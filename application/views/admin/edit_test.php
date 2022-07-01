<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery('#sdate').datetimepicker({
								dateFormat: "yy-mm-d"
								});
jQuery('#edate').datetimepicker({
								dateFormat: "yy-mm-d"
								});
});
</script>
<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css" />
<style>
.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
.ui-timepicker-div dl { text-align: left; }
.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
.ui-timepicker-div td { font-size: 90%; }
.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

.ui-timepicker-rtl{ direction: rtl; }
.ui-timepicker-rtl dl { text-align: right; }
.ui-timepicker-rtl dl dd { margin: 0 65px 10px 10px; }
</style>
<?php
$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone); ?>
<div class="maincontentinner">

                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Admin Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span><?php echo $title;?></span></h2>
                    </div><!--contenttitle-->
                    
                    <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p>Updated Sucessfully</p></div>
			<?php } ?>
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/edit_test/<?php echo $details['tid'];?>" method="post">
                    <input type="hidden" name="tid" value="<?php echo $details['tid'];?>" />
                     <p>
                        	<label>Select Batch</label>
                            <span class="field">
                            <select name="batch_id" class="batchid">
                                <option value="">Select</option>
                                <?php foreach($all_batch as $val) {  if($val['batch_id'] == $details['batch_id']) { $chk = TRUE; } else { $chk = FALSE; } ?>
                                <option value="<?php echo $val['batch_id'];?>" <?php echo set_select('batch_id', $val['batch_id'], $chk); ?>><?php echo $val['batch_name'];?></option>
                             <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                        <p>
                        	<label>Test Name</label>
                            <span class="field"><input type="text" name="tname" id="tname" value="<?php echo set_value('tname', $details['test_name']); ?>" class="mediuminput" /></span>
                        </p>
                        
                        
                         <p>
                        	<label>Select Start Date</label>
                            <span class="field"><input type="text" name="sdate" id="sdate" value="<?php echo set_value('sdate', date('Y-m-d h:i',$details['start_time'])); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <p>
                        	<label>Select End Date</label>
                            <span class="field"><input type="text" name="edate" id="edate" value="<?php echo set_value('edate', date('Y-m-d h:i',$details['end_time'])); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <p>
                        	<label>Test Time in Minutes</label>
                            <span class="field"><input type="text" name="ttime" id="ttime" value="<?php echo set_value('ttime', $details['test_time']); ?>" class="mediuminput" /></span>
                        </p>
      

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Update Test" name="edit_test" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>