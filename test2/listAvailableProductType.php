<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="./CSS/listCss.css" />
<title>Server 생성</title>
<style>
table, tr, td {
	border: 1px solid black;
	border-collapse: collapse;
}
</style>
</head>
<body>
<?php 
include('api_constants.php');
include ('./refer/callAPI.php');
 
 
$listProductcmdArr = array(
		"command" => "listAvailableProductTypes",
		"apikey" => API_KEY
);
$seceret_key = SECERET_KEY;
$productTypesByZone = callCommand(URL, $listProductcmdArr, $seceret_key);
//var_dump_enter($result);
$count = $productTypesByZone['count'];
$productTypesByZone = $productTypesByZone['producttypes'];
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
	if($productTypesByZone[$i]['productstate']=="available") {
		if(isset($productTypesByZone[$i]['diskofferingid'])){
			$diskofferingid = $productTypesByZone[$i]['diskofferingid'];
		}else {
      		$diskofferingid = "rootonly";
     	}
		echo "<tr><form action='deploy_result.php' method='post'><td>";
		echo $productTypesByZone[$i]['product'];
		echo "<input type='hidden' name='productid' value='".$productTypesByZone[$i]['productid']."'/>";
		 
		echo "</td> <td>";
		echo $productTypesByZone[$i]['diskofferingdesc'];
		echo "<input type='hidden' name='diskofferingid' value='".$diskofferingid."'/>";
		echo "</td> <td>";
		echo $productTypesByZone[$i]['serviceofferingdesc'];
		echo "<input type='hidden' name='serviceofferingid' value='".$productTypesByZone[$i]['serviceofferingid']."'/>";
		echo "</td> <td>";
		echo $productTypesByZone[$i]['templatedesc'];
		echo "<input type='hidden' name='templateid' value='".$productTypesByZone[$i]['templateid']."'/>";
		echo "</td> <td>";
		echo $productTypesByZone[$i]['zonedesc'];
		echo "<input type='hidden' name='zoneid' value='".$productTypesByZone[$i]['zoneid']."'/>";
		echo "</td><td><input type='submit' value='신청'/></td></tr></form>";
	}
}
?>
<tr>
</tr>
</table> 
</body>
</html>