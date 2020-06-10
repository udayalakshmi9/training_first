<?php

trait messaging
{
	protected $_logger = null;
	public function message1() 
    {
		
        
		$t="The function message1 is hitted on  " . date("Y/m/d"). "at time " . date("h:i:sa"). "<br>";
		echo $t;
    }
	public function message2() 
    {
		
        
		$t="The function message2 is hitted on  " . date("Y/m/d"). "at time " . date("h:i:sa"). "<br>";
		echo $t;
    }
	function log($level, $time)
    {
        echo $level."-----".$time  . "<br>";
		
    }
	public function setLogger( array $logger) 
    {
        $this->_logger = $logger;
    }

	

}
/**
 * Hello World
 */
class HelloWorld
{
    use messaging;

    /**
     * Run the hello world
     */
    public function run()
    {
        $this->log("info", "running");
        echo "Hello World!\n";
        $this->log("info", "done");
    }
}




$t="The function is hitted on  " . date("Y/m/d"). "at time " . date("h:i:sa"); "<br>";

$logger = array('level'=>'running',
'time'=>$t);



$hw = new HelloWorld;
$hw->setLogger($logger);
$hw->run();

$hw->log("started","info");
$hw->message1();
$hw->log("stopped","done");
$hw->log("started","info");
$hw->message2();
$hw->log("stopped","done");