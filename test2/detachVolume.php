<?php
include ('api_constants.php');
include ('./refer/callAPI.php');
include ('var_dump_enter.php');

$volumeid = $_POST ['volumeid'];
$vmid = $_POST ['vmid'];

$cmdArr = array (
		"command" => "detachVolume",
		"id" => $volumeid,
		"apikey" => API_KEY 
);

$productTypesByZone = callCommand ( URL, $cmdArr, SECERET_KEY );

$jobid = $productTypesByZone['jobid'];

echo $jobid.'  jobid입니다.<br>'; 

do {
	$cmdArr2 = array(
			"command" => "queryAsyncJobResult",
			"jobid" => $jobid,
			"apikey"  => API_KEY
	);
	$result2 = callCommand(URL, $cmdArr2, SECERET_KEY);
 
	$jobStatus = $result2["jobstatus"];
	if ($jobStatus == 2) {
		printf($result2["jobresult"]);
		exit;
	}
} while ($jobStatus != 1);

//josbStatus==1이 됬다는 건 성공

header("Location:listVolumes.php");
 
?>

 