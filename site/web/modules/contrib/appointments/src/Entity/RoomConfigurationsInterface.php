<?php

namespace Drupal\appointments\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Room configurations entities.
 *
 * @ingroup appointments
 */
interface RoomConfigurationsInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Room configurations name.
   *
   * @return string
   *   Name of the Room configurations.
   */
  public function getName();

  /**
   * Sets the Room configurations name.
   *
   * @param string $name
   *   The Room configurations name.
   *
   * @return \Drupal\appointments\Entity\RoomConfigurationsInterface
   *   The called Room configurations entity.
   */
  public function setName($name);

  /**
   * Gets the Room configurations creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Room configurations.
   */
  public function getCreatedTime();

  /**
   * Sets the Room configurations creation timestamp.
   *
   * @param int $timestamp
   *   The Room configurations creation timestamp.
   *
   * @return \Drupal\appointments\Entity\RoomConfigurationsInterface
   *   The called Room configurations entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Room configurations published status indicator.
   *
   * Unpublished Room configurations are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Room configurations is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Room configurations.
   *
   * @param bool $published
   *   TRUE to set this Room configurations to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\appointments\Entity\RoomConfigurationsInterface
   *   The called Room configurations entity.
   */
  public function setPublished($published);

  /**
   * @return mixed
   */
  public function getAvailable();

  /**
   * Get slots configuration value.
   *
   * @return string
   */
  public function getSlots();

  /**
   * Get open configuration value.
   *
   * @return string
   */
  public function getOpen();

  /**
   * Get timestamp for open.
   *
   * @return string
   */
  public function getFullOpen();

  /**
   * Get close configuration value.
   *
   * @return string
   */
  public function getClose();

  /**
   * Get timestamp for close.
   *
   * @return string
   */
  public function getFullClose();

  /**
   * Get close time for office.
   *
   * @return string
   */
  public function getOfficeClose();

  /**
   * @return mixed
   */
  public function getPendingEmailSubject();

  /**
   * @return mixed
   */
  public function getPendingEmailBody();

  /**
   * @return mixed
   */
  public function getConfirmedEmailSubject();

  /**
   * @return mixed
   */
  public function getConfirmedEmailBody();

  /**
   * @return mixed
   */
  public function getRejectedEmailSubject();

  /**
   * @return mixed
   */
  public function getRejectedEmailBody();

  /**
   * @return mixed
   */
  public function getRoomManagerEmail();

  /**
   * @return mixed
   */
  public function getAutoConfirmation();

  /**
   * @return mixed
   */
  public function getTotalSlots();

}
