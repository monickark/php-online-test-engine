<script>
function closef()
{
	window.parent.$.prettyPhoto.close();
}
</script>
<?php if(!empty($success)) { ?>
<div style="margin:10px;"><center><font color="#009900" size="3"><b><?php echo $success; ?></b></font></center></div>

<script type="text/javascript">
window.parent.$.prettyPhoto.close();
</script>
		<?php } ?>
<form action="<?php echo base_url();?>home/msg_centre_ajx" method="post">
                 <table width="90%" cellspacing="4" cellpadding="4" class="table">
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
<center> <a href="#" onclick="closef();">Close</a></center>