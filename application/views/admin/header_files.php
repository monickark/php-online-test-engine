	<!-- START OF HEADER -->
	<div class="header radius3">
    	<div class="headerinner">
        	
            <h1 style="height:37px;">ADMIN DASHBOARD - AONE TEST AND ASSESSMENT MANAGEMENT SYSTEM VER 1.0</h1>
<p> Strictly Restricted to Authorized Personnel Only.
            
            <?php
$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
			$latest_msgs = $this->admin_model->get_latest_msg(); 
			?>
              
            <div class="headright">
            	<div class="headercolumn">&nbsp;</div>
            	<!--<div id="searchPanel" class="headercolumn">
                	<div class="searchbox">
                        <form action="#" method="post">
                            <input type="text" id="keyword" name="keyword" class="radius2" value="Search here" /> 
                        </form>
                    </div>
                </div>--><!--headercolumn-->
                <?php if(!empty($latest_msgs)) { ?>
        <div id="notiPanel" class="headercolumn">
                    <div class="notiwrapper">
                        <a href="#" class="notialert radius2"><?php echo $this->admin_model->count_all_msgs();?></a>
                        <div class="notibox">
                            <h3>Recent Messages</h3>
                            <br clear="all" />
                            <div class="noticontent" style="display:block"><ul class="msglist" style="display:block;">
                            <?php foreach($latest_msgs as $val) { ?>
	<li class="message new">
        <div class="msg">
            From: <a href=""><?php echo $val['member_name'];?></a> <span><?php echo date('dS,M h:i A', $val['date']);?></span>
            <p><?php echo $val['msg'];?></p>
        </div>
    </li>
    <?php } ?>
   
</ul>
<div class="msgmore"><a href="<?php echo base_url();?>admin/msg_support">See All Messages</a></div></div>
                        </div>
                    </div>
                </div><!--headercolumn-->
                <?php } ?>
                <div id="userPanel" class="headercolumn">
                    <a href="#" class="userinfo radius2">
                        <img src="<?php echo $assets;?>images/avatar.png" alt="" class="radius2" />
                        <span><strong>Admin</strong></span>
                    </a>
                    <div class="userdrop">
                        <ul>
                            <li><a href="<?php echo base_url();?>admin/logout">Logout</a></li>
                        </ul>
                    </div><!--userdrop-->
                </div><!--headercolumn-->
            </div><!--headright-->
        
        </div><!--headerinner-->
	</div><!--header-->
    <!-- END OF HEADER -->