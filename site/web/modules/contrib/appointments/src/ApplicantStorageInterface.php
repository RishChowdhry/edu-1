<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface ApplicantStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Applicant revision IDs for a specific Applicant.
   *
   * @param \Drupal\appointments\Entity\ApplicantInterface $entity
   *   The Applicant entity.
   *
   * @return int[]
   *   Applicant revision IDs (in ascending order).
   */
  public function revisionIds(ApplicantInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Applicant author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Applicant revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\appointments\Entity\ApplicantInterface $entity
   *   The Applicant entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ApplicantInterface $entity);

  /**
   * Unsets the language for all Applicant with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
