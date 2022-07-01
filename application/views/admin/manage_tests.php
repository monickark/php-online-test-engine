<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	//delete individual row
	jQuery('a.deletepassage').live("click", function() {
		var pp = jQuery(this);
		var msg = jQuery(this).html();
		var pid = jQuery(this).attr('id');
		var c = confirm('Are you sure?');
		var domain = "<?php echo base_url();?>";
		if(c) {			

			  var str="featured=1&id="+pid
			jQuery.ajax({
				type: "POST",
				url: domain+"admin/delete_passage",
				data: str,
				cache: false,
				success: function(html){
					pp.parents('tr').fadeOut(function(){ 
						pp.remove();
				});
					jAlert('Passage Deleted Successfully', 'Notification Dialog');
				}
			});
		}
		return false;
	});
});	
</script>
<?php
$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone); ?>
<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Goto Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                
                 <p style="float:right; clear:both"> <a href="<?php echo base_url();?>admin/add_test/" class="stdbtn btn_black">Add Test</a></p>
                    
                                   <div class="contenttitle radiusbottom0">
                	<h2 class="table"><span><?php echo $title;?></span></h2>
                </div><!--contenttitle-->
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                       <tr>
                              <th class="head1">No</th>
                             <th class="head1">Test Name</th>
                              <th class="head1">Test Time</th>
                                <th class="head1">Batch</th>
                               <th class="head1">Start Time</th>
                            <th class="head0">End Time</th>
                            <th class="head1">Total Qns</th>
                             <th class="head0">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                               <th class="head1">No</th>
                             <th class="head1">Test Name</th>
                              <th class="head1">Test Time</th>
                                <th class="head1">Batch</th>
                               <th class="head1">Start Time</th>
                            <th class="head0">End Time</th>
                            <th class="head1">Total Qns</th>
                             <th class="head0">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i=1; foreach($all_tests as $val) { ?>
                        <tr class="gradeA" id="<?php echo $val['tid'];?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $val['test_name']; ?></td>
                            <td><?php echo $val['test_time']; ?> mins</td>
                             <td><?php echo $val['batch_name'];?></td>
                             <td><?php echo date('d-M-Y h:i A',$val['start_time']);?></td>
                            <td><?php echo date('d-M-Y h:i A',$val['end_time']);?></td>
                            <td><?php echo $val['tot_qns']; ?></td>
                            <td><a href="<?php echo base_url();?>admin/edit_test/<?php echo $val['tid'];?>">Edit</a></td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
                     <br clear="all" />

  
                </div><!--content-->
                
            </div>