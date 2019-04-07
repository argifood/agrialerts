<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Nuts3s extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->model('nuts3', '', TRUE);
	}
	
	function index()
	{
		$data['viewdata'] = $this->nuts3->dropdown();
		$this->templates->load('nuts3', 'list', $data);
	}
	
	function add()
	{
		$this->load->model('nuts2', '', TRUE); 
		
		$data['nuts2'] = $this->nuts2->dropdown(); 
		
		$this->form_validation->set_rules('nuts3_name', $this->lang->line('nuts3_name'), 'trim|required'); 
		$this->form_validation->set_rules('nuts2_id', $this->lang->line('nuts2_id'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('nuts3', 'add', $data);
		}
		else {
			$db_data['nuts3_name'] = $this->input->post('nuts3_name'); 
			$db_data['nuts2_id'] = $this->input->post('nuts2_id'); 
			
			if (!$this->nuts3->add($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('nuts3', 'add', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('nuts3', 'add', $data);
			}
		}
	}

	function update($id)
	{
		$this->load->model('nuts2', '', TRUE); 
		
		$data['nuts2'] = $this->nuts2->dropdown(); 
		
		$this->load->model('nuts3','',TRUE);
		$data['row'] = $this->nuts3->get(array('nuts3_id' => $id));
		$this->form_validation->set_rules('nuts3_name', $this->lang->line('nuts3_name'), 'trim|required'); 
		$this->form_validation->set_rules('nuts2_id', $this->lang->line('nuts2_id'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('nuts3', 'update', $data);
		}
		else {
			$db_data['nuts3_id'] = $id;
			$db_data['nuts3_name'] = $this->input->post('nuts3_name'); 
			$db_data['nuts2_id'] = $this->input->post('nuts2_id'); 
			
			if (!$this->nuts3->update($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('nuts3', 'update', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('nuts3', 'update', $data);
			}
		}
	}

	function delete($id)
	{
		$db_data = array('nuts3_id' => $id);
    $this->db->trans_start();
    $this->nuts3->delete($db_data);
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
