<?php
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
	
	function getlistVMs() { // 전체 VM들 가져오기
		$cmdArr = array (
				"command" => "listVirtualMachines",
				"apikey" => $_SESSION ['apikey'] 
		);
		
		$vms = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $vms;
	}
	

	function searchVM($vmid){ //조건들에 맞는 vm찾기
		$cmdArr = array (
				"command" => "listVirtualMachines",
				"id" => $vmid,
				"apikey" => $_SESSION ['apikey']
		);
		
		$vm = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $vm;
	}
 
	function getVMs($listVMs, $condition, $value){ //해당 VM들 중에서 condition은 비교할 조건(존같은), value는 비교할 값
		$vmCount= $listVMs['count'];
		$resultIndex = 0;
		
		if($vmCount == 1){
			if($listVMs['virtualmachine'][$condition] == $value ){
				return $listVMs['virtualmachine'];
			}
		}else{
			for($i=0; $i<$vmCount; $i++){
				$vm = $listVMs['virtualmachine'][$i];
	
				if($vm[$condition] == $value){
					$result[$resultIndex++] = $vm;
				}
			}
			return $result;
		}
	}
	
	//------------서버 기능(시작, 정지, 재부팅, 삭제) --업데이트(나중)

	function startVM(){
		$cmdArr = array(
		    "command" => "startVirtualMachine",
			//"id" => "371bf4c5-fb6f-4d57-9cdd-167b33567907",				
		    "id" => $_POST['vmid'],
		    "apikey" => $_SESSION['apikey']
		);
		 
		$seceret_key = $_SESSION['secretkey'];
		
		$vms = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		$jobId = $cmdArr["jobid"];
		
		echo 'startVM';
// 		do {
// 		  $cmdArr2 = array(
// 		    "command" => "queryAsyncJobResult",
// 		    "jobid" => $jobId,
// 		    "apikey"  =>  $_SESSION['apikey']
// 		  );
// 		  $result2 = $this->callApiModel->callCommand(CallApiModel::URI, $cmdArr2, $seceret_key);
		  
// 		  $jobStatus = $result2["jobstatus"];
// 		  if ($jobStatus == 2) {
// 		     printf($result2["jobresult"]);
// 		      exit;
// 		  }
// 		} while ($jobStatus != 1); 
// 		echo print($result2);
	}
	
	function stopVM(){
// 		$cmdArr = array(
// 				"command" => "stopVirtualMachine",
// 				"id" => $_POST['vmid'],
// 				"apikey" => $_SESSION ['apikey']
// 		);
		 
// 		$seceret_key = $_SESSION['secretkey'];
// 		$result = $this->callApiModel(CallApiModel::URI, $cmdArr, $seceret_key);
		
// 		sleep(1);
// 		$jobId = $result["jobid"];
		

		$cmdArr = array(
				"command" => "stopVirtualMachine",
				//"id" => "371bf4c5-fb6f-4d57-9cdd-167b33567907",
				"id" => $_POST['vmid'],
				"apikey" => $_SESSION['apikey']
		);
			
		$seceret_key = $_SESSION['secretkey'];
		
		$vms = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		$jobId = $cmdArr["jobid"];
	  
// 		do {
// 			$cmdArr2 = array(
// 					"command" => "queryAsyncJobResult",
// 					"jobid" => $jobId,
// 					"apikey"  => $_SESSION ['apikey']
// 			);
// 			$result2 = callCommand($URL, $cmdArr2, $seceret_key);
// 			sleep(5);
// 			$jobStatus = $result2["jobstatus"];
// 			if ($jobStatus == 2) {
// 				printf($result2["jobresult"]);
// 				exit;
// 			}
// 		} while ($jobStatus != 1);
	}
}