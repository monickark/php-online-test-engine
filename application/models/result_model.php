<?php
class result_model extends CI_Model {

	public function __construct()
	{	
		parent::__construct(); 
	}
	public function del_result($result_id)
	{
	$this->db->delete('result', array('result_id' => $result_id));
	}
	public function search_result($str)
	{
		$this->db->select('*');
		$this->db->from('result');
		$this->db->join('test', 'result.tid = test.tid' );
		$this->db->or_like('result.result_id',$str);
		$this->db->or_like('result.tid',$str);
		$this->db->or_like('test.test_name',$str);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	public function get_result($result_id, $limit)
	{
	
	if ($result_id>="1")
		{
		$sql="select result.*,test.*,user_details.name,user_details.u_id from result,test,user_details where result.test_id = test.pid and result_id = '$result_id' and result.uid = user_details.u_id  ";
		$query = $this->db->query($sql);
		return $query->row_array();
		}
	else{
		$this->db->select('*');
		$this->db->from('result');
		if(($this->session->userdata('su'))=='1'){
		$this->db->join('test', 'result.test_id = test.pid order by result_id DESC LIMIT '.$limit.', 30 ');
		}
		else
		{
		$uid= $_SESSION['edu_uid'];
		$this->db->join('test', 'result.test_id = test.pid and result.uid='.$uid.' order by result_id DESC LIMIT '.$limit.', 30 ');
		}
		$query = $this->db->get();
		return $query->result_array();
		
		}
	}
	
	
	public function count_result_row($tid,$uid)
	{
	$sql="select * from result where uid='$uid' and test_id='$tid' ";
	$query = $this->db->query($sql);
	$numrows=$query->num_rows();
	return $numrows;
	}
	
	function get_two_rows($result_id)
	{
		$query = $this->db->query("select `selected_answers`, `question_ids` from result where result_id=$result_id");
		return $query->row_array();
	}
	
	function insert_marks($dat, $rid){
		extract($dat);
		$uuid = $_SESSION['edu_uid'];

		//chk if mark is already generated
		//$query = $this->db->query("SELECT `result_id`, `u_id` FROM `gen_result` WHERE `result_id`=$rid AND `u_id`=$uuid");
		$query = $this->db->query('SELECT `result_id`, `u_id` FROM `gen_result` WHERE `result_id`='.$rid);
		if($query->num_rows() == 0){
			$q_array = explode(',', $question_ids);
			$s_ans_array = explode(',', $selected_answers);
			$ra_array = explode(',', $ra);
			$wa_array = explode(',', $wa);
			
			$sector_id_array = explode(',', $sector_id);
			$section_id_array = explode(',', $section_id);
			$section_sub_id_array = explode(',', $section_sub_id);
		
			foreach($q_array as $key => $val){
				$ques_id = $q_array[$key];
				$ra_score = $ra_array[$key];
				$wa_score = $wa_array[$key];
				
				$sanda = $this->get_subject_id_and_answer($ques_id);
				
				$mark = 0;
				$ans = 0;
				if($s_ans_array[$key] == $sanda['answer']){
					$mark = $ra_score;
					$ans = 1;
				}
				elseif($s_ans_array[$key] == -1){
				}
				else{
					$mark = -$wa_score;
					$ans = -1;
				}
				
				$datat = array(
					'result_id'		=> $rid ,
					'u_id'			=> $_SESSION['edu_uid'],
					'qid'			=> $ques_id,
					's_ans'			=> $s_ans_array[$key],
					'mark'			=> $mark,
					'is_right'		=> $ans,
					
					'sector_id'		=> $sector_id_array[$key],
					'section_id'	=> $section_id_array[$key],
					'section_sub_id'=> $section_sub_id_array[$key],
				);
	
				 $this->db->insert('gen_result', $datat);
			}
		}
	}
	
	function get_subject_id_and_answer($qid)
	{
		$query = $this->db->query("SELECT `answer` FROM `questions` WHERE `pid`=$qid");
		if($query->num_rows() > 0)
		{
		  $q = $query->row_array();
		  return $q;
		} else {
			return false;
		}
	}
	
	function get_subject_name($sub_id)
	{
		$query = $this->db->query("SELECT `subject` FROM `subject` WHERE `sub_id`=$sub_id");
		if($query->num_rows() > 0)
		{
		  $q = $query->row_array();
		  return $q['subject'];
		} else {
			return false;
		}
	}
	
	function get_user_email($uid)
	{
		$query = $this->db->query("SELECT `email` FROM `user_details` WHERE `u_id`=$uid");
		if($query->num_rows() > 0)
		{
		  $q = $query->row_array();
		  return $q['email'];
		} else {
			return false;
		}
	}
	
	function allocate_mark($s_ans, $c_ans)
	{
		if($s_ans == $c_ans)
		{
			$ans = 1;
		} elseif($s_ans == -1) {
			$ans = 0;
		} else {
			$ans = -0.25;
		}
		return $ans;
	}
	
	function get_marks_by_subject($rid)
	{
		$uuid = $_SESSION['edu_uid'];
		$query = $this->db->query("SELECT SUM(mark) as marks, sub_id, count(*) as sub FROM `gen_result` WHERE `result_id`=$rid AND `u_id`=$uuid GROUP BY `sub_id`");
		if($query->num_rows() > 0)
		{
			$mk = array();
			foreach($query->result_array() as $key => $val) {
				$mk[$key]['marks'] = $val['marks'];
				$mk[$key]['subject'] = $this->get_subject_name($val['sub_id']);
				$mk[$key]['tot_sub_qns'] = $val['sub'];
			}
			return $mk;
		} else {
			return false;
		}
	}
	
	function get_unans($rid)
	{
		$query = $this->db->query("SELECT `gr_id` FROM `gen_result` WHERE `s_ans`= -1");
		 return $query->num_rows();
	}
	
	function get_score($rid, $uid)
	{
		//$query = $this->db->query("SELECT SUM(mark) as score  FROM `gen_result` WHERE `result_id` = $rid AND `u_id` = $uid");
		$query = $this->db->query("SELECT SUM(mark) as score  FROM `gen_result` WHERE `result_id` = $rid");
		if($query->num_rows() > 0)
		{
		  $q = $query->row_array();
		  return $q['score'];
		} else {
			return false;
		}
	}
}


?>
