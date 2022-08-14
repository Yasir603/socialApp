<?php


 class students{
    public $name;

    function __construct($name){
      $this->name = $name;

    }

    function __destruct(){
      echo "  Simple Classes with Objects";

      echo "\n";
      echo " my name is {$this->name}";
    }

 }
 $x = new students("yasir");

 interface subjects{
     public function marks();
 }

 class  math      implements subjects{
   public function marks(){
     echo "70";

   }
 }

 class  physics   implements subjects{
   public function marks(){
     echo "80";
   }
 }

 class  biology   implements subjects{
   public function marks(){
     echo "60";
   }
 }

 class  chemistry implements subjects{
   public function marks(){
     echo "90";
   }
 }

 $math      = new math();
 $physics   = new physics();
 $biology   = new biology();
 $chemistry = new chemistry();

 $Subject = array($math,$physics,$biology,$chemistry);

 foreach($Subject as  $Subjects){

   echo  "\n";
   $Subjects->marks();
 }



  abstract class Car {
  public $name;
  public function __construct($name) {
    $this->name = $name;
  }
  abstract public function intro() : string;
}

echo  "\n";

// Parent class


// Child classes
class Audi extends Car {

 public function intro() : string {
   return "Choose German quality! I'm an $this->name!";
 }
}

class Volvo extends Car {
 public function intro() : string {
   return "Proud to be Swedish! I'm a $this->name!";
 }
}

class Citroen extends Car {
 public function intro() : string {
   return "French extravagance! I'm a $this->name!";
 }
}

// Create objects from the child classes
$audi = new audi("Audi");
echo $audi->intro();
echo  "\n";

$volvo = new volvo("Volvo");
echo $volvo->intro();
echo  "\n";

$citroen = new citroen("Citroen");
echo $citroen->intro();
echo  "\n";

?>
