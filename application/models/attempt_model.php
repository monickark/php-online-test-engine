<?php
class attempt_model extends CI_Model {

	public function __construct()
	{	
		$this->load->database();
	}
	
	
	public function get_questions_id($test)
	{	
	
	//print_r($test);
	
		$noq=$test['random_question_no'];
		$batch_id=$test['batch_id'];
		//$sids=explode(',',$test['subject_ids']);
	    $sql="(select qid from questions where batch_id='$batch_id' order by `sub_id` ASC LIMIT $noq )";
		$query = $this->db->query($sql);
		$questions=$query->result_array();
	    return $questions;
		
		
	}
	
	
	
	// return single question
	public function get_question($qid){
		$sql		= "select * from questions where pid='$qid' ";
		$query		= $this->db->query($sql);
		$questions	= $query->row_array();
		return $questions;
	}
	
	// return multiple questions
	public function get_questions($qids)
	{	
	$sql="select * from questions where qid in($qids) ORDER BY FIELD(qid, $qids)  ";
	$query = $this->db->query($sql);
	$questions=$query->result_array();
	return $questions;
	}
	
	
	
	public function get_result($resultid)
	{	
		$sql	= "select * from result where result_id='$resultid' ";
		$query	= $this->db->query($sql);
		$result	= $query->row_array();
		return $result;
	}
	
	
	
	
	public function submit_answer($resultid, $qno, $tid, $qid, $posted_answer, $time1){
		$sql	= "select * from result where result_id='$resultid' ";
		$query1 = $this->db->query($sql);
		$result	= $query1->row_array();
		
		// getting correct answer from question
		$sql	= "select answer from questions where pid='$qid' ";
		$query	= $this->db->query($sql);
		$answer	= $query->row_array();
	
		//compare posted answer with correct answer
		$correct_answer		= explode(",",$result['correct_answer']);
		$selected_answers	= explode(",",$result['selected_answers']);
		$time_taken			= explode(",",$result['time_taken']);
		$time2				= (time()-$time1);
		$time_taken[$qno-1]	= ($time_taken[$qno-1])+$time2;
		
		if($posted_answer!='NULL'){
			if($posted_answer==$answer['answer']){
				$correct_answer[$qno-1]	= "1";
			}
			else{
				$correct_answer[$qno-1]	= "0";
			}
			$selected_answers[$qno-1]	= $posted_answer;
		}
		else{
			if($posted_answer==$answer['answer']){
				$correct_answer[$qno-1]	= "-1";
			}
			else{
				$correct_answer[$qno-1]	= "-1";
			}
			$selected_answers[$qno-1]	= "-1";
		}
	
		$correct_answer		= implode(",",$correct_answer);
		$selected_answers	= implode(",",$selected_answers);
		$time_taken			= implode(",",$time_taken);
	
		//Update result row
		$data = array('correct_answer' => $correct_answer,'selected_answers' => $selected_answers,'time_taken' => $time_taken);
		$this->db->where('result_id', $resultid);
		$this->db->update('result', $data);
	}
	
	public function submit_test($resultid,$tid)
	{
	// getting test data
	$sql="select * from test where pid='$tid' ";
	$query1 = $this->db->query($sql);
	$test=$query1->row_array();
		
	// getting result data
	$sql="select * from result where result_id='$resultid' ";
	$query2 = $this->db->query($sql);
	$result=$query2->row_array();
	
	// calculating result
	$correct_answer=$result['correct_answer'];
	$correct_answer=str_replace("-1","0",$correct_answer);
	$correct_answer=explode(",",$correct_answer);
	$correctans=array_sum($correct_answer);
	$percentage=($correctans/$result['total_question'])*100;
	/*if($percentage>=$test['reqpercentage'])
	{
	$status="1";
	}
	else
	{
	$status="0";
	}*/
	$status = "1";
	
	// update result row
	$data = array('obtained_percentage' => $percentage,'status' => $status,'submitTime'=>time());
	$this->db->where('result_id', $resultid);
	$this->db->update('result', $data);	
	}
	
	
	
	
	
	public function insert_result_row($test, $questionList){
		$temp_ques			= array();
		$temp_value			= array();
		$temp_time_avail	= array();
		$temp_time_taken	= array();

		$temp_sector_id		= array();
		$temp_section_id	= array();
		$temp_section_sub_id= array();
		$temp_ra			= array();
		$temp_wa			= array();

		$total = 0;
		foreach($questionList as $K=>$V){
			$total++;
			$temp_ques[$K]			= $V['pid'];
			$temp_value[$K]			= '-1';
			$temp_time_avail[$K]	= $V['minutes'];
			$temp_time_taken[$K]	= '0';
			
			$temp_sector_id[$K]		= $V['sector_id'];
			$temp_section_id[$K]	= $V['section_id'];
			$temp_section_sub_id[$K]= $V['section_sub_id'];
			$temp_ra[$K]			= $V['ra'];
			$temp_wa[$K]			= $V['wa'];
		}
		
		$temp_ques			= implode(',', $temp_ques);
		$temp_value			= implode(',', $temp_value);
		$temp_time_avail	= implode(',', $temp_time_avail);
		$temp_time_taken	= implode(',', $temp_time_taken);

		$temp_sector_id		= implode(',', $temp_sector_id);
		$temp_section_id	= implode(',', $temp_section_id);
		$temp_section_sub_id= implode(',', $temp_section_sub_id);
		$temp_ra			= implode(',', $temp_ra);
		$temp_wa			= implode(',', $temp_wa);
	
		$uid = $_SESSION['edu_uid'];
	
		// insert row
		$data = array(
			'uid'				=> $uid,
			'test_id'			=> $test['pid'],
			'total_question'	=> $total,
			'correct_answer'	=> $temp_value,
			'time_avail'		=> $temp_time_avail,
			'time_taken'		=> $temp_time_taken,

			'sector_id'			=> $temp_sector_id,
			'section_id'		=> $temp_section_id,
			'section_sub_id'	=> $temp_section_sub_id,
			'ra'				=> $temp_ra,
			'wa'				=> $temp_wa,

			'selected_answers'	=> $temp_value,
			'question_ids'		=> $temp_ques,
			'status'			=> '2',
			'iniTime'			=> time()
		);
		$this->db->insert('result', $data); 
		return $this->db->insert_id();

	}
	
	
	
	public function get_test($slug='0', $limit='30'){
		if ($slug>="1"){
			$this->db->select('*');
			$this->db->from('test');
			$this->db->where('pid = '.$slug );
			$query = $this->db->get();
			return $query->row_array();
		}
		else{
		
			$tim = time();
			$query = $this->db->query("SELECT * FROM `test` WHERE `start_time` <= '$tim' AND `end_time` >= '$tim'");
			return $query->result_array();
		
		}
	}
	
	
	
	public function get_group($gid = FALSE)
	{
	if ($gid === FALSE)
		{
		$this->db->select('*');
		$this->db->from('batch');
		//$this->db->join('subject', 'questionBank.sid = subject.sid');
		$query = $this->db->get();
		return $query->result_array();
		}
	
		$this->db->select('*');
		$this->db->where('batch_id',$gid);
		$this->db->from('batch');
		//$this->db->join('subject', 'questionBank.sid = subject.sid and qid = '.$slug );
		$query = $this->db->get();
		return $query->row_array();
	}

	function get_sub_pass_id($qid)
	{
		$this->db->select('sub_id, pid');
		$this->db->where('qid',$qid);
		$this->db->from('questions');
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_subject_name($sub_id)
	{
		
		$this->db->select('subject');
		$this->db->where('sub_id', $sub_id);
		$query = $this->db->get('subject');
		
		if($query->num_rows() > 0)
		{
			$topic = $query->row_array();
			return $topic['subject'];
		}
		else
		{
		return false;
		}
	}
	
	function get_passage_details($pid)
	{
		
		$this->db->select('passage_title, passage_desc');
		$this->db->where('pid', $pid);
		$query = $this->db->get('passage');
		
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
		return false;
		}
	}
	
	function get_unanswered($str)
	{
		$arr=explode(",", $str); 
		$newArray = array_count_values($arr);

		foreach ($newArray as $key=>$value){
			if($key === -1) {
				$val = $value;
				break;
			}
			else {
				$val = 0;
			}
		}

		return $val;
	}
	
	function update_review_qid($result_id, $rev_qid) {
		
		$get_rev_qid = $this->get_rev_qid($result_id);
		
		if($get_rev_qid) {
		$new_rev_id = $get_rev_qid.",".$rev_qid;
		} else {
		$new_rev_id = $rev_qid;
		}
		
		//update result table
		$data = array(
               'review_ids' => $new_rev_id
            );
        $this->db->where('result_id', $result_id);
		$this->db->update('result', $data);
		return true;
		
	}
	
	function get_rev_qid($result_id)
	{
		$this->db->select('review_ids');
		$this->db->where('result_id', $result_id);
		$query = $this->db->get('result');
		
		if($query->num_rows() > 0)
		{
			$topic = $query->row_array();
			return $topic['review_ids'];
		}
		else
		{
		return false;
		}
	}
	
	function get_c_qid($result_id)
	{
		$this->db->select('question_ids');
		$this->db->where('result_id', $result_id);
		$query = $this->db->get('result');
		
		if($query->num_rows() > 0)
		{
			$topic = $query->row_array();
			return $topic['question_ids'];
		}
		else
		{
		return false;
		}
	}
	
	function get_test_id($result_id)
	{
		$this->db->select('tid');
		$this->db->where('result_id', $result_id);
		$query = $this->db->get('result');
		
		if($query->num_rows() > 0)
		{
			$topic = $query->row_array();
			return $topic['tid'];
		}
		else
		{
		return false;
		}
	}
	
	function update_unans_qid($result_id, $unans_qid) {
		
		$get_unans_qid = $this->get_unans_qid($result_id);
		
		if($get_unans_qid) {
		
		  $a1 = explode(',', $get_unans_qid);
		  $ak = explode(',', $get_unans_qid);
		  $a1_size = sizeof($ak);
		  $a2= explode(',', $unans_qid);
		  $a3 = array();
		  $a3 = array_diff($a1,$a2);
		  $a3_size = sizeof($a3);
		  if($a1_size === $a3_size) {
		  	$new_unans_id = $get_unans_qid.",".$unans_qid;
		  } else {
		   $new_unans_id = $get_unans_qid;
		  }
		
		
		} else {
		$new_unans_id = $unans_qid;
		}
		
		//update result table
		$data = array(
               'unans_ids' => $new_unans_id
            );
        $this->db->where('result_id', $result_id);
		$this->db->update('result', $data);
		return true;
		
	}
	
	function remove_unans_qid($result_id, $unans_qid) {
		
		$get_unans_qid = $this->get_unans_qid($result_id);
		
		if($get_unans_qid) {
		
		  $a1 = explode(',', $get_unans_qid);
		  $ak = explode(',', $get_unans_qid);
		  $a1_size = sizeof($ak);
		  $a2= explode(',', $unans_qid);
		  $a3 = array();
		  $a3 = array_diff($a1,$a2);
		  $a3_size = sizeof($a3);
		  //if($a1_size === $a3_size) {
		  	//$new_unans_id = $get_unans_qid.",".$unans_qid;
		 //} else {
		   $new_unans_id = implode(',', $a3);
		  //}
		
		
		} else {
		$new_unans_id = '';
		}
		
		//update result table
		$data = array(
               'unans_ids' => $new_unans_id
            );
        $this->db->where('result_id', $result_id);
		$this->db->update('result', $data);
		return true;
		
	}
	
	function get_unans_qid($result_id)
	{
		$this->db->select('unans_ids');
		$this->db->where('result_id', $result_id);
		$query = $this->db->get('result');
		
		if($query->num_rows() > 0)
		{
			$topic = $query->row_array();
			return $topic['unans_ids'];
		}
		else
		{
		return false;
		}
	}
		
}
?>