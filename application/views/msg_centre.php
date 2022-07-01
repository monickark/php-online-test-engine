<?php
$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
?>
        <table width="1002" border="0" cellspacing="0" cellpadding="0">
        <tr>
        
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top">
            
                 <?php if(!empty($success)) { ?>
<div style="margin:10px;"><center><font color="#009900" size="3"><b><?php echo $success; ?></b></font></center></div>
		<?php } ?>
            
            <div align="center">           

             <span class="advt">Message Centre</span>
              <br>
            
  			</div>
  	
            <table width="700" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
            <td>
            
            <table width="700" cellspacing="4" cellpadding="4" border="0" class="table" bgcolor="#FFFFFF">

             <tr>
                <td>
              
                 <form action="<?php echo base_url();?>home/message_centre" method="post">
                 <table width="700" cellspacing="4" cellpadding="4" class="table">
             <!--    <tr>
                 <td>Subject : </td><td><input type="text" name="subject" style="width:424px;" class="textbox"  value="" /><?php //echo form_error('subject', '<p class="error">', '</p>'); ?></td>
                 </tr>-->
                 <tr>
                 <td>Message : </td><td><textarea name="message" rows="5" cols="50"><?php echo set_value('message'); ?></textarea><?php echo form_error('message', '<p class="error">', '</p>'); ?></td>
                 </tr>
                  <tr>
                 <td colspan="2" align="center"><input type="submit" value="Send" name="msg_sup" /></td>
                 </tr>
                 </table>
                 </form>
                   
                
                </td>
              </tr>
             </table>  
                </td>
              </tr>
             </table>
              <br>
              <div style="margin:20px;">
            <?php if(!empty($msgs)) { ?>
            <h3>Messages</h3>
            <table width="700" class="table">
           <tr>
              <td colspan="2" height="1" bgcolor="#999999"></td>
            </tr>             
            <?php foreach($msgs as $val) { ?>
            
            <tr>
            <td width="563">
            	<!--<p> Subject : <?php //echo $val['subject']; ?></p>-->
            	<p> <?php echo ucwords($_SESSION['edu_name']);?> : <?php echo $val['msg']; ?></p>
              </td>
            <td width="125"><?php echo date('dS  M, Y h:i a', $val['date']); ?></td>
            <?php if(!empty($val['reply'])) { ?>
            <tr style="background:#fafafa; padding-left:100px;">
            <td colspan="2">
            <h5 style="text-align:center">Admin Replies</h5>
            <?php foreach($val['reply'] as $vall) { ?>
            <p style="text-align:right"><?php echo $vall['msg'];?> - <?php echo date('dS  M, Y h:i a', $vall['date']); ?></p>
            <?php } ?>
            </td>
            </tr>
            <?php } ?>
           <tr>
              <td colspan="2" height="1" bgcolor="#999999"></td>
            </tr>   
              <?php } ?>
             
			           
              
            </table>
      
            <?php } ?>
             </div>
                          
            </td>
            <td width="250" align="center" valign="top">
            
            <?php include_once("sidebar_msg.php"); ?>
        
        </td>
        
        <td width="1" bgcolor="#F3F3F3"></td>
        </tr>
        </table>  