<?php

namespace Drupal\custom_form\Plugin\Block;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "customform_block",
 *   admin_label = @Translation("customform block"),
 *   category = @Translation("Hello World"),
 * )
 */
class CustomformBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
	  
	  
    $config = $this->getConfiguration();

    if (!empty($config['hello_block_name'])) {
      $name = $config['hello_block_name'];
	  $type= $config['hello_block_type'];
	  $time = date('Y/M/D h:i:sa');
	  
	 

    }
    else {
      $name = $this->t('to no one');
    }

    return [
      '#markup' => $this->t('Hello @name @type  @time  !', [
        '@name' => $name,
		'@type' => $type,
		'@time' => $time
		
      ]),
    ];
  }
  
   public function defaultConfiguration() {
    $default_config = \Drupal::config('custom_default.settings');
    return [
      'hello_block_name' => $default_config->get('hello.username'),
	   'hello_block_type' => $default_config->get('hello.type')
    ];
  }
/**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['hello_block_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => isset($config['hello_block_name']) ? $config['hello_block_name'] : '',
    ];

    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['hello_block_name'] = $values['hello_block_name'];
  }
}