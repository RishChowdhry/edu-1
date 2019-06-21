<?php

namespace Drupal\appointments;

use Drupal\appointments\Entity\Appointment;

/**
 * Interface AppointmentsTransactionManagerInterface.
 *
 * @package Drupal\appointments
 */
Interface AppointmentsTransactionManagerInterface {

  /**
   * Check if a user can perform a transaction toward publish state.
   *
   * @param Appointment $appointment
   *
   * @return bool
   */
  public function canTransitionToConfirm(Appointment $appointment);

  /**
   * Check if a user can perform a transaction toward delete state.
   *
   * @param Appointment $appointment
   *
   * @return bool
   */
  public function canTransitionToDelete(Appointment $appointment);

  /**
   * Check if a user can perform a transaction toward reject state.
   *
   * @param Appointment $appointment
   *
   * @return bool
   */
  public function canTransitionToReject(Appointment $appointment);

}
