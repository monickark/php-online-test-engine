<style>

.onecol-style { font-family:Arial, Helvetica, sans-serif; font-size:12px; min-width:480px; text-align:left; border-collapse:collapse; margin-bottom:25px; margin-left:20px;}

.onecol-style th {font-size:14px; font-weight:normal; color:#666666; padding:12px 15px;}

.onecol-style td {color:#333; border-top:1px solid #ccc; padding:10px 15px;}

.onecol-first {background:#fafafa; border-right:10px solid transparent; border-left:10px solid transparent;}

.onecol-style tr:hover td {color:#444; background:#eee;}

a.btncss {

  width: 100px;

  padding: 10px 15px 10px 15px;

  font-family: Arial;

  font-size: 15px;

  text-decoration: none;

  color: #ffffff;

  text-shadow: -1px -1px 2px #618926;

  background: -moz-linear-gradient(#98ba40, #a6c250 35%, #618926);

  background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #98ba40),color-stop(.35, #a6c250),color-stop(1, #618926));

  border: 1px solid #618926;

  border-radius: 3px;

  -moz-border-radius: 3px;

  -webkit-border-radius: 3px;

  margin-bottom:50px;

}



a.btncss:hover {

  text-shadow: -1px -1px 2px #465f97;

  background: -moz-linear-gradient(#245192, #1e3b73 75%, #12295d);

  background: -webkit-gradient(linear,left top,left bottom,color-stop(0, #245192),color-stop(.75, #1e3b73),color-stop(1, #12295d));

  border: 1px solid #0f2557;

}

</style>

<table width="1002" border="0" cellspacing="0" cellpadding="0">

        <tr>

            <td width="1" bgcolor="#F3F3F3"></td>

            <td width="1000" valign="top"><br> 

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="subtitledblue1">Manage Users - <?php echo $this->pagination->total_rows.'/'.$_SESSION['edu_user_count']; ?> |
  	<?php if( $this->pagination->total_rows<$_SESSION['edu_user_count'] ){ ?><a href="<?php echo base_url();?>user/create">ADD USER</a><?php } ?></span>

<br /><br />


<table class="onecol-style" width="90%">

	<tr>

		<td bgcolor="#eeeeee" width="45">No</td>

		<td bgcolor="#eeeeee" width="76">Date</td>

		<td bgcolor="#eeeeee" width="73">Name</td>

		<td bgcolor="#eeeeee" width="56">ID</td>

		<td bgcolor="#eeeeee" width="71">Email</td>

		<td bgcolor="#eeeeee" width="94">Password</td>

		<td bgcolor="#eeeeee" width="74">Status</td>

		<td bgcolor="#eeeeee" width="75">Action</td>

	</tr>

	<?php

	if( $all_users ){

		foreach($all_users as $K=>$V){

	?>

	<tr>

		<td bgcolor="#ffffff"><?php echo $K+1; ?></td>

		<td bgcolor="#ffffff"><?php echo date('j M, Y', $V['date']); ?></td>

		<td bgcolor="#ffffff"><?php echo $V['name']; ?></td>

		<td bgcolor="#ffffff"><?php echo $V['candidate_id']; ?></td>

		<td bgcolor="#ffffff"><?php echo $V['email']; ?></td>

		<td bgcolor="#ffffff"><?php echo $V['password']; ?></td>

		<td bgcolor="#ffffff">

		<?php

		if( $V['status']==1 ){

			echo 'Active';

		}

		elseif( $V['status']==0 ){

			echo 'InActive';

		}

		?>

		</td>

		<td bgcolor="#ffffff">

		<a href="<?php echo base_url();?>user/edit/<?php echo $V['u_id'];?>">Edit</a>

		</td>

	</tr>

	<?php

		}

	}

	?>

</table>



<ul class="pagination">

                    <?php echo $this->pagination->create_links(); ?>

                    </ul>

	

    </td>

            


         <td width="1" bgcolor="#F3F3F3"></td>

        </tr>

        </table>