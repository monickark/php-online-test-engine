<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		if(empty($_SESSION['edu_admin'])) {
		$this->login();
		} else {
		redirect('admin/dashboard', 'refresh');
		}
	}
	
	public function login()
	{
		
		$data['title'] = "Admin Login";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'login';
		$data['content'] = 'middle_content';
		if(isset($_POST['admin_login'])) {
			if(($_POST['username'] == 'admin') && ($_POST['password'] == 'praisethelord@itk2012')) {
				
				$_SESSION['edu_admin'] = TRUE;
				$_SESSION['edu_admin_login'] = 1;
				redirect('admin/dashboard', 'refresh');
			} else {
				$data['display'] = 'block';
				$this->load->view('admin/login/login', $data);
			}
		} else {
		$data['display'] = 'none';
		$this->load->view('admin/login/login', $data);
		}
	}
	
	function dashboard()
	{
		if(!empty($_SESSION['edu_admin'])) {
			  $data['title'] = "AONE Dashboard";
			  $data['right_bar'] = 'noright';
			  $data['layout'] = 'loggedin';
			  $data['content'] = 'admin/dashboard';
			  $data['selected'] = 'dashboard';
			  $this->load->model('admin/admin_model');
			  $data['total'] = $this->admin_model->total_statistics();
			  //$data['members_stats'] = $this->dashboard_model->All_members_data();
			  //$data['club_acts'] = $this->dashboard_model->ct_activities();
			  $this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	
	function manage($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {

			
			$data['right_bar'] = 'noright';
			$data['layout'] = 'loggedin';
			$data['content'] = 'admin/members';
			$this->load->model('admin/admin_model');

			$config['base_url'] = base_url().'admin/manage/?';
			
			$sqlWhere = array();
			
			if( isset($_GET['type']) ){
				if( $_GET['type']=='default' ){
					$this->db->where_in('type', array(USER_TYPE_CANDIDATE, USER_TYPE_FRESHER));
					
					$sqlWhere[] = '`type` IN ("'.USER_TYPE_CANDIDATE.'", "'.USER_TYPE_FRESHER.'")';
					
					$data['title'] = "Manage Members";
					$data['selected'] = 'managemembers';
				}
				elseif( $_GET['type']=='institutional' ){
					$this->db->where('type', USER_TYPE_INSTITUTIONAL);
					
					$sqlWhere[] = '`type`="'.USER_TYPE_INSTITUTIONAL.'"';
					
					$data['title'] = "Manage Institutional";
					$data['selected'] = 'managemembersinstitutional';
				}
				elseif( $_GET['type']=='user' ){
					$this->db->where('type', USER_TYPE_USER);
					
					$sqlWhere[] = '`type`="'.USER_TYPE_USER.'"';
					
					if( isset($_GET['iid']) ){
						$idetails = $this->admin_model->get_member_details($_GET['iid']);
						
						if( isset($idetails['u_id']) ){
							$this->db->where('iid', $_GET['iid']);
							
							$sqlWhere[] = '`iid`="'.$_GET['iid'].'"';
						}
						else{
							redirect('admin/manage?type=institutional');
						}
					
						$data['title'] = $idetails['name']."'s Users";
						$data['selected'] = 'managemembersinstitutional';
			
						$config['base_url'] .= '&iid='.$_GET['iid'];
					}
					else{
						redirect('admin/manage?type=institutional');
					}
				}
				else{
					redirect('admin/manage?type=default');
				}
			}
			else{
				redirect('admin/manage?type=default');
			}
			
			$config['base_url'] .= '&type='.$_GET['type'];
			

			$total_members = $this->db->count_all_results('user_details');
			
			$this->load->library('pagination');
			$config['total_rows'] = $total_members;
			$config['per_page'] = '2000'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
			$config['page_query_string'] = true;
			$Page_No = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 0;
			$data['Page_No'] = $Page_No;
			$this->pagination->initialize($config);
			
			if( isset($sqlWhere[0]) ){
				$sqlWhere = ' WHERE '.implode(' AND ', $sqlWhere);
			}
			else{
				$sqlWhere = '';
			}
			
			$query = $this->db->query("SELECT name,`candidate_id`,u_id, email, status, city, user_count, mob_no, date FROM `user_details` $sqlWhere ORDER BY u_id DESC LIMIT $Page_No, ".$config['per_page']);
			$data['all_members'] = $query->result_array();
	
			$this->load->view('admin/container', $data);
		} 
		else {
			$this->login();
		}
	}
	
	
	function manage_active($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Manage Active Members";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/members';
		$data['selected'] = 'managemembers';
		 $this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_members_active();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/manage/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '500'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_members'] = $this->admin_model->all_members_active($Page_No, $config['per_page']);

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	function manage_inactive($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Manage In-Active Members";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/members';
		$data['selected'] = 'managemembers';
		 $this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_members_inactive();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/manage/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '2000'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_members'] = $this->admin_model->all_members_inactive($Page_No, $config['per_page']);

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	function logout()
	{
		unset($_SESSION['edu_admin']);
        unset($_SESSION['edu_admin_login']);
        $this->session->sess_destroy();
		redirect('admin/login', 'refresh');
	}
	
	function delete_user()
	{
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$this->admin_model->delete_member($_POST);
			return true;
		}
	}
	
	function view_member($u_id)
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Edit Member";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/view_member';
		$data['selected'] = 'managemembers';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['user_details'] = $this->admin_model->get_member_details($u_id);
		 
		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
		
	}
	
	function edit_member($u_id)
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Edit Member";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/edit_member';
		$data['selected'] = 'managemembers';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['user_details'] = $this->admin_model->get_member_details($u_id);
		$data['success'] = $this->session->userdata('edrop');
		$this->session->set_userdata('edrop', '');
		
		if(isset($_POST['edit_member'])) {
			
			$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
			$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|xss_clean|max_length[11]|numeric');
			$this->form_validation->set_rules('city', 'City', 'required|trim|xss_clean');
			$this->form_validation->set_rules('pincode', 'Pincode', 'required|trim|xss_clean|max_length[6]|numeric');
			$this->form_validation->set_rules('received_through', 'Received Through', 'trim|xss_clean');
			$this->form_validation->set_rules('bank', 'Name of the Bank', 'trim|xss_clean');
			$this->form_validation->set_rules('date_of_credit', 'Date of Credit', 'trim|xss_clean');
			$this->form_validation->set_rules('fee_remitted_for', 'Fee Remitted For', 'trim|xss_clean');
			
			
			 if(!empty($_POST['address'])) {
			  $this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
		     }
			 if(!empty($_POST['feepaid'])) {
			 $this->form_validation->set_rules('feepaid', 'Fee Paid', 'trim|xss_clean');
			 }
		  if(!empty($_POST['landline'])) {
			  $this->form_validation->set_rules('landline', 'Landline', 'trim|xss_clean|numeric');	
		  }
		   if(!empty($_POST['details'])) {
		  $this->form_validation->set_rules('details', 'Details', 'trim|xss_clean');
		   }
		   
		   if(!empty($_POST['moredetails'])) {
		  $this->form_validation->set_rules('moredetails', 'More Details', 'trim|xss_clean');
		   }
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  		$data['update'] = $this->admin_model->update_member($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('edrop', 'Updated Successfully');			   
			   redirect('admin/edit_member/'.$_POST['u_id'], 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}
	 
	 function scrolling_gk()
	 {
		 if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Update Scrolling GK";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/scroll_gk';
		$data['selected'] = 'gk';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['gk'] = $this->admin_model->get_scrolling_gk();
		$data['success'] = $this->session->userdata('scroll');
		 $this->session->set_userdata('scroll', '');
		
		if(isset($_POST['scrolling_gk'])) {
			
			$this->form_validation->set_rules('scroll_gk', 'GK', 'required|trim');			

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  		$data['update'] = $this->admin_model->update_scroll_gk($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('scroll', 'Updated Successfully');			   
			   redirect('admin/scrolling_gk', 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	 }
	 
	function add_gk()
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Add GK";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/add_gk';
		$data['selected'] = 'gk';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['success'] = $this->session->userdata('agk');
		 $this->session->set_userdata('agk', '');
		
		if(isset($_POST['add_gk'])) {
			
			$this->form_validation->set_rules('title', 'Question', 'required|trim');
			$this->form_validation->set_rules('desc', 'Answer', 'required|trim');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  	  $data['update'] = $this->admin_model->add_gk($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('agk', 'Added Successfully');
			   redirect('admin/add_gk', 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}
	
	function manage_gk($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Manage GK";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/manage_gk';
		$data['selected'] = 'managemembers';
		$this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_gk();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/manage_gk/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '1000'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_gk'] = $this->admin_model->all_gk($Page_No, $config['per_page']);

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	function delete_gk()
	{
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$this->admin_model->delete_gk($_POST);
			return true;
		}
	}
	
	function edit_gk($gk_id)
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Edit GK";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/edit_gk';
		$data['selected'] = 'gk';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['gk_details'] = $this->admin_model->get_gk_details($gk_id);
		$data['success'] = $this->session->userdata('egk');
		 $this->session->set_userdata('egk', '');
		
		if(isset($_POST['update_gk'])) {
			
			$this->form_validation->set_rules('title', 'Question', 'required|trim');
			$this->form_validation->set_rules('desc', 'Answer', 'required|trim');
			$this->form_validation->set_rules('gk_id', 'GK_id', 'required|trim');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  	  $data['update'] = $this->admin_model->update_gk($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('egk', 'Updated Successfully');
			   redirect('admin/edit_gk/'.$_POST['gk_id'], 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}
	
	
		function add_batch()
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Add Batch";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/add_batch';
		$data['selected'] = 'batch';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['success'] = $this->session->userdata('abat');
		 $this->session->set_userdata('abat', '');
		
		if(isset($_POST['add_bat'])) {
			
			$this->form_validation->set_rules('title', 'Batch Name', 'required|trim|xss_clean|max_length[20]|is_unique[batch.batch_name]');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  	  $data['update'] = $this->admin_model->add_batch($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('abat', 'Added Successfully');
			   redirect('admin/add_batch', 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}
	
	function manage_batch($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Manage Batch";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/manage_batch';
		$data['selected'] = 'batch';
		$this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_batch();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/manage_batch/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '100'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_gk'] = $this->admin_model->all_batch($Page_No, $config['per_page']);

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
		function edit_batch($batch_id)
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Edit Batch";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/edit_batch';
		$data['selected'] = 'batch';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['batch_details'] = $this->admin_model->get_batch_details($batch_id);
		$data['success'] = $this->session->userdata('ebat');
		$this->session->set_userdata('ebat', '');
		
		if(isset($_POST['update_batch'])) {
			
			$this->form_validation->set_rules('title', 'Batch Name', 'required|trim|xss_clean|max_length[20]');
			$this->form_validation->set_rules('batch_id', 'batch_id', 'required|trim|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  	  $data['update'] = $this->admin_model->update_batch($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('ebat', 'Updated Successfully');
			   redirect('admin/edit_batch/'.$_POST['batch_id'], 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}
	
	
	function add_subject()
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Add Subject";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/add_subject';
		$data['selected'] = 'subject';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['success'] = $this->session->userdata('asub');
		$this->session->set_userdata('asub', '');
		$data['all_batch'] = $this->admin_model->all_batch();
		if(isset($_POST['add_sub'])) {
			
			$this->form_validation->set_rules('title', 'Subject Name', 'required|trim|xss_clean|max_length[20]');
			$this->form_validation->set_rules('batch_id', 'Batch Name', 'required|trim');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  	  $data['update'] = $this->admin_model->add_subject($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('asub', 'Added Successfully');
			   redirect('admin/add_subject', 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}
	
	
	function edit_subject($sub_id)
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Edit Subject";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/edit_subject';
		$data['selected'] = 'subject';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['success'] = $this->session->userdata('esub');
		$this->session->set_userdata('esub', '');
		$data['all_batch'] = $this->admin_model->all_batch();
		$data['details'] = $this->admin_model->get_subject_details($sub_id);
		if(isset($_POST['edit_sub'])) {
			
			$this->form_validation->set_rules('title', 'Subject Name', 'required|trim|xss_clean|max_length[20]');
			$this->form_validation->set_rules('batch_id', 'Batch Name', 'required|trim');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  	  $data['update'] = $this->admin_model->update_subject($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('esub', 'Updated Successfully');
			   redirect('admin/edit_subject/'.$_POST['sub_id'], 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}
	
	function manage_subject($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Manage Subject";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/manage_subject';
		$data['selected'] = 'subject';
		$this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_subject();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/manage_subject/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '100'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_subject'] = $this->admin_model->all_subject($Page_No, $config['per_page']);

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	function add_passage()
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Add Passage";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/add_passage';
		$data['selected'] = 'passage';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['success'] = $this->session->userdata('apass');
		$this->session->set_userdata('apass', '');
		$data['all_batch'] = $this->admin_model->all_batch();
		$data['all_sub'] = $this->admin_model->all_subject();
		if(isset($_POST['add_pass'])) {
			
			$this->form_validation->set_rules('p_name', 'Passage Name', 'required|trim|xss_clean|max_length[20]');
			$this->form_validation->set_rules('p_desc', 'Passage Desc', 'required|trim|xss_clean');
			$this->form_validation->set_rules('batch_id', 'Batch Name', 'required|trim');
			$this->form_validation->set_rules('sub_id', 'Subject Name', 'required|trim');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
				//print_r($this->input->post());
		  	  $data['update'] = $this->admin_model->add_passage($this->input->post());	 
		  
			if($data['update']) {
			   $this->session->set_userdata('apass', 'Added Successfully');
			   redirect('admin/add_passage', 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}

	function manage_passage($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Manage Passage";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/manage_passage';
		$data['selected'] = 'passage';
		$this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_passage();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/manage_passage/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '100'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_subject'] = $this->admin_model->all_passage($Page_No, $config['per_page']);

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	function edit_passage($pid)
	{
		if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Edit Passage";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/edit_passage';
		$data['selected'] = 'passage';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['success'] = $this->session->userdata('epass');
		$this->session->set_userdata('epass', '');
		$data['all_batch'] = $this->admin_model->all_batch();
		$data['all_sub'] = $this->admin_model->all_subject();
		$data['details'] = $this->admin_model->get_passage_details($pid);
		if(isset($_POST['edit_pass'])) {
			
			$this->form_validation->set_rules('p_name', 'Passage Name', 'required|trim|xss_clean|max_length[20]');
			$this->form_validation->set_rules('p_desc', 'Passage Desc', 'required|trim|xss_clean');
			$this->form_validation->set_rules('batch_id', 'Batch Name', 'required|trim');
			$this->form_validation->set_rules('sub_id', 'Subject Name', 'required|trim');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
				//print_r($this->input->post());
		  	  $data['update'] = $this->admin_model->update_passage($this->input->post());	 
		  
			if($data['update']) {
			   $this->session->set_userdata('epass', 'Updated Successfully');
			   redirect('admin/edit_passage/'.$_POST['pid'], 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	}
	
	function delete_passage()
	{
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$this->admin_model->delete_passage($_POST);
			return true;
		}
	}
	
	function member_logs($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Manage Members Logs";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/members_logs';
		$data['selected'] = 'managemembers';
		 $this->load->model('admin/admin_model');
		$total_members = $this->admin_model->count_all_member_logs();
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/member_logs/';
			$config['total_rows'] = $total_members;
			$config['per_page'] = '100'; 
			$config['uri_segment'] = 3;
			$config['num_links'] = 5;
		$Page_No = $this->uri->segment(3,0);
		$data['Page_No'] = $Page_No;
		$this->pagination->initialize($config);
		$data['all_members'] = $this->admin_model->all_members_logs($Page_No, $config['per_page']);

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	function delete_log()
	{
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$this->admin_model->clear_log($_POST['id']);
			return true;
		}
	}
	
	function msg_support($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Message Support";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/manage_msgs';
		$data['selected'] = 'ms';
		 $this->load->model('admin/admin_model');
		 $data['success'] = $this->session->userdata('mc');
		  $this->session->set_userdata('mc', '');
		$total_msgs = $this->admin_model->count_all_msgs();

		$data['all_msgs'] = $this->admin_model->all_msgs();

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	function reply($msgid)
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Message Reply";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/reply_msg';
		$data['selected'] = 'ms';
		 $this->load->model('admin/admin_model');
		 $this->load->library('form_validation');
		$data['msg'] = $this->admin_model->get_msg_detail($msgid);

		if(isset($_POST['reply_msg'])) {
		  $this->form_validation->set_rules('reply', 'Reply', 'required|trim|max_length[1000]');
		  
			if ($this->form_validation->run() == FALSE)
			{
			  $this->load->view('admin/container', $data);
			} else {
			  $data['update'] = $this->admin_model->reply_msg($this->input->post());
			   $this->session->set_userdata('mc', 'Message Sent Successfully');
			  redirect('admin/msg_support', 'refresh');
			}
		  } else {
			   $this->load->view('admin/container', $data);
		  }

		} else {
			$this->login();
		}
	}
	
	
	function msg_to_all()
	 {
		 if(!empty($_SESSION['edu_admin'])) {
			
		$data['title'] = "Send Message to All";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/msg_to_all';
		$data['selected'] = 'mall';
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		$data['msg_to_all'] = $this->admin_model->get_msg_to_all();
		$data['success'] = $this->session->userdata('mall');
		 $this->session->set_userdata('mall', '');
		
		if(isset($_POST['msgall'])) {
			
			$this->form_validation->set_rules('msg', 'Message', 'required|trim');			

			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('admin/container', $data);
			} else {
		  		$data['update'] = $this->admin_model->update_msg_to_all($_POST);	 
		  
			if($data['update']) {
			   $this->session->set_userdata('mall', 'Updated Successfully');			   
			   redirect('admin/msg_to_all', 'refresh');
			}	
		  }
		} else {
		$this->load->view('admin/container', $data);
		}
	
		} else {
			$this->login();
		}	
	 }
	 
	function clear_results($id='')
	{
		if(!empty($_SESSION['edu_admin'])) {
		$data['title'] = "Clear Test Logs";
		$data['right_bar'] = 'noright';
		$data['layout'] = 'loggedin';
		$data['content'] = 'admin/test_logs';
		$data['selected'] = 'test';
		$data['success'] = $this->session->userdata('clogs');
		 $this->session->set_userdata('clogs', '');
		 $this->load->model('admin/admin_model');
		
		//$data['all_tests'] = $this->admin_model->all_tests_results();
		
		 $query = $this->db->query('SELECT *  FROM test_attempt ORDER BY date DESC');

		 $data['all_tests'] = $query->result_array();

		$this->load->view('admin/container', $data);
		} else {
			$this->login();
		}
	}
	
	
	function clear_test_logs($rid, $uid)
	{
		if(!empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$clear_logs = $this->admin_model->clear_tr_logs_1($rid, $uid);
			if($clear_logs)
			{
			   $this->session->set_userdata('clogs', 'Test Link Enabled Successfully');			   
			   redirect('admin/clear_results', 'refresh');
			}
			
		} else {
			$this->login();
		}
	}
	
	
	
	/*****
	{
	*****/
	
	/*
	{
	*/
	
	function add_test_type(){
		
		if(!empty($_SESSION['edu_admin'])) {
			$data = array();
			$data['title'] = 'Add Test Type';
			$data['form_url'] = base_url().'admin/add_test_type/';
			$data['form_type'] = 'add';
			
			$this->__form_test_type($data);
			
			
		}
		else{
			$this->login();
		}
		
	}
	
	function edit_test_type($pid=''){
		
		if(!empty($_SESSION['edu_admin'])) {
			$data = array();
			$data['title'] = 'Edit Test Type';
			$data['form_url'] = base_url().'admin/edit_test_type/'.$pid;
			$data['form_type'] = 'edit';
			
			$this->load->model('admin/admin_model');
			$data['details'] = $this->admin_model->get_test_type_details($pid);
			
			if( $data['details']==false || !is_array($data['details']) ){
				$this->session->set_userdata('manage_test_type_error', 'Invalid Record');

				redirect('admin/manage_test_type');
				exit();
			}
			
			$this->__form_test_type($data);
			
			
		}
		else{
			$this->login();
		}
		
	}
	
	function __form_test_type($data){
		
		$data['right_bar']	= 'noright';
		$data['layout']		= 'loggedin';
		$data['content']	= 'admin/form_test_type';
		$data['selected']	= 'test_type';
		
		$this->load->model('admin/admin_model');
		$this->load->library('form_validation');
		
		$data['success'] = $this->session->userdata('manage_test_type_success');
		$this->session->set_userdata('manage_test_type_success', '');
		$data['error'] = $this->session->userdata('manage_test_type_error');

		$this->session->set_userdata('manage_test_type_error', '');
		
		if(isset($_POST['save_form'])) {
			
			$data['details'] = $_POST;
			
			$this->form_validation->set_rules('p_name', 'Name', 'required|trim|xss_clean|max_length[80]');
			
			if ($this->form_validation->run() != FALSE){
				
				if( $data['form_type'] == 'add' ){
					$data['update'] = $this->admin_model->add_test_type($this->input->post());
				}
				elseif( $data['form_type'] == 'edit' ){
					$data['update'] = $this->admin_model->update_test_type($this->input->post());
				}
				
				if($data['update']) {

					$this->session->set_userdata('manage_test_type_success', $data['form_type'] == 'add' ? 'Added Successfully' : 'Updated Successfully');

					redirect('admin/manage_test_type');
					exit();

				}
				
			}
			
		}

		$this->load->view('admin/container', $data);

	}
	
	function manage_test_type(){
		
		if(!empty($_SESSION['edu_admin'])) {

			$data['title']		= "Manage Test Type";

			$data['right_bar']	= 'noright';

			$data['layout']		= 'loggedin';

			$data['content']	= 'admin/manage_test_type';

			$data['selected']	= 'test_type';
			

			$this->load->model('admin/admin_model');
			
			$total_members = $this->admin_model->count_all_test_type();
			
			$this->load->library('pagination');
			
			$config['base_url']		= base_url().'admin/manage_test_type/';

			$config['total_rows']	= $total_members;

			$config['per_page']		= '100';

			$config['uri_segment']	= 3;

			$config['num_links']	= 5;
			
			$Page_No = $this->uri->segment(3,0);
			$data['Page_No'] = $Page_No;
			
			$this->pagination->initialize($config);
			
			$data['all_subject'] = $this->admin_model->all_test_type($Page_No, $config['per_page']);
		
			$data['success'] = $this->session->userdata('manage_test_type_success');
			$this->session->set_userdata('manage_test_type_success', '');
			$data['error'] = $this->session->userdata('manage_test_type_error');
			$this->session->set_userdata('manage_test_type_error', '');
			
			$this->load->view('admin/container', $data);

		}
		else{
			$this->login();
		}
		
	}
	
	function delete_test_type()
	{
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$this->admin_model->delete_test_type($_POST);
			return true;
		}
	}
	
	/*
	}
	*/
	/*
	 {
	*/
	
	function add_sector(){
	
		if(!empty($_SESSION['edu_admin'])) {
			$data = array();
			$data['title'] = 'Add Sector';
			$data['form_url'] = base_url().'admin/add_sector/';
			$data['form_type'] = 'add';
				
			$this->__form_sector($data);
				
				
		}
		else{
			$this->login();
		}
	
	}
	
	function edit_sector($pid=''){
	
		if(!empty($_SESSION['edu_admin'])) {
			$data = array();
			$data['title'] = 'Edit Sector';
			$data['form_url'] = base_url().'admin/edit_sector/'.$pid;
			$data['form_type'] = 'edit';
				
			$this->load->model('admin/admin_model');
			$data['details'] = $this->admin_model->get_sector_details($pid);
				
			if( $data['details']==false || !is_array($data['details']) ){
				$this->session->set_userdata('manage_sector_error', 'Invalid Record');
				redirect('admin/manage_sector');
				exit();
			}
				
			$this->__form_sector($data);
				
				
		}
		else{
			$this->login();
		}
	
	}
	
	function __form_sector($data){
	
		$data['right_bar']	= 'noright';
		$data['layout']		= 'loggedin';
		$data['content']	= 'admin/form_sector';
		$data['selected']	= 'sector';
	
		$this->load->model('admin/admin_model');
		
		$data['all_test_type'] = $this->admin_model->all_test_type();
		
		$this->load->library('form_validation');
	
		$data['success'] = $this->session->userdata('manage_sector_success');
		$this->session->set_userdata('manage_sector_success', '');
		$data['error'] = $this->session->userdata('manage_sector_error');
		$this->session->set_userdata('manage_sector_error', '');
	
		if(isset($_POST['save_form'])) {
			
			$data['details'] = $_POST;
				
			$this->form_validation->set_rules('test_type_id', 'Test Type', 'required|trim');
			$this->form_validation->set_rules('p_name', 'Name', 'required|trim|xss_clean|max_length[80]');
				
			if ($this->form_validation->run() != FALSE){
	
				if( $data['form_type'] == 'add' ){
					$data['update'] = $this->admin_model->add_sector($this->input->post());
				}
				elseif( $data['form_type'] == 'edit' ){
					$data['update'] = $this->admin_model->update_sector($this->input->post());
				}
	
				if($data['update']) {
					$this->session->set_userdata('manage_sector_success', $data['form_type'] == 'add' ? 'Added Successfully' : 'Updated Successfully');
					redirect('admin/manage_sector');
					exit();
				}
	
			}
				
		}
	
		$this->load->view('admin/container', $data);
	
	}
	
	function manage_sector(){
	
		if(!empty($_SESSION['edu_admin'])) {
	
			$data['title']		= "Manage Sector";
			$data['right_bar']	= 'noright';
			$data['layout']		= 'loggedin';
			$data['content']	= 'admin/manage_sector';
			$data['selected']	= 'sector';
				
			$this->load->model('admin/admin_model');
				
			$total_members = $this->admin_model->count_all_sector();
				
			$this->load->library('pagination');
				
			$config['base_url']		= base_url().'admin/manage_sector/';
			$config['total_rows']	= $total_members;
			$config['per_page']		= '100';
			$config['uri_segment']	= 3;
			$config['num_links']	= 5;
				
			$Page_No = $this->uri->segment(3,0);
			$data['Page_No'] = $Page_No;
				
			$this->pagination->initialize($config);
				
			$data['all_subject'] = $this->admin_model->all_sector($Page_No, $config['per_page']);
	
			$data['success'] = $this->session->userdata('manage_sector_success');
			$this->session->set_userdata('manage_sector_success', '');
			$data['error'] = $this->session->userdata('manage_sector_error');
			$this->session->set_userdata('manage_sector_error', '');
				
			$this->load->view('admin/container', $data);
	
		}
		else{
			$this->login();
		}
	
	}
	
	function delete_sector()
	{
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$this->admin_model->delete_sector($_POST);
			return true;
		}
	}
	
	/*
	 }
	*/
	/*
	 {
	*/
	
	function add_section(){
	
		if(!empty($_SESSION['edu_admin'])) {
			$data = array();
			$data['title'] = 'Add Section';
			$data['form_url'] = base_url().'admin/add_section/';
			$data['form_type'] = 'add';
	
			$this->__form_section($data);
	
	
		}
		else{
			$this->login();
		}
	
	}
	
	function edit_section($pid=''){
	
		if(!empty($_SESSION['edu_admin'])) {
			$data = array();
			$data['title'] = 'Edit Section';
			$data['form_url'] = base_url().'admin/edit_section/'.$pid;
			$data['form_type'] = 'edit';
	
			$this->load->model('admin/admin_model');
			$data['details'] = $this->admin_model->get_section_details($pid);
	
			if( $data['details']==false || !is_array($data['details']) ){
				$this->session->set_userdata('manage_section_error', 'Invalid Record');
				redirect('admin/manage_section');
				exit();
			}
	
			$this->__form_section($data);
	
	
		}
		else{
			$this->login();
		}
	
	}
	
	function __form_section($data){
	
		$data['right_bar']	= 'noright';
		$data['layout']		= 'loggedin';
		$data['content']	= 'admin/form_section';
		$data['selected']	= 'section';
	
		$this->load->model('admin/admin_model');
	
		$data['all_sector'] = $this->admin_model->all_sector();
		
		if( isset($data['details']['pid']) ){
			$query = $this->db->query('SELECT `sector_id` FROM `section_sector` WHERE `section_id`='.$data['details']['pid'].' ORDER BY pid DESC');

			$resuls = $query->result_array();
			
			foreach($resuls as $K=>$V){

				$data['details']['sector_ids'][] = $V['sector_id'];

			}
		}
	
		$this->load->library('form_validation');
	
		$data['success'] = $this->session->userdata('manage_section_success');
		$this->session->set_userdata('manage_section_success', '');
		$data['error'] = $this->session->userdata('manage_section_error');
		$this->session->set_userdata('manage_section_error', '');
	
		if(isset($_POST['save_form'])) {
			
			$data['details'] = $_POST;
			
			$this->form_validation->set_rules('sector_ids[]', 'Sector', 'required');
			$this->form_validation->set_rules('p_name', 'Name', 'required|trim|xss_clean|max_length[80]');
	
			if ($this->form_validation->run() != FALSE){
	
				if( $data['form_type'] == 'add' ){
					$data['update'] = $this->admin_model->add_section($this->input->post());
				}
				elseif( $data['form_type'] == 'edit' ){
					$data['update'] = $this->admin_model->update_section($this->input->post());
				}
	
				if($data['update']) {
					$this->session->set_userdata('manage_section_success', $data['form_type'] == 'add' ? 'Added Successfully' : 'Updated Successfully');
					redirect('admin/manage_section');
					exit();
				}
	
			}
	
		}
	
		$this->load->view('admin/container', $data);
	
	}
	
	function manage_section(){
	
		if(!empty($_SESSION['edu_admin'])) {
	
			$data['title']		= "Manage Section";
			$data['right_bar']	= 'noright';
			$data['layout']		= 'loggedin';
			$data['content']	= 'admin/manage_section';
			$data['selected']	= 'section';
	
			$this->load->model('admin/admin_model');
	
			$total_members = $this->admin_model->count_all_section();
	
			$this->load->library('pagination');
	
			$config['base_url']		= base_url().'admin/manage_section/';
			$config['total_rows']	= $total_members;
			$config['per_page']		= '100';
			$config['uri_segment']	= 3;
			$config['num_links']	= 5;
	
			$Page_No = $this->uri->segment(3,0);
			$data['Page_No'] = $Page_No;
	
			$this->pagination->initialize($config);
	
			$data['all_subject'] = $this->admin_model->all_section($Page_No, $config['per_page']);
	
			$data['success'] = $this->session->userdata('manage_section_success');
			$this->session->set_userdata('manage_section_success', '');
			$data['error'] = $this->session->userdata('manage_section_error');
			$this->session->set_userdata('manage_section_error', '');
	
			$this->load->view('admin/container', $data);
	
		}
		else{
			$this->login();
		}
	
	}
	
	function delete_section()
	{
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$this->admin_model->delete_section($_POST);
			return true;
		}
	}
	
	/*
	 }
	*/
	/*
	 {
	*/
	
	function add_section_sub(){
	
		if(!empty($_SESSION['edu_admin'])) {
			$data = array();
			$data['title'] = 'Add Sub Section';
			$data['form_url'] = base_url().'admin/add_section_sub/';
			$data['form_type'] = 'add';
	
			$this->__form_section_sub($data);
	
	
		}
		else{
			$this->login();
		}
	
	}
	
	function edit_section_sub($pid=''){
	
		if(!empty($_SESSION['edu_admin'])) {
			$data = array();
			$data['title'] = 'Edit Sub Section';
			$data['form_url'] = base_url().'admin/edit_section_sub/'.$pid;
			$data['form_type'] = 'edit';
	
			$this->load->model('admin/admin_model');
			$data['details'] = $this->admin_model->get_section_sub_details($pid);
	
			if( $data['details']==false || !is_array($data['details']) ){
				$this->session->set_userdata('manage_section_sub_error', 'Invalid Record');
				redirect('admin/manage_section_sub');
				exit();
			}
	
			$this->__form_section_sub($data);
	
	
		}
		else{
			$this->login();
		}
	
	}
	
	function __form_section_sub($data){
	
		$data['right_bar']	= 'noright';
		$data['layout']		= 'loggedin';
		$data['content']	= 'admin/form_section_sub';
		$data['selected']	= 'section';
	
		$this->load->model('admin/admin_model');
	
		$data['all_section'] = $this->admin_model->all_section();
	
		if( isset($data['details']['pid']) ){
			$query = $this->db->query('SELECT `section_id` FROM `section_sub_section` WHERE `section_sub_id`='.$data['details']['pid'].' ORDER BY pid DESC');
			$resuls = $query->result_array();
		
			foreach($resuls as $K=>$V){
				$data['details']['section_ids'][] = $V['section_id'];
			}
		}
	
		$this->load->library('form_validation');
	
		$data['success'] = $this->session->userdata('manage_section_sub_success');
		$this->session->set_userdata('manage_section_sub_success', '');
		$data['error'] = $this->session->userdata('manage_section_sub_error');
		$this->session->set_userdata('manage_section_sub_error', '');
	
		if(isset($_POST['save_form'])) {
			
			$data['details'] = $_POST;
				
			$this->form_validation->set_rules('section_ids[]', 'Section', 'required');
			$this->form_validation->set_rules('p_name', 'Name', 'required|trim|xss_clean|max_length[80]');
	
			if ($this->form_validation->run() != FALSE){
	
				if( $data['form_type'] == 'add' ){
					$data['update'] = $this->admin_model->add_section_sub($this->input->post());
				}
				elseif( $data['form_type'] == 'edit' ){
					$data['update'] = $this->admin_model->update_section_sub($this->input->post());
				}
	
				if($data['update']) {
					$this->session->set_userdata('manage_section_sub_success', $data['form_type'] == 'add' ? 'Added Successfully' : 'Updated Successfully');
					redirect('admin/manage_section_sub');
					exit();
				}
	
			}
	
		}
	
		$this->load->view('admin/container', $data);
	
	}
	
	function manage_section_sub(){
	
		if(!empty($_SESSION['edu_admin'])) {
	
			$data['title']		= "Manage Sub Section";
			$data['right_bar']	= 'noright';
			$data['layout']		= 'loggedin';
			$data['content']	= 'admin/manage_section_sub';
			$data['selected']	= 'section';
	
			$this->load->model('admin/admin_model');
	
			$total_members = $this->admin_model->count_all_section_sub();
	
			$this->load->library('pagination');
	
			$config['base_url']		= base_url().'admin/manage_section_sub/';
			$config['total_rows']	= $total_members;
			$config['per_page']		= '100';
			$config['uri_segment']	= 3;
			$config['num_links']	= 5;
	
			$Page_No = $this->uri->segment(3,0);
			$data['Page_No'] = $Page_No;
	
			$this->pagination->initialize($config);
	
			$data['all_subject'] = $this->admin_model->all_section_sub($Page_No, $config['per_page']);
	
			$data['success'] = $this->session->userdata('manage_section_sub_success');
			$this->session->set_userdata('manage_section_sub_success', '');
			$data['error'] = $this->session->userdata('manage_section_sub_error');
			$this->session->set_userdata('manage_section_sub_error', '');
	
			$this->load->view('admin/container', $data);
	
		}
		else{
			$this->login();
		}
	
	}
	
	function delete_section_sub()
	{
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {
			$this->load->model('admin/admin_model');
			$this->admin_model->delete_section_sub($_POST);
			return true;
		}
	}
	
	/*
	 }
	*/
	/*

	 {

	*/

	

	function add_question(){

	

		if(!empty($_SESSION['edu_admin'])) {

			$data = array();

			$data['title'] = 'Add Question';

			$data['form_url'] = base_url().'admin/add_question/';

			$data['form_type'] = 'add';

	

			$this->__form_question($data);

	

	

		}

		else{

			$this->login();

		}

	

	}

	

	function edit_question($pid=''){

	

		if(!empty($_SESSION['edu_admin'])) {

			$data = array();

			$data['title'] = 'Edit Question';

			$data['form_url'] = base_url().'admin/edit_question/'.$pid;

			$data['form_type'] = 'edit';

	

			$this->load->model('admin/admin_model');

			$data['details'] = $this->admin_model->get_question_details($pid);

	

			if( $data['details']==false || !is_array($data['details']) ){

				$this->session->set_userdata('manage_question_error', 'Invalid Record');

				redirect('admin/manage_question');

				exit();

			}

	

			$this->__form_question($data);

	

	

		}

		else{

			$this->login();

		}

	

	}

	

	function __form_question($data){

	

		$data['right_bar']	= 'noright';

		$data['layout']		= 'loggedin';

		$data['content']	= 'admin/form_question';

		$data['selected']	= 'question';

	

		$this->load->model('admin/admin_model');

	

		$data['all_section_sub'] = $this->admin_model->all_section_sub();

	

		$this->load->library('form_validation');

	

		$data['success'] = $this->session->userdata('manage_question_success');

		$this->session->set_userdata('manage_question_success', '');

		$data['error'] = $this->session->userdata('manage_question_error');

		$this->session->set_userdata('manage_question_error', '');

	

		if(isset($_POST['save_form'])) {
			
			$data['details'] = $_POST;

	

			$this->form_validation->set_rules('section_sub_id', 'Sub Section', 'required|trim');
			$this->form_validation->set_rules('question', 'Question', 'required|trim');
			$this->form_validation->set_rules('ops1', 'Option 1', 'required|trim');
			$this->form_validation->set_rules('ops2', 'Option 2', 'required|trim');
			$this->form_validation->set_rules('ops3', 'Option 3', 'required|trim');
			$this->form_validation->set_rules('ops4', 'Option 4', 'required|trim');
			$this->form_validation->set_rules('answer', 'Answer', 'required|trim|max_length[1]|numeric|callback_chkanswer');

	

			if ($this->form_validation->run() != FALSE){

	

				if( $data['form_type'] == 'add' ){

					$data['update'] = $this->admin_model->add_question($this->input->post());

				}

				elseif( $data['form_type'] == 'edit' ){

					$data['update'] = $this->admin_model->update_question($this->input->post());

				}

	

				if($data['update']) {

					$this->session->set_userdata('manage_question_success', $data['form_type'] == 'add' ? 'Added Successfully' : 'Updated Successfully');

					redirect('admin/manage_question');

					exit();

				}

	

			}

	

		}

	

		$this->load->view('admin/container', $data);

	

	}
	
	function chkanswer()
	{
		$ans = $this->input->post('answer');
		$ans_array = array(1, 2, 3, 4);
		if(in_array($ans, $ans_array)) {
			return true;
		} else {
			$this->form_validation->set_message('chkanswer', 'Answer should be between 1 to 4');
			return false;
		}
	}

	

	function manage_question(){

	

		if(!empty($_SESSION['edu_admin'])) {

	

			$data['title']		= "Manage Question";

			$data['right_bar']	= 'noright';

			$data['layout']		= 'loggedin';

			$data['content']	= 'admin/manage_question';

			$data['selected']	= 'question';

	

			$this->load->model('admin/admin_model');

	

			$total_members = $this->admin_model->count_all_question();

	

			$this->load->library('pagination');

	

			$config['base_url']		= base_url().'admin/manage_question/';

			$config['total_rows']	= $total_members;

			$config['per_page']		= '200';

			$config['uri_segment']	= 3;

			$config['num_links']	= 5;

	

			$Page_No = $this->uri->segment(3,0);

			$data['Page_No'] = $Page_No;

	

			$this->pagination->initialize($config);

	

			$data['all_subject'] = $this->admin_model->all_question($Page_No, $config['per_page']);

	

			$data['success'] = $this->session->userdata('manage_question_success');

			$this->session->set_userdata('manage_question_success', '');

			$data['error'] = $this->session->userdata('manage_question_error');

			$this->session->set_userdata('manage_question_error', '');

	

			$this->load->view('admin/container', $data);

	

		}

		else{

			$this->login();

		}

	

	}

	

	function delete_question()

	{

		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {

			$this->load->model('admin/admin_model');

			$this->admin_model->delete_question($_POST);

			return true;

		}

	}

	

	/*

	 }

	*/
	/*

	 {

	*/

	

	function add_test(){

	

		if(!empty($_SESSION['edu_admin'])) {

			$data = array();

			$data['title'] = 'Add Test';

			$data['form_url'] = base_url().'admin/add_test/';

			$data['form_type'] = 'add';

	

			$this->__form_test($data);

	

	

		}

		else{

			$this->login();

		}

	

	}

	

	function edit_test($pid=''){

	

		if(!empty($_SESSION['edu_admin'])) {

			$data = array();

			$data['title'] = 'Edit Test';

			$data['form_url'] = base_url().'admin/edit_test/'.$pid;

			$data['form_type'] = 'edit';

	

			$this->load->model('admin/admin_model');

			$data['details'] = $this->admin_model->get_test_details($pid);

	

			if( $data['details']==false || !is_array($data['details']) ){

				$this->session->set_userdata('manage_test_error', 'Invalid Record');

				redirect('admin/manage_test');

				exit();

			}

	

			$this->__form_test($data);

	

	

		}

		else{

			$this->login();

		}

	

	}

	

	function __form_test($data){

	

		$data['right_bar']	= 'noright';

		$data['layout']		= 'loggedin';

		$data['content']	= 'admin/form_test';

		$data['selected']	= 'test';

	

		$this->load->model('admin/admin_model');

	

		$this->load->library('form_validation');

	

		$data['success'] = $this->session->userdata('manage_test_success');

		$this->session->set_userdata('manage_test_success', '');

		$data['error'] = $this->session->userdata('manage_test_error');

		$this->session->set_userdata('manage_test_error', '');
		
		if( isset($data['details']['pid']) ){
			$query = $this->admin_model->db->query('

			SELECT

				A.`pid`, A.`title`

			FROM `section` A

			LEFT OUTER JOIN

			`section_sector` B

			ON B.`sector_id`='.( isset($data['details']['sector_id']) ? $data['details']['sector_id'] : '' ).' AND A.pid=B.section_id

			WHERE

			B.`sector_id`='.( isset($data['details']['sector_id']) ? $data['details']['sector_id'] : '' ).' AND A.pid=B.section_id

			ORDER BY A.pid DESC

			');
			$result = $query->result_array();
			foreach($result as $K=>$V){
				
				$query1 = $this->admin_model->db->query('
				SELECT
					A.`pid`, A.`title`
				FROM `section_sub` A
				LEFT OUTER JOIN
				`section_sub_section` B
				ON B.`section_id`='.$V['pid'].' AND A.pid=B.section_sub_id
				WHERE
				B.`section_id`='.$V['pid'].' AND A.pid=B.section_sub_id
				ORDER BY A.pid DESC
				');
				$result1 = $query1->result_array();
					foreach($result1 as $K1=>$V1){
						$data['details']['values'][ $V['pid'] ][ $V1['pid'] ] = array(
							'q'		=> '',
							'm'		=> '',
							'ra'	=> '',
							'wa'	=> '',
						);						
					}
				
			}
			
			$query = $this->db->query('SELECT * FROM `test_set` WHERE `test_id`='.$data['details']['pid'].' AND `sector_id`='.( isset($data['details']['sector_id']) ? $data['details']['sector_id'] : '' ).' ORDER BY pid DESC');

			$resuls = $query->result_array();
			foreach($resuls as $K=>$V){
				$data['details']['values'][ $V['section_id'] ][ $V['section_sub_id'] ] = array(
					'q'		=> $V['question'],
					'm'		=> $V['minutes'],
					'ra'	=> $V['ra'],
					'wa'	=> $V['wa'],
				);
			}
		}

	

		if(isset($_POST['save_form'])) {
			
			$data['details'] = $_POST;

	

			$this->form_validation->set_rules('title', 'Name', 'required|trim|xss_clean|max_length[80]');
			$this->form_validation->set_rules('test_type_id', 'Test Type', 'required|trim');
			$this->form_validation->set_rules('sector_id', 'Sector', 'required|trim');
			$this->form_validation->set_rules('values', 'Question', 'required|callback_set_test_question');

	

			if ($this->form_validation->run() != FALSE){

	

				if( $data['form_type'] == 'add' ){

					$data['update'] = $this->admin_model->add_test($this->input->post());

				}

				elseif( $data['form_type'] == 'edit' ){

					$data['update'] = $this->admin_model->update_test($this->input->post());

				}

	

				if($data['update']) {

					$this->session->set_userdata('manage_test_success', $data['form_type'] == 'add' ? 'Added Successfully' : 'Updated Successfully');

					redirect('admin/manage_test');

					exit();

				}

	

			}

	

		}

	

		$this->load->view('admin/container', $data);

	

	}
	
	function set_test_question()
	{
		$values = $this->input->post('values');
		$notFound = true;
		
		if( is_array($values) ){

			foreach($values as $K=>$V){

				foreach($V as $K1=>$V1){
					if( isset($V1['q']) && isset($V1['m']) && isset($V1['ra']) && isset($V1['wa']) ){
						if( $V1['q']!='' ){
							$notFound = false;
							if( !( $V1['q']>0 && preg_match('/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/', $V1['q']) ) ){
								$this->form_validation->set_message('set_test_question', 'Enter question and other fields');
								return false;
							}
							if( !( $V1['m']>0 && preg_match('/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/', $V1['m']) ) ){
								$this->form_validation->set_message('set_test_question', 'Enter question and other fields');
								return false;
							}
							if( !( $V1['ra']>0 && preg_match('/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/', $V1['ra']) ) ){
								$this->form_validation->set_message('set_test_question', 'Enter question and other fields');
								return false;
							}
							if( !( preg_match('/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/', $V1['wa']) ) ){
								$this->form_validation->set_message('set_test_question', 'Enter question and other fields');
								return false;
							}
						}
					}
				}
			}
		}
		
		if( $notFound ){
			$this->form_validation->set_message('set_test_question', 'Enter question and other fields');
			return false;
		}
		
		return true;
	}

	

	function manage_test(){

	

		if(!empty($_SESSION['edu_admin'])) {

	

			$data['title']		= "Manage Test";

			$data['right_bar']	= 'noright';

			$data['layout']		= 'loggedin';

			$data['content']	= 'admin/manage_test';

			$data['selected']	= 'test';

	

			$this->load->model('admin/admin_model');

	

			$total_members = $this->admin_model->count_all_test();

	

			$this->load->library('pagination');

	

			$config['base_url']		= base_url().'admin/manage_test/';

			$config['total_rows']	= $total_members;

			$config['per_page']		= '100';

			$config['uri_segment']	= 3;

			$config['num_links']	= 5;

	

			$Page_No = $this->uri->segment(3,0);

			$data['Page_No'] = $Page_No;

	

			$this->pagination->initialize($config);

	

			$data['all_subject'] = $this->admin_model->all_test($Page_No, $config['per_page']);

	

			$data['success'] = $this->session->userdata('manage_test_success');

			$this->session->set_userdata('manage_test_success', '');

			$data['error'] = $this->session->userdata('manage_test_error');

			$this->session->set_userdata('manage_test_error', '');

	

			$this->load->view('admin/container', $data);

	

		}

		else{

			$this->login();

		}

	

	}

	

	function delete_test()

	{

		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {

			$this->load->model('admin/admin_model');

			$this->admin_model->delete_test($_POST);

			return true;

		}

	}

	

	/*

	 }

	*/
	/*

	 {

	*/

	

	function add_payment(){

	

		if(!empty($_SESSION['edu_admin'])) {

			$data = array();

			$data['title'] = 'Add Payment';

			$data['form_url'] = base_url().'admin/add_payment/';

			$data['form_type'] = 'add';

				

			$this->__form_payment($data);

				

				

		}

		else{

			$this->login();

		}

	

	}

	

	function edit_payment($pid=''){

	

		if(!empty($_SESSION['edu_admin'])) {

			$data = array();

			$data['title'] = 'Edit Payment';

			$data['form_url'] = base_url().'admin/edit_payment/'.$pid;

			$data['form_type'] = 'edit';

				

			$this->load->model('admin/admin_model');

			$data['details'] = $this->admin_model->get_payment_details($pid);

				

			if( $data['details']==false || !is_array($data['details']) ){

				$this->session->set_userdata('manage_payment_error', 'Invalid Record');

				redirect('admin/manage_payment');

				exit();

			}

				

			$this->__form_payment($data);

				

				

		}

		else{

			$this->login();

		}

	

	}

	

	function __form_payment($data){
		
		exit();

	

		$data['right_bar']	= 'noright';

		$data['layout']		= 'loggedin';

		$data['content']	= 'admin/form_payment';

		$data['selected']	= 'payment';

	

		$this->load->model('admin/admin_model');

		$this->load->library('form_validation');

	

		$data['success'] = $this->session->userdata('manage_payment_success');

		$this->session->set_userdata('manage_payment_success', '');

		$data['error'] = $this->session->userdata('manage_payment_error');

		$this->session->set_userdata('manage_payment_error', '');

	

		if(isset($_POST['save_form'])) {

				

			$data['details'] = $_POST;

				

			$this->form_validation->set_rules('p_name', 'Name', 'required|trim|xss_clean|max_length[80]');

				

			if ($this->form_validation->run() != FALSE){

	

				if( $data['form_type'] == 'add' ){

					$data['update'] = $this->admin_model->add_payment($this->input->post());

				}

				elseif( $data['form_type'] == 'edit' ){

					$data['update'] = $this->admin_model->update_payment($this->input->post());

				}

	

				if($data['update']) {

					$this->session->set_userdata('manage_payment_success', $data['form_type'] == 'add' ? 'Added Successfully' : 'Updated Successfully');

					redirect('admin/manage_payment');

					exit();

				}

	

			}

				

		}

	

		$this->load->view('admin/container', $data);

	

	}

	

	function manage_payment(){

	

		if(!empty($_SESSION['edu_admin'])) {

	

			$data['title']		= "Manage Payment";

			$data['right_bar']	= 'noright';

			$data['layout']		= 'loggedin';

			$data['content']	= 'admin/manage_payment';

			$data['selected']	= 'payment';

				

			$this->load->model('admin/admin_model');

				

			$total_members = $this->admin_model->count_all_payment();

				

			$this->load->library('pagination');

				

			$config['base_url']		= base_url().'admin/manage_payment/';

			$config['total_rows']	= $total_members;

			$config['per_page']		= '100';

			$config['uri_segment']	= 3;

			$config['num_links']	= 5;

				

			$Page_No = $this->uri->segment(3,0);

			$data['Page_No'] = $Page_No;

				

			$this->pagination->initialize($config);

				

			$data['all_subject'] = $this->admin_model->all_payment($Page_No, $config['per_page']);

	

			$data['success'] = $this->session->userdata('manage_payment_success');

			$this->session->set_userdata('manage_payment_success', '');

			$data['error'] = $this->session->userdata('manage_payment_error');

			$this->session->set_userdata('manage_payment_error', '');

				

			$this->load->view('admin/container', $data);

	

		}

		else{

			$this->login();

		}

	

	}

	

	function delete_payment()

	{

		exit();
		if(isset($_POST['id']) && !empty($_SESSION['edu_admin'])) {

			$this->load->model('admin/admin_model');

			$this->admin_model->delete_payment($_POST);

			return true;

		}

	}

	

	/*

	 }

	*/
	
	/*****
	}
	*****/
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */