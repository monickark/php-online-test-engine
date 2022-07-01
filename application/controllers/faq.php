<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function index()
	{
		global $data;
		$data['title'] = 'FAQ';
		$data['template'] = 'faq';
		
		$this->load->view('container', $data);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */