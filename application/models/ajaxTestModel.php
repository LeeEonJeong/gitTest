a<?php
// db에서 사용자의 클라우드 가져오기
/*
 * 해당 유저의 서버 정보 가져오기
 * 서칭기능
 * 볼륨이 붙여진 클라우드 가져오기
 *
 */
class CloudsModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' );
	}
	
 
	//------------서버 기능(시작, 정지, 재부팅, 삭제) --업데이트(나중)
	function startVM(){
		$cmdArr = array (
				"command" => "startVirtualMachine",
				"id" =>$_POST('vmid'),
				"apikey" => $_SESSION ['apikey']
		); 
		
		$vms = $this->callApiModel->callCommandReponseJson( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $vms;
	}
}