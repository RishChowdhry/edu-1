<?php

namespace Drupal\appointments;

use Drupal\appointments\Entity\Appointment;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Roomify\Bat\Unit\Unit;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class AppointmentsManager.
 *
 * @package Drupal\appointments
 */
class AppointmentsManager implements AppointmentsManagerInterface {

  /**
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * @var \Drupal\appointments\RoomConfigurationsManagerInterface
   */
  protected $roomConfigurationManager;

  /**
   * @var \Drupal\appointments\CalendarManagerInterface
   */
  protected $calendarManager;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var EmailManagerInterface
   */
  protected $emailManager;

  /**
   * CalendarManager constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger
   * @param \Drupal\appointments\RoomConfigurationsManagerInterface $room_configuration_manager
   * @param \Drupal\appointments\CalendarManagerInterface $calendar_manager
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\appointments\EmailManagerInterface $email_manager
   */
  public function __construct(ConfigFactoryInterface $config_factory, LoggerChannelInterface $logger, RoomConfigurationsManagerInterface $room_configuration_manager, CalendarManagerInterface $calendar_manager, EntityTypeManagerInterface $entity_type_manager, EmailManagerInterface $email_manager) {
    $this->configFactory = $config_factory;
    $this->logger = $logger;
    $this->roomConfigurationManager = $room_configuration_manager;
    $this->calendarManager = $calendar_manager;
    $this->entityTypeManager = $entity_type_manager;
    $this->emailManager =$email_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function save($appointment) {

    $transaction = \Drupal::database()->startTransaction();
    try {
      $storage = $this->entityTypeManager->getStorage('appointment');
      $return = $storage->save($appointment);

      // Only when Appointments is created, update roomify/bat info.
      if ($return == SAVED_NEW) {
        if ($this->add($appointment)) {
          $storage->save($appointment);
        }
      }
    }
    catch (\Exception $e) {
      $transaction->rollBack();
      throw new \Exception($e->getMessage());
    }

    return $return;
  }

  /**
   * {@inheritdoc}
   */
  public function add(Appointment $appointment) {

    // If Appointment entity is not linked to a node.
    $nid = $appointment->getAppointmentNode();
    if (empty($nid)) {
      return FALSE;
    }

    /** @var \Drupal\appointments\Entity\RoomConfigurationsInterface $config */
    $config = $this->roomConfigurationManager->getConfiguration($nid);

    $startTime = $appointment->getDateTimeStart();
    $endTime = $appointment->getDateTimeEndReal();

    try {

      // Appointment workflows.
      if ($config->getAutoConfirmation()) {
        $event_status = CalendarManager::BOOKED;
        $appointment->set('moderation_state', Appointment::CONFIRMED);
      } else {
        $event_status = CalendarManager::PENDING;
      }

      /** @var \Roomify\Bat\Unit\Unit $unit */
      $unit = $this->calendarManager->addEvent($nid, $startTime, $endTime, $appointment->id(), $event_status);

      // Set slot value.
      $appointment->get('slot')->setValue($unit->getUnitId());

      if ($config->getAutoConfirmation()) {
        $this->emailManager->newAppointment($appointment, TRUE, TRUE);
      }
      else {
        $this->emailManager->newAppointment($appointment);
      }

    } catch (\Exception $e) {
      $this->logger->error($e->getMessage());
      throw new \Exception();
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function delete(Appointment $appointment, $hard = FALSE) {
    $transaction = \Drupal::database()->startTransaction();
    try {
      $storage = $this->entityTypeManager->getStorage('appointment');

      if ($hard) {
        $storage->delete([$appointment->id() => $appointment]);
      }
      else {
        $appointment->set('moderation_state', Appointment::DELETED);
        $storage->save($appointment);
      }

      $start = $appointment->getDateTimeStart();
      $end = $appointment->getDateTimeEnd();
      $nid = $appointment->getAppointmentNode();
      $slot = $appointment->getSlot();

      $this->calendarManager->addEvent($nid, $start, $end, 0, CalendarManager::AVAILABLE, $slot);
    } catch (\Exception $e) {
      $transaction->rollBack();
      throw new \Exception($e->getMessage());
    }
  }

  /**
   * @param \Drupal\appointments\Entity\Appointment $appointment
   *
   * @throws \Exception
   */
  public function confirm(Appointment $appointment) {
    $transaction = \Drupal::database()->startTransaction();
    try {
      $appointment->set('moderation_state', Appointment::CONFIRMED);
      $this->save($appointment);

      $start = $appointment->getDateTimeStart();
      $end = $appointment->getDateTimeEnd();
      $nid = $appointment->getAppointmentNode();
      $slot = $appointment->getSlot();
      $this->calendarManager->addEvent($nid, $start, $end, $appointment->id(), CalendarManager::BOOKED, $slot);

      $this->emailManager->confirmAppointment($appointment);
    } catch (\Exception $e) {
      $transaction->rollBack();
      throw new \Exception();
    }
  }

  /**
   * @param \Drupal\appointments\Entity\Appointment $appointment
   *
   * @throws \Exception
   */
  public function reject(Appointment $appointment) {
    $transaction = \Drupal::database()->startTransaction();
    try {
      $appointment->set('moderation_state', Appointment::REJECTED);
      $this->save($appointment);

      $start = $appointment->getDateTimeStart();
      $end = $appointment->getDateTimeEnd();
      $nid = $appointment->getAppointmentNode();
      $slot = $appointment->getSlot();
      $this->calendarManager->addEvent($nid, $start, $end, 0, CalendarManager::AVAILABLE, $slot);

      $this->emailManager->rejectAppointment($appointment);
    } catch (\Exception $e) {
      $transaction->rollBack();
      throw new \Exception();
    }
  }

}
