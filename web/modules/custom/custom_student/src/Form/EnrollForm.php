<?php

namespace Drupal\custom_student\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Url;



class EnrollForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['studentno'] = [
      '#type' => 'textfield',
      '#title' => $this->t('studentno'),
    ];

    // CheckBoxes.
    $form['studentname'] = [
      '#type' => 'textfield',
      
      '#title' => $this->t('student name'),
      '#description' => 'student name',
    ];
	$form['chapter'] = [
      '#type' => 'textfield',
      
      '#title' => $this->t('chaptername'),
      '#description' => 'chaptername',
    ];
	
  $form['status'] = array(
  '#type' => 'hidden',
  '#value' => 0,
);

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#description' => $this->t('Submit, #type = submit'),
    ];
	
	

    // Add a reset button that handles the submission of the form.
   
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_student.enroll_form';
  }
protected function getEditableConfigNames()
    {
        return [
        'custom_student.enroll',
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
