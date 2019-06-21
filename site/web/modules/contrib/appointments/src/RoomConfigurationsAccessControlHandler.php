<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Room configurations entity.
 *
 * @see \Drupal\appointments\Entity\RoomConfigurations.
 */
class RoomConfigurationsAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\appointments\Entity\RoomConfigurationsInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished room configurations entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published room configurations entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit room configurations entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete room configurations entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add room configurations entities');
  }

}
