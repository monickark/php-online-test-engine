<script src="<?php echo base_url();?>js/jquery-1.6.1.min.js" type="text/javascript"></script>
<!--script src="js/jquery.lint.js" type="text/javascript" charset="utf-8"></script-->
<link rel="stylesheet" href="<?php echo base_url();?>css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?php echo base_url();?>js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

<script language="javascript">
$(document).ready(function(){
	$("a[rel^='prettyPhoto']").prettyPhoto({
			keyboard_shortcuts: false,
			showTitle: false,
			social_tools: false
	});
	$("#ucheck").click(function(){ 
        $('input[name="answer"][type="radio"]:checked').each(function(){ 
        	$(this).attr("checked", false); 
    	}); 
    });
});					   
var c = null
var time = null;
function startTime() {
	//if(getCookie('timeLeft')){
	//document.getElementById('timer').innerHTML=getCookie('timeLeft');
	//}

	timerDisplay = document.getElementById('timer');

	if((timerDisplay.innerHTML)=="0.00"){
		time=getCookie('timeLeft').replace(':','.');
		time = parseFloat(time);
	}
	else{
		time = parseFloat(timerDisplay.innerHTML.replace(':','.'));
	}

	timerDisplay.innerHTML = time.toFixed(2).replace('.', ':');

	var c=setInterval(countdown, 1000);
}
function countdown() {
	if(time > 0.01) {
		time -= 0.01;
		if(time%1 > 0.59) time = Math.floor(time) + 0.59;
		timerDisplay.innerHTML = time.toFixed(2).replace('.', ':');
		//setCookie('timeLeft',time.toFixed(2).replace('.', ':'),'1');
	}
	else{
		clearInterval(c);
		timerDisplay.innerHTML = "0:00";
		alert("Time Over!\n Press Ok to Submit");
		document.getElementById('submitTest').value='0';
		document.getElementById('testForm').submit(); 
		return;
	}
}
</script>
<style>
#qoption{
		background-color:#ffffff;
		font: 15px/20px normal Helvetica, Arial, sans-serif;
		color: #222222;
		margin: 5px 0px 5px 0px;
		font-weight:bold;
	}
#qoption:hover{
		background-color:#eeeeee;
		font: 15px/20px normal Helvetica, Arial, sans-serif;
		color: #222222;
		margin: 5px 0px 5px 0px;
		}
