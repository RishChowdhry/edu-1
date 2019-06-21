<?php

namespace Drupal\appointments;

/**
 * Interface RoomConfigurationsManagerInterface.
 */
interface RoomConfigurationsManagerInterface {

  /**
   * This method get a node's RoomConfigurations object.
   *
   * For every node used for appointments there is a RoomConfigurations object
   * with the corresponding configuration.
   *
   * @param $nid
   *
   * @return \Drupal\appointments\Entity\RoomConfigurations
   *
   * @throws \Exception
   */
  public function getConfiguration($nid);

}