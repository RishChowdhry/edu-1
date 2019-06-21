<?php

namespace Drupal\appointments\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\field\Entity\FieldConfig;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Cache\Cache;

/**
 * Class AppointmentsConfigurationForm.
 */
class AppointmentsConfigurationForm extends ConfigFormBase {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  /**
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  private $entityFieldManager;

  /**
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  protected $database;

  /**
   * Constructs a \Drupal\system\ConfigFormBase object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type managers object.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager object.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service object.
   * @param \Drupal\Core\Database\Connection $database
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, EntityFieldManagerInterface $entity_field_manager, MessengerInterface $messenger, Connection $database) {
    parent::__construct($config_factory);
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFieldManager = $entity_field_manager;
    $this->messenger = $messenger;
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager'),
      $container->get('entity_field.manager'),
      $container->get('messenger'),
      $container->get('database')
    );
  }

  public function getEditableConfigNames() {
    // TODO: Implement getEditableConfigNames() method.
    return [
      'appointments.settings'
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'appointments_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $appointments_content_type_options = [
      'none' => ' - Select a Content Type - ',
    ];
    $types = $this->entityTypeManager->getStorage('node_type')->loadMultiple();
    foreach ($types as $type => $entity) {
      $appointments_content_type_options[$type] = $entity->label();
    }

    $appointments_field_options = [
      'none' => ' - Select a Field - ',
    ];
    $fields = $this->entityFieldManager->getFieldDefinitions('user', 'user');
    foreach ($fields as $field) {
      if ($field instanceof FieldConfig) {
        $appointments_field_options[$field->getName()] = $field->getLabel();
      }
    }

    $config = $this->config('appointments.settings');

    $form['appointments_content_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Content type with appointments attached to.'),
      '#options' => $appointments_content_type_options,
      '#default_value' => empty($config->get('content_type')) ? 'none' : $config->get('content_type'),
      '#weight' => '0',
    ];

    $form['appointments_privacy_text'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Privacy text for anonymous users'),
      '#default_value' => $config->get('privacy_text'),
      '#format' => $config->get('privacy_text_format'),
      '#weight' => '0',
    ];

    $form['appointments_name_field'] = [
      '#type' => 'select',
      '#title' => $this->t('User field containig user&#039;s proper name.'),
      '#options' => $appointments_field_options,
      '#default_value' => empty($config->get('user_profile_field_name')) ? 'none' : $config->get('user_profile_field_name'),
      '#weight' => '0',
    ];

    $form['appointments_surname_field'] = [
      '#type' => 'select',
      '#title' => $this->t('User field containig user&#039;s surname.'),
      '#options' => $appointments_field_options,
      '#default_value' => empty($config->get('user_profile_field_surname')) ? 'none' : $config->get('user_profile_field_surname'),
      '#weight' => '0',
    ];

    $form['appointments_first_day_week'] = [
      '#type' => 'select',
      '#title' => $this->t('Select the first day of the week in the calendar.'),
      '#options' => [
        0 => $this->t('Sunday'),
        1 => $this->t('Monday'),
        2 => $this->t('Tuesday'),
        3 => $this->t('Wednesday'),
        4 => $this->t('Thursday'),
        5 => $this->t('Friday'),
        6 => $this->t('Saturday'),
      ],
      '#default_value' => $config->get('first_day_week', 0),
      '#weight' => '0',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
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

    $bundles = [
      $form_state->getValue('appointments_content_type'),
      $this->config('appointments.settings')->get('content_type'),
    ];

    $tags = $this->getInvalidaTags($bundles);
    Cache::invalidateTags($tags);
    $this->logger('appointments')->debug('Invalida tags @tags', [
      '@tags' => print_r($tags, TRUE),
    ]);

    // Display result.
    $appointments_privacy_text = $form_state->getValue('appointments_privacy_text');
    $this->config('appointments.settings')
      ->set('content_type', $form_state->getValue('appointments_content_type'))
      ->set('privacy_text', $appointments_privacy_text['value'])
      ->set('privacy_text_format', $appointments_privacy_text['format'])
      ->set('user_profile_field_name', ($form_state->getValue('appointments_name_field') == 'none') ? '' : $form_state->getValue('appointments_name_field'))
      ->set('user_profile_field_surname', ($form_state->getValue('appointments_surname_field') == 'none' ? '' : $form_state->getValue('appointments_surname_field')))
      ->set('first_day_week', $form_state->getValue('appointments_first_day_week'))
      ->save();

    $this->messenger->addMessage("Configuration updated");
  }

  /**
   * @param $bundles
   *
   * @return array
   */
  private function getInvalidaTags($bundles) {
    $tags = [];
    $nids = $this->database
      ->select('node', 'n')
      ->fields('n', ['nid'])
      ->condition('type', $bundles, "IN")
      ->execute()
      ->fetchAllKeyed(0,0);

    foreach ($nids as $nid) {
      $tags[] = 'node:' . $nid;
    }

    return $tags;
  }
}
