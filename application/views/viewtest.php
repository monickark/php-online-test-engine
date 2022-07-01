<style>
.onecol-style { font-family:Arial, Helvetica, sans-serif; font-size:12px; min-width:480px; text-align:left; border-collapse:collapse; margin-bottom:25px; margin-left:20px;}
.onecol-style th {font-size:14px; font-weight:normal; color:#666666; padding:12px 15px;}
.onecol-style td {color:#333; border-top:1px solid #ccc; padding:10px 15px;}
.onecol-first {background:#fafafa; border-right:10px solid transparent; border-left:10px solid transparent;}
.onecol-style tr:hover td {color:#444; background:#eee;}
a.btncss {
  width: 100px;
  padding: 5px 10px 5px 10px;
  font-family: Arial;
  font-size: 15px;
  text-decoration: none;
  color: #ffffff;
  text-shadow: -1px -1px 2px #618926;
  background: -moz-linear-gradient(#98ba40, #a6c250 35%, #618926);
  background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #98ba40),color-stop(.35, #a6c250),color-stop(1, #618926));
  border: 1px solid #618926;
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  margin-top:30px;
  margin-bottom:50px;
}

a.btncss:hover {
  text-shadow: -1px -1px 2px #465f97;
  background: -moz-linear-gradient(#245192, #1e3b73 75%, #12295d);
  background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #245192),color-stop(.75, #1e3b73),color-stop(1, #12295d));
  border: 1px solid #0f2557;
}
img { border:0; }
</style>
	<script src="<?php echo base_url();?>js/jquery-1.6.1.min.js" type="text/javascript"></script>

		<link rel="stylesheet" href="<?php echo base_url();?>css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<script src="<?php echo base_url();?>js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	$(document).ready(function(){
	$("a[rel^='prettyPhoto']").prettyPhoto({
			keyboard_shortcuts: false,
			showTitle: false,
			social_tools: false
		});
	});
	</script>
<?php
$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone); ?>
        <table width="1002" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top"><br> 
	<h2 style="margin-left:20px;"><?=$test['title']?> 
	<div style="float:right" >
	<?php echo anchor('home/online_test',img('images/back.gif'));?> &nbsp;<a href="javascript:print();"><?php echo img('images/print.png');?></a>
	</div>
	</h2>

	
	
	<table class="onecol-style" width="90%">
    <colgroup>
		                    <col class="onecol-first">
                        </colgroup>
	<tr><td valign=top >Test Name</td><td width="20px"></td><td><?php
	echo $test['title'];
	?></td></tr>
	<tr><td>Test Type</td><td width="20px"></td><td><?php
	$query = $this->db->query('SELECT * FROM `test_type` WHERE `pid` = "'.$test['test_type_id'].'"');
	$info = $query->row_array();
	if( $info!=false ){
		echo $info['title'];
	}
	?></td></tr>
	<tr><td>Sector</td><td width="20px"></td><td><?php
	$query = $this->db->query('SELECT * FROM `sector` WHERE `pid` = "'.$test['sector_id'].'"');
	$info = $query->row_array();
	if( $info!=false ){
		echo $info['title'];
	}
	?></td></tr>
	<tr><td>No. of Questions</td><td width="20px"></td><td><?php
	echo $question;
	?></td></tr>
	<tr><td>Time Duration</td><td width="20px"></td><td><?php
	echo $minutes;
	?> Minutes</td></tr>	
	</table>
	

<div id="inline-1" class="hide" style="display:none">
		
        <h2 style="margin:0; padding:0;">Instructions</h2>
        <ol>
<li>Total questions will be shown on the right side of the screen.</li>
<li>Each question will have specific time to answer. Time left will show the remaining time of that particular question only.</li>
<li>To un-select the answer, click Clear Answer link.</li>
<li>On clicking Save & Next button, it will move to next question.</li>
<li>The test will come to a close automatically after completing the all questions. Do not close or click back button on the browser.</li>

</ol>
<p style="text-align:center"><a href="<?php echo base_url();?>attemptTest/index/<?php echo $test['pid']; ?>" id="menu"><img src="<?php echo base_url();?>images/proceed.jpg" /></a> <a href="javascript:$.prettyPhoto.close();">Cancel</a></p>
</div>

<?php
if( isset($info_test_attempt['pid']) ){
	echo 'You have exceeded the number of attempts!';
}
else{
?>
<table width="90%"><tr>
<td align="right"><div style="margin-bottom:50px;">
<a href="#inline-1" rel="prettyPhoto" ><img src="<?php echo base_url();?>images/start_test.jpg" border="0" /></a>
</div></td></tr></table>
<?php
}
if(isset($msg) && $msg!=""){ echo $msg;}
?>
	
    </td>
            
            
            <td width="250" align="center" valign="top">
            <?php include_once("sidebar_msg.php"); ?>
        </td>
         <td width="1" bgcolor="#F3F3F3"></td>
        </tr>
        </table>  