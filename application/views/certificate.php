<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css">
  
  <br>
  <br />
  <table width="928" height="637" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
  <tr>
		<td colspan="5">
			<img src="<?php echo base_url();?>assets/images/Certificate_01.jpg" width="928" height="276" alt=""></td>
	</tr>
	<tr>
		<td colspan="5" background="<?php echo base_url();?>assets/images/Certificate_02.jpg" width="928" height="73" alt="">
			
            <div align="center"><span class="subtitlered2"> <?php echo $udetails['name']; ?> </span></div>
            </td>
	
    
    </tr>
	<tr>
		<td colspan="5">
			<img src="<?php echo base_url();?>assets/images/Certificate_03.jpg" width="928" height="41" alt=""></td>
	</tr>
	<tr>
		<td colspan="5" background="<?php echo base_url();?>assets/images/Certificate_04.jpg" width="928" height="73" alt="">

  
  <div align="center">
  <span class="subtitlered2">
	  <?php

      $query = $this->db->query('SELECT `test_type_id` FROM `test` WHERE `pid` = "'.$result['test_id'].'"');

      $info = $query->row_array();

      if( $info!=false ){

      	$query = $this->db->query('SELECT `title` FROM `test_type` WHERE `pid` = "'.$info['test_type_id'].'"');

      	$info = $query->row_array();

      	if( $info!=false ){

      		echo $info['title'];

      	}

      }

      ?>
      </span> 
		</div>	
            
            </td>
	</tr>
	<tr>
		<td colspan="3">
			<img src="<?php echo base_url();?>assets/images/Certificate_05.jpg" width="407" height="74" alt=""></td>
		<td rowspan="4">
			<img src="<?php echo base_url();?>assets/images/Certificate_06.jpg" width="140" height="174" alt=""></td>
		<td rowspan="4">
			<img src="<?php echo base_url();?>assets/images/Certificate_07.png" width="381" height="174" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3">
			<img src="<?php echo base_url();?>assets/images/Certificate_08.jpg" width="73" height="100" alt=""></td>
		<td>
			<img src="<?php echo base_url();?>assets/images/Certificate_09.jpg" width="147" height="21" alt=""></td>
		<td rowspan="3">
			<img src="<?php echo base_url();?>assets/images/Certificate_10.jpg" width="187" height="100" alt=""></td>
	</tr>
	<tr>
		<td background="<?php echo base_url();?>assets/images/Certificate_11.jpg" width="147" height="22" alt="">
            <div align="right"> <span class="advtb"> <?php echo date('j M, Y', $result['iniTime']); ?></span></div>
           
            </td>
	</tr>
	<tr>
		<td>
			<img src="<?php echo base_url();?>assets/images/Certificate_12.jpg" width="147" height="57" alt=""></td>
	</tr>
</table>  
  
  
  