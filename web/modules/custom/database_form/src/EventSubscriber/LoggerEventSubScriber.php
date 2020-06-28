<?php

/**
 * @file
 * Contains \Drupal\database_form\LoggerEventSubScriber.
 */

namespace Drupal\database_form\EventSubscriber;

use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\database_form\LoggerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/**
 * Class LoggerEventSubScriber.
 *
 * @package Drupal\database_form
 */
class LoggerEventSubScriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[ConfigEvents::SAVE][] = array('onSavingConfig', 800);
    $events[LoggerEvent::SUBMIT][] = array('doSomeAction', 800);
    return $events;

  }

  /**
   * Subscriber Callback for the event.
   * @param ExampleEvent $event
   */
  public function doSomeAction(LoggerEvent $event) {
	 //print_r($event);exit;
\Drupal::logger('database_form')->info($event->first_name);
 
   drupal_set_message("The Example Event has been subscribed, which has bee dispatched on submit of the form with " . $event->first_name. " as Reference");
  }

  /**
   * Subscriber Callback for the event.
   * @param ConfigCrudEvent $event
   */
  public function onSavingConfig(ConfigCrudEvent $event) {
    drupal_set_message("You have saved a configuration of " . $event->getConfig()->getName());
  }
}
