 <div class="mainleft floatleft">
          	<div class="mainleftinner">
            
              	<div class="leftmenu">
            		<ul>
                    	<li class="<?php echo ($selected == 'dashboard') ? 'current' : ''?>"><a href="<?php echo base_url();?>admin/dashboard" class="dashboard"><span>Admin Dashboard</span></a></li>
                        <li class="<?php echo ($selected == 'managemembersdefault') ? 'current' : ''?>"><a href="<?php echo base_url();?>admin/manage?type=default" class="widgets"><span>Manage Members</span></a></li>
                        <li class="<?php echo ($selected == 'managemembersinstitutional') ? 'current' : ''?>"><a href="<?php echo base_url();?>admin/manage?type=institutional" class="widgets"><span>Manage Institutional</span></a></li>

                        <li><a href="<?php echo base_url();?>admin/manage_payment" class="widgets"><span>Online Payment</span></a></li>

                          <li class="<?php echo ($selected == 'test_type') ? 'current' : ''?>"><a href="javascript:;" class="editor menudrop"><span>Test Types</span></a>
                          <ul <?php if($selected == 'test_type') { ?>style="display:block"<?php } ?>>
                            	<li><a href="<?php echo base_url();?>admin/add_test_type"><span>Add Test Type</span></a></li>
                            	<li><a href="<?php echo base_url();?>admin/manage_test_type"><span>Manage Test Types</span></a></li>
                                
                           </ul>
                         </li>                        
                         

                          <li class="<?php echo ($selected == 'sector') ? 'current' : ''?>"><a href="javascript:;" class="editor menudrop"><span>Test Taker Verticals</span></a>
                          <ul <?php if($selected == 'sector') { ?>style="display:block"<?php } ?>>
                            	<li><a href="<?php echo base_url();?>admin/add_sector"><span>Add New Vertical</span></a></li>
                            	<li><a href="<?php echo base_url();?>admin/manage_sector"><span>Manage Verticals</span></a></li>
                                
                           </ul>
                         </li> 



                         <li class="<?php echo ($selected == 'section') ? 'current' : ''?>"><a href="javascript:;" class="editor menudrop"><span>Test Sections</span></a>
                          <ul <?php if($selected == 'section') { ?>style="display:block"<?php } ?>>
                            	<li><a href="<?php echo base_url();?>admin/add_section"><span>Add New Section</span></a></li>
                            	<li><a href="<?php echo base_url();?>admin/manage_section"><span>Manage Section</span></a></li>
                                <li><a href="<?php echo base_url();?>admin/add_section_sub"><span>Add Sub Section</span></a></li>
                                <li><a href="<?php echo base_url();?>admin/manage_section_sub"><span>Manage Sub Section</span></a></li>
                                
                           </ul>
                         </li>
                         
                          <li class="<?php echo ($selected == 'question') ? 'current' : ''?>"><a href="javascript:;" class="editor menudrop"><span>Questions</span></a>
                          <ul <?php if($selected == 'question') { ?>style="display:block"<?php } ?>>
                            	<li><a href="<?php echo base_url();?>admin/add_question"><span>Add Question</span></a></li>
                            	<li><a href="<?php echo base_url();?>admin/manage_question"><span>Manage Questions</span></a></li>
                           </ul>
                         </li>
                         
                          <li class="<?php echo ($selected == 'test') ? 'current' : ''?>"><a href="javascript:;" class="editor menudrop"><span>Client Management</span></a>
                          <ul <?php if($selected == 'test') { ?>style="display:block"<?php } ?>>
                            	<li><a href="<?php echo base_url();?>admin/add_test"><span>Set New Client</span></a></li>
                            	<li><a href="<?php echo base_url();?>admin/manage_test"><span>Manage Clients</span></a></li>
                                
                           </ul>
                         </li>
                         
                           <li class="<?php echo ($selected == 'gk') ? 'current' : ''?>"><a href="javascript:;" class="editor menudrop <?php echo ($selected == 'gk') ? 'active' : ''?>"><span>GK</span></a>
                          <ul <?php if($selected == 'question') { ?>style="display:block"<?php } ?>>
                            	<li><a href="<?php echo base_url();?>admin/add_gk"><span>Add GK</span></a></li>
                            	<li><a href="<?php echo base_url();?>admin/manage_gk"><span>Manage GK</span></a></li>
                                <li><a href="<?php echo base_url();?>admin/scrolling_gk"><span>Scrolling GK</span></a></li>
                           </ul>
                         </li>
                          
                          <li class="<?php echo ($selected == 'ms') ? 'current' : ''?>"><a href="<?php echo base_url();?>admin/msg_support" class="chat"><span>Message Centre</span></a></li>
                          <li  class="<?php echo ($selected == 'mall') ? 'current' : ''?>"><a href="<?php echo base_url();?>admin/msg_to_all" class="chat"><span>Message to All</span></a></li>
                           <li class="<?php echo ($selected == 'cpass') ? 'current' : ''?>"><a href="#" class="widgets"><span>Change Admin Password</span></a></li>
                           
                           <li class="<?php echo ($selected == 'cpass') ? 'current' : ''?>"><a href="<?php echo base_url();?>admin/member_logs" class="widgets"><span>Manage Member Logs</span></a></li>
                           <li class="<?php echo ($selected == 'test') ? 'current' : ''?>"><a href="<?php echo base_url();?>admin/clear_results" class="widgets"><span>Clear Test Logs</span></a></li>

                          <li class="<?php echo ($selected == 'fclub') ? 'current' : ''?>"><a href="<?php echo base_url();?>admin/logout" class="error"><span>Logout</span></a></li>
                        
                    </ul>
                        
                </div><!--leftmenu-->
                
                
            	<div id="togglemenuleft"><a></a></div>
            </div><!--mainleftinner-->
        </div><!--mainleft-->
        
       