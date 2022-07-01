<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Admin Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                
             
                    
                    <div class="one_half">
                     <div class="widgetbox">
                        <div class="title"><h2 class="tabbed"><span>Statistics</span></h2></div>
                        <div class="widgetcontent padding0 statement">
                           <table cellpadding="0" cellspacing="0" border="0" class="stdtable">
                           		<colgroup>
                                    <col class="con1" />
                                    <col class="con0" />
                                    <col class="con0" />
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th class="head1">Sections</th>
                                        <th class="head0">Total Nos</th>
                                        <th class="head0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total Members</td>
                                        <td><?php echo $total['members'];?></td>
                                        <td> <a href="<?php echo base_url();?>admin/manage">Manage</a></td>
                                    </tr>
                                    <tr>
                                        <td>Active members</td>
                                        <td><?php echo $total['active'];?></td>
                                        <td> <a href="<?php echo base_url();?>admin/manage_active">Manage</a></td>
                                    </tr>
                                    <tr>
                                        <td>In-Active members</td>
                                        <td><?php echo $total['inactive'];?></td>
                                         <td><a href="<?php echo base_url();?>admin/manage_inactive">Manage</a></td>
                                    </tr>
                                    <tr>
                                        <td>GK</td>
                                        <td><?php echo $total['gk'];?></td>
                                        <td><a href="<?php echo base_url();?>admin/add_gk">Add New</a> | <a href="<?php echo base_url();?>admin/manage_gk">Manage</a> | <a href="<?php echo base_url();?>admin/scrolling_gk">Scrolling GK</a></td>
                                    </tr>
                                    <tr>
                                        <td>Subjects</td>
                                        <td><?php echo $total['subjects'];?></td>
                                         <td><a href="<?php echo base_url();?>admin/add_subject">Add New</a> | <a href="<?php echo base_url();?>admin/manage_subject">Manage</a></td>
                                    </tr>
                                    <tr>
                                        <td>Questions</td>
                                        <td><?php echo $total['questions'];?></td>
                                        <td><a href="<?php echo base_url();?>admin/add_question">Add New</a> | <a href="<?php echo base_url();?>admin/manage_questions">Manage</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--widgetcontent-->
                    </div><!--widgetbox-->         
                  </div>
                  
                   <div class="one_half last">
                  
                    </div>
                    <br clear="all" /><br />

  
                </div><!--content-->
                
            </div>