<?php

include('api_constants.php');
include ('./refer/callAPI.php');
include('var_dump_enter.php');
 
$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

$vmid = "c545eb01-5538-4778-a6d6-9ec4937d6231";
$ipaddressid = "465e6db6-7b44-4ea4-9ab2-b4ff6c616494";

$cmdArr = array(
		"command" => "createPortForwardingRule",
		"ipaddressid" => $ipaddressid,
		"privateport" => 22,
		"protocol" => "TCP",
		"publicport" => "5000",
		"virtualmachineid" => $vmid,
		"apikey" => API_KEY
);
//-----------------------(5) createPortForwardingRule로 22번(ssh 접속포트) 외부 오픈
 $result = callCommand($URL, $cmdArr, SECERET_KEY);
 $jobid = $result["jobid"];
 
do {
 	$cmdArr = array(
 			"command" => "queryAsyncJobResult",
 			"jobid" => $jobid,
 			"apikey"  => API_KEY
 	);
 	$result2 = callCommand($URL, $cmdArr, SECERET_KEY);
 
 	$jobStatus = $result2["jobstatus"];
 	if ($jobStatus == 2) {
 		printf($result2["jobresult"]);
 		exit;
 	}
} while ($jobStatus != 1);
 
 
 
?>