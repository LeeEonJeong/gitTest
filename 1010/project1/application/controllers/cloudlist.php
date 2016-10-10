<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Cloudlist extends MY_Controller{
		function __construct()
		{
			parent::__construct();
		}
		function index(){
			$this->_head();
			$this->load->model('callApiModel');
			$this->load->model('cloudsModel');
			$cmdArr = array (
					"command" => "listVirtualMachines",
					"apikey" => $_SESSION['apikey']
			);
			$cloudlist = $this->callApiModel->callCommand(CallApiModel::URI, $cmdArr, $_SESSION['secretkey'] );
			
			$clouds = $this->load->view('cloudlist');
			$this->load->view('cloudslist',$clouds);
			
			$this->_footer();
		}
		
	}