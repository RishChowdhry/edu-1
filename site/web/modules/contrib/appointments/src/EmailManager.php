<?php

namespace Drupal\appointments;

use Drupal\appointments\Entity\Appointment;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Utility\Token;
use Drupal\Component\Utility\Html;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Mail\MailManagerInterface;

/**
 * Class EmailManager.
 *
 * @package Drupal\appointments
 */
class EmailManager implements EmailManagerInterface  {

  use StringTranslationTrait;

  /**
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  private $languageManager;

  /**
   * @var RoomConfigurationsManagerInterface
   */
  protected $roomConfigurationManager;

  /**
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * EmailManager constructor.
   *
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   * @param \Drupal\appointments\RoomConfigurationsManagerInterface $room_configuration_manager
   * @param \Drupal\Core\Utility\Token $token
   * @param \Drupal\Core\Render\RendererInterface $renderer
   * @param \Drupal\Core\Mail\MailManagerInterface $mail_manager
   */
  public function __construct(LanguageManagerInterface $language_manager, RoomConfigurationsManagerInterface $room_configuration_manager, Token $token, RendererInterface $renderer, MailManagerInterface $mail_manager) {
    $this->languageManager = $language_manager;
    $this->roomConfigurationManager = $room_configuration_manager;
    $this->token =$token;
    $this->renderer = $renderer;
    $this->mailManager = $mail_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function newAppointment(Appointment $appointment, $exclude_client = FALSE, $show_acceptance_url = TRUE) {
    $language = $this->languageManager->getCurrentLanguage()->getId();

    $configuration = $this->roomConfigurationManager->getConfiguration($appointment->getAppointmentNode());
    $clientEmail = $appointment->getApplicantEMail();
    $roomManagerEmail = $configuration->getRoomManagerEmail();

    $subject = Html::escape($this->buildRoomManagerSubject());
    $body = Html::escape($this->buildRoomManagerBody($show_acceptance_url));

    $roomManagerParams = [
      'subject' => $this->token->replace($subject, ['appointment' => $appointment]),
      'body' => $this->token->replace($body, ['appointment' => $appointment]),
    ];

    $this->mailManager->mail('appointments', 'new_appointment_room_manager', $roomManagerEmail, $language, $roomManagerParams);
    if (!$exclude_client) {
      $subject = Html::escape($configuration->getPendingEmailSubject());
      $body = Html::escape($configuration->getPendingEmailBody());
      $clientParams = [
        'subject' => $this->token->replace($subject, ['appointment' => $appointment]),
        'body' => $this->token->replace($body, ['appointment' => $appointment]),
      ];
      $this->mailManager->mail('appointments', 'new_appointment_client', $clientEmail, $language, $clientParams, $roomManagerEmail);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function confirmAppointment(Appointment $appointment) {
    $language = $this->languageManager->getCurrentLanguage()->getId();

    $configuration = $this->roomConfigurationManager->getConfiguration($appointment->getAppointmentNode());
    $clientEmail = $appointment->getApplicantEMail();
    $roomManagerEmail = $configuration->getRoomManagerEmail();

    $subject = Html::escape($configuration->getConfirmedEmailSubject());
    $body = Html::escape($configuration->getConfirmedEmailBody());

    $params = [
      'subject' => $this->token->replace($subject, ['appointment' => $appointment]),
      'body' => $this->token->replace($body, ['appointment' => $appointment]),
    ];

    $this->mailManager->mail('appointments', 'confirm_appointment_client', $clientEmail, $language, $params, $roomManagerEmail);
  }

  /**
   * {@inheritdoc}
   */
  public function rejectAppointment(Appointment $appointment) {
    $language = $this->languageManager->getCurrentLanguage()->getId();

    $configuration = $this->roomConfigurationManager->getConfiguration($appointment->getAppointmentNode());
    $clientEmail = $appointment->getApplicantEMail();
    $roomManagerEmail = $configuration->getRoomManagerEmail();

    $subject = Html::escape($configuration->getRejectedEmailSubject());
    $body = Html::escape($configuration->getRejectedEmailBody());

    $params = [
      'subject' => $this->token->replace($subject, ['appointment' => $appointment]),
      'body' => $this->token->replace($body, ['appointment' => $appointment]),
    ];

    $this->mailManager->mail('appointments', 'reject_appointment_client', $clientEmail, $language, $params, $roomManagerEmail);
  }

  /**
   * @return string
   */
  protected function buildRoomManagerSubject() {
    return $this->t('A new request has been inserted, the requested date: [appointment:start]');
  }

  /**
   * Render Room manager email body.
   *
   * @param bool $show_acceptance_url
   *
   * @return \Drupal\Component\Render\MarkupInterface
   * @throws \Exception
   */
  protected function buildRoomManagerBody($show_acceptance_url = TRUE) {
    $build = [
      '#theme' => 'appointments_room_manager_email',
      '#show_acceptance_url' => $show_acceptance_url,
    ];
    $body = $this->renderer->render($build);

    return $body;
  }

}
