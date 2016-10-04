<?php
include ('api_constants.php');
include ('./refer/callAPI.php');
include ('printArray.php');
 
$cmdArr = array (
		"command" => "listAccounts",	 
		"apikey" => API_KEY 
); 

$result = callCommand ( URL, $cmdArr, SECERET_KEY );

myPrint($result);

?>