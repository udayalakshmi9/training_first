<?php
namespace Drupal\custom_register\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;


class CustomregisterController  {

	public $user;
	public function display($user) {
			/**return [
			  '#type' => 'markup',
			  '#markup' => $this->t('Implement method: display with parameter(s): $name'),
			];*/
			//create table header
		  
		$results = \Drupal::service('config.factory')->getEditable('custom_register.settings')->get();
				
			
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


	
	
	public function edit($user)
	{
		$results = \Drupal::service('config.factory')->getEditable('custom_register.settings')->get();
		
	
		foreach($results as $k=>$data){
			
			if(is_array($results[$k]))
			{
			
			 
				  
				$edit   = Url::fromUserInput('/custom_form/form/change?uid='.$k);

			  //print the data from table
					 $rows[$k] = array(
					
						'username' => $results[$k]['username'],
						'password' =>$results[$k]['password'],
						'email' => $results[$k]['email'],
						

						 
						 \Drupal::l('Edit', $edit),
					);
			}
		   
		}
		
		 $myForm =  \Drupal::formBuilder()->getForm('Drupal\custom_register\Form\ChangeForm');
        $renderer = \Drupal::service('renderer');
        $myFormHtml = $renderer->render($myForm);

        return [
            '#markup' => Markup::create("
                <h2>My Form is Below</h2>
                {$myFormHtml}
                <h2>My Form is Above</h2>
            ")
			];
	}
}