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
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/msg_to_all" method="post">
                    	
                        <p>
                        <label>Send Message to All:</label>
                      <span class="field"> <textarea  name="msg" cols="100" rows="6"><?php if(!empty($msg_to_all)) { echo $msg_to_all; } ?></textarea> </span>
                      </p>

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Update Message" name="msgall" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>