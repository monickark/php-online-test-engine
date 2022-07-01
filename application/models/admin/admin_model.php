<?php
class admin_model extends CI_Model 
{
 	
    function __construct()
    {       
       parent::__construct();     
    }
	
	function total_statistics()
	{
		$dat = array();
		$dat['members'] = $this->db->count_all('user_details');
		$dat['active'] = $this->count_status(1);
		$dat['inactive'] = $this->count_status(0);
		$dat['gk'] = $this->db->count_all('gk');
		$dat['subjects'] = $this->db->count_all('subject');;
		$dat['questions'] = $this->db->count_all('questions');
		return $dat;
	}
	
	function count_status($status)
	{
		$this->db->where('status', $status);
		$this->db->from('user_details');
		return $this->db->count_all_results();
	}
	
	function count_all_member_logs()
	{
		$this->db->where('logged_in', 1);
		$this->db->from('user_details');
		return $this->db->count_all_results();
	}
	
	function count_all_members()
	{
		return $this->db->count_all('user_details');
	}
	
	function count_all_tests()
	{
		return $this->db->count_all('test');
	}
	
	function count_all_members_active()
	{
		$this->db->where('status', 1);
		$this->db->from('user_details');
		return $this->db->count_all_results();
	}
	
	function count_all_members_inactive()
	{
		$this->db->where('status', 0);
		$this->db->from('user_details');
		return $this->db->count_all_results();
	}
	
	function count_all_msgs()
	{
		$this->db->where('type', 'p');
		$this->db->from('msg_centre');
		return $this->db->count_all_results();
	}
	
	function count_all_gk()
	{
		return $this->db->count_all('gk');
	}
	
	function count_all_batch()
	{
		return $this->db->count_all('batch');
	}
	
	function count_all_subject()
	{
		return $this->db->count_all('subject');
	}
	
	
	
	function count_all_passage()
	{
		return $this->db->count_all('passage');
	}
	
	function all_members($start,$end)
	{
	    $query = $this->db->query("SELECT name,`candidate_id`,u_id, email, status, city, mob_no, date FROM `user_details` ORDER BY u_id DESC LIMIT $start, $end");

		return $query->result_array();
	}
	
	function all_members_active($start,$end)
	{
	    $query = $this->db->query("SELECT name,u_id, email, status, city, mob_no, date FROM `user_details` WHERE `status`=1 ORDER BY u_id DESC LIMIT $start, $end");

		return $query->result_array();
	}
	
	function all_members_inactive($start,$end)
	{
	    $query = $this->db->query("SELECT name,u_id, email, status, city, mob_no, date FROM `user_details` WHERE `status`=0 ORDER BY u_id DESC LIMIT $start, $end");

		return $query->result_array();
	}
	
	function all_members_logs($start,$end)
	{
	    $query = $this->db->query("SELECT name,u_id, email, status, city, mob_no, date, last_active FROM `user_details` WHERE `logged_in`=1 ORDER BY u_id DESC LIMIT $start, $end");

		return $query->result_array();
	}
	
	function all_gk($start,$end)
	{
	    $query = $this->db->query("SELECT * FROM `gk` ORDER BY gk_id DESC LIMIT $start, $end");

		return $query->result_array();
	}
	
