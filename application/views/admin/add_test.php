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
<div class="maincontentinner">

                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Admin Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span><?php echo $title;?></span></h2>
                    </div><!--contenttitle-->
                    
                    <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p>Added Sucessfully</p></div>
			<?php } ?>
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/add_test" method="post">
                    
                    
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
                <tr>
                <td>Select Test Type</td><td></td>
                </tr>
                <tr>
                <td>Select Vertical</td><td></td>
                </tr>
                </table>    
                    
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                       <tr>
                            <th class="head1">Sections</th>
                            <th class="head0">Set Question</th>
                            <th class="head1">Set Minutes</th>
                            <th class="head0">Set RA Mark</th>
                            <th class="head1">Set WA Mark</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                             <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                    </tbody>
                </table>                    
                    
                    

                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>