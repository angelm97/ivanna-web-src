<?
if(check_login("admin"))
{
 if(isset($_GET['jID']))
 {
  $session_array=array("sess_recruiterid"=>$_GET['rID'],"sess_recruiterlogin"=>"y");
  unset_session_value($session_array);
  if($row=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE,"jobseeker_id='".(int)tep_db_input($_GET['jID'])."'",'jobseeker_id'))
  {
   $session_array=array("sess_jobseekerid"=>$_GET['jID'],"sess_jobseekerlogin"=>"y");
   set_session_value($session_array);
  }
  else
  {
   $messageStack->add_session(MESSAGE_JOBSEEKER_ERROR, 'error');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_JOBSEEKERS,'selected_box=jobseekers'));
  }
 }
 else if($_GET['add']=='jobseeker')
 {
  $session_array=array("sess_jobseekerid"=>$_GET['jID'],"sess_jobseekerlogin"=>"y");
  unset_session_value($session_array);
 }
 else if(isset($_GET['rID']))
 {
  $session_array=array("sess_jobseekerid"=>$_GET['jID'],"sess_jobseekerlogin"=>"y");
  unset_session_value($session_array);
  if($row=getAnyTableWhereData(RECRUITER_TABLE,"recruiter_id='".(int)tep_db_input($_GET['rID'])."'",'recruiter_id'))
  {
   $session_array=array("sess_recruiterid"=>$_GET['rID'],"sess_recruiterlogin"=>"y");
   set_session_value($session_array);
  }
  else
  {
   $messageStack->add_session(MESSAGE_RECRUITER_ERROR, 'error');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_RECRUITERS,'selected_box=recruiters'));
  }
 }
 else if($_GET['add']=='recruiter')
 {
  $session_array=array("sess_recruiterid"=>$_GET['rID'],"sess_recruiterlogin"=>"y");
  unset_session_value($session_array);
 }
}
//////////////////////////////
$welcome_text='';
if(check_login('jobseeker'))
{
 if($row_11=getAnyTableWhereData(JOBSEEKER_TABLE," jobseeker_id ='".$_SESSION['sess_jobseekerid']."'","jobseeker_first_name,jobseeker_middle_name,jobseeker_last_name"))
 {
  $welcome_text=tep_db_output('Welcome,'.$row_11['jobseeker_first_name'].' '.$row_11['jobseeker_last_name']);
 }
}
else if(check_login('recruiter'))
{
 if($row_11=getAnyTableWhereData(RECRUITER_TABLE," recruiter_id ='".$_SESSION['sess_recruiterid']."'","recruiter_first_name,recruiter_last_name"))
 {
  $welcome_text=tep_db_output('Welcome,'.$row_11['recruiter_first_name'].' '.$row_11['recruiter_last_name']);
 }
}
else
{
 $welcome_text='Welcome,Guest';
}
if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_JOB_DETAILS)
{
$job_name=getAnyTableWhereData(JOB_TABLE," job_id ='".$_GET['query_string']."'","job_title,job_short_description");
$meta_title=$job_name['job_title']."/".SITE_TITLE;
$meta_description="<META NAME='Keywords' CONTENT='".$job_name['job_title']."'>
<META NAME='Description' CONTENT='".strip_tags($job_name['job_short_description'], '<a><b><i><u><>')."'>";
$meta_description.=$obj_title_metakeyword->metakeywords;
}
else
{
//print_r($obj_title_metakeyword);
$meta_title   = $obj_title_metakeyword->title;
$meta_description = $obj_title_metakeyword->metakeywords;
}
///////////////////////////////
if($_SESSION['language']=='spanish')
 include_once(dirname(__FILE__).'/language/spanish.php');
elseif($_SESSION['language']=='english')
 include_once(dirname(__FILE__).'/language/english.php');


//echo $_SESSION['language'];
$add_script='';
//autologin(); ///auto login
if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_JOBSEEKER_RESUME2)
{
 $add_script=' set_current_emp();';
}
$add_script_file='';
if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
	$add_script_file.='<script language="JavaScript">
