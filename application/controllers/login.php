<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Login extends CI_Controller {



	public function index()

	{

		global $data;

		$data['title'] = 'Login';

		$data['template'] = 'login';

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_emailchk');

		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');



		if ($this->form_validation->run() == FALSE)

		{

			$this->load->view('container', $data);

		}

		else

		{

		  $this->load->model('registration_model');

		  $chk_login = $this->registration_model->login($this->input->post());

		  if($chk_login) {
		      
            $cookie = array('name'=>'resultid','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'qids','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'tid','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'qno','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'access_token','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie);
			//unset review cookies	
		    $cookie = array('name'=>'rresultid','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'rqids','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'rtid','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'rqno','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'raccess_token','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie);
			
			
			//unset unans cookies	
	   		$cookie = array('name'=>'urresultid','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'urqids','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'urtid','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'urqno','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'uraccess_token','value'=>'','expire'=>'1'); 
			$this->input->set_cookie($cookie);

			  redirect('home', 'refresh');

		  } else {

			  $this->load->view('container', $data);

		  }

		}

	}

	

	public function emailchk($str)

	{

		$this->load->model('registration_model');

		$chkemail = $this->registration_model->chk_email1($str);

		

		if ($chkemail)

		{

			if($chkemail['logged_in'] == 0) {

			return TRUE;

			} else {

			$this->form_validation->set_message('emailchk', '"'.$str.'" already loggedin into another machine. If problem persists, pls contact the Administrator');

			return FALSE;				

			}

		}

		else

		{

			$this->form_validation->set_message('emailchk', 'The "'.$str.'" not exists in our database');

			return FALSE;

		}

	}

}



/* End of file login.php */

/* Location: ./application/controllers/login.php */