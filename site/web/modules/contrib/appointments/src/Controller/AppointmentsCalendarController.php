<?php

namespace Drupal\appointments\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\appointments\RoomConfigurationsManager;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\appointments\CalendarManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Class AppointmentsCalendarController.
 */
class AppointmentsCalendarController extends ControllerBase {

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
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $accountProxy;

  /**
   * AppointmentsManagementController constructor.
   *
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\appointments\RoomConfigurationsManager $room_configuration_manager
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\appointments\CalendarManagerInterface $calendar_manager
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   * @param \Drupal\Core\Session\AccountProxyInterface $account_proxy
   */
  public function __construct(LoggerChannelInterface $logger, EntityTypeManagerInterface $entity_type_manager, RoomConfigurationsManager $room_configuration_manager, ConfigFactoryInterface $config_factory, CalendarManagerInterface $calendar_manager, RequestStack $request_stack, RendererInterface $renderer, AccountProxyInterface $account_proxy) {
    $this->logger = $logger;
    $this->entityTypeManager = $entity_type_manager;
    $this->roomConfigurationsManager = $room_configuration_manager;
    $this->configFactory = $config_factory;
    $this->calendarManager = $calendar_manager;
    $this->requestStack = $request_stack;
    $this->request = $this->requestStack->getCurrentRequest();
    $this->renderer = $renderer;
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
      $container->get('request_stack'),
      $container->get('renderer'),
      $container->get('current_user')
    );
  }

  /**
   * Returns appointments to frontend.
   *
   * @param $node
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   * @throws \Exception
   */
  public function getAppointments($node) {
    $start = $this->request->get('start');
    $end = $this->request->get('end');
    $configuration = $this->roomConfigurationsManager->getConfiguration($node);

    // check empties
    if (empty($start) || empty($end)) {
      $this->logger->warning("");
      return new JsonResponse([]);
    }

    try {
      $s1 = new \DateTime($start);
      $s1->setTime(0, 0);
      $s2 = new \DateTime($end);
      $s2->setTime(23, 59);
    }
    catch (\Exception $e) {
      $this->logger->error("Error in creating DateTime objects in getAppointments method on AppointmentsCalendarController, check start & end values: %start, %end", ['%start' => $start, '%end' => $end]);
      return new JsonResponse([]);
    }

    $days = $this->calendarManager->getDays($node, $s1, $s2);
    $events = [];

    $open = $configuration->getOpen();
    $close = $configuration->getOfficeClose();

    foreach ($days as $day) {
      if ($day['status'] === 1) {
        $free = $this->dayCountFreeSlots($node, $day['start']->format('Y-m-d'));
        $booked = $this->dayCountBookedSlots($node, $day['start']->format('Y-m-d'));
        $events[] = [
          'start' => $day['start']->format('Y-m-d'),
          'end' => $day['end']->format('Y-m-d'),
          'overlap' => FALSE,
          'status' => $day['status'],
          'title' => $this->t("", []),
          'office' => ['open' => $open, 'close' => $close],
          'slots' => ['free' => $free, 'booked' => $booked],
        ];
      }
    }

    return new JsonResponse($events);
  }

  /**
   * Get appointments hours for a specific day for an office.
   *
   * @param $node
   * @param $date
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function getAppointmentHours($node, $date) {
    $s1 = new \DateTime($date);

    $hours = $this->calendarManager->getHours($node, $s1);

    $events = [];
    foreach ($hours as $hour) {
      $events[] = [
        'start' => $hour['start']->format('H:i'),
        'end' => $hour['end']->format('H:i'),
        'end_real' => $hour['end_real']->format('H:i'),
        'status' => $hour['status'],
      ];
    }

    try {
      $element = [
        '#theme' => 'appointments_frontend_hours',
        '#hours' => $events,
        '#day' => $s1,
      ];
      $html = $this->renderer->render($element);
    }
    catch (\Exception $e) {
      $this->logger->error($e->getMessage());
      return new Response();
    }

    return new Response($html);
  }

  /**
   * Get the appointment form.
   *
   * @param $node
   * @param $date
   *
   * @return Response
   */
  public function getAppointmentForm($node, $date) {

    $start = $this->request->get('start');
    $end = $this->request->get('end');
    $end_real = $this->request->get('end_real');

    $this->logger->debug('AppointmentsCalendarController::getAppointmentForm (@nid, @date, @start, @end, @end_real)', [
      '@nid' => $node,
      '@date' => $date,
      '@start' => $start,
      '@end' => $end,
      '@end_real' => $end_real,
    ]);

    $s1 = new \DateTime($date);

    // check empties
    if (empty($start) || empty($end) ||  empty($end_real)) {
      $this->logger->warning("AppointmentsCalendarController::getAppointmentForm parameters start, end, end_real are empty");
      return new Response("Empty start, end and end_real parameters");
    }

    try {
      $defaults = [
        'start' => $this->getDateTimeObject($s1, $start)->format('U'),
        'appointment_node' => $node,
      ];

      $appointment = $this->entityTypeManager->getStorage('appointment')->create($defaults);
      $form_appointment = $this->entityTypeManager->getFormObject('appointment', 'default')->setEntity($appointment);
      $form_appointment->setOperation('add');

      $form = $this->formBuilder()->getForm($form_appointment);

      $form['#action'] = \Drupal\Core\Url::fromRoute("entity.appointment.add_form")->toString();

      // Disable Date Time change.
      $form['start']['widget'][0]['value']['date']['#attributes']['readonly'] = TRUE;
      $form['start']['widget'][0]['value']['time']['#attributes']['readonly'] = TRUE;
      unset($form['when']['widget'][0]['value']['#description']);

      // hide revision log message.
      $form['revision_log_message']['#access'] = FALSE;
      $form['applicant']['widget'][0]['inline_entity_form']['revision_log_message']['#access'] = FALSE;

      $form['appointment_node'] = [
        '#type' => 'hidden',
        '#value' => $node,
        '#name' => 'appointment_node',
      ];

      $form['appointment_redirect'] = [
        '#type' => 'hidden',
        '#value' => 1,
        '#name' => 'appointment_redirect',
      ];

      $form['appointment_redirect_uri'] = [
        '#type' => 'hidden',
        '#value' => "entity:node/" . $node,
        '#name' => 'appointment_redirect_uri',
      ];

      // Hide moderation state always.
      $form['moderation_state']['#attributes']['style'] = 'display:none;';

      $form['#attached']['library'][] = 'core/jquery.form';
      $form['#attached']['library'][] = 'core/drupal.ajax';

      $build = [
        '#theme' => 'appointments_frontend_form',
        '#form' => $form,
        '#day' => $s1,
        '#start' => $this->getDateTimeObject($s1, $start),
        '#end' => $this->getDateTimeObject($s1, $end),
        '#end_real' => $this->getDateTimeObject($s1, $end_real),
        '#front_office' => NULL,
        '#address' => NULL,
      ];

      $html = $this->renderer->renderRoot($build);
    }
    catch (\Exception $e) {
      $this->logger->error($e->getMessage());
      $html = Markup::create("");
    }

    return new Response($html);
  }

  /**
   * @param \DateTime $day
   *   Date.
   * @param string $hour
   *   Hour in the format: HH:mm
   *
   * @return \DateTime
   */
  private function getDateTimeObject(\DateTime $day, $hour) {
    try {
      $date = clone $day;
      $fragments = explode(':', $hour);
      $date->setTime($fragments[0], $fragments[1]);
    }
    catch (\Exception $e) {
      $this->logger->error($e->getMessage());
    }

    return $date;
  }

  /**
   * Use calendarManager to get available slots for a specific day.
   * @param $node
   * @param $date
   *
   * @return int
   */
  private function dayCountFreeSlots($node, $date) {
    $s1 = new \DateTime($date);
    $hours = $this->calendarManager->getHours($node, $s1);
    $count = 0;
    foreach ($hours as $hour) {
      $count += $hour['count'];
    }

    return $count;
  }

  /**
   * Use calendarManager to get NON available slots for a specific day.
   *
   * @param $node
   * @param $date
   *
   * @return int
   */
  private function dayCountBookedSlots($node, $date) {
    $s1 = new \DateTime($date);
    $hours = $this->calendarManager->getNonAvailableSlotInHours($node, $s1);
    $count = 0;
    foreach ($hours as $hour) {
      $count += $hour['count'];
    }

    return $count;
  }

}
