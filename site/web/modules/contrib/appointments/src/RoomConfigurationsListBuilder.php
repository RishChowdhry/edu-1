<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Room configurations entities.
 *
 * @ingroup appointments
 */
class RoomConfigurationsListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Room configurations ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\appointments\Entity\RoomConfigurations */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.room_configurations.edit_form',
      ['room_configurations' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