<!--
function search_company(company_name)
{
 document.company_search.company_name.value=company_name;
 document.company_search.submit();
}
//-->
</script>';
}
else
{
 $add_script_file='<script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/optionlist.js").'"></script>';
 $add_script.='initOptionLists();';
}
$abs=strstr($_SERVER['REQUEST_URI'],'?');
$path1=(($abs)?(stristr($_SERVER['REQUEST_URI'],'language=')?substr($_SERVER['REQUEST_URI'],0,-2):$_SERVER['REQUEST_URI'].'&language='):$_SERVER['REQUEST_URI'].'?language=');
if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_RECRUITER_POST_JOB)
{
 $add_script.='show_hide();';
}
$header_banner=banner_display("3",1,380);

///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////CALL JOBSEEKER PIC, name & email ///////////////////////////////////////////////////////
///////////////////////////////////////////////

if(check_login("jobseeker"))
{
	 if($row=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE.' as jl, '.JOBSEEKER_TABLE.' as j',"jl.jobseeker_id='".$_SESSION['sess_jobseekerid']."' && jl.jobseeker_id=j.jobseeker_id","j.jobseeker_first_name,j.jobseeker_last_name"))
	{
		///////name and email
		$name=$row['jobseeker_first_name'].' '.$row['jobseeker_last_name'];
		///no of resumes
		$resume_query = tep_db_query("select distinct resume_id from " . JOBSEEKER_RESUME1_TABLE.' where jobseeker_id='.$_SESSION['sess_jobseekerid'] );
		$no_of_resumes= tep_db_num_rows($resume_query);
	}

		///find pic
		$resume_photo_check=getAnyTableWhereData(JOBSEEKER_RESUME1_TABLE,"jobseeker_id='".$_SESSION['sess_jobseekerid']."' and jobseeker_photo!='' ","jobseeker_photo,resume_id");

		$photo='';
		if(tep_not_null($resume_photo_check['jobseeker_photo']) && is_file(PATH_TO_MAIN_PHYSICAL_PHOTO.$resume_photo_check['jobseeker_photo']))
		{
			$photo = tep_image(FILENAME_IMAGE.'?image_name='.PATH_TO_PHOTO.$resume_photo_check['jobseeker_photo'],'','','','class="jobseeker-profile2 img-responsive photoMenu img-menu"');
		}
		else
			$photo='<img src="'.HOST_NAME.'image/no_pic.gif" class="img-menu jobseeker-profile2 img-responsive photoMenu">';

