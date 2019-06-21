<?php

namespace Drupal\appointments\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Url;
use Drupal\appointments\AppointmentsManagerInterface;
use Drupal\appointments\AppointmentsTransactionManagerInterface;

/**
 * Class AppointmentDeleteForm.
 */
class AppointmentDeleteForm extends ConfirmFormBase {

  /**
   * @var \Drupal\appointments\Entity\Appointment
   */
  protected $appointment;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  /**
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * @var \Drupal\appointments\AppointmentsManagerInterface
   */
  protected $appointmentsManager;

  /**
   * @var \Drupal\appointments\AppointmentsTransactionManagerInterface
   */
  protected $appointmentsTransactionManager;

  /**
   * Constructs a AppointmentDeleteForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type managers object.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service object.
   * @param \Drupal\appointments\AppointmentsManagerInterface $appointments_manager
   *   The Appointment Manager object.
   * @param \Drupal\appointments\AppointmentsTransactionManagerInterface $appointments_transaction_manager
   *   The Appointments Transaction Manager object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, MessengerInterface $messenger, AppointmentsManagerInterface $appointments_manager, AppointmentsTransactionManagerInterface $appointments_transaction_manager) {
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
    $this->appointmentsManager = $appointments_manager;
    $this->appointmentsTransactionManager = $appointments_transaction_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('messenger'),
      $container->get('appointments.appointments_manager'),
      $container->get('appointments.appointments_transaction_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'appointments_delete_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $appointment = NULL) {
    $this->appointment = $this->entityTypeManager->getStorage('appointment')->load($appointment);
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    if ($this->appointmentsTransactionManager->canTransitionToDelete($this->appointment)) {
      $this->appointmentsManager->delete($this->appointment);
      $this->messenger->addMessage("Configuration updated");
    }
    else {
      $this->messenger->addMessage("You can not put Appointment in Delete state");
    }

    $form_state->setRedirectUrl(new Url('appointments.node.appointments_management', ['node' => $this->appointment->getAppointmentNode()]));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('appointments.node.appointments_management', ['node' => $this->appointment->getAppointmentNode()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Do you want to delete Appointment %id?', ['%id' => $this->appointment->id()]);
  }

}