	function get_batch_name($batch_id)
	{
		$this->db->select('batch_name');
		$this->db->where('batch_id', $batch_id);
		$query = $this->db->get('batch');
		
		if($query->num_rows() > 0)
		{
			$topic = $query->row_array();
			return $topic['batch_name'];
		}
		else
		{
		return false;
		}
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
	
	function all_subject($start='',$end='')
	{
	    if($start == '' && $end == '') {
			$query = $this->db->query("SELECT `sub_id`, `subject` FROM `subject` ORDER BY sub_id DESC");
		} else {
			$this->db->select('sub.sub_id,sub.subject, sub.batch_id, bat.batch_name, sub.date');
			$this->db->from('subject as sub');
			$this->db->join('batch as bat', 'bat.batch_id = sub.batch_id');
			$query = $this->db->get();
		}
		return $query->result_array();
	}
	
	function all_passage($start='',$end='')
	{
	    if($start == '' && $end == '') {
			$query = $this->db->query("SELECT `pid`, `passage_title` FROM `passage` ORDER BY pid DESC");
			return $query->result_array();
		} else {
		
			$blogs=array();
		$qry = $this->db->query("SELECT * from passage ORDER BY `pid` DESC");
		 if($qry->num_rows() > 0)
		 {
			 foreach($qry->result_array() as $key=> $row)
			 {		    
				 $blogs[$key]['pid']=$row['pid']; 
				 $blogs[$key]['passage_title']=$row['passage_title']; 
				 $blogs[$key]['passage_desc']=$row['passage_desc']; 
				 $blogs[$key]['batch_name'] = $this->get_batch_name($row['batch_id']);
				 $blogs[$key]['subject'] = $this->get_subject_name($row['sub_id']);
				 $blogs[$key]['date']=$row['date']; 
			 }
		 }
		 return $blogs;	
		}
	}
	
	function all_tests()
	{
		$blogs=array();
		$qry = $this->db->query("SELECT * from test ORDER BY `tid` DESC");
		 if($qry->num_rows() > 0)
		 {
			 foreach($qry->result_array() as $key=> $row)
			 {		    
				 $blogs[$key]['tid']=$row['tid']; 
				 $blogs[$key]['test_name']=$row['test_name']; 
				 $blogs[$key]['test_time']=$row['test_time']; 
				 $blogs[$key]['start_time']=$row['start_time'];
				 $blogs[$key]['end_time']=$row['end_time'];
				 $blogs[$key]['batch_name'] = $this->get_batch_name($row['batch_id']);
				 $blogs[$key]['tot_qns']=$row['random_question_no']; 
			 }
		 }
		 return $blogs;	
	}
	
	function all_msgs()
	{
		$blogs=array();
		$qry = $this->db->query("SELECT * from msg_centre WHERE `type`='p' ORDER BY `msg_id` DESC");
		 if($qry->num_rows() > 0)
		 {
			 foreach($qry->result_array() as $key=> $row)
			 {		    
				 $blogs[$key]['msg_id']=$row['msg_id']; 
				 $blogs[$key]['subject']=$row['subject']; 
				 $blogs[$key]['msg']=$row['msg']; 
				 $blogs[$key]['date']=$row['date'];
				 $blogs[$key]['status']=$row['status'];
				 $blogs[$key]['member_name'] = $this->get_member_name($row['sender_id']);
			 }
		 }
		 return $blogs;	
	}
	
	function get_msg_detail($msg_id)
	{
		$blogs=array();
		$qry = $this->db->query("SELECT * from msg_centre WHERE `msg_id`=$msg_id LIMIT 1");
		 if($qry->num_rows() > 0)
		 {
			 foreach($qry->result_array() as $row)
			 {		    
				 $blogs['msg_id']=$row['msg_id']; 
				 $blogs['subject']=$row['subject']; 
				 $blogs['msg']=$row['msg']; 
				 $blogs['date']=$row['date'];
				 $blogs['status']=$row['status'];
				 $blogs['member_name'] = $this->get_member_name($row['sender_id']);
				 $blogs['reply'] = $this->get_msg_reply($row['msg_id']);
			 }
		 }
		 return $blogs;	
	}
	
	function all_batch($start='',$end='')
	{
		 if($start == '' && $end == '') {
			$query = $this->db->query("SELECT `batch_id`, `batch_name` FROM `batch` ORDER BY batch_id DESC");
		} else {
	   		$query = $this->db->query("SELECT * FROM `batch` ORDER BY batch_id DESC LIMIT $start, $end");
		}

		return $query->result_array();
	}
	
	function delete_member($pst)
	{
		extract($pst);
		if(!empty($_SESSION['edu_admin'])) {
			$this->db->where('u_id', $id);
			$this->db->delete('user_details');
			return true;
		} else {
		 return false;
		}
	}
	
	function delete_gk($pst)
	{
		extract($pst);
		if(!empty($_SESSION['edu_admin'])) {
			$this->db->where('gk_id', $id);
			$this->db->delete('gk');
			return true;
		} else {
		 return false;
		}
	}
	
	function get_member_details($uid)
	{
		$query = $this->db->query("SELECT * FROM `user_details` WHERE `u_id`=$uid LIMIT 1");
		return $query->row_array();
	}
	
	function load_subjects($batchid)
	{
		$query = $this->db->query("SELECT `sub_id`, `subject` FROM subject WHERE `batch_id`=$batchid");
		return $query->result_array();
	}
	
	function load_passage($sub_id)
	{
		$query = $this->db->query("SELECT `pid`, `passage_title` FROM passage WHERE `sub_id`=$sub_id");
		return $query->result_array();
	}
	
	
	function update_member($pst)
	{
		extract($pst);
		if(!empty($_SESSION['edu_admin'])) {
		  $data = array(
               'name' => trim($name) ,
		  	   'candidate_id'=>$candidate_id,
               'email' => trim($email) ,
			   'mob_no' => $mobile,
			   'landline' => $landline,
			   'address' => trim($address),
			   'pincode' => $pincode,
			   'status' => $status,
			   'city' => trim($city),
			   'fee_paid' => $feepaid,
			   'received_through' => $received_through,
			   'bank' => $bank,
			   'date_of_credit' => $date_of_credit,
			   'fee_remitted_for' => $fee_remitted_for,
			   'details' => $details,
			   'moredetails' => $moredetails
            );
        $this->db->where('u_id', $u_id);
		$this->db->update('user_details', $data);
		
		return true;
		} else {
			return false;
		}
	}
	
	function get_scrolling_gk()
	{
		$query = $this->db->query("SELECT `scrolling_gk` FROM `scrolling_gk` WHERE `sgk`=1");
		if($query->num_rows() > 0)
		{
		  $q = $query->row_array();
		  return $q['scrolling_gk'];
		} else {
			return false;
		}
	}
	
	function get_member_name($uid)
	{
		$query = $this->db->query("SELECT `name` FROM `user_details` WHERE `u_id`=$uid");
		if($query->num_rows() > 0)
		{
		  $q = $query->row_array();
		  return $q['name'];
		} else {
			return false;
		}
	}
	
	function update_scroll_gk($pst)
	{
		extract($pst);
		$gk = strip_tags($scroll_gk, '<strong><b><i><ul><u><ol><li><img><a><p><div><span><hr><br><h1><h2><h3>');
		
		  $data = array(
               'scrolling_gk' => $gk,
            );
        $this->db->where('sgk', 1);
		$this->db->update('scrolling_gk', $data);
		return true;
	}
	
	function add_gk($pst)
	{
		extract($pst);
		
		  $data = array(
               'question' => $title,
			   'answer' => $desc
            );
       $this->db->insert('gk', $data); 
	   return true;
	}
	
	function add_batch($pst)
	{
		extract($pst);
		
		  $data = array(
               'batch_name' => $title,
			   'date' => date("Y-m-d")
            );
       $this->db->insert('batch', $data); 
	   return true;
	}	
	
	function get_gk_details($gk_id)
	{
		$query = $this->db->query("SELECT * FROM `gk` WHERE `gk_id`=$gk_id LIMIT 1");
		if($query->num_rows() > 0)
		{
		  return $query->row_array();
		} else {
			return false;
		}
	}
	
	function update_gk($pst)
	{
		extract($pst);
		
		  $data = array(
               'question' => $title,
			   'answer' => $desc
            );
        $this->db->where('gk_id', $gk_id);
		$this->db->update('gk', $data);
		return true;
	}
	
	function update_batch($pst)
	{
		extract($pst);
		
		  $data = array(
               'batch_name' => $title,
			   'date' => date("Y-m-d")
            );
        $this->db->where('batch_id', $batch_id);
		$this->db->update('batch', $data);
		return true;
	}
	
	function get_batch_details($batch_id)
	{
		$query = $this->db->query("SELECT * FROM `batch` WHERE `batch_id`=$batch_id LIMIT 1");
		if($query->num_rows() > 0)
		{
		  return $query->row_array();
		} else {
			return false;
		}
	}
	
	function add_subject($pst)
	{
		extract($pst);
		
		  $data = array(
               'subject' => $title,
			   'batch_id' => $batch_id,
			   'date' => date("Y-m-d")
            );
       $this->db->insert('subject', $data); 
	   return true;
	}
	
	function add_passage($pst)
	{
		extract($pst);
		
		  $data = array(
               'passage_title' => $p_name,
			   'passage_desc' => $p_desc,
			   'batch_id' => $batch_id,
			   'sub_id' => $sub_id,
			   'date' => date("Y-m-d")
            );
       $this->db->insert('passage', $data); 
	   return true;
	}
	
	function get_passage_details($pid)
	{
		$query = $this->db->query("SELECT * FROM `passage` WHERE `pid`=$pid LIMIT 1");
		if($query->num_rows() > 0)
		{
		  return $query->row_array();
		} else {
			return false;
		}
	}
	
	function update_passage($pst)
	{
		extract($pst);
		
		  $data = array(
               'passage_title' => $p_name,
			   'passage_desc' => $p_desc,
			   'batch_id' => $batch_id,
			   'sub_id' => $sub_id,
			   'date' => date("Y-m-d")
            );
		  
        $this->db->where('pid', $pid);
		$this->db->update('passage', $data);
		return true;
	}
	
	function delete_passage($pst)
	{
		extract($pst);
		if(!empty($_SESSION['edu_admin'])) {
			$this->db->where('pid', $id);
			$this->db->delete('passage');
			return true;
		} else {
		 return false;
		}
	}
	
	function get_subject_details($sub_id)
	{
		$query = $this->db->query("SELECT * FROM `subject` WHERE `sub_id`=$sub_id LIMIT 1");
		if($query->num_rows() > 0)
		{
		  return $query->row_array();
		} else {
			return false;
		}
	}
	
	function update_subject($pst)
	{
		extract($pst);
		
		  $data = array(
               'subject' => $title,
			   'batch_id' => $batch_id,
			   'date' => date("Y-m-d")
            );
		  
        $this->db->where('sub_id', $sub_id);
		$this->db->update('subject', $data);
		return true;
	}
	
	function clear_log($uid)
	{
		$query = $this->db->query("UPDATE `user_details` SET `logged_in`=0 WHERE `u_id`=$uid");
		return true;
	}
	
	function set_test($pst)
	{
		$timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		extract($pst);
		  $data = array(
               'batch_id' => $batch_id,
			   'start_time' => strtotime($sdate),
			   'end_time' => strtotime($edate),
			   'test_name' => $tname,
			   'description' => $desc,
			   'test_time' => $ttime,
			   'attempts' => 1,
			   'reqpercentage' => $percentage,
			   'type' => 0,
			   'random_question_no' => $this->no_of_qns_by_batch_id($batch_id)
            );
       $this->db->insert('test', $data); 
	   return true;
	}	
	
	function no_of_qns_by_batch_id($batch_id)
	{
		$this->db->where('batch_id', $batch_id);
		$this->db->from('questions');
		return $this->db->count_all_results();		
	}
	
	function reply_msg($prt)
	{
		extract($prt);
		$data = array(
               'sender_id' => 0,
			   'msg' => $reply,
			   'date' => time(),
			   'parent_id' => $msg_id,
			   'type' => 'r'
            );
		$this->db->insert('msg_centre', $data); 
		
		//update status of parent msg 
		$this->db->query("UPDATE `msg_centre` SET `status`=1 WHERE `msg_id`=$msg_id");
		return true;
	}
	
	function get_msg_reply($msgid)
	{
		$query = $this->db->query("SELECT `msg`, `date` FROM `msg_centre` WHERE `parent_id`=$msgid ORDER BY `msg_id` ASC");
		return $query->result_array();
	}
	
	function get_msg_to_all()
	{
		$query = $this->db->query("SELECT `msg_to_all` FROM `msg_to_all` WHERE `mid`=1");
		if($query->num_rows() > 0)
		{
		  $q = $query->row_array();
		  return $q['msg_to_all'];
		} else {
			return false;
		}
	}
	
	function update_msg_to_all($pst)
	{
		extract($pst);
		
		  $data = array(
               'msg_to_all' => $msg,
            );
        $this->db->where('mid', 1);
		$this->db->update('msg_to_all', $data);
		return true;
	}
	
	function get_latest_msg()
	{
		$blogs=array();
		$qry = $this->db->query("SELECT * from msg_centre WHERE `type`='p' ORDER BY `msg_id` DESC LIMIT 5");
		 if($qry->num_rows() > 0)
		 {
			 foreach($qry->result_array() as $key=> $row)
			 {		    
				 $blogs[$key]['msg_id']=$row['msg_id']; 
				 $blogs[$key]['subject']=$row['subject']; 
				 $blogs[$key]['msg']=$row['msg']; 
				 $blogs[$key]['date']=$row['date'];
				 $blogs[$key]['status']=$row['status'];
				 $blogs[$key]['member_name'] = $this->get_member_name($row['sender_id']);
			 }
		 }
		 return $blogs;	
	}
	
	function all_tests_results()
	{
		$sql="select result.*,test.*,user_details.name,user_details.u_id, user_details.email from result,test,user_details where result.test_id = test.pid and result.uid = user_details.u_id  ORDER BY result.result_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function clear_tr_logs($rid, $uid)
	{
		//delete from result table
		$this->db->where('result_id', $rid);
		$this->db->delete('result'); 
		
		//delete from gen_result table
		$this->db->where('result_id', $rid);
		$this->db->where('u_id', $uid);
		$this->db->delete('gen_result'); 
		return true;
	}
	
	function clear_tr_logs_1($rid, $uid)
	{
		$this->db->where('last_test', $rid);
		$this->db->where('uid', $uid);
		$this->db->delete('test_attempt'); 
		return true;
	}
    
    function get_score($rid, $uid)
	{
		$query = $this->db->query("SELECT SUM(mark) as score  FROM `gen_result` WHERE `result_id` = $rid AND `u_id` = $uid");
		if($query->num_rows() > 0)
		{
		  $q = $query->row_array();
		  return $q['score'];
		} else {
			return false;
		}
	}
	
	
	
	/*****
	{
	*****/
	
	/*
	{
	*/
	function add_test_type($pst)
	{
		extract($pst);
		
		$data = array(
            'title' => $p_name,
            'date' => date("Y-m-d")
        );
        $this->db->insert('test_type', $data); 
        return true;
	}
	function update_test_type($pst)
	{
		extract($pst);
		
        $data = array(
            'title' => $p_name
        );
		  
        $this->db->where('pid', $pid);
		$this->db->update('test_type', $data);
		return true;
	}
	function count_all_test_type()
	{
		return $this->db->count_all('test_type');
	}
	
	function all_test_type($start='',$end='')
	{
		$limit = '';
		if( $start!='' && $end!='' ){
			$limit = ' '.$start.', '.$end;
		}
		$query = $this->db->query('SELECT * FROM `test_type` ORDER BY pid DESC'.$limit);

		return $query->result_array();
	}
	
	function get_test_type_details($pid)
	{
		$query = $this->db->query("SELECT * FROM `test_type` WHERE `pid`=$pid LIMIT 1");
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else{
			return false;
		}
	}
	
	function delete_test_type($pst)
	{
		extract($pst);
		if(!empty($_SESSION['edu_admin'])) {
			$this->db->where('pid', $id);
			$this->db->delete('test_type');
			return true;
		} else {
		 return false;
		}
	}
	/*

	 }

	*/
	/*
	 {
	*/
	function add_sector($pst)
	{
		extract($pst);
	
		$data = array(
			'title'			=> $p_name,
			'test_type_id'	=> $test_type_id,
			'date'			=> date("Y-m-d"),
		);
		$this->db->insert('sector', $data);
		return true;
	}
	function update_sector($pst)
	{
		extract($pst);
	
		$data = array(
			'title'			=> $p_name,
			'test_type_id'	=> $test_type_id,
		);
	
		$this->db->where('pid', $pid);
		$this->db->update('sector', $data);
		return true;
	}
	function count_all_sector()
	{
		return $this->db->count_all('sector');
	}
	
	function all_sector($start='',$end='')
	{
		$limit = '';
		if( $start!='' && $end!='' ){
			$limit = ' '.$start.', '.$end;
		}
		$query = $this->db->query('SELECT * FROM `sector` ORDER BY title ASC'.$limit);
		return $query->result_array();
	}
	
	function get_sector_details($pid)
	{
		$query = $this->db->query("SELECT * FROM `sector` WHERE `pid`=$pid LIMIT 1");
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else{
			return false;
		}
	}
	
	function delete_sector($pst)
	{
		extract($pst);
		if(!empty($_SESSION['edu_admin'])) {
			
			$query = $this->db->query('SELECT `pid` FROM `section_sector` WHERE `sector_id`='.$id.' ORDER BY pid DESC');
			$resuls = $query->result_array();
		
			foreach($resuls as $K=>$V){
				$this->db->where('pid', $V['pid']);
				$this->db->delete('section_sector');
			}
			
			$this->db->where('pid', $id);
			$this->db->delete('sector');
			return true;
		} else {
			return false;
		}
	}
	/*
	 }
	*/
	/*
	 {
	*/
	function add_section($pst)
	{
		extract($pst);
	
		$data = array(
			'title'			=> $p_name,
			'date'			=> date("Y-m-d"),
		);
		$this->db->insert('section', $data);
		
		$id = $this->db->insert_id();
		
		if( $id>0 ){
			
			if( isset($sector_ids) && is_array($sector_ids) ){
				foreach($sector_ids as $K=>$V){
					$not = true;
					$query = $this->db->query('SELECT `pid` FROM `section_sector` WHERE `section_id`='.$id.' AND `sector_id`='.$V.' LIMIT 1');
					if($query->num_rows() > 0){
						$row = $query->row_array();
						if( isset($row['pid']) ){
							$not = false;
						}
					}
					if( $not ){
						$this->db->insert('section_sector', array(
							'section_id'=> $id,
							'sector_id'	=> $V,
						));
					}
				}
			}
			
		}
		
		return true;
	}
	function update_section($pst)
	{
		extract($pst);
	
		$data = array(
			'title'			=> $p_name,
		);
	
		$this->db->where('pid', $pid);
		$this->db->update('section', $data);
			
		$query = $this->db->query('SELECT `pid` FROM `section_sector` WHERE `section_id`='.$pid.' ORDER BY pid DESC');
		$resuls = $query->result_array();
		
		$sector_ids_saved = array();
		if( isset($sector_ids) && is_array($sector_ids) ){
			foreach($sector_ids as $K=>$V){
				$not = true;
				$query = $this->db->query('SELECT `pid` FROM `section_sector` WHERE `section_id`='.$pid.' AND `sector_id`='.$V.' LIMIT 1');
				if($query->num_rows() > 0){
					$row = $query->row_array();
					if( isset($row['pid']) ){
						$not = false;
						$sector_ids_saved[] = $row['pid'];
					}
				}
				if( $not ){
					$this->db->insert('section_sector', array(
						'section_id'=> $pid,
						'sector_id'	=> $V,
					));
				}
			}
		}
		
		foreach($resuls as $K=>$V){
			if( !in_array($V['pid'], $sector_ids_saved) ){
				$this->db->where('pid', $V['pid']);
				$this->db->delete('section_sector');
			}
		}
		
	
		return true;
	}
	function count_all_section()
	{
		return $this->db->count_all('section');
	}
	
	function all_section($start='',$end='')
	{
		$limit = '';
		if( $start!='' && $end!='' ){
			$limit = ' '.$start.', '.$end;
		}
		$query = $this->db->query('SELECT * FROM `section` ORDER BY title ASC'.$limit);
		return $query->result_array();
	}
	
	function get_section_details($pid)
	{
		$query = $this->db->query("SELECT * FROM `section` WHERE `pid`=$pid LIMIT 1");
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else{
			return false;
		}
	}
	
	function delete_section($pst)
	{
		extract($pst);
		if(!empty($_SESSION['edu_admin'])) {
			
			$query = $this->db->query('SELECT `pid` FROM `section_sector` WHERE `section_id`='.$id.' ORDER BY pid DESC');

			$resuls = $query->result_array();
		
			foreach($resuls as $K=>$V){
				$this->db->where('pid', $V['pid']);
				$this->db->delete('section_sector');
			}
			
			$query = $this->db->query('SELECT `pid` FROM `section_sub_section` WHERE `section_id`='.$id.' ORDER BY pid DESC');
			$resuls = $query->result_array();
	
			foreach($resuls as $K=>$V){
				$this->db->where('pid', $V['pid']);
				$this->db->delete('section_sub_section');
			}
			
			$this->db->where('pid', $id);
			$this->db->delete('section');
			return true;
		} else {
			return false;
		}
	}
	/*
	 }
	*/
	/*

	 {

	*/

	function add_section_sub($pst)

	{

		extract($pst);

	

		$data = array(

				'title'			=> $p_name,

				'date'			=> date("Y-m-d"),

		);

		$this->db->insert('section_sub', $data);

	

		$id = $this->db->insert_id();

	

		if( $id>0 ){

				

			if( isset($section_ids) && is_array($section_ids) ){

				foreach($section_ids as $K=>$V){

					$not = true;

					$query = $this->db->query('SELECT `pid` FROM `section_sub_section` WHERE `section_sub_id`='.$id.' AND `section_id`='.$V.' LIMIT 1');

					if($query->num_rows() > 0){

						$row = $query->row_array();

						if( isset($row['pid']) ){

							$not = false;

						}

					}

					if( $not ){

						$this->db->insert('section_sub_section', array(

								'section_sub_id'=> $id,

								'section_id'	=> $V,

						));

					}

				}

			}

				

		}

	

		return true;

	}

	function update_section_sub($pst)

	{

		extract($pst);

	

		$data = array(

				'title'			=> $p_name,

		);

	

		$this->db->where('pid', $pid);

		$this->db->update('section_sub', $data);

	

		$query = $this->db->query('SELECT `pid` FROM `section_sub_section` WHERE `section_sub_id`='.$pid.' ORDER BY pid DESC');

		$resuls = $query->result_array();

	

		$section_ids_saved = array();

		if( isset($section_ids) && is_array($section_ids) ){

			foreach($section_ids as $K=>$V){

				$not = true;

				$query = $this->db->query('SELECT `pid` FROM `section_sub_section` WHERE `section_sub_id`='.$pid.' AND `section_id`='.$V.' LIMIT 1');

				if($query->num_rows() > 0){

					$row = $query->row_array();

					if( isset($row['pid']) ){

						$not = false;

						$section_ids_saved[] = $row['pid'];

					}

				}

				if( $not ){

					$this->db->insert('section_sub_section', array(

							'section_sub_id'=> $pid,

							'section_id'	=> $V,

					));

				}

			}

		}

	

		foreach($resuls as $K=>$V){

			if( !in_array($V['pid'], $section_ids_saved) ){

				$this->db->where('pid', $V['pid']);

				$this->db->delete('section_sub_section');

			}

		}

	

	

		return true;

	}

	function count_all_section_sub()

	{

		return $this->db->count_all('section_sub');

	}

	

	function all_section_sub($start='',$end='')

	{

		$limit = '';

		if( $start!='' && $end!='' ){

			$limit = ' '.$start.', '.$end;

		}

		$query = $this->db->query('SELECT * FROM `section_sub` ORDER BY title ASC'.$limit);

		return $query->result_array();

	}

	

	function get_section_sub_details($pid)

	{

		$query = $this->db->query("SELECT * FROM `section_sub` WHERE `pid`=$pid LIMIT 1");

		if($query->num_rows() > 0)

		{

			return $query->row_array();

		}

		else{

			return false;

		}

	}

	

	function delete_section_sub($pst)

	{

		extract($pst);

		if(!empty($_SESSION['edu_admin'])) {

				

			$query = $this->db->query('SELECT `pid` FROM `section_sub_section` WHERE `section_sub_id`='.$id.' ORDER BY pid DESC');

			$resuls = $query->result_array();

	

			foreach($resuls as $K=>$V){

				$this->db->where('pid', $V['pid']);

				$this->db->delete('section_sub_section');

			}

				

			$this->db->where('pid', $id);

			$this->db->delete('section_sub');

			return true;

		} else {

			return false;

		}

	}

	/*

	 }

	*/
	/*

	 {

	*/

	function add_question($pst)

	{

		extract($pst);

	

		$data = array(

				'question' => $question,

				'option_1' => $ops1,

				'option_2' => $ops2,

				'option_3' => $ops3,

				'option_4' => $ops4,

				'answer' => $answer,

				'section_sub_id' => $section_sub_id,

				'date' => date("Y-m-d"),

		);

		$this->db->insert('questions', $data);

		return true;

	}

	function update_question($pst)

	{

		extract($pst);

	

		$data = array(

				'question' => $question,

				'option_1' => $ops1,

				'option_2' => $ops2,

				'option_3' => $ops3,

				'option_4' => $ops4,

				'answer' => $answer,

				'section_sub_id' => $section_sub_id,

		);

	

		$this->db->where('pid', $pid);

		$this->db->update('questions', $data);

		return true;

	}

	function count_all_question()

	{

		return $this->db->count_all('questions');

	}

	

	function all_question($start='',$end='')

	{

		$limit = '';

		if( $start!='' && $end!='' ){

			$limit = ' '.$start.', '.$end;

		}

		$query = $this->db->query('SELECT * FROM `questions` ORDER BY pid DESC'.$limit);

		return $query->result_array();

	}

	

	function get_question_details($pid)

	{

		$query = $this->db->query("SELECT * FROM `questions` WHERE `pid`=$pid LIMIT 1");

		if($query->num_rows() > 0)

		{

			return $query->row_array();

		}

		else{

			return false;

		}

	}

	

	function delete_question($pst)

	{

		extract($pst);

		if(!empty($_SESSION['edu_admin'])){

			$this->db->where('pid', $id);

			$this->db->delete('questions');

			return true;

		} else {

			return false;

		}

	}

	/*

	 }

	*/
	/*

	 {

	*/

	function add_test($pst)

	{

		extract($pst);

	

		$data = array(
			'title'			=> $title,
			'test_type_id'	=> $test_type_id,
			'sector_id'		=> $sector_id,

			'date' => date("Y-m-d"),

		);

		$this->db->insert('test', $data);
	
		$id = $this->db->insert_id();
	
		if( $id>0 ){
				
			if( isset($values) && is_array($values) ){
				foreach($values as $K=>$V){
					foreach($V as $K1=>$V1){
						if( $V1['q']!='' ){
							$not = true;
							$query = $this->db->query('SELECT `pid` FROM `test_set` WHERE `test_id`='.$id.' AND `sector_id`='.$sector_id.' AND `section_id`='.$K.' AND `section_sub_id`='.$K1.' LIMIT 1');
							if($query->num_rows() > 0){
								$row = $query->row_array();
								if( isset($row['pid']) ){
									$not = false;
								}
							}
							if( $not ){
								$this->db->insert('test_set', array(
									'test_id'		=> $id,
									'sector_id'		=> $sector_id,
									'section_id'	=> $K,
									'section_sub_id'=> $K1,

									'question'	=> $V1['q'],
									'minutes'	=> $V1['m'],
									'ra'		=> $V1['ra'],
									'wa'		=> $V1['wa'],
								));
							}
							else{
								$this->db->where('pid', $row['pid']);
								$this->db->update('test_set', array(
									'question'	=> $V1['q'],
									'minutes'	=> $V1['m'],
									'ra'		=> $V1['ra'],
									'wa'		=> $V1['wa'],
								));
							}
						}
					}
				}
			}
				
		}
		

		return true;

	}

	function update_test($pst)

	{

		extract($pst);

	

		$data = array(

			'title'			=> $title,

			'test_type_id'	=> $test_type_id,
			'sector_id'		=> $sector_id,

		);

	

		$this->db->where('pid', $pid);

		$this->db->update('test', $data);
	
		$query = $this->db->query('SELECT `pid` FROM `test_set` WHERE `test_id`='.$pid.' ORDER BY pid DESC');
		$resuls = $query->result_array();
	
		$test_set_ids_saved = array();
				
		if( isset($values) && is_array($values) ){
			foreach($values as $K=>$V){
				foreach($V as $K1=>$V1){
					if( $V1['q']!='' ){
						$not = true;
						$query = $this->db->query('SELECT `pid` FROM `test_set` WHERE `test_id`='.$pid.' AND `sector_id`='.$sector_id.' AND `section_id`='.$K.' AND `section_sub_id`='.$K1.' LIMIT 1');
						if($query->num_rows() > 0){
							$row = $query->row_array();
							if( isset($row['pid']) ){
								$not = false;
								$test_set_ids_saved[] = $row['pid'];
							}
						}
						if( $not ){
							$this->db->insert('test_set', array(
								'test_id'		=> $pid,
								'sector_id'		=> $sector_id,
								'section_id'	=> $K,
								'section_sub_id'=> $K1,

								'question'	=> $V1['q'],
								'minutes'	=> $V1['m'],
								'ra'		=> $V1['ra'],
								'wa'		=> $V1['wa'],
							));
						}
						else{
							$this->db->where('pid', $row['pid']);
							$this->db->update('test_set', array(
								'question'	=> $V1['q'],
								'minutes'	=> $V1['m'],
								'ra'		=> $V1['ra'],
								'wa'		=> $V1['wa'],
							));
						}
					}
				}
			}
		}
	
		foreach($resuls as $K=>$V){
			if( !in_array($V['pid'], $test_set_ids_saved) ){
				$this->db->where('pid', $V['pid']);
				$this->db->delete('test_set');
			}
		}


		return true;

	}

	function count_all_test()

	{

		return $this->db->count_all('test');

	}

	

	function all_test($start='',$end='')

	{

		$limit = '';

		if( $start!='' && $end!='' ){

			$limit = ' '.$start.', '.$end;

		}

		$query = $this->db->query('SELECT * FROM `test` ORDER BY pid DESC'.$limit);

		return $query->result_array();

	}

	

	function get_test_details($pid)

	{

		$query = $this->db->query("SELECT * FROM `test` WHERE `pid`=$pid LIMIT 1");

		if($query->num_rows() > 0)

		{

			return $query->row_array();

		}

		else{

			return false;

		}

	}

	

	function delete_test($pst)

	{

		extract($pst);

		if(!empty($_SESSION['edu_admin'])){

			$this->db->where('pid', $id);

			$this->db->delete('test');

			return true;

		} else {

			return false;

		}

	}

	/*

	 }

	*/
	/*

	 {

	*/

	function add_payment($pst)

	{

		extract($pst);

	

		$data = array(

				'title' => $p_name,

				'date' => date("Y-m-d")

		);

		$this->db->insert('payment_details', $data);

		return true;

	}

	function update_payment($pst)

	{

		extract($pst);

	

		$data = array(

				'title' => $p_name

		);

	

		$this->db->where('pid', $pid);

		$this->db->update('payment_details', $data);

		return true;

	}

	function count_all_payment()

	{

		return $this->db->count_all('payment_details');

	}

	

	function all_payment($start='',$end='')

	{

		$limit = '';

		if( $start!='' && $end!='' ){

			$limit = ' '.$start.', '.$end;

		}

		$query = $this->db->query('SELECT * FROM `payment_details` ORDER BY pid DESC'.$limit);

		return $query->result_array();

	}

	

	function get_payment_details($pid)

	{

		$query = $this->db->query("SELECT * FROM `payment_details` WHERE `pid`=$pid LIMIT 1");

		if($query->num_rows() > 0)

		{

			return $query->row_array();

		}

		else{

			return false;

		}

	}

	

	function delete_payment($pst)

	{

		extract($pst);

		if(!empty($_SESSION['edu_admin'])) {

			$this->db->where('pid', $id);

			$this->db->delete('payment_details');

			return true;

		} else {

			return false;

		}

	}

	/*

	 }

	*/
	
	/*****
	}
	*****/

}