<?php
class attemptTest extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('attempt_model');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('session');
	// if not logged in redirect
		if(empty($_SESSION['edu_uid'])) { redirect('login'); } 
	}

	public function index($tid='',$access_token='0'){
	
		$this->load->helper('cookie');
		$this->load->library('form_validation');
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();

		
		// if test cookies exist bypass to getquestion function
		if(isset($_COOKIE['tid']) && isset($_COOKIE['qids']) && isset($_COOKIE['resultid']) && isset($_COOKIE['qno']) && isset($_COOKIE['access_token'])){
			$this->getquestion($_COOKIE['qno'], $_COOKIE['qids'], $_COOKIE['tid']);		
		}

		// else started new test so check access token cookie exist for test	if not redirect
		else{
			$query = $this->db->query('SELECT `pid` FROM `test_attempt` WHERE `uid` = "'.$_SESSION['edu_uid'].'" AND `test_id` = "'.$tid.'" LIMIT 0,1');
			$info_test_attempt = $query->row_array();
			if( isset($info_test_attempt['pid']) ){
				redirect('home/view/'.$tid);
				exit();
			}
			
			if( !isset($_COOKIE['access_token']) ){
				redirect('home/view/'.$tid);
				exit();
			}

			// getting test data
			$data['test'] = $this->attempt_model->get_test($tid);
			
			$query = $this->db->query('SELECT * FROM `test_set` WHERE `test_id` = "'.$data['test']['pid'].'"');
			$data['test_set'] = $query->result_array();
			
			
			$questionList = array();
			$data['question'] = 0;
		
			foreach($data['test_set'] as $K=>$V){
				$data['question'] += $V['question'];
				
				$query = $this->db->query('SELECT * FROM `questions` WHERE `section_sub_id` = "'.$V['section_sub_id'].'" ORDER BY RAND() LIMIT 0,'.$V['question']);
				$questions = $query->result_array();
				
				if( count($questions)!=$V['question'] ){
					redirect('home/view/'.$tid);
					exit();					
				}
				
				foreach($questions as $K1=>$V1){
					$qids[] = $V1['pid'];
					$questionList[] = array_merge(
						$V1,
						array(
							'minutes'		=> $V['minutes'],
							'sector_id'		=> $V['sector_id'],
							'section_id'	=> $V['section_id'],
							'section_sub_id'=> $V['section_sub_id'],
							'ra'			=> $V['ra'],
							'wa'			=> $V['wa'],
						)
					);
				}
				
			}
			
			if( count($questionList)!=$data['question'] ){
				redirect('home/view/'.$tid);
				exit();				
			}

			// insert result row
			$data['resultid']	= $this->attempt_model->insert_result_row($data['test'], $questionList);
			$this->db->insert('test_attempt', array(
				'uid'		=> $_SESSION['edu_uid'],
				'test_id'	=> $data['test']['pid'],
				'last_test'	=> $data['resultid'],
				'date'		=> date('Y-m-d H:i:s'),
			));

			// creating required cookies
			$cookie = array('name'=>'resultid', 'value'=>$data['resultid'], 'expire'=>'86500'); 
			$this->input->set_cookie($cookie);

			$cookie = array('name'=>'qids', 'value'=>implode(',', $qids), 'expire'=>'86500'); 
			$this->input->set_cookie($cookie);

			$cookie = array('name'=>'tid', 'value'=>$data['test']['pid'],'expire'=>'86500'); 
			$this->input->set_cookie($cookie);

			$cookie = array('name'=>'qno', 'value'=>'0','expire'=>'86500'); 
			$this->input->set_cookie($cookie);

			$this->getquestion('0', $qids, $tid, $data['resultid']);
		}
	}
	
	public function getquestion($qno=0, $qids=0, $tid=0, $resultid=0)
	{
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();

		if(!isset($_COOKIE['access_token'])){
			redirect('home');
		}
		$this->load->helper('cookie');
		$this->load->library('form_validation');
	
		if(isset($_COOKIE['resultid'])){
			$resultid = $_COOKIE['resultid'];
		}
		
		$iniTime = $this->attempt_model->get_result($resultid);
	
		if(isset($iniTime['result_id'])){
			$qids = $iniTime['question_ids'];
			$tid = $iniTime['test_id'];
		}
		$eqid		= explode(",", $qids);
		$time_taken = explode(",", $iniTime['time_taken']);
		$time_avail = explode(",", $iniTime['time_avail']);

		$sector_id		= explode(",", $iniTime['sector_id']);
		$section_id		= explode(",", $iniTime['section_id']);
		$section_sub_id	= explode(",", $iniTime['section_sub_id']);
		$ra				= explode(",", $iniTime['ra']);
		$wa				= explode(",", $iniTime['wa']);
		
		$data['question_total'] = count($eqid);
		
		$test_time = $this->attempt_model->get_test($tid, '0');
		// check time
		
		$data['question_time_taken'] = 0;
		$data['question_time_avail'] = 0;
		
		$data['sector_id']			= 0;
		$data['section_id']			= 0;
		$data['section_sub_id']		= 0;
		$data['ra']					= 0;
		$data['wa']					= 0;
	
		// define question no.
		if(isset($_POST['qno'])){
			$qno = $_POST['qno'];
			$pqid = $eqid[$qno-1];
			if(isset($_POST['answer'])){
				$answer		= $_POST['answer'];
				$time1		= $_POST['time1'];
				$unans_qid	= $_POST['uqid'];
				$this->attempt_model->remove_unans_qid($_COOKIE['resultid'], $unans_qid);
			}
			else{
				$answer		= 'NULL';
				$time1		= $_POST['time1'];
				//insert unans qids
				$unans_qid	= $_POST['uqid'];
				$this->attempt_model->update_unans_qid($_COOKIE['resultid'], $unans_qid);
			}
			if( $qno==$data['question_total'] ){
				$_POST['submitTest']='1';
			}
			$this->attempt_model->submit_answer($_COOKIE['resultid'], $qno, $_COOKIE['tid'], $pqid, $answer, $time1);
		}
	
		if( isset($_POST['submitTest']) ){
			if( $_POST['submitTest']=='1' ){
				$this->submit();
				return;
			}
		}
	
		// next question
		if( isset($_POST['direction']) ){
			// if direction is for next question add one
			if( $_POST['direction']=='N' ){
				$data['qno']			= $qno+1;
				$qid					= $eqid[$qno];
				$data['question_time_taken']	= $time_taken[$qno];
				$data['question_time_avail']	= $time_avail[$qno];
		
				$data['sector_id']				= $sector_id[$qno];
				$data['section_id']				= $section_id[$qno];
				$data['section_sub_id']			= $section_sub_id[$qno];
				$data['ra']						= $ra[$qno];
				$data['wa']						= $wa[$qno];
			}
			else{
				// else subtract one
				$data['qno']			= $qno-1;
				$qid					= $eqid[$qno-2];
				$data['question_time_taken']	= $time_taken[$qno-2];
				$data['question_time_avail']	= $time_avail[$qno-2];
		
				$data['sector_id']				= $sector_id[$qno-2];
				$data['section_id']				= $section_id[$qno-2];
				$data['section_sub_id']			= $section_sub_id[$qno-2];
				$data['ra']						= $ra[$qno-2];
				$data['wa']						= $wa[$qno-2];
			}
		}
		else{
			if( !empty($eqid[$qno]) ){
				$data['qno']			= $qno+1;
				$qid					= $eqid[$qno];
				$data['question_time_taken']	= $time_taken[$qno];
				$data['question_time_avail']	= $time_avail[$qno];
		
				$data['sector_id']				= $sector_id[$qno];
				$data['section_id']				= $section_id[$qno];
				$data['section_sub_id']			= $section_sub_id[$qno];
				$data['ra']						= $ra[$qno];
				$data['wa']						= $wa[$qno];
			}
			else{
				$data['qno']			= $qno-1;
				$qid					= $eqid[$qno-2];
				$data['question_time_taken']	= $time_taken[$qno-2];
				$data['question_time_avail']	= $time_avail[$qno-2];
		
				$data['sector_id']				= $sector_id[$qno-2];
				$data['section_id']				= $section_id[$qno-2];
				$data['section_sub_id']			= $section_sub_id[$qno-2];
				$data['ra']						= $ra[$qno-2];
				$data['wa']						= $wa[$qno-2];
			}
		}
		
		while( $data['question_time_taken']>0 || $data['question_time_avail']==0 ){
			$qno					= $qno+1;
			$data['qno']			= $qno+1;
			if( isset($eqid[$qno]) ){
				$qid					= $eqid[$qno];
				$data['question_time_taken']	= $time_taken[$qno];
				$data['question_time_avail']	= $time_avail[$qno];
		
				$data['sector_id']				= $sector_id[$qno];
				$data['section_id']				= $section_id[$qno];
				$data['section_sub_id']			= $section_sub_id[$qno];
				$data['ra']						= $ra[$qno];
				$data['wa']						= $wa[$qno];
			}
			else{
				return;
			}
		}

		// getting earlier submitted answer if any
		$data['result']			= $this->attempt_model->get_result($resultid);
		// getting test data
		$data['test']			= $this->attempt_model->get_test($tid,'0');
		// getting question data
		$data['question']		= $this->attempt_model->get_question($qid);
	
		$data['unanswered']		= $this->attempt_model->get_unanswered($data['result']['selected_answers']);
		$data['review_qid']		= $qid;
		$data['uqid']			= $qid;
		$data['review_qids']	= $data['result']['review_ids'];
		$data['unans_qids']		= $data['result']['unans_ids'];
		$data['r_result_id']	= $resultid;
		// load header page
		//$this->load->view('header_attemptTest.php',$data);
		// load attempt test body page
	
		$data['title']			= 'Online Test';
		$data['template']		= 'attemptTest';

		$this->load->view('container',$data);

	
		//$this->load->view('attemptTest', $data);
		// load footer
		//$this->load->view('footer');
		// update cookies with question number
		$cookie					= array('name'=>'qno', 'value'=>$data['qno'], 'expire'=>'86500'); 
		$this->input->set_cookie($cookie);
		 
		$cookie					= array('name'=>'urqids', 'value'=>'', 'expire'=>'1'); 
		$this->input->set_cookie($cookie);
	}
	
	
	public function submit($msg='')
	{	
		$this->load->helper('cookie');
		$this->attempt_model->submit_test($_COOKIE['resultid'],$_COOKIE['tid']);
		//page title meassage
		$data['title']="Test Submitted";
		$data['msg']=$msg;
		$data['resultid']=$_COOKIE['resultid'];
		//$this->load->view('header.php',$data);
		
		//data['title'] = 'Online Test';
		$data['template'] = 'submitTest';

		$this->load->view('container',$data);
		//$this->load->view('submitTest',$data);
		//$this->load->view('footer');
		//unset test cookies
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
		
		$this->load->model('result_model');
		
		$data['result'] = $this->result_model->get_result($data['resultid'], '0');
		
		$query = $this->result_model->db->query('select `selected_answers`, `question_ids`, `ra`, `wa`, `sector_id`, `section_id`, `section_sub_id` from result where result_id='.$data['resultid']);
		$resultInfo = $query->row_array();
			
		$this->result_model->insert_marks($resultInfo, $data['resultid']);
		
		if( $this->config->item('email_result')=="yes" ){
		
			$data['score'] = $this->result_model->get_score($data['resultid'], $data['result']['uid']);
		
			$query = $this->result_model->db->query('SELECT * FROM `gen_result` WHERE `result_id` = '.$data['resultid'].' ORDER BY gr_id ASC');
			$data['marks'] = $query->result_array();
				
			$this->load->library('email');
			// preparing email variables
			$email_subject = ucwords($data['result']['title'])." Result - ".date("l dS \of F Y");
				
			$email_msg = $this->load->view('test_success_email', $data, true);
				
			$email_to = $this->result_model->get_user_email($_SESSION['edu_uid']);
			$email_from=$this->config->item('admin_email');
			$this->email->from($email_from, "Online Exam");
			$this->email->to($email_to);
			$this->email->bcc("midenarif@gmail.com", "rgovind.1609@gmail.com");
			$this->email->subject($email_subject);
			$this->email->message($email_msg);
		
			//send email
			$this->email->send();
			//print_r($this->email);
			//exit();
		}
		
		redirect('attemptTest/success/'.$data['resultid']);
		exit();
	}
	
	public function success($resultid=0){
		
		$this->load->model('result_model');
		
		$data['result'] = $this->result_model->get_result($resultid, '0');
		
		$data['score'] = $this->result_model->get_score($resultid, $data['result']['uid']);
		
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();
		
		if( isset($data['result']['result_id']) ){
			
			$data['title']		= 'Online Test Result';
			$data['template']	= 'view_success';
			
			$this->load->view('container', $data);
		
		}

	}
	
	public function careerPointer($resultid=0){
	
		$this->load->model('result_model');
	
		$data['result'] = $this->result_model->get_result($resultid, '0');
	
		$data['score'] = $this->result_model->get_score($resultid, $data['result']['uid']);
	
		$query = $this->result_model->db->query('SELECT `result_id`, `section_id`, AVG(mark) as score  FROM `gen_result` WHERE `result_id` = '.$resultid.' GROUP BY `section_id`');
		$data['marks'] = $query->result_array();
	
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();
		
		$this->load->model('admin/admin_model');
		$data['udetails'] = $this->admin_model->get_member_details($data['result']['uid']);
	
		if( isset($data['result']['result_id']) ){
				
			$data['title']		= 'Online Test Result';
			$data['template']	= 'career_pointer';
				
			$this->load->view('container', $data);
	
		}
	
	}
	
	public function careerPointerSection($resultid=0, $section_id=0){
	
		$this->load->model('result_model');
	
		$data['result'] = $this->result_model->get_result($resultid, '0');
	
		$data['score'] = $this->result_model->get_score($resultid, $data['result']['uid']);
	
		$query = $this->result_model->db->query('SELECT `result_id`, `section_id`, AVG(mark) as score  FROM `gen_result` WHERE `result_id` = '.$resultid.' '.(
			$section_id>0 ? ' AND `section_id` = '.$section_id.' ' : ''
		).' GROUP BY `section_id`');
		$data['marks'] = $query->result_array();
	
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();
		
		$this->load->model('admin/admin_model');
		$data['udetails'] = $this->admin_model->get_member_details($data['result']['uid']);
	
		if( isset($data['result']['result_id']) ){
				
			$data['title']		= 'Online Test Result';
			$data['template']	= 'career_pointer_section';
				
			$this->load->view('container', $data);
	
		}
	
	}
	
	public function resultView($resultid=0){
		
		$this->load->model('result_model');
		
		$data['result'] = $this->result_model->get_result($resultid, '0');
		
		$data['score'] = $this->result_model->get_score($resultid, $data['result']['uid']);
		
		$query = $this->result_model->db->query('SELECT `section_id`, COUNT(`qid`) as ques, COUNT( IF(is_right=1, 1, NULL) ) as rans, COUNT( IF(is_right=-1, 1, NULL) ) as wans, SUM(mark) as score  FROM `gen_result` WHERE `result_id` = '.$resultid.' GROUP BY `section_id`');
		$data['marks'] = $query->result_array();
		
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();
		
		if( isset($data['result']['result_id']) ){
			
			$data['title']		= 'Online Test Result';
			$data['template']	= 'result_view';
			
			$this->load->view('container', $data);
		
		}

	}
	
	public function resultSectionView($resultid=0, $section_id=0){
		
		$this->load->model('result_model');
		
		$data['result'] = $this->result_model->get_result($resultid, '0');
		
		$data['score'] = $this->result_model->get_score($resultid, $data['result']['uid']);
		
		$query = $this->result_model->db->query('SELECT * FROM `gen_result` WHERE `result_id` = '.$resultid.' AND `section_id` = '.$section_id.'');
		$data['marks'] = $query->result_array();
		
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();
		
		if( isset($data['result']['result_id']) ){
			
			$data['title']		= 'Online Test Result';
			$data['template']	= 'result_section_view';
			
			$this->load->view('container', $data);
		
		}

	}
	
	public function resultList(){
		
		$this->load->model('result_model');
		$this->load->model('admin/admin_model');
		
		if( $_SESSION['edu_type']==USER_TYPE_INSTITUTIONAL ){
			
			$query = $this->result_model->db->query('
			SELECT t.result_id, t.uid, t.test_id 
			FROM `result` t LEFT OUTER JOIN `user_details` ud ON t.uid=ud.u_id AND ud.iid = '.$_SESSION['edu_uid'].'
			WHERE ud.iid = '.$_SESSION['edu_uid'].' AND t.status=1 AND t.uid=ud.u_id ORDER BY t.result_id DESC
			');
			$data['results'] = $query->result_array();
		}
		else{
			$query = $this->result_model->db->query('SELECT result_id, uid, test_id  FROM `result` WHERE `uid` = '.$_SESSION['edu_uid'].' AND status=1 ORDER BY result_id DESC ');
			$data['results'] = $query->result_array();
		}
		
		$this->load->model('home_model');
		$data['message_to_all'] = $this->home_model->get_all_msg();
			
		$data['title']		= 'Online Test Result List';
		$data['template']	= 'result_list';
		
		$this->load->view('container', $data);

	}
	
	public function certificate($resultid=0){
		
		$this->load->model('admin/admin_model');
		$this->load->model('result_model');
		
		$data['result'] = $this->result_model->get_result($resultid, '0');
		
		$data['score'] = $this->result_model->get_score($resultid, $data['result']['uid']);
		
		$query = $this->result_model->db->query('SELECT `section_id`, COUNT(`qid`) as ques, COUNT( IF(is_right=1, 1, NULL) ) as rans, COUNT( IF(is_right=-1, 1, NULL) ) as wans, SUM(mark) as score  FROM `gen_result` WHERE `result_id` = '.$resultid.' GROUP BY `section_id`');
		$data['marks'] = $query->result_array();
		
		$data['udetails'] = $this->admin_model->get_member_details($data['result']['uid']);
		
		if( isset($data['result']['result_id']) ){
			
			$this->load->view('certificate', $data);
		
		}

	}
}
?>
