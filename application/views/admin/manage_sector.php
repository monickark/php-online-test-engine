<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	//delete individual row
	jQuery('a.deletesector').live("click", function() {
		var pp = jQuery(this);
		var msg = jQuery(this).html();
		var pid = jQuery(this).attr('id');
		var c = confirm('Are you sure?');
		var domain = "<?php echo base_url();?>";
		if(c) {			

			  var str="featured=1&id="+pid
			jQuery.ajax({
				type: "POST",
				url: domain+"admin/delete_sector",
				data: str,
				cache: false,
				success: function(html){
					pp.parents('tr').fadeOut(function(){ 
						pp.remove();
				});
					jAlert('Vertical Deleted Successfully', 'Notification Dialog');
				}
			});
		}
		return false;
	});
});	
</script>
<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Goto Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                
                 <p style="float:right; clear:both"> <a href="<?php echo base_url();?>admin/add_sector/" class="stdbtn btn_black">Add Test Vertical</a></p>
                    
				<div class="contenttitle radiusbottom0">
                	<h2 class="table"><span><?php echo $title;?></span></h2>
                </div><!--contenttitle-->
                
                <?php if( isset($success) && $success!='' ) { ?>
					<div class="notification msgsuccess"> <a class="close"></a><p><?php echo $success; ?></p></div>
				<?php } ?>
                <?php if( isset($error) && $error!='' ) { ?>
					<div class="notification msgerror"> <a class="close"></a><p><?php echo $error; ?></p></div>
				<?php } ?>
                
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
                            <th class="head1">Test Vertical Name</th>
                            <th class="head1">Test Type</th>
                            <th class="head0">Date Added</th>
                            <th class="head1">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="head1">No</th>
                            <th class="head1">Test Vertical Name</th>
                            <th class="head0">Date Added</th>
                            <th class="head1">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i=$Page_No+1; foreach($all_subject as $val) { ?>
                        <tr class="gradeA" id="<?php echo $val['pid'];?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $val['title']; ?></td>
                            <td><?php
                            $infoSector = $this->admin_model->get_test_type_details($val['test_type_id']);
                            if( $infoSector!=false ){
                            	echo $infoSector['title'];
                            }
                            ?></td>
                            <td><?php echo $val['date'];?></td>
                            <td><a href="<?php echo base_url();?>admin/edit_sector/<?php echo $val['pid'];?>">Edit</a> | <a href="javascript:;" id="<?php echo $val['pid'];?>" class="deletesector">Delete</a></td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
                     <br clear="all" />
                <div style="float:right">
                   <ul class="pagination">
                    <?php echo $this->pagination->create_links(); ?>
                    </ul>
                  </div>
  
                </div><!--content-->
                
            </div>