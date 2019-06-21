<?php

namespace Drupal\appointments\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItem;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;

/**
 * Plugin implementation of the 'time_only_field' field type.
 *
 * @FieldType(
 *   id = "time_only_field",
 *   label = @Translation("Time only field"),
 *   description = @Translation("Creates custom field type for time only field."),
 *   default_widget = "time_only_widget", default_formatter = "time_only_field_formatter",
 *   list_class = "\Drupal\datetime\Plugin\Field\FieldType\DateTimeFieldItemList"
 * )
 */
class TimeOnlyField extends DateTimeItem {

  /**
   * Value for the 'datetime_type' setting: store a date and time.
   */
  const DATETIME_TYPE_TIME = 'time';

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $element = [];

    $element['datetime_type'] = [
      '#type' => 'select',
      '#title' => t('Date type'),
      '#description' => t('Choose the type of date to create.'),
      '#default_value' => $this->getSetting('datetime_type'),
      '#options' => [
        static::DATETIME_TYPE_TIME => t('Time only'),
      ],
      '#disabled' => $has_data,
    ];

    return $element;

  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $type = $field_definition->getSetting('datetime_type');

    // Just pick a date in the past year. No guidance is provided by this Field
    // type.
    $timestamp = \Drupal::time()->getRequestTime() - mt_rand(0, 86400 * 365);
    if ($type == DateTimeItem::DATETIME_TYPE_DATE) {
      $values['value'] = gmdate(DateTimeItemInterface::DATE_STORAGE_FORMAT, $timestamp);
    }
    elseif ($type == TimeOnlyField::DATETIME_TYPE_TIME) {
      $values['value'] = gmdate(DateTimeItemInterface::DATE_STORAGE_FORMAT, $timestamp);
    }
    else {
      $values['value'] = gmdate(DateTimeItemInterface::DATE_STORAGE_FORMAT, $timestamp);
    }
    return $values;
  }

}
