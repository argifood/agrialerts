<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Alerts extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('loggedin')){
			redirect(site_url('user/login'));
		}
		$this->lang->load(array('labels', 'alerts'), 'greek');
		$this->load->helper(array('form', 'url', 'language', 'format'));
		$this->load->model('alert', '', TRUE);
	}
	
	function index()
	{
		$data['viewdata'] = $this->alert->dropdown();
		$this->templates->load('alert', 'list', $data);
	}
	
	function add()
	{
		$this->load->model('agency', '', TRUE); 
		
		$data['agency'] = $this->agency->dropdown(); 
		
		$this->form_validation->set_rules('alert_name', $this->lang->line('alert_name'), 'trim|required'); 
		$this->form_validation->set_rules('agency_id', $this->lang->line('agency_id'), 'trim|required'); 
		$this->form_validation->set_rules('alert_from', $this->lang->line('alert_from'), 'trim|required'); 
		$this->form_validation->set_rules('alert_to', $this->lang->line('alert_to'), 'trim'); 
		$this->form_validation->set_rules('alert_file', $this->lang->line('alert_file'), 'trim'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('alert', 'add', $data);
		}
		else {
			$db_data['alert_name'] = $this->input->post('alert_name'); 
			$db_data['agency_id'] = $this->input->post('agency_id'); 
			$db_data['alert_from'] = prety_date($this->input->post('alert_from')); 
			$db_data['alert_to'] = prety_date($this->input->post('alert_to')); 
			$db_data['alert_file'] = $this->input->post('alert_file'); 
			
			$config['upload_path'] = APPPATH.'fldrs/tmp';
			$config['allowed_types'] = 'docx|doc|pdf';
			$config['max_size'] = DEFAULT_UPLOAD_SIZE;
			$config['overwrite'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			if ( $this->upload->do_upload()){
  			$db_data['alert_file'] = $this->upload->data('file_name'); 
        $new_id = $this->alert->add($db_data);
        if (!$new_id) {
          $this->session->set_flashdata('message', $this->lang->line('failure'));
          $this->session->set_flashdata('messagetype', 'danger');
          $this->templates->load('alert', 'add', $data);
        }
        else {
          $thePath = APPPATH.'fldrs/'.$new_id;
          if (!file_exists($thePath)) {
            mkdir($thePath, 0777, TRUE);
          }         
          if(copy($this->upload->data('full_path'), $thePath.'/'.$this->upload->data('file_name'))){
            unlink($this->upload->data('full_path'));
            $this->session->set_flashdata('message', $this->lang->line('success'));
            $this->session->set_flashdata('messagetype', 'success');
            $this->session->set_userdata('alert', $new_id);
            redirect(site_url('alert_dims/add'));
          }
          else {
            unlink($this->upload->data('full_path'));
            $this->session->set_flashdata('message', 'Το αρχείο δεν ανέβηκε σωστά. Παρακαλώ, δοκιμάστε ξανά.');
            $this->session->set_flashdata('messagetype', 'danger');
            redirect(site_url('alerts/update'.$new_id));
          }
        }
      }
		}
	}

	function update($id)
	{
		$this->load->model('agency', '', TRUE); 
		$this->load->model('alert_dim', '', TRUE); 
		
		$data['agency'] = $this->agency->dropdown(); 
		$this->session->set_userdata('alert', $id);
		$this->load->model('alert','',TRUE);
    	$where = array('alert_id' => $id);
		$data['row'] = $this->alert->get($where);
		$data['viewdata'] = $this->alert_dim->dropdown($where);
		$this->form_validation->set_rules('alert_name', $this->lang->line('alert_name'), 'trim|required'); 
		$this->form_validation->set_rules('agency_id', $this->lang->line('agency_id'), 'trim|required'); 
		$this->form_validation->set_rules('alert_from', $this->lang->line('alert_from'), 'trim|required'); 
		$this->form_validation->set_rules('alert_to', $this->lang->line('alert_to'), 'trim'); 
		$this->form_validation->set_rules('alert_file', $this->lang->line('alert_file'), 'trim'); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->templates->load('alert', 'update', $data);
		}
		else {
      $uperrors = '';
			$db_data['alert_id'] = $id;
			$db_data['alert_name'] = $this->input->post('alert_name'); 
			$db_data['agency_id'] = $this->input->post('agency_id'); 
			$db_data['alert_from'] =  prety_date($this->input->post('alert_from')); 
			$db_data['alert_to'] = prety_date($this->input->post('alert_to')); 
			
      $thePath = APPPATH.'fldrs/'.$id;
			$config['upload_path'] = $thePath;
			$config['allowed_types'] = 'docx|doc|pdf';
			$config['max_size'] = DEFAULT_UPLOAD_SIZE;
			$config['overwrite'] = TRUE;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
      if (!empty($_FILES['userfile']['name'])){
        if ( $this->upload->do_upload()){
          $db_data['alert_file'] = $this->upload->data('file_name');
          unlink($thePath.'/'.$data['row']['alert_file']);
        }
         else {
          $uperrors .= $this->upload->display_errors();
        }
      }
      if($uperrors === ''){
        if (!$this->alert->update($db_data)) {
          $this->session->set_flashdata('message', $this->lang->line('failure'));
          $this->session->set_flashdata('messagetype', 'danger');
          $this->templates->load('alert', 'update', $data);
        }
        else {
          $this->session->set_flashdata('message', $this->lang->line('success'));
          $this->session->set_flashdata('messagetype', 'success');
          $data['row'] = $this->alert->get(array('alert_id' => $id));
          $this->templates->load('alert', 'update', $data);
        }
      }
      else {
        $this->session->set_flashdata('message', $uperrors);
        $this->session->set_flashdata('messagetype', 'danger');
      }
		}
	}

	function delete($id)
	{
		$db_data = array('alert_id' => $id);
    $this->db->trans_start();
    if($this->alert->delete($db_data)){
      $this->load->helper('file');
      delete_files(APPPATH.'fldrs/'.$id.'/');
      rmdir('fldrs/'.$id);
    }
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
