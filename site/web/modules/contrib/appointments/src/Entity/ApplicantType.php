<?php

namespace Drupal\appointments\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the name type entity.
 *
 * @ConfigEntityType(
 *   id = "applicant_type",
 *   label = @Translation("Applicant type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\appointments\ApplicantTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\appointments\Form\ApplicantTypeForm",
 *       "edit" = "Drupal\appointments\Form\ApplicantTypeForm",
 *       "delete" = "Drupal\appointments\Form\ApplicantTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\appointments\ApplicantTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "applicant_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "applicant",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/applicant_type/{applicant_type}",
 *     "add-form" = "/admin/structure/applicant_type/add",
 *     "edit-form" = "/admin/structure/applicant_type/{applicant_type}/edit",
 *     "delete-form" = "/admin/structure/applicant_type/{applicant_type}/delete",
 *     "collection" = "/admin/structure/applicant_type"
 *   }
 * )
 */
class ApplicantType extends ConfigEntityBundleBase implements ApplicantTypeInterface {

  /**
   * The name type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The name type label.
   *
   * @var string
   */
  protected $label;

}
