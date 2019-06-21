<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\appointments\Entity\ApplicantInterface;

/**
 * Defines the storage handler class for Applicant entities.
 *
 * This extends the base storage class, adding required special handling for
 * Applicant entities.
 *
 * @ingroup appointments
 */
class ApplicantStorage extends SqlContentEntityStorage implements ApplicantStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ApplicantInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {applicant_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {applicant_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ApplicantInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {applicant_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('applicant_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
