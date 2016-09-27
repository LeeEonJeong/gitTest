<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="./CSS/listCss.css" />
<title>Server 생성</title>
</head>
<body>
<?php 
include('api_constants.php');
include ('./refer/callAPI.php');
include('var_dump_enter.php');

$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

$listProductcmdArr = array(
		"command" => "listAvailableProductTypes",
		"apikey" => API_KEY
);
$seceret_key = SECERET_KEY;
$result = callCommand($URL, $listProductcmdArr, $seceret_key);
//var_dump_enter($result);
$count = $result['count'];
$result = $result['producttypes'];
?>
 
<table>
		<tr>
			<td>product</td>
			<td>disk</td>
			<td>cpu,memory</td>
			<td>os</td>
			<td>zone</td>
			<td>apply</td>
		</tr>
<?php 
for($i=0; $i<$count; $i++){
	if($result[$i]['productstate']=="available") {
		if(isset($result[$i]['diskofferingid'])){
			$diskofferingid = $result[$i]['diskofferingid'];
		}else {
      		$diskofferingid = "rootonly";
     	}
		echo "<tr><form action='deploy_result.php' method='post'><td>";
		echo $result[$i]['product'];
		echo "<input type='hidden' name='productid' value='".$result[$i]['productid']."'/>";
		 
		echo "</td> <td>";
		echo $result[$i]['diskofferingdesc'];
		echo "<input type='hidden' name='diskofferingid' value='".$diskofferingid."'/>";
		echo "</td> <td>";
		echo $result[$i]['serviceofferingdesc'];
		echo "<input type='hidden' name='serviceofferingid' value='".$result[$i]['serviceofferingid']."'/>";
		echo "</td> <td>";
		echo $result[$i]['templatedesc'];
		echo "<input type='hidden' name='templateid' value='".$result[$i]['templateid']."'/>";
		echo "</td> <td>";
		echo $result[$i]['zonedesc'];
		echo "<input type='hidden' name='zoneid' value='".$result[$i]['zoneid']."'/>";
		echo "</td><td><input type='submit' value='신청'/></td></tr></form>";
	}
}
?>
<tr>
</tr>
</table> 
</body>
</html>