<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	//delete individual row
	jQuery('a.deletesection_sub').live("click", function() {
		var pp = jQuery(this);
		var msg = jQuery(this).html();
		var pid = jQuery(this).attr('id');
		var c = confirm('Are you sure?');
		var domain = "<?php echo base_url();?>";
		if(c) {			

			  var str="featured=1&id="+pid
			jQuery.ajax({
				type: "POST",
				url: domain+"admin/delete_section_sub",
				data: str,
				cache: false,
				success: function(html){
					pp.parents('tr').fadeOut(function(){ 
						pp.remove();
				});
					jAlert('Sub Section Deleted Successfully', 'Notification Dialog');
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
                
                 <p style="float:right; clear:both"> <a href="<?php echo base_url();?>admin/add_section_sub/" class="stdbtn btn_black">Add Sub Section</a></p>
                    
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
                            <th class="head1">Sub Section Name</th>
                            <th class="head1">Sections</th>
                            <th class="head0">Date Added</th>
                            <th class="head1">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="head1">No</th>
                            <th class="head1">Sub Section Name</th>
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
                            $query = $this->db->query('SELECT A.`pid`, A.`title` FROM `section` A LEFT OUTER JOIN `section_sub_section` B ON B.`section_sub_id`='.$val['pid'].' AND A.pid=B.section_id WHERE B.`section_sub_id`='.$val['pid'].' AND A.pid=B.section_id ORDER BY A.pid DESC');
							$prefix = '';
							$resuls = $query->result_array();
                            foreach($resuls as $K1=>$V1){
                            	echo $prefix.$V1['title'];
                            	$prefix = ', ';
                            }
                            ?></td>
                            <td><?php echo $val['date'];?></td>
                            <td><a href="<?php echo base_url();?>admin/edit_section_sub/<?php echo $val['pid'];?>">Edit</a> | <a href="javascript:;" id="<?php echo $val['pid'];?>" class="deletesection_sub">Delete</a></td>
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