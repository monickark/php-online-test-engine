<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {

	public function index()
	{
		global $data;
		$data['title'] = 'Forgot Password';
		$data['template'] = 'forgot';
		$data['s_pass'] = $this->session->userdata('s_pass');
		$this->session->set_userdata('s_pass', '');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_emailchk');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('container', $data);
		}
		else
		{
		  $this->load->model('registration_model');
		  //$register = $this->registration_model->login($this->input->post());
		  $userdetails = $this->registration_model->get_member_details_email($this->input->post('email'));
		  $password = $userdetails['password'];
		  $name = ucwords($userdetails['name']);
		  $subject = "Your Password";
		  $base_url = base_url();
		  $base_urllogin = base_url().'login';
		  $message = "Dear $name, <br><br> Login: Your email id <br>Password: $password<br><br> You may now log in to $base_urllogin by clicking on this link or copying and pasting it in your browser<br><br>Best Wishes,<br>$base_url";
		  $to =  $userdetails['email'];
		  $this->send_email($to, '1', $subject, $message);
		  
		   $this->session->set_userdata('s_pass', 'Password has been sent to your email id');
		   redirect('forgot_password', 'refresh');
		  
		}
	}
	
	public function emailchk($str)
	{
		$this->load->model('registration_model');
		$chkemail = $this->registration_model->chk_email($str);
		
		if ($chkemail)
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('emailchk', 'The "'.$str.'" not exists in our database');
			return FALSE;
		}
	}
	
	 function send_email($to, $bcc='', $subject, $message)
	 {
		$this->load->library('email');
		$this->email->from('rgovind.1609@gmail.com', 'AONE');
		$this->email->reply_to('rgovind.1609@gmail.com', 'AONE');
		$this->email->to($to);
		if(!empty($bcc)) {
		$this->email->bcc('itzurkarthi@gmail.com'); 
		}
		$this->email->subject($subject);
		$this->email->message($message);	
		$this->email->send();
		return true;
	 }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */