<?php
 echo 'while�� : ';
 $value = 5;
 while($value>0) {
 	echo $value . '';
 	$value--;
 }
 
 echo'<br>do~while�� : ';
 $value=5;
 do{
 	echo $value . '';
 	$value--;
 }while($value >10);
 
 echo '<br>foreach�� : ';
 $fruit = array('apple' => 2000, 'orange' => 1000, 'grape' => 2000);
 foreach ($fruit as $one => $two){
 	echo $one . '��' . $two . '��';
 }
  
?>