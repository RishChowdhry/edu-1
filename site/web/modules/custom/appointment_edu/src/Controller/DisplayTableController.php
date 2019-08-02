<?php

namespace Drupal\appointment_edu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\appointment_edu\Controller
 */
class DisplayTableController extends ControllerBase {


  public function getContent() {
    // First we'll tell the user what's going on. This content can be found
    // in the twig template file: templates/description.html.twig.
    // @todo: Set up links to create nodes and point to devel module.
    $build = [
      'description' => [
        '#theme' => 'appointment_edu_description',
        '#description' => 'foo',
        '#attributes' => [],
      ],
    ];
    return $build;
  }

  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    /**return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display with parameter(s): $name'),
    ];*/

    //create table header
    $header_table = array(
     'appointment_id'=>    t('ApNo'),
      'name' => t('Name'),
        'mobilenumber' => t('MobileNumber'),
        //'email'=>t('Email'),
        'age' => t('Age'),
        'gender' => t('Gender'),
        'email' => t('Email'),
        'appointment_date' => t('Appointment Date'),
        'note' => t('Note'),
        'appointment_saveas' => t('Appointment Save As'),
        'opt' => t('Operations'),
        //'opt1' => t('operations'),
    );

//select records from table
    $query = \Drupal::database()->select('appointment_edu_booking', 'm');
      $query->fields('m', ['appointment_id','name','mobilenumber','email','age','gender','appointment_date','note','appointment_saveas','appointment_tutoruid']);
      $uid = \Drupal::currentUser()->id();
      $current_user = \Drupal::currentUser();
      $roles = $current_user->getRoles();
      //echo "<pre>"; print_r($roles); die();
      if ($roles[1] == 'student') {
        $results = $query->condition('appointment_studentuid', $uid)->execute()->fetchAll();
      } elseif ($roles[1] == 'tutor'){
        $results = $query->condition('appointment_tutoruid', $uid)->execute()->fetchAll();
      }elseif ($roles[1] == 'administrator'){
        $results = $query->execute()->fetchAll();
      }
        $rows=array();
    foreach($results as $data){
        $delete = Url::fromUserInput('/appointment_edu/form/delete/'.$data->appointment_id);
        $edit   = Url::fromUserInput('/user/'.$data->appointment_tutoruid.'/createappointment?num='.$data->appointment_id);

      //print the data from table
             $rows[] = array(
            'appointment_id' =>$data->appointment_id,
                'name' => $data->name,
                'mobilenumber' => $data->mobilenumber,
                //'email' => $data->email,
                'age' => $data->age,
                'gender' => $data->gender,
                'email' => $data->email,
                'appointment_date' => $data->appointment_date,
                'note' => $data->note,
                'appointment_saveas' => $data->appointment_saveas,
                //'note' => $data->note,

                // \Drupal::l('Delete', $delete),
                 \Drupal::l('Edit', $edit),
            );

    }
    //display data in site
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
//        echo '<pre>';print_r($form['table']);exit;
        return $form;

  }

}
