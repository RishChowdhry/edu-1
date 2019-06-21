<?php

namespace Drupal\appointments\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\appointments\RoomConfigurationsManager;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\appointments\CalendarManagerInterface;
use Drupal\views\ViewExecutableFactory;

/**
 * Class AppointmentsManagementController.
 */
class AppointmentsManagementController extends ControllerBase {

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
   * @var \Drupal\views\ViewExecutableFactory
   */
  protected $viewExecutableFactory;

  /**
   * AppointmentsManagementController constructor.
   *
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\appointments\RoomConfigurationsManager $room_configuration_manager
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\appointments\CalendarManagerInterface $calendar_manager
   * @param \Drupal\views\ViewExecutableFactory $view_executable_factory
   */
  public function __construct(LoggerChannelInterface $logger, EntityTypeManagerInterface $entity_type_manager, RoomConfigurationsManager $room_configuration_manager, ConfigFactoryInterface $config_factory, CalendarManagerInterface $calendar_manager, ViewExecutableFactory $view_executable_factory) {
    $this->logger = $logger;
    $this->entityTypeManager = $entity_type_manager;
    $this->roomConfigurationsManager = $room_configuration_manager;
    $this->configFactory = $config_factory;
    $this->calendarManager = $calendar_manager;
    $this->viewExecutableFactory = $view_executable_factory;
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
      $container->get('views.executable')
    );
  }

  /**
   * Current node's appointments page.
   *
   * @return array
   *   Return Hello string.
   */
  public function appointmentListContent($node) {
    try {
      $view_entity = $this->entityTypeManager->getStorage('view')->load('appointments');
      /** @var \Drupal\views\ViewExecutable $view */
      $view = $this->viewExecutableFactory->get($view_entity);

      // Execute view & render it.
      $view->build('default');
      $view->execute('default');
      $build =  $view->render('default');
    }
    catch (\Exception $e) {
      $this->logger->warning("AppointmentsManagementController::appointmentListContent throw an exception, page node: @node, exception message: @msg", ['@node' => $node, '@msg' => $e->getMessage()]);
      $mail = $this->configFactory->get('system.site')->get('mail');
      $build = [
        '#type' => 'markup',
        '#markup' => $this->t('There be occurred a problem on rendering the page, if the problem persists contact site administrator <a href="mailto:@mail">@mail</a>', ['@mail' => $mail]),
      ];
    }

    return $build;
  }

  /**
   * Current node's appointments availability page.
   *
   * @param string $node
   *   Current node's id.
   *
   * @return array
   *   Renderer array
   *
   * @throws \Exception
   */
  public function appointmentAvailabilityContent($node) {
    /** @var \Drupal\node\Entity\Node $entity */
    $entity = $this->entityTypeManager->getStorage('node')->load($node);
    return [
      '#theme' => 'appointments_backend_calendar',
      '#node' => $entity,
      // the field have to be configurable.
      '#note' => $entity->get('body')->view(['label' => 'hidden']),
      '#hours' => $this->calendarManager->listDayHours($node),
      '#repeat_interval' => NULL,
      '#repeat_checkbox_label' => NULL,
      '#attached' => [
        'drupalSettings' => [
          'appointments' => [
            'nid' => $node,
            'lang' => $this->languageManager()->getCurrentLanguage()->getId(),
            'first_day_week' => $this->configFactory->get('appointments.settings')->get('first_day_week', 0),
          ],
        ],
      ],
    ];
  }

  /**
   * Current node's appointments configuration page.
   *
   * @return array
   *   Room configurations form render array.
   *
   * @throws \Exception
   */
  public function appointmentConfigureContent($node) {

    // Gets current node appointment configuration.
    $entity = $this->roomConfigurationsManager->getConfiguration($node);

    // Gets its form.
    $form_object = $this->entityTypeManager->getFormObject('room_configurations', 'default')->setEntity($entity);
    $form = $this->formBuilder()->getForm($form_object);

    // If there is at least one availability, slots doesn't can be changed.
    if ($this->calendarManager->hasAvailability($node)) {
      $form['slots']['widget'][0]['value']['#attributes']['readonly'] = TRUE;
    }

    $form['slots']['#weight'] = -9;
    $form['open']['#weight'] = -8;
    $form['close']['#weight'] = -7;
    $form['auto_confirmation']['#weight'] = -6;

    // Add the token tree UI.
    $form['token_tree'] = array(
      '#theme' => 'token_tree_link',
      '#token_types' => array('appointment'),
      '#show_restricted' => TRUE,
      '#weight' => -5,
    );

    return $form;
  }

}
