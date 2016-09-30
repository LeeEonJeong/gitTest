<?php
include ('api_constants.php');
include ('./refer/callAPI.php');
include ('var_dump_enter.php');

$volumeid = $_POST ['volumeid'];
 
echo $volumeid .'   '.$vmid;

$cmdArr = array (
		"command" => "deleteVolume",
		"id" => $volumeid,
		"apikey" => API_KEY 
);

$productTypesByZone = callCommand ( URL, $cmdArr, SECERET_KEY ); 

if($productTypesByZone['success']){
	header("Location:listVolumes.php");
}else{
	echo 'volume 삭제 실패';
}
 
?>
