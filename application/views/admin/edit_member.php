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
                    <?php echo validation_errors('<div class="notification msgerror"><p><a class="close"></a>', '</p></div>'); ?>
                    
                    <form id="kl" class="stdform" action="<?php echo base_url();?>admin/edit_member/<?php echo $user_details['u_id'];?>" method="post">
                    	
                        <input type="hidden" name="u_id" value="<?php echo $user_details['u_id'];?>" />
                        <p>
                        	<label>Name</label>
                            <span class="field"><input type="text" name="name" value="<?php echo set_value('name', $user_details['name']); ?>" class="mediuminput" /></span>
                        </p>
                        
                        <p>
                        	<label>Candidate ID</label>
                            <span class="field"><input type="text" name="candidate_id" value="<?php echo set_value('candidate_id', $user_details['candidate_id']); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <p>
                        	<label>Email</label>
                            <span class="field"><input type="text" name="email" value="<?php echo set_value('email', $user_details['email']); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <p>
                        	<label>Mobile</label>
                            <span class="field"><input type="text" name="mobile" value="<?php echo set_value('mobile', $user_details['mob_no']); ?>" class="mediuminput" /></span>
                        </p>
                        
                        <p>
                        	<label>Landline</label>
                            <span class="field"><input type="text" name="landline" value="<?php echo set_value('landline', $user_details['landline']); ?>" class="mediuminput" /></span>
                        </p>
                        
                        
                        <p>
                        	<label>Address</label>
                            <span class="field"><textarea cols="80" rows="4" name="address" class="longinput"><?php echo set_value('address', $user_details['address']); ?></textarea></span> 
                        </p>
                        
                         <p>
                        	<label>City</label>
                            <span class="field"><input type="text" name="city" value="<?php echo set_value('city', $user_details['city']); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <p>
                        	<label>Pincode</label>
                            <span class="field"><input type="text" name="pincode" value="<?php echo set_value('pincode', $user_details['pincode']); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <p>
                        	<label>How did you know us </label>
                            <span class="field"><?php if(!empty($user_details['how'])) { echo ucwords($user_details['how']); } else { echo 'N/A'; } ?></span>
                        </p>
                        
                        
                        
                        <p>
                        	<label>Fee Paid</label>
                            <span class="field"><input type="text" name="feepaid" value="<?php echo set_value('feepaid', $user_details['fee_paid']); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <p>
                        	<label>Received Through</label>
                            <span class="field"><input type="text" name="received_through" value="<?php echo set_value('received_through', $user_details['received_through']); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <p>
                        	<label>Name of Bank </label>
                            <span class="field"><input type="text" name="bank" value="<?php echo set_value('bank', $user_details['bank']); ?>" class="mediuminput" /></span>
                        </p>
                        
                        <p>
                        	<label>Date of Credit </label>
                            <span class="field"><input type="text" name="date_of_credit" value="<?php echo set_value('date_of_credit', $user_details['date_of_credit']); ?>" class="mediuminput" /></span>
                        </p>
                        
                         <?php if($user_details['fee_remitted_for'] == 0) { $chkkt = TRUE; $chkktt = FALSE; $chkkttt = FALSE; } elseif($user_details['fee_remitted_for'] == 1) { $chkktt = TRUE; $chkkt = FALSE; $chkkttt = FALSE; } elseif($user_details['fee_remitted_for'] == 2) { $chkkttt = TRUE; $chkkt = FALSE; $chkktt = FALSE; } elseif($user_details['fee_remitted_for'] == 3) { $chkkt = FALSE; $chkktt = FALSE; $chkkttt = FALSE; } ?>
                    
                        <p>
                        	<label>Fee Remitted For </label>
                           <span class="field">
                            <select name="fee_remitted_for">
                                <option value="3">Select</option>
                                <option value="0" <?php echo set_select('fee_remitted_for', $user_details['fee_remitted_for'], $chkkt); ?>>Online Test</option>
                                <option value="1" <?php echo set_select('fee_remitted_for', $user_details['fee_remitted_for'], $chkktt); ?>>GK</option>
                                <option value="2" <?php echo set_select('fee_remitted_for', $user_details['fee_remitted_for'], $chkkttt); ?>>Both</option>
                            </select>
                            </span>
                        </p>
                        
                         <p>
                        	<label>Other Details</label>
                            <span class="field"><textarea cols="80" rows="4" name="details" class="longinput"><?php echo set_value('details', $user_details['details']); ?></textarea></span> 
                        </p>
                        
                        <p>
                        	<label>More Details</label>
                            <span class="field"><textarea cols="80" rows="4" name="moredetails" class="longinput"><?php echo set_value('moredetails', $user_details['moredetails']); ?></textarea></span> 
                        </p>
                        
                        <?php if($user_details['status'] == 0) { $chkk = TRUE; } else { $chkk = FALSE; } ?>
                        
                        <p>
                        	<label>Status</label>
                            <span class="field">
                            <select name="status">
                                <option value="1" <?php echo set_select('status', $user_details['status'], $chkk); ?>>Active</option>
                                <option value="0" <?php echo set_select('status', $user_details['status'], $chkk); ?>>In Active</option>
                            </select>
                            </span>


                        </p>
                        
                       

                        <p class="stdformbutton">
                             <input type="submit" class="stdbtn btn_black" value="Update Member" name="edit_member" />
                        </p>
                        
                        
                    </form>
                    
                    <br clear="all" /><br />
  
                </div><!--content-->
                
            </div>