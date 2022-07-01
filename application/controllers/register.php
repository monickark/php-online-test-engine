<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index()
	{
		global $data;
		
		$data['title'] = 'Register';
		$data['template'] = 'register';
		$data['s_register'] = $this->session->userdata('s_register');
		$this->session->set_userdata('s_register', '');
		
		$this->load->model('home_model');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user_details.email]');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|xss_clean|max_length[11]|numeric');
		$this->form_validation->set_rules('city', 'City', 'required|trim|xss_clean');
		$this->form_validation->set_rules('pincode', 'Pincode', 'required|trim|xss_clean|max_length[6]|numeric');
		$this->form_validation->set_rules('year', 'Year', 'required|trim|xss_clean|max_length[4]|numeric');
		$this->form_validation->set_rules('qualification', 'Qualification', 'required|trim|xss_clean');				
		
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
		
		$this->form_validation->set_rules('type', 'Type', 'required');
		if( isset($_POST['type']) && $_POST['type']==USER_TYPE_INSTITUTIONAL ){
			
			if( isset($_POST['test_type_id']) ){
				unset($_POST['test_type_id']);
			}
			if( isset($_POST['sector_id']) ){

				unset($_POST['sector_id']);

			}
			
			$this->form_validation->set_rules('user_count', 'No of users', 'required|trim|xss_clean|max_length[3]|numeric');
			$this->form_validation->set_rules('how', 'How', 'required|trim|xss_clean');
		}
		else{
		
			$this->form_validation->set_rules('test_type_id', 'Test Type', 'required|numeric');
			$this->form_validation->set_rules('sector_id', 'Sector', 'required|numeric');
			$this->form_validation->set_rules('how', 'How', 'required|trim|xss_clean');
			
		}
		
		if(!empty($_POST['address'])) {
			$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
		}
		if(!empty($_POST['landline'])) {
			$this->form_validation->set_rules('landline', 'Landline', 'trim|xss_clean|numeric');	
		}

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('container', $data);
		}
		else
		{
		  $this->load->model('registration_model');
		  $register = $this->registration_model->register($this->input->post());
		  if($register) {
				   $userdetails = $this->registration_model->get_member_details($register);
				   $password = $userdetails['password'];
				   
				   $subject = "Your Account has been activated";
				   $base_url = base_url();
				   $base_urllogin = base_url().'login';
				   $message = "Dear Registrant, <br><br>Thank you for your registration with us.<br><br>Your account has been activated at $base_url <br><br> Login: Your email id <br>Password: $password<br><br> You may now log in to $base_urllogin by clicking on this link or copying and pasting it in your browser<br><br>Best Wishes,<br>$base_url";
				   $to =  $userdetails['email'];
				   $this->send_email($to, '1', $subject, $message);
			  
			  
			  $this->session->set_userdata('s_register', 'Thank you for registering with us. Activation email along with password has been sent to your email id');
			  redirect('register', 'refresh');
		  }
		  //$this->load->view('container', $data);
		}
	}
	
		 function send_email($to, $bcc='', $subject, $message)
	 {
		$this->load->library('email');
		$this->email->from('rgovind.1609@gmail.com', 'AONE');
		$this->email->reply_to('rgovind.1609@gmail.com', 'AONE');
		$this->email->to($to);
		if(!empty($bcc)) {
		$this->email->bcc('rgovind.1609@gmail.com'); 
		}
		$this->email->subject($subject);
		$this->email->message($message);	
		$this->email->send();
		return true;
	 }
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */