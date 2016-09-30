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
<form method="post" action="deployVirtualMachine.php">
<?php
include ('listAvailableProductTypes.php');
include ('../listZones.php');
 
$templateid = $_POST['templateid'];
$zoneid = $_POST['zoneid'];
$serviceofferingid = $_POST['serviceofferingid'];

echo 'tempalteid : '.$templateid.'<br>';
echo 'zoneid : '.$zoneid.'<br>';
echo 'serviceofferingid : '.$serviceofferingid.'<br>';

echo '<h4>선택한 VM 사양</h4>';
myPrint(getProduct($templateid, $zoneid, $serviceofferingid));
?>

<input type="hidden" name="templateid" value="<?=$templateid?>"/>
<input type="hidden" name="zoneid" value="<?=$zoneid?>"/>
<input type="hidden" name="zoneid" value="<?=$serviceofferingid?>"/>

<br>
vm name : <input type="text" name="vmname"/><br>
<input type="submit" value="생성하기"/>
</form>
</body>
</html>
