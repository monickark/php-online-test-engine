<table width="1002" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top"><br>
            
                <div align="center"><font class="titlegrey1"><br>
                Registration Form</font>
                <br>
                  <br>

             <?php if(empty($s_register)) { ?>
            <form name="register" action="<?php echo base_url();?>register" method="post">

                 
            <table width="700" cellspacing="1" cellpadding="0" border="0" bgcolor="#CCCCCC">
            <tr>
            <td>

            
            <table width="700" cellspacing="4" cellpadding="4" border="0" class="table1" bgcolor="#FFFFFF">

             <tr>
                <td width="182"   align="right" class="bluetxt" >Institution Name <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="name" type="text" class="textbox" value="<?php echo set_value('name'); ?>" size="40"> <?php echo form_error('name', '<p class="error">', '</p>'); ?></td>
              </tr>
              <tr>
                <td width="182"   align="right" class="bluetxt" >Email <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="email" type="text" class="textbox" value="<?php echo set_value('email'); ?>" size="40"><?php echo form_error('email', '<p class="error">', '</p>'); ?></td>
              </tr>
             <tr>
                <td width="182"   align="right" class="bluetxt" >Mobile No <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="mobile" type="text" class="textbox" value="<?php echo set_value('mobile'); ?>"><?php echo form_error('mobile', '<p class="error">', '</p>'); ?></td>
              </tr>
             <tr>
                <td width="182"   align="right" class="bluetxt" >Landline No</td>
                <td align="left" width="321"><input name="landline" type="text" class="textbox" value="<?php echo set_value('landline'); ?>"><?php echo form_error('landline', '<p class="error">', '</p>'); ?></td>
              </tr>
             <tr>
                <td width="182"   align="right" class="bluetxt" >Address&nbsp;</td>
                <td align="left" width="321"><input name="address" type="text" class="textbox" value="<?php echo set_value('address'); ?>" size="50"><?php echo form_error('address', '<p class="error">', '</p>'); ?></td>
              </tr>       
             <tr>
                <td width="182"   align="right" class="bluetxt" >City <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="city" type="text" class="textbox" value="<?php echo set_value('city'); ?>"><?php echo form_error('city', '<p class="error">', '</p>'); ?></td>
              </tr>
             <tr>
              <tr>
                <td width="182"   align="right" class="bluetxt" >Pincode <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="pincode" type="text" class="textbox" value="<?php echo set_value('pincode'); ?>"><?php echo form_error('pincode', '<p class="error">', '</p>'); ?></td>
              </tr>
             
             <tr style="display: none;" id="type_row">
                <td width="182"   align="right" class="bluetxt" > Select User Type <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><label for="select"></label>
                  <select name="type" id="type">
                  <option value="">Select</option>
                  <?php
                  $types = array(
					USER_TYPE_INSTITUTIONAL => 'Institutional',
                  );
foreach($types as $K=>$V){
	echo '<option value="'.$K.'"'.set_select('type', $K).'>'.$V.'</option>';
}
                  ?>
                  </select><?php echo form_error('type', '<p class="error">', '</p>'); ?></td>
              </tr>
              <tr style="display: none;" id="user_count_row">
                <td width="182"   align="right" class="bluetxt" >Estimate No of Test Takers <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="user_count" type="text" class="textbox" value="<?php echo set_value('user_count'); ?>"><?php echo form_error('user_count', '<p class="error">', '</p>'); ?></td>
              </tr>
              <!--
             <tr style="display: none;" id="test_type_id_row">
                <td width="182"   align="right" class="bluetxt" >Select Test Type <font color="#FF0000">*</font>&nbsp;</td>
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
                <td width="182"   align="right" class="bluetxt" >Select Test Sector <font color="#FF0000">*</font>&nbsp;</td>
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
			-->	
             <tr>
                <td width="182"   align="right" class="bluetxt" >How did you know us <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><label for="select"></label>
                  <select name="how" id="select">
                  <option value="">Select</option>
                  <option value="newspaper" <?php echo set_select('how', 'newspaper'); ?>>Newspaper</option>
                  <option value="referral" <?php echo set_select('how', 'referral'); ?>>Referall</option>
                  <option value="internet search" <?php echo set_select('how', 'internet search'); ?>>Internet Search</option>
                  <option value="others" <?php echo set_select('how', 'others'); ?>>Others</option>
                  </select>
                   <?php echo form_error('how', '<p class="error">', '</p>'); ?>
                  </td>
              </tr>  
              <tr>
                <td align="center" colspan="2"><input disabled="disabled" id="submit-btn" type="submit" value=" Submit " name="Submit" STYLE="font-size:10pt;  color:#000000" >
                  <input disabled="disabled" id="cancel-btn" type="reset" value="Cancel" name="Cancel" STYLE="font-size:10pt;  color:#000000" ></td>
              </tr>
          </table> 
           
          
          </td>
          </tr>
          </table>
		</form>
		<?php } else { echo $s_register; } ?>	

               
			</div>
            <br>
            <br>
            <br></td>
            <td width="250" valign="top"><br>
              
              
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
	inputTestType = jQuery("#test_type_id");
	inputSector = jQuery("#sector_id");
	
	jQuery("#type").on("change", function(){
		var t = jQuery(this);
		if( t.val()=="<?php echo USER_TYPE_INSTITUTIONAL ?>" ){
			jQuery("#user_count_row").show();

			jQuery("#test_type_id_row").hide();
			jQuery("#sector_id_row").hide();
		}
		else{
			jQuery("#user_count_row").hide();

			jQuery("#test_type_id_row").show();
			jQuery("#sector_id_row").show();
		}
	});
	jQuery("#type").trigger("change");
	jQuery("#type_row").show();

	jQuery("#submit-btn").removeAttr("disabled");
	jQuery("#cancel-btn").removeAttr("disabled");
});
//-->
</script>