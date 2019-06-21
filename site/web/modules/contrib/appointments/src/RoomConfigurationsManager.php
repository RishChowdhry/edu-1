<?php

namespace Drupal\appointments;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelInterface;

/**
 * Class AppointmentsConfigurationManager.
 *
 * @package Drupal\appointments
 */
class RoomConfigurationsManager implements RoomConfigurationsManagerInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Logger\LoggerChannelInterface definition.
   *
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  public function __construct(EntityTypeManagerInterface $entity_type_manager, LoggerChannelInterface $logger) {
    $this->entityTypeManager = $entity_type_manager;
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration($nid) {
    /** @var \Drupal\Core\Entity\EntityStorageInterface $storage **/
    $storage = $this->entityTypeManager->getStorage('room_configurations');
    $query = $storage->getQuery('AND');
    $results = $query->condition('room_manager_node', $nid)
      ->execute();

    $rcid = NULL;
    if (empty($results)) {
      $label = $this->entityTypeManager->getStorage('node')->load($nid)->label();
      /** @var \Drupal\appointments\Entity\RoomConfigurations $entity */
      $entity = $storage->create();
      $entity->set('name', $label);
      $entity->set('room_manager_node', $nid);
    }
    else {
      $rcid = array_pop($results);
      /** @var \Drupal\appointments\Entity\RoomConfigurations $entity */
      $entity = $storage->load($rcid);
    }

    return $entity;
  }
}
