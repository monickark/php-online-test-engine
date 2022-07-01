<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_us extends CI_Controller {

	public function index()
	{
		global $data;
		$data['title'] = 'About Us';
		$data['template'] = 'about';
		
		$this->load->view('container', $data);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */