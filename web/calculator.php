<?php  
  
interface CaculatorInterface { 
   public  function add($a,$b); 
   public  function subtract($d,$e); 
   public  function multiply($f,$g); 
   public  function divide($l,$m); 
}  
  
class MyCalucaltor implements CaculatorInterface{ 
   public $height;
  public $width;
    public function add($a,$b){ 
        $c=$a+$b;
		echo "This is an example of class and interface functions <br> <br>";
		echo "addition of  $a , $b is " .$c. "<br>"; 
	}
  
    public function subtract($d,$e){ 
        $k=$d-$e;
		echo "subtraction  of  $d  - $e is " .$k. "<br>"; 
    } 
	public function multiply($f,$g){ 
		$i=$f*$g;
		echo "multiplication  of  $f * $g is " .$i. "<br>"; 
    } 
  
    public function divide($l,$m){ 
        $j=$l/$m;
		echo "division  of  $l / $m is " .$j. "<br>"; 
    } 
}  
  
$obj = new MyCalucaltor; 
$obj->add(1,2); 
$obj->subtract(8,1); 
$obj->multiply(5,6); 
$obj->divide(8,2); 



 
  
?> 