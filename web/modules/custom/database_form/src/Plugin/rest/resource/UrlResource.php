<?php

namespace Drupal\database_form\Plugin\rest\resource;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Provides a Url Resource
 *
 * @RestResource(
 *   id = "url_resource",
 *   label = @Translation("UrlResource"),
 *   uri_paths = {
 *     "canonical" = "/database_form/url_resource"
 *   }
 * )
 */

class UrlResource extends ResourceBase {

 
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

