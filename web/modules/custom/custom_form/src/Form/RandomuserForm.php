<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;

class RandomuserForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_api_example_ajax_color_demo';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
	  
	  $form['user_name'] = array(
  '#type' => 'textfield',
  '#title' => 'Username',
  '#description' => 'Please enter in a username',
  '#ajax' => array(
    // Function to call when event on form element triggered.
    'callback' => 'Drupal\ajax_example\Form\AjaxExampleForm::usernameValidateCallback',
    // Effect when replacing content. Options: 'none' (default), 'slide', 'fade'.
    'effect' => 'fade',
    // Javascript event to trigger Ajax. Currently for: 'onchange'.
    'event' => 'change',
    'progress' => array(
      // Graphic shown to indicate ajax. Options: 'throbber' (default), 'bar'.
      'type' => 'throbber',
      // Message to show along progress graphic. Default: 'Please wait...'.
      'message' => NULL,
    ),
  ),
);

$form['random_user'] = array(
  '#type' => 'button',
  '#value' => 'Random Username',
  '#ajax' => array(
    'callback' => '\custom_form\Form\RandomuserForm::randomUsernameCallback',
    'event' => 'click',
    'progress' => array(
      'type' => 'throbber',
      'message' => 'Getting Random Username',
    ),
    
  ),
);
  }
 
public function randomUsernameCallback(array &$form, FormStateInterface $form_state) {
  // Get all User Entities.
  $all_users = entity_load_multiple('user');
  
  // Remove Anonymous User.
  array_shift($all_users);
  
  // Pick Random User.
  $random_user = $all_users[array_rand($all_users)];
 
  // Instantiate an AjaxResponse Object to return.
  $ajax_response = new AjaxResponse();
  
  // ValCommand does not exist, so we can use InvokeCommand.
  $ajax_response->addCommand(new InvokeCommand('#edit-user-name', 'val' , array($random_user->get('name')->getString())));
  
  // ChangedCommand did not work.
  //$ajax_response->addCommand(new ChangedCommand('#edit-user-name', '#edit-user-name'));
  
  // We can still invoke the change command on #edit-user-name so it triggers Ajax on that element to validate username.
  $ajax_response->addCommand(new InvokeCommand('#edit-user-name', 'change'));
  
  // Return the AjaxResponse Object.
  return $ajax_response;
}
}