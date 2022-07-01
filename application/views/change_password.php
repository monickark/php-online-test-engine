<table width="1002" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top"><br>
            
                <div align="center"><font class="titlegrey1"><br>
                Change Password</font>
                <br>
                  <br>
             <form action="<?php echo base_url();?>home/change_password" method="post" name="login">
            <table width="550" cellspacing="1" cellpadding="0" border="0" bgcolor="#CCCCCC">
            <tr>
            <td>
            
            <table width="550" cellspacing="4" cellpadding="4" border="0" class="table1" bgcolor="#FFFFFF">

             <tr>
                <td width="182"   align="right" class="bluetxt" >Old Password <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="old_pass" type="password" class="textbox" size="40"><?php echo form_error('old_pass', '<p class="error">', '</p>'); ?></td>
              </tr>
              <tr>
                <td width="182"   align="right" class="bluetxt" >New Password <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="new_pass" type="password" class="textbox" value="" size="20"><?php echo form_error('new_pass', '<p class="error">', '</p>'); ?></td>
              </tr>
              <tr>
                <td width="182"   align="right" class="bluetxt" >Confirm New Password <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="new_pass_confirm" type="password" class="textbox" value="" size="20"><?php echo form_error('new_pass_confirm', '<p class="error">', '</p>'); ?></td>
              </tr>

              <tr>
                <td align="center" colspan="2"><input type="submit" value="Update Password" name="c_pass" STYLE="font-size:10pt;  color:#000000" ></td>
              </tr>
          </table>  
          
          
          </td>
          </tr>
          </table>
         </form>
            <br>
          </div>
            <br>
            <br></td>
            <td width="250" align="center" valign="top"><br>
              <?php include_once("sidebar_msg.php"); ?>
              
              </td>
            <td width="1" bgcolor="#F3F3F3"></td>
          </tr>
          <tr>
            <td bgcolor="#F3F3F3"></td>
            <td valign="top">&nbsp;</td>
            <td align="center" valign="top">&nbsp;</td>
            <td bgcolor="#F3F3F3"></td>
          </tr>
        </table>