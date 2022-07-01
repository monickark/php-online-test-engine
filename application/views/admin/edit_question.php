<div class="maincontentinner">
<!-- Load TinyMCE -->
<script type="text/javascript" src="<?php echo base_url();?>tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
		jQuery('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo base_url();?>tinymce/jscripts/tiny_mce/tiny_mce.js',
    		relative_urls : false,
			width : "600",
			height : "125",
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
		
		 jQuery(".batchid").change(function () {
		   var bid=jQuery(this).val();								 
		   var str = 'bid='+ bid;
		   var domain = "<?php echo base_url();?>";
		   
		   		jQuery.ajax({
				type: "POST",
				url: domain+"select/s_subject",
				data: str,
				cache: false,
				success: function(html){
						jQuery(".sub_id").html(html);
						 jQuery(".p_id").html('');
				}
			});						  
		});
		 
		  jQuery(".sub_id").change(function () {
		   var sid=jQuery(this).val();	
		   var str = 'sub_id='+ sid;
		   var domain = "<?php echo base_url();?>";
		   jQuery(".p_id").html('');
		   		jQuery.ajax({
				type: "POST",
				url: domain+"select/s_passage",
				data: str,
				cache: false,
				success: function(html){
						jQuery(".p_id").html(html);
				}
			});						  
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
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/edit_question/<?php echo $details['qid']; ?>" method="post">
                     <input type="hidden" name="qid" value="<?php echo $details['qid']; ?>" />
                     <p>
                        	<label>Select Batch</label>
                            <span class="field">
                            <select name="batch_id" class="batchid">
                                <option value="">Select</option>
                                <?php foreach($all_batch as $val) { if($val['batch_id'] == $details['batch_id']) { $chk = TRUE; } else { $chk = FALSE; } ?>
                                <option value="<?php echo $val['batch_id'];?>" <?php echo set_select('batch_id', $val['batch_id'], $chk); ?>><?php echo $val['batch_name'];?></option>
                             <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                         <p>
                        	<label>Select Subject</label>
                            <span class="field">
                            <select name="sub_id" class="sub_id">
                                <option value="">Select</option>
                                <?php foreach($all_sub as $val) { if($val['sub_id'] == $details['sub_id']) { $chkk = TRUE; } else { $chkk = FALSE; } ?>
                                <option value="<?php echo $val['sub_id'];?>" <?php echo set_select('sub_id', $val['sub_id'], $chkk); ?>><?php echo $val['subject'];?></option>
                             <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                        <p>
                        	<label>Select Passage</label>
                            <span class="field">
                            <select name="pid" class="p_id">
                                <option value="">Select</option>
                                <?php foreach($all_pass as $val) { if($val['pid'] == $details['pid']) { $chkkk = TRUE; } else { $chkkk = FALSE; }?>
                                <option value="<?php echo $val['pid'];?>" <?php echo set_select('pid', $val['pid'], $chkkk); ?>><?php echo $val['passage_title'];?></option>
                             <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                         <p>
                        	<label>Question</label>
                            <span class="field"><textarea class="tinymce" id="qn" name="question" cols="" rows=""><?php echo set_value('question', $details['question']); ?></textarea> </span>
                        </p>
                        
                        <p>
                        	<label>Option 1</label>
                            <span class="field"><textarea class="tinymce" id="op1" name="ops1" cols="" rows=""><?php echo set_value('ops1', $details['option_1']); ?></textarea> </span>
                        </p>
                        
                         <p>
                        	<label>Option 2</label>
                            <span class="field"><textarea class="tinymce" id="op2" name="ops2" cols="" rows=""><?php echo set_value('ops2', $details['option_2']); ?></textarea> </span>
                        </p>
                        
                         <p>
                        	<label>Option 3</label>
                            <span class="field"><textarea class="tinymce" id="op3" name="ops3" cols="" rows=""><?php echo set_value('ops3', $details['option_3']); ?></textarea> </span>
                        </p>
                        
                        <p>
                        	<label>Option 4</label>
                            <span class="field"><textarea class="tinymce" id="op4" name="ops4" cols="" rows=""><?php echo set_value('ops4', $details['option_4']); ?></textarea> </span>
                        </p>
                        
                        <p>
                        	<label>Answer</label>
                            <span class="field"><input type="text" name="answer" value="<?php echo set_value('answer', $details['answer']); ?>" class="mediuminput" /></span> <small class="desc">Type 1 or 2 or 3 or 4</small>

                        </p>

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Update Question" name="edit_qn" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>