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
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/edit_gk/<?php echo $gk_details['gk_id'];?>" method="post">
                    
                    <input type="hidden" name="gk_id" value="<?php echo $gk_details['gk_id'];?>" />
                     <p>
                        	<label>Question </label>
                            
                            <span class="field"><textarea cols="80" rows="4" name="title" class="meduiminput"><?php echo set_value('title', $gk_details['question']); ?></textarea></span> 
                       
                        </p>
                    	
                     <p>
                        	<label>Answer</label>
                            <span class="field"><textarea cols="80" rows="4" name="desc" class="meduiminput"><?php echo set_value('desc', $gk_details['answer']); ?></textarea></span> 
                        </p>

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Update GK" name="update_gk" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>