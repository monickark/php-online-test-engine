<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>">Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                <!--	<ul class="widgetlist">
                    	<li><a href="calendar.html" class="events">Latest Events</a></li>
                    	<li><a href="editor.html" class="message">New Message</a></li>
                        <li><a href="dashboard.html" class="upload">Upload Image</a></li>
                    	<li><a href="calendar.html" class="events">Statistics</a></li>
                    	<li><a href="editor.html" class="message">New Message</a></li>
                    </ul>-->
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span>Add EAI 360 News</span></h2>
                    </div><!--contenttitle-->
                    
                    <br />
                    <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p>Added Sucessfully</p></div>
			<?php } ?>
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>dashboard" method="post">
                    	
                        
                        <p>
                        	<label>Title</label>
                            <span class="field"><input type="text" name="title" value="<?php echo set_value('title'); ?>" class="mediuminput" /></span>
                        </p>
                        
                        
                        <p>
                        	<label>Description</label>
                            <span class="field"><textarea cols="80" rows="5" name="desc" class="longinput"><?php echo set_value('desc'); ?></textarea></span> 
                        </p>
                        
                        <p>
                        	<label>Category</label>
                            <span class="field">
                            <select name="cid">
                            	<?php foreach($cats as $val) { ?>
                                <option value="<?php echo $val['cid'];?>" <?php echo set_select('cid', $val['cid'], TRUE); ?>><?php echo $val['cname'];?></option>
                                <?php } ?>
                            </select>
                            </span>
                        </p>
                        
                        <p>
                        	<label>Link</label>
                            <span class="field"><input type="text" name="link" value="<?php echo set_value('link'); ?>" class="mediuminput" /></span>
                        </p>
                        
                        
                        <br clear="all" /><br />
                        
                        <p class="stdformbutton">
                        	<button class="submit radius2" name="add_news">Submit Button</button>
                            <input type="reset" class="reset radius2" value="Reset Button" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>