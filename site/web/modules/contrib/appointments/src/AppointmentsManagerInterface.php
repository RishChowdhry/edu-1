<?php

namespace Drupal\appointments;

use Drupal\appointments\Entity\Appointment;

/**
 * Interface AppointmentsManagerInterface.
 *
 * @package Drupal\appointments
 */
Interface AppointmentsManagerInterface {

  /**
   * Save an appointment.
   *
   * @param \Drupal\appointments\Entity\Appointment $appointment
   *
   * @throws \Exception
   */
  public function save($appointment);

  /**
   * Description.
   *
   * @param \Drupal\appointments\Entity\Appointment $appointment
   *
   * @return array
   *
   * @throws \Exception
   */
  public function add(Appointment $appointment);

  /**
   * @param \Drupal\appointments\Entity\Appointment $appointment
   *
   * @throws \Exception
   */
  public function confirm(Appointment $appointment);

  /**
   * @param \Drupal\appointments\Entity\Appointment $appointment
   *
   * @throws \Exception
   */
  public function reject(Appointment $appointment);

  /**
   * @param \Drupal\appointments\Entity\Appointment $appointment
   * @param bool $hard
   *
   * @throws \Exception
   */
  public function delete(Appointment $appointment, $hard = FALSE);

}
