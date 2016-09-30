<?php
include ('api_constants.php');
include ('./refer/callAPI.php');

$volumename = $_POST['volumename'];
$diskofferingid = $_POST ['diskofferingid'];
$zoneid = $_POST ['zoneid'];

//echo $volumename."<br>".$diskofferingid."<br>".$zoneid."<br>";

$cmdArr = array (
		"command" => "createVolume",
		"name" => $volumename,
		"diskofferingid" => $diskofferingid,
		"zoneid" => $zoneid,
		"apikey" => API_KEY 
);

$productTypesByZone = callCommand ( URL, $cmdArr, SECERET_KEY );

$jobid = $productTypesByZone['jobid'];
echo 'createVolume후 jobid : '.$jobid."<br>";

do {
	$cmdArr2 = array(
			"command" => "queryAsyncJobResult",
			"jobid" => $jobid,
			"apikey"  => API_KEY
	);
	$result2 = callCommand(URL, $cmdArr2, SECERET_KEY);
	 
	$jobStatus = $result2["jobstatus"];
	if ($jobStatus == 2) {
		echo print_r($result2["jobresult"]);
		exit;
	}
} while ($jobStatus != 1);

 
?>

 