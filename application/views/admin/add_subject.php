<div class="maincontentinner">

                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span><?php echo $title;?></span></h2>
                    </div><!--contenttitle-->
                    
                    <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p>Added Sucessfully</p></div>
			<?php } ?>
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/add_subject" method="post">
                    
                     <p>
                        	<label>Select Batch</label>
                            <span class="field">
                            <select name="batch_id">
                                <option value="">Select</option>
                                <?php foreach($all_batch as $val) { ?>
                                <option value="<?php echo $val['batch_id'];?>" <?php echo set_select('batch_id', $val['batch_id']); ?>><?php echo $val['batch_name'];?></option>
                             <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                        
                         <p>
                        	<label>Subject Name</label>
                            <span class="field"><input type="text" name="title" value="<?php echo set_value('subject'); ?>" class="mediuminput" /></span>
                        </p>
                  

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Add Subject" name="add_sub" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>