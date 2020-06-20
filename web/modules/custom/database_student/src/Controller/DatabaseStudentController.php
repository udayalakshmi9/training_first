<?php

namespace Drupal\database_student\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\database_student\DatabaseStudentRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;
use Drupal\user\Entity\User;
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
      $this->t('pid'),
      $this->t('uid'),
      $this->t('studentname'),
      $this->t('studentno'),
      $this->t('chapter'),
	   
	    $this->t('status'),
		$this->t('link'),
    ];
//print_r($this->repository);exit;

$results = $this->repository->load();
//echo"<pre>";//print_r($entries);exit;
   
	
	
	$k1=array();
   $output=array();

    foreach($results as $k=>$data){

      
//print_r($results[$k]);exit;
      if($results[$k]->status ==1)
      {
		  
		  $edit   = Url::fromUserInput('/update/'.$results[$k]->uid);
          $output[] = [
		  'pid' => $results[$k]->pid,
		  'uid' => $results[$k]->uid,
          'studentname' => $results[$k]->studentname,     // 'userid' was the key used in the header
          'studentno' => $results[$k]->studentno, // 'Username' was the key used in the header
          'chapter' => $results[$k]->chapter,
		  
          'status' => 'Granted',
          \Drupal::l('Edit', $edit),




         ];
      }
      if($results[$k]->status ==0)
      {
		  
		 $edit   = Url::fromUserInput('/update/'.$results[$k]->uid);
          $output[] = [
          'pid' => $results[$k]->pid,
		  'uid' => $results[$k]->uid,
          'studentname' => $results[$k]->studentname,     // 'userid' was the key used in the header
          'studentno' => $results[$k]->studentno, // 'Username' was the key used in the header
          'chapter' => $results[$k]->chapter,
		  
          'status' => 'Notgranted',
          \Drupal::l('Edit', $edit),




         ];
      }



//print_r($output);exit;

        array_push($k1,$output);
      //display data in site

    }
//print_r($k1);exit;
    $content['table'] = [
              '#type' => 'table',
              '#header' => $headers,
              '#rows' => $output,
              '#empty' => t('No users found'),
          ];
          return $content;

  }
  //}

  /**
   * Render a filtered list of entries in the database.
   */
  public function entryAdvancedList() {
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
  }
  
  public function edit($user)
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
	}

}