//call of premium membership
 $row=getAnyTableWhereData(JOBSEEKER_ACCOUNT_HISTORY_TABLE.' as jah',"jah.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and jah.start_date<=CURDATE() and jah.end_date >=CURDATE()",'jah.id,jah.order_id');

    $membership=(!tep_not_null($row['id'])?'
    <a class="dropdown-item font65" href="'.tep_href_link(FILENAME_JOBSEEKER_RATES).'">'.INFO_TEXT_HEADER_MIDDLE_PREMIUM_MEMBERSHIP.'
    </a>':'<a class="dropdown-item font30" href="'.tep_href_link(FILENAME_JOBSEEKER_ACCOUNT_HISTORY_INFO).'">'.INFO_TEXT_HEADER_MIDDLE_PREMIUM_MEMBERSHIP.'
    </a>');
}
elseif(check_login("recruiter"))
{
	 if($row=getAnyTableWhereData(RECRUITER_LOGIN_TABLE.' as rl, '.RECRUITER_TABLE.' as r',"rl.recruiter_id='".$_SESSION['sess_recruiterid']."' && rl.recruiter_id=r.recruiter_id","r.recruiter_first_name,r.recruiter_last_name,r.recruiter_logo"))
	{
		///////name and email
		$name=$row['recruiter_first_name'].' '.$row['recruiter_last_name'];
		$photo='';
		if(tep_not_null($row['recruiter_logo']) && is_file(PATH_TO_MAIN_PHYSICAL_LOGO.$row['recruiter_logo']))
			$photo =tep_image(FILENAME_IMAGE.'?image_name='.PATH_TO_LOGO.$row['recruiter_logo'],'','','','class="img-menu jobseeker-profile2 img-responsive photoMenu"');
		else
			$photo='<img src="'.HOST_NAME.'image/no_pic.gif" class="img-menu jobseeker-profile2 img-responsive photoMenu">';
		///no. of jobs posted
		$resume_query = tep_db_query("select distinct job_id from " . JOB_TABLE.' where recruiter_id='.$_SESSION['sess_recruiterid'] );
		$no_of_resumes= tep_db_num_rows($resume_query);
	}
	else
		$photo='<img src="'.HOST_NAME.'image/no_pic.gif" class="img-menu img-menu jobseeker-profile2 img-responsive photoMenu">';
}
else//if neither recruiter nor jobseeker
{
$photo='';
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////JObseeker or recruiter cpanel display//////////////////////////////////////////////////////////////////
if(check_login("jobseeker"))
{	$jobrec_profilemenu='
    <!-- Top Profile Pictures-->

    <li class="nav-item dropdown m-mb-12">
    <a class="nav-link img-margin dropdown-toggle photoMenu" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$photo.'</a>
    <div class="dropdown-menu dropdown-menu-right w100" aria-labelledby="dropdown01">
        <div class="media p-0">
           <div class="media-body">
            <h5 class="mt-0 px-3 mb-2 font65">'.$name.'</h5>
          </div>
        </div>
		<div class="dropdown-divider"></div>
      <a class="dropdown-item font65" href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL).'">'.INFO_TEXT_HM_JOBSEEKER_CONTROL_PANEL.'</a>
      <div class="dropdown-divider"></div>
	  <a class="dropdown-item font65" href="'.tep_href_link(FILENAME_JOB_SEARCH).'">'.INFO_TEXT_HM_JOB_SEARCH.'</a>
      <div class="dropdown-divider"></div>
	  <a class="dropdown-item font65" href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_RESUMES).'">'.INFO_TEXT_HM_MY_RESUMES.'</a>
      <div class="dropdown-divider"></div>
	  <a class="dropdown-item font65" href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">'.INFO_TEXT_EDIT_PROFILE.'</a>
      <div class="dropdown-divider"></div>
	  '.$membership.'
	  <div class="dropdown-divider"></div>
      <a class="dropdown-item font65" href="'.tep_href_link(FILENAME_LOGOUT).'">'.INFO_TEXT_HM_LOGOUT.'</a>
    </div>
  </li>
   <!-- Top Profile Pictures End-->


';
}
elseif(check_login("recruiter"))
{ $jobrec_profilemenu='
            <!-- Top Profile Pictures recruiter-->

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle img-margin" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$photo.'</a>
    <div class="dropdown-menu dropdown-menu-right w100r" aria-labelledby="dropdown01">
        <div class="media p-0">
           <div class="media-body">
            <h5 class="mt-0 px-3 mb-2 font45">'.$name.'</h5>
          </div>
        </div>
		<div class="dropdown-divider"></div>
        <a class="dropdown-item font45" href="'.tep_href_link(FILENAME_RECRUITER_CONTROL_PANEL).'">'.INFO_TEXT_HM_RECRUITER_CONTROL_PANEL.'</a>
        <div class="dropdown-divider"></div>
		<a class="dropdown-item font45" href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'">'.INFO_TEXT_HM_RESUME_SEARCH.'</a>
        <div class="dropdown-divider"></div>
		<a class="dropdown-item font45" href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'">'.INFO_TEXT_HM_POST_JOB.'</a>
        <div class="dropdown-divider"></div>
		<a class="dropdown-item font45" href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">'.INFO_TEXT_EDIT_PROFILE.'</a>
        <div class="dropdown-divider"></div>
		<a class="dropdown-item font45" href="'.tep_href_link(FILENAME_LOGOUT).'">'.INFO_TEXT_HM_LOGOUT.'</a>
    </div>
  </li>
<!-- Top Profile Pictures End-->


';
}
else {$jobrec_profilemenu='';}


