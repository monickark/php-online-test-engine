<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="<?php echo base_url();?>admin/dashboard">Dashboard</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                    
                    <div class="contenttitle">
                    	<h2 class="form"><span><?php echo $title;?></span></h2>
                    </div><!--contenttitle-->
                    
                    <br />
                    <?php if(!empty($success)) { ?>
			<div class="notification msgsuccess"> <a class="close"></a><p>Updated Sucessfully</p></div>
			<?php } ?>
                   
                    
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
                                    </tr>
                                </thead>
                                 <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td><?php echo $user_details['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?php echo $user_details['email']; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Mobile No</td>
                                        <td><?php echo $user_details['mob_no']; ?></td>
                                    </tr>
                                     <tr>
                                        <td>Landline</td>
                                        <td><?php echo $user_details['landline']; ?></td>
                                    </tr>
                                    
                                     <tr>
                                        <td>City</td>
                                        <td><?php echo $user_details['city']; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Address</td>
                                        <td><?php echo $user_details['address']; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Pincode</td>
                                        <td><?php echo $user_details['pincode']; ?></td>
                                    </tr>
                                     <tr>
                                        <td>Fee Paid</td>
                                        <td><?php echo $user_details['fee_paid']; ?></td>
                                    </tr>
                                    
                                      <tr>
                                        <td>Received Through</td>
                                        <td><?php echo $user_details['received_through']; ?></td>
                                    </tr>
                                     <tr>
                                        <td>Name of Bank</td>
                                        <td><?php echo $user_details['bank']; ?></td>
                                    </tr>
                                    
                                     <tr>
                                        <td>Date of Credit</td>
                                        <td><?php echo $user_details['date_of_credit']; ?></td>
                                    </tr>
                                    
                                     <tr>
                                        <td>Fee Remitted For</td>
                                        <td><?php if($user_details['fee_remitted_for'] == 0) { echo "Online Test"; } elseif($user_details['fee_remitted_for'] == 1) { echo "GK"; } elseif($user_details['fee_remitted_for'] == 2) { echo "Online Test & GK"; } ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Details 1</td>
                                        <td><?php echo $user_details['details']; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Details 2</td>
                                        <td><?php echo $user_details['moredetails']; ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Status</td>
                                        <td><?php if($user_details['status'] == 0) { echo "In active"; } else { echo "Active"; } ?></td>
                                    </tr>
                        </tbody>
                        </table>
                        
                       <p><center> <a href="<?php echo base_url();?>admin/edit_member/<?php echo $user_details['u_id'];?>" class="stdbtn btn_black">Edit Member</a></center></p>
                        
                        
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>