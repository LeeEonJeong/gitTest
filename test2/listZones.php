<?php
include ('./refer/callAPI.php');
include ('api_constants.php');
 

	function getlistZones(){
		$cmdArr = array (
				"command" => "listZones",
				"apikey" => API_KEY
		);
		
		$result = callCommand(URL, $cmdArr, SECERET_KEY);
		 
		return $result['zone'];
	} 
?>