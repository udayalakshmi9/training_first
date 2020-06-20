<?php

namespace Drupal\database_student\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\database_student\DatabaseStudentRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form to add a database entry, with all the interesting fields.
 *
 * @ingroup database_student
 */
class DatabaseStudentAddForm implements FormInterface, ContainerInjectionInterface {

  use StringTranslationTrait;
  use MessengerTrait;

  /**
   * Our database repository service.
   *
   * @var \Drupal\database_student\DatabaseStudentRepository
   */
  protected $repository;

  /**
   * The current user.
   *
   * We'll need this service in order to check if the user is logged in.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   *
   * We'll use the ContainerInjectionInterface pattern here to inject the
   * current user and also get the string_translation service.
   */
  public static function create(ContainerInterface $container) {
    $form = new static(
      $container->get('database_student.repository'),
      $container->get('current_user')
    );
    // The StringTranslationTrait trait manages the string translation service
    // for us. We can inject the service here.
    $form->setStringTranslation($container->get('string_translation'));
    $form->setMessenger($container->get('messenger'));
    return $form;
  }

  /**
   * Construct the new form object.
   */
  public function __construct(DatabaseStudentRepository $repository, AccountProxyInterface $current_user) {
    $this->repository = $repository;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'database_student_add_form';
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {

      if (empty($form_state->getValue('studentname'))) {
        $form_state->setErrorByName('studentname', $this->t('enter studentname.'));
      }
	  if (empty($form_state->getValue('studentno'))) {
        $form_state->setErrorByName('studentno', $this->t('enter password.'));
      }
	   if (empty($form_state->getValue('chapter'))) {
        $form_state->setErrorByName('chapter', $this->t('enter chapter.'));
      }
	  

    }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];

    $form['message'] = [
      '#markup' => $this->t('Add an entry to the database_student table.'),
    ];

    $form['add'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Add a person entry'),
    ];
    $form['add']['studentname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('studentname'),
      '#size' => 15,
    ];
    $form['add']['studentno'] = [
      '#type' => 'textfield',
      '#title' => $this->t('studentno'),
      '#size' => 15,
    ];
    $form['add']['status'] = [
      '#type' => 'textfield',
      '#title' => $this->t('status'),
      '#size' => 5,
      '#description' => $this->t("Values greater than 127 will cause an exception. Try it - it's a great example why exception handling is needed with DTBNG."),
    ];
	$form['add']['uid'] = [
      '#type' => 'hiden',
      '#title' => $this->t('uid'),
      '#size' => 5,
      '#description' => $this->t("Values greater than 127 will cause an exception. Try it - it's a great example why exception handling is needed with DTBNG."),
    ];
    $form['add']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add'),
    ];

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
    $account = $this->currentUser;
    // Save the submitted entry.
    $entry = [
      'studentname' => $form_state->getValue('studentname'),
      'studentno' => $form_state->getValue('studentno'),
      'chapter' => $form_state->getValue('chapter'),
	  'status' => $form_state->getValue('status'),
      'uid' => $account->id(),
    ];
    $return = $this->repository->insert($entry);
    if ($return) {
      $this->messenger()->addMessage($this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }
  }

}
