<?php
namespace Drupal\custom_students\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;


class CustomstudentsController  {

	public $user;
	public function display($user) {
			/**return [
			  '#type' => 'markup',
			  '#markup' => $this->t('Implement method: display with parameter(s): $name'),
			];*/
			//create table header
		 // $uid = \Drupal::currentUser()->id();
		$results = \Drupal::service('config.factory')->getEditable('custom_student.settings')->get();


		foreach($results as $k=>$data){

			if(is_array($results[$k]))
			{

				$edit   = Url::fromUserInput('/custom_form/form/change?uid='.$k);


				 $rows[$k] = array(

					'username' => $results[$k]['username'],
					'password' =>$results[$k]['password'],
					'email' => $results[$k]['email'],



					 \Drupal::l('Edit', $edit),
				);
			}

		}


			return array(
			'#theme'=>'user_list',
			'#users'=>$rows[$user],
			'#uid'=>$user,

			);


	}



}
