<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends CI_Controller {

	public function index()
	{
		global $data;
		$data['title'] = 'Contact Us';
		$data['template'] = 'contact';
		
		$this->load->view('container', $data);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */