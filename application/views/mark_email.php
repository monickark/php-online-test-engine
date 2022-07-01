<?php
  function sec2hmst ($sec, $padHours = false) 
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
<p>Please check your result</p>
<table class="onecol-style" width="90%">

  <tr >
    <td bgcolor="#eeeeee" width="331">Test Name</td>
    <td width="332" bgcolor="#eeeeee" ><?=$result['test_name']?></td>
  </tr>
  <!--<tr>
    <td bgcolor="#ffffff">Correct Answers / Total Questions</td>
    <td bgcolor="#ffffff"><?php //$correcto=str_replace("2","0",$result['correct_answer']); $correcto=str_replace("-1","0",$correcto); $correcto=explode(",",$correcto); echo array_sum($correcto); ?>
      /
      <?php //echo $result['total_question']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#ffffff">Time Taken / Time Duration (H:M:S)</td>
    <td bgcolor="#ffffff"><?php //$time_taken=explode(",",$result['time_taken']); echo sec2hmst(array_sum($time_taken)); ?>
      / <?php //echo sec2hmst(($result['test_time'])*60);?></td>
  </tr>-->
  <tr>
    <td bgcolor="#ffffff" colspan="2" height="1"></td>
  </tr>
</table>
<br />
<table class="onecol-style" width="90%">
<tr >
    <td bgcolor="#eeeeee" width="331">Subject</td>
    <td width="332" bgcolor="#eeeeee" >Mark Scored</td>
  </tr>
  
  <?php foreach($marks as $val) { ?>
  <tr>
    <td bgcolor="#ffffff"><?php echo ucfirst($val['subject']);?></td>
    <td bgcolor="#ffffff">
      <?php echo $val['marks'];?> / <?php echo $val['tot_sub_qns']; ?></td>
  </tr>
   <?php } ?>
  <tr>
    <td bgcolor="#eeeeee">Total</td>
    <td bgcolor="#eeeeee"><?php echo $my_score; ?> / <?=$result['total_question']?></td>
  </tr>
</table>
<p>With best regards,<br />
Bankexamonlinemocktest.com</p>