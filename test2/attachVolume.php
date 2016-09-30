<?php
include ('api_constants.php');
include ('./refer/callAPI.php');
 
$volumeid = $_POST ['volumeid'];
$vmid = $_POST ['vmid'];

echo $volumeid."   ".$vmid."<br>";


$cmdArr = array (
		"command" => "attachVolume",
		"id" => "e6116c55-80f2-48f4-90f4-7804dbd013b5",
		"virtualmachineid" => "5896aad1-3d9f-4c16-aad7-8f77aeedcd39",
		"apikey" => API_KEY 
);

$productTypesByZone = callCommand ( URL, $cmdArr, SECERET_KEY );

$jobid = $productTypesByZone['jobid'];
echo 'attachVolume후 jobid : '.$jobid;

do {
	$cmdArr2 = array(
			"command" => "queryAsyncJobResult",
			"jobid" => $jobid,
			"apikey"  => API_KEY
	);
	
	$result2 = callCommand(URL, $cmdArr2, SECERET_KEY);
 
	$jobStatus = $result2["jobstatus"];
	if ($jobStatus == 2) {
		echo '<br>-------------------<br><pre>';
		echo print_r($result2["jobresult"]);
		echo '</pre>';
		exit;
	}
} while ($jobStatus != 1);


//header("Location:listVolumes.php");
 
?>

 