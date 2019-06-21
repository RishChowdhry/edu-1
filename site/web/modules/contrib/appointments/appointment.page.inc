<?php

/**
 * @file
 * Contains appointment.page.inc.
 *
 * Page callback for Appointment entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Appointment templates.
 *
 * Default template: appointment.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_appointment(array &$variables) {
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
