<?php
//db에서 사용자의 클라우드 가져오기
/*
 * 해당 유저의 서버 정보 가져오기
 * 서칭기능
 * 볼륨이 붙여진 클라우드 가져오기
 *  
 * */
class CloudsModel extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function getlistVMs(){
		$cmdArr = array (
				"command" => "listVirtualMachines",
				"apikey" => $_SESSION['apikey']
		);
		
		//$result = new CallApiModel().callCommand(URL, $cmdArr, $_SESSION['secretkey']);
		
		return $result;
	}	
}