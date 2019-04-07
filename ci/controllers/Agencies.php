<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Agencies extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->model('agency', '', TRUE);
	}
	
	function index()
	{
		$data['viewdata'] = $this->agency->dropdown();
		$this->templates->load('agency', 'list', $data);
	}
	
	function add()
	{
		
		
		$this->form_validation->set_rules('agency_name', $this->lang->line('agency_name'), 'trim|required'); 
		$this->form_validation->set_rules('agency_address', $this->lang->line('agency_address'), 'trim|required'); 
		$this->form_validation->set_rules('agency_zip', $this->lang->line('agency_zip'), 'trim|required'); 
		$this->form_validation->set_rules('agency_city', $this->lang->line('agency_city'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('agency', 'add', $data);
		}
		else {
			$db_data['agency_name'] = $this->input->post('agency_name'); 
			$db_data['agency_address'] = $this->input->post('agency_address'); 
			$db_data['agency_zip'] = $this->input->post('agency_zip'); 
			$db_data['agency_city'] = $this->input->post('agency_city'); 
			
			if (!$this->agency->add($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('agency', 'add', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('agency', 'add', $data);
			}
		}
	}

	function update($id)
	{
		
		
		$this->load->model('agency','',TRUE);
		$data['row'] = $this->agency->get(array('agency_id' => $id));
		$this->form_validation->set_rules('agency_name', $this->lang->line('agency_name'), 'trim|required'); 
		$this->form_validation->set_rules('agency_address', $this->lang->line('agency_address'), 'trim|required'); 
		$this->form_validation->set_rules('agency_zip', $this->lang->line('agency_zip'), 'trim|required'); 
		$this->form_validation->set_rules('agency_city', $this->lang->line('agency_city'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('agency', 'update', $data);
		}
		else {
			$db_data['agency_id'] = $id;
			$db_data['agency_name'] = $this->input->post('agency_name'); 
			$db_data['agency_address'] = $this->input->post('agency_address'); 
			$db_data['agency_zip'] = $this->input->post('agency_zip'); 
			$db_data['agency_city'] = $this->input->post('agency_city'); 
			
			if (!$this->agency->update($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('agency', 'update', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('agency', 'update', $data);
			}
		}
	}

	function delete($id)
	{
		$db_data = array('agency_id' => $id);
    $this->db->trans_start();
    $this->agency->delete($db_data);
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
