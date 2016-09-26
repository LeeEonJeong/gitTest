<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>

</head>
<body>
<?php
include('api_constants.php');
include ('./refer/callAPI.php');
include('var_dump_enter.php');
var_dump_enter($_POST);

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

if ($_POST['diskofferingid']=="rootonly"){ //diskofferingid안씀
	$cmdArr1 = array(
			"command" => "deployVirtualMachine",
			"serviceofferingid" => $_POST['serviceofferingid'],
			"templateid" => $_POST['templateid'],
			//    "diskofferingid" => $_POST['diskofferingid'],
	//    "productcode" => $_POST['productid'],
			"zoneid" => $_POST['zoneid'],
			"displayname" => "test",
			"usageplantype" => "hourly",
			"apikey" => API_KEY
	);
} else {
	$cmdArr1 = array(
	    "command" => "deployVirtualMachine",
	    "serviceofferingid" => $_POST['serviceofferingid'],
	    "templateid" => $_POST['templateid'],
	    "diskofferingid" => $_POST['diskofferingid'], 
	//    "productcode" => $_POST['productid'],
	    "zoneid" => $_POST['zoneid'],
	    "displayname" => 'test', //박음
	    "usageplantype" => "hourly", //default : hourly
	    "apikey" => API_KEY
	);
 
}

$result1 = callCommand($URL, $cmdArr1, SECERET_KEY);
 
$jobId = $result1["jobid"];
echo 'deployVM(cmdArr1) 후 jobid : '.$jobId; 
 
do {
  $cmdArr2 = array(
    "command" => "queryAsyncJobResult",
    "jobid" => $jobId,
    "apikey"  => API_KEY
  );
  $result2 = callCommand($URL, $cmdArr2, SECERET_KEY);
  sleep(5);
  $jobStatus = $result2["jobstatus"];
  if ($jobStatus == 2) {
     printf($result2["jobresult"]);
      exit;
  }
} while ($jobStatus != 1);

//--------------- (2)deployVirtualMachine 명령으로 VM 생성한다
//1(성공)로 나오게되면 
$vmid = $result1["id"];
$vmpwd = $result1["password"];

echo 'vmid = '.$vmid.'vmpwd = '.$vmpwd.'<br>'; 
//----------------(3)vm 생성완료 확인

$cmdArr3 = array(
		"command" => "listPublicIpAddresses",
	  	"account" => ACCOUNT,
		"apikey" => API_KEY
);

$result3 = callCommand($URL, $cmdArr3, SECERET_KEY);

$id = $result3['id']; // 공인 IP 주소 ID 
$ipaddress = $result3['ipaddress'];//공인 IP 주소 
echo '<br>id = '.$id.'ipadress = '.$ipaddress.'<br>';
//------------------(4) listPublicIpAddresses 명령으로 공인 IP 정보[id, ip주소] 확인한다. 

$cmdArr41 = array(
		"command" => "createPortForwardingRule",
		"ipaddressid" => $ipaddress,
		"privateport" => 22,
		"protocol" => "TCP",
		"publicport" => 22,
		"virtualmachineid" => $vmid,
		"apikey" => API_KEY
);
//-----------------------(5) createPortForwardingRule로 22번(ssh 접속포트) 외부 오픈 
$result41 = callCommand($URL, $cmdArr41, SECERET_KEY);

$jobId41 = $result41["jobid"];
echo '<br>createPortForwarding(cmdArr41) 후 jobid41 : '.$jobId.'<br>';

do {
	$cmdArr51 = array(
			"command" => "queryAsyncJobResult",
			"jobid" => $jobId41,
			"apikey"  => API_KEY
	);
	$result5 = callCommand($URL, $cmdArr51, SECERET_KEY);

	$jobStatus = $result5["jobstatus"];
	if ($jobStatus == 2) {
		printf($result5["jobresult"]);
		exit;
	}
} while ($jobStatus != 1);


//윈도우 경우만 오픈해야~~~ 일단 걍 함
$cmdArr42 = array(
		"command" => "createPortForwardingRule",
		"ipaddressid" => $ipaddress,
		"privateport" => 3389,
		"protocol" => "TCP",
		"publicport" => 3389,
		"virtualmachineid" => $vmid,
		"apikey" => API_KEY
);
//  (윈도우VM의 경우 mstsc 로 접속하는 3389 port를 외부 오픈) 
$result42 = callCommand($URL, $cmdArr42, SECERET_KEY);

$jobId42 = $result42["jobid"];
echo '<br>createPortForwarding(cmdArr42) 후 jobid42 : '.$jobId42.'<br>';

do {
	$cmdArr51 = array(
			"command" => "queryAsyncJobResult",
			"jobid" => $jobId41,
			"apikey"  => API_KEY
	);
	$result5 = callCommand($URL, $cmdArr51, SECERET_KEY);

	$jobStatus = $result5["jobstatus"];
	if ($jobStatus == 2) {
		printf($result5["jobresult"]);
		exit;
	}
} while ($jobStatus != 1);
//---------(6) queryAsyncJobResult 명령으로 포트포워딩 생성 완료 확인한다 - 
//응답 결과에서 ipaddress<publicIpAddress>, publicport, privateport 필드 확인
echo '<br>------------------------------<br>';
var_dump_enter($result41);
var_dump_enter($result42);
echo '<br>------------------------------<br>';
?>
</body>
</html>