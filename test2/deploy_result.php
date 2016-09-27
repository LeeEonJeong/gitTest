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
			"displayname" => "winserver",
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
	    "displayname" => 'winserver', //박음
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
$vmid = $result2["jobresult"]["virtualmachine"]["id"];
$vmpwd = $result2["jobresult"]["virtualmachine"]["password"];

$vmname = $result2["jobresult"]["virtualmachine"]["displayname"];
$account = $result2["jobresult"]["virtualmachine"]["account"];
$zonename = $result2["jobresult"]["virtualmachine"]["zonename"];

echo '<br>vmid = '.$vmid.'<br>vmpwd = '.$vmpwd.'<br> vmname = '.$vmname.'<br>'; 
//----------------(3)vm 생성완료 확인

$cmdArr3 = array(
		"command" => "listPublicIpAddresses",
	  	//"account" => $account,
		"apikey" => API_KEY
);

$result3 = callCommand($URL, $cmdArr3, SECERET_KEY);

for($i=0; $i< count($result3); $i++){
	if($zonename == $result3["publicipaddress"][$i]["zonename"]){
		$ipaddressid = $result3["publicipaddress"][$i]["id"]; // 공인 IP 주소 ID 
		$ipaddress = $result3["publicipaddress"][$i]['ipaddress'];//공인 IP 주소 
		echo '<br>id = '.$ipaddressid.'<br>ipaddress = '.$ipaddress.'<br>';
	}
}
//------------------(4) listPublicIpAddresses 명령으로 공인 IP 정보[id, ip주소] 확인한다. 

$cmdArr41 = array(
		"command" => "createPortForwardingRule",
		"ipaddressid" => $ipaddressid,
		"privateport" => "22",
		"protocol" => "TCP",
		"publicport" => "22",
		"virtualmachineid" => $vmid,
		"apikey" => API_KEY
);
//-----------------------(5) createPortForwardingRule로 22번(ssh 접속포트) 외부 오픈 
$result41 = callCommand($URL, $cmdArr41, SECERET_KEY);

$jobId41 = $result41["jobid"];

echo '<br>createPortForwarding(cmdArr41) 후 jobid41 : '.$jobId41.'<br>';

do {
	$cmdArr51 = array(
			"command" => "queryAsyncJobResult",
			"jobid" => $jobId41,
			"apikey"  => API_KEY
	);
	$result51 = callCommand($URL, $cmdArr51, SECERET_KEY);

	$jobStatus = $result51["jobstatus"];
	if ($jobStatus == 2) {
		printf($result51["jobresult"]);
		exit;
	}
} while ($jobStatus != 1);


$privateport = $result51["jobresult"]["portforwardingrule"]["privateport"];//포트 포워딩 규칙의 개인 포트 범위의 시작 포트
$privateendport= $result51["jobresult"]["portforwardingrule"]["privateendport"];
$publicport = $result51["jobresult"]["portforwardingrule"]["publicport"];//포트 포워딩 규칙의 공개 포트 범위의 시작 포트
$publicendport = $result51["jobresult"]["portforwardingrule"]["publicendport"];
$virtualmachinedisplayname = $result51["jobresult"]["portforwardingrule"]["virtualmachinedisplayname"];//포트 포워딩 규칙에 대한 VM 의 표시 이름
$virtualmachinename = $result51["jobresult"]["portforwardingrule"]["virtualmachinename"]; //포트 포워딩 규칙에 대한 VM 의 이름
$ipaddress = $result51["jobresult"]["portforwardingrule"]["ipaddress"];//포트 포워딩 규칙에 대한 공인 IP 주소
$state = $result51["jobresult"]["portforwardingrule"]["state"];//규칙의 상태
echo '<br> 포트포워딩 규칙에 대한 공인 IP 주소 ipaddress : '.$ipaddress.'<br>';
echo '<br>publiceport : '.$publicport." ~ ".$publicendport.'<br>';
echo '<br>privateport : '.$privateport." ~ ".$privateendport.'<br>';

$cmdArrFirewall = array(
		"command" => "createFirewallRule ",
		"ipaddressid" => $ipaddressid,
		"protocol" => "TCP",
		"startport" => "22",
		"endport" => "22",
		"apikey" => API_KEY
);


$resultFirewall = callCommand($URL, $cmdArrFirewall, SECERET_KEY);
$jobidFirewall = $resultFirewall["jobid"];

