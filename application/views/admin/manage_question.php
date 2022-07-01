<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	//delete individual row
	jQuery('a.deletequestion').live("click", function() {
		var pp = jQuery(this);
		var msg = jQuery(this).html();
		var qid = jQuery(this).attr('id');
		var c = confirm('Are you sure?');
		var domain = "<?php echo base_url();?>";
		if(c) {			

			  var str="featured=1&id="+qid
			jQuery.ajax({
				type: "POST",
				url: domain+"admin/delete_question",
				data: str,
				cache: false,
				success: function(html){
					pp.parents('tr').fadeOut(function(){ 
						pp.remove();
				});
					jAlert('Question Deleted Successfully', 'Notification Dialog');
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
                
                 <p style="float:right; clear:both"> <a href="<?php echo base_url();?>admin/add_question/" class="stdbtn btn_black">Add Question</a></p>
                    
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
                              <th class="head1">Option 1</th>
                                <th class="head1">Option 2</th>
                               <th class="head1">Option 3</th>
                            <th class="head0">Option 4</th>
                            <th class="head0">Answer</th>
                            <th class="head1">Sub Section</th>
                            <th class="head1">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="head1">No</th>
                            <th class="head1">Question</th>
                            <th class="head1">Option 1</th>
                            <th class="head1">Option 2</th>
                            <th class="head1">Option 3</th>
                            <th class="head0">Option 4</th>
                            <th class="head0">Answer</th>
                            <th class="head1">Sub Section</th>
                            <th class="head1">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $i=$Page_No+1; foreach($all_subject as $val) { ?>
                        <tr class="gradeA" id="<?php echo $val['pid'];?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $val['question']; ?></td>
                            <td><?php echo $val['option_1']; ?></td>
                             <td><?php echo $val['option_2'];?></td>
                             <td><?php echo $val['option_3'];?></td>
                            <td><?php echo $val['option_4'];?></td>
                             <td><?php echo "option ".$val['answer'];?></td>
                             <td><?php
                            $infoSubSection = $this->admin_model->get_section_sub_details($val['section_sub_id']);
                            if( $infoSubSection!=false ){
                            	echo $infoSubSection['title'];
                            }
                            ?></td>
                            <td><a href="<?php echo base_url();?>admin/edit_question/<?php echo $val['pid'];?>">Edit</a> | <a href="javascript:;" id="<?php echo $val['pid'];?>" class="deletequestion">Delete</a></td>
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