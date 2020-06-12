<?php

namespace Drupal\custom_register\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Url;


use Symfony\Component\HttpFoundation\RedirectResponse;


class ChangeForm extends ConfigFormBase {

	public  $uid;

	public function getFormId() {
	return 'custom_register_change_form';
	}

	protected function getEditableConfigNames()
	{
		return [
		'custom_register.display',
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
		$record = \Drupal::service('config.factory')->getEditable('custom_register.settings')->get($uid);
		}
	$config = \Drupal::service('config.factory')->getEditable('custom_register.settings');


	$form['username'] = [
		'#type' => 'textfield',
		'#title' => $this->t('username'),
		'#description' => $this->t('Email, #type = textfield'),
		'#default_value' => (isset($record['username']) && $uid) ? $record['username']:'',

		];

    // Email.
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Email, #type = email'),
	   '#default_value' => (isset($record['email']) && $uid) ? $record['email']:'',
    ];
	 // password.
   
   // Password.
    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
	  
      '#description' => 'Password, #type = password',
	  '#default_value' => (isset($record['password']) && $uid) ? $record['password']:'',
    ];

   

	$form['uid'] = [
       '#type' => 'textfield',
      '#title' => $this->t('uid'),
      '#description' => $this->t('uid, #type = textfield'),
	   '#default_value' => $uid,
      
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

      if (empty($form_state->getValue('username'))) {
        $form_state->setErrorByName('username', $this->t('enter username.'));
      }
	  if (empty($form_state->getValue('password'))) {
        $form_state->setErrorByName('password', $this->t('enter password.'));
      }
	   if (empty($form_state->getValue('email'))) {
        $form_state->setErrorByName('email', $this->t('enter email.'));
      }
	   if (empty($form_state->getValue('uid'))) {
        $form_state->setErrorByName('username', $this->t('enter uid.'));
      }

    }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
	   
    $d=array();
	
	
	$field=$form_state->getValues();
    $username=$field['username'];
    
    $password=$field['password'];
    $email=$field['email'];
	$id=$field['uid'];
    
	$config = \Drupal::service('config.factory')->getEditable('custom_register.settings');
		   
		
          $field  = array(
              'username'   => $username,
              'password' =>  $password,
              'email' =>  $email,
              
          );
	  
	
	$d=array($id=>
		$field);
		
		
		$config = \Drupal::service('custom_register.register')->savetoeditcinfig($d);	
			
     }
 
}
