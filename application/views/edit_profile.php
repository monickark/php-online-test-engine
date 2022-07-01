<table width="1002" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top"><br>
            
              <?php if(!empty($success)) { ?>
<div style="margin:10px;"><center><font color="#009900" size="3"><b><?php echo $success; ?></b></font></center></div>
		<?php } ?>
            
                <div align="center"><font class="titlegrey1"><br>
                Edit Member Profile</font>
                <br>
                  <br>
                 
            <table width="550" cellspacing="1" cellpadding="0" border="0" bgcolor="#CCCCCC">
            <tr>
            <td>
            <form name="register" action="<?php echo base_url();?>home/edit_profile" method="post">
            <table width="550" cellspacing="4" cellpadding="4" border="0" class="table1" bgcolor="#FFFFFF">

             <tr>
                <td width="182"   align="right" class="bluetxt" >Member Name <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="name" type="text" class="textbox" value="<?php echo set_value('name', $udetails['name']); ?>" size="40"> <?php echo form_error('name', '<p class="error">', '</p>'); ?></td>
              </tr>
              <tr>
                <td width="182"   align="right" class="bluetxt" >Email <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="email" type="text" class="textbox" value="<?php echo set_value('email', $udetails['email']); ?>" size="40"><?php echo form_error('email', '<p class="error">', '</p>'); ?></td>
              </tr>
             <tr>
                <td width="182"   align="right" class="bluetxt" >Mobile No <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="mobile" type="text" class="textbox" value="<?php echo set_value('mobile', $udetails['mob_no']); ?>"><?php echo form_error('mobile', '<p class="error">', '</p>'); ?></td>
              </tr>
             <tr>
                <td width="182"   align="right" class="bluetxt" >Landline No</td>
                <td align="left" width="321"><input name="landline" type="text" class="textbox" value="<?php echo set_value('landline', $udetails['landline']); ?>"><?php echo form_error('landline', '<p class="error">', '</p>'); ?></td>
              </tr>
             <tr>
                <td width="182"   align="right" class="bluetxt" >Address&nbsp;</td>
                <td align="left" width="321"><input name="address" type="text" class="textbox" value="<?php echo set_value('address', $udetails['address']); ?>" size="50"><?php echo form_error('address', '<p class="error">', '</p>'); ?></td>
              </tr>       
             <tr>
                <td width="182"   align="right" class="bluetxt" >City <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="city" type="text" class="textbox" value="<?php echo set_value('city', $udetails['city']); ?>"><?php echo form_error('city', '<p class="error">', '</p>'); ?></td>
              </tr>
             <tr>
              <tr>
                <td width="182"   align="right" class="bluetxt" >Pincode <font color="#FF0000">*</font>&nbsp;</td>
                <td align="left" width="321"><input name="pincode" type="text" class="textbox" value="<?php echo set_value('pincode', $udetails['pincode']); ?>"><?php echo form_error('pincode', '<p class="error">', '</p>'); ?></td>
              </tr>
              <tr>
                <td align="center" colspan="2"><input type="submit" value="Update Profile" name="e_profile" STYLE="font-size:10pt;  color:#000000" >
                 </td>
              </tr>
          </table> 
          </form> 
          </td>
          </tr>
          </table>
               
			</div>
            <br>
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