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
	function test(){
		alert("window.open 테스트");
		window.open("www.naver.com");
	}
</script>
</head>

<body>
<?php
include ('../listZones.php');
include ('listAvailableProductTypes.php');
 
$listZones = getlistZones ();
 

?>
<input type=button onclick="test()"/><br>
<h2>Virtual Machine 생성하기</h2>
<form method='post' action='deployVirtualMachine.php'>
	os선택 :  
	
	서버명 : <input type="text" name="vmName" /><br>
	  
	<select name="zoneid" id="zoneid" onChange="selectZoneid(this)"  >
		<option value="<?= $listZones[0]['id']?>">존선택</option>
		<?php
			for($i = 0; $i < count ( $listZones ); $i ++) {
				$zone = $listZones [$i];
				echo "<option value= " . $zone ['id'] . ">" . $zone ['name'] . "</option>";
			}
		?>
	</select>
	<br>
	<div id="selectZone">
		
	</div>
<input type="submit" value="신청" />
</form>
	
</body>
</html>
