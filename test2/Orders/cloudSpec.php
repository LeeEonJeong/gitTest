<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<style>
	table, tr, td {
		border: 1px solid black;
		border-collapse: collapse;
	}
</style>
</head>

<body>
<?php
include ('listAvailableProductTypes.php');
include ('../listZones.php');
 
$templateid = $_GET['templateid'];
$zoneid = $_GET['zoneid'];

echo $templateid."입니다.<br>".$zoneid."입니다.<br> +++ ".isset($templateid)." <br>--- ".isset($zoneid);

$productTypesByTemplateId = getProductTypes('templateid',$templateid);
//myPrint($productTypesByTemplateDesc);
$listZones = getlistZones ();
?>

<form method="post" action="cloudConfirm.php" >
<input type="hidden" name="templateid" value="<?=$templateid?>"/>
<input type="hidden" name="zoneid" value="<?=$zoneid?>"/>

<table>
	<tr>
		<td></td>
		<td>product</td>  
		<td>serviceofferingdesc(cpu, ram)</td>
		<td>diskofferingdesc(기본디스크)</td>
	</tr>
<?php 
if(isset($zoneid) && isset($templateid)){
	echo '존설정됨<br>';
// 	$productTypesByZone = sortArray('zoneid', $productTypesByTemplateDesc)[$zoneid];  //sortArray() depth문제
	$productTypesByZoneAndId = array();
	$i=0;
	foreach($productTypesByTemplateId as $index => $productType){
		if($productType['zoneid'] == $zoneid){
			$productTypesByZoneAndId[$i++] = $productType;
		}
	}
	
	//myPrint($productTypesByZoneAndTemplate);
	
	
	for($i=0; $i<count($productTypesByZoneAndId); $i++){
		if($productTypesByZoneAndId[$i]['productstate']=="available") {
			if(isset($productTypesByZoneAndId[$i]['diskofferingid'])){
				$diskofferingid = $productTypesByZoneAndId[$i]['diskofferingid'];
			}else {
				$diskofferingid = "rootonly";
			}
// 			myPrint($productTypesByZoneAndTemplate[$i]);
// 			echo '<br>--------<br>';
			echo "<tr>
					<td>
						<input type='radio' name='serviceofferingid' value='".$productTypesByZoneAndId[$i]['serviceofferingid']."'/>
					</td>
				  <td>";
			
			echo $productTypesByZoneAndId[$i]['product'];
			echo "</td> <td>";
			echo $productTypesByZoneAndId[$i]['serviceofferingdesc'];
			echo "</td> <td>";
			echo $productTypesByZoneAndId[$i]['diskofferingdesc'];
			echo "</td></tr>";
		}
	}
?>
</table>
<input type="submit"  value="다음"/>
</form>
<?php 
}
else{
	echo '존설정안됨<br>';
 
	foreach($listZones as $index => $zone){
		echo "<a href='cloudSpec.php?zoneid=".$zone[id]."&templateid=".$templateid."'>".$zone['name']."</a><br>";
	}
}

?>


</body>
</html>
