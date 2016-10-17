<?php
 
class NetworksModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' ); 
	}
	
	//-------------<<공인ip>>--------------------------------------------
	
	function getlistPublicIpAddresses() { 
		$cmdArr = array (
				"command" => "listPublicIpAddresses",
				"apikey" => $_SESSION ['apikey'] 
		);
		
		$publicIpAddreses = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $publicIpAddreses;
	}
	
	function getPublicIpInfo() {
		$cmdArr = array (
				"command" => "listPublicIpAddresses",
				"id" => $_POST['publicip'],
				//"id" => '465e6db6-7b44-4ea4-9ab2-b4ff6c616494',
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
	 	
		if($result['count'] != 1){ } //error 정보 무조건 하나일거아냐....아닌가 나중에 바뀌나?
		
		$publicip = $result['publicipaddress'];
		
		return $publicip;
	}

	//-------------<<포트포워딩>>--------------------------------------------
	
	//전체 포트포워딩 규칙 가져오기
 	function getlistPortForwardingRules(){ 
 		$cmdArr = array (
 				"command" => "listPortForwardingRules",
 				"apikey" => $_SESSION ['apikey']
 		);
 		
 		$portforwardingRules = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 		
 		return $publicIpAddreses; 
 	}
 	
 	//ipaddress에 따라서 룰 가져오기
 	function getlistPortForwardingRulesByIpAdress(){
 		$cmdArr = array (
 				"command" => "listPortForwardingRules",
 				//"ipaddressid" => "465e6db6-7b44-4ea4-9ab2-b4ff6c616494",
 				"ipaddressid" => $_POST['ipaddressid'],
 				"apikey" => $_SESSION ['apikey']
 		);
 			
 		$portforwardingRules = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 			
 		return $portforwardingRules;
 	}
 	
 	function createPortForwarding(){ //비동기
 		$cmdArr = array (
 				"command" => "createPortForwardingRule",
 				"ipaddressid" => $_POST['ipaddressid'],
 				"publicport" => $_POST['publicport'],//포트 포워딩 규칙의 공개 포트 범위의 시작 포트
 				"publicendport" => $_POST['publicendport'],
 				"virtualmachineid" => $_POST["virtualmachineid"],
 				"privateport" => $_POST["privateport"],//포트 포워딩 규칙의 개인 포트 범위의 시작 포트
 				"privateendport" => $_POST["privateendport"],
 				"protocol" => $_POST["protocol"], 
 				"apikey" => $_SESSION ['apikey']
 		);
 		
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 	}
 
 	function deletePortForwardingRule(){ //비동기
 		$cmdArr = array (
 				"command" => "deletePortForwardingRule",
 				"ipaddressid" => $_POST['portForwardingId'], 
 				"apikey" => $_SESSION ['apikey']
 		);
 		
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 	}
 	
 	//-------------<<방화벽>>--------------------------------------------
 	function getFirewallReuls(){
 		
 	}
 	

 	function getlistFirewallRules() {
 		$cmdArr = array (
 				"command" => "listFirewallRules",
 				"apikey" => $_SESSION ['apikey']
 		);
 	
 		$publicIpAddreses = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 	
 		return $publicIpAddreses;
 	}
 	
 	function getlistFireWallInfoByIpAddress() {
 		$cmdArr = array (
 				"command" => "listFirewallRules",
 				"ipaddressid" => $_POST['ipaddressid'],
 				"apikey" => $_SESSION ['apikey']
 		);
 	
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 		 
 		if($result['count'] != 1){ } //error 정보 무조건 하나일거아냐....아닌가 나중에 바뀌나?
 	
 		$publicip = $result;
 	
 		return $publicip;
 	}
 	
 	function createFirewallRule(){ //비동기
 		$cmdArr = array (
 				"command" => "createPortForwardingRule",
 				"ipaddressid" => $_POST['ipaddressid'],
 				"protocol" => $_POST["protocol"],
 				"cidrlist" => $_POST['cidrlist'], //Firewall에 등록할 source cidrlist ( 미기입시, 모든 IP 허용 정)
 				"startport" => $_POST["startport"],
 				"apikey" => $_SESSION ['apikey']
 		);
 	
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 	
 	}
 	
 	
 	function deleteFirewallRule(){//비동기
 		$cmdArr = array (
 				"command" => "deleteFirewallRule",
 				"ipaddressid" => $_POST['firwallRuleId'],
 				"apikey" => $_SESSION ['apikey']
 		);
 			
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 	}
 	
}