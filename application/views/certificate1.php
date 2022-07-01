<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css">
  
  <br>
  <br />
  <table width="700" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
  <tr>
  <td colspan="3" background="<?php echo base_url();?>assets/images/cert_top.jpg" width="9" height="8" border="0"></td>
  </tr>
  <tr>
  <td background="<?php echo base_url();?>assets/images/cert_top.jpg" width="9" height="8" border="0"></td>
	<td>  

	  <br />

<div align="center"><img src="<?php echo base_url();?>assets/images/AONE_Logo.png" border="0"></div>

      <br />

      <br />

      <br />

      <br />

      <div align="center"> <span class="titlegrey2">This is to certify that</span></div>

      <br>

      <br />

      <br />

      <br />

      <div align="center"><span class="subtitlered2"> Mr / Ms. <?php echo $udetails['name']; ?> </span></div>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;......................................................................................... 
      <br />

      <br>

      <br />

      <div align="center"><span class="advtb">has successfully completed the</span> <br />
	  
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
      </span> <br />
      <span class="advtb"> On <?php echo date('j M, Y', $result['iniTime']); ?></span>
      </div>

      <br>

      <br />

      <br />

      <br />

      <div align="center"><span class="titlegrey1">ASSESSED BY IMPETUS TECHKNOWS - <?php echo date('Y', $result['iniTime']); ?></span></div><br />

      <br>

      <br>

      <br />
      <br />

      <br />

      <br />
      <div align="right"><span class="content">Authorised Signatory &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
      For Impetus Techknows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div><br />

      <br />

    </td>

  <td background="<?php echo base_url();?>assets/images/cert_top.jpg" width="9" height="8" border="0"></td>
 </tr>
 <tr>
  <td colspan="3" background="<?php echo base_url();?>assets/images/cert_top.jpg" width="9" height="8" border="0"></td>
  </tr>
  </table>
  <br />
    <br />



