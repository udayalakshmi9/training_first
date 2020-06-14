<?php

namespace Drupal\custom_student\Services;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EnrollService  {

	public $value;




	 Public function savetocinfig($value)
	 { 
			
		$config = \Drupal::service('config.factory')->getEditable('custom_student.settings');
		foreach($value as $k=>$v){
if($k=='status')
{
	$value['status']=0;
}
else
{
	$v=$v;
}
			$config->set($k,$v)->save();


		  }
	 }
	 
	 Public function savetoeditcinfig($value)
	 { 
			
		$config = \Drupal::service('config.factory')->getEditable('custom_student.settings');
		foreach($value as $k=>$v){



			$config->set($k,$v)->save();


		  }
	 }

}
