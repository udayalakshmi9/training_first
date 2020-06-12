<?php

namespace Drupal\custom_register\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Url;

class RegisterForm extends ConfigFormBase {

  public function getFormId() {
    return 'custom_register_register_form';
  }


  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['username'] = [
       '#type' => 'textfield',
      '#title' => $this->t('username'),
      '#description' => $this->t('Email, #type = textfield'),
      
    ];

    // Email.
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Email, #type = email'),
    ];
	 // password.
   
   // Password.
    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#description' => 'Password, #type = password',
    ];

   
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ],
    ];

    return $form;
  }
  
  protected function getEditableConfigNames()
    {
        return [
        'custom_register.register',
        ];
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
	   

    }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Find out what was submitted.
    $values = $form_state->getValues();
	$a=array();$b=array();
	
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
		//$a[]= array('%title' => $label, '%value' => $display_value);
		
		
		


    
      }
    }
	  foreach ($values as $key => $value) {
	  if ($key=='username' || $key== 'email' || $key =='password')
	  {
		  array_push($a, $key);
		  array_push($b, $value);
	  }
	  }
	  $uuid_service = \Drupal::service('uuid');
$uuid = $uuid_service->generate();
	//$myuid = uniqid('gfg');
	$c = array_combine($a, $b);
	$d=array('id'=>'');
	
	$d=array($uuid=>
		$c);
	
	
	//$d= array($uuid[$c]);
	$config = \Drupal::service('custom_register.register')->savetocinfig($d);
  }

}
