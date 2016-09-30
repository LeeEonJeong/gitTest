<?php
include ('api_constants.php');
include ('./refer/callAPI.php');
include ('var_dump_enter.php');
var_dump_enter ( $_POST );

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

$cmdArr = array (
		"command" => "createVolume",
		"name" => $_POST ['name'],
		"diskofferingid" => $_POST ['diskofferingid'],
		//"productcode" => $_POST ['productcode'],
		"zoneid" =>$_POST['zoneid']
);


$result1 = callCommand ( $URL, $cmdArr1, SECERET_KEY );

$jobId = $result1 ["jobid"];
echo 'deployVM(cmdArr1) 후 jobid : ' . $jobId;

do {
	$cmdArr2 = array (
			"command" => "queryAsyncJobResult",
			"jobid" => $jobId,
			"apikey" => API_KEY 
	);
	$result2 = callCommand ( $URL, $cmdArr2, SECERET_KEY );
	sleep ( 5 );
	$jobStatus = $result2 ["jobstatus"];
	if ($jobStatus == 2) {
		printf ( $result2 ["jobresult"] );
		exit ();
	}
} while ( $jobStatus != 1 );

// --------------- (2)deployVirtualMachine 명령으로 VM 생성한다
// 1(성공)로 나오게되면
$vmid = $result2 ["jobresult"] ["virtualmachine"] ["id"];
$vmpwd = $result2 ["jobresult"] ["virtualmachine"] ["password"];

$vmname = $result2 ["jobresult"] ["virtualmachine"] ["displayname"];
$account = $result2 ["jobresult"] ["virtualmachine"] ["account"];
$zonename = $result2 ["jobresult"] ["virtualmachine"] ["zonename"];

echo '<br>vmid = ' . $vmid . '<br>vmpwd = ' . $vmpwd . '<br> vmname = ' . $vmname . '<br>';
?>