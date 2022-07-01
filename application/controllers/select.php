<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Select extends CI_Controller {

	public function s_subject()
	{
		if(!empty($_SESSION['edu_admin']) && !empty($_POST['bid'])) {
			 $this->load->model('admin/admin_model');
			 $data['subject'] =  $this->admin_model->load_subjects($_POST['bid']);
			 $this->load->view('admin/load_subjects', $data);
		} else {

		}
	}
	
	public function s_passage()
	{
		if(!empty($_SESSION['edu_admin']) && !empty($_POST['sub_id'])) {
			 $this->load->model('admin/admin_model');
			 $data['passage'] =  $this->admin_model->load_passage($_POST['sub_id']);
			 $this->load->view('admin/load_passage', $data);
		} else {

		}
	}
	
	public function test_form_sector(){
		if( !empty($_SESSION['edu_admin']) ){
			if( isset($_POST['id']) && $_POST['id']!='' ){
				$this->load->model('admin/admin_model');
				
				$query = $this->admin_model->db->query('SELECT * FROM `sector` WHERE test_type_id='.$_POST['id']);
				$options = array();
				if( $query ){
					$result = $query->result_array();
					if( $result ){
						foreach($result as $K=>$V){
							$options[] = '<option value="'.$V['pid'].'">'.$V['title'].'</option>';
						}
					}
				}
				if( isset($options[0]) ){
					echo '<select name="sector_id" id="sector_id" class="sector_id" onchange="onSector(this)"><option value="">Select</option>'.implode('', $options).'<select>';
					unset($options);
				}
			}
		}
	}
	
	public function test_form_section(){
		if( !empty($_SESSION['edu_admin']) ){
			if( isset($_POST['id']) && $_POST['id']!='' ){
				$this->load->model('admin/admin_model');
				
				$query = $this->admin_model->db->query('
				SELECT 
					A.`pid`, A.`title` 
				FROM `section` A 
				LEFT OUTER JOIN 
				`section_sector` B 
				ON B.`sector_id`='.$_POST['id'].' AND A.pid=B.section_id 
				WHERE 
				B.`sector_id`='.$_POST['id'].' AND A.pid=B.section_id 
				ORDER BY A.pid DESC
				');
				//echo $this->admin_model->db->last_query();
				
				$html = array();
				$result = '';
				if( $query ){
					$result = $query->result_array();
					if( $result ){
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
							//echo $this->admin_model->db->last_query();
							
							$html1 = array();
							$result1 = '';
							if( $query1 ){
								$result1 = $query1->result_array();
								if( $result1 ){
									foreach($result1 as $K1=>$V1){
										
										$info = array(
											'q' => '',
											'm' => '',
											'ra' => '',
											'wa' => '',
										);
										
										if( isset($_POST['pid']) && $_POST['pid']!='' && $_POST['pid']>0 ){
											$query = $this->db->query('
											SELECT * FROM `test_set` 
											WHERE 
											`test_id`='.$_POST['pid'].' AND `sector_id`='.$_POST['id'].' AND `section_id`='.$V['pid'].' AND `section_sub_id`='.$V1['pid'].'
											LIMIT 1
											');
											//echo $this->admin_model->db->last_query();
											
											$row = $query->row_array();
											if( isset($row['pid']) ){
										
												$info = array(
													'q'		=> $row['question'],
													'm'		=> $row['minutes'],
													'ra'	=> $row['ra'],
													'wa'	=> $row['wa'],
												);
												
											}
										}
										
										$html1[] = '
												<tr class="gradeA '.($K1%2==0 ? 'even' : 'odd').'">
													<td>'.$V1['title'].'</td>
													<td>
														<input type="text" class="mediuminput" name="values['.$V['pid'].']['.$V1['pid'].'][q]" value="'.$info['q'].'">
													</td>
													<td>
														<input type="text" class="mediuminput" name="values['.$V['pid'].']['.$V1['pid'].'][m]" value="'.$info['m'].'">
													</td>
													<td>
														<input type="text" class="mediuminput" name="values['.$V['pid'].']['.$V1['pid'].'][ra]" value="'.$info['ra'].'">
													</td>
													<td>
														<input type="text" class="mediuminput" name="values['.$V['pid'].']['.$V1['pid'].'][wa]" value="'.$info['wa'].'">
													</td>
												</tr>
										';
									}
								}
							}
							if( isset($html1[0]) ){
								$html1 = '
										<table border="0" cellpadding="0" class="stdtable" style="width: 600px">
										
										<thead>
                       						<tr>
												<th class="head1" rowspan="1" colspan="1" style="width: 150px;">&nbsp;</th>
												<th class="head1" rowspan="1" colspan="1" style="width: 100px;">Set Question</th>
												<th class="head1" rowspan="1" colspan="1" style="width: 100px;">Set Minutes</th>
												<th class="head1" rowspan="1" colspan="1" style="width: 100px;">Set RA Mark</th>
												<th class="head1" rowspan="1" colspan="1" style="width: 100px;">Set WA Mark</th>
											</tr>
                    					</thead>
										
										'.implode('', $html1).'

										</table>
								';
							}
							else{
								$html1 = '';
							}
							
							$html[] = '
								<div class="elSectionClass">
									<label>'.$V['title'].'</label>
									<div class="field">
											
									'.$html1.'
											
									</div>
								</div>
							';
							
							unset($query1, $result1, $html1);
						}
					}
				}
				if( isset($html[0]) ){
					echo implode('', $html);
				}
				unset($query, $result, $html);
			}
		}
	}
	
	public function fo_sector(){
	
		if( isset($_POST['id']) && $_POST['id']!='' ){
			$this->load->model('home_model');
			
			$query = $this->home_model->db->query('SELECT * FROM `sector` WHERE test_type_id='.$_POST['id'].' ORDER BY `pid` DESC');
			$options = array();
			if( $query ){
				$result = $query->result_array();
				if( $result ){
					foreach($result as $K=>$V){
						$options[] = '<option value="'.$V['pid'].'">'.$V['title'].'</option>';
					}
				}
			}
			echo implode('', $options);
			unset($options);

		}
	
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */