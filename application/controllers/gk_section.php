<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gk_section extends CI_Controller {

	public function index()
	{
		if(!empty($_SESSION['edu_name'])) {
		$data['title'] = 'GK Section';
		$data['template'] = 'gk';
		$data['uname'] = $_SESSION['edu_name'];
		$this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_gk();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/manage_gk/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '100'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_gk'] = $this->admin_model->all_gk($Page_No, $config['per_page']);
		$this->load->view('container', $data);
		
		} else {
			redirect('login', 'refresh');
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */