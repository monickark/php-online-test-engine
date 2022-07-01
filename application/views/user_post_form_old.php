

<table width="1002" border="0" cellspacing="0" cellpadding="0">

        <tr>

            <td width="1" bgcolor="#F3F3F3"></td>

            <td width="1000" valign="top"><br> 
<div align="center">

	<span class="subtitledblue1">Manage Users | <a href="<?php echo base_url();?>user/listing">Cancel</a></span>

</div>
<br />


<table width="700" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">

            <tr>

            <td>

            

            <table width="700" cellspacing="4" cellpadding="4" border="0" class="table" bgcolor="#FFFFFF">



             <tr>

                <td>

              

                 <form id="kl" class="stdform" action="<?php echo $form_url; ?>" method="post">

                 

                 <table width="700" cellspacing="4" cellpadding="4" class="table">

	                 <tr>

	                 	<td width="182"   align="right" class="bluetxt" >Name <font color="#FF0000">*</font>&nbsp;</td>

	                 	<td>

	                 		<input name="name" value="<?php echo isset($details['name']) ? set_value('name', $details['name']) : ''; ?>" />

	                 		<?php echo form_error('name', '<p class="error">', '</p>'); ?>

	                 	</td>

	                 </tr>

	                 <!--
                     <tr>

	                 	<td width="182"   align="right" class="bluetxt" >Email <font color="#FF0000">*</font>&nbsp;</td>

	                 	<td>

	                 		<input name="email" value="<?php echo isset($details['email']) ? set_value('email', $details['email']) : ''; ?>" />

	                 		<?php echo form_error('email', '<p class="error">', '</p>'); ?>

	                 	</td>

	                 </tr>
					 -->
	                 <tr>

	                 	<td width="182" align="right" class="bluetxt" >Candidate ID</td>

	                 	<td>

	                 		<input name="candidate_id" value="<?php echo isset($details['candidate_id']) ? set_value('candidate_id', $details['candidate_id']) : ''; ?>" />

	                 		<?php echo form_error('candidate_id', '<p class="error">', '</p>'); ?>

	                 	</td>

	                 </tr>

	                 

	                 <tr style="display: none;" id="test_type_id_row">

		                <td width="182"   align="right" class="bluetxt" >Select Test Type <font color="#FF0000">*</font>&nbsp;</td>

		                <td align="left" width="321">

		                  <select name="test_type_id" id="test_type_id" onchange="onTestType()">

		                  	<option value="">Select</option>

		                    <?php

		                    $query = $this->home_model->db->query('SELECT * FROM `test_type` ORDER BY `pid` DESC');

		                    $all_test_type = $query->result_array();

		                    foreach($all_test_type as $K=>$V){

		                    	echo '<option value="'.$V['pid'].'"'.set_select('test_type_id', $V['pid'], isset($details['test_type_id']) && $details['test_type_id']==$V['pid']).'>'.$V['title'].'</option>';

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

		                    $query = $this->home_model->db->query('SELECT * FROM `sector` WHERE test_type_id="'.( isset($_POST['test_type_id']) ? $_POST['test_type_id'] : ( isset($details['test_type_id']) ? $details['test_type_id'] : '' ) ).'" ORDER BY `pid` DESC');

		                    $all_sector = $query->result_array();

		                    foreach($all_sector as $K=>$V){

		                    	echo '<option value="'.$V['pid'].'"'.set_select('sector_id', $V['pid'], isset($details['sector_id']) && $details['sector_id']==$V['pid']).'>'.$V['title'].'</option>';

		                    }

		                    ?>                

		                  </select>

		                  <?php echo form_error('sector_id', '<p class="error">', '</p>'); ?>

		                </td>

		              </tr>

	                 

	                  <tr>

	                 <td colspan="2" align="center">

	                 <input type="submit" value="<?php echo $form_type=='add' ? 'Add' : 'Update'; ?>" name="save_form" />

	                 </td>

	                 </tr>

                 </table>

                 

                 </form>

                   

                

                </td>

              </tr>

             </table>  

                </td>

              </tr>

             </table>

	

    </td>


         <td width="1" bgcolor="#F3F3F3"></td>

        </tr>

        </table>

   <br />     

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

	

	jQuery("#test_type_id_row").show();

	jQuery("#sector_id_row").show();

});

//-->

</script>