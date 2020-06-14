<?php

namespace Drupal\custom_student\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Url;


use Symfony\Component\HttpFoundation\RedirectResponse;


class ChangeForm extends ConfigFormBase {

	public  $uid;

	public function getFormId() {
	return 'custom_student_change_form';
	}

	protected function getEditableConfigNames()
	{
		return [
		'custom_student.display',
		];
	}
  public function buildForm(array $form, FormStateInterface $form_state) {
	  
	  
     $record = array();
	
	 //echo $uid;
	 $path = \Drupal::request()->getpathInfo();
	 $arg  = explode('/',$path);
 
	 //$uid =$_GET['uid']= \Drupal::request()->query->get('uid'); //echo $uid;exit;
	 
	 $uid=$arg[3];
	 if ($uid) {
		$record = \Drupal::service('config.factory')->getEditable('custom_student.settings')->get($uid);
		}
	$config = \Drupal::service('config.factory')->getEditable('custom_student.settings');


	$form['studentname'] = [
		'#type' => 'textfield',
		'#title' => $this->t('studentname'),
		'#description' => $this->t('studentname, #type = textfield'),
		'#default_value' => (isset($record['studentname']) && $uid) ? $record['studentname']:'',

		];

    // Email.
    $form['studentno'] = [
      '#type' => 'textfield',
      '#title' => $this->t('studentno'),
      '#description' => $this->t('studentno, #type = textfield'),
	   '#default_value' => (isset($record['studentno']) && $uid) ? $record['studentno']:'',
    ];
	 // password.
   
   // Password.
    $form['chapter'] = [
      '#type' => 'textfield',
      '#title' => $this->t('chapter'),
	  
      '#description' => $this->t('chapter, #type = textfield'),
	  '#default_value' => (isset($record['chapter']) && $uid) ? $record['chapter']:'',
    ];

   

	$form['uid'] = [
       '#type' => 'textfield',
      '#title' => $this->t('uid'),
      '#description' => $this->t('uid, #type = textfield'),
	   '#default_value' => $uid,
      
    ];
	
    $form['status'] = [
      '#type' => 'radios',
      '#title' => $this->t('Access Status'),
      '#description' => $this->t('Radios, #type = radios'),
	  
      '#options' => [1 => 'Granted', 0 => 'Notgranted'],
	  '#default_value' => $record[status],

    ];

	
	 
	
    
	
   
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
		
        '#value' => $this->t('Submit'),
      ],
    ];
//$form['field_ref_to_xxxxxx']['uid']['#attributes']['readonly'] = TRUE;
    return $form;
  }
   public function validateForm(array &$form, FormStateInterface $form_state) {

      if (empty($form_state->getValue('studentno'))) {
        $form_state->setErrorByName('studentno', $this->t('enter studentno.'));
      }
	  if (empty($form_state->getValue('studentname'))) {
        $form_state->setErrorByName('studentname', $this->t('enter studentno.'));
      }
	   if (empty($form_state->getValue('chapter'))) {
        $form_state->setErrorByName('chapter', $this->t('enter chapter.'));
      }
	   if (empty($form_state->getValue('uid'))) {
        $form_state->setErrorByName('username', $this->t('enter uid.'));
      }

    }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
	   
    $d=array();
	
	
	$field=$form_state->getValues();
    $studentno=$field['studentno'];
    
    $studentname=$field['studentname'];
    $chapter=$field['chapter'];
	$id=$field['uid'];
	$status=$field['status'];
    
	$config = \Drupal::service('config.factory')->getEditable('custom_student.settings');
		   
		
          $field  = array(
              'studentno'   => $studentno,
              'studentname' =>  $studentname,
              'chapter' =>  $chapter,
			  'status'=>$status,
              
          );
	  
	
	$d=array($id=>
		$field);
		
		
		$config = \Drupal::service('custom_student.enroll')->savetoeditcinfig($d);	
		  drupal_set_message("succesfully granted the permission updated");	
     }
 
}
