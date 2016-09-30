<?php
 include ('./refer/callAPI.php');
 include ('api_constants.php');
 include('printArray.php');
 
 
 function getlistVMs(){
 	$cmdArr = array (
 			"command" => "listVirtualMachines",
 			"apikey" => API_KEY
 	);
 	
 	$result = callCommand(URL, $cmdArr, SECERET_KEY);
//  	echo '<pre>';
//  	echo print_r($result);
//  	echo '</pre>';
 	
 	return $result;
 } 
 
 function getVMs($condition, $value){ //condition은 비교할 조건(존같은), value는 비교할 값
 	$listVMs = getlistVMs();
    $vmCount= $listVMs['count'];
    $result = array();
    $resultIndex = 0;
    
    if($vmCount == 1){
    	if($vm['virtualmachine'][$condition] == $value ){
    		return vm['virtualmachine'];
    	}
    }else{
	 	for($i=0; $i<$vmCount; $i++){
	 		$vm = $listVMs['virtualmachine'][$i];

	 		if($vm[$condition] == $value){
	 			$result[$resultIndex++] = $vm;
	 		}
	 	}
 		return $result;
    }
 }
 
// myPrint(getlistVMs());
// myPrint(getVMs("zoneid",'95e2f517-d64a-4866-8585-5177c256f7c7'));
 
?>