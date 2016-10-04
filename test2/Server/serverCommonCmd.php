<?php
session_start ();
include ('../api_constants.php');
include '../refer/callAPI.php';

function callSyncCmd($command, $vmid) {
	$cmdArr = array (
			"command" => $command,
			"id" =>$vmid,
			"apikey" => $_SESSION ['userapikey'] 
	);
	
	return callCommand ( URL, $cmdArr, $_SESSION ['usersecretkey'] );
}

function callASyncCmd($command, $vmid) {
	$jobid = callSyncCmd ( $command , $vmid) ['jobid'];
	
	do {
		$cmdArr = array (
				"command" => "queryAsyncJobResult",
				"jobid" => $jobId,
				"apikey" => $_SESSION ['userapikey'] 
		);
		
		$result = callCommand ( $URL, $cmdArr2, SECERET_KEY );
		sleep ( 5 );
		$jobStatus = $result ["jobstatus"];
		if ($jobStatus == 2) {
			printf ( $result ["jobresult"] );
			exit ();
		}
	} while ( $jobStatus != 1 );
	
	return true;
}


?>
	