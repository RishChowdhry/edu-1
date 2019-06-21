<?php

namespace Drupal\appointments\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Room configurations edit forms.
 *
 * @ingroup appointments
 */
class RoomConfigurationsForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\appointments\Entity\RoomConfigurations */
    $form = parent::buildForm($form, $form_state);

    // Step of 1h.
    $form['open']['widget'][0]['value']['#attributes']['step'] = '3600';
    $form['close']['widget'][0]['value']['#attributes']['step'] = '3600';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);

    $entity = $this->entity;
    drupal_set_message($this->t('Updated the %label Room configurations.', [
      '%label' => $entity->label(),
    ]));

    $room_manager_node = $entity->get('room_manager_node')->get(0)->getValue();
    if (!empty($room_manager_node)) {
      $form_state->setRedirect('appointments.node.appointments_management.configure', ['node' => $room_manager_node['target_id']]);
    }
    else {
      $form_state->setRedirect('entity.room_configurations.canonical', ['room_configurations' => $entity->id()]);
    }
  }

}
