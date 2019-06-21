<?php

namespace Drupal\appointments\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Appointment entity.
 *
 * @ingroup appointments
 *
 * @ContentEntityType(
 *   id = "appointment",
 *   label = @Translation("Appointment"),
 *   handlers = {
 *     "storage" = "Drupal\appointments\AppointmentStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\appointments\AppointmentListBuilder",
 *     "views_data" = "Drupal\appointments\Entity\AppointmentViewsData",
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\appointments\Form\AppointmentForm",
 *       "add" = "Drupal\appointments\Form\AppointmentForm",
 *       "edit" = "Drupal\appointments\Form\AppointmentForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "access" = "Drupal\appointments\AppointmentAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\appointments\AppointmentHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "appointment",
 *   data_table = "appointment_field_data",
 *   revision_table = "appointment_revision",
 *   revision_data_table = "appointment_field_revision",
 *   translatable = TRUE,
 *   admin_permission = "administer appointment entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "uid",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },

 *   links = {
 *     "canonical" = "/appointment/{appointment}",
 *     "add-form" = "/appointment/add",
 *     "edit-form" = "/appointment/{appointment}/edit",
 *     "delete-form" = "/appointment/{appointment}/hard-delete",
 *     "version-history" = "/appointment/{appointment}/revisions",
 *     "revision" = "/appointment/{appointment}/revisions/{appointment_revision}/view",
 *     "revision_revert" = "/appointment/{appointment}/revisions/{appointment_revision}/revert",
 *     "revision_delete" = "/appointment/{appointment}/revisions/{appointment_revision}/delete",
 *     "translation_revert" = "/appointment/{appointment}/revisions/{appointment_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/appointment",
 *   },
 *   field_ui_base_route = "appointment.settings"
 * )
 */
class Appointment extends RevisionableContentEntityBase implements AppointmentInterface, EntityPublishedInterface {

  use EntityChangedTrait;

  const PENDING = 'draft';
  const CONFIRMED = 'published';
  const REJECTED = 'rejected';
  const DELETED = 'deleted';

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
  protected function urlRouteParameters($rel) {
    $uri_route_parameters = parent::urlRouteParameters($rel);

    if ($rel === 'revision_revert' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }
    elseif ($rel === 'revision_delete' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }

    return $uri_route_parameters;
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    foreach (array_keys($this->getTranslationLanguages()) as $langcode) {
      $translation = $this->getTranslation($langcode);

      // If no owner has been set explicitly, make the anonymous user the owner.
      if (!$translation->getOwner()) {
        $translation->setOwnerId(0);
      }
    }

    // If no revision author has been set explicitly, make the appointment owner the
    // revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save() {
    /** @var \Drupal\appointments\AppointmentsManager $manager */
    $manager = \Drupal::service('appointments.appointments_manager');
    try {
      return $manager->save($this);
    }
    catch (\Exception $e) {
      /** @var \Drupal\Core\Messenger\MessengerInterface $messenger **/
      $messenger = \Drupal::service('messenger');
      $messenger->deleteByType($messenger::TYPE_STATUS);
      $messenger->addWarning("Another user have had take this slot, you have to choose another free slot.");
      return NULL;
    }

  }

  /**
   * {@inheritdoc}
   */
  public function delete() {
    if (!$this->isNew()) {
      /** @var \Drupal\appointments\AppointmentsManager $manager */
      $manager = \Drupal::service('appointments.appointments_manager');
      $manager->delete($this, TRUE);
    }
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
  public function getDateTimeStart() {
    $start = $this->get('start')->value;
    if(!empty($start)) {
      $timezone = drupal_get_user_timezone();
      return \DateTime::createFromFormat("U", $start)->setTimezone(new \DateTimeZone($timezone));
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getDateTimeEnd() {
    $end = $this->get('end')->value;

    if(!empty($end)) {
      $timezone = drupal_get_user_timezone();
      return \DateTime::createFromFormat("U", $end)->setTimezone(new \DateTimeZone($timezone));
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getDateTimeEndReal() {
    $end_real = $this->getDateTimeEnd();
    if (!empty($end_real)) {
      return $end_real->sub(new \DateInterval("PT1M"));
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getAppointmentNode() {
    $value = $this->get('appointment_node')->get(0)->getValue();
    if (!empty($value)) {
      return $value['target_id'];
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getSlot() {
    $slot = $this->get('slot')->value;
    if (!empty($slot)) {
      return $slot;
    }

    return NULL;
  }

  public function getApplicantEMail() {

    try {
      /** @var \Drupal\appointments\Entity\Applicant $applicant */
      $applicant = $this->get('applicant')->first()->get('entity')->getTarget()->getValue();

      $email = $applicant->getEMail();
    }
    catch (\Exception $e) {
      $email = '';
    }

    return $email;
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
  public function setPublished($published = NULL) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setUnpublished() {
    $this->set('status', FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Appointment entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
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
      ->setDescription(t('The name of the Appointment entity.'))
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('Empty')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
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
      ->setDescription(t('A boolean indicating whether the Appointment is published.'))
      ->setRevisionable(TRUE)
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
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

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    $fields['start'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('Date and time of the Appointment.'))
      ->setDescription(t(''))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['end'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('End Date and time of the Appointment.'))
      ->setDescription(t(''))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['slot'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Slot.'))
      ->setDescription(t(''))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setDefaultValue(0)
      ->setDisplayOptions('form', [
        'type' => 'hidden',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['note'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Note'))
      ->setDescription(t(''))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
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

    $fields['applicant'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Applicant'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'applicant')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'inline_entity_form_simple',
        'weight' => 5,
        'settings' => [
          'form_mode' => 'default',
          'label_singular' => '',
          'label_plural' => '',
          'override_labels' => false,
          'collapsible' => false,
          'collapsed' => false,
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['appointment_node'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Appointment node'))
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
