<div class="maincontentinner">
<script type="text/javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
								
		jQuery('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js',
    		relative_urls : false,
			width : "600",
			height : "200",
			// General options
			theme : "advanced",
			plugins : "markettoimages,autolink,lists,pagebreak,style,layer,save,advhr,advimage,advlink,iespell,inlinepopups,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,fontsizeselect,",
			theme_advanced_buttons2 : "undo,redo,|,link,unlink,image,|,markettoimages,cleanup,code,|,preview",
			theme_advanced_buttons3 : "hr,removeformat,|,sub,sup,|,charmap,iespell,advhr,|,fullscreen",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",
			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",
			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
			
		});
	
});
</script>
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span><?php echo $title;?></span></h2>
                    </div><!--contenttitle-->
                    
                    <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p>Updated Sucessfully</p></div>
			<?php } ?>
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/edit_passage/<?php echo $details['pid'];?>" method="post">
                    
                    <input type="hidden" name="pid" value="<?php echo $details['pid']; ?>" />
                     <p>
                        	<label>Select Batch</label>
                            <span class="field">
                            <select name="batch_id">
                                <option value="">Select</option>
                                <?php foreach($all_batch as $val) { if($val['batch_id'] == $details['batch_id']) { $chk = TRUE; } else { $chk = FALSE; } ?>
                                <option value="<?php echo $val['batch_id'];?>" <?php echo set_select('batch_id', $details['batch_id'], $chk); ?>><?php echo $val['batch_name'];?></option>
                             <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                         <p>
                        	<label>Select Subject</label>
                            <span class="field">
                            <select name="sub_id">
                                <option value="">Select</option>
                                <?php foreach($all_sub as $val) { if($val['sub_id'] == $details['sub_id']) { $chkk = TRUE; } else { $chkk = FALSE; } ?>
                                <option value="<?php echo $val['sub_id'];?>" <?php echo set_select('sub_id', $details['sub_id'], $chkk); ?>><?php echo $val['subject'];?></option>
                             <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                        
                        
                         <p>
                        	<label>Passage Name</label>
                            <span class="field"><input type="text" name="p_name" value="<?php echo set_value('p_name', $details['passage_title']); ?>" class="mediuminput" /></span>
                        </p>
                        
                            <p>
                        	<label>Passage Description</label>
                            <span class="field"><textarea class="tinymce" name="p_desc" cols="" rows=""><?php echo set_value('p_desc', $details['passage_desc']); ?></textarea> </span>
                        </p>
                  

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Update Passage" name="edit_pass" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>