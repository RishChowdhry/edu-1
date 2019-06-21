<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Appointment entity.
 *
 * @see \Drupal\appointments\Entity\Appointment.
 */
class AppointmentAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\appointments\Entity\AppointmentInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished appointment entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published appointment entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit appointment entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete appointment entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add appointment entities');
  }

}
