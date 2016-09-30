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
 
<table>
<?php 
include ('listVirtualMachines.php');

$volumeid = $_POST['volumeid'];
$volumezoneid = $_POST['volumezoneid'];
$VMsByZone = getVMs('zoneid', $volumezoneid);


for($i=0; $i<count($VMsByZone); $i++){
	$VM = $VMsByZone[$i];
	$vmid = $VM['id'];
	echo "<tr>
			<form method='post' action='attachVolume.php'>
				<input type='hidden' name='volumeid' value=".$volumeid."/>
		 		<input type='hidden' name='vmid' value=".$vmid."/>
		 		<td>".$volumeid."</td>
		 		<td>".$VM['displayname']."</td>
				<td><input type='submit' value='연결'/></td>
			</form>
		</tr>
	";
	
//	echo $volumeid .'    '.$vmid;
}
?>
</table>

</body>
</html>
