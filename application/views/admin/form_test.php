            <div class="maincontentinner">
<script type="text/javascript">
btnSubmit = null;
inputTestType = null;
inputSector = null;

elTestTypeClass = "elTestTypeClass";
elSectorClass = "elSectorClass";
elSectionClass = "elSectionClass";

elForm = null;

function block(){
	elForm.block({ message: null });
	submitBtn.attr("disabled", "disabled").hide();
}
function unBlock(){
	elForm.unblock();
	submitBtn.removeAttr("disabled").show();
}

function onTestType(){
	var v = inputTestType.val();
	elForm.find("p."+elSectorClass).remove();
	elForm.find("p."+elSectionClass).remove();

	if( v!="" ){
		block();
		jQuery.ajax({
			url		: "<?php echo base_url();?>select/test_form_sector",
			type	: "POST",
			data	: {
				'id' : v,
			},
			error	: function(xhr, textStatus, errorThrown){
				unBlock();
			},
			success	: function(data){
				unBlock();
				if( jQuery.trim(data)!='' ){
					elForm.find("p."+elTestTypeClass).after(
						jQuery("<p>").addClass( elSectorClass ).html(
							jQuery("<label>").html("Sector").after(
								jQuery("<span>").addClass("field").html( data )
							)
						)
					);
					inputSector = jQuery("#sector_id");
				}
			}
		});
		
	}
	else{
		
	}
}

function onSector(){
	var v = inputSector.val();
	elForm.find("p."+elSectionClass).remove();

	if( v!="" ){
		block();
		jQuery.ajax({
			url		: "<?php echo base_url();?>select/test_form_section",
			type	: "POST",
			data	: {
				'id' : v,
				'pid' : '<?php echo isset($details['pid']) ? $details['pid'] : '0'; ?>'
			},
			error	: function(xhr, textStatus, errorThrown){
				unBlock();
			},
			success	: function(data){
				unBlock();
				if( jQuery.trim(data)!='' ){
					elForm.find("p."+elSectorClass).after(
						data
					);
				}
			}
		});
		
	}
	else{
		
	}
}

