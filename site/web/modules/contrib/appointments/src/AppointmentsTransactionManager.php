<?php

namespace Drupal\appointments;

use Drupal\appointments\Entity\Appointment;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\content_moderation\StateTransitionValidationInterface;
use Drupal\content_moderation\Entity\ContentModerationState as ContentModerationStateEntity;

/**
 * Class AppointmentsTransactionManager.
 *
 * @package Drupal\appointments
 */
class AppointmentsTransactionManager implements AppointmentsTransactionManagerInterface {

  /**
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * @var \Drupal\content_moderation\StateTransitionValidationInterface
   */
  protected $stateTransitionValidation;

  /**
   * AppointmentsTransactionManager constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   * @param \Drupal\Core\Session\AccountProxyInterface $account_proxy
   * @param \Drupal\content_moderation\StateTransitionValidationInterface $state_transition_validation
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountProxyInterface $account_proxy, StateTransitionValidationInterface $state_transition_validation) {
    $this->entityTypeManager = $entity_type_manager;
    $this->account = $account_proxy;
    $this->stateTransitionValidation = $state_transition_validation;
  }

  /**
   * {@inheritdoc}
   */
  public function canTransitionToConfirm(Appointment $appointment) {

    try {
      $transitions = $this->stateTransitionValidation->getValidTransitions($appointment, $this->account);

      /** @var \Drupal\content_moderation\ContentModerationState $current_state */
      $current_state = $this->getCurentState($appointment);

      $result = (isset($transitions['confirm']) && $current_state->canTransitionTo('published'));
    }
    catch (\Exception $e) {
      $this->logger->error($e->getMessage());
      $result = FALSE;
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function canTransitionToDelete(Appointment $appointment) {

    try {
      $transitions = $this->stateTransitionValidation->getValidTransitions($appointment, $this->account);

      /** @var \Drupal\content_moderation\ContentModerationState $current_state */
      $current_state = $this->getCurentState($appointment);

      $result = (isset($transitions['delete']) && $current_state->canTransitionTo('deleted'));
    }
    catch (\Exception $e) {
      $this->logger->error($e->getMessage());
      $result = FALSE;
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function canTransitionToReject(Appointment $appointment) {
    try {
      $transitions = $this->stateTransitionValidation->getValidTransitions($appointment, $this->account);

      /** @var \Drupal\content_moderation\ContentModerationState $current_state */
      $current_state = $this->getCurentState($appointment);

      $result = (isset($transitions['reject']) && $current_state->canTransitionTo('rejected'));
    }
    catch (\Exception $e) {
      $this->logger->error($e->getMessage());
      $result = FALSE;
    }

    return $result;
  }

  /**
   * Get Current Appointment workflow state.
   *
   * @param $appointment
   *
   * @return \Drupal\content_moderation\ContentModerationState
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\TypedData\Exception\MissingDataException
   */
  private function getCurentState($appointment) {
    $workflow = $this->entityTypeManager->getStorage('workflow')->load('appointments');
    $content_moderation_state = ContentModerationStateEntity::loadFromModeratedEntity($appointment);
    $current_state_id = $content_moderation_state->get('moderation_state')->first()->value;

    return $workflow->getTypePlugin()->getState($current_state_id);
  }

}
