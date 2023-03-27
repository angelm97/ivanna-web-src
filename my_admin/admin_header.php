<?
if((strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.PATH_TO_ADMIN.FILENAME_ADMIN1_RATE_RESUMES) || (strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.PATH_TO_ADMIN.FILENAME_ADMIN1_JOBSEEKER_REPORTS) || (strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.PATH_TO_ADMIN.FILENAME_ADMIN1_RECRUITER_REPORTS) )
$body_load="onLoad=\"initOptionLists()\"";
elseif((strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.PATH_TO_ADMIN.FILENAME_ADMIN1_BANNER_MANAGEMENT))
$body_load="onLoad='set_type();'";
$_SESSION['language']='english';
$_SESSION['languages_id']='1';
if($_SESSION['languages_id']!=1)
tep_redirect(tep_href(PATH_TO_ADMIN.FILENAME_ADMIN1_CONTROL_PANEL));
$ADMIN_HEADER_HTML='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>'.SITE_TITLE.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="'.tep_href_link("css/admin_stylesheet.css").'">
<script src="'.tep_href_link("jscript/common.js").'"></script>
<script src="'.tep_href_link("jscript/page.js").'"></script>
<script src="'.tep_href_link("jscript/optionlist.js").'"></script>
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<script src="lib/jquery-1.10.2.min.js"></script>
    <script src="numscroller-1.0.js"></script>
    <script src="lib/prism.js"></script>
    <script src="'.HOST_NAME.'jscript/admin_js/error_success_message_timeout.js"></script>
</head>
<body  '.$body_load.'  >
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="middle_table2">
 <tr>
  <td valign="top" >';
if (strtolower($_SERVER['PHP_SELF'])!="/".PATH_TO_MAIN.PATH_TO_ADMIN.FILENAME_INDEX)
{
	 $ADMIN_HEADER_HTML.='
   <table border="0" width="100%" cellPadding="0" cellSpacing="0" height="43" class="admin-header">
    <tr valign="middle">
     <td><a href="'.tep_href_link(PATH_TO_ADMIN).'" class="admin_site_logo"><nobr>'.SITE_TITLE.'</nobr></a> '.((check_login("admin"))?'<a href="'.tep_href_link().'" target="_blank"><nobr><i class="fas fa-external-link-alt" style="font-size: 18px;color: #838f9a;margin: 0 0 0 50px;"></i> Visit Site</nobr></a>':'').'</td>


	 <td>
	 <ul class="profile-wrapper">
			<li>
				<!-- user profile -->
				<div class="profile">
					<nav>
        <ul>
            <li><a href="#" class="admin"><i class="fa fa-user profile-ico" aria-hidden="true"></i> Admin</a>
            <!-- First Tier Drop Down -->
            <ul>'.((check_login("admin"))?'
                <li><a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ACCOUNT) . '"><i class="fa fa-pencil" aria-hidden="true"></i> My Account</a></li>
                <li><a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_LOGOUT) . '"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a></li>
				':'').'
            </ul>        
            </li>
        </ul>
    </nav>
					
				</div>
			</li>
		</ul>
		
		    

	 </td>
    </tr>
   </table> <img src="../img/dot.gif" height="10" width="5">';
}

 $ADMIN_HEADER_HTML.='
   <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="middle_table1">
    <tr>
     <td valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"class="middle_table2">
       <tr>
        <td valign="top">';
?>