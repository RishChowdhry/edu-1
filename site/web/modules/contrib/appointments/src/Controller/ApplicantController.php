<?php

namespace Drupal\appointments\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\appointments\Entity\ApplicantInterface;

/**
 * Class ApplicantController.
 *
 *  Returns responses for Applicant routes.
 */
class ApplicantController extends ControllerBase {

  /**
   * Displays a Applicant  revision.
   *
   * @param int $applicant_revision
   *   The Applicant  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *   Thrown if the entity type doesn't exist.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   Thrown if the storage handler couldn't be loaded.
   */
  public function revisionShow($applicant_revision) {
    $applicant = $this->entityTypeManager()->getStorage('applicant')->loadRevision($applicant_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('applicant');

    return $view_builder->view($applicant);
  }

  /**
   * Page title callback for a Applicant  revision.
   *
   * @param int $applicant_revision
   *   The Applicant  revision ID.
   *
   * @return string
   *   The page title.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *   Thrown if the entity type doesn't exist.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   Thrown if the storage handler couldn't be loaded.
   */
  public function revisionPageTitle($applicant_revision) {
    $applicant = $this->entityTypeManager()->getStorage('applicant')->loadRevision($applicant_revision);
    return $this->t('Revision of %title from %date', ['%title' => $applicant->label(), '%date' => format_date($applicant->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Applicant .
   *
   * @param \Drupal\appointments\Entity\ApplicantInterface $applicant
   *   A Applicant  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *   Thrown if the entity type doesn't exist.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   Thrown if the storage handler couldn't be loaded.
   */
  public function revisionOverview(ApplicantInterface $applicant) {
    $account = $this->currentUser();
    $langcode = $applicant->language()->getId();
    $langname = $applicant->language()->getName();
    $languages = $applicant->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $applicant_storage = $this->entityTypeManager()->getStorage('applicant');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $applicant->label()]) : $this->t('Revisions for %title', ['%title' => $applicant->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all applicant revisions") || $account->hasPermission('administer applicant entities')));
    $delete_permission = (($account->hasPermission("delete all applicant revisions") || $account->hasPermission('administer applicant entities')));

    $rows = [];

    $vids = $applicant_storage->revisionIds($applicant);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\appointments\ApplicantInterface $revision */
      $revision = $applicant_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $applicant->getRevisionId()) {
          $link = $this->l($date, new Url('entity.applicant.revision', ['applicant' => $applicant->id(), 'applicant_revision' => $vid]));
        }
        else {
          $link = $applicant->link($date);
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
              Url::fromRoute('entity.applicant.translation_revert', ['applicant' => $applicant->id(), 'applicant_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.applicant.revision_revert', ['applicant' => $applicant->id(), 'applicant_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.applicant.revision_delete', ['applicant' => $applicant->id(), 'applicant_revision' => $vid]),
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

    $build['applicant_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
