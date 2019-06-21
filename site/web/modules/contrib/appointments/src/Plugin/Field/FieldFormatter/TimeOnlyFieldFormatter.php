<?php

namespace Drupal\appointments\Plugin\Field\FieldFormatter;

use Drupal\datetime\Plugin\Field\FieldFormatter\DateTimeDefaultFormatter;

/**
 * Plugin implementation of the 'time_only_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "time_only_field_formatter",
 *   label = @Translation("Time only field formatter"),
 *   field_types = {
 *     "time_only_field"
 *   }
 * )
 */
class TimeOnlyFieldFormatter extends DateTimeDefaultFormatter {

  // This Formatter is created since it was throwing error and requiring some formatter class.
  //@Todo: See if there is other way without custom formatter class and just use datetime_default formatter.
}
