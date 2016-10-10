<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Volumelist extends MY_Controller{
		function __construct()
		{
			parent::__construct();
		}
		function index(){
			$this->_head();
			$this->load->view('volumelist');
			$this->_footer();
		}
	}