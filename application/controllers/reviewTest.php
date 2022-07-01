<?php
class reviewTest extends CI_Controller {
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
	public function index($rlt_id='',$access_token='0')
	{	
	
	    $this->load->model('home_model');
	$data['message_to_all'] = $this->home_model->get_all_msg();

		$this->load->helper('cookie');
		$this->load->library('form_validation');
		
	// if test cookies exist bypass to getquestion function
		if(isset($_COOKIE['rtid']) && isset($_COOKIE['rqids']) && isset($_COOKIE['rresultid']) && isset($_COOKIE['rqno']) && isset($_COOKIE['raccess_token']))
		{
			$qids = $this->attempt_model->get_rev_qid($rlt_id);
			$cookie = array('name'=>'rqids','value'=>$qids,'expire'=>'86500'); 
			$this->input->set_cookie($cookie);
			$cookie = array('name'=>'rresultid','value'=>$rlt_id,'expire'=>'86500'); 
			$this->input->set_cookie($cookie); 
			$this->getquestion(0,$_COOKIE['rqids'],$_COOKIE['rtid'], $_COOKIE['rresultid']);		
		}
		else
			{
	// else started new test so check access token cookie exist for test	if not redirect
			if(!isset($_COOKIE['raccess_token'])){
			redirect('home/view/'.$tid);
			}
			//from result id get test id
			$tid = $this->attempt_model->get_test_id($rlt_id);
	// getting test data
			$data['test'] = $this->attempt_model->get_test($tid,'0');
	// getting multi dimensonal arrays of question ids which are going to assign user
			//$data['qids'] = $this->attempt_model->get_questions_id($data['test']);
	// make one dimensonal array
			//$qid=array();
			//foreach($data['qids'] as $question)
			//{
			//$qid[]=$question['qid'];	
			//}
	// convert array into string
			$qids= $this->attempt_model->get_rev_qid($rlt_id);
	// insert result row
			$data['resultid']=$rlt_id;
	// creating required cookies
			$cookie = array('name'=>'rresultid','value'=>$rlt_id,'expire'=>'86500'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'rqids','value'=>$qids,'expire'=>'86500'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'rtid','value'=>$data['test']['tid'],'expire'=>'86500'); 
			$this->input->set_cookie($cookie); 
			$cookie = array('name'=>'rqno','value'=>'0','expire'=>'86500'); 
			$this->input->set_cookie($cookie); 
			$this->getquestion('0',$qids,$tid,$rlt_id);
			}
	}
	
