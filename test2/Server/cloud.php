<?php
session_start ();
?>

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
 
function func(cmd,vmid){
	alert('test');
// 	document.forms[num].action='startVM.php';
// 	document.forms[num].method = 'post';
// 	document.forms[num].submit();
	alert("<?callSyncCmd(cmd,vmid);?>");
// 	alert('end');
}


function test(){
	alert('hi');
}

 
</script>
</head>

<body>

	<pre>
<a href="./Orders/cloudTemplate.php">서버생성하기</a>
</pre>

	<table>
		<tr>
			<td>번호</td>
			<td>계정명(displayname)</td>
			<td>운영체제(templatedisplaytext)</td>
			<td>네트워크그룹(?)</td>
			<td>데이터센터(zonename)</td>
			<td>생성시간(created)</td>
			<td>상태(state)</td>
			<td>제어</td>
		</tr>

<?php
include 'listVirtualMachines.php';
include 'serverCommonCmd.php';

$listVMs = getlistVMs ();
$count = $listVMs ['count'];

for($i = 0; $i < $count; $i ++) {
	if ($count == 1) {
		$temp = $listVMs ['virtualmachine'];
	} else {
		$temp = $listVMs ['virtualmachine'] [$i];
	}
	
	echo "<tr><form method='post'><td>";
	//echo "<input type='hidden' name='vmid' value='" . $temp ['id'] . "'/>";
	echo $i + 1;
	echo "</td><td>";
	echo $temp ['displayname'];
	echo "</td><td>";
	echo $temp ['templatedisplaytext'];
	echo "</td><td>";
	echo $temp [' '];
	echo "</td><td>";
	echo $temp ['zonename'];
	echo "</td><td>";
	echo $temp ['created'];
	echo "</td><td>";
	echo $temp ['state'];
	echo "</td><td>"; ?>
	<input type='button' value='시작' onclick = "func('updateVirtualMachine','<?= $temp['id']?>')"/>
<?php 	
	echo "</td></form></tr>";
}
?>

</table>
</body>