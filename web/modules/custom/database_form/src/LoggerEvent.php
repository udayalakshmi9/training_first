<?php

namespace Drupal\database_form;

use Symfony\Component\EventDispatcher\Event;


class LoggerEvent extends Event {

  const SUBMIT = 'event.submit';

  public $first_name;

  public function __construct($firstname)
  {
    $this->first_name = $firstname;
  }

 

 
}