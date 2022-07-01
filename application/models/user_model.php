<?php
class user_model extends CI_Model 
{
 	
    function __construct()
    {       
       parent::__construct();     
    }
	
	function count($iid=-1)
	{
		$this->db->where('iid', $iid);
		return $this->db->count_all_results('user_details');
		//echo $this->db->last_query();
		//return $t;
	}
	
	function all($iid=-1, $start, $end)
	{
		$this->db->select('*');
		$this->db->from('user_details');
		$this->db->where('iid', $iid);
	    $this->db->order_by("u_id", "DESC");
	    $this->db->limit($end, $start);
		$query = $this->db->get();
		return $query->result_array();
		//echo $this->db->last_query();
		//return $t;
	}
	
	function get($u_id)
	{
		$query = $this->db->query("SELECT * FROM `user_details` WHERE `u_id`=$u_id LIMIT 1");
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else{
			return false;
		}
	}
	
	function add($pst)
	{
		extract($pst);
		$this->load->helper('string');
		$password = random_string('alnum', 16);

		$data = array(
			'name'			=> $this->db->escape_str($name),
			'password'		=> $this->db->escape_str($password),
            'date'			=> time(),
			'email'			=> $this->db->escape_str($email),
			'candidate_id'	=> $this->db->escape_str($candidate_id),
			'last_active'	=> time(),
			'test_type_id'	=> $this->db->escape_str($test_type_id),
			'sector_id'		=> $this->db->escape_str($sector_id),
			'type'			=> $this->db->escape_str(USER_TYPE_USER),
			'iid'			=> $_SESSION['edu_uid'],
			'status'		=> 1,
		);
	
		$this->db->insert('user_details', $data);
	
		return true;
	
	}
	
	function update($pst, $u_id)
	{
		extract($pst);	
		$data = array(
			'name'			=> $this->db->escape_str($name),
			'email'			=> $this->db->escape_str($email),
			'candidate_id'	=> $this->db->escape_str($candidate_id),
			'test_type_id'	=> $this->db->escape_str($test_type_id),
			'sector_id'		=> $this->db->escape_str($sector_id),
		);

		$this->db->where('u_id', $u_id);	
		$this->db->update('user_details', $data);

		return true;
	
	}

}
