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
$stopcmdArr = array(
    "command" => "stopVirtualMachine",
    "id" => $_POST['id'],
    "apikey" => API_KEY
);
var_dump_enter($stopcmdArr);
$seceret_key = SECERET_KEY;
$productTypesByZone = callCommand($URL, $stopcmdArr, $seceret_key);
sleep(1);
$jobId = $productTypesByZone["jobid"];
echo $jobId;
/*
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
*/
?>
</body>
</html>