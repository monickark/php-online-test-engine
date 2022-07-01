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
                
                                     
                                   <div class="contenttitle radiusbottom0">
                	<h2 class="table"><span><?php echo $title;?></span></h2>
                </div><!--contenttitle-->
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        
                    </colgroup>
                    <thead>
                       <tr>
                              <th class="head1">No</th>
                             <th class="head1">Member Name</th>
                            <th class="head0">Email ID</th>
                            <th class="head1">Test Type</th>
                            <th class="head0">Test Sector</th>
                            <th class="head1">Date</th>
                            <th class="head0">NEFT Txn No.</th>
                        </tr>
                    </thead>
                    <tfoot>
                       <tr>
                              <th class="head1">No</th>
                             <th class="head1">Member Name</th>
                            <th class="head0">Email ID</th>
                            <th class="head1">Test Type</th>
                            <th class="head0">Test Sector</th>
                            <th class="head1">Date</th>
                            <th class="head0">NEFT Txn No.</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        
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