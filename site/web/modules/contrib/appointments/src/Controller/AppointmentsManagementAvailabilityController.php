<?php

namespace Drupal\appointments\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\appointments\RoomConfigurationsManager;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\appointments\CalendarManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AppointmentsManagementAvailabilityController.
 */
class AppointmentsManagementAvailabilityController extends ControllerBase {

  /**
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\appointments\RoomConfigurationsManager
   */
  protected $roomConfigurationsManager;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * @var \Drupal\appointments\CalendarManagerInterface
   */
  protected $calendarManager;

  /**
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * AppointmentsManagementController constructor.
   *
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\appointments\RoomConfigurationsManager $room_configuration_manager
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\appointments\CalendarManagerInterface $calendar_manager
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   */
  public function __construct(LoggerChannelInterface $logger, EntityTypeManagerInterface $entity_type_manager, RoomConfigurationsManager $room_configuration_manager, ConfigFactoryInterface $config_factory, CalendarManagerInterface $calendar_manager, RequestStack $request_stack) {
    $this->logger = $logger;
    $this->entityTypeManager = $entity_type_manager;
    $this->roomConfigurationsManager = $room_configuration_manager;
    $this->configFactory = $config_factory;
    $this->calendarManager = $calendar_manager;
    $this->requestStack = $request_stack;
    $this->request = $this->requestStack->getCurrentRequest();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.channel.appointments'),
      $container->get('entity_type.manager'),
      $container->get('appointments.room_configuration_manager'),
      $container->get('config.factory'),
      $container->get('appointments.calendar_manager'),
      $container->get('request_stack')
    );
  }

  /**
   * Get availability for a appointments node (frontend api).
   *
   * @param $node
   *
   * @return JsonResponse
   *   Availability for this node.
   */
  public function getAvailability($node) {

    $start = $this->request->get('start');
    $end = $this->request->get('end');

    // check empties
    if (empty($start) || empty($end)) {
      $this->logger->warning("");
    }

    try {
      $s1 = new \DateTime($start);
      $s1->setTime(0, 0);
      $s2 = new \DateTime($end);
      $s2->setTime(23, 59);
    }
    catch (\Exception $e) {
      $this->logger->error("Error in creating DateTime objects in getAvailability method on AppointmentsManagementAvailabilityController, check start & end values: %start, %end", ['%start' => $start, '%end' => $end]);
      return new JsonResponse([]);
    }

    $days = $this->calendarManager->getAvailability($node, $s1, $s2);
    $events = [];

    foreach ($days as $day) {
      $events[] = [
        'start' => $day['start']->format('Y-m-d H:i'),
        'end' => $day['end']->format('Y-m-d H:i'),
        'title' => t('(slots: @slots)', ['@slots' => $day['slot']]),
      ];
    }

    return new JsonResponse($events);
  }

  /**
   * Add a new Availability for a node.
   *
   * @param $node
   * @param $date
   *
   * @return JsonResponse
   *   Availability for this node.
   */
  public function addAvailability($node, $date) {

    $repeat = $this->request->get('repeat');
    $hours = $this->request->get('hours');

    try {
      $this->calendarManager->addAvailability($node, new \DateTime($date), $repeat, $hours);
    }
    catch (\Exception $e) {
      $this->logger->error("The Calendar manager is not able to add availability because this exception: %msg", ['%msg' => $e->getMessage()]);
      return new JsonResponse(['status' => 'error', 'msg' => 'The Calendar manager is not able to add availability']);
    }

    return new JsonResponse(['status' => 'ok', 'msg' => '']);
  }
}
