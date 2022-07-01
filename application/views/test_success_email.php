<p><img src="<?php echo base_url(); ?>assets/images/logo.jpg"></p>

<p>Dear <?php echo $result['name']; ?></p>



<p>Please check your result</p>

<table class="onecol-style" width="90%">



  <tr >

    <td bgcolor="#eeeeee" width="331">Test Name</td>

    <td width="332" bgcolor="#eeeeee" ><?php echo $result['title']; ?></td>

  </tr>

  <tr>

    <td bgcolor="#ffffff" colspan="2" height="1"></td>

  </tr>

</table>

<br />

<table class="onecol-style" width="90%">

  <tr>

    <td bgcolor="#eeeeee">Total</td>

    <td bgcolor="#eeeeee"><?php echo $score; ?> / <?php echo $result['total_question']; ?></td>

  </tr>

</table>





<style>

.content { font-family: Verdana; font-size: 12px; color: #000000; border-collapse:collapse; border:1px solid #CCC; line-height: 18px; display:block;}

.onecol-style { font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:left; border-collapse:collapse; margin-bottom:25px;}

.onecol-style th {font-size:14px; font-weight:normal; color:#666666; padding:12px 15px;}

.onecol-style td {color:#333; border:1px solid #ccc; padding:10px 15px;}

.onecol-first {background:#fafafa; border-right:10px solid transparent; border-left:10px solid transparent;}

.onecol-style tr:hover td {color:#444; background:#ggg;}

#question{

		background-color:#ffffff;

		font: 15px/20px normal Helvetica, Arial, sans-serif;

		color: #222222;

		margin: 5px 0px 5px 0px;

	}

#question:hover{

		background-color:#eeeeee;

		font: 15px/20px normal Helvetica, Arial, sans-serif;

		color: #222222;

		margin: 5px 0px 5px 0px;

		}

p.correct { background:#060; color:#CCC; padding:2px; }

</style>





<div id="container">



	<h1> Your Marks	</h1>



	<div id="body">





	<?php

	$qno				= 1;

	$section_ids		= explode(",", $result['section_id']);

	$selected_answers	= explode(",", $result['selected_answers']);

	$correct_answers	= explode(",", $result['correct_answer']);



	$ans_arr = array(0,1,2,3);

	?>

    <table width="100%" border="1" class="onecol-style">

	    <tr bgcolor="#eeeeee">

		    <td width="20%"><b>Section</b></td>

		    <td width="20%"><b>Sub Section</b></td>

		    <td width="5%"><b>Q No</b></td>

		    <td width="32%"><b>Question</b></td>

		    <td width="7%"><b>Option 1</b></td>

		    <td width="7%"><b>Option 2</b></td>

		    <td width="7%"><b>Option 3</b></td>

		    <td width="7%"><b>Option 4</b></td>

		    <td width="5%"><b>By Candidate</b></td>

		    <td width="2%"><b>Result</b></td>

		    <td width="8%"><b>Marks Scored</b></td>

	    </tr>

    <?php 

    foreach($marks as $K=>$V){

	?>

	<tr>

	<td width="20%"><?php

	$query = $this->db->query('SELECT * FROM `section` WHERE `pid` = "'.$V['section_id'].'"');

	$info = $query->row_array();

	if( $info!=false ){

		echo $info['title'];

	}

	?></td>
    

	<td width="20%"><?php

	$query = $this->db->query('SELECT * FROM `section_sub` WHERE `pid` = "'.$V['section_sub_id'].'"');

	$info = $query->row_array();

	if( $info!=false ){

		echo $info['title'];

	}

	?></td>

	<td bgcolor="#ffffff"><?php echo $K+1; ?></td>

	<td bgcolor="#ffffff"><?php

	$query = $this->db->query('SELECT * FROM `questions` WHERE `pid` = "'.$V['qid'].'"');

	$info = $query->row_array();

	if( $info!=false ){

		echo $info['question'];

	}

	?></td>

	<td bgcolor="#ffffff"><?php

	if( $info!=false ){

		echo $info['option_1'];

	}

	?></td>

	<td bgcolor="#ffffff"><?php

	if( $info!=false ){

		echo $info['option_2'];

	}

	?></td>

	<td bgcolor="#ffffff"><?php

	if( $info!=false ){

		echo $info['option_3'];

	}

	?></td>

	<td bgcolor="#ffffff"><?php

	if( $info!=false ){

		echo $info['option_4'];

	}

	?></td>

	<td bgcolor="#ffffff"><?php

	if( $V['s_ans']>0 ){

		echo $V['s_ans'];

	}

	?></td>

	<td bgcolor="#ffffff"><?php

	if( $V['is_right']==1 ){

		echo img('images/tick.png', array('title'=>'Correct'));

	}

	elseif( $V['is_right']==-1 ){

		echo img('images/delete.png', array('title'=>'Correct'));

	}

	else{

		echo 'Not Attended';

	}

	?></td>

	<td bgcolor="#ffffff"><?php echo $V['mark']; ?></td>

	<?php

	}

	?>

</tr>

<tr bgcolor="#eeeeee">

<td colspan="11" align="right">

<div align="right"><b>Total Mark Scored = <?php echo $score; ?></b></div>

</tr>

</table>

<p>With best regards,<br />impetustechknows.in</p>