<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class AppointmentsFormAlter.
 *
 * @package Drupal\appointments
 */
class AppointmentsFormAlter implements AppointmentsFormAlterInterface {

  /**
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * CalendarManager constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger
   */
  public function __construct(ConfigFactoryInterface $config_factory, LoggerChannelInterface $logger) {
    $this->configFactory = $config_factory;
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public function appointmentsNodeView(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {
    $bundle = $entity->bundle();
    $config = $this->configFactory->get('appointments.settings');
    $current_bundle = $config->get('content_type', '');
    $first_day_week = $config->get('first_day_week', '');

    if ($bundle == $current_bundle && $view_mode == 'full') {
      $build['appointments'] = [
        '#theme' => 'appointments_frontend_calendar',
        '#node' => $entity,
        '#attached' => [
          'drupalSettings' => [
            'appointments' => [
              'nid' => $entity->id(),
              'lang' => 'en',
              'first_day_week' => $first_day_week,
            ],
          ],
        ],
        '#weight' => 1000,
      ];
    }
  }

}
