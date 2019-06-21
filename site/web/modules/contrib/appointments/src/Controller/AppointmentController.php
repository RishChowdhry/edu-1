<?php

namespace Drupal\appointments\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\appointments\Entity\AppointmentInterface;

/**
 * Class AppointmentController.
 *
 *  Returns responses for Appointment routes.
 */
class AppointmentController extends ControllerBase {

  /**
   * Displays a Appointment  revision.
   *
   * @param int $appointment_revision
   *   The Appointment  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *   Thrown if the entity type doesn't exist.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   Thrown if the storage handler couldn't be loaded.
   */
  public function revisionShow($appointment_revision) {
    $appointment = $this->entityTypeManager()->getStorage('appointment')->loadRevision($appointment_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('appointment');

    return $view_builder->view($appointment);
  }

  /**
   * Page title callback for a Appointment  revision.
   *
   * @param int $appointment_revision
   *   The Appointment  revision ID.
   *
   * @return string
   *   The page title.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *   Thrown if the entity type doesn't exist.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   Thrown if the storage handler couldn't be loaded.
   */
  public function revisionPageTitle($appointment_revision) {
    $appointment = $this->entityTypeManager()->getStorage('appointment')->loadRevision($appointment_revision);
    return $this->t('Revision of %title from %date', ['%title' => $appointment->label(), '%date' => format_date($appointment->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Appointment .
   *
   * @param \Drupal\appointments\Entity\AppointmentInterface $appointment
   *   A Appointment  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *   Thrown if the entity type doesn't exist.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   Thrown if the storage handler couldn't be loaded.
   */
  public function revisionOverview(AppointmentInterface $appointment) {
    $account = $this->currentUser();
    $langcode = $appointment->language()->getId();
    $langname = $appointment->language()->getName();
    $languages = $appointment->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $appointment_storage = $this->entityTypeManager()->getStorage('appointment');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $appointment->label()]) : $this->t('Revisions for %title', ['%title' => $appointment->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all appointment revisions") || $account->hasPermission('administer appointment entities')));
    $delete_permission = (($account->hasPermission("delete all appointment revisions") || $account->hasPermission('administer appointment entities')));

    $rows = [];

    $vids = $appointment_storage->revisionIds($appointment);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\appointments\AppointmentInterface $revision */
      $revision = $appointment_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $appointment->getRevisionId()) {
          $link = $this->l($date, new Url('entity.appointment.revision', ['appointment' => $appointment->id(), 'appointment_revision' => $vid]));
        }
        else {
          $link = $appointment->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.appointment.translation_revert', ['appointment' => $appointment->id(), 'appointment_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.appointment.revision_revert', ['appointment' => $appointment->id(), 'appointment_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.appointment.revision_delete', ['appointment' => $appointment->id(), 'appointment_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['appointment_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
