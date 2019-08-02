<?php

namespace Drupal\appointment_edu\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class appointment_eduForm.
 *
 * @package Drupal\appointment_edu\Form
 */
class Appointment_slotForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'appointment_slot_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $uid = \Drupal::currentUser()->id();
    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('appointment_edu_booking_slots', 'm')
            ->condition('eduslot_id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();
    }

    $form['appointment_tutoruid'] = array(
      '#type' => 'hidden',
      '#default_value' => $uid,
    );
    $form['appointment_slot_box']['appointment_slot'] = array(
      '#type' => 'checkboxes',
      '#options' => array('10:00-11:00' => $this->t('10:00-11:00'), '11:00-12:00' => $this->t('12:00-1:00')),
      '#title' => $this->t('Select Your Slot'),
    );
    // $form['appointment_slot'] = array(
    //   '#type' => 'textfield',
    //   '#title' => t('Slot:'),
    //   '#default_value' => (isset($record['appointment_slot']) && $_GET['num']) ? $record['appointment_slot']:'',
    //   );
    $form['appointment_date'] = array (
      '#type' => 'datetime',
      '#title' => t('Appointment Date.'),
      '#size' => 20,
      '#default_value' => (isset($record['appointment_date']) && $_GET['num']) ? $record['appointment_date']:'',
      '#date_date_format' => 'd/m/Y',
      '#date_time_format' => 'H:m',
       );
    $form['appointment_subject'] = array(
      '#type' => 'textfield',
      '#title' => t('Appointment Subject:'),
      '#default_value' => (isset($record['appointment_subject']) && $_GET['num']) ? $record['appointment_subject']:'',
      );
    $form['appointment_address'] = array(
      '#type' => 'textfield',
      '#title' => t('Appointment Address:'),
      '#default_value' => (isset($record['appointment_address']) && $_GET['num']) ? $record['appointment_address']:'',
      );
    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'save',
        //'#value' => t('Submit'),
    ];
    return $form;
  }

  /**
    * {@inheritdoc}
    */

  public function validateForm(array &$form, FormStateInterface $form_state) {
          // if (strlen($form_state->getValue('mobile_number')) < 10 ) {
          //   $form_state->setErrorByName('mobile_number', $this->t('your mobile number must in 10 digits'));
          //  }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field=$form_state->getValues();
    $appointment_slot_data = implode(',', $field['appointment_slot']);
    $appointment_slot = $appointment_slot_data;
    $appointment_subject = $field['appointment_subject'];
    $appointment_address = $field['appointment_address'];
    $appointment_date = $field['appointment_date'];
    $appointment_tutoruid = $field['appointment_tutoruid'];

    if (isset($_GET['num'])) {
          $field  = array(
              'appointment_date' => $appointment_date,
              'appointment_slot' => $appointment_slot,
              'appointment_subject' => $appointment_subject,
              'appointment_address' => $appointment_address,
          );
          //echo "<pre>"; print_r($field); die();
          $query = \Drupal::database();
          $query->update('appointment_edu_booking_slots')
              ->fields($field)
              ->condition('eduslot_id', $_GET['num'])
              ->execute();
          drupal_set_message("succesfully updated");
          $response = new RedirectResponse("appointment");
          $response->send();
          //$form_state->setRedirect('appointment_edu.display_table_controller_display');
      }
       else
       {
          $field  = array(
              'appointment_date' => $appointment_date,
              'appointment_slot' => $appointment_slot,
              'appointment_subject' => $appointment_subject,
              'appointment_address' => $appointment_address,
              'appointment_tutoruid' => $appointment_tutoruid,
          );
           $query = \Drupal::database();
           $query ->insert('appointment_edu_booking_slots')
               ->fields($field)
               ->execute();
           drupal_set_message("succesfully slot saved");

           $response = new RedirectResponse("appointment");
           $response->send();
       }
     }

}
