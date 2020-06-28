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
  public function userlist()
  {
	 /* $urls = 'http://localhost/drupal/oauth/token';
		$method1 = 'POST';
		$options1 = [
		'grant_type' => 'password',
		'client_id'=>'d218cb6d-bd2f-4c68-93a2-36d966abc220',
		'client_secret'=>'12345',
		'username'=>'udaya',
		'password'=>'12345',
		

		];
		
		
		$clients = \Drupal::httpClient();

		$response1 = $clients->request($method1, $urls, $options1);
		print_r($response1);exit;*/

		
		$token='Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImFkMTQ5NmFiM2VmZmNlYjMzMmRmMjkzOGJjNDllY2YzM2M0MzRhZDZhNDlhNDRlMWFlMzVlNmIyMjZkODE5NTgzYzRmMGM2YjVkMWMxYmJhIn0.eyJhdWQiOiJkMjE4Y2I2ZC1iZDJmLTRjNjgtOTNhMi0zNmQ5NjZhYmMyMjAiLCJqdGkiOiJhZDE0OTZhYjNlZmZjZWIzMzJkZjI5MzhiYzQ5ZWNmMzNjNDM0YWQ2YTQ5YTQ0ZTFhZTM1ZTZiMjI2ZDgxOTU4M2M0ZjBjNmI1ZDFjMWJiYSIsImlhdCI6MTU5MzMzNzU1NiwibmJmIjoxNTkzMzM3NTU2LCJleHAiOjE1OTMzNDA1NTUsInN1YiI6IjMiLCJzY29wZXMiOlsiYXV0aGVudGljYXRlZCIsImNsaWVudCJdfQ.UhwGqZYv5vKgZb6Js5FADPPLFQFJ8QcJ6sAwDlZy3u4AuWIb75L7uKdpHHvtSZmg3AWOP-Ngcx13ko_dfpHcYqO3SpsV-IpzDgWmuqPvX5Oaz5epIZ308bSHogOSSFEUrdkj4UQB9I1jFPYuEN_5dJgMnhWkjeUAk7DOQa3jWeSMkSVedhxJlLZz6FV7MeRxLr5pZMUQ2HIspEnb5eUGcGNIvVGaXsLOvaDEKaaRU7aL2I5-FH-SLXyLh0PG9fe8L_9X2WeZ_TEDuZnmbr4FXa0NOVlGiZxKebTL__c1RENZTKfgDeyJ6Ya_GnN6uyaQGHFrFdZamuXUOMmPKdnTaA';
		$url = 'http://localhost/drupal/dashboardlist';
		$method = 'GET';
		$options = [
		'access_token' => $token

		];

		$client = \Drupal::httpClient();

		$response = $client->request($method, $url, $options);

		//print_r($response);
		$code = $response->getStatusCode();

		if ($code == 200) {
		$body = $response->getBody()->getContents();
		}
		return $response;
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
