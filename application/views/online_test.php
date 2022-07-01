        <table width="1002" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top"><br> 
            
            <div align="center"> 
<style>
table.box-style {font-family:"Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size:12px;min-width:480px;text-align:left;border-collapse:collapse;margin-bottom:25px; margin-left:20px; margin-right:0; }
table.box-style th {font-size:14px;font-weight:normal;background:#ccc;border-top:4px solid #ddd;border-bottom:1px solid #fff;color:#666666;padding:10px;}
table.box-style td {background:#f9f9f9;border-bottom:1px solid #fff;color:#333;border-top:1px solid transparent;padding:8px 10px;}
table.box-style tr:hover td {background:#eee;color:#444;}
</style>
             <span class="advt">ONLINE TEST</span>
              <br>
              <br>  
              
            <?php
            if($alert_message){
				if( $_SESSION['edu_type']==USER_TYPE_USER ){
			?>              
			<div style="color:#F00; font-size:15px">Contact your institution</div>
            <?php
            	}
            	else{
			?>              
			<div style="color:#F00; font-size:15px">Our records indicate that you have not paid the fees yet. Please pay the fees by ONLINE or NEFT/RTGS and mail the transaction details to <a href="mailto:accounts@impetustechknows.in">accounts@impetustechknows.in</a></div>
            <?php
            	}
			}
			?>
  			<?php
  			if( !empty($online) ){
			?>
		    </div>
            <?php
            if( !empty($test) ){
			?>
	
	<table class="box-style">

	<tr id="Theading" >
		<th id="Theading"> Test Name</th>
		<!--<th id="Theading"> Date</th>-->
		<th id="Theading"> Test Type</th>
		<th id="Theading"> Sector</th>
		<th id="Theading"> Test Duration </th>
		<th id="Theading"> Action </th>
	</tr>

	<?php
	foreach($test as $test){
		$query = $this->db->query('SELECT * FROM `test_set` WHERE `test_id` = "'.$test['pid'].'"');
		$result = $query->result_array();
		
		$min = 0;
		foreach($result as $K=>$V){
			$min += ($V['question']*$V['minutes']);
		}
	?>
	<tr id="Tvalues">
		<td ><?php
		echo $test['title'];
		?></td>
		<!--<td><?php echo date('j M, Y', strtotime($test['date'])); ?></td>-->
		<td><?php
		$query = $this->db->query('SELECT * FROM `test_type` WHERE `pid` = "'.$test['test_type_id'].'"');
		$info = $query->row_array();
		if( $info!=false ){
			echo $info['title'];
		}
		?></td>
		<td><?php
		$query = $this->db->query('SELECT * FROM `sector` WHERE `pid` = "'.$test['sector_id'].'"');
		$info = $query->row_array();
		if( $info!=false ){
			echo $info['title'];
		}
		?></td>
		<td ><?php echo $min;?> Min.</td>
		<td ><center><?php
		echo anchor(
			'home/view/'.$test['pid'],
			img(array('src'=>'images/view.png', 'title'=>'View'))
		);
		?> </center></td>
	</tr>
	<?php
	}
	?>
	</table>
    <?php
	}
	else{
	?>
    <center>Test will be available from 10.00 am</center>
    <?php
	}
	?>
              <br>
              <div align="center">
            <?php
			}
			?>
            
             <br><br><br><br><br><br>
             </div>
                          
            </td>
            
            
            <td width="250" align="center" valign="top">
            <?php include_once("sidebar_msg.php"); ?>
        </td>
         <td width="1" bgcolor="#F3F3F3"></td>
        </tr>
        </table>  