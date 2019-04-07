<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class User_prefs extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language'));
		$this->load->model('user_pref', '', TRUE);
	}
	
	function index()
	{
		$where = array('user_id' => $this->session->userdata('user_id'));
    $data['viewdata'] = $this->user_pref->dropdown($where);
		$this->templates->load('user_pref', 'list', $data);
	}
	
	function add()
	{
		$this->load->model('agritype', '', TRUE); 
		$this->load->model('nuts2', '', TRUE); 
		$this->load->model('nuts3', '', TRUE); 
		$this->load->model('nuts5', '', TRUE); 
		
		$data['agritype'] = $this->agritype->dropdown(); 
		$data['nuts2'] = $this->nuts2->dropdown(); 
		$data['nuts3'] = $this->nuts3->dropdown(); 
		$data['nuts5'] = $this->nuts5->dropdown(); 
		
		$this->form_validation->set_rules('agritype_id', $this->lang->line('agritype_id'), 'trim|required'); 
		$this->form_validation->set_rules('nuts2_id', $this->lang->line('nuts2_id'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('user_pref', 'add', $data);
		}
		else {
			$db_data['user_id'] = $this->session->userdata('user_id'); 
			$db_data['agritype_id'] = $this->input->post('agritype_id'); 
			$db_data['nuts2_id'] = $this->input->post('nuts2_id'); 
			$db_data['nuts3_id'] = $this->input->post('nuts3_id'); 
			$db_data['nuts5_id'] = $this->input->post('nuts5_id'); 
			
			if (!$this->user_pref->add($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('user_pref', 'add', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('user_pref', 'add', $data);
			}
		}
	}

	function update($id)
	{
		$this->load->model('agritype', '', TRUE); 
		$this->load->model('nuts2', '', TRUE); 
		$this->load->model('nuts3', '', TRUE); 
		$this->load->model('nuts5', '', TRUE); 
		
		$data['agritype'] = $this->agritype->dropdown(); 
		$data['nuts2'] = $this->nuts2->dropdown(); 
		$data['nuts3'] = $this->nuts3->dropdown(); 
		$data['nuts5'] = $this->nuts5->dropdown(); 
		
		$this->load->model('user_pref','',TRUE);
		$data['row'] = $this->user_pref->get(array('user_pref_id' => $id));
		$this->form_validation->set_rules('agritype_id', $this->lang->line('agritype_id'), 'trim|required'); 
		$this->form_validation->set_rules('nuts2_id', $this->lang->line('nuts2_id'), 'trim|required'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('user_pref', 'update', $data);
		}
		else {
			$db_data['user_pref_id'] = $id;
			$db_data['agritype_id'] = $this->input->post('agritype_id'); 
			$db_data['nuts2_id'] = $this->input->post('nuts2_id'); 
			$db_data['nuts3_id'] = $this->input->post('nuts3_id'); 
			$db_data['nuts5_id'] = $this->input->post('nuts5_id'); 
			
			if (!$this->user_pref->update($db_data)) {
				$this->session->set_flashdata('message', $this->lang->line('failure'));
				$this->session->set_flashdata('messagetype', 'danger');
				$this->templates->load('user_pref', 'update', $data);
			}
			else {
				$this->session->set_flashdata('message', $this->lang->line('success'));
				$this->session->set_flashdata('messagetype', 'success');
				$this->templates->load('user_pref', 'update', $data);
			}
		}
	}

	function delete($id)
	{
		$db_data = array('user_pref_id' => $id);
    $this->db->trans_start();
    $this->user_pref->delete($db_data);
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
