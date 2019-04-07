<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Nuts2s extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->model('nuts2', '', TRUE);
	}
	
	function index()
	{
		$data['viewdata'] = $this->nuts2->dropdown();
		$this->templates->load('nuts2', 'list', $data);
	}
	
	function add()
	{
		
		
		$this->form_validation->set_rules('nuts2_name', $this->lang->line('nuts2_name'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('nuts2', 'add', $data);
		}
		else {
			$db_data['nuts2_name'] = $this->input->post('nuts2_name'); 
			
			if (!$this->nuts2->add($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('nuts2', 'add', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('nuts2', 'add', $data);
			}
		}
	}

	function update($id)
	{
		
		
		$this->load->model('nuts2','',TRUE);
		$data['row'] = $this->nuts2->get(array('nuts2_id' => $id));
		$this->form_validation->set_rules('nuts2_name', $this->lang->line('nuts2_name'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('nuts2', 'update', $data);
		}
		else {
			$db_data['nuts2_id'] = $id;
			$db_data['nuts2_name'] = $this->input->post('nuts2_name'); 
			
			if (!$this->nuts2->update($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('nuts2', 'update', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('nuts2', 'update', $data);
			}
		}
	}

	function delete($id)
	{
		$db_data = array('nuts2_id' => $id);
    $this->db->trans_start();
    $this->nuts2->delete($db_data);
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
