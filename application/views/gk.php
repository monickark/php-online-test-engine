        <table width="1002" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top"><br>        


        	<div align="center">
             <span class="subtitledblue1">GK SECTION</span>
              <br>
              <br>  
              
              <?php
              if($alert_message) {
				if( $_SESSION['edu_type']==USER_TYPE_USER ){
			  ?>
              <div style="color:#F00; font-size:15px">Contact your institution</div>
              <?php
				}
				else{
			  ?>
              <div style="color:#F00; font-size:15px">Our records indicate that you have not paid the fees yet. Please pay the fees either by ONLINE or RTGS/NEFT and mail the transaction details to <a href="mailto:accounts@impetustechknows.in">accounts@impetustechknows.in</a></div>
              <?php
				}
			  }
			  ?>
              
  <?php if(!empty($all_gk)) { ?>
  			</div>
            <table width="700" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
            <td>
            
            <table width="700" cellspacing="4" cellpadding="4" border="0" bgcolor="#FFFFFF">

             <tr>
                <td>
              
                    <table class="content1">
                    <?php foreach($all_gk as $val) { ?>
                    <tr>
                    <td valign="top"><img src="<?php echo base_url();?>assets/images/arrow_s.jpg" width="10" height="10" vspace="3"></td>
                    <td>
                    
                    <font color="#F000000">Q: <?php echo $val['question']; ?> </font><br>A: <?php echo $val['answer']; ?><br><br>
                    </td>
                    </tr>                          
                    <?php }  ?>
                    </table>
                   
                
                </td>
              </tr>
             </table>  
                </td>
              </tr>
             </table>
              <br>
             <div align="center">
             <span class="subtitle"> <?php echo $this->pagination->create_links(); ?></span><br>
             <?php } ?>
             </div>
             <br><br>
                          
            </td>
           
            <td width="250" align="center" valign="top">
           <?php include_once("sidebar_msg.php"); ?><br /><br />
        </td>
        <td width="1" bgcolor="#F3F3F3"></td>
        
        </tr>
        </table> 
 