<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		if(!empty($_SESSION['edu_name'])) {
		$data['title'] = 'Member Home';
		$data['template'] = 'home';
		$data['uname'] = $_SESSION['edu_name'];
		$this->load->model('home_model');
		$data['gk'] = $this->home_model->get_scrolling_gk();
		$data['success'] = $this->session->userdata('cpass');
		$data['message_to_all'] = $this->home_model->get_all_msg();
		$this->session->set_userdata('cpass', '');
		$this->load->view('container', $data);
		
		} else {
			redirect('login', 'refresh');
		}
	}
	
	function gk($id='')
	{
		if(!empty($_SESSION['edu_name'])) {
		$data['title'] = 'GK Section';
		$data['template'] = 'gk';
		$data['uname'] = $_SESSION['edu_name'];
		$data['uid'] = $_SESSION['edu_uid'];
		//chk paid user
		$this->load->model('home_model');
		
		$fpf = $this->home_model->chk_fee_remitted_for($_SESSION['edu_type']==USER_TYPE_USER ? $_SESSION['edu_iid'] : $data['uid']);
		
		$data['message_to_all'] = $this->home_model->get_all_msg();
		
		$fee_paid_for = $fpf['fee_remitted_for'];
		$user_status = $fpf['status'];
		
		$this->load->model('member_model');
		$member = $this->member_model->get_member($data['uid'], '');
		if( $_SESSION['edu_type']==USER_TYPE_USER ){
			if( $member['status']!=1 ){
				$user_status = 0;
			}
		}
		
		if(($fee_paid_for == 1 || $fee_paid_for == 2) && ($user_status == 1)) {
		$this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_gk();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'home/gk/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '10'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_gk'] = $this->admin_model->all_gk($Page_No, $config['per_page']);
		$data['alert_message'] = FALSE;
		} else {
		$data['alert_message'] = TRUE;
		}
		$this->load->view('container', $data);
		} else {
			redirect('login', 'refresh');
		}
	}
	
	function online_test($limit=0)
	{
		$timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		
		/*if(!empty($_SESSION['edu_uid'])) {
		  $data['title'] = 'Online Test';
		  $data['template'] = 'online_test';
		  $data['uname'] = $_SESSION['edu_name'];
		  $data['uid'] = $_SESSION['edu_uid'];
			//chk paid user
			$this->load->model('home_model');
			$fpf = $this->home_model->chk_fee_remitted_for($data['uid']);
			$fee_paid_for = $fpf['fee_remitted_for'];
			$user_status = $fpf['status'];
			if(($fee_paid_for == 0 || $fee_paid_for == 2) && ($user_status == 1)) {
				
			$data['online'] = "Coming Soon";
			$chktest = $this->home_model->chk_test();
			$data['alert_message'] = FALSE;
			if($chktest) {
				
				//get no of question from that batch + timings
				$data['test'] = $this->home_model->test_lists($chktest['batch_id'], $chktest);
				
			}
			
			} else {
			  $data['alert_message'] = TRUE;
			}
		$this->load->view('container', $data);
		} else {
			redirect('login', 'refresh');
		}*/
		
		if(!empty($_SESSION['edu_uid'])) {
		  	$data['title']		= 'Online Test';
		  	$data['template']	= 'online_test';
		  	$data['uname']		= $_SESSION['edu_name'];
		  	$data['uid']		= $_SESSION['edu_uid'];
		  
		  	//chk paid user
			$this->load->model('home_model');
			$data['message_to_all'] = $this->home_model->get_all_msg();
			$fpf = $this->home_model->chk_fee_remitted_for($_SESSION['edu_type']==USER_TYPE_USER ? $_SESSION['edu_iid'] : $data['uid']);

			$fee_paid_for	= $fpf['fee_remitted_for'];
			$user_status	= $fpf['status'];
			
			$this->load->model('member_model');
			$this->load->model('attempt_model');
			
			$member = $this->member_model->get_member($data['uid'], '');
			if( $_SESSION['edu_type']==USER_TYPE_USER ){
				if( $member['status']!=1 ){
					$user_status = 0;
				}
			}

			if(($fee_paid_for == 0 || $fee_paid_for == 2) && ($user_status == 1)) {
		  
				$this->load->helper('html');
				$this->load->helper('url');

				$query = $this->db->query('SELECT * FROM `test` WHERE `test_type_id` = "'.$member['test_type_id'].'" AND `sector_id` = "'.$member['sector_id'].'"');
				$data['test']			= $query->result_array();
				
				$data['online']			= "Coming Soon";
				$data['title']			= 'Online Test';
				$data['limit']			= $limit;
				$data['alert_message']	= FALSE;
		
			} 
			else{
				$data['alert_message'] = TRUE;
			}
	
			
			$this->load->view('container', $data);
		}
		else{
			redirect('login', 'refresh');
		}
		
	}
	
	function message_centre()
	{
		if(!empty($_SESSION['edu_uid'])) {
		  $data['title'] = 'Message Centre';
		  $data['template'] = 'msg';
		  $data['uname'] = $_SESSION['edu_name'];
		  $data['uid'] = $_SESSION['edu_uid'];
		  $data['success'] = $this->session->userdata('mc');
		  $this->session->set_userdata('mc', '');
		  $this->load->model('home_model');
		  $this->load->library('form_validation');
		  $data['msgs'] = $this->home_model->get_all_msgs($data['uid']);
		  $data['message_to_all'] = $this->home_model->get_all_msg();
			  if(isset($_POST['msg_sup'])) {
		  //$this->form_validation->set_rules('subject', 'Subject', 'required|trim|max_length[100]');
		  $this->form_validation->set_rules('message', 'Message', 'required|trim|max_length[1000]');
		  
			if ($this->form_validation->run() == FALSE)
			{
			  $this->load->view('container', $data);
			} else {
			  $data['update'] = $this->home_model->add_msg($this->input->post());
			   $this->session->set_userdata('mc', 'Message Sent Successfully');
			  redirect('home/message_centre', 'refresh');
			}
		  } else {
			   $this->load->view('container', $data);
		  }
		} else {
			redirect('login', 'refresh');
		}
	}
	
	function msg_centre_ajx()
	{
		if(!empty($_SESSION['edu_uid'])) {
			 $data['uname'] = $_SESSION['edu_name'];
		 	 $data['uid'] = $_SESSION['edu_uid'];
			  $data['success'] = $this->session->userdata('mcv');
		  $this->session->set_userdata('mcv', '');
		   $this->load->model('home_model');
			  $this->load->library('form_validation');
			  if(isset($_POST['msg_sup'])) {
				   $this->form_validation->set_rules('message', 'Message', 'required|trim|max_length[1000]');
		  
			if ($this->form_validation->run() == FALSE)
			{
			  $this->load->view('ajx_msg_centre', $data);
			} else {
			  $data['update'] = $this->home_model->add_msg($this->input->post());
			   $this->session->set_userdata('mcv', 'Message Sent Successfully');
			  redirect('home/msg_centre_ajx', 'refresh');
			}
				  
			 } else {
			   $this->load->view('ajx_msg_centre', $data);
		  }
			} else {
			redirect('login', 'refresh');
		}
	}
	
	function change_password()
	{
		if(!empty($_SESSION['edu_uid'])) {
		  $data['title'] = 'Change Password';
		  $data['template'] = 'change_password';
		  $this->load->model('home_model');
		  $data['message_to_all'] = $this->home_model->get_all_msg();
		  $this->load->library('form_validation');
		  if(isset($_POST['c_pass'])) {
		  $this->form_validation->set_rules('old_pass', 'Old Password', 'required|trim|callback_oldpass');
		  $this->form_validation->set_rules('new_pass', 'New Password', 'required|trim|min_length[6]|max_length[20]');
		  $this->form_validation->set_rules('new_pass_confirm', 'Confirm New Password', 'required|trim|matches[new_pass]');
		  
			if ($this->form_validation->run() == FALSE)
			{
			  $this->load->view('container', $data);
			} else {
			  $data['update'] = $this->home_model->update_password($this->input->post());
			   $this->session->set_userdata('cpass', 'Password Updated Successfully');
			  redirect('home', 'refresh');
			}
		  } else {
			   $this->load->view('container', $data);
		  }
		} else {
			redirect('login', 'refresh');
		}
	}	
	
	function oldpass($pass)
	{
		if(!empty($_SESSION['edu_uid'])) {
			$this->load->model('home_model');
			$chk_pass = $this->home_model->check_pass($pass);
			if ($chk_pass)
		     {
				 return true;
			 } else {
				 $this->form_validation->set_message('oldpass', 'Old password is wrong');
				 return false;
			 }
			
		} else {
			redirect('login', 'refresh');
		}
	}
	
	
	function edit_profile()
	{
		if(!empty($_SESSION['edu_uid'])) {
		  $data['title'] = 'Edit Profile';
		  $data['template'] = 'edit_profile';
		  $this->load->model('home_model');
		  $this->load->model('admin/admin_model');
		  $data['udetails'] = $this->admin_model->get_member_details($_SESSION['edu_uid']);
		  $data['message_to_all'] = $this->home_model->get_all_msg();
		  $data['success'] = $this->session->userdata('eprof');
		  $this->session->set_userdata('eprof', '');
		  $this->load->library('form_validation');
		  if(isset($_POST['e_profile'])) {
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_editemail');
			$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|xss_clean|max_length[11]|numeric');
			$this->form_validation->set_rules('city', 'City', 'required|trim|xss_clean');
			$this->form_validation->set_rules('pincode', 'Pincode', 'required|trim|xss_clean|max_length[6]|numeric');
			$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
			$this->form_validation->set_rules('landline', 'Landline', 'trim|xss_clean|numeric');	
		  
			if ($this->form_validation->run() == FALSE)
			{
			  $this->load->view('container', $data);
			} else {
			  $data['update'] = $this->home_model->update_profile($this->input->post());
			   $this->session->set_userdata('eprof', 'Profile Updated Successfully');
			  redirect('home/edit_profile', 'refresh');
			}
		  } else {
			   $this->load->view('container', $data);
		  }
		} else {
			redirect('login', 'refresh');
		}
	}	
	
	function editemail($email)
	{
		if(!empty($_SESSION['edu_uid'])) {
			$this->load->model('home_model');
			$chk_email = $this->home_model->check_emailupdate($email, $_SESSION['edu_uid']);
			if ($chk_email)
		     {
				 $this->form_validation->set_message('editemail', 'Email Already Exists');
				 return false;
			 } else {
				 return true;
			 }
			
		} else {
			redirect('login', 'refresh');
		}
	}
	
	
	public function view($tid='0')
	{
		$query = $this->db->query('SELECT `pid` FROM `test_attempt` WHERE `uid` = "'.$_SESSION['edu_uid'].'" AND `test_id` = "'.$tid.'" LIMIT 0,1');
		$info_test_attempt			= $query->row_array();
		$data['info_test_attempt']	= $info_test_attempt;
		/*if( isset($info_test_attempt['pid']) ){
			//redirect('home/online_test/');
			//exit();
		}*/

		$timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')){
			date_default_timezone_set($timezone);
		}

		$this->load->model('member_model');

		$this->load->model('attempt_model');
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();

		$this->load->helper('html');
		$this->load->helper('url');

	
	    $data['title']		= 'View Test';
		$data['template']	= 'viewtest';

	
		// view test detail
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->model('result_model');
		
		// generate access token by random string function which is required for next page or attempt test page
		$data['access_token']	= random_string('alnum', 16);
		$data['raccess_token']	= random_string('alnum', 16);
		$data['uaccess_token']	= random_string('alnum', 16);
		// getting subjects list

		// getting test detail by test id (tid)
		$data['test'] = $this->attempt_model->get_test($tid,'');
		// getting group detail
		$data['groupname'] = $this->attempt_model->get_group();
		// count number of attempts has been done by user
		$data['noattempts'] = $this->result_model->count_result_row($tid, $_SESSION['edu_uid']);
		// getting logged in user/member data
		$member = $this->member_model->get_member($_SESSION['edu_uid'],'');
		
		//$gid=$member['batch_id'];
		$gid = 1;
		$fee_paid_for=$member['fee_remitted_for'];
		
		if( $_SESSION['edu_type']==USER_TYPE_USER ){
			$memberParent = $this->member_model->get_member($_SESSION['edu_iid'],'');
			$fee_paid_for=$memberParent['fee_remitted_for'];
		}
		
		$data['msg']="";
		$data['startButton']=1; // default
		// check user credit
	
	
		if($fee_paid_for == 3) {
			$data['startButton']=0;
			$data['msg'].="You do not have enough credit to access this test!<br/>";
		}
		
		$query = $this->db->query('SELECT * FROM `test_set` WHERE `test_id` = "'.$data['test']['pid'].'"');
		$data['test_set'] = $query->result_array();
		
		$data['question'] = 0;
		$data['minutes'] = 0;
		foreach($data['test_set'] as $K=>$V){
			$data['question'] += $V['question'];
			$data['minutes'] += ($V['question']*$V['minutes']);
		}
		
		if( $data['question']==0 ){
			$data['startButton']=0;
			$data['msg'].="Not able to start a test!<br/>";			
		}
		
		if( $data['minutes']==0 ){
			$data['startButton']=0;
			$data['msg'].="Not able to start a test!<br/>";			
		}
		
		// check no of attempts
		/*if($data['noattempts']>=$data['test']['attempts']){
			$data['startButton']=0;
			$data['msg'].="You have exceeded the number of attempts!<br/>";
		}*/
		
		// check no of attempts
	/*	if($data['noattempts']>=$data['test']['attempts'])
		{
		$data['startButton']=0;
		$data['msg'].="You have exceeded the number of attempts!<br/>";
		} */
		
		// check start time 
		/*if((time())<($data['test']['start_time'])){
			$data['startButton']=0;
			$data['msg'].="Test is not available yet!<br/>";
		}*/
		
		// check end time
		/*if((time())>=($data['test']['end_time'])){
			$data['startButton']=0;
			$data['msg'].="Test time has been passed!<br/>";
		}*/
		
		
		$data['title']='Test / Quiz';
		//$group_id=explode(",",$data['test']['batch_id']);
		//if(in_array($gid, $group_id)){
		
		if(($data['startButton']=='1')){
			$cookie = array('name'=>'access_token','value'=>$data['access_token'],'expire'=>'86500'); 
			$cookie1 = array('name'=>'raccess_token','value'=>$data['raccess_token'],'expire'=>'86500'); 
			$cookie2 = array('name'=>'uraccess_token','value'=>$data['uaccess_token'],'expire'=>'86500'); 
			$this->input->set_cookie($cookie);
			$this->input->set_cookie($cookie1);
			$this->input->set_cookie($cookie2);
		}
		 
		$this->load->view('container',$data);
		/*}
		else
		{
		
		$data['title'] = 'View Test';
		$data['template'] = 'restricted';

		$this->load->view('container',$data);
		}*/
		
	}
	
	public function payment_details(){
		if(!empty($_SESSION['edu_name'])) {
			
			$data['title']		= 'Payment Details';
			$data['template']	= 'payment_details';
			$data['uname']		= $_SESSION['edu_name'];
			$data['uid']		= $_SESSION['edu_uid'];
			
			
			$this->load->model('home_model');
			
			$this->load->model('admin/admin_model');
			$total = $this->admin_model->db->where('uid', $_SESSION['edu_uid'])->count_all('payment_details');
			
			$this->load->library('pagination');
			
			$config['base_url']		= base_url().'home/payment_details/';
			$config['total_rows']	= $total;
			$config['per_page']		= '10';
			$config['uri_segment']	= 3;
			$config['num_links']	= 5;
			
			$Page_No = $this->uri->segment(3,0);
			
			$data['Page_No']		= $Page_No;
			
			$this->pagination->initialize($config);
			
			$query = $this->db->query('SELECT * FROM `payment_details` WHERE uid="'.$_SESSION['edu_uid'].'" ORDER BY pid DESC LIMIT '.$Page_No.', '.$config['per_page']);
			
			$data['all_list'] = $query->result_array();			
			
			$this->load->view('container', $data);
			
		}
		else{
			redirect('login', 'refresh');
		}
	}
	
	public function payment_add(){
		if(!empty($_SESSION['edu_name'])) {
			
			$this->load->model('home_model');
			$this->load->library('form_validation');
			
			$data['message_to_all'] = $this->home_model->get_all_msg();
			
			$data['title']		= 'Add Payment';
			$data['template']	= 'payment_add';
			$data['uname']		= $_SESSION['edu_name'];
			$data['uid']		= $_SESSION['edu_uid'];
			
			if(isset($_POST['save_form'])) {
				
				$this->form_validation->set_rules('test_type_id', 'Test Type', 'required|numeric');
				$this->form_validation->set_rules('sector_id', 'Sector', 'required|numeric');
				
				if( isset($_POST['test_type_id']) && isset($_POST['sector_id']) ){
					$query = $this->home_model->db->query('SELECT * FROM `sector` WHERE pid="'.( isset($_POST['sector_id']) ? $_POST['sector_id'] : '' ).'" LIMIT 1');
					$row = $query->row_array();
					if( isset($row['pid']) ){
						$_POST['test_type_id'] = $row['test_type_id'];
					}
					else{
						unset($_POST['sector_id']);
					}
				}
				
				$this->form_validation->set_rules('type', 'Type', 'required');
				if( isset($_POST['type']) && $_POST['type']==USER_TYPE_INSTITUTIONAL ){
					$this->form_validation->set_rules('user_count', 'No of users', 'required|trim|xss_clean|max_length[3]|numeric');
				}
				
				$this->form_validation->set_rules('paid', 'Amount paid', 'required|numeric');
				$this->form_validation->set_rules('paid_date', 'Amount paid', 'required|callback_payment_add_date');
				$this->form_validation->set_rules('transaction_no', 'Transaction no', 'required|trim|xss_clean|max_length[20]');
			
				if($this->form_validation->run() != FALSE){
					
					$data = array(
						'uid'			=> $_SESSION['edu_uid'],

						'test_type_id'	=> $this->db->escape_str($_POST['test_type_id']),
						'sector_id'		=> $this->db->escape_str($_POST['sector_id']),
						'type'			=> $this->db->escape_str($_POST['type']),
						'user_count'	=> $_POST['type']==USER_TYPE_INSTITUTIONAL ? $this->db->escape_str($_POST['user_count']) : 0,
							
						'paid'			=> $this->db->escape_str($_POST['paid']),
						'paid_date'		=> $this->db->escape_str($_POST['paid_date']),
						'transaction_no'=> $this->db->escape_str($_POST['transaction_no']),
						'date'			=> date("Y-m-d"),
					);
					$this->db->insert('payment_details', $data);
					$id = $this->db->insert_id();
					if( $id>0 ){
						$this->session->set_userdata('payment_details', 'Saved Successfully');
						redirect('home/payment_details', 'location');
						exit();
					}
				}
			}
			
			$this->load->view('container', $data);
			
		}
		else{
			redirect('login', 'refresh');
		}
	}
	
	public function payment_add_date($date){
		
		if($date && $date!=''){
			$date_1 = explode('-', $date);
			if( isset($date_1[0]) && isset($date_1[1]) && isset($date_1[2]) && checkdate($date_1[1], $date_1[2], $date_1[0])){
				$date_1 = implode('-', $date_1);
			}
			else{
				unset($date_1);
			}
		}
		else{
			$this->form_validation->set_message('payment_add_date', 'The Date field is invalid.');
			return false;			
		}
		
		if( !isset($date_1) ){
			$this->form_validation->set_message('payment_add_date', 'The Date field is required.');
			return false;
		}
		
		return true;
	}
		
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */