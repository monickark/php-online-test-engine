
<table width="1002" border="0" cellspacing="0" cellpadding="0">
	<tr>
    <td width="1" bgcolor="#F3F3F3"></td>
    <td width="750" valign="top"><br>
            
		<div align="center">
			<font class="titlegrey1"><br>Add Payment</font><br><br>
                 
<table width="550" cellspacing="1" cellpadding="0" border="0" bgcolor="#CCCCCC">
	<tr>
    	<td>
        	<form name="payment_add" action="<?php echo base_url();?>home/payment_add" method="post">
            
<table width="550" cellspacing="4" cellpadding="4" border="0" class="table1" bgcolor="#FFFFFF">
	<tr style="display: none;" id="test_type_id_row">
    	<td width="182"   align="right" class="bluetxt" >Test Type <font color="#FF0000">*</font>&nbsp;</td>
        <td align="left" width="321">
        	<select name="test_type_id" id="test_type_id" onchange="onTestType()">
            	<option value="">Select</option>
                <?php
                $query = $this->home_model->db->query('SELECT * FROM `test_type` ORDER BY `pid` DESC');
                $all_test_type = $query->result_array();
                foreach($all_test_type as $K=>$V){
                	echo '<option value="'.$V['pid'].'"'.set_select('test_type_id', $V['pid']).'>'.$V['title'].'</option>';
                }
                ?>                
			</select>
        	<?php echo form_error('test_type_id', '<p class="error">', '</p>'); ?>
        </td>
	</tr>
	<tr style="display: none;" id="sector_id_row">
    	<td width="182"   align="right" class="bluetxt" >Sector <font color="#FF0000">*</font>&nbsp;</td>
        <td align="left" width="321">
        	<select name="sector_id" id="sector_id">
            	<option value="">Select</option>
                <?php
                $query = $this->home_model->db->query('SELECT * FROM `sector` WHERE test_type_id="'.( isset($_POST['test_type_id']) ? $_POST['test_type_id'] : '' ).'" ORDER BY `pid` DESC');
                $all_sector = $query->result_array();
				foreach($all_sector as $K=>$V){
                	echo '<option value="'.$V['pid'].'"'.set_select('sector_id', $V['pid']).'>'.$V['title'].'</option>';
                }
                ?>                
			</select>
        	<?php echo form_error('sector_id', '<p class="error">', '</p>'); ?>
        </td>
	</tr>
	<tr style="display: none;" id="type_row">
		<td width="182"   align="right" class="bluetxt" > Select User Type <font color="#FF0000">*</font>&nbsp;</td>
        <td align="left" width="321"><label for="select"></label>
        	<select name="type" id="type">
            	<option value="">Select</option>
                <?php
                $types = array(
					USER_TYPE_INSTITUTIONAL => 'Institutional',
					USER_TYPE_CANDIDATE		=> 'Candidates Applying for Jobs',
					USER_TYPE_FRESHER		=> 'Fresher\'s',
                );
foreach($types as $K=>$V){
	echo '<option value="'.$K.'"'.set_select('type', $K).'>'.$V.'</option>';
}
                ?>
                </select>
                <?php echo form_error('type', '<p class="error">', '</p>'); ?></td>
              </tr>
			  <tr style="display: none;" id="user_count_row">
			    <td width="182"   align="right" class="bluetxt" >No of users <font color="#FF0000">*</font>&nbsp;</td>
			    <td align="left" width="321"><input name="user_count" type="text" class="textbox" value="<?php echo set_value('user_count'); ?>"><?php echo form_error('user_count', '<p class="error">', '</p>'); ?></td>
			  </tr>
			  <tr>

			  <tr>
			    <td width="182"   align="right" class="bluetxt" >Amount paid <font color="#FF0000">*</font>&nbsp;</td>
			    <td align="left" width="321"><input name="paid" type="text" class="textbox" value="<?php echo set_value('paid'); ?>"><?php echo form_error('paid', '<p class="error">', '</p>'); ?></td>
			  </tr>

			  <tr>
			    <td width="182"   align="right" class="bluetxt" >Date <font color="#FF0000">*</font>&nbsp;</td>
			    <td align="left" width="321">
			    <input id="paid_date_1" type="text" class="textbox" value="<?php
			    if( isset($_POST['paid_date']) && $_POST['paid_date']!='' ){
			    	echo date('j M Y', strtotime($_POST['paid_date']));
			    }
			    ?>" readonly="readonly">
			    <input name="paid_date" id="paid_date" type="hidden" class="textbox" value="<?php
			    if( isset($_POST['paid_date']) && $_POST['paid_date']!='' ){
			    	echo $_POST['paid_date'];
			    }
			    ?>">
			    <?php echo form_error('paid_date', '<p class="error">', '</p>'); ?>
			    </td>
			  </tr>

			  <tr>
			    <td width="182"   align="right" class="bluetxt" >NEFT Transaction No <font color="#FF0000">*</font>&nbsp;</td>
			    <td align="left" width="321"><input name="transaction_no" type="text" class="textbox" value="<?php echo set_value('transaction_no'); ?>"><?php echo form_error('transaction_no', '<p class="error">', '</p>'); ?></td>
			  </tr>

			  <tr>
			  <td align="center" colspan="2">
			  		<input type="submit" value="Save" name="save_form" STYLE="font-size:10pt;  color:#000000" >
			  </td>
			  </tr>
</table> 
          
			</form> 
		</td>
	</tr>
</table>
               
	</div>
    <br>
    <br>
    <br>
    </td>
    <td width="250" align="center" valign="top"><br>
              
    <?php include_once("sidebar_msg.php"); ?>
    
    </td>
    <td width="1" bgcolor="#F3F3F3"></td>
    </tr>
    <tr>
    <td bgcolor="#F3F3F3"></td>
    <td valign="top">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td bgcolor="#F3F3F3"></td>
    </tr>
</table>

<script type="text/javascript">
<!--
inputTestType = null;
ajaxTestType = null;
inputSector = null;

function onTestType(){
	var v = inputTestType.val();
	inputSector.find("option").not(":first").remove();
	inputSector.attr("disabled", "disabled");
	if( v!="" ){
		if( ajaxTestType ){
			ajaxTestType.abort();
		}
		ajaxTestType = jQuery.ajax({
			url		: "<?php echo base_url();?>select/fo_sector",
			type	: "POST",
			data	: {
				'id' : v,
			},
			error	: function(xhr, textStatus, errorThrown){
				inputSector.removeAttr("disabled");
			},
			success	: function(data){
				inputSector.append(data);
				inputSector.removeAttr("disabled");
			}
		});
		
	}
	else{
		inputSector.removeAttr("disabled");
	}
}

jQuery(function(){
	jQuery("#paid_date_1").datepicker({
		dateFormat:"d-M-yy",
		altField:"#paid_date",
		altFormat:"yy-mm-dd",
		changeMonth: true,
		changeYear: true
	});

	inputTestType = jQuery("#test_type_id");
	inputSector = jQuery("#sector_id");

	jQuery("#test_type_id_row").show();
	jQuery("#sector_id_row").show();
	
	jQuery("#type").on("change", function(){
		var t = jQuery(this);
		if( t.val()=="<?php echo USER_TYPE_INSTITUTIONAL ?>" ){
			jQuery("#user_count_row").show();
		}
		else{
			jQuery("#user_count_row").hide();
		}
	});
	jQuery("#type").trigger("change");
	jQuery("#type_row").show();
});
//-->
</script>