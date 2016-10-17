<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Cloudlist extends MY_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model('cloudsModel');
		}
		
		function index(){
			$this->_head();
			$returnURI = '/cloudlist'; // 일단임의로 나중에 returnURI 다시 처리하자
			$this->_require_login($returnURI);
			
			$vms = $this->cloudsModel->getlistVms();
		 	
			 
			$vmcount = $vms['count'];
			
			$cloudlistdata = array(
					'clouds' => $vms,
					'vmcount' => $vmcount
			); 
		
			$this->load->view('cloudlist', $cloudlistdata); 
		 	$this->load->view('cloudManageMenu');
		 	 
		 	if($vmcount==0){
		 		$vminfo = "생성된 서버가 없습니다.";
		 	}elseif($vmcount == 1){
		 		$vminfo = $this->cloudsModel->getVMs($vms, 'id',$vms['virtualmachine']['id']);
		 	}else{
		 		$vminfo = $this->cloudsModel->getVMs($vms, 'id',$vms['virtualmachine'][0]['id']); //일단 임의로
		 	}
		 	
		 	$serverinfo = array(
		 			'server' => $vminfo
		 	);
		 	
		 	$this->load->view('serverInfo',$serverinfo); 
			
			$this->_footer();
		}  
		 
		function startVM(){
			$this->cloudsModel->startVM(); 
		}
		
		function stopVM(){
			$this->cloudsModel->stopVM(); 
		}
		
		function getVMsByZoneId($zoneid){ //publicip로 할수 없어서 일단은 zoneid로 서치
			$vms = $this->cloudsModel->getlistVMs();
			
			$result = $this->cloudsModel->getVMS($vms, 'zoneid', $zoneid );
			
			print(json_encode($result));
		}
		
		function searchVM($vmid){
			$result = $this->cloudsModel->searchVM($vmid);
			print(json_encode($result));
		}
	}