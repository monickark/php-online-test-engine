            <div class="maincontentinner">

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
                        	<label>Test Type</label>
                            <span class="field">
                            <select name="test_type_id" class="test_type_id">
                                <option value="">Select</option>
                                <?php
                                if( isset($all_test_type) ){
                                foreach($all_test_type as $val){
								?>
                                <option value="<?php echo $val['pid'];?>" <?php echo set_select('test_type_id', $val['pid'], isset($details['test_type_id']) && $details['test_type_id']==$val['pid']); ?>><?php echo $val['title'];?></option>
                             	<?php
								}
								}
								?>
                            </select>
                            </span>
                        </p>
                        
                        <p>
                        	<label>Name</label>
                            <span class="field"><input type="text" name="p_name" value="<?php echo isset($details['title']) ? set_value('p_name', $details['title']) : ''; ?>" class="mediuminput" /></span>
                        </p>


                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="<?php
                             echo $form_type=='add' ? 'Add' : 'Update';
                             ?>" name="save_form" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>