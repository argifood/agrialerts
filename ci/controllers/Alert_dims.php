<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Alert_dims extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->model('alert_dim', '', TRUE);
	}
	
	function index()
	{
    $this->session->set_flashdata('message', $this->lang->line('no_alert'));
    $this->session->set_flashdata('messagetype', 'warning');
    redirect(site_url('alerts'));
	}
	
	function add()
	{
		if(!$this->session->userdata('alert')){
				$this->session->set_flashdata('message', $this->lang->line('no_alert'));
				$this->session->set_flashdata('messagetype', 'warning');
        redirect(site_url('alerts'));
    	}
		$this->load->model('alerttype', '', TRUE); 
    	$this->load->model('agritype', '', TRUE); 
		$this->load->model('nuts2', '', TRUE); 
		$this->load->model('nuts3', '', TRUE); 
		$this->load->model('nuts5', '', TRUE); 
		
		$data['alerttype'] = $this->alerttype->dropdown(); 
		$data['agritype'] = $this->agritype->dropdown(); 
		$data['nuts2'] = $this->nuts2->dropdown(); 
		$data['nuts3'] = $this->nuts3->dropdown(); 
		$data['nuts5'] = $this->nuts5->dropdown(); 
		
		$this->form_validation->set_rules('alerttype_id', $this->lang->line('alerttype_id'), 'trim|required'); 
		$this->form_validation->set_rules('agritype_id', $this->lang->line('agritype_id'), 'trim|required'); 
		$this->form_validation->set_rules('agri_dim_severity', $this->lang->line('agri_dim_severity'), 'trim|required'); 
		$this->form_validation->set_rules('nuts2_id', $this->lang->line('nuts2_id'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('alert_dim', 'add', $data);
		}
		else {
			$db_data['alert_id'] = $this->session->userdata('alert'); 
			$db_data['alerttype_id'] = $this->input->post('alerttype_id'); 
			$db_data['agritype_id'] = $this->input->post('agritype_id'); 
			$db_data['agri_dim_severity'] = $this->input->post('agri_dim_severity'); 
			$db_data['nuts2_id'] = $this->input->post('nuts2_id'); 
			$db_data['nuts3_id'] = $this->input->post('nuts3_id'); 
			$db_data['nuts5_id'] = $this->input->post('nuts5_id'); 
			
			if (!$this->alert_dim->add($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('alert_dim', 'add', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('alert_dim', 'add', $data);
			}
		}
	}

	function update($id)
	{
		$this->load->model('alerttype', '', TRUE); 
		$this->load->model('agritype', '', TRUE); 
		$this->load->model('nuts2', '', TRUE); 
		$this->load->model('nuts3', '', TRUE); 
		$this->load->model('nuts5', '', TRUE); 
		
		$data['alerttype'] = $this->alerttype->dropdown(); 
		$data['agritype'] = $this->agritype->dropdown(); 
		$data['nuts2'] = $this->nuts2->dropdown(); 
		$data['nuts3'] = $this->nuts3->dropdown(); 
		$data['nuts5'] = $this->nuts5->dropdown(); 
		
		$this->load->model('alert_dim','',TRUE);
		$data['row'] = $this->alert_dim->get(array('alert_dim_id' => $id));

		$this->form_validation->set_rules('alerttype_id', $this->lang->line('alerttype_id'), 'trim|required'); 
		$this->form_validation->set_rules('agritype_id', $this->lang->line('agritype_id'), 'trim|required'); 
		$this->form_validation->set_rules('agri_dim_severity', $this->lang->line('agri_dim_severity'), 'trim|required'); 
		$this->form_validation->set_rules('nuts2_id', $this->lang->line('nuts2_id'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('alert_dim', 'update', $data);
		}
		else {
			$db_data['alert_dim_id'] = $id;
			$db_data['alerttype_id'] = $this->input->post('alerttype_id'); 
			$db_data['agritype_id'] = $this->input->post('agritype_id'); 
			$db_data['agri_dim_severity'] = $this->input->post('agri_dim_severity'); 
			$db_data['nuts2_id'] = $this->input->post('nuts2_id'); 
			$db_data['nuts3_id'] = $this->input->post('nuts3_id'); 
			$db_data['nuts5_id'] = $this->input->post('nuts5_id'); 
			
			if (!$this->alert_dim->update($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('alert_dim', 'update', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('alert_dim', 'update', $data);
			}
		}
	}

	function delete($id)
	{
		$db_data = array('alert_dim_id' => $id);
    	$this->db->trans_start();
    	$this->alert_dim->delete($db_data);
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