jQuery(function(){
	submitBtn = jQuery("#btn_save_form");
	inputTestType = jQuery("#test_type_id");
	inputSector = jQuery("#sector_id");
	elForm = jQuery("div.content form#kl");

	inputTestType.removeAttr("disabled");
	inputSector.removeAttr("disabled");
	
	submitBtn.removeAttr("disabled").show();
});
</script>
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span><?php echo $title;?></span></h2>
                    </div><!--contenttitle-->
                    
                    <?php if( isset($success) && $success!='' ) { ?>
					<div class="notification msgsuccess"> <a class="close"></a><p><?php echo $success; ?></p></div>
					<?php } ?>
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo $form_url; ?>" method="post">
                    
                    	<?php
                    	if( isset($details['pid']) ){
                    	?>
                    	<input type="hidden" name="pid" value="<?php echo $details['pid']; ?>" />
                    	<?php
                    	}
                    	?>
                        
                        <p>
                        	<label>Name</label>
                            <span class="field"><input type="text" name="title" value="<?php echo isset($details['title']) ? form_prep($details['title'], 'title') : ''; ?>" class="mediuminput" /></span>
                        </p>
                    	
                    	<p class="elTestTypeClass">
                        	<label>Test Type</label>
                            <span class="field">
                            <select name="test_type_id" id="test_type_id" class="test_type_id" disabled="disabled" onchange="onTestType(this)">
                                <option value="">Select</option>
                                <?php
                                $all_test_type = $this->admin_model->all_test_type();
                                foreach($all_test_type as $val){
								?>
                                <option value="<?php echo $val['pid'];?>"<?php echo isset($details['test_type_id']) && $details['test_type_id']==$val['pid'] ? ' selected="selected"' : ''; ?>><?php echo $val['title'];?></option>
                             	<?php
								}
								?>
                            </select>
                            </span>
                        </p>
                        
                        <?php
                        if( isset($details['test_type_id']) && $details['test_type_id']!='' ){
                        ?>
                        <p class="elSectorClass">
                        	<label>Sector</label>
                        	<span class="field">
	                        	<select onchange="onSector(this)" class="sector_id" disabled="disabled" id="sector_id" name="sector_id">
	                        		<option value="">Select</option>
	                        		<?php
	                                $query = $this->admin_model->db->query('SELECT * FROM `sector` WHERE test_type_id='.$details['test_type_id']);
	                                $all_sector = $query->result_array();
	                                foreach($all_sector as $val){
									?>
	                                <option value="<?php echo $val['pid'];?>"<?php echo isset($details['sector_id']) && $details['sector_id']==$val['pid'] ? ' selected="selected"' : ''; ?>><?php echo $val['title'];?></option>
	                             	<?php
									}
									?>
	                        	</select>
                        	</span>
                        </p>
                        <?php
                        }
                        ?>
                        
                        <?php
                        if( isset($details['test_type_id']) && isset($details['sector_id']) ){
							if( isset($details['values']) ){

								foreach($details['values'] as $K=>$V){
									
									$query = $this->admin_model->db->query('SELECT * FROM `section` WHERE pid='.$K);
									$info_section = $query->row_array();
                        ?>
                        <div class="elSectionClass">
							<label><?php if( isset($info_section['pid']) ){ echo $info_section['title']; } ?></label>
							<div class="field">
							
								<table cellpadding="0" border="0" style="width: 600px" class="stdtable">
										
									<thead>
		                       			<tr>
											<th style="width: 150px;" colspan="1" rowspan="1" class="head1">&nbsp;</th>
											<th style="width: 100px;" colspan="1" rowspan="1" class="head1">Set Question</th>
											<th style="width: 100px;" colspan="1" rowspan="1" class="head1">Set Minutes</th>
											<th style="width: 100px;" colspan="1" rowspan="1" class="head1">Set RA Mark</th>
											<th style="width: 100px;" colspan="1" rowspan="1" class="head1">Set WA Mark</th>
										</tr>
	                    			</thead>
										
										
									<tbody>
									<?php
									foreach($V as $K1=>$V1){

										$query = $this->admin_model->db->query('SELECT * FROM `section_sub` WHERE pid='.$K1);
										$info_section_sub = $query->row_array();
									?>
										<tr class="gradeA <?php echo $K1%2==0 ? 'even' : 'odd'; ?>">
											<td><?php if( isset($info_section_sub['pid']) ){ echo $info_section_sub['title']; } ?></td>
											<td>
												<input type="text" name="<?php echo 'values['.$K.']['.$K1.'][q]'; ?>" class="mediuminput" value="<?php
												echo form_prep(isset($V1['q']) ? $V1['q'] : '', 'values['.$K.']['.$K1.'][q]');
												?>">
											</td>
											<td>
												<input type="text" name="<?php echo 'values['.$K.']['.$K1.'][m]'; ?>" class="mediuminput" value="<?php
												echo form_prep(isset($V1['m']) ? $V1['m'] : '', 'values['.$K.']['.$K1.'][m]');
												?>">
											</td>
											<td>
												<input type="text" name="<?php echo 'values['.$K.']['.$K1.'][ra]'; ?>" class="mediuminput" value="<?php
												echo form_prep(isset($V1['ra']) ? $V1['ra'] : '', 'values['.$K.']['.$K1.'][ra]');
												?>">
											</td>
											<td>
												<input type="text" name="<?php echo 'values['.$K.']['.$K1.'][wa]'; ?>" class="mediuminput" value="<?php
												echo form_prep(isset($V1['wa']) ? $V1['wa'] : '', 'values['.$K.']['.$K1.'][wa]');
												?>">
											</td>
										</tr>
									<?php
									}
									?>
									</tbody>
								</table>
									
							</div>
						</div>
                        <?php
                        		}
                        	}
                        }
                        ?>

                        <p class="stdformbutton">
                             <input style="display: none;" id="btn_save_form" disabled="disabled" type="submit" class="stdbtn btn_black" value="<?php
                             echo $form_type=='add' ? 'Add' : 'Update';
                             ?>" name="save_form" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>