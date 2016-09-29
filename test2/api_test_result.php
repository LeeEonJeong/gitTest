<?php
session_write_close();
session_start();
require_once("../lib/KTOpenApiHandler.php");

// api id
$api_id = $_POST['id'];
// 발급받은 개발자 KEY
$auth_key = $_POST["auth_key"];
// 발급받은 개발자 API_SECRET
$auth_secret = $_POST["auth_secret"];
/*
echo $api_id."<br>";
echo $auth_key."<br>";
echo $auth_secret."<br>";
*/
$params = array();
if ($_POST["param"]) {
	foreach($_POST["param"] as $k => $v) {
		//echo "key=".$k.", value=".$v;
		$params[$k] = $v;
	}
} 

if ($api_id == "gwFileGet") { ?>

<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
</HEAD>
<body>

<?
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	$url = $params["api_url"].'?api_token='.$params["api_token"].'&file_token='.$params["file_token"];
	//echo $url;
	
	curl_setopt($ch, CURLOPT_URL, $url);

	$fp = fopen('download.file', 'w');

	curl_setopt($ch, CURLOPT_FILE, $fp);

	$http_result = curl_exec($ch);
	$error = curl_error($ch);
	$http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
	curl_close($ch);

	fclose($fp);

	echo "result code".$http_code;
	echo "<br><br>";
	if($http_code == "200") {
		echo "<a href='./download.file'>file download </a>=> right-button click, and then save as ...";
	} else {
		echo "download failed<br>";
	}
	
} else if ($api_id == "gwFilePost") {
	copy ($_FILES["ufile"]["tmp_name"], "upload/".$_FILES["ufile"]["name"]) or die ("Could not upload");
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	$url = $params["api_url"]."?api_token=".$params["api_token"]."&file_token=".$params["file_token"];
	//echo $url;
	
	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	//$filename = $_FILES["ufile"]["tmp_name"];
	$filename = "upload/".$_FILES["ufile"]["name"];
	$fileContents = "";

	if(file_exists($filename))
	{
	    $fp = fopen($filename, "rb");
	    $fileContents = stream_get_contents($fp);
	    fclose ($fp);
	    flush();
	}
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContents);
	$http_result = curl_exec($ch);
	$error = curl_error($ch);
	$http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
	curl_close($ch);

	echo "result code: ".$http_code;

} else { // 그외 api


	$apiHandler = new KTOpenApiHandler($auth_key, $auth_secret);

	if (!$apiHandler) { 
	    echo "Can't create apiHandler\r\n";
	    exit;
	}

	// api폴더의 상대 주소를 입력함
	$ret = $apiHandler->initialize("v1.0.52", "../api");

	if ( ! $ret ) {
    	echo "KTOpenApiHandler initialize error\r\n";
	    exit ;
	}

	// set api_id
	//$api = "1.0.UCLOUD.BASIC.GETRECENTFILE";
	$api = $api_id;
	// set https flag
	$bSSL = true;  

	// make xauth params
	$xauth_params = array();


	// api call
	$ret = $apiHandler->call($api,$params, $xauth_params,$bSSL);
	if ( !$ret) {
    	echo "errmsg:".$apiHandler->getErrorMsg();
	    exit;
	}

	// 호출결과 출력
	print_r($ret);
	echo "<br>";
	if($api_id == "1.0.UCLOUD.BASIC.CREATEFILETOKEN") {
		echo "api token: ".$apiHandler->makeApiToken();
	}
}
    echo "<br><br><br>";
    echo "<a href='./api_test_all.php'>Test Page</a>";
?>
</body>
</html>

