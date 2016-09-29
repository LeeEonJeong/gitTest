<?php
session_write_close();
session_start();
/**
* api 호출 정보를 담기 위한 class
*/
$api_id = $_POST['api_id'];
$auth_key =  $_POST['key'];
$auth_secret = $_POST['secret'];

class apiRoom {

private $id;
private $name;
private $params;

	public function __construct($pid, $pname, $tp) {
		$this->id = $pid;
		$this->name = $pname;
		$this->params = $tp;
	}
	 
	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getParams() {
		return $this->params;
	}

} 

$path = "api/";
$version = "KTApiSpec_v1.0.52.xml" ;
$doc = new DOMDocument();
$doc->load( $path . $version);

$api_list = $doc->getElementsByTagName( "api" );

$type_list = $doc->getElementsByTagName("type");

$rooms = array();
 
 	foreach($api_list as $single_api) {
		$id = $single_api->getAttributeNode("id")->nodeValue;
		$name = $single_api->getAttributeNode("name")->nodeValue;
		$inputs = $single_api->getElementsByTagName("input");
		$input = $inputs->item(0)->nodeValue;
		$input_type_id = $inputs->item(0)->getAttributeNode("type_ref")->nodeValue;
 
		$p  = array(); //input parameters
		
		foreach($type_list as $single_type) {
			$type_id = $single_type->getAttributeNode("id")->nodeValue;
			if($input_type_id == $type_id) {
				$params = $single_type->getElementsByTagName("param");
				foreach($params as $param) {
					array_push($p, $param->getAttributeNode("name")->nodeValue);
				}
				break;
			}
		}

		$room = new apiRoom($id, $name, $p);
	    array_push($rooms, $room);
	}
	
	$room_size = count($rooms);
	
	if($api_id == null ) {
		$api_id = $rooms[0]->getId();
	} 
	$in_params = array();
	
	foreach($rooms as $sr) {
		if($sr->getId() == $api_id) {
			$in_params = $sr->getParams();
			break;
		}
	}
	

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript">
<!--

	String.prototype.trim = function() {
		return this.replace(/(^\s*)|(\s*$)/g, "");
	}

	function isBlank(objj)
	{
		if (objj.value.trim() == "" || objj.value == null || objj.value == "undefined")
			return true;
		 
		return false;
	}


	function onChangeApi() {
		var frm = document.frm;
		if (isBlank(frm.api)) {
			alert("please select api!!");
			return false;
		}

		document.frm1.api_id.value = frm.api.value;
		document.frm1.key.value = frm.auth_key.value;
		document.frm1.secret.value = frm.auth_secret.value;
		//alert(document.frm1.api_id.value);
		document.frm1.submit();
	}

  -->
</script>

</head>
<body>
<div align='center' style="background-color: #fff7f7;width:800px"  >            
  <p align="center" style="margin-top: 25px;">
    <font color="blue" size="4">
      <b>uCloud API PHP Test (ver. <?=$version?>)</b>
    </font>
  </p>
</div>

<? if ($api_id == "gwFilePost") { ?>
<form name='frm' action='api_test_result.php' enctype='multipart/form-data' method='post'>
<? } else { ?>
<form name='frm' action='api_test_result.php' method='post'>
<? } ?>
<table cellspacing="1" cellpadding="4" border="0" width="800" style="table-layout: fixed;">
<col width="200"/>
<col width=""/>
<tbody>

 <tr align="center" class="list1">
    <td align="right" class="list_eng"> auth key : </td>
    <td nowrap="" align="left" colspan="3">
      <input name="auth_key" size="100" maxlength="100" type="text" value="<?=$auth_key?>"/>
	</td>
 </tr>
 <tr align="center" class="list1">
    <td align="right" class="list_eng"> auth secret : </td>
    <td nowrap="" align="left" colspan="3">
      <input name="auth_secret" size="100" maxlength="100" type="text" value="<?=$auth_secret?>"/>
	  <input name="id" type="hidden" value="<?=$api_id?>"/>
	</td>
 </tr>

 <tr align="center" class="list0">
    <td align="right" class="list_eng">api :</td>
	<td nowrap="" align="left" colspan="3">
		<select name=api onChange="javascript:onChangeApi();">
