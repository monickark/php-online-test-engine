<?php $assets = base_url().'assets/admin/'; ?>
<?php include_once 'header.php';
	  include_once 'header_files.php';
?>
<!-- START OF MAIN CONTENT -->
    <div class="mainwrapper">
    
     	<div class="mainwrapperinner">
        <?php $this->load->view('admin/sidebar'); ?>
        
		<div class="maincontent <?php echo $right_bar;?>">
        	
            <?php $this->load->view($content); ?>
            
                <div class="footer">
            	<p>AONE®, STAR® and RESET®are registered software products developed by Impetus TechKnows®.<br /> All Rights Reserved. &copy; Impetus TechKnows® 2012-13. </p>
            </div><!--footer-->
            
        </div><!--maincontent-->
        
        <?php if(empty($right_bar)) { $this->load->view('admin/right_content'); } ?>
		
        </div><!--mainwrapperinner-->
    </div><!--mainwrapper-->
	<!-- END OF MAIN CONTENT -->

</body>
</html>