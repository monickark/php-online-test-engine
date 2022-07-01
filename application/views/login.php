<table width="1002" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top"><br>
            
                <div align="center"><font class="titlegrey1"><br>
                Login Form</font>
                <br>
                  <br>
             <form action="<?php echo base_url();?>login" method="post" name="login">
            <table width="550" cellspacing="1" cellpadding="0" border="0" bgcolor="#CCCCCC">
            <tr>
            <td>
            
            <table width="550" cellspacing="4" cellpadding="4" border="0" class="table1" bgcolor="#FFFFFF">

             <tr>
                <td width="182"   align="right" class="bluetxt" >Email <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="email" type="text" class="textbox" value="<?php echo set_value('email'); ?>" size="40"><?php echo form_error('email', '<p class="error">', '</p>'); ?></td>
              </tr>
              <tr>
                <td width="182"   align="right" class="bluetxt" >Password <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="password" type="password" class="textbox" value="" size="40"><?php echo form_error('password', '<p class="error">', '</p>'); ?></td>
              </tr>

              <tr>
                <td align="center" colspan="2"><input type="submit" value=" Submit " name="Submit" STYLE="font-size:10pt;  color:#000000" >
                  <input type="reset" value="Cancel" name="Cancel" STYLE="font-size:10pt;  color:#000000" ></td>
              </tr>
          </table>  
          
          
          </td>
          </tr>
          </table>
         </form>
            <br>
            <span class="content"><a href="<?php echo base_url();?>forgot_password">Forgot Password</a></span></div>
            <br>
            <br>
            <br></td>
            <td width="250" valign="top"><br></td>
            <td width="1" bgcolor="#F3F3F3"></td>
          </tr>
          <tr>
            <td bgcolor="#F3F3F3"></td>
            <td valign="top">&nbsp;</td>
            <td align="center" valign="top">&nbsp;</td>
            <td bgcolor="#F3F3F3"></td>
          </tr>
        </table>