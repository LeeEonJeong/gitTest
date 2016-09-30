<?php

$test1 = array("first"=>array("a","b","c"), "second"=>"eonjeong");

$test2 = array("first"=>"lee", "second"=>"eonjeong");
$test3 = array("first"=>"lee", "second"=>"eonjeong");
$test4 = array("first"=>"lee", "second"=>"eonjeong");
$test5 = array("first"=>"lee", "second"=>"eonjeong");
$test6 = array("first"=>"lee", "second"=>"eonjeong");


$productTypesByZone = array($test1, $test2, $test3, $test4, $test5);

// for($i=0; $i<count($result); $i++){
// 	echo $result[$i];
// 	echo '<br>';
// 	echo $result[$i]['first'];
// 	echo '<br>';
// }

echo '<pre>';
echo print_r($productTypesByZone);
echo '</pre>';

printArray($productTypesByZone);

function printArray($array){
	foreach($array as $x => $x_value){
		if(is_array($x_value)){
			printArray($x_value);
		}
		else{
			echo $x." : ".$x_value."<br>";
		}
	}
}

?>