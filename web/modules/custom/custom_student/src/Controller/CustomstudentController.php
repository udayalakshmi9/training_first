<?php
namespace Drupal\custom_student\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\Markup;


class CustomstudentController  {

	
	
	public function display() {
			
		$c=array();$x=array();
		$results = \Drupal::service('config.factory')->getEditable('custom_student.settings')->get();


		foreach($results as $k=>$data){

			if(is_array($results[$k]))
			{

				$edit   = Url::fromUserInput('/student/edit/'.$k);


	

				 $rows[$k] = array(

					'studentname' => $results[$k]['studentname'],
					'studentno' =>$results[$k]['studentno'],
					'chapter' => $results[$k]['chapter'],

					

					 \Drupal::l('Edit', $edit),
				);
}
if($results[$k]['status']==1)
{
	

				 $rows[$k] = array(

					'studentname' => $results[$k]['studentname'],
					'studentno' =>$results[$k]['studentno'],
					'chapter' => $results[$k]['chapter'],

'status'=>'granted',

					 \Drupal::l('Edit', $edit),
				);
}
if($results[$k]['status']==0)
{
	

				 $rows[$k] = array(

					'studentname' => $results[$k]['studentname'],
					'studentno' =>$results[$k]['studentno'],
					'chapter' => $results[$k]['chapter'],

'status'=>'granted',

					 \Drupal::l('Edit', $edit),
				);
}
				
				
			}
			
			//array_push($h,$rows[$]);

		
		$p=array();
		foreach ($rows as $kc)
		{
			//echo $rows[$ca]['studentname'];
			foreach($kc as $keyd=>$l)
			{
				echo"<tr>";
				//echo $l['studentname'];
				//echo $kc[$keyd]['studentname'];
				
				//print_r($l);
				array_push($p,$l);
				echo"</tr>";
			}
			
		}


    $output = array(
      '#theme' => 'user_list',    // Here you can write #type also instead of #theme.
     
      '#users' => $p,
    );
    return $output;


			/*return array(
			'#theme'=>'user_list',
			'#users'=>$p,
			);*/


	}

public function edit($user)
	{
		$results = \Drupal::service('config.factory')->getEditable('custom_student.settings')->get();


		foreach($results as $k=>$data){

			if(is_array($results[$k]))
			{



				$edit   = Url::fromUserInput('/custom_form/form/change?uid='.$k);

			  //print the data from table
					 $rows[$k] = array(

						'studentname' => $results[$k]['studentname'],
						'studentno' =>$results[$k]['studentno'],
						'chapter' => $results[$k]['chapter'],
'status' => $results[$k]['status'],


						 \Drupal::l('Edit', $edit),
					);
			}

		}

		 $myForm =  \Drupal::formBuilder()->getForm('Drupal\custom_student\Form\ChangeForm');
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
