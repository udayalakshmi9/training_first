<?php

namespace Drupal\custom_register\Services;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegisterService  {

	public $value;




	 Public function savetocinfig($value)
	 { 
			
		$config = \Drupal::service('config.factory')->getEditable('custom_register.settings');
		foreach($value as $k=>$v){

			$config->set($k,$v)->save();


		  }
	 }
	 
	 Public function savetoeditcinfig($value)
	 { 
			
		$config = \Drupal::service('config.factory')->getEditable('custom_register.settings');
		foreach($value as $k=>$v){

			$config->set($k,$v)->save();


		  }
	 }

}
