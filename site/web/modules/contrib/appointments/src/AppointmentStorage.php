<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\appointments\Entity\AppointmentInterface;

/**
 * Defines the storage handler class for Appointment entities.
 *
 * This extends the base storage class, adding required special handling for
 * Appointment entities.
 *
 * @ingroup appointments
 */
class AppointmentStorage extends SqlContentEntityStorage implements AppointmentStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(AppointmentInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {appointment_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {appointment_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(AppointmentInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {appointment_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('appointment_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
