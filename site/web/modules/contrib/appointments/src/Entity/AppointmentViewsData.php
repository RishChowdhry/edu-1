<?php

namespace Drupal\appointments\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Appointment entities.
 */
class AppointmentViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['appointment']['appointment_workflow_actions'] = [
      'title' => $this->t("Appointment workflow actions"),
      'help' => $this->t(""),
      'field' => [
        'id' => 'appointment_workflow_actions',
      ],
    ];

    return $data;
  }

}
