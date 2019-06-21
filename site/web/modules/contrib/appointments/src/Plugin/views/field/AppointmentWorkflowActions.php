<?php

namespace Drupal\appointments\Plugin\views\field;

use Drupal\Core\Url;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Description.
 *
 * @ViewsField("appointment_workflow_actions")
 */
class AppointmentWorkflowActions extends FieldPluginBase {

  /**
   * @var array
   */
  private $enableStates = ['draft'];

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {

    $items = [];
    $nid = $values->_entity->getAppointmentNode();
    $destination = Url::fromRoute('appointments.node.appointments_management', ['node' => $nid])->toString();
    $moderation_state = $values->_relationship_entities['moderation_state']->get('moderation_state')->value;

    /** @var \Drupal\Core\Session\AccountProxyInterface $account_proxy */
    $account_proxy = \Drupal::currentUser();
    $account = $account_proxy->getAccount();

    $administer_workflows = $account->hasPermission('administer workflows');

    // Link to delete an appointment.
    if ($administer_workflows || $account->hasPermission('use appointments transition delete')) {
      // If the appointments is no more in initial state,
      // does not to shown anymore links to change status.
      if (in_array($moderation_state, $this->enableStates)) {
        $items[] = [
          '#type' => 'link',
          '#title' => $this->t("Delete"),
          '#url' => Url::fromRoute('appointments.appointment.delete', ['appointment' => $values->id], ['query' => ['destination' => $destination]]),
        ];
      }
      else {
        $items[] = [
          '#type' => 'markup',
          '#markup' => $this->t("Delete"),
        ];
      }
    }

    // Link to reject an appointment.
    if ($administer_workflows || $account->hasPermission('use appointments transition reject')) {
      // If the appointments is no more in initial state,
      // does not to shown anymore links to change status.
      if (in_array($moderation_state, $this->enableStates)) {
        $items[] = [
          '#type' => 'link',
          '#title' => $this->t("Reject"),
          '#url' => Url::fromRoute('appointments.appointment.reject', ['appointment' => $values->id], ['query' => ['destination' => $destination]]),
        ];
      }
      else {
        $items[] = [
          '#type' => 'markup',
          '#markup' => $this->t("Reject"),
        ];
      }
    }

    // Link to confirm an appointment.
    if ($administer_workflows || $account->hasPermission('use appointments transition confirm')) {
      // If the appointments is no more in initial state,
      // does not to shown anymore links to change status.
      if (in_array($moderation_state, $this->enableStates)) {
        $items[] = [
          '#type' => 'link',
          '#title' => $this->t("Confirm"),
          '#url' => Url::fromRoute('appointments.appointment.confirm', ['appointment' => $values->id], ['query' => ['destination' => $destination]]),
        ];
      }
      else {
        $items[] = [
          '#type' => 'markup',
          '#markup' => $this->t("Confirm"),
        ];
      }
    }

    $build = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#items' => $items,
      '#attributes' => ['class' => 'actions-list'],
    ];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // This field have not a SQL table field associate with.
  }
}
