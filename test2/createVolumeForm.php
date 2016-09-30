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
<script>
function selectProductType(zoneid){
	alert(zoneid.tx
}

</script>
</head>

<body>
<?php
include ('listZones.php');
include ('diskofferingid.php');

$listZones = getlistZones ();

?>
<h2>volume 생성하기</h2>

<form method='post' action='createVolume.php'>
	volume이름 : <input type="text" name="volumename" /><br>
	<select name="diskofferingid">
		<?php
		for($i = 10; $i <= 300; $i += 10) {
			echo "<option value= " . getDiskOfferingId ( $i ) . ">" . $i . "GB</option>";
		}
		?>
	</select>
	<br>
	<select id="zoneid" name="zoneid" onChange="selectProductType(this)">
		<option value="<?= $listZones[0]['id']?>">존선택</option>
		<?php
			for($i = 0; $i < count ( $listZones ); $i ++) {
				$zone = $listZones [$i];
				echo "<option value= " . $zone ['id'] . ">" . $zone ['name'] . "</option>";
			}
		?>
	</select>
	<br>
	
<input type="submit" value="신청" />
</form>
	
</body>
</html>
