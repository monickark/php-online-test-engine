<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	//delete individual row
	jQuery('a.deletepayment').live("click", function() {
		var pp = jQuery(this);
		var msg = jQuery(this).html();
		var pid = jQuery(this).attr('id');
		var c = confirm('Are you sure?');
		var domain = "<?php echo base_url();?>";
		if(c) {			

			  var str="featured=1&id="+pid
			jQuery.ajax({
				type: "POST",
				url: domain+"admin/delete_payment",
				data: str,
				cache: false,
				success: function(html){
					pp.parents('tr').fadeOut(function(){ 
						pp.remove();
				});
					jAlert('Payment Details Deleted Successfully', 'Notification Dialog');
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
                
                 <p style="float:right; clear:both"></p>
                    
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
							<th class="head1">User</th>
							<th class="head1">Test Type</th>
							<th class="head1">Sector</th>
							<th class="head1">User Type</th>
							<th class="head1">No of Users</th>
							<th class="head1">Paid</th>
							<th class="head1">Date</th>
							<th class="head1">NEFT Transaction No</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
							<th class="head1">No</th>
							<th class="head1">User</th>
							<th class="head1">Test Type</th>
							<th class="head1">Sector</th>
							<th class="head1">User Type</th>
							<th class="head1">No of Users</th>
							<th class="head1">Paid</th>
							<th class="head1">Date</th>
							<th class="head1">NEFT Transaction No</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i=$Page_No+1; foreach($all_subject as $val) { ?>
                        <tr class="gradeA" id="<?php echo $val['pid'];?>">
                            <td><?php echo $i;?></td>
                            <td><?php
                            $infoMember = $this->admin_model->get_member_details($val['uid']);
                            if( $infoMember!=false ){
                            	echo $infoMember['name'];
                            }
                            ?></td>
                            <td><?php
                            $infoTestType = $this->admin_model->get_test_type_details($val['test_type_id']);
                            if( $infoTestType!=false ){
                            	echo $infoTestType['title'];
                            }
                            ?></td>
                            <td><?php
                            $infoSector = $this->admin_model->get_sector_details($val['sector_id']);
                            if( $infoSector!=false ){
                            	echo $infoSector['title'];
                            }
                            ?></td>
                            <td><?php
	                    	if( $val['type']==USER_TYPE_INSTITUTIONAL ){
	                    		echo 'Institutional';
	                    	}
	                    	elseif( $val['type']==USER_TYPE_CANDIDATE ){
	                    		echo 'Candidates Applying for Jobs';
	                    	}
	                    	elseif( $val['type']==USER_TYPE_FRESHER ){
	                    		echo 'Fresher\'s';
	                    	}
	                    	?></td>
	                    	<td>                    
	                    	<?php echo $val['user_count']; ?>
	                    	</td>
	                    	<td>                    
	                    	<?php echo $val['paid']; ?>
	                    	</td>
	                    	<td>                    
	                    	<?php echo date('j-M-Y', strtotime($val['paid_date'])); ?>
	                    	</td>
	                    	<td>                    
	                    	<?php echo $val['transaction_no']; ?>
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