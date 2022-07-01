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
<script type="text/javascript" src="<?php echo base_url(); ?>js/fusion.charts/src.js"></script>

<br />
<div align="center">    <span class="link">Section I </span><br />         
 <table width="650" border="1" cellspacing="2" cellpadding="4" class="content">
  <tr>
    <td colspan="2" align="center" bgcolor="#538ed5"><span class="titlewhite1">A-ONE ASSESSMENT - TECHNICAL ASSESSMENT REPORT</span></td>
    </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#538ed5"><span class="titlewhite1">Impetus TechKnows®</span></td>
    </tr>
  <tr>
    <td colspan="2">
    <div align="center"><span class="subtitledblue">Mr / Ms. <?php echo $udetails['name']; ?> <br />


<br /><br />
<span class="subtitlered1">
	<?php
      $query = $this->db->query('SELECT `test_type_id` FROM `test` WHERE `pid` = "'.$result['test_id'].'"');
      $info = $query->row_array();
      if( $info!=false ){
      	$query = $this->db->query('SELECT `title` FROM `test_type` WHERE `pid` = "'.$info['test_type_id'].'"');
      	$info = $query->row_array();
      	if( $info!=false ){
      		echo $info['title'];
      	}
      }
      ?>
      </span>
</div>
    
    </td>
  </tr>
  <tr>
    <td width="605" bgcolor="#1f497d" class="textwhite2">KEY SKILL &amp; BEHAVIOURAL ATTRIBUTES</td>
    <td width="137" align="center" bgcolor="#1f497d" class="textwhite2">RATING</td>
  </tr>


	<?php
	
	$colorsHex = array(

		'd81d4a',

		'666666',

		'CCCCCC',

	);

	shuffle($colorsHex);
	
	if( $marks ){
		$score = 0;
		$count = 0;
		$list = array();
		foreach($marks as $K=>$V){
			
			$sql = '
SELECT
`section_sub_id`,
(
	(
		( SUM( CASE `is_right` WHEN 1 THEN `mark` ELSE 0 END ) / COUNT(`gr_id`) )
		+
		( SUM( CASE `is_right` WHEN -1 THEN `mark` ELSE 0 END ) / COUNT(`gr_id`) )
	) / 10
) * 100 as score
FROM `gen_result` WHERE `result_id` = '.$V['result_id'].' AND `section_id` = '.$V['section_id'].' GROUP BY `section_sub_id`
			';

			$query = $this->result_model->db->query($sql);

			$sectionMarks = $query->result_array();
			
			$scoreTotal = 0;
			$scoreCount = 0;
			
			if( isset($sectionMarks[0]) ){
				foreach($sectionMarks as $K1=>$V1){
					$scoreTotal += $V1['score'];
					$scoreCount++;
				}
			}
			
			$scoreAvg = $scoreTotal/$scoreCount;

			$score += $scoreAvg;

			$count++;

	?>
	<tr>
		<td bgcolor="#ffffff"><?php
		$query = $this->db->query('SELECT * FROM `section` WHERE `pid` = "'.$V['section_id'].'"');

		$info = $query->row_array();

		if( $info!=false ){

			echo $info['title'];
			
			$list[] = '<set name="'.$info['title'].'" value="'.$V['score'].'" />';

		}
		?></td>
		<td bgcolor="#1f497d" class="textwhite2"><?php echo number_format($scoreAvg, 2); ?></td>
	</tr>
	<?php
		}
		?>
        <tr>
        <td>&nbsp;</td>
        <td></td>
        </tr>
        
	<tr>
		<td bgcolor="#1f497d" class="textwhite2">SOFTSKILLS AVERAGE</td>
		<td><a href="<?php echo base_url();?>attemptTest/careerPointerSection/<?php echo $result['result_id']; ?>"><?php echo $score/$count; ?></a></td>
	</tr>
		<?php
	}
	?>  

        <tr>
        <td height="15">&nbsp;</td>
        <td></td>
        </tr>
 
 <tr bgcolor="#ffc000">
 <td><b>Evaluation</b></td>
 <td><b>Rating Bandwidth</b></td>
 </tr>

 <tr>
 <td>Generic Skills Training Indicated</td>
 <td>>4</td>
 </tr>

 <tr>
 <td>Good Employability Levels Indicated</td>
 <td>5 to7</td>
 </tr>
 
 <tr>
 <td>Excellent Employability Levels Indicated</td>
 <td>8 to 10</td>
 </tr>

 
 <tr>
 <td>&nbsp;</td>
 <td></td>
 </tr>
 
 <tr>
 <td colspan="2"><div align="center">Thank you for taking the Technical Assessment! <br>
   Your TAR (Technical Assessment Report) is valid for a period of 6 Months<br />You may wish to re-assess after a period of 6 Months for continuous assessments <br /><br /><br /><br /><br />


<span class="h1">A-ONE® is a registered Assessment Engine developed by Impetus TechKnows®<br>All Rights Reserved.  © Impetus TechKNows® 2011-12<br />Visit us at www.impetustechknows.com</span></div></td>

 </tr>
 
 </table>
 </div>
<br />

<!--
<?php
if( isset($list[0]) ){
?>


<div id="analytic-graph-01"></div>
<script type="text/javascript">
$(function(){
	var
	chType="Pie2D",
	w=400,
	h=400,
	xml = <?php
	echo json_encode(array('

				<graph caption="RATING" xAxisName="Month" yAxisName="Visits" showValues="1"

					numberPrefix="" bgcolor="FFFFFF" bgAlpha="70" showColumnShadow="1"

					divlinecolor="c5c5c5" divLineAlpha="60" showAlternateHGridColor="1" alternateHGridColor="f8f8f8"

					alternateHGridAlpha="60" showLegend="1"

				>

					'.implode(' ', $list).'

				</graph>

	'));
	?>;
	$("#analytic-graph-01").insertFusionCharts({
		swfPath: "<?php echo base_url(); ?>js/fusion.charts/swf/",
		id: "chart1",
		type: chType,
		width: w, height: h,
		data: xml[0],
		dataFormat: "XMLData",
		wMode: "transparent"
	});
});
</script>
<?php
}
?>
-->
	
