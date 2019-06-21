<?php

namespace Drupal\appointments\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Room configurations entity.
 *
 * @ingroup appointments
 *
 * @ContentEntityType(
 *   id = "room_configurations",
 *   label = @Translation("Room configurations"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\appointments\RoomConfigurationsListBuilder",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\appointments\Form\RoomConfigurationsForm",
 *       "add" = "Drupal\appointments\Form\RoomConfigurationsForm",
 *       "edit" = "Drupal\appointments\Form\RoomConfigurationsForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "access" = "Drupal\appointments\RoomConfigurationsAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\appointments\RoomConfigurationsHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "room_configurations",
 *   data_table = "room_configurations_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer room configurations entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {},
 *   field_ui_base_route = "room_configurations.settings"
 * )
 */
class RoomConfigurations extends ContentEntityBase implements RoomConfigurationsInterface {

  use EntityChangedTrait;

  const DEFAULT_AVAILABLE = TRUE;
  const DEFAULT_SLOTS = 1;
  const DEFAULT_OPEN = '09:00';
  const DEFAULT_CLOSE = '18:00';
//  const DEFAULT_OPEN = '1546329600';
//  const DEFAULT_CLOSE = '1546362000';
  const DEFAULT_AUTO_CONFRMATION = FALSE;
  const DEFAULT_PENDING_SUBJECT = 'Thanks for the request';
  const DEFAULT_PENDING_BODY = 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo';
  const DEFAULT_CONFIRMED_SUBJECT = 'Your booking has been confirmed';
  const DEFAULT_CONFIRMED_BODY = 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo';
  const DEFAULT_REJECTED_SUBJECT = 'Your booking has been rejected';
  const DEFAULT_REJECTED_BODY = 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo';
  const DEFAULT_ROOM_MANAGER_EMAIL = 'info@example.org';

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'uid' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getAvailable() {
    return $this->available;
  }

  /**
   * {@inheritdoc}
   */
  public function getSlots() {
    $value = $this->get('slots')->getValue();
    if (empty($value)) {
      // returns default value, 1.
      return self::DEFAULT_SLOTS;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getOpen() {
    $value = $this->getFullOpen();
    $datetime = \DateTime::createFromFormat('U', $value);
    $timezone = drupal_get_user_timezone();

    return $datetime->setTimezone(new \DateTimeZone($timezone))->format("H:i");
  }

  /**
   * {@inheritdoc}
   */
  public function getOpenUTC() {
    $value = $this->getFullOpen();
    $datetime = \DateTime::createFromFormat('U', $value);

    return $datetime->format("H:i");
  }

  /**
   * {@inheritdoc}
   */
  public function getFullOpen() {
    $value = $this->get('open')->getValue();
    if (empty($value)) {
      // returns default value, 09:00 UTC (timestamp).
      \DateTime::createFromFormat("Y/m/d H:i", '2019/01/01 ' . self::DEFAULT_OPEN, new \DateTimeZone(drupal_get_user_timezone()))->format('U');
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getClose() {
    $value = $this->getFullClose();
    $datetime = \DateTime::createFromFormat('U', $value);
    $timezone = drupal_get_user_timezone();

    return $datetime->setTimezone(new \DateTimeZone($timezone))->format("H:i");
  }

  /**
   * {@inheritdoc}
   */
  public function getOfficeClose() {
    $value = $this->getFullClose();
    $datetime = \DateTime::createFromFormat('U', $value);
    $timezone = drupal_get_user_timezone();

    return $datetime->add(new \DateInterval('PT1H'))->setTimezone(new \DateTimeZone($timezone))->format("H:i");
  }

  /**
   * {@inheritdoc}
   */
  public function getCloseUTC() {
    $value = $this->getFullClose();
    $datetime = \DateTime::createFromFormat('U', $value);

    return $datetime->format("H:i");
  }

  /**
   * {@inheritdoc}
   */
  public function getFullClose() {
    $value = $this->get('close')->getValue();
    if (empty($value)) {
      // returns default value, 18:00 UTC (timestamp).
      return \DateTime::createFromFormat("Y/m/d H:i", '2019/01/01 ' . self::DEFAULT_CLOSE, new \DateTimeZone(drupal_get_user_timezone()))->format('U');
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getPendingEmailSubject() {
    $value = $this->get('pending_subject')->getValue();
    if (empty($value)) {
      // returns default value, String.
      return self::DEFAULT_PENDING_SUBJECT;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getPendingEmailBody() {
    $value = $this->get('pending_body')->getValue();
    if (empty($value)) {
      // returns default value, String.
      return self::DEFAULT_PENDING_BODY;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmedEmailSubject() {
    $value = $this->get('confirmed_subject')->getValue();
    if (empty($value)) {
      // returns default value, String.
      return self::DEFAULT_CONFIRMED_SUBJECT;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmedEmailBody() {
    $value = $this->get('confirmed_body')->getValue();
    if (empty($value)) {
      // returns default value, String.
      return self::DEFAULT_CONFIRMED_BODY;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getRejectedEmailSubject() {
    $value = $this->get('rejected_subject')->getValue();
    if (empty($value)) {
      // returns default value, String.
      return self::DEFAULT_REJECTED_SUBJECT;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getRejectedEmailBody() {
    $value = $this->get('rejected_body')->getValue();
    if (empty($value)) {
      // returns default value, String.
      return self::DEFAULT_REJECTED_BODY;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getRoomManagerEmail() {
    $value = $this->get('room_manager_email')->getValue();
    if (empty($value)) {
      // returns default value, String.
      return self::DEFAULT_ROOM_MANAGER_EMAIL;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getAutoConfirmation() {
    $value = $this->get('auto_confirmation')->getValue();
    if (empty($value)) {
      // returns default value, FALSE.
      return self::DEFAULT_AUTO_CONFRMATION;
    }

    $value = array_pop($value);
    return $value['value'];
  }

  /**
   * {@inheritdoc}
   */
  public function getTotalSlots() {
    try {
      $start = explode(":", $this->getOpen());
      $end = explode(":", $this->getClose());
      $slot = $this->getSlots();

      $start_date = new \DateTime();
      $end_date = new \DateTime();

      $start_date->setTime($start[0], $start[1]);
      $end_date->setTime($end[0], $end[1]);

      $diff = $end_date->diff($start_date);

      $hours = $diff->h;

      $result = ($hours * $slot) + 1;
    }
    catch (\Exception $e) {
      $result = 0;
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Room configurations entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'type' => 'hidden',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'hidden',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Room configurations entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('Empty')
      ->setDisplayOptions('view', [
        'type' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Room configurations is published.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'hidden',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['slots'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Available slots'))
      ->setDescription(t('The number of slots available for every hour in this office. ATTENTION: this can be only changed if the availability calendar has not been populated yet.'))
      ->setSettings([
        'unsigned' => TRUE,
        'size' => 'normal',
        'min' => 1,
      ])
      ->setDefaultValue(self::DEFAULT_SLOTS)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['open'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('First bookable slot'))
      ->setDescription(t(''))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue(\DateTime::createFromFormat("Y/m/d H:i", '2019/01/01 ' . self::DEFAULT_OPEN, new \DateTimeZone(drupal_get_user_timezone()))->format('U'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'time_only_widget',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['close'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('Latest bookable slot'))
      ->setDescription(t(''))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue(\DateTime::createFromFormat("Y/m/d H:i", '2019/01/01 ' . self::DEFAULT_CLOSE, new \DateTimeZone(drupal_get_user_timezone()))->format('U'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'time_only_widget',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['available'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Available'))
      ->setDescription(t(''))
      ->setSettings([])
      ->setDefaultValue(self::DEFAULT_AVAILABLE)
      ->setDisplayOptions('view', [
        'type' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);

    $fields['auto_confirmation'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Create appointments with status Confirmed'))
      ->setDescription(t(''))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue(self::DEFAULT_AUTO_CONFRMATION)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);

    $fields['pending_subject'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Email pending subject'))
      ->setDescription(t(''))
      ->setSettings([
        'max_length' => 150,
        'text_processing' => 0,
      ])
      ->setDefaultValue(self::DEFAULT_PENDING_SUBJECT)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['pending_body'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Email pending body'))
      ->setDescription(t(''))
      ->setSettings([
        'display_summary' => TRUE,
      ])
      ->setDefaultValue(self::DEFAULT_PENDING_BODY)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['confirmed_subject'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Email confirmed subject'))
      ->setDescription(t(''))
      ->setSettings([
        'max_length' => 150,
        'text_processing' => 0,
      ])
      ->setDefaultValue(self::DEFAULT_CONFIRMED_SUBJECT)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['confirmed_body'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Email confirmed body'))
      ->setDescription(t(''))
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDefaultValue(self::DEFAULT_CONFIRMED_BODY)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['rejected_subject'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Email rejected subject'))
      ->setDescription(t(''))
      ->setSettings([
        'max_length' => 150,
        'text_processing' => 0,
      ])
      ->setDefaultValue(self::DEFAULT_REJECTED_SUBJECT)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['rejected_body'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Email rejected body'))
      ->setDescription(t(''))
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDefaultValue(self::DEFAULT_REJECTED_BODY)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['room_manager_email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Room manager email'))
      ->setDescription(t(''))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setDefaultValue(self::DEFAULT_ROOM_MANAGER_EMAIL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'email_default',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['room_manager_node'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Room manager node'))
      ->setDescription(t(''))
      ->setDisplayOptions('view', [
        'type' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);

    return $fields;
  }

}