<?	foreach($rooms as $single_room) { ?>
		<? if( $api_id == $single_room->getId() ) {?>
			<option value='<?=$single_room->getId()?>' selected><?=$single_room->getName()?></option>
		<? } else { ?>
			<option value='<?=$single_room->getId()?>' ><?=$single_room->getName()?></option>
		<? } ?>
<?  } ?>
		<? if($api_id == "gwFileGet") { ?>
			<option value='gwFileGet' selected >gwFileGet</option>
		<? } else { ?>
			<option value='gwFileGet' >gwFileGet</option>
		<? } ?>

        <? if($api_id == "gwFilePost") { ?>
            <option value='gwFilePost' selected >gwFilePost</option>
        <? } else { ?>
            <option value='gwFilePost' >gwFilePost</option>
        <? } ?>
		</select>
    </td>
 </tr>

<? foreach($in_params as $p) { ?>
 <tr align="center" class="list1">
    <td align="right" class="list_eng"> <?=$p?> : </td>
    <td nowrap="" align="left" colspan="3">
<? if ($p == "cb_method") { ?>
      <input name="param[<?=$p?>]" size="100" type="text" value="url" />
<? } else if ($p == "cb_trgt_info") { ?>
      <input name="param[<?=$p?>]" size="100" type="text" value="http://www.example.com/cbreceiver" />
<? } else { ?>
      <input name="param[<?=$p?>]" size="100" type="text" value="" />
<? } ?>
<? if ($p == "contents") { ?>
	  <input name="data_type" type="checkbox" checked>File
<? } ?>
	</td>
</tr>

<? } ?>

<? if($api_id == "gwFileGet") { ?>
 <tr align="center" class="list1">
     <td align="right" class="list_eng">api_url : </td>
     <td nowrap="" align="left">
	       <input name="param[api_url]" size="80" type="text" value="https://gate.ucloud.com/api/open/download" />
     </td>
 </tr>
 <tr align="center" class="list1">
	<td align="right" class="list_eng">api_token : </td>
    <td nowrap="" align="left">
	       <input name="param[api_token]" size="80" type="text" value="" />
    </td>
 </tr>
 <tr align="center" class="list1">
    <td align="right" class="list_eng">file_token : </td>
    <td nowrap="" align="left">
	       <input name="param[file_token]" size="80" type="text" value="" />
    </td>
 </tr>
<? } else if ($api_id == "gwFilePost") { ?>
 <tr align="center" class="list1">
     <td align="right" class="list_eng">api_url : </td>
     <td nowrap="" align="left">
	       <input name="param[api_url]" size="80" type="text" value="https://gate.ucloud.com/api/open/upload" />
     </td>
 </tr>
 <tr align="center" class="list1">
     <td align="right" class="list_eng">api_token : </td>
     <td nowrap="" align="left">
	       <input name="param[api_token]" size="80" type="text" value="" />
     </td>
 </tr>
 <tr align="center" class="list1">
     <td align="right" class="list_eng">file_token : </td>
     <td nowrap="" align="left">
	       <input name="param[file_token]" size="80" type="text" value="" />
     </td>
 </tr>
 <tr align="center" class="list1">
     <td align="right" class="list_eng">file : </td>
     <td nowrap="" align="left">
	       <input name="ufile" size="80" type="file" value="" />
     </td>
 </tr>

<? } ?>


 <tr align="center" class="list0">
    <td class="list_eng" colspan='4' >
       <input name="commit" type="submit" value="API CALL" />
    </td>
 </tr> 
</tbody>
</table>
</form>
<div name="result_div">

</div>
<form name="frm1" action='api_test_all.php' method='post'>
<input type="hidden" name="api_id">
<input type="hidden" name="key" >
<input type="hidden" name="secret">
</form>
</body>
</html>