//***************COOKIE ALERT POPUP CODE *****************************************************/
if(COOKIE_ALERT_POPUP=='true')
	$cookie_alert_popup='
    <!-- /.container -->
<div class="alert-warning alert-dismissible fade text-center cookiealert cookiealert2" role="alert">
<strong>Cookies:</strong>  ¡Hola! Nuestro sitio de internet utiliza cookies para mejorar tu experiencia. Si continúas navegando, consideramos que aceptas su uso :) También puedes cambiar la configuración u obtener más información aquí:<a href="'.tep_href_link(FILENAME_PRIVACY).'" target="_blank"> Leer más</a>
<button   class="btn btn-secondary btn-sm acceptcookies" aria-label="Close">OK, ACEPTO</button>
</div>
';
else
$cookie_alert_popup='';
///////////////////////////////////////////////////////////////////////////////////////////////////

//---------------------------------------------------------------------------------------------------------//
//------------------------different header for internal page and for home page  begins-------------------

define('HEADER_HTML','
<!DOCTYPE html>
    <html lang="en">
        <head>

        <meta property="og:title" content="Waojobs">
        <meta property="og:description" content=" ">
        <meta property="og:image" content="https://waojobs.com/img/logo.png">
        <meta property="og:url" content="https://waojobs.com/">

            <meta>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>'.$meta_title.'</title>
            <meta http-equiv="Content-Type" >
            <meta charset="UTF-8">
        '.$meta_description.'
        <link rel="icon" href="'.HOST_NAME.'img/favicon.png" type="png" sizes="16x16">

        <link rel="stylesheet" type="text/css" href="'.tep_href_link("css/animate.css").'">
        <link rel="stylesheet" type="text/css" href="'.tep_href_link("css/animate.min.css").'"> 
        <link rel="stylesheet" type="text/css" href="'.tep_href_link("select2/select2.min.css").'"> 
    
        <!--bootstrap5-->
        <link rel="stylesheet" href="'.tep_href_link("css/bootstrap5.min.css").'">
    
        <!--font-awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

        <!-- alert sweet -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!--main style css-->
        <link rel="stylesheet" type="text/css" href=" '.tep_href_link("css/style.css").'">
       <link rel="stylesheet" type="text/css" href="'.tep_href_link("css/media.css").'">

        
        <link rel="stylesheet" type="text/css" href="'.tep_href_link("css/bootstrap.min.css").'">
        <link rel="stylesheet" type="text/css" href="'.tep_href_link("fonts/font-awesome.min.css").'">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800;900&family=Suez+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="'.tep_href_link("css/custom.css").'">
        <link rel="stylesheet" type="text/css" href="'.tep_href_link("css/fix.css").'">
        <link rel="stylesheet" type="text/css" href="'.tep_href_link("css/responsive.css").'">
        <link rel="stylesheet" href="'.tep_href_link("css/cookiealert.css").'">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
		<link rel="stylesheet" type="text/css" href="'.tep_href_link("themes/waojobs/css/theme5.css").'">
        '.$add_script_file.'
        <script language="JavaScript" type="text/JavaScript">
        function body_load()
        {
        '.$add_script.'
        }
        </script>
        <script>
            $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll > 70) {
                $(".navbar-inverse").addClass("active");
            }
            else {
                $(".navbar-inverse").removeClass("active");
            }
            });
        </script>
        <!-- cookiealert.css -->
        <link rel="stylesheet" href="'.tep_href_link("css/cookiealert.css").'">
        <script language="javascript" type="text/javascript" src="'.tep_href_link("themes/theme5/tab.js").'"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            
    </head>

    <body onLoad="body_load();">
    '.$cookie_alert_popup.'


    <nav class="navbar navbar-expand-lg navbar-light bg-light p-0">


    <div class="container d-none d-lg-block">

        <button class="navbar-toggler fontt-m"   data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mx-auto" style="align-items: center;">

                <li class="nav-item">
                    <!--<a class="nav-link" href="'.tep_href_link(FILENAME_JOB_SEARCH).'"  >'.INFO_TEXT_MENU_JOBS.'</a>-->
                    <a class="nav-link font30" href="'.tep_href_link("").'"  >Inicio</a>
                </li>

                <li class="nav-item">
                <!--<a class="nav-link" href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'"  >'.INFO_TEXT_MENU_POST_JOB.'</a>-->
                    <a class="nav-link font30" href="'.tep_href_link(FILENAME_ABOUT_US).'"  >Quiénes somos</a>
                </li>

                <li style="margin: 16px 0 0 0;">
                <a class="navbar-brand font30" href="'.tep_href_link("").'" style="padding:0;">
                <img src="'.tep_href_link('img/'.DEFAULT_SITE_LOGO).'" alt="Jobboard Logo" class="internal-logo">
            </a>
                </li>
			<li><a class="nav-link font30"  href="'.tep_href_link(FILENAME_ARTICLE).'"  >Recursos</a></li>
                <li class="m-mb-12">
                '.(check_login("jobseeker") || check_login("recruiter")?'':'
                <a class="nav-link" href="'.tep_href_link(FILENAME_LOGIN).'"  >Iniciar sesión</a>').'

            '.$jobrec_profilemenu.'
                </li>



            </ul>


        </div>

    </div>

    <!--  /////////////////////////////////////////////////// -->

    <!--  menu para el movil -->

    <div class="container d-block d-lg-none full-max-width" style="margin:0px; padding:0px;">
      <div class="col-12 rounded row full-max-width" style="background: #000080; border_radius: 2px; height: 75px; margin:0px; padding:0px;">
        <div class="col-3">
         <a href="/index.php"> <img src="'.tep_href_link('img/'.DEFAULT_SITE_LOGO).'" alt="Jobboard Logo" class="internal-logo" style="margin-top: 14px; margin-left:5px" width="80px" height="50px"> </a>

        </div>

        <div class="col-7">

          '.(check_login("jobseeker") || check_login("recruiter")?'':'
            <button   class="btn btn-light float-right" style="border-radius: 45px; margin-top:18px !important; max-width: 150px; max-height: 40px;">  <a class="nav-link" href="'.tep_href_link(FILENAME_LOGIN).'" style="font-size: 15px !important; padding:0px;"  >Iniciar sesión</a> </button>').'
            <div class="float-right">'.$jobrec_profilemenu.' </div>

        </div>
        <div class="col-2">
        <button class="text-white navbar-toggler " style="font-size: 35px; margin-top:14px; margin-rigth:16px;"   data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        </div>

      </div>

        <div class="collapse  row col-12" id="navbarNavDropdown">
        <div class="col-12">
            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <!--<a class="nav-link" href="'.tep_href_link(FILENAME_JOB_SEARCH).'"  >'.INFO_TEXT_MENU_JOBS.'</a>-->
                    <a class="nav-link font65" href="'.tep_href_link("").'"  >Inicio</a>
                </li>

                <li class="nav-item">
                <!--<a class="nav-link" href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'"  >'.INFO_TEXT_MENU_POST_JOB.'</a>-->
                    <a class="nav-link font65" href="'.tep_href_link(FILENAME_ABOUT_US).'"  >Quiénes somos</a>
                </li>

                
			<li><a class="nav-link font65"  href="'.tep_href_link(FILENAME_ARTICLE).'"  >Recursos</a></li>

            </ul>


        </div>

        </div>

    </div>

    </nav>

');
?>
