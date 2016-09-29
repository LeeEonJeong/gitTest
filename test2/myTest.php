<?php
function callCommand($URL, $cmdArr, $SECRET) {
	$fArray = array_keys ( $cmdArr );
	$vArray = array_values ( $cmdArr );
	
	$f = array ();
	$v = array ();
	$cmd = array ();
	$cmd1 = array ();
	
	for($i = 0; $i < count ( $cmdArr ); $i ++) {
		$vArray [$i] = strtok ( $vArray [$i], "&" );
		$f [$i] = strtolower ( urlencode ( $fArray [$i] ) );
		$v [$i] = strtolower ( urlencode ( $vArray [$i] ) );
		array_push ( $cmd, $f [$i] . "=" . $v [$i] );
	}
	
	sort ( $cmd );
	
	for($i = 0; $i < count ( $cmdArr ); $i ++)
		array_push ( $cmd1, $fArray [$i] . "=" . $vArray [$i] );
	sort ( $cmd1 );
	$cmdStr = "";
	for($i = 0; $i < count ( $cmd ); $i ++) {
		if ($i == count ( $cmd ) - 1)
			$cmdStr = $cmdStr . $cmd [$i];
		else
			
			$cmdStr = $cmdStr . $cmd [$i] . "&";
	}
	
	$signature = urlencode ( base64_encode ( hash_hmac ( "sha1", $cmdStr, $SECRET, true ) ) );
	
	$url = $URL;
	
	for($i = 0; $i < count ( $cmd1 ); $i ++)
		$url = $url . $cmd1 [$i] . "&";
	
	$xmlUrl = $url . "signature=" . $signature;
	
	print_r($xmlUrl);
	
 	//$orig_error_reporting = error_reporting ();
	//error_reporting ( 0 );
	return  file_get_contents ( $xmlUrl );
 	$arrXml = objectsIntoArray ( simplexml_load_string ( file_get_contents ( $xmlUrl ) ) );
	
// 	error_reporting ( $orig_error_reporting );
	
// 	print_r($arrXml);
 //	return $arrXml;
}

function curl($url)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$g = curl_exec($ch);
	curl_close($ch);
	return $g;
}


$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

$apikey = "dujRkDjR3cXHOFx7i0L2XJcXZggC2gRvEcudTophpWG8KGCVljZ9-5p0k60Gj5FSdhROon9R9pdyTd3gKKWrAw";
$secret = "okXiXBEj2MgdxDWWOzvzEiC7I5HNwBfNlJdJy-CH3epf4Ae4gw9QfoDvcq9xoVFo-wq5YNsWzSZghFHbWawGyw";

$content = "";

$cmdArr = array (
		"command" => "listVirtualMachines",
		"state" => "Running",
		"apiKey" => $apikey 
);

$mycmd="https://api.ucloudbiz.olleh.com/server/v1/client/api?command=listVirtualMachines&state=Running&apiKey=dujRkDjR3cXHOFx7i0L2XJcXZggC2gRvEcudTophpWG8KGCVljZ9-5p0k60Gj5FSdhROon9R9pdyTd3gKKWrAw&signature=3O2tE1IzKZCaQKcdPqSgCm9DHD8%3D";

$result = file_get_contents ( $mycmd );
echo $result;

//echo curl($mycmd);
//$result = callCommand ( $URL, $cmdArr, $secret );

//$result1 = file_get_contents ( $mycmd );
 
//$result =  objectsIntoArray ( simplexml_load_string ( file_get_contents ( $mycmd ) ) );

// $content .= $result ["virtualmachine"] ["name"];

// $content .= " - name 출력 by eonjeong\n";

// $content .= $result ["virtualmachine"] ["created"];

// $content .= " - 생성시간 출력 by eonjeong\n";

// $content .= "\n\n";

 
$fp = fopen ( "eonjeong.txt" , 'w+' );

fwrite ( $fp, $result1 );

fclose ( $fp );

?>