<?php
class home_model extends CI_Model 
{    
    function __construct()
    {       
        parent::__construct();     
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
	
	function test_lists($b_id, $test)
	{
		$tests=array();
		$qry = $this->db->query("SELECT count(*) as tot_qn from questions WHERE `batch_id`=$b_id");
		 if($qry->num_rows() > 0)
		 {		    
				 $row = $qry->row_array();
				 $tests['total_qn']= $row['tot_qn']; 
				 $tests['batch_name'] = $this->get_batch_name($b_id);
				 $tests['at_id'] = $test['at_id'];
				 $tests['start_date'] = $test['start_date'];
				 $tests['end_date']=$test['end_date'];
		 }
		 return $tests;		
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
	
	function chk_test()
	{
		$query = $this->db->query("SELECT * FROM `add_test` WHERE `start_date` <= NOW() AND `end_date` >= NOW() AND `status`=1 LIMIT 1");
		return $query->row_array();
	}
	
	function chk_fee_remitted_for($uid)
	{
		$query = $this->db->query("SELECT fee_remitted_for, status FROM `user_details` WHERE `u_id`=$uid LIMIT 1");
		return $query->row_array();
	}
	
	function clear_log($uid)
	{
		$query = $this->db->query("UPDATE `user_details` SET `logged_in`=0 WHERE `u_id`=$uid");
		return true;
	}
	
	function get_member_password($uid)
	{
		$query = $this->db->query("SELECT * FROM `user_details` WHERE `u_id`=$uid LIMIT 1");
		return $query->row_array();
	}
	
	function update_password($prt)
	{
		extract($prt);
		$uid = $_SESSION['edu_uid'];
		$data = array(
               'password' => $new_pass
            );

		$this->db->where('u_id', $uid);
		$this->db->update('user_details', $data); 
		return true;
	}
	
	function check_pass($pass)
	{
		$query = $this->db->query("SELECT `password` FROM `user_details` WHERE `password`='$pass'");
		if($query->num_rows() > 0)
		{
		   return true;
		} else {
		   return false;
		}
	}
	
	function check_emailupdate($email, $uid)
	{
		$query = $this->db->query("SELECT `u_id` FROM `user_details` WHERE `email`='$email' AND `u_id`!=$uid");
		if($query->num_rows() > 0)
		{
		   return true;
		} else {
		   return false;
		}
	}
	
	function update_profile($r_data)
	{
		extract($r_data);
		$uid = $_SESSION['edu_uid'];
		$data = array(
					'name' => $this->db->escape_str($name),
					'email' => $this->db->escape_str($email),
					'mob_no' => $this->db->escape_str($mobile),
					'pincode' => $this->db->escape_str($pincode),
					'city' => $this->db->escape_str($city),
					'address' => $this->db->escape_str($address),
					'landline' => $this->db->escape_str($landline)
				);
		$_SESSION['edu_name'] = $name;
		$this->db->where('u_id', $uid);
		$this->db->update('user_details', $data); 
		return true;
	}
	
	function add_msg($prt)
	{
		extract($prt);
		$uid = $_SESSION['edu_uid'];
		$data = array(
               'sender_id' => $uid,
			   'subject' => '',
			   'msg' => $message,
			   'date' => time(),
			   'parent_id' => 0
            );
		$this->db->insert('msg_centre', $data); 
		return true;
	}
	
	function get_all_msgs($uid)
	{
		$blogs = array();
		$qry = $this->db->query("SELECT * FROM `msg_centre` WHERE `sender_id`=$uid ORDER BY `msg_id` DESC");
		 if($qry->num_rows() > 0)
		 {
			 foreach($qry->result_array() as $key=> $row)
			 {		    
				 $blogs[$key]['sender_id']=$row['sender_id']; 
				 $blogs[$key]['subject']=$row['subject']; 
				 $blogs[$key]['msg']=$row['msg']; 
				 $blogs[$key]['type']=$row['type'];
				 $blogs[$key]['date']=$row['date'];
				 $blogs[$key]['reply'] = $this->get_msg_reply($row['msg_id']);
			 }
		 }
		 return $blogs;
	}
	
	function get_msg_reply($msgid)
	{
		$query = $this->db->query("SELECT `msg`, `date` FROM `msg_centre` WHERE `parent_id`=$msgid ORDER BY `msg_id` ASC");
		return $query->result_array();
	}
	
	function get_all_msg()
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
}