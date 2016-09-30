<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<style>
table,tr,td{
    border: 1px solid black;
    border-collapse: collapse;
}
</style>

<script>
function destroyVM(num){
//  alert(document.forms[num]);
  document.forms[num].action = 'destroyVM.php';
  document.forms[num].method = 'post';
  document.forms[num].submit();
}
function startVM(num){
//  alert(document.forms[num]);
  document.forms[num].action = 'startVM.php';
  document.forms[num].method = 'post';
  document.forms[num].submit();
}

function stopVM(num){
  alert(document.forms[num]);
  document.forms[num].action = 'stopVM.php';
  document.forms[num].method = 'post';
  document.forms[num].submit();
}
</script>
</head>
<body>
<a href="listAvailableProductType.php">서버생성하기</a><br/>
<table>
<?php
include('api_constants.php');
include ('./refer/callAPI.php');
include('var_dump_enter.php');
 
$URL = "https://api.ucloudbiz.olleh.com/server/v1/client/api?";

$listProductcmdArr = array(
    "command" => "listVirtualMachines",
    "apikey" => API_KEY
);
$productTypesByZone = callCommand($URL, $listProductcmdArr, SECERET_KEY);
 
$result_num = $productTypesByZone['count'];
//echo $result_num;
$productTypesByZone = $productTypesByZone['virtualmachine'];
//var_dump_enter($result['1']);
for($i=0; $i<$result_num; $i++){ 
  if($result_num != '1' ) {
    $temp = $productTypesByZone[$i];
  }else{
  	$temp = $productTypesByZone;
  }
    echo "<tr><form id ='jk$i' method='post'><td>";
    echo $temp['displayname'];
    echo "<input type='hidden' name='id' value='".$temp['id']."'/>";
    echo "</td> <td>";
    echo $temp['state'];
    echo "</td> <td>";
    echo $temp['zonename'];
    echo "<input type='hidden' name='zoneid' value='".$temp['zoneid']."'/>";
    echo "</td> <td>";
    echo $temp['serviceofferingname'];
    echo "<input type='hidden' name='serviceofferingid' value='".$temp['serviceofferingid']."'/>";
    echo "</td> <td>";
    echo $temp['templatedisplaytext'];
    echo "<input type='hidden' name='templateid' value='".$temp['templateid']."'/>";
    echo "</td> <td>"; 
    
    if($temp['displayname'] != "eonjeongserver") {?>
    <input type='button' value='stopVM' onclick="stopVM('<?=$i?>')"/>
     <input type='button' value='startVM' onclick="startVM('<?=$i?>')"/>
     <input type='button' value='destroyVM' onclick="destroyVM('<?=$i?>')"/> </td></tr></form>
<?php } else {
	echo " </td></tr></form>";
    }
}

?>
    </td></tr></form>
</table>
</body>
</html>
