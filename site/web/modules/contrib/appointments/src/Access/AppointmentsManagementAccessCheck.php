<?php

namespace Drupal\appointments\Access;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Access\AccessResultAllowed;
use Drupal\Core\Access\AccessResultForbidden;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelInterface;

/**
* Checks access for displaying appointments.
*/
class AppointmentsManagementAccessCheck implements AccessInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  /**
   * ConfigFactory object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\Core\Logger\LoggerChannelInterface definition.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $loggerChannelAppointments;

  /**
   * AppointmentsManagementAccessCheck constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager object.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory object.
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger_channel_appointments
   *   The logger channel object with appointments key.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, ConfigFactoryInterface $config_factory, LoggerChannelInterface $logger_channel_appointments) {
    $this->entityTypeManager = $entity_type_manager;
    $this->configFactory = $config_factory;
    $this->loggerChannelAppointments = $logger_channel_appointments;
  }

  /**
   * A custom access check.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   * @param string $node
   *   The node ID in current request object.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account, $node) {

    try {
      $entity = $this->entityTypeManager->getStorage('node')->load($node);
      if (empty($entity)) {
        return new AccessResultForbidden();
      }

      $bundle = $entity->bundle();
      $appointments_content_type = $this->configFactory->get('appointments.settings')->get('content_type');

      // If current node's bundle is that selected in config.
      if ($bundle == $appointments_content_type) {
        return new AccessResultAllowed();
      }
    }
    catch (\Exception $e) {
      $this->loggerChannelAppointments->error($e->getMessage());
      return new AccessResultForbidden();
    }

    return new AccessResultForbidden();
  }

}
