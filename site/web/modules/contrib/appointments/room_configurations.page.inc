<?php

/**
 * @file
 * Contains room_configurations.page.inc.
 *
 * Page callback for Room configurations entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Room configurations templates.
 *
 * Default template: room_configurations.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_room_configurations(array &$variables) {
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
