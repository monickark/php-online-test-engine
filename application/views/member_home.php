        <!-- central panel starts --> 
        <?php if(!empty($success)) { ?>
<div style="margin:10px;"><center><font color="#009900" size="3"><b><?php echo $success; ?></b></font></center></div>
		<?php } ?>
        <table width="1002" border="0" cellspacing="0" cellpadding="0">
        <tr>
             <td width="500" align="center" valign="top"><br>
             <span class="advt">LATEST GK</span>
              <br>
              <br>  

            <table width="700" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
            <tr>
            <td>
            
            <table width="700" cellspacing="4" cellpadding="4" border="0" class="table" bgcolor="#FFFFFF">

             <tr>
                <td>
               <marquee behavior="scroll" scrollamount="2" direction="up" onmouseover="this.stop();" onmouseout="this.start();">
                    <?php echo $gk; ?>
                </marquee>
                </td>
              </tr>
             </table>  
                </td>
              </tr>
             </table>
             <br><br>
                          
             </td>
            <td width="250" align="center" valign="top"><br>
          <?php include_once("sidebar_msg.php"); ?>
        
        </td>
        </tr>
        </table>        
        <!-- center panel ends --> 