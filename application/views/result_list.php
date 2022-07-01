<?php



  function sec2hms ($sec, $padHours = false) 

  {



    // start with a blank string

    $hms = "";

    

    // do the hours first: there are 3600 seconds in an hour, so if we divide

    // the total number of seconds by 3600 and throw away the remainder, we're

    // left with the number of hours in those seconds

    $hours = intval(intval($sec) / 3600); 



    // add hours to $hms (with a leading 0 if asked for)

    $hms .= ($padHours) 

          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"

          : $hours. ":";

    

    // dividing the total seconds by 60 will give us the number of minutes

    // in total, but we're interested in *minutes past the hour* and to get

    // this, we have to divide by 60 again and then use the remainder

    $minutes = intval(($sec / 60) % 60); 



    // add minutes to $hms (with a leading 0 if needed)

    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";



    // seconds past the minute are found by dividing the total number of seconds

    // by 60 and using the remainder

    $seconds = intval($sec % 60); 



    // add seconds to $hms (with a leading 0 if needed)

    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);



    // done!

    return $hms;

    

  }



?>

<style>

.onecol-style { font-family:Arial, Helvetica, sans-serif; font-size:12px; min-width:480px; text-align:left; border-collapse:collapse; margin-bottom:25px; margin-left:20px;}

.onecol-style th {font-size:14px; font-weight:normal; color:#666666; padding:12px 15px;}

.onecol-style td {color:#333; border-top:1px solid #ccc; padding:2px 4px;}

.onecol-first {background:#fafafa; border-right:10px solid transparent; border-left:10px solid transparent;}

.onecol-style tr:hover td {color:#444; background:#eee;}

a.btncss {

  width: 100px;

  padding: 10px 15px 10px 15px;

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

  margin-bottom:50px;

}



a.btncss:hover {

  text-shadow: -1px -1px 2px #465f97;

  background: -moz-linear-gradient(#245192, #1e3b73 75%, #12295d);

  background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #245192),color-stop(.75, #1e3b73),color-stop(1, #12295d));

  border: 1px solid #0f2557;

}

</style>



        <table width="1002" border="0" cellspacing="0" cellpadding="0">

        <tr>

            <td width="1" bgcolor="#F3F3F3"></td>

            <td width="1000" valign="top"><br> 

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="subtitledblue1">Result</span>

  <div style="float:right" > <a href="javascript:print();"><?php echo img('images/print.png');?></a> <!--<?php //echo anchor('result/',img('images/back.gif'));?> &nbsp;-->  </div>



<br /><br />

<table width="980" border="0" class="onecol-style" align="center">

	<tr>

		<td bgcolor="#eeeeee" width="79">Date</td>

		<?php

		if( $_SESSION['edu_type']==USER_TYPE_INSTITUTIONAL ){

			$showStudentName = 1;

		?>

		<td bgcolor="#eeeeee" width="108">Name</td>

		<td bgcolor="#eeeeee" width="61"> ID</td>

		<?php

		}

		?>

		<td bgcolor="#eeeeee" width="190">Test Type</td>

		<td bgcolor="#eeeeee" width="185">Test Name</td>

		<td bgcolor="#eeeeee" width="83">Mark Scored</td>

		<td bgcolor="#eeeeee" width="44">Result</td>

		<td bgcolor="#eeeeee" width="63">Certificate</td>

		<td bgcolor="#eeeeee" width="89">Career Pointer</td>

	</tr>

	<?php

	if( $results ){

		foreach($results as $K=>$V){

			$result = $this->result_model->get_result($V['result_id'], '0');



			$score = $this->result_model->get_score($V['result_id'], $V['uid']);

	?>

	<tr>

		<td bgcolor="#ffffff"><?php echo date('j M, Y', $result['iniTime']); ?></td>

		<?php

		if( isset($showStudentName) ){

			$udetails = $this->admin_model->get_member_details($result['uid']);

		?>

		<td bgcolor="#ffffff"><?php echo $udetails['name']; ?></td>

		<td bgcolor="#ffffff"><?php echo $udetails['candidate_id']; ?></td>

		<?php	

		}

		?>

		<td bgcolor="#ffffff"><?php

		$query = $this->db->query('SELECT `test_type_id` FROM `test` WHERE `pid` = "'.$V['test_id'].'"');

		$info = $query->row_array();

		if( $info!=false ){

			$query = $this->db->query('SELECT `title` FROM `test_type` WHERE `pid` = "'.$info['test_type_id'].'"');

			$info = $query->row_array();

			if( $info!=false ){

				echo $info['title'];

			}

		}

		?></td>

		<td bgcolor="#ffffff"><?php echo $result['title']; ?></td>

		<td bgcolor="#ffffff"><?php echo $score; ?></td>

		<td align="center" bgcolor="#ffffff"><a href="<?php echo base_url();?>attemptTest/resultView/<?php echo $result['result_id']; ?>">View</a></td>

		<td align="center" bgcolor="#ffffff">
        <a href="<?php echo base_url();?>attemptTest/certificate/<?php echo $result['result_id']; ?>" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=1200,height=600,toolbar=1,resizable=0'); return false;">View</a>
        </td>

        <td align="center" bgcolor="#ffffff">
        <a href="<?php echo base_url();?>attemptTest/careerPointer/<?php echo $result['result_id']; ?>">Sec 1</a> | 
        <a href="<?php echo base_url();?>attemptTest/careerPointerSection/<?php echo $result['result_id']; ?>">Sec 2</a>
		</td>


	</tr>

	<?php

		}

	}

	?>

</table>

	

    </td>



         <td width="1" bgcolor="#F3F3F3"></td>

        </tr>

        </table>  