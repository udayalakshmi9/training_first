<?php

namespace Drupal\database_form\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\database_form\DatabaseFormRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\database_form\LoggerEvent;
/**
 * Form to add a database entry, with all the interesting fields.
 *
 * @ingroup database_form
 */
class DatabaseFormAddForm implements FormInterface, ContainerInjectionInterface {

  use StringTranslationTrait;
  use MessengerTrait;

  /**
   * Our database repository service.
   *
   * @var \Drupal\database_form\DatabaseFormRepository
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
      $container->get('database_form.repository'),
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
  public function __construct(DatabaseFormRepository $repository, AccountProxyInterface $current_user) {
    $this->repository = $repository;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'database_form_add_form';
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {

      if (empty($form_state->getValue('firstname'))) {
        $form_state->setErrorByName('firstname', $this->t('enter firstname.'));
      }
	  if (empty($form_state->getValue('lastname'))) {
        $form_state->setErrorByName('lastname', $this->t('enter lastname.'));
      }
	   if (empty($form_state->getValue('bio'))) {
        $form_state->setErrorByName('bio', $this->t('enter bio.'));
      }
	  

    }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = [];

    $form['message'] = [
      '#markup' => $this->t('Add an entry to the taxonomyform table.'),
    ];
    //$keys = \Drupal::service('config.factory')->listAll($prefix = "system");
	//print_r ($keys);exit;
    $form['add'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Taxonomy form'),
    ];
    $form['add']['firstname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('firstname'),
      '#size' => 40,
    ];
    $form['add']['lastname'] = [
      '#type' => 'textfield',
      '#title' => $this->t('lastname'),
      '#size' => 40,
    ];
	  $form['add']['bio'] = [
      '#type' => 'textfield',
      '#title' => $this->t('bio'),
      '#size' => 40,
    ];
     $form['add']['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Access gender'),
      '#description' => $this->t('Radios, #type = radios'),
	  
      '#options' => [1 => 'Female', 0 => 'Male'],
	  

    ];
	
		$database = \Drupal::database();
		$query = $database->query("SELECT tid,name FROM taxonomy_term_field_data WHERE vid = 'interest' ");
		$results = $query->fetchAll();

			//$results = db_query("SELECT tid, name FROM taxonomy_term_field_data WHERE vid = 'interest' ")->fetchAll();

			$options1 = array();$v=0;
			$a=array();$b=array();$c=array();
			foreach($results  as $key=>$value){
			
			
				array_push($a,$results[$v]->tid);
				array_push($b,$results[$v]->name);
				
				$v++;
			}
			$c=array_combine($a,$b);
			//print_r($c);exit;
			//print_r($options1);exit;
			$form['add']['interest'] = array(
			'#type' => 'select',
			'#title' => t('Click on your interset'),
			
			'#options' =>$c,
			'#description' => t('Click on one or more cities.'),
			);
	
		$form['add']['submit'] = [
		  '#type' => 'submit',
		  '#value' => $this->t('Add'),
		  
		   '#ajax' => [
        'callback' => '::addCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
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
    /*$account = $this->currentUser;
    // Save the submitted entry.
    $entry = [
      'firstname' => $form_state->getValue('firstname'),
      'lastname' => $form_state->getValue('lastname'),
      'gender' => $form_state->getValue('gender'),
	  'bio' => $form_state->getValue('bio'),
      'interest' => $form_state->getValue('interest'),
    ];
    $return = $this->repository->insert($entry);
    if ($return) {
      $this->messenger()->addMessage($this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }*/
  }
  
  
  public function addCallback(array &$form, FormStateInterface $form_state) {
    // Gather the current user so the new record has ownership.
	// $account = $this->currentUser;
    // Save the submitted entry.
    $entry = [
      'firstname' => $form_state->getValue('firstname'),
      'lastname' => $form_state->getValue('lastname'),
      'gender' => $form_state->getValue('gender'),
	  'bio' => $form_state->getValue('bio'),
      'interest' => $form_state->getValue('interest'),
    ];
	 $return = $this->repository->insert($entry);
	 
	 
	$dispatcher = \Drupal::service('event_dispatcher');
    $event = new LoggerEvent($form_state->getValue('firstname'));
    $dispatcher->dispatch(LoggerEvent::SUBMIT, $event);
	
	//$message=$this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]);

	//\Drupal::logger('database_form')->info($message);

	//\Drupal::logger('database_form')->error($message);*/

	
   
	
	$response = new AjaxResponse();
    if ($return) {
      $this->messenger()->addMessage($this->t('Created entry @entry', ['@entry' => print_r($entry, TRUE)]));
    }
	return $response;
  }

}
