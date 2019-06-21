<?php

namespace Drupal\appointments\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Slot field.
 */
class SlotTimeFormatConstraintValidator extends ConstraintValidator {

  /**
   * Validator 2.5 and upwards compatible execution context.
   *
   * @var \Symfony\Component\Validator\Context\ExecutionContextInterface
   */
  protected $context;

  /**
   * {@inheritdoc}
   */
  public function validate($items, Constraint $constraint) {
    foreach ($items as $item) {
      if (!$this->slotTimeFormatValidate($item->value)) {
        $this->context->addViolation($constraint->slotTimeFormatMessage, ['%value' => $item->value]);
      }
    }
    return NULL;
  }

  private function slotTimeFormatValidate($value) {
    $hour_format = "/^[0-9]{2}:[0-9]{2}$/";
    return preg_match($hour_format, $value, $matches);
  }

}
