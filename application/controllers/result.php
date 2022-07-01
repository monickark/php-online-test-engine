<?php
class Result extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('result_model');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
		//if not logged in redirect
		//if(($this->session->userdata('logged_in'))!='TRUE'){ redirect('login'); }
		
	}
	public function index($limit = 0)
	{	
	// getting result rows
	 if(!empty($_SESSION['edu_uid'])) { 
		$data['result'] = $this->result_model->get_result('0',$limit);
		$data['title']='Result';
		$data['template'] = 'all_results';
		$data['limit']=$limit;
		$this->load->model('home_model');
	$data['message_to_all'] = $this->home_model->get_all_msg();
		$this->load->view('container',$data);
	 } else {
		 redirect('', 'refresh');
	 }
	}
	public function search($str)
	{	
	// getting result rows of searched string
		$data['result'] = $this->result_model->search_result($str);
		$data['title']='Result';
		$this->load->view('header',$data);
	// only if logged in user is admin
		if(($this->session->userdata('su'))=='1'){
		$this->load->view('result',$data);
		}
		else
		{
		$this->load->view('restricted',$data);
		}
		$this->load->view('footer');
	}
	
	public function del($resultid)
	{
	// delete result record
		if(($this->session->userdata('su'))=='1'){
		$this->result_model->del_result($resultid);
		}
		$this->index();
	}
	
	public function view($resultid,$emailsend='email')
	{	
	// view result dtail
	
		$data['result'] = $this->result_model->get_result($resultid,'0');
		$two_rows = $this->result_model->get_two_rows($resultid);
		$marks = $this->result_model->insert_marks($two_rows, $resultid);
		$data['marks'] = $this->result_model->get_marks_by_subject($resultid);
		$data['my_score'] = $this->result_model->get_score($resultid, $data['result']['uid']);
		//$data['unans'] = $this->result_model->get_unans($resultid);
		$data['title']='Online Test Result';
		$data['template'] = 'view_result';
		$this->load->model('home_model');
	$data['message_to_all'] = $this->home_model->get_all_msg();
		
		if((($_SESSION['edu_uid'])==$data['result']['uid']) || (($this->session->userdata('su'))=='1')){
		// if admin allow result send in email in config file and if user requested to email
			if(($this->config->item('email_result')=="yes") && $emailsend=="email")
			{
		// preparing email variables
			$email_subject = ucwords($data['result']['title'])." Result - ".date("l dS \of F Y");
			$email_msg = "Dear ".$data['result']['name'].",\n\n";
			$email_msg .= $this->load->view('mark_email', $data, true);
			$email_to = $this->result_model->get_user_email($_SESSION['edu_uid']);
			$email_from=$this->config->item('admin_email');	
			$this->email->from($email_from, "Bank Exam");
			$this->email->to($email_to);
			$this->email->bcc("rgovind.1609@gmail.com");
			//$this->email->to("itzurkarthi@gmail.com");
			$this->email->subject($email_subject);
			$this->email->message($email_msg);
			
		// send email
			@$this->email->send();
			$data['msg']="Result sent to email!<br>";
			}
		
		$this->load->view('container',$data);
		if($this->config->item('graph')=="yes"){
		$this->load->view('ColumnChart',$data);
		}
		
		
		}
		else
		{
		$this->load->view('restricted',$data);
		}
	}
	
}
?>