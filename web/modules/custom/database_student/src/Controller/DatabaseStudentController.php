<?php

namespace Drupal\database_student\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\database_student\DatabaseStudentRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for DBTNG Example.
 *
 * @ingroup database_student
 */
class DatabaseStudentController extends ControllerBase {

  /**
   * The repository for our specialized queries.
   *
   * @var \Drupal\database_student\DatabaseStudentRepository
   */
  protected $repository;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $controller = new static($container->get('database_student.repository'));
    $controller->setStringTranslation($container->get('string_translation'));
    return $controller;
  }

  /**
   * Construct a new controller.
   *
   * @param \Drupal\database_student\DatabaseStudentRepository $repository
   *   The repository service.
   */
  public function __construct(DatabaseStudentRepository $repository) {
    $this->repository = $repository;
  }

  /**
   * Render a list of entries in the database.
   */
  public function entryList() {
    $content = [];

    $content['message'] = [
      '#markup' => $this->t('Generate a list of all entries in the database. There is no filter in the query.'),
    ];

    $rows = [];
    $headers = [
      $this->t('Id'),
      $this->t('uid'),
      $this->t('studentname'),
      $this->t('studentno'),
      $this->t('chapter'),
	   $this->t('status'),
    ];

    foreach ($entries = $this->repository->load() as $entry) {
      // Sanitize each entry.
      $rows[] = array_map('Drupal\Component\Utility\Html::escape', (array) $entry);
    }
    $content['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => $this->t('No entries available.'),
    ];
    // Don't cache this page.
    $content['#cache']['max-age'] = 0;

    return $content;
  }

  /**
   * Render a filtered list of entries in the database.
   */
  public function entryAdvancedList() {
    $content = [];

    $content['message'] = [
      '#markup' => $this->t('A more complex list of entries in the database. Only the entries with name = "John" and age older than 18 years are shown, the username of the person who created the entry is also shown.'),
    ];

    $headers = [
      $this->t('Id'),
      $this->t('uid'),
      $this->t('studentname'),
      $this->t('studentno'),
      $this->t('chapter'),
	   $this->t('status'),
    ];

    $rows = [];
    foreach ($entries = $this->repository->advancedLoad() as $entry) {
      // Sanitize each entry.
      $rows[] = array_map('Drupal\Component\Utility\Html::escape', $entry);
    }
    $content['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#attributes' => ['id' => 'dbtng-example-advanced-list'],
      '#empty' => $this->t('No entries available.'),
    ];
    // Don't cache this page.
    $content['#cache']['max-age'] = 0;
    return $content;
  }

}
