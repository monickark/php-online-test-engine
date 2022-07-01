<?php
class user extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('attempt_model');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('session');
		// if not logged in redirect
		if(empty($_SESSION['edu_uid'])) {
			redirect('login');
		}

		if( $_SESSION['edu_type']!=USER_TYPE_INSTITUTIONAL ){
			redirect('home');
		}
	}
	
	public function listing(){

		$data['title'] = 'Manage Users';
		$data['template'] = 'user_list';
		$data['uname'] = $_SESSION['edu_name'];
		$data['uid'] = $_SESSION['edu_uid'];
		$this->load->model('home_model');
		$data['gk'] = $this->home_model->get_scrolling_gk();
		$data['message_to_all'] = $this->home_model->get_all_msg();
		
		$this->load->model('user_model');
		$total_users = $this->user_model->count($_SESSION['edu_uid']);
		$this->load->library('pagination');
		$config['base_url'] = base_url().'user/listing/';
		$config['total_rows'] = $total_users;
		$config['per_page'] = '10';
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_users'] = $this->user_model->all($_SESSION['edu_uid'], $Page_No, $config['per_page']);

		$this->load->view('container', $data);
		
	}
	
	public function create(){
		
		$this->load->model('user_model');
		
		$total_users = $this->user_model->count($_SESSION['edu_uid']);
		
		if( $total_users>=$_SESSION['edu_user_count'] ){
			$this->session->set_userdata('manage_user_error', 'Reached limits');
			redirect('user/listing/');
			exit();
		}

		$data['title'] = 'Create User';
		$data['uname'] = $_SESSION['edu_name'];
		$data['uid'] = $_SESSION['edu_uid'];
		$this->load->model('home_model');
		$data['gk'] = $this->home_model->get_scrolling_gk();
		$data['message_to_all'] = $this->home_model->get_all_msg();
			
		$data['form_url'] = base_url().'user/create/';
			
		$data['form_type'] = 'add';
		
		$this->postForm($data);
		
	}
	
	function edit($u_id=''){
		
		$this->load->model('user_model');

		$data['title'] = 'Edit User';
		$data['uname'] = $_SESSION['edu_name'];
		$data['uid'] = $_SESSION['edu_uid'];
		$this->load->model('home_model');
		$data['gk'] = $this->home_model->get_scrolling_gk();
		$data['message_to_all'] = $this->home_model->get_all_msg();
			
		$data['form_url'] = base_url().'user/edit/'.$u_id;
			
		$data['form_type'] = 'edit';
		
		$this->load->model('user_model');
		$data['details'] = $this->user_model->get($u_id);
		
		if( !( $data['details']!=false && isset($data['details']['iid']) && $data['details']['iid']==$_SESSION['edu_uid'] ) ){
			$this->session->set_userdata('manage_user_error', 'Invalid Record');
			redirect('user/listing/');
			exit();
		}
		
		$this->postForm($data, $u_id);
	
	}
	
	private function postForm($data, $u_id=''){
		$data['template'] = 'user_post_form';
		
		$this->load->library('form_validation');
	
		$data['success'] = $this->session->userdata('manage_user_success');
		$this->session->set_userdata('manage_user_success', '');
		$data['error'] = $this->session->userdata('manage_user_error');
		$this->session->set_userdata('manage_user_error', '');
	
		if(isset($_POST['save_form'])) {
			
			if( isset($data['details']['email']) && isset($_POST['email']) && $data['details']['email']==$_POST['email'] ){
				$is_unique =  '';
			}
			else{
				$is_unique =  '|is_unique[user_details.email]';
			}
			
			$data['details'] = $_POST;
		
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email'.$is_unique);
			
			if( isset($_POST['test_type_id']) && isset($_POST['sector_id']) ){
				$query = $this->home_model->db->query('SELECT * FROM `sector` WHERE pid="'.( isset($_POST['sector_id']) ? $_POST['sector_id'] : '' ).'" LIMIT 1');
				$row = $query->row_array();
				if( isset($row['pid']) ){
					$_POST['test_type_id'] = $row['test_type_id'];
				}
				else{
					unset($_POST['sector_id']);
				}
			}
			
			$this->form_validation->set_rules('test_type_id', 'Test Type', 'required|numeric');
			$this->form_validation->set_rules('sector_id', 'Sector', 'required|numeric');
	
			if ($this->form_validation->run() != FALSE){
	
				if( $data['form_type'] == 'add' ){
					$data['update'] = $this->user_model->add($this->input->post());
				}
				elseif( $data['form_type'] == 'edit' ){
					$data['update'] = $this->user_model->update($this->input->post(), $u_id);
				}
	
				if($data['update']) {
					$this->session->set_userdata('manage_user_success', $data['form_type'] == 'add' ? 'Added Successfully' : 'Updated Successfully');
					redirect('user/listing/');
					exit();
				}
	
			}
	
		}

		$this->load->view('container', $data);
	}
}