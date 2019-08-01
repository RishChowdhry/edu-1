<?php

namespace Drupal\appointment_edu\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'appointment_eduBlock' block.
 *
 * @Block(
 *  id = "appointment_edu_block",
 *  admin_label = @Translation("appointment_edu block"),
 * )
 */
class Appointment_eduBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    ////$build = [];
    //$build['appointment_edu_block']['#markup'] = 'Implement appointment_eduBlock.';

    $form = \Drupal::formBuilder()->getForm('Drupal\appointment_edu\Form\appointment_eduForm');

    return $form;
  }

}
