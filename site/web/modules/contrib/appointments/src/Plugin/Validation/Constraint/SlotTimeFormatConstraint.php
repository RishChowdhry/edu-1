<?php

namespace Drupal\appointments\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Verify that the order number is valid.
 *
 * @Constraint(
 *   id = "SlotTimeFormat",
 *   label = @Translation("Check Slot time Format", context = "Validation"),
 *   type = "string"
 * )
 */
class SlotTimeFormatConstraint extends Constraint {

  /**
   * @var string
   */
  public $slotTimeFormatMessage = '%value is not a correct slot time format, it must be HH:mm.';

}
