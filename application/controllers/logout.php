<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		$this->load->model('home_model');
		$clearlog = $this->home_model->clear_log($_SESSION['edu_uid']);
		unset($_SESSION['logged_in']);
        unset($_SESSION['logged_status']);
		unset($_SESSION['edu_name']);
		unset($_SESSION['edu_uid']);
		session_destroy();
        $this->session->sess_destroy();
		redirect('', 'refresh');
	}
}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */