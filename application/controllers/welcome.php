<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data['title'] = 'A-ONE Test Engine';
		$data['template'] = 'index';
		$this->load->view('container', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */