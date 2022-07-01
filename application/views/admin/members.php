<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	//delete individual row
	jQuery('a.deleteuser').live("click", function() {
		var pp = jQuery(this);
		var msg = jQuery(this).html();
		var u_id = jQuery(this).attr('id');
		var c = confirm('Are you sure?');
		var domain = "<?php echo base_url();?>";
		if(c) {			

			  var str="featured=1&id="+u_id
			jQuery.ajax({
				type: "POST",
				url: domain+"admin/delete_user",
				data: str,
				cache: false,
				success: function(html){
					pp.parents('tr').fadeOut(function(){ 
						pp.remove();
				});
					jAlert('Member Deleted Successfully', 'Notification Dialog');
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

$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

?>
<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Goto Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
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
                                 <th class="head0">Date</th>
                            <th class="head1">Name</th>
                            <th class="head1">Candidate ID</th>
                            <th class="head0">Email</th>
                            <th class="head1">Mobile</th>
                            <th class="head0">City</th>
                            <?php
                            if( $_GET['type']=='institutional' ){
                            ?>
                            <th class="head0">No of users</th>
                            <?php
                            }
                            ?>
                            <th class="head1">Status</th>
                            <th class="head0">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                              <th class="head1">No</th>
                              <th class="head0">Date</th>
                            <th class="head1">Name</th>
                            <th class="head1">Candidate ID</th>
                            <th class="head0">Email</th>
                            <th class="head1">Mobile</th>
                            <th class="head0">City</th>
                            <?php
                            if( $_GET['type']=='institutional' ){
                            ?>
                            <th class="head0">No of users</th>
                            <?php
                            }
                            ?>
                            <th class="head1">Status</th>
                            <th class="head0">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i=$Page_No+1; foreach($all_members as $val) { ?>
                        <tr class="gradeA" id="<?php echo $val['u_id'];?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo date('dS  M, Y h:i a', $val['date']); ?></td>
                            <td><?php echo $val['name'];?></td>
                            <td><?php echo $val['candidate_id'];?></td>
                             <td><?php echo $val['email'];?></td>
                            <td><?php echo $val['mob_no'];?></td>
                             <td><?php echo $val['city'];?></td>
                             <?php
                            if( $_GET['type']=='institutional' ){
                            ?>
                            <td><?php echo $val['user_count']; ?></td>
                            <?php
                            }
                            ?>
                             <td><?php echo check_status($val['status']); ?></td>
                            <td>
                            <a href="<?php echo base_url();?>admin/edit_member/<?php echo $val['u_id'];?>">Edit</a> 
                            | 
                            <a href="javascript:;" id="<?php echo $val['u_id'];?>" class="deleteuser">Delete</a> 
                            | 
                            <a href="<?php echo base_url();?>admin/view_member/<?php echo $val['u_id'];?>">View</a>
                            <?php
                            if( $_GET['type']=='institutional' ){
                            ?>
                            | 
                            <a href="<?php echo base_url();?>admin/manage?type=user&iid=<?php echo $val['u_id'];?>">Users</a>
                            <?php
                            }
                            ?>
                            </td>
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