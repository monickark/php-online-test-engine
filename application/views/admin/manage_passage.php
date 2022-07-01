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
<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Goto Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                
                 <p style="float:right; clear:both"> <a href="<?php echo base_url();?>admin/add_passage/" class="stdbtn btn_black">Add Passage</a></p>
                    
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
                             <th class="head1">Passage Name</th>
                              <th class="head1">Passage Desc</th>
                                <th class="head1">Batch Name</th>
                               <th class="head1">Subject Name</th>
                            <th class="head0">Date Added</th>
                            <th class="head1">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                              <th class="head1">No</th>
                                <th class="head1">Passage Name</th>
                              <th class="head1">Passage Desc</th>
                              <th class="head1">Batch Name</th>
                               <th class="head1">Subject Name</th>
                            <th class="head0">Date Added</th>
                            <th class="head1">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i=$Page_No+1; foreach($all_subject as $val) { ?>
                        <tr class="gradeA" id="<?php echo $val['pid'];?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $val['passage_title']; ?></td>
                            <td><?php echo $val['passage_desc']; ?></td>
                             <td><?php echo $val['batch_name'];?></td>
                             <td><?php echo $val['subject'];?></td>
                            <td><?php echo $val['date'];?></td>
                            <td><a href="<?php echo base_url();?>admin/edit_passage/<?php echo $val['pid'];?>">Edit</a> | <a href="javascript:;" id="<?php echo $val['pid'];?>" class="deletepassage">Delete</a></td>
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