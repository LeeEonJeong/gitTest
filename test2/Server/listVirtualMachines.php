<?php
 session_start();
 
 include ('../api_constants.php');
 include('../printArray.php');
 
 
 function getlistVMs(){
 	$cmdArr = array (
 			"command" => "listVirtualMachines",
 			"apikey" => $_SESSION['userapikey']
 	);
 	
 	
 	$result = callCommand(URL, $cmdArr, $_SESSION['usersecretkey']);
 	
 	return $result;
 } 
 
 function getVMs($condition, $value){ //condition은 비교할 조건(존같은), value는 비교할 값
 	$listVMs = getlistVMs();
    $vmCount= $listVMs['count'];
    $result = array();
    $resultIndex = 0;
    
    if($vmCount == 1){
    	if($listVMs['virtualmachine'][$condition] == $value ){
    		return $listVMs['virtualmachine'];
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
 
//myPrint(getlistVMs());
// myPrint(getVMs('name','eonjeongserver'));
 
?>