<?php

namespace Drupal\appointments;

use Drupal\appointments\Entity\Appointment;

/**
 * Interface EmailManagerInterface.
 *
 * @package Drupal\appointments
 */
Interface EmailManagerInterface {

  /**
   * @param \Drupal\appointments\Entity\Appointment $appointment
   * @param bool $exclude_client
   * @param bool $show_acceptance_url
   *
   * @return mixed
   */
  public function newAppointment(Appointment $appointment, $exclude_client = FALSE, $show_acceptance_url = TRUE);

  /**
   * @param \Drupal\appointments\Entity\Appointment $appointment
   *
   * @return mixed
   */
  public function confirmAppointment(Appointment $appointment);

  /**
   * @param \Drupal\appointments\Entity\Appointment $appointment
   *
   * @return mixed
   */
  public function rejectAppointment(Appointment $appointment);

}