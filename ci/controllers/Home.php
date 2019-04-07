<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Home extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
	}
	
	function index()
	{
		$this->templates->load('home', 'home');
	}
	
		
}
?>
