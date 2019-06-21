<?php

namespace Drupal\appointments\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ApplicantTypeForm.
 */
class ApplicantTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $applicant_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $applicant_type->label(),
      '#description' => $this->t("Label for the name type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $applicant_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\appointments\Entity\ApplicantType::load',
      ],
      '#disabled' => !$applicant_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $applicant_type = $this->entity;
    $status = $applicant_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label name type.', [
          '%label' => $applicant_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label name type.', [
          '%label' => $applicant_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($applicant_type->toUrl('collection'));
  }

}
