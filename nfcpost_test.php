<?php 
$text="";
if(isset($_POST['value'])){
    $text = $_POST['value'];
   echo ("my name is $text");
}else{
   echo("nothing");

}
 ?>