#timer { font-weight:bold; display:inline; }
p.qn, p.qn p{ font-weight:bold; color:#F00; font-size:13px; }
a.btncss {
  padding: 10px 12px 10px 12px;
  margin-top:-20px;
  font-family: Arial;
  font-size: 14px;
  text-decoration: none;
  color: #ffffff;
  text-shadow: -1px -1px 2px #618926;
  background: -moz-linear-gradient(#98ba40, #a6c250 35%, #618926);
  background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #98ba40),color-stop(.35, #a6c250),color-stop(1, #618926));
  border: 1px solid #618926;
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  margin:0;
}

a.btncss:hover {
  text-shadow: -1px -1px 2px #465f97;
  background: -moz-linear-gradient(#245192, #1e3b73 75%, #12295d);
  background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #245192),color-stop(.75, #1e3b73),color-stop(1, #12295d));
  border: 1px solid #0f2557;
}
img { border:0; }
</style>
</head>
<body onLoad="startTime();">
<?php 
// getting minutes
$minutes = str_pad(intval( ($question_time_avail * 60) / 60 ), 2, '0', STR_PAD_LEFT);
//getting seconds
$seconds = str_pad(intval( ($question_time_avail * 60) % 60 ), 2, '0', STR_PAD_LEFT);
?>

<table width="1002" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="2"></td>
	<td width="998" height="2"></td>
	<td width="2"></td>
</tr>

<tr>
	<td width="2"></td>
	<td width="998" height="35" bgcolor="#f1f1f1">
    
    	<table width="990" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td width="270" class="subtitle2"><font color="#d43e85">ONLINE TEST</font></td>
        <td width="720" class="subtitlered2" align="right">
		</td>
        </tr>
        </table>
    
	</td>
	<td width="2"></td>
</tr>

<tr>
	<td bgcolor="#d43e85" width="2"></td>
	<td bgcolor="#d43e85" width="998" height="2"></td>
	<td bgcolor="#d43e85" width="2"></td>
</tr>

<tr>
	<td width="2"></td>
	<td width="998" height="35" bgcolor="#f1f1f1">
    
    	<table width="990" border="0" align="center" cellpadding="0" cellspacing="0">
	        <tr>
		        <td width="270" class="subtitle2">
		        <font color="#d43e85"><?php
		        $query = $this->db->query('SELECT * FROM `test_type` WHERE `pid` = "'.$test['test_type_id'].'"');
		        $info = $query->row_array();
                if( $info!=false ){
                	echo $info['title'];
                }
                ?></font>
		        </td>
		        <td width="270" class="subtitle2">
		        <font color="#d43e85"><?php
		        $query = $this->db->query('SELECT * FROM `sector` WHERE `pid` = "'.$sector_id.'"');
		        $info = $query->row_array();
                if( $info!=false ){
                	echo $info['title'];
                }
                ?></font>
		        </td>
		        <td width="270" class="subtitle2">
		        <font color="#d43e85"><?php
		        $query = $this->db->query('SELECT * FROM `section` WHERE `pid` = "'.$section_id.'"');
		        $info = $query->row_array();
                if( $info!=false ){
                	echo $info['title'];
                }
                ?></font>
		        </td>
		        <td width="270" class="subtitle2">
		        <font color="#d43e85"><?php
		        $query = $this->db->query('SELECT * FROM `section_sub` WHERE `pid` = "'.$section_sub_id.'"');
		        $info = $query->row_array();
                if( $info!=false ){
                	echo $info['title'];
                }
                ?></font>
		        </td>
	        </tr>
        </table>
    
	</td>
	<td width="2"></td>
</tr>

<tr>
	<td bgcolor="#d43e85" width="2"></td>
	<td bgcolor="#d43e85" width="998" height="2"></td>
	<td bgcolor="#d43e85" width="2"></td>
</tr>

<tr>
	<td bgcolor="#d43e85" width="2"></td>
	<td width="998">
    
        <table width="990" border="0" align="center" cellpadding="0" cellspacing="0" class="subtitle">
	        <tr>
		        <td width="332" height="30" align="left">
		        	<font color="#d43e85">NAME:</font><?php echo $test['title']; ?>
		        </td>
		        <td width="332" align="center">
		        	<font color="#d43e85">TIME LEFT:</font> <div id="timer"><?php echo $minutes.":".$seconds; ?></div>
		        </td>
		        <td width="326" align="right">
		        	<font color="#d43e85">TOTAL QUESTIONS:</font><?php echo $question_total; ?>
		        </td>
	        </tr>
	        <tr>
	        	<td colspan="5" bgcolor="#d43e85" height="2"></td>
	        </tr>
        </table>
        <br />
        
    	<table width="990" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td width="960" valign="top" class="content1">
<?php
$attributes=array('id'=>'testForm');
echo form_open('attemptTest/getquestion/',$attributes);

//$totq				= explode(",",$test['random_question_no']);
$totq				= $question_total;
$totalQuestions		= $question_total;
$selected_answers	= explode(',', $result['selected_answers']);
$selected_answers	= $selected_answers[$qno-1];
?>
	<input type="hidden" name="qno" value="<?php echo $qno; ?>" id="qno">
	<input type="hidden" name="direction" value="N" id="direction">
    <input type="hidden" name="uqid" value="<?php echo $uqid; ?>">
	<input type="hidden" name="submitTest" value="0" id="submitTest">
	<input type="hidden" name="time1" value="" >
	<div style="height:300px; overflow:auto">
		<table>
			<tr>
				<td valign="top">
				</td>
				<td valign="top" style="font-weight:bold; color:#F00; font-size:13px; margin:0; padding:0;">
					<p class="qn">Q<?php echo $qno; ?>:</p> <p class="qn"><?php echo $question['question']; ?></p>
				</td>
			</tr>
		</table>
		<?php
		$option1 = $question['option_1'];
		$option2 = $question['option_2'];
		$option3 = $question['option_3'];
		$option4 = $question['option_4'];
		?>
		<div id="qoption">
			<table>
				<tr>
				<td style="width:18px;" valign=top >
					<input type="radio" value="1" name="answer" <?php if($selected_answers==1){ echo "checked";} ?> />
				</td>
				<td class="content1">
					<?php echo $option1; ?>
				</td>
				</tr>
			</table>
	 	</div>
	 	<div id="qoption">
			<table>
				<tr>
					<td style="width:18px;" valign=top >
						<input type="radio" value="2" name="answer" <?php if($selected_answers==2){ echo "checked";} ?> />
					</td>
					<td class="content1">
						<?php echo $option2; ?>
					</td>
				</tr>
			</table>
	 	</div>
	 	<div id="qoption">
			<table>
				<tr>
					<td style="width:18px;" valign=top >
						<input type="radio" value="3" name="answer" <?php if($selected_answers==3){ echo "checked";} ?>  >
					</td>
					<td class="content1">
						<?php echo $option3; ?>
					</td>
				</tr>
			</table>
	 	</div>
		<div id="qoption">
			<table>
				<tr>
					<td style="width:18px;" valign=top >
						<input type="radio" value="4" name="answer" <?php if($selected_answers==4){ echo "checked";} ?>  >
					</td>
					<td class="content1">
						<?php echo $option4; ?>
					</td>
				</tr>
			</table>
	 	</div>

		<a href="javascript:;" id="ucheck" style="margin-left:10px;">Clear Answer</a>

	</div>
        
        </td>
        </tr>
        </table>        

    	<table width="990" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td width="260" align="center">
        </td>
        <td width="260" align="center">
        </td>
        <td width="470" align="right" valign="top" style="vertical-align:top">
        
		<a href="javascript:document.getElementById('testForm').submit();" id="menu"><img src="<?php echo base_url();?>images/next.jpg"></a>
		
        </td>
        </tr>
        </table>
    	<br/>
        <br/>
	</td>
	<td bgcolor="#d43e85" width="2"></td>
</tr>


<tr>
	<td bgcolor="#d43e85" width="2"></td>
	<td bgcolor="#d43e85" width="998" height="2"></td>
	<td bgcolor="#d43e85" width="2"></td>
</tr>
</table> 