

	<table width="1002" border="0" cellspacing="0" cellpadding="0">

    <tr>

    	<td width="1" bgcolor="#F3F3F3"></td>

        <td width="750" valign="top" class="table"><br>        





        	<div align="center">

            	<span class="subtitledblue1">Payment Details</span>

				<br>

              	<br>

  			</div>

  			

  			<div><a href="<?php echo base_url();?>home/payment_add">Add Payment Information</a></div>

  			

            <?php

            if( isset($all_list) && $all_list ){

            ?>
			
            <br /><br />
            <table width="700" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">

            	<tr>

            		<td>

            <table width="700" cellspacing="4" cellpadding="4" border="0" bgcolor="#FFFFFF">

				<tr>

                	<td>

                	

                	<table cellpadding="4" cellspacing="0" border="0" class="table" width="700">

                    <thead>

                       	<tr>

							<td><b>Date</b></td>

							<td><b>Test Type</b></td>

							<td><b>Sector</b></td>

							<td><b>User Type</b></td>

							<!--<th>No of Users</th>-->

							<td><b>Paid</b></td>

							<td><b>NEFT Transaction No</b></td>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    foreach($all_list as $K=>$V){

                    ?>

                    <tr>

                    	<td>                    

                    	<?php echo date('j-M-Y', strtotime($V['paid_date'])); ?>

                    	</td>


                    	<td>

                    	<?php

                        $info = $this->admin_model->get_test_type_details($V['test_type_id']);

                        if( $info!=false ){

                        	echo $info['title'];

                        }

                        ?>

                    	</td>

                    	<td>

                    	<?php

                        $info = $this->admin_model->get_sector_details($V['sector_id']);

                        if( $info!=false ){

                        	echo $info['title'];

                        }

                        ?>

                    	</td>

                    	<td>                    

                    	<?php

                    	if( $V['type']==USER_TYPE_INSTITUTIONAL ){

                    		echo 'Institutional';

                    	}

                    	elseif( $V['type']==USER_TYPE_CANDIDATE ){

                    		echo 'Candidates Applying for Jobs';

                    	}

                    	elseif( $V['type']==USER_TYPE_FRESHER ){

                    		echo 'Fresher\'s';

                    	}

                    	?>

                    	</td>

                    	<!--<td>                    

                    	<?php echo $V['user_count']; ?>

                    	</td>-->

                    	<td>                    

                    	<?php echo $V['paid']; ?>

                    	</td>


                    	<td>                    

                    	<?php echo $V['transaction_no']; ?>

                    	</td>

                    </tr>                          

                    <?php

					}

					?>

                    </tbody>

                    </table>

                   

                

					</td>

				</tr>

			</table>  

            

					</td>

				</tr>

			</table>

			<br>

            

            <div align="center">

            <span class="subtitle"> <?php echo $this->pagination->create_links(); ?></span><br>

            </div>

            <br><br>

            <?php

			}

            ?>

                          

		</td>

        <td width="250" align="center" valign="top">



        </td>

        <td width="1" bgcolor="#F3F3F3"></td>        

        </tr>

        </table>

