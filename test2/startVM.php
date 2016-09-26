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
$startcmdArr = array(
    "command" => "startVirtualMachine",
    "id" => $_POST['id'],
    "apikey" => API_KEY
);
var_dump_enter($startcmdArr);
$seceret_key = SECERET_KEY;
$result = callCommand($URL, $startcmdArr, $seceret_key);
sleep(1);
$jobId = $result["jobid"];
echo $jobId;

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

?>
</body>
</html>