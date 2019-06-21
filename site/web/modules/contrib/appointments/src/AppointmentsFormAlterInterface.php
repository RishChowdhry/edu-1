<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;

/**
 * Interface AppointmentsFormAlterInterface.
 *
 * @package Drupal\appointments
 */
Interface AppointmentsFormAlterInterface {

  /**
   * @param array $build
   * @param \Drupal\Core\Entity\EntityInterface $entity
   * @param \Drupal\Core\Entity\Display\EntityViewDisplayInterface $display
   * @param $view_mode
   *
   * @return mixed
   */
  public function appointmentsNodeView(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode);
}