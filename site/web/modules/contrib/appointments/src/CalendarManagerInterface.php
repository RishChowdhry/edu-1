<?php

namespace Drupal\appointments;

/**
 * Interface CalendarManagerInterface.
 */
interface CalendarManagerInterface {

  /**
   * Get Availability for a node in a specific time interval.
   *
   * @param $nid
   * @param \DateTime $start_date
   *
   * @param \DateTime $end_date
   *
   * @return array
   */
  public function getAvailability($nid, \DateTime $start_date, \DateTime $end_date);

  /**
   * Add Availability for a node.
   *
   * @param $nid
   * @param \DateTime $day
   * @param $repeat
   * @param array $hours
   */
  public function addAvailability($nid, \DateTime $day, $repeat, $hours = []);

  /**
   * Remove Availability for a node.
   *
   * @param $nid
   *
   * @return mixed
   */
  public function clearAvailability($nid);

  /**
   * Check if a node has at least one Availability.
   *
   * @param $nid
   *
   * @return mixed
   */
  public function hasAvailability($nid);

  /**
   * Add an event for a given time period.
   *
   * For more info about what an event is: https://github.com/Roomify/bat
   *
   * @param $nid
   * @param $start_date
   * @param $end_date
   * @param $reservation_id
   * @param $state
   * @param null $unit_id
   *
   * @return \Roomify\Bat\Unit\Unit
   * @throws \Drupal\appointments\Exceptions\NoUnitAvailableException
   */
  public function addEvent($nid, $start_date, $end_date, $reservation_id, $state, $unit_id = NULL);

  /**
   * Get the list of hours on which there are slots available for a specific node.
   *
   * @param $nid
   *
   * @return mixed
   */
  public function listDayHours($nid);

  /**
   * @param $nid
   * @param \DateTime $start_date
   * @param \DateTime $end_date
   *
   * @return mixed
   */
  public function getDays($nid, \DateTime $start_date, \DateTime $end_date);

  /**
   * Get Availability hours with available slots.
   *
   * @param $nid
   * @param \DateTime $day
   *
   * @return mixed
   */
  public function getHours($nid, \DateTime $day);

  /**
   * Get Availability hours with NON available slots.
   *
   * @param $nid
   * @param \DateTime $day
   *
   * @return mixed
   */
  public function getNonAvailableSlotInHours($nid, \DateTime $day);

}
