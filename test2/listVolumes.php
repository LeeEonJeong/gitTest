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
function attachVolume(num){
//  alert(document.forms[num]);
  document.forms[num].action = 'selectAttachVolume.php';
  document.forms[num].method = 'post';
  document.forms[num].submit();
}

function detachVolume(num){
//  alert(document.forms[num]);
  document.forms[num].action = 'detachVolume.php';
  document.forms[num].method = 'post';
  document.forms[num].submit();
}

function deleteVolume(num){
//  alert(document.forms[num]);
  document.forms[num].action = 'deleteVolume.php';
  document.forms[num].method = 'post';
  document.forms[num].submit();
}


</script>
</head>
<body>
	<table>
		<tr>
			<td>disk명</td>
			<td>disk id</td>
			<td>용량</td>
			<td>위치(존)</td>
			<td>연결상태</td>
			<td>적용서버</td>
			<td>type</td>
			<td>생성일시</td>
		</tr>
 
<?php
include ('api_constants.php');
include ('./refer/callAPI.php');
 


$vmid = "c545eb01-5538-4778-a6d6-9ec4937d6231";
$ipaddressid = "465e6db6-7b44-4ea4-9ab2-b4ff6c616494";

$cmdArr = array (
		"command" => "listVolumes",
		"apikey" => API_KEY
);
// -----------------------(5) createPortForwardingRule로 22번(ssh 접속포트) 외부 오픈
$productTypesByZone = callCommand ( URL, $cmdArr, SECERET_KEY );
echo '<pre>';
print_r ( $productTypesByZone );
echo '</pre>';
$volumes = $productTypesByZone ['volume'];
$volumeNum = $productTypesByZone ['count'];

for($i = 0; $i < $volumeNum; $i ++) {
	$volume = $volumes [$i];
	echo "<tr><form method='post'><td>";
	echo "<input type='hidden' name='volumeid' value='" . $volume ['id'] . "'/>";
	echo $volume ['name']; // volume이름
	echo "</td> <td>";
	echo $volume ['id']; // volume이름
	echo "</td> <td>";
	echo $volume ['diskofferingdisplaytext'];
	echo "</td> <td>";
	echo $volume ['zonename'];
	echo "<input type='hidden' name='volumezoneid' value='" . $volume ['zoneid'] . "'/>";
	echo "</td> <td>";
	if ($volume['vmname'] && $volume['type'] == 'DATADISK') {
		echo'사용 ';
		?>
			<input type="submit" value="서버 연결해제" onclick = "detachVolume(<?=$i?>)"/>
			
		<?php
	} else if (!$volume['vmname'] && $volume['type'] == 'DATADISK') {
		echo '분리 ';
		?>		 
			<input type="button" value="서버연결" onclick="attachVolume(<?=$i?>)"/> 
			<input type="submit" value="삭제" onclick = "deleteVolume(<?= $i?>)"/>
		<?php
	}
	
	
	echo "</td><td>";
	echo $volume ['vmdisplayname']; // 적용서버 이름
	echo "</td> <td>";
	echo $volume ['type']; // ROOT DATADISK(추가)
	echo "</td> <td>";
	echo $volume ['attached']; // 생성일시
	echo "</td> </form></tr>";
}
?>    
</table>

</body>
</html>