	public function getquestion($qno=0,$qids=0,$tid=0,$resultid=0)
	{
		
		$this->load->model('home_model');
	$data['message_to_all'] = $this->home_model->get_all_msg();

	if(!isset($_COOKIE['raccess_token'])){
			redirect('home');
			}
	$this->load->helper('cookie');
	$this->load->library('form_validation');
	
	
	
	//define question ids
	if(isset($_COOKIE['rqids'])){
	$qids=$_COOKIE['rqids'];
	}else{
	$qids=$qids;
	}
	$eqid=explode(",",$qids);
	
	//define test id
	if(isset($_COOKIE['rtid'])){
	$tid=$_COOKIE['rtid'];
	}else{
	$tid=$tid;
	}
	
	if(isset($_COOKIE['rresultid'])){
	$resultid=$_COOKIE['rresultid'];
	}
	$iniTime = $this->attempt_model->get_result($resultid);
	$test_time = $this->attempt_model->get_test($tid,'0');
	// check time

	if(((($test_time['test_time']*60)-(time()-$iniTime['iniTime']))<="0") || ((time())>($test_time['end_time']))){
	$this->submit('Time Over');
		return;
		
	}
	
	// define question no.
	if(isset($_POST['qno'])){
	$qno=$_POST['qno'];
	$pqid=$eqid[$qno-1];
	if(isset($_POST['answer'])){
	$answer=$_POST['answer'];
	$time1=$_POST['time1'];
	$unans_qid = $_POST['uqid'];
	$this->attempt_model->remove_unans_qid($_COOKIE['resultid'], $unans_qid);
	}else{ 
	$answer='NULL'; $time1=$_POST['time1'];
	//insert unans qids
	$unans_qid = $_POST['uqid'];
	$this->attempt_model->update_unans_qid($_COOKIE['resultid'], $unans_qid);
	}
	
		if(isset($_POST['my_qid'])) {
	//get the correct qno key from question ids
	$original_qids = $this->attempt_model->get_c_qid($_COOKIE['rresultid']);
	$exp_ori_qids = explode(',',$original_qids);
	$new_qno = array_search($_POST['my_qid'],$exp_ori_qids, true);
	//echo $new_qno
	$new_qqno = $new_qno+1;
	$data['new_no'] = $new_qqno;
		} else { 
		
		//get the correct qno key from question ids
	$original_qids = $this->attempt_model->get_c_qid($_COOKIE['rresultid']);
	$exp_ori_qids = explode(',',$original_qids);
	$new_qno = array_search($pqid,$exp_ori_qids, true);
	$new_qqno = $new_qno+1;
	$data['new_no'] = $new_qqno;
		}
		
		
	$this->attempt_model->submit_answer($_COOKIE['rresultid'],$new_qqno,$_COOKIE['rtid'],$pqid,$answer,$time1);
	}
	
	if(isset($_POST['review_last']))
	{
		if($_POST['review_last']=='1')
		{
		redirect('attemptTest/index/'.$resultid);
		return;
		}
	}
	
	if(isset($_POST['submitTest']))
	{
		if($_POST['submitTest']=='1')
		{
		$this->submit();
		return;
		}
	}
	
	// next question
	if(isset($_POST['direction']))
	{
	// if direction is for next question add one
	if($_POST['direction']=='N'){ 
	$data['qno']=$qno+1; $qid=$eqid[$qno]; 
	}
	else
	{ 
	// else subtract one
	$data['qno']=$qno-1; 
	$qid=$eqid[$qno-2]; 
	}
	}
	else{
	$data['qno']=$qno+1;
	$qid=$eqid[$qno];
	}
	
	if(isset($_POST['my_qid'])) {
		
	$original_qids = $this->attempt_model->get_c_qid($_COOKIE['rresultid']);
	$exp_ori_qids = explode(',',$original_qids);
	$new_qno = array_search($_POST['my_qid'],$exp_ori_qids, true);
	$new_qqno = $new_qno+1;
	$data['new_no'] = $new_qqno;
	} else {
	$original_qids = $this->attempt_model->get_c_qid($resultid);
	$exp_ori_qids = explode(',',$original_qids);
	$new_qno = array_search($qid,$exp_ori_qids, true);
	$new_qqno = $new_qno;
	$data['new_no'] = $new_qqno;
	}
	

	// getting earlier submitted answer if any
	$data['result'] = $this->attempt_model->get_result($resultid);
	// getting test data
	$data['test'] = $this->attempt_model->get_test($tid,'0');

	// getting question data
	$data['question'] = $this->attempt_model->get_question($qid);
	
	//get subject and passage details
	$sub_pas_id = $this->attempt_model->get_sub_pass_id($qid);
	$data['s_name'] = $this->attempt_model->get_subject_name($sub_pas_id['sub_id']);
	if($sub_pas_id) {
	$data['passage_details'] = $this->attempt_model->get_passage_details($sub_pas_id['pid']);
	} else {
	$data['passage_details'] = '';
	}
	$data['unanswered'] = $this->attempt_model->get_unanswered($data['result']['selected_answers']);
	$data['review_qid'] = $qid;
	$data['my_qid'] = $qid;
	$data['uqid'] = $qid;
	$data['review_qids'] = $data['result']['review_ids'];
	$data['unans_qids'] = $data['result']['unans_ids'];
	$data['r_result_id'] = $resultid;
	// load header page
	//$this->load->view('header_attemptTest.php',$data);
	// load attempt test body page
	
	
	
	
	$data['title'] = 'Online Test';
		$data['template'] = 'reviewTest';

		$this->load->view('container',$data);

	
	//$this->load->view('attemptTest',$data);
	// load footer
	//$this->load->view('footer');
	// update cookies with question number
	$cookie = array('name'=>'rqno','value'=>$data['qno'],'expire'=>'86500'); 
	$this->input->set_cookie($cookie); 
	$cookie = array('name'=>'urqids','value'=>'','expire'=>'1'); 
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
	}
}
?>
