<div class="maincontentinner">

                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span><?php echo $title;?></span></h2>
                    </div><!--contenttitle-->
                    
                    <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p>Updated Sucessfully</p></div>
			<?php } ?>
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/edit_subject/<?php echo $details['sub_id'];?>" method="post">
                    <input type="hidden" value="<?php echo $details['sub_id'];?>" name="sub_id" />
                     <p>
                        	<label>Select Batch</label>
                            <span class="field">
                            <select name="batch_id">
                                <option value="">Select</option>
                                <?php foreach($all_batch as $val) { if($val['batch_id'] == $details['batch_id']) { $chk = TRUE; } else { $chk = FALSE; } ?>
                                <option value="<?php echo $val['batch_id'];?>" <?php echo set_select('batch_id', $details['batch_id'], $chk); ?>><?php echo $val['batch_name'];?></option>
                             <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                        
                         <p>
                        	<label>Subject Name</label>
                            <span class="field"><input type="text" name="title" value="<?php echo set_value('subject', $details['subject']); ?>" class="mediuminput" /></span>
                        </p>
                  

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Update Subject" name="edit_sub" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>