<?php

/**
 * @file
 * Contains applicant.page.inc.
 *
 * Page callback for Applicant entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Applicant templates.
 *
 * Default template: applicant.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_applicant(array &$variables) {
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
