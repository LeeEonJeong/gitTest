<?php
// !/usr/bin/php -q
include 'callAPI.php';

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

// Creating Server account api/secret key lists

$acct = array (
		"abc@kt.com\n" 
);

$serverName = array (
		"DB1-server",
		"DB2-server",
		"DB3-server",
		"DB4-server",
		"DB5-server",
		"DB6-server",
		"DB7-server",
		"DB8-server",
		"DB9-server",
		"DB10-server" 
);

$apikey = "asdf3DPclPu4s1qB9KGAQjUzl9nvzwat09YzxrhbKgmA";
$secret = "qwexyTfOjSldRRXz5Hxd2T8ymKVuXkdfttRYemALgGtA";
$etitle = " Report: server deploy info";
$content = "";

for($i = 0; $i < count ( $serverName ); $i ++) {
	$conetnt = "";
	$cmdArr = array (
			"command" => "deployVirtualMachine",
			"serviceofferingid" => "260fafb7-16a2-4c61-894c-3cc9861e603e",
			"templateid" => "db5de456-df00-4d38-8a32-fc3821ecebac",
			"zoneid" => "9845bd17-d438-4bde-816d-1b12f37d5080",
			"diskofferingid" => "d1109077-fe57-48a9-be27-22c1d928c2e9",
			"usageplantype" => "monthly",
			"displayname" => $serverName [$i],
			"apikey" => $apikey 
	);
	
	$result = callCommand ( $URL, $cmdArr, $secret );

	sleep ( 7 );
	
	$jobId = $result ["jobid"];
	
	do {
		
		$cmdArr2 = array (
				
				"command" => "queryAsyncJobResult",
				
				"jobid" => $jobId,
				
				"apikey" => $apikey 
		)
		;
		
		$result2 = callCommand ( $URL, $cmdArr2, $secret );
		
		sleep ( 5 );
		
		$jobStatus = $result2 ["jobstatus"];
		
		if ($jobStatus == 2) {
			
			printf ( $result2 ["jobresult"] );
			
			exit ();
		}
	} while ( $jobStatus != 1 );
	
	print_r ( $result2 );
	
	$content .= $result2 ["jobresult"] ["virtualmachine"] ["displayname"];
	
	$content .= "\n";
	
	$content .= $result2 ["jobresult"] ["virtualmachine"] ["password"];
	
	$content .= "\n";
	
	$content .= $result2 ["jobresult"] ["virtualmachine"] ["nic"] ["ipaddress"];
	
	$content .= "\n\n";
	
	$check1 = mail ( "injung.kim@kt.com", $etitle, $content, "" );
	
	$check2 = mail ( "cse2.kt@gmail.com", $etitle, $content, "" );
}

if ($check1 && check2) {
	
	echo " vm report sent";
	
	$fname = "vmReport";
	
	$fp = fopen ( "./" . $fname, 'w+' );
	
	fwrite ( $fp, $content );
	
	fclose ( $fp );
} else {
	
	echo " vm report did not send";
}

?>