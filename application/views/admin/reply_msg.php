<div class="maincontentinner">
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span><?php echo $title;?></span></h2>
                    </div><!--contenttitle-->
                    
                    <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p>Message Sent Sucessfully</p></div>
			<?php } ?>
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/reply/<?php echo $msg['msg_id'];?>" method="post">
                    
                        <input type="hidden" value="<?php echo $msg['msg_id'];?>" name="msg_id" />
                        
                         <p>
                        	<label>From :</label>
                            <span><?php echo $msg['member_name'];?></span>
                        </p>
                         <p>
                        	<label>Subject :</label>
                            <span><?php echo $msg['subject'];?></span>
                        </p>
                        
                          <p>
                        	<label>Message : </label>
                            <span><?php echo $msg['msg'];?></span>
                        </p>
                        
                        <?php if(!empty($msg['reply'])) { ?>
                        
                          <p>
                        	<label>Prev Replies : </label>
                            <?php $oo=1; foreach($msg['reply'] as $val) { ?>
                            <span><?php echo $oo; ?>.&nbsp;<?php echo $val['msg']; ?></span> <br />
                            <?php $oo++; } ?>
                            </p>
                        <?php } ?>
                            <p>
                        	<label>Reply :</label>
                            <span class="field"><textarea name="reply" cols="100" rows="6"><?php echo set_value('reply'); ?></textarea> </span>
                        </p>
                  

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Send Reply" name="reply_msg" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>