<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface AppointmentStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Appointment revision IDs for a specific Appointment.
   *
   * @param \Drupal\appointments\Entity\AppointmentInterface $entity
   *   The Appointment entity.
   *
   * @return int[]
   *   Appointment revision IDs (in ascending order).
   */
  public function revisionIds(AppointmentInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Appointment author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Appointment revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\appointments\Entity\AppointmentInterface $entity
   *   The Appointment entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(AppointmentInterface $entity);

  /**
   * Unsets the language for all Appointment with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
