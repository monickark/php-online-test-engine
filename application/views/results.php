<style>
.onecol-style { font-family:Arial, Helvetica, sans-serif; font-size:12px; min-width:480px; text-align:left; border-collapse:collapse; margin-bottom:25px; margin-left:20px;}
.onecol-style th {font-size:14px; font-weight:normal; color:#666666; padding:12px 15px;}
.onecol-style td {color:#333; border-top:1px solid #ccc; padding:10px 15px;}
.onecol-first {background:#fafafa; border-right:10px solid transparent; border-left:10px solid transparent;}
.onecol-style tr:hover td {color:#444; background:#eee;}
</style>

        <table width="1002" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="1" bgcolor="#F3F3F3"></td>
            <td width="750" valign="top"><br> 
            <h3 style="margin-left:20px;">Results</h3>
	<?php if(($this->session->userdata('su'))=='1'){ ?>
<input type="text" id="searchr" value="" onkeydown="if(event.keyCode==13){return searchresult();}"> <a href="javascript:searchresult();"><?php echo img(array('src'=>'images/search.jpg','width'=>'20','height'=>'20','title'=>'Search'));?></a>
<?php } ?>
	
<table class="onecol-style" width="90%">
	<tr id="Theading" >
	<th id="Theading"> ID </th>
	<th id="Theading"> Test Name</th>
	<th id="Theading"> Obtained % </th>
	<th id="Theading"> Status </th>
	<th id="Theading"> View </th>
	<?php if(($this->session->userdata('su'))=='1'){ ?>
	<th id="Theading"> Delete </th>
	<?php } ?>
	</tr>
	<?php foreach($result as $result){ ?>
	<tr id="Tvalues">
	<td > <?=$result['result_id']?> </td>
	<td > <?=$result['test_name']?> </td>
	<td ><center> <?=$result['obtained_percentage']?> % </center></td>
	<td > <?php if($result['status']==1){ echo "Pass"; }else{ echo "Fail";}  ?> </td>
	<td ><center><?php echo anchor('result/view/'.$result['result_id'],img(array('src'=>'images/view.png','title'=>'View')));?> </center></td>
	<?php if(($this->session->userdata('su'))=='1'){ ?>
	<td ><center><a href="javascript:delr('<?php echo $result['result_id']?>');"><?php echo img('images/delete.png');?></a></center></td>
	<?php } ?>
	</tr>
	<?php } ?>
	</table>
	
	
	
    </td>
            
            
            <td width="250" align="center" valign="top">
            <?php include_once("sidebar_msg.php"); ?>
        </td>
         <td width="1" bgcolor="#F3F3F3"></td>
        </tr>
        </table>  