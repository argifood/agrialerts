<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Alerttypes extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->model('alerttype', '', TRUE);
	}
	
	function index()
	{
		$data['viewdata'] = $this->alerttype->dropdown();
		$this->templates->load('alerttype', 'list', $data);
	}
	
	function add()
	{
		$this->form_validation->set_rules('alerttype_name', $this->lang->line('alerttype_name'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('alerttype', 'add', $data);
		}
		else {
			$db_data['alerttype_name'] = $this->input->post('alerttype_name'); 
			if (!$this->alerttype->add($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('alerttype', 'add', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('alerttype', 'add', $data);
			}
		}
	}

	function update($id)
	{
		$this->load->model('alerttype','',TRUE);
		$data['row'] = $this->alerttype->get(array('alerttype_id' => $id));
		$this->form_validation->set_rules('alerttype_name', $this->lang->line('alerttype_name'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('alerttype', 'update', $data);
		}
		else {
			$db_data['alerttype_id'] = $id;
			$db_data['alerttype_name'] = $this->input->post('alerttype_name'); 
			if (!$this->alerttype->update($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('alerttype', 'update', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('alerttype', 'update', $data);
			}
		}
	}

	function delete($id)
	{
		$db_data = array('alerttype_id' => $id);
    	$this->db->trans_start();
    	$this->alerttype->delete($db_data);
    	$this->db->trans_complete();
    	if($this->db->trans_status() !== FALSE){
			$return_text = 1;
		}
		else {
			$return_text = 0;
		}
		echo $return_text;
	}

}
?>
