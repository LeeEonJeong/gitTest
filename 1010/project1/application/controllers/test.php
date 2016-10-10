<?php
class Test extends MY_Controller{
	function __construct(){
		parent::__construct();
	}
	
	function test(){
		if(!$this->session->userdata('is_login')){
			//redirect('/auth/login?returnURL='.rawurlencode(site_url('/test/test')));
			redirect('/auth/login?returnURL='.rawurlencode('http://localhost/project1/index.php/test/test'));
		}
		$this->load->view('test');
	}
}