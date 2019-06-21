<?php

namespace Drupal\appointments\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\Plugin\Field\FieldWidget\TimestampDatetimeWidget;

/**
 * Plugin implementation of the 'time_only_widget' widget.
 *
 * @FieldWidget(
 *   id = "time_only_widget",
 *   label = @Translation("Time only widget"),
 *   field_types = {
 *     "timestamp"
 *   }
 * )
 */
class TimeOnlyWidget extends TimestampDatetimeWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $date_type = 'none';

    $element['value'] = array_merge($element['value'], [
      '#date_date_element' => $date_type,
    ]);

    $element['value']['#description'] = '';

    return $element;
  }

}
