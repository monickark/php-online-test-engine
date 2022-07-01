<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	//delete individual row
	jQuery('a.deletegk').live("click", function() {
		var pp = jQuery(this);
		var msg = jQuery(this).html();
		var gk_id = jQuery(this).attr('id');
		var c = confirm('Are you sure?');
		var domain = "<?php echo base_url();?>";
		if(c) {			

			  var str="featured=1&id="+gk_id
			jQuery.ajax({
				type: "POST",
				url: domain+"admin/delete_gk",
				data: str,
				cache: false,
				success: function(html){
					pp.parents('tr').fadeOut(function(){ 
						pp.remove();
				});
					jAlert('GK Deleted Successfully', 'Notification Dialog');
				}
			});
		}
		return false;
	});
});	
</script>
<style>
tr#norm { }
tr#feat { background:#FFC6C6}
</style>
<?php
function check_status($id)
{
	switch ($id) {
		case 0:
		return "In Active";
		break;
		case 1:
		return "Active";
		break;
		case 2:
		return "Banned";
		break;
	}
}
?>
<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Goto Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                
                 <p style="float:right; clear:both"> <a href="<?php echo base_url();?>admin/add_gk/" class="stdbtn btn_black">Add GK</a></p>
                    
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
                             <th class="head1">Question</th>
                            <th class="head0">Answer</th>
                            <th class="head1">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                              <th class="head1">No</th>
                                <th class="head1">Question</th>
                            <th class="head0">Answer</th>
                            <th class="head1">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i=$Page_No+1; foreach($all_gk as $val) { ?>
                        <tr class="gradeA" id="<?php echo $val['gk_id'];?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $val['question']; ?></td>
                            <td><?php echo $val['answer'];?></td>
                            <td><a href="<?php echo base_url();?>admin/edit_gk/<?php echo $val['gk_id'];?>">Edit</a> | <a href="javascript:;" id="<?php echo $val['gk_id'];?>" class="deletegk">Delete</a></td>
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