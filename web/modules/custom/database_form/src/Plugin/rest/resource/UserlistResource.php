<?php

namespace Drupal\database_form\Plugin\rest\resource;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Provides a Userlist Resource
 *
 * @RestResource(
 *   id = "userlist_resource",
 *   label = @Translation("UserlistResource"),
 *   uri_paths = {
 *     "canonical" = "/api/userslist"
 *   }
 * )
 */

class UserlistResource extends ResourceBase {

 
  public function get() {
    $database = \Drupal::database();
		$query = $database->query("SELECT * FROM taxonomyform ");
		$results = $query->fetchAll();
   
	
	 return new jsonResponse(
		  [
		  
		  'data' => $results,
		  'method' => 'GET'
		  ]
		  );
  }
}

