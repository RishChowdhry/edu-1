<?php

namespace Drupal\appointments\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Form controller for Appointment edit forms.
 *
 * @ingroup appointments
 */
class AppointmentForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\appointments\Entity\Appointment */
    $form = parent::buildForm($form, $form_state);

    if (!$this->entity->isNew()) {
      $form['new_revision'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Create new revision'),
        '#default_value' => FALSE,
        '#weight' => 10,
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * Button-level validation handlers are highly discouraged for entity forms,
   * as they will prevent entity validation from running. If the entity is going
   * to be saved during the form submission, this method should be manually
   * invoked from the button-level validation handler, otherwise an exception
   * will be thrown.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    // Save as a new revision if requested to do so.
    if (!$form_state->isValueEmpty('new_revision') && $form_state->getValue('new_revision') != FALSE) {
      $entity->setNewRevision();

      // If a new revision is created, save the current user as revision author.
      $entity->setRevisionCreationTime(REQUEST_TIME);
      $entity->setRevisionUserId(\Drupal::currentUser()->id());
    }
    else {
      $entity->setNewRevision(FALSE);
    }

    // If start datetime is present, set end datetime.
    $start = $entity->get('start')->value;
    if(!empty($start)) {
      $end = \DateTime::createFromFormat("U", $start);
      $end->add(new \DateInterval("PT1H"));
      $entity->get('end')->setValue($end->format("U"));
    }

    // Gets form's user input.
    $input = $form_state->getUserInput();

    if(isset($input['appointment_node'])) {
      $entity->get('appointment_node')->setValue(['target_id' => $input['appointment_node']]);
    }

    // Set Appointment label field.
    $entity->get('name')->setValue($this->getAppointmentName($entity));

    $status = parent::save($form, $form_state);

    /**
     * When Appointment will be created from content Appointments page view,
     * the user will be redirect in that page (/node/{nid}).
     */
    $appointment_redirect = FALSE;
    $appointment_redirect_uri = "";

    if (isset($input['appointment_redirect']) && is_numeric($input['appointment_redirect'])) {
      $appointment_redirect = ($input['appointment_redirect'] == 1) ? TRUE : FALSE;
    }

    if (isset($input['appointment_redirect_uri']) && $this->validEntityUri($input['appointment_redirect_uri'])){
      $appointment_redirect_uri = $input['appointment_redirect_uri'];
    }

    if ($appointment_redirect && !empty($appointment_redirect_uri)) {
      $this->messenger()->addMessage($this->t("Your appointment has been successful requested."));
      $form_state->setRedirectUrl(Url::fromUri($appointment_redirect_uri));
    }
    else {
      switch ($status) {
        case SAVED_NEW:
          $this->messenger()->addMessage($this->t('Created the %label Appointment.', [
            '%label' => $entity->label(),
          ]));
          break;

        default:
          $this->messenger()->addMessage($this->t('Saved the %label Appointment.', [
            '%label' => $entity->label(),
          ]));
      }
      $form_state->setRedirect('entity.appointment.canonical', ['appointment' => $entity->id()]);
    }
  }

  /**
   * @param $uri
   *
   * @return bool
   */
  private function validEntityUri($uri) {

    if(empty($uri)) {
      return FALSE;
    }

    // TODO: use a regular expression to do the check.
    // $uri have to be an entity uri.
    $start = substr($uri, 0, 7);
    if ($start == "entity:") {
      return TRUE;
    }

    return FALSE;
  }

  /**
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $appointment
   *
   * @return array
   */
  private function getAppointmentName(ContentEntityInterface $appointment) {
    try {
      $applicant = $this->getApplicant($appointment);
      $node = $this->getAppointmentNode($appointment);
    }
    catch (\Exception $e) {
      // log message.
      return [
        'value' => $appointment->get('name')->value,
      ];
    }

    return [
      'value' => $applicant->getName() . " "  . $applicant->getSurname() . " - " . $node->label(),
    ];
  }

  /**
   * @param $appointment
   *
   * @return mixed
   */
  private function getApplicant($appointment) {
    return $appointment->get('applicant')->get(0)->get('entity')->getTarget()->getValue();
  }

  /**
   * @param $appointment
   *
   * @return mixed
   * @throws \Exception
   */
  private function getAppointmentNode($appointment) {
    $field = $appointment->get('appointment_node')->get(0);
    if (empty($field)) {
      throw new \Exception("There is not a appointment_node referenced value");
    }

    return $field->get('entity')->getTarget()->getValue();
  }

}
