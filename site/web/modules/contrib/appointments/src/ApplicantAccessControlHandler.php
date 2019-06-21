<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Applicant entity.
 *
 * @see \Drupal\appointments\Entity\Applicant.
 */
class ApplicantAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\appointments\Entity\ApplicantInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished applicant entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published applicant entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit applicant entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete applicant entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add applicant entities');
  }

}
