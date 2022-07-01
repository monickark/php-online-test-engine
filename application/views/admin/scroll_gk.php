<div class="maincontentinner">
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/wysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/wysiwyg/wysiwyg.image.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/wysiwyg/wysiwyg.link.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/wysiwyg/wysiwyg.table.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/plugins/wysiwyg/plugins/wysiwyg.rmFormat.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
								
	jQuery('#wysiwyg').wysiwyg({
		controls: {
			indent: { visible: false },
			outdent: { visible: false },
			subscript: { visible: false },
			superscript: { visible: false },
			redo: { visible: true },
			undo: { visible: true },
			insertOrderedList: { visible: true },
			insertUnorderedList: { visible: true },
			insertHorizontalRule: { visible: true },
			insertTable: { visible: false },
			code: { visible: false },
			removeFormat: { visible: true },
			strikethrough: { visible: false },
			strikeThrough: { visible: false },
			html  : { visible: true }
		},
		plugins: { 
			rmFormat: {
					rmMsWordMarkup: true
			}
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
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/scrolling_gk" method="post">
                    	
                       <textarea id="wysiwyg" name="scroll_gk" cols="" rows=""><?php if(!empty($gk)) { echo $gk; } ?></textarea> 

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Update GK" name="scrolling_gk" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>