<?php

namespace Drupal\custom_student\Services;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;

use Drupal\Core\Url;

class EnrollService  {

	public $value;




	 Public function savetocinfig($value)
	 { 
				
		$config = \Drupal::service('config.factory')->getEditable('custom_student.settings');
		foreach($value as $k=>$v){
		
		
			$config->set($k,$v)->save();


		  }
		  
	 }
	 
	 Public function savetoeditcinfig($value)
	 { 
			
		$config = \Drupal::service('config.factory')->getEditable('custom_student.settings');
		 $path = \Drupal::request()->getpathInfo();
	 $arg  = explode('/',$path);
 
	 //$uid =$_GET['uid']= \Drupal::request()->query->get('uid'); //echo $uid;exit;
	 
	 $uid=$arg[3];
		 $current_user = \Drupal::currentUser();
$roles = $current_user->getRoles();

$account = \Drupal\user\Entity\User::load($uid); // pass your uid
      $name = $account->getUsername();
     //$account->addRole('Teacher');
	 $roles=$account->getRoles();
	 //$account->removeRole('Teacher');
	 $roles=$account->getRoles();
		// print_r($roles);exit;



		foreach($value as $k=>$v){

if($value[$k]['status']==1)
		{
			 

$account->addRole('Student');
	 
		}
		if($value[$k]['status']==0)
		{
			 

$account->removeRole('Student');
	
		}
		else
		{
			$v=$v;
		}

$account->save();
			$config->set($k,$v)->save();


		  }
	 }

}
