<?php
class registration_model extends CI_Model 
{    
    function __construct()
    {       
        parent::__construct();     
    }
	
	function register($r_data)
	{
		extract($r_data);
		$this->load->helper('string');
		$password = random_string('alnum', 16);
		$data = array(
			'name'			=> $this->db->escape_str($name),
			'password'		=> $this->db->escape_str($password),
            'date'			=> time(),
			'email'			=> $this->db->escape_str($email),
			'mob_no'		=> $this->db->escape_str($mobile),
			'pincode'		=> $this->db->escape_str($pincode),
			'city'			=> $this->db->escape_str($city),
			'address'		=> $this->db->escape_str($address),
			'landline'		=> $this->db->escape_str($landline),
			'how'			=> $this->db->escape_str($how),
			'last_active'	=> time(),
			'test_type_id'	=> $this->db->escape_str($test_type_id),
			'sector_id'		=> $this->db->escape_str($sector_id),
			'type'			=> $this->db->escape_str($type),
			'user_count'	=> $type==USER_TYPE_INSTITUTIONAL ? $this->db->escape_str($user_count) : 0,
		);
		$query = $this->db->insert('user_details', $data); 
		$user_ins_id = $this->db->insert_id();
		return $user_ins_id;
	}
	
	function chk_email($email)
	{
		$this->db->select('status');
		$this->db->where('email',$email);
		$query = $this->db->get('user_details');
		if($query->num_rows() > 0)
		{
			$topic = $query->row_array();
			//return $topic['status'];
			return true;
		}
		else
		{
		return false;
		}
	}
	
	function chk_email1($email)
	{
		$this->db->select('status, logged_in');
		$this->db->where('email',$email);
		$query = $this->db->get('user_details');
		if($query->num_rows() > 0)
		{
			$topic = $query->row_array();
			//return $topic['status'];
			return $topic;
		}
		else
		{
		return false;
		}
	}
	
	function login($login_data)
	{
		extract($login_data);
		$this->db->select('u_id, name, type, user_count, iid');
		$this->db->where('email',$email);
		$this->db->where('password', $password);
		$this->db->where('logged_in', 0);
		$query = $this->db->get('user_details');
		if($query->num_rows() > 0)
		{
			$q = $query->row_array();
			//set session
			$_SESSION['logged_in'] = true;
			$_SESSION['logged_status'] = true;
			$_SESSION['edu_name'] = $q['name'];
			$_SESSION['edu_uid'] = $q['u_id'];
			$_SESSION['edu_type'] = $q['type'];
			$_SESSION['edu_iid'] = $q['iid'];
			$_SESSION['edu_user_count'] = $q['user_count'];
			$uid = $q['u_id'];
			//update user_details logged_in
			$timee = time();
			mysql_query("UPDATE `user_details` SET `logged_in`=1, `last_active`='$timee' WHERE `u_id`=$uid");
			return true;
		} else {
			return false;
		}
	}
	
	function get_member_details($uid)
	{
		$query = $this->db->query("SELECT email, password, name FROM `user_details` WHERE `u_id`=$uid LIMIT 1");
		return $query->row_array();
	}
	
	function get_member_details_email($email)
	{
		$query = $this->db->query("SELECT email, password, name FROM `user_details` WHERE `email`='$email' LIMIT 1");
		return $query->row_array();
	}
}