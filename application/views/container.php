<html>
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url();?>assets/css/ui-lightness/style.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.16.custom.min.js"></script>

<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>
<body bgcolor="#7f8081" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br><br>
<div align="center">
<table width="1040" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
  <tr>
    <td width="19">&nbsp;</td>
    <td width="1002" valign="top">
   <?php include_once "header.php";?>  

        <!-- central panel starts -->
        <?php 
		$showar = array('home', 'gk', 'online_test', 'msg', 'edit_profile', 'payment_details', 'payment_add', 'result_list', 'user_list', 'user_post_form');
		if(!empty($_SESSION['edu_uid']) && in_array($template,$showar)) { ?>
                <br>
        <table width="1002" border="0" cellspacing="0" cellpadding="0">
        <tr>
        
        <?php
        if( $_SESSION['edu_type']!=USER_TYPE_USER ){
        ?>
        <td><div align="center"><a href="<?php echo base_url();?>home/edit_profile" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image14','','<?php echo base_url();?>assets/images/profile_button1.jpg',1)"><img src="<?php echo base_url();?>assets/images/profile_button.jpg" alt="Edit your profile" name="Image14" width="220" height="50" border="0"></a></div></td>
        <td><div align="center"><a href="<?php echo base_url();?>home/message_centre" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image15','','<?php echo base_url();?>assets/images/msg_button1.jpg',1)"><img src="<?php echo base_url();?>assets/images/msg_button.jpg" alt="Message Centre" name="Image15" width="220" height="50" border="0"></a></div></td>
		<?php
		}
		if( $_SESSION['edu_type']!=USER_TYPE_USER && $_SESSION['edu_type']!=USER_TYPE_INSTITUTIONAL ){
		?>
        <td><div align="center"><a href="<?php echo base_url();?>home/payment_details" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image16','','<?php echo base_url();?>assets/images/payment_info1.jpg',1)"><img src="<?php echo base_url();?>assets/images/payment_info.jpg" alt="Message Centre" name="Image16" width="120" height="50" border="0"></a></div></td>
		<?php
		}
		
		if( $_SESSION['edu_type']!=USER_TYPE_INSTITUTIONAL ){
		?>
        <td><div align="center"><a href="<?php echo base_url();?>home/online_test" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image17','','<?php echo base_url();?>assets/images/onlinetest_button1.jpg',1)"><img src="<?php echo base_url();?>assets/images/onlinetest_button.jpg" alt="Online Test" name="Image17" width="120" height="50" border="0"></a></div></td>
        <?php
        }
        ?>
        <td><div align="center"><a href="<?php echo base_url();?>attemptTest/resultList" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image18','','<?php echo base_url();?>assets/images/result_button1.jpg',1)"><img src="<?php echo base_url();?>assets/images/result_button.jpg" alt="Result" name="Image18" width="120" height="50" border="0"></a></div></td>              
                
        
        <td><div align="center"><a href="<?php echo base_url();?>home/gk" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image19','','<?php echo base_url();?>assets/images/gk_button1.jpg',1)"><img src="<?php echo base_url();?>assets/images/gk_button.jpg" alt="GK Section" name="Image19" width="120" height="50" border="0"></a></div></td>
        

        <?php
        if( $_SESSION['edu_type']==USER_TYPE_INSTITUTIONAL ){
        ?>
        <td><div align="center"><a href="<?php echo base_url();?>user/listing" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image20','','<?php echo base_url();?>assets/images/user_button1.jpg',1)"><img src="<?php echo base_url();?>assets/images/user_button.jpg" alt="Users" name="Image20" width="120" height="50" border="0"></a></div></td>
        <?php
        }
        ?>
        </tr>
        </table>
        <?php } ?>
        <?php
		switch($template)
		{
			case 'index':
			include_once 'main_page.php';
			break;
			case 'register':
			include_once 'register.php';
			break;
			case 'login':
			include_once 'login.php';
			break;
			case 'forgot':
			include_once 'forgot_password.php';
			break;
			case 'home':
			include_once 'member_home.php';
			break;
			case 'gk':
			include_once 'gk.php';
			break;
			case 'online_test':
			include_once 'online_test.php';
			break;
			case 'msg':
			include_once 'msg_centre.php';
			break;
			case 'about':
			include_once 'about_us.php';
			break;
			case 'why':
			include_once 'other_details.php';
			break;
			case 'fee':
			include_once 'fee_details.php';
			break;
			case 'faq':
			include_once 'faq.php';
			break;
			case 'contact':
			include_once 'contact_us.php';
			break;
			case 'change_password':
			include_once 'change_password.php';
			break;
			case 'edit_profile':
			include_once 'edit_profile.php';
			break;
			case 'viewtest':
			include_once 'viewtest.php';
			break;	
			case 'restricted':
			include_once 'restricted.php';
			break;
			case 'attemptTest':
			include_once 'attemptTest.php';
			break;
			case 'submitTest':
			include_once 'submitTest.php';
			break;
			case 'view_success':
			include_once 'view_success.php';
			break;
			case 'result_list':
			include_once 'result_list.php';
			break;
			case 'career_pointer':
			include_once 'career_pointer.php';
			break;
			case 'career_pointer_section':
			include_once 'career_pointer_section.php';
			break;
			case 'result_view':
			include_once 'result_view.php';
			break;
			case 'result_section_view':
			include_once 'result_section_view.php';
			break;
			case 'view_result':
			include_once 'view_result_final.php';
			break;
			case 'reviewTest':
			include_once 'reviewTest.php';
			break;
			case 'all_results':
			include_once 'results.php';
			break;
			case 'unansTest':
			include_once 'unansTest.php';
			break;

			case 'payment_details':
			include_once 'payment_details.php';
			break;
			case 'payment_add':
			include_once 'payment_add.php';
			break;
			case 'user_list':
			include_once 'user_list.php';
			break;
			case 'user_post_form':
			include_once 'user_post_form.php';
			break;
		}
		?>
        <!-- center panel ends --> 
        <?php include "footer.php";?>
     </td>
    <td width="19">&nbsp;</td>    
  </tr>
</table>
<br><br>


</div>
</body>
</html> 