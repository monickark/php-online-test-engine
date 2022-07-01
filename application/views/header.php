 <style>
 p.error { color:#F00; padding:0; margin:0; font-size:10px; }
 </style>
    	<table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><br /><img src="<?php echo base_url();?>assets/images/AONE_Logo.png">  <!--img src="assets/images/Web Greet.jpg"--><br /></td>
          </tr>
        </table>
        <?php $head_array = array('attemptTest', 'reviewTest', 'unansTest', 'all_results'); if((!empty($template)) && (!in_array($template, $head_array))) { ?>
        <table width="1002" height="43" border="0" cellspacing="0" cellpadding="0" bgcolor="#4380fb">
          <tr>
            <td width="8">&nbsp;</td>
            <td width="500" class="tablewhitebold"><a href="<?php echo base_url();?>" class="tablewhitebold">HOME</a> &nbsp;&nbsp;/&nbsp;&nbsp; <a href="<?php echo base_url();?>fee_details" class="tablewhitebold">FEE DETAILS</a> &nbsp;&nbsp;/&nbsp;&nbsp; <a href="<?php echo base_url();?>faq" class="tablewhitebold">FAQ</a> &nbsp;&nbsp; </td>
            <td width="30">&nbsp;</td>
            <?php if(empty($_SESSION['edu_uid'])) { ?>
            <td width="58" class="navigation">New User?</td>
            <td width="89" align="center"><a href="<?php echo base_url();?>register"><img src="<?php echo base_url();?>assets/images/register_button.jpg" width="78" height="23" border="0"></a></td>
            <td width="70" align="center"><a href="<?php echo base_url();?>login"><img src="<?php echo base_url();?>assets/images/signin_button.jpg" width="63" height="23" border="0"></a></td>
            <?php } else { ?>
              <td class="navigation" colspan="2" align="right"><font size="2" color="#FFFFFF">Welcome <?php echo ucfirst($_SESSION['edu_name']); ?>!</font>&nbsp;&nbsp;<a href="<?php echo base_url();?>home" style="color:#fff; font-size:12px;">My Home</a></td>
            <td align="center"><a href="<?php echo base_url();?>home/change_password" style="color:#FFFFFF; font-size:12px;">Change Password</a> | <a href="<?php echo base_url();?>logout" style="color:#FFFFFF; font-size:12px;">Logout</a></td>
            
            <?php } ?>
            <td width="11">&nbsp;</td>
          </tr>
        </table>
        <?php } ?>
        
        <?php $ban_arry = array('index', 'contact', 'why', 'fee', 'faq', 'about'); if(empty($_SESSION['edu_uid']) || in_array($template,$ban_arry)) { ?>
        <?php } ?>