<?php

namespace Drupal\appointments\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Appointment entities.
 *
 * @ingroup appointments
 */
interface AppointmentInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Appointment name.
   *
   * @return string
   *   Name of the Appointment.
   */
  public function getName();

  /**
   * Sets the Appointment name.
   *
   * @param string $name
   *   The Appointment name.
   *
   * @return \Drupal\appointments\Entity\AppointmentInterface
   *   The called Appointment entity.
   */
  public function setName($name);

  /**
   * Get a DateTime Object from start field value (timestamp).
   *
   * @return \DateTime
   */
  public function getDateTimeStart();

  /**
   * Get a DateTime Object from end field value (timestamp).
   *
   * @return \DateTime
   */
  public function getDateTimeEnd();

  /**
   * Get a DateTime Object from end field value (timestamp) subtracted of 1 minute.
   *
   * @return \DateTime
   */
  public function getDateTimeEndReal();

  /**
   * Get appointment Node id.
   *
   * @return int
   */
  public function getAppointmentNode();

  /**
   * Get appointment slot value.
   *
   * @return int
   */
  public function getSlot();

  /**
   * @return mixed
   */
  public function getApplicantEMail();

  /**
   * Gets the Appointment creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Appointment.
   */
  public function getCreatedTime();

  /**
   * Sets the Appointment creation timestamp.
   *
   * @param int $timestamp
   *   The Appointment creation timestamp.
   *
   * @return \Drupal\appointments\Entity\AppointmentInterface
   *   The called Appointment entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Appointment published status indicator.
   *
   * Unpublished Appointment are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Appointment is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Appointment.
   *
   * @param bool $published
   *   TRUE to set this Appointment to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\appointments\Entity\AppointmentInterface
   *   The called Appointment entity.
   */
  public function setPublished($published);

  /**
   * Gets the Appointment revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Appointment revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\appointments\Entity\AppointmentInterface
   *   The called Appointment entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Appointment revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Appointment revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\appointments\Entity\AppointmentInterface
   *   The called Appointment entity.
   */
  public function setRevisionUserId($uid);

}
