<?php
/**
 * Logging trait
 */
trait Loggingareas
{
	public function circle($radius) 
    {
		echo "logging circle area ". "<br>";
        echo 22/7*$radius*$radius. "<br>";
    }
	public function square($radius) 
    {
		echo "logging square area ". "<br>";
        echo $radius*$radius. "<br>";
    }
	public function rectangle($h1,$w1) 
    {
		echo "logging rectangle area ". "<br>";
        echo $h1*$w1. "<br>";
    }
	public function triangle($b,$h) 
    {
		echo "logging triangle area ". "<br>";
        echo 1/2*$b*$h. "<br>";
    }

}

class Areaclass {
use Loggingareas;

  public $height;
  public $width;

  public function __construct($height,$width) {
    $this->height = $height;
	$this->width = $width;
  }
  
  
}

$area = new Areaclass('1','2');
$h= $area->height;
$w=$area->width;
$area->circle($h);
$area->triangle($w,$h);
$area->rectangle($h,$w);
$area->square($h);
