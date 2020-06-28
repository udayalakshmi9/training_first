<?php

namespace Drupal\database_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\database_form\DatabaseFormRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;
use Drupal\user\Entity\User;

use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Controller for DBTNG Example.
 *
 * @ingroup database_student
 */
class DatabaseFormController extends ControllerBase {

  /**
   * The repository for our specialized queries.
   *
   * @var \Drupal\database_student\DatabaseStudentRepository
   */
  protected $repository;
  public $user;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $controller = new static($container->get('database_form.repository'));
    $controller->setStringTranslation($container->get('string_translation'));
    return $controller;
  }

  /**
   * Construct a new controller.
   *
   * @param \Drupal\database_student\DatabaseStudentRepository $repository
   *   The repository service.
   */
  public function __construct(DatabaseFormRepository $repository) {
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
      $this->t('pid'),
    
      $this->t('firstname'),
      $this->t('lastname'),
      $this->t('bio'),
	  $this->t('interest'), 
	    $this->t('gender'),
		$this->t('link'),
    ];

	$results = $this->repository->load();

   
	
	
	$k1=array();
   $output=array();

    foreach($results as $k=>$data){

      $term_name = \Drupal\taxonomy\Entity\Term::load($results[$k]->interest)->get('name')->value;
	 
      if($results[$k]->gender ==1)
      {
		  
		  $edit   = Url::fromUserInput('/update');
          $output[] = [
		  'pid' => $results[$k]->pid,
		  'lastname' => $results[$k]->lastname,
          'firstname' => $results[$k]->firstname,     // 'userid' was the key used in the header
          'bio' => $results[$k]->bio, // 'Username' was the key used in the header
          'gender' => 'Male',
		 
          'interest' => $term_name,
          \Drupal::l('Edit', $edit),




         ];
      }
      if($results[$k]->gender ==0)
      {
		  
		 $edit   = Url::fromUserInput('/update');
          $output[] = [
		  'pid' => $results[$k]->pid,
		  'lastname' => $results[$k]->lastname,
          'firstname' => $results[$k]->firstname,     // 'userid' was the key used in the header
          'bio' => $results[$k]->bio, // 'Username' was the key used in the header
          'gender' => 'Female',
		  
          'interest' => $term_name,
          \Drupal::l('Edit', $edit),




         ];
      }





        array_push($k1,$output);
      //display data in site

    }

    $content['table'] = [
              '#type' => 'table',
              '#header' => $headers,
              '#rows' => $output,
              '#empty' => t('No users found'),
          ];
		  
          //return $content;
		  return new jsonResponse(
		  [
		  
		  'data' => $output,
		  'method' => 'GET'
		  ]
		  );
  }
  //}

  /**
   * Render a filtered list of entries in the database.
   */
 /* public fuenction entryAdvancedList() {
    $content = [];

    $content['message'] = [
      '#markup' => $this->t('A more complex list of entries in the database. Only the entries with name = "John" and age older than 18 years are shown, the username of the person who created the entry is also shown.'),
    ];

    $headers = [
      $this->t('pid'),
      $this->t('uid'),
      $this->t('studentname'),
      $this->t('studentno'),
      $this->t('chapter'),
	   $this->t('status'),
    ];

    $rows = [];
    foreach ($entries = $this->repository->advancedLoad() as $entry) {
      // Sanitize each entry.
      $rows[] = array_map('Drupal\Component\Utility\Html::escape', $entries);
    }
    $content['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#attributes' => ['id' => 'dbtng-example-advanced-list'],
      '#empty' => $this->t('No entries available.'),
    ];
    // Don't cache this page.
    //$content['#cache']['max-age'] = 0;
    return $content;
  }*/
  
  /*public function edit($user)
	{
		//$results = \Drupal::service('config.factory')->getEditable('custom_student.settings')->get();


		
		 $myForm =  \Drupal::formBuilder()->getForm('Drupal\database_student\Form\DatabasestudentUpdateForm');
        $renderer = \Drupal::service('renderer');
        $myFormHtml = $renderer->render($myForm);

        return [
            '#markup' => Markup::create("
                <h2>Student access edit form</h2>
                {$myFormHtml}

            ")
			];
	}*/

}
