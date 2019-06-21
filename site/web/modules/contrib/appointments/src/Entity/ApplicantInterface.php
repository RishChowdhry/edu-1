<?php

namespace Drupal\appointments\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Applicant entities.
 *
 * @ingroup appointments
 */
interface ApplicantInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Applicant Fullname.
   *
   * @return string
   *   Name of the Applicant.
   */
  public function getFullName();

  /**
   * Sets the Applicant name.
   *
   * @param string $name
   *   The Applicant name.
   *
   * @return \Drupal\appointments\Entity\ApplicantInterface
   *   The called Applicant entity.
   */
  public function setFullName($name);

  /**
   * Gets the Applicant Name.
   *
   * @return string
   *   First name of the Applicant.
   */
  public function getName();

  /**
   * Gets the Applicant Surname.
   *
   * @return string
   *   Surname of the Applicant.
   */
  public function getSurname();

  /**
   * Gets the Applicant Email.
   *
   * @return string
   *   Email of the Applicant.
   */
  public function getEMail();

  /**
   * Gets the Applicant creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Applicant.
   */
  public function getCreatedTime();

  /**
   * Sets the Applicant creation timestamp.
   *
   * @param int $timestamp
   *   The Applicant creation timestamp.
   *
   * @return \Drupal\appointments\Entity\ApplicantInterface
   *   The called Applicant entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Applicant published status indicator.
   *
   * Unpublished Applicant are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Applicant is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Applicant.
   *
   * @param bool $published
   *   TRUE to set this Applicant to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\appointments\Entity\ApplicantInterface
   *   The called Applicant entity.
   */
  public function setPublished($published);

  /**
   * Gets the Applicant revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Applicant revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\appointments\Entity\ApplicantInterface
   *   The called Applicant entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Applicant revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Applicant revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\appointments\Entity\ApplicantInterface
   *   The called Applicant entity.
   */
  public function setRevisionUserId($uid);

}