do {
	$cmdArrFirewallAsync = array(
			"command" => "queryAsyncJobResult",
			"jobid" => $jobidFirewall,
			"apikey"  => API_KEY
	);
	$resultFirewallAsync = callCommand($URL, $cmdArrFirewallAsync, SECERET_KEY);

	$jobStatus = $resultFirewallAsync["jobstatus"];
	if ($jobStatus == 2) {
		printf($resultFirewallAsync["jobresult"]);
		exit;
	}
} while ($jobStatus != 1);

$protocol = $resultFirewallAsync["jobresult"]["firewall"]["protocol"]; 
$startport= $resultFirewallAsync["jobresult"]["firewall"]["startport"];
$endport = $resultFirewallAsync["jobresult"]["firewall"]["endport"]; 
$state = $resultFirewallAsync["jobresult"]["firewall"]["state"];
$cidrlist = $resultFirewallAsync["jobresult"]["firewall"]["cidrlist"]; 
 
echo '<br>'.$protocol.'/ startport : '.$startport.' / endport : '.$endport.' / state : '.$state.'cidrlist : '.$cidrlist.'<br>';
 
 
//---------(6) queryAsyncJobResult 명령으로 포트포워딩 생성 완료 확인한다 - 응답 결과에서 ipaddress<publicIpAddress>, publicport, privateport 필드 확인 
 

// //윈도우 경우만 오픈해야~~~ 일단 걍 함
// $cmdArr42 = array(
// 		"command" => "createPortForwardingRule",
// 		"ipaddressid" => $ipaddressid,
// 		"privateport" => "3389",
// 		"protocol" => "TCP",
// 		"publicport" => "3389",
// 		"virtualmachineid" => $vmid,
// 		"apikey" => API_KEY
// );
// //  (윈도우VM의 경우 mstsc 로 접속하는 3389 port를 외부 오픈) 
// $result42 = callCommand($URL, $cmdArr42, SECERET_KEY);

// $jobId42 = $result42["jobid"];
// echo '<br>createPortForwarding(cmdArr42) 후 jobid42 : '.$jobId42.'<br>';

// do {
// 	$cmdArr52 = array(
// 			"command" => "queryAsyncJobResult",
// 			"jobid" => $jobId42,
// 			"apikey"  => API_KEY
// 	);
// 	$result52 = callCommand($URL, $cmdArr52, SECERET_KEY);

// 	$jobStatus = $result52["jobstatus"];
// 	if ($jobStatus == 2) {
// 		printf($result52["jobresult"]);
// 		exit;
// 	}
// } while ($jobStatus != 1);

// $privateport = $result52["jobresult"]["portforwardingrule"]["privateport"];//포트 포워딩 규칙의 개인 포트 범위의 시작 포트
// $privateendport= $result52["jobresult"]["portforwardingrule"]["privateendport"];
// $publicport = $result52["jobresult"]["portforwardingrule"]["publicport"];//포트 포워딩 규칙의 공개 포트 범위의 시작 포트
// $publicendport = $result52["jobresult"]["portforwardingrule"]["publicendport"];
// $virtualmachinedisplayname = $result52["jobresult"]["portforwardingrule"]["virtualmachinedisplayname"];//포트 포워딩 규칙에 대한 VM 의 표시 이름
// $virtualmachinename = $result52["jobresult"]["portforwardingrule"]["virtualmachinename"]; //포트 포워딩 규칙에 대한 VM 의 이름
// $ipaddress = $result52["jobresult"]["portforwardingrule"]["ipaddress"];//포트 포워딩 규칙에 대한 공인 IP 주소
// $state = $result52["jobresult"]["portforwardingrule"]["state"];//규칙의 상태

// //---------(6) queryAsyncJobResult 명령으로 포트포워딩 생성 완료 확인한다 - 응답 결과에서 ipaddress<publicIpAddress>, publicport, privateport 필드 확인
// echo '<br> 포트포워딩 규칙에 대한 공인 IP 주소 ipaddress : '.$ipaddress.'<br>';
// echo '<br>publiceport : '.$publicport." ~ ".$publicendport.'<br>';
// echo '<br>privateport : '.$privateport." ~ ".$privateendport.'<br>';

 ?>
 
 </body>
 </html>
 