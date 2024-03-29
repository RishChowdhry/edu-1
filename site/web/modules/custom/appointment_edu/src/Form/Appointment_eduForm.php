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
class Appointment_eduForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'appointment_edu_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $uid = \Drupal::currentUser()->id();
    $current_path = \Drupal::service('path.current')->getPath();
    $arg  = explode('/',$current_path);
    $tid = $arg[2];
    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('appointment_edu_booking', 'm')
            ->condition('appointment_id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();

    }

    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Student Name:'),
      '#required' => TRUE,
       //'#default_values' => array(array('id')),
      '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
      );
    //print_r($form);die();
    $form['appointment_studentuid'] = array(
      '#type' => 'hidden',
      '#default_value' => $uid,
    );
    $form['appointment_tutoruid'] = array(
      '#type' => 'hidden',
      '#default_value' => $tid,
    );
    $form['mobile_number'] = array(
      '#type' => 'textfield',
      '#title' => t('Mobile Number:'),
      '#default_value' => (isset($record['mobilenumber']) && $_GET['num']) ? $record['mobilenumber']:'',
      );

    $form['candidate_mail'] = array(
      '#type' => 'textfield',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['email']) && $_GET['num']) ? $record['email']:'',
      );

    $form['candidate_age'] = array (
      '#type' => 'textfield',
      '#title' => t('AGE'),
      '#required' => TRUE,
      '#default_value' => (isset($record['age']) && $_GET['num']) ? $record['age']:'',
       );

    $form['candidate_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        '#default_value' => (isset($record['gender']) && $_GET['num']) ? $record['gender']:'',
        'Female' => t('Female'),
        'male' => t('Male'),

        ),
      );

    $form['note'] = array (
      '#type' => 'textfield',
      '#title' => t('Note.'),
      '#default_value' => (isset($record['note']) && $_GET['num']) ? $record['note']:'',
       );

    $form['appointment_date'] = array (
      '#type' => 'datetime',
      '#title' => t('Appointment Date.'),
      '#size' => 20,
      '#default_value' => (isset($record['appointment_date']) && $_GET['num']) ? $record['appointment_date']:'',
      '#date_date_format' => 'd/m/Y',
      '#date_time_format' => 'H:m',
       );

    $form['appointment_saveas'] = array (
      '#type' => 'select',
      '#title' => ('Appointment Save As '),
      '#options' => array(
        '#default_value' => (isset($record['appointment_saveas']) && $_GET['num']) ? $record['appointment_saveas']:'',
        'Requested' => t('Requested'),
        'Confirmed' => t('Confirmed'),
        'Rejected' => t('Rejected'),
        'Expired' => t('Expired'),
        ),
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

         $name = $form_state->getValue('candidate_name');
          if(preg_match('/[^A-Za-z]/', $name)) {
             $form_state->setErrorByName('candidate_name', $this->t('your name must in characters without space'));
          }

          // Confirm that age is numeric.
        if (!intval($form_state->getValue('candidate_age'))) {
             $form_state->setErrorByName('candidate_age', $this->t('Age needs to be a number'));
            }

         /* $number = $form_state->getValue('candidate_age');
          if(!preg_match('/[^A-Za-z]/', $number)) {
             $form_state->setErrorByName('candidate_age', $this->t('your age must in numbers'));
          }*/

          if (strlen($form_state->getValue('mobile_number')) < 10 ) {
            $form_state->setErrorByName('mobile_number', $this->t('your mobile number must in 10 digits'));
           }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field=$form_state->getValues();
    $name=$field['candidate_name'];
    //echo "$name";
    $number=$field['mobile_number'];
    $email=$field['candidate_mail'];
    $age=$field['candidate_age'];
    $gender=$field['candidate_gender'];
    $note=$field['note'];
    $appointment_date=$field['appointment_date'];
    $appointment_saveas=$field['appointment_saveas'];
    $appointment_studentuid =$field['appointment_studentuid'];
    $appointment_tutoruid =$field['appointment_tutoruid'];


    if (isset($_GET['num'])) {
          $field  = array(
              'name'   => $name,
              'mobilenumber' =>  $number,
              'email' =>  $email,
              'age' => $age,
              'gender' => $gender,
              'note' => $note,
              // 'appointment_date' => $appointment_date,
              'appointment_saveas' => $appointment_saveas,
              //'appointment_studentuid' => $appointment_studentuid,
              //'appointment_tutoruid' => $appointment_tutoruid,
          );
          //echo "<pre>"; print_r($field); die();
          $query = \Drupal::database();
          $query->update('appointment_edu_booking')
              ->fields($field)
              ->condition('appointment_id', $_GET['num'])
              ->execute();
          drupal_set_message("succesfully updated");
          $response = new RedirectResponse("appointment");
          $response->send();
          //$form_state->setRedirect('appointment_edu.display_table_controller_display');

      }

       else
       {
           $field  = array(
              'name'   =>  $name,
              'mobilenumber' =>  $number,
              'email' =>  $email,
              'age' => $age,
              'gender' => $gender,
              'note' => $note,
              'appointment_date' => $appointment_date,
              'appointment_saveas' => $appointment_saveas,
              'appointment_studentuid' => $appointment_studentuid,
              'appointment_tutoruid' => $appointment_tutoruid,
          );
           $query = \Drupal::database();
           $query ->insert('appointment_edu_booking')
               ->fields($field)
               ->execute();
           drupal_set_message("succesfully saved");

           $response = new RedirectResponse("appointment");
           $response->send();
       }
     }

}
