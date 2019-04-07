<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Agritypes extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->model('agritype', '', TRUE);
	}
	
	function index()
	{
		$data['viewdata'] = $this->agritype->dropdown();
		$this->templates->load('agritype', 'list', $data);
	}
	
	function add()
	{
		
		
		$this->form_validation->set_rules('agritype_name', $this->lang->line('agritype_name'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('agritype', 'add', $data);
		}
		else {
			$db_data['agritype_name'] = $this->input->post('agritype_name'); 
			
			if (!$this->agritype->add($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('agritype', 'add', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('agritype', 'add', $data);
			}
		}
	}

	function update($id)
	{
		
		
		$this->load->model('agritype','',TRUE);
		$data['row'] = $this->agritype->get(array('agritype_id' => $id));
		$this->form_validation->set_rules('agritype_name', $this->lang->line('agritype_name'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('agritype', 'update', $data);
		}
		else {
			$db_data['agritype_id'] = $id;
			$db_data['agritype_name'] = $this->input->post('agritype_name'); 
			
			if (!$this->agritype->update($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('agritype', 'update', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('agritype', 'update', $data);
			}
		}
	}

	function delete($id)
	{
		$db_data = array('agritype_id' => $id);
    $this->db->trans_start();
    $this->agritype->delete($db_data);
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
