<?php

namespace Drupal\custom_student\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Url;
use Drupal\Component\Render\FormattableMarkup; 



class TableForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $results = \Drupal::service('config.factory')->getEditable('custom_student.settings')->get();

    // Add a submit button that handles the submission of the form.
    $header = [
     'studentname' => t('studentname'),
     'studentno' => t('studentno'),
     'chapter' => t('chapter'),
	 'status'=>t('status'),
	 'edit'=>t('link'),
   ];
	
// Initialize an empty array
$output = array();$k1=array();

// Next, loop through the $results array
foreach ($results as $k=>$result) {
	if($results[$k]['status']==1)
	{
		$results[$k]['status']='granted';
	}
	if($results[$k]['status']==0)
	{
		$results[$k]['status']='notgranted';
	}
	$edit   = Url::fromUserInput('/student/edit/'.$k);
	
	//'edit' => l(t('Edit'),'/student/edit/'.$k,
array('#type' => 'link', '#title' => t('link title'), '#href' => 'student/edit/'.$k);


 
  
	
     $output[$result->uid] = [
         'studentname' => $results[$k]['studentname'],     // 'userid' was the key used in the header
         'studentno' => $results[$k]['studentno'], // 'Username' was the key used in the header
         'chapter' => $results[$k]['chapter'],  
 'status' => $results[$k]['status'],
\Drupal::l('Edit', $edit),




       ];
	   array_push($k1,$output[$result->uid]);
	   
	   
	   
     }
	  $form['table'] = [
'#type' => 'tableselect',
'#header' => $header,
'#options' => $k1,
'#empty' => t('No users found'),
];
   
    // Add a reset button that handles the submission of the form.
   
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_student.table_form';
  }
protected function getEditableConfigNames()
    {
        return [
        'custom_student.table_form',
        ];
	}
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Find out what was submitted.
	$a=array();
	$b=array();$c=array();
    $values = $form_state->getValues();
    foreach ($values as $key => $value) {
      $label = isset($form[$key]['#title']) ? $form[$key]['#title'] : $key;

      // Many arrays return 0 for unselected values so lets filter that out.
      if (is_array($value)) {
        $value = array_filter($value);
      }

      // Only display for controls that have titles and values.
      if ($value && $label) {
        $display_value = is_array($value) ? preg_replace('/[\n\r\s]+/', ' ', print_r($value, 1)) : $value;
        $message = $this->t('Value for %title: %value', ['%title' => $label, '%value' => $display_value]);
        $this->messenger()->addMessage($message);
      }
    }
	
	$uid = \Drupal::currentUser()->id();
	foreach ($values as $key => $value) {
			if ($key=='studentname' || $key== 'studentno' || $key =='chapter' || $key == 'status')
			{
				
			  array_push($a, $key);
			  array_push($b, $value);
			}
		}
		 
			
			$c = array_combine($a, $b);
			$d=array('id'=>'');

	$d=array($uid=>
			$c);
	
	
	//$d= array($uuid[$c]);
	$config = \Drupal::service('custom_student.enroll')->savetocinfig($d);
	 drupal_set_message("Access request submitted succesfully for ".$uid);
  }

}
