<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Nuts5s extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->model('nuts5', '', TRUE);
	}
	
	function index()
	{
		$data['viewdata'] = $this->nuts5->dropdown();
		$this->templates->load('nuts5', 'list', $data);
	}
	
	function add()
	{
		$this->load->model('nuts3', '', TRUE); 
		
		$data['nuts3'] = $this->nuts3->dropdown(); 
		
		$this->form_validation->set_rules('nuts5_name', $this->lang->line('nuts5_name'), 'trim|required'); 
		$this->form_validation->set_rules('nuts3_id', $this->lang->line('nuts3_id'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('nuts5', 'add', $data);
		}
		else {
			$db_data['nuts5_name'] = $this->input->post('nuts5_name'); 
			$db_data['nuts3_id'] = $this->input->post('nuts3_id'); 
			
			if (!$this->nuts5->add($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('nuts5', 'add', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('nuts5', 'add', $data);
			}
		}
	}

	function update($id)
	{
		$this->load->model('nuts3', '', TRUE); 
		
		$data['nuts3'] = $this->nuts3->dropdown(); 
		
		$this->load->model('nuts5','',TRUE);
		$data['row'] = $this->nuts5->get(array('nuts5_id' => $id));
		$this->form_validation->set_rules('nuts5_name', $this->lang->line('nuts5_name'), 'trim|required'); 
		$this->form_validation->set_rules('nuts3_id', $this->lang->line('nuts3_id'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('nuts5', 'update', $data);
		}
		else {
			$db_data['nuts5_id'] = $id;
			$db_data['nuts5_name'] = $this->input->post('nuts5_name'); 
			$db_data['nuts3_id'] = $this->input->post('nuts3_id'); 
			
			if (!$this->nuts5->update($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('nuts5', 'update', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('nuts5', 'update', $data);
			}
		}
	}

	function delete($id)
	{
		$db_data = array('nuts5_id' => $id);
    $this->db->trans_start();
    $this->nuts5->delete($db_data);
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
