<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	//delete individual row
	jQuery('a.deletelog').live("click", function() {
		var pp = jQuery(this);
		var msg = jQuery(this).html();
		var u_id = jQuery(this).attr('id');
		var c = confirm('Are you sure?');
		var domain = "<?php echo base_url();?>";
		if(c) {			

			  var str="featured=1&id="+u_id
			jQuery.ajax({
				type: "POST",
				url: domain+"admin/delete_log",
				data: str,
				cache: false,
				success: function(html){
					pp.parents('tr').fadeOut(function(){ 
						pp.remove();
				});
					jAlert('Log Cleared Successfully', 'Notification Dialog');
				}
			});
		}
		return false;
	});
});	

   function confirmUser() {  
      var answer = window.confirm("Are you sure?");  
      if(answer) { return true;  } else { return false;  
	  }
   }  
</script>
<style>
tr#norm { }
tr#feat { background:#FFC6C6}
</style>
<?php
function marks($c_ans)
{
   $correct=str_replace("2","0",$c_ans);
   $correct=str_replace("-1","0",$correct);
   $correct=explode(",",$correct);
   return array_sum($correct);
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
                
                <?php //print_r($all_tests); ?>
                
                 <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p><?php echo $success; ?></p></div>
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
                            <th class="head0">Date</th>
                            <th class="head1">Name</th>
                            <th class="head0">Email</th>
                            <th class="head1">Test Name</th>
                            <th class="head1">Marks</th>
                            <th class="head0">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="head1">No</th>
                            <th class="head0">Date</th>
                            <th class="head1">Name</th>
                            <th class="head0">Email</th>
                            <th class="head1">Test Name</th>
                            <th class="head1">Marks</th>
                            <th class="head0">Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                      <?php
                      $i=1;
                      foreach($all_tests as $val){
						$query = $this->db->query('SELECT * FROM `user_details` WHERE `u_id`='.$val['uid']);
						$infoMember = $query->row_array();
						
						$query = $this->db->query('SELECT * FROM `test` WHERE `pid`='.$val['test_id']);
						$infoTest = $query->row_array();
					  ?>
                        <tr class="gradeA" id="<?php echo $val['uid'];?>">
                            <td><?php
                            echo $i;
                            ?></td>
                            <td><?php
                            echo date('dS  M, Y h:i a', strtotime($val['date']));
                            ?></td>
                            <td><?php
                            echo isset($infoMember['name']) ? $infoMember['name'] : '';
                            ?></td>
                            <td><?php
                            echo isset($infoMember['email']) ? $infoMember['email'] : '';
                            ?></td>
                            <td><?php
                            echo isset($infoTest['title']) ? $infoTest['title'] : '';
                            ?></td>
                            <td><?php
                            echo $this->admin_model->get_score($val['last_test'], $val['uid']);
                            ?></td>
                            <td>
                            <a href="<?php echo base_url();?>admin/clear_test_logs/<?php echo $val['last_test'];?>/<?php echo $val['uid'];?>" id="<?php echo $val['uid'];?>"  onclick="return confirm('Are you sure?')" class="cleartestlog">Enable Test Link</a>
                            </td>
                        </tr>
                        <?php
                        $i++;
						}
						?>
                    </tbody>
                </table>
                     <br clear="all" />
               
  
                </div><!--content-->
                
            </div>