<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fee_details extends CI_Controller {

	public function index()
	{
		global $data;
		$data['title'] = 'Fee Details';
		$data['template'] = 'fee';
		
		$this->load->view('container', $data);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */