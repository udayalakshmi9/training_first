<?php

namespace Drupal\database_student\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\database_student\DbtngExampleRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Sample UI to update a record.
 *
 * @ingroup database_student
 */
class DatabaseStudentUpdateForm extends FormBase {

  /**
   * Our database repository service.
   *
   * @var \Drupal\database_student\DatabaseStudentRepository
   */
  protected $repository;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'database_student_update_form';
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $form = new static($container->get('database_student.repository'));
    $form->setStringTranslation($container->get('string_translation'));
    $form->setMessenger($container->get('messenger'));
    return $form;
  }

  /**
   * Construct the new form object.
   */
  public function __construct(DatabaseStudentRepository $repository) {
    $this->repository = $repository;
  }

  /**
   * Sample UI to update a record.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Wrap the form in a div.
    $form = [
      '#prefix' => '<div id="updateform">',
      '#suffix' => '</div>',
    ];
    // Add some explanatory text to the form.
    $form['message'] = [
      '#markup' => $this->t('Demonstrates a database update operation.'),
    ];
    // Query for items to display.
    $entries = $this->repository->load();
    // Tell the user if there is nothing to display.
    if (empty($entries)) {
      $form['no_values'] = [
        '#value' => $this->t('No entries exist in the table database_student table.'),
      ];
      return $form;
    }

    $keyed_entries = [];
    $options = [];
    foreach ($entries as $entry) {
      $options[$entry->pid] = $this->t('@pid: @studentname @studentno @chapter (@status)', [
        '@pid' => $entry->pid,
        '@studentname' => $entry->studentname,
        '@studentno' => $entry->studentno,
        '@status' => $entry->status,
		'@chapter' => $entry->chapter,
      ]);
      $keyed_entries[$entry->pid] = $entry;
    }

    // Grab the pid.
    $pid = $form_state->getValue('pid');
    // Use the pid to set the default entry for updating.
    $default_entry = !empty($pid) ? $keyed_entries[$pid] : $entries[0];

    // Save the entries into the $form_state. We do this so the AJAX callback
    // doesn't need to repeat the query.
    $form_state->setValue('entries', $keyed_entries);

    $form['pid'] = [
      '#type' => 'select',
      '#options' => $options,
      '#title' => $this->t('Choose entry to update'),
      '#default_value' => $default_entry->pid,
      '#ajax' => [
        'wrapper' => 'updateform',
        'callback' => [$this, 'updateCallback'],
      ],
    ];

    $form['studentname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated student name'),
      '#size' => 15,
      '#default_value' => $default_entry->studentname,
    ];

    $form['studentno'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated last name'),
      '#size' => 15,
      '#default_value' => $default_entry->studentno,
    ];
    $form['status'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated status'),
      '#size' => 4,
      '#default_value' => $default_entry->status,
      '#description' => $this->t('Values greater than 127 will cause an exception'),
    ];
	 $form['chapter'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Updated chapter'),
      '#size' => 4,
      '#default_value' => $default_entry->chapter,
      '#description' => $this->t('Values greater than 127 will cause an exception'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update'),
    ];
    return $form;
  }

  /**
   * AJAX callback handler for the pid select.
   *
   * When the pid changes, populates the defaults from the database in the form.
   */
  public function updateCallback(array $form, FormStateInterface $form_state) {
    // Gather the DB results from $form_state.
    $entries = $form_state->getValue('entries');
    // Use the specific entry for this $form_state.
    $entry = $entries[$form_state->getValue('pid')];
    // Setting the #value of items is the only way I was able to figure out
    // to get replaced defaults on these items. #default_value will not do it
    // and shouldn't.
    foreach (['studentname', 'studentno', 'status', 'chapter'] as $item) {
      $form[$item]['#value'] = $entry->$item;
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
 

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Gather the current user so the new record has ownership.
    $account = $this->currentUser();
    // Save the submitted entry.
    $entry = [
      'pid' => $form_state->getValue('pid'),
      'studentname' => $form_state->getValue('studentname'),
      'studentno' => $form_state->getValue('studentno'),
      'status' => $form_state->getValue('status'),
	  'chapter' => $form_state->getValue('chapter'),
      'uid' => $account->id(),
    ];
    $count = $this->repository->update($entry);
    $this->messenger()->addMessage($this->t('Updated entry @entry (@count row updated)', [
      '@count' => $count,
      '@entry' => print_r($entry, TRUE),
    ]));
  }

}
