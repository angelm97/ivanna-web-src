<?
/*
***********************************************************
**********# Name          : Shambhu Prasad Patnaik   #*****
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
***********************************************************
*/
include_once("include_files.php");
include_once("general_functions/password_funcs.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_LOGIN);
include_once(FILENAME_BODY);
$jscript_file=PATH_TO_LANGUAGE.$language."/jscript/".'login.js';
$template->set_filenames(array('login' => 'login.htm'));

$u=(isset($_GET['u'])?$_GET['u']:0);
//echo $u;

//// Jobseeker auto login starts //////
$checked1=false;
$checked2=false;
$encoded_login1=$_COOKIE["autologin1"];
$encoded_login2=$_COOKIE["autologin2"];
//echo $encoded_login1;
//echo $encoded_login2;
if(tep_not_null($encoded_login1))
{
 $checked1=true;
 $explode_array=explode("|",decode_string($encoded_login1));
 $TREF_email_address1=$explode_array[0];
 $TR_password1=$explode_array[1];
}
else
{
  $TREF_email_address1="";
 $TR_password1='';
}
if(tep_not_null($encoded_login2))
{
 $checked2=true;
 $explode_array=explode("|",decode_string($encoded_login2));
 $TREF_email_address2=$explode_array[0];
 $TR_password2=$explode_array[1];
}
else
{
 $TREF_email_address2="";
 $TR_password2='';
}
//// Jobseeker auto login ends //////

///////DEFINE VALUES//////////////////////////////////////////////////
$button1=tep_draw_submit_button_field('login1',INTO_LOG_IN,'class="btn btn-block btn-primary  mt-3"');
$button2=tep_draw_submit_button_field('login2',INTO_LOG_IN,'class="btn btn-primary btn-block mt-3"');
$NEW_USER_REGISTER_NOW1='<a href="' . tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'"  class="mt-1 btn btn-block btn-secondary">'.INFO_TEXT_REGISTER_NOW1.'</a>';
$NEW_USER_REGISTER_NOW2='<a href="' . tep_href_link(FILENAME_RECRUITER_REGISTRATION).'" class="mt-1 btn btn-block btn-secondary">'.INFO_TEXT_REGISTER_NOW2.'</a>';
$FORGOT_PASSWORD1='<a href="'.tep_href_link(FILENAME_JOBSEEKER_FORGOT_PASSWORD).'">'.INFO_TEXT_FORGOT_PASSWORD1.'</a>';
$FORGOT_PASSWORD2='<a href="' . tep_href_link(FILENAME_RECRUITER_FORGOT_PASSWORD).'">'.INFO_TEXT_FORGOT_PASSWORD2.'</a>';
$AUTO_LOGIN1=tep_draw_checkbox_field('auto_login1','on', $checked1,'','id="auto_login1" class="mr-1"').'<label for="auto_login1">'.AUTO_LOGIN1.'<label>';
$AUTO_LOGIN2=tep_draw_checkbox_field('auto_login2','on', $checked2,'','id="auto_login2" class="mr-1"').'<label for="auto_login2" >'.AUTO_LOGIN2.'<label>';
$form1=tep_draw_form('js_login', FILENAME_JOBSEEKER_LOGIN,'','post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','check');
$form2=tep_draw_form('rec_login', FILENAME_RECRUITER_LOGIN,'','post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','check');

$social_login_button1='';
if(!check_login("jobseeker"))
{
 if(MODULE_FACEBOOK_PLUGIN=='enable' && MODULE_FACEBOOK_PLUGIN_JOBSEEKER=='enable')
 $social_login_button1.=' <a href="'.FILENAME_FACEBOOK_APPLICATION.'" title="Sign in with Facebook"><img src="img/facebook.png" alt="Facebook"></a>';

 if(MODULE_GOOGLE_PLUGIN=='enable' && MODULE_GOOGLE_PLUGIN_JOBSEEKER=='enable')
 $social_login_button1.=' <a href="'.FILENAME_GOOGLE_APPLICATION.'" title="Sign in with Google"><img src="img/google.png" alt="Google"></a>';

 if(MODULE_LINKEDIN_PLUGIN=='enable' && MODULE_LINKEDIN_PLUGIN_JOBSEEKER=='enable')
 $social_login_button1.=' <a href="'.FILENAME_LINKEDIN_APPLICATION.'" title="Sign in with Linkedin"><img src="img/linkedin.png" alt="Linkedin"></a>';

 if(MODULE_TWITTER_PLUGIN_JOBSEEKER=='enable' && MODULE_TWITTER_SUBMITTER_OAUTH_CONSUMER_KEY!='')
 $social_login_button1.=' <a href="'.FILENAME_TWITTER_APPLICATION.'" title="Sign in with Twitter"><img src="img/twitter.png" alt="Twitter"></a>';
}
$social_login_button2='';
if(!check_login("recruiter"))
{
 if(MODULE_FACEBOOK_PLUGIN=='enable' && MODULE_FACEBOOK_PLUGIN_RECRUITER=='enable')
 $social_login_button2.=' <a href="'.FILENAME_FACEBOOK_APPLICATION.'?user_type=recruiter" title="Sign in with Facebook"><img src="img/facebook.png" alt="Facebook"></a>';
 if(MODULE_GOOGLE_PLUGIN=='enable' && MODULE_GOOGLE_PLUGIN_RECRUITER=='enable')
 $social_login_button2.=' <a href="'.FILENAME_GOOGLE_APPLICATION.'?user_type=recruiter" title="Sign in with Google"><img src="img/google.png" alt="Google"></a>';
 if(MODULE_LINKEDIN_PLUGIN=='enable' && MODULE_LINKEDIN_PLUGIN_RECRUITER=='enable')
 $social_login_button2.=' <a href="'.FILENAME_LINKEDIN_APPLICATION.'?user_type=recruiter" title="Sign in with Linkedin"><img src="img/linkedin.png" alt="Linkedin"></a>';
 if( MODULE_TWITTER_PLUGIN_RECRUITER=='enable' && MODULE_TWITTER_SUBMITTER_OAUTH_CONSUMER_KEY!='')
 $social_login_button2.=' <a href="'.FILENAME_TWITTER_APPLICATION.'?user_type=recruiter" title="Sign in with Twitter"><img src="img/twitter.png" alt="Twitter"></a>';
}
/////////////////////////////////////////////////////////////////////
if($u==0)
{	$heading_title1=HEADING_TITLE1;
	$heading_title2=HEADING_TITLE2;
	$area1=''.$form1.
                    // tep_draw_input_field('TREF_email_address1', $TREF_email_address1,'class="form-control mb-2"',false).
										// tep_draw_password_field('TR_password1', $TR_password1,false, 'class="form-control mb-2"').
                    //                     $AUTO_LOGIN1.
                    //                       $button1.'
                    // <p class="py-3 text-center">'.$FORGOT_PASSWORD1.'</p>
                    // <hr>

                    // <div class="d-block text-center">Or Login with</div>

                    // '.$social_login_button.'<div class="text-center d-block">Don\'t have an account?</div>'.$NEW_USER_REGISTER_NOW1.'
                    //                     </form>';
                    '<div class="col-md-12">
                    <div class="form-group">'
                    . tep_draw_input_field('TREF_email_address1', $TREF_email_address1,'class="form-control mb-2"',false).
                    tep_draw_password_field('TR_password1', $TR_password1,false, 'class="form-control mb-2"').
                    '</div>
                    <div class="form-group mb-2">
                    <div class="custom-checkbox">'
                    .$AUTO_LOGIN1.

                    '</div>
                    <div class="text-center">'.
                    $button1.
                    '</div>
                    <div class="text-center mt-2">'.
                    $FORGOT_PASSWORD1.
                    '</div>
                    <div class="orloginwith d-block text-center mt-1">'.INFO_LOGIN_WITH.'</div>
                    <div>'.$social_login_button1.'</div>

                    <div class="orloginwith d-block text-center mt-4">'.INFO_NO_ACCOUNT.'</div>'
                    .$NEW_USER_REGISTER_NOW1.'
                    </div>
                    </form>
                    </div>';

    $area2=''.$form2
  //                   .tep_draw_input_field('TREF_email_address2', $TREF_email_address2,'class="form-control mb-2"',false).
  //                   tep_draw_password_field('TR_password2', $TR_password2,false, 'class="form-control mb-2"').
  // $AUTO_LOGIN2.
  // $button2.'
  // <p class="py-3 text-center">'.$FORGOT_PASSWORD2.'</p>
  // <hr>


  //   <div class="text-center d-block">Or Login with</div>'.$social_login_button2.'
  //   <div class="text-center d-block">'.INFO_NO_ACCOUNT.'</div>'.$NEW_USER_REGISTER_NOW2.'
  //                           </form>';

                          .'<div class="col-md-12">
                          <div class="form-group">'
                          . tep_draw_input_field('TREF_email_address2', $TREF_email_address2,'class="form-control mb-2"',false).
                            tep_draw_password_field('TR_password2', $TR_password2,false, 'class="form-control mb-2"').
                          '</div>
                          <div class="form-group mb-2">

                          <div class="custom-checkbox">'
                          .$AUTO_LOGIN2.

                          '</div>
                          <div class="text-center">'.
                          $button2.
                          '</div>
                          <div class="text-center mt-2">'.
                          $FORGOT_PASSWORD2.
                          '</div>
                          <div class="orloginwith d-block text-center mt-1">'.INFO_LOGIN_WITH.'</div>
                          <div>'.$social_login_button2.'</div>

                          <div class="orloginwith d-block text-center mt-4">'.INFO_NO_ACCOUNT.'</div>'
                          .$NEW_USER_REGISTER_NOW2.'
                          </div>
                          </form>
                          </div>';

    }
else
{
	$heading_title1=HEADING_TITLE2;
	$heading_title2=HEADING_TITLE1;
	$area1=''.$form2.
                    // tep_draw_input_field('TREF_email_address2', $TREF_email_address2,'class="form-control mb-2"',false).
										// tep_draw_password_field('TR_password2', $TR_password2,false, 'class="form-control mb-2"').
                    //                      $AUTO_LOGIN2.
                    //                       $button2.'
                    //                         <div class="text-center">'.$FORGOT_PASSWORD2.'</div>
                    //                         <hr>
                    //   <div class="orloginwith d-block">'.INFO_LOGIN_WITH.'</div>'.$social_login_button2.'
                    // <div class="orloginwith d-block">'.INFO_NO_ACCOUNT.'</div>
                    //                               '.$NEW_USER_REGISTER_NOW2.'
                    //                       </form>';
                    '<div class="col-md-12">
                      <div class="form-group">'
                      . tep_draw_input_field('TREF_email_address2', $TREF_email_address2,'class="form-control mb-2 inputlogin"',false).
                        tep_draw_password_field('TR_password2', $TR_password2,false, 'class="form-control mb-2 inputlogin"').
                      '</div>
                      <div class="form-group mb-2">

                      <div class="custom-checkbox font22">'
                      .$AUTO_LOGIN2.

                      '</div>
                      <div class="text-center">'.
                      $button2.
                      '</div>
                      <div class="text-center mt-2">'.
                      $FORGOT_PASSWORD2.
                      '</div>
                      <div class="orloginwith d-block text-center mt-1 font22">'.INFO_LOGIN_WITH.'</div><div>'
                      .$social_login_button2.'</div>

                      <div class="orloginwith d-block text-center mt-4 font22" >'.INFO_NO_ACCOUNT.'</div>'
                      .$NEW_USER_REGISTER_NOW2.'
                      </div>
                      </form>
                      </div>';

	$area2=''.$form1
                      //                      .tep_draw_input_field('TREF_email_address1', $TREF_email_address1,'class="form-control mb-2"',false).
                      //                       tep_draw_password_field('TR_password1', $TR_password1,false, 'class="form-control mb-2"').
                      //                       $AUTO_LOGIN1.
                      //                       $button1.'
                      // <div class="mt-3 text-center">'.$FORGOT_PASSWORD1.'</div>
                      //  <hr>

                      //    <div class="orloginwith d-block">'.INFO_LOGIN_WITH.'</div>'.$social_login_button.'<div class="orloginwith">Don\'t have an account?</div>'.$NEW_USER_REGISTER_NOW1.'
                      //                     </form>';
                      .'<div class="col-md-12">
                      <div class="form-group">'
                      . tep_draw_input_field('TREF_email_address1', $TREF_email_address1,'class="form-control mb-2 inputlogin"',false).
                      tep_draw_password_field('TR_password1', $TR_password1,false, 'class="form-control mb-2 inputlogin"').
                      '</div>
                      <div class="form-group mb-2">
                      <div class="custom-checkbox font22">'
                      .$AUTO_LOGIN1.

                      '</div>
                      <div class="text-center">'.
                      $button1.
                      '</div>
                      <div class="text-center mt-2">'.
                      $FORGOT_PASSWORD1.
                      '</div>
                      <div class="orloginwith d-block text-center mt-1">'.INFO_LOGIN_WITH.'</div><div>'
                      .$social_login_button1.'</div>

                      <div class="orloginwith d-block text-center mt-4">'.INFO_NO_ACCOUNT.'</div>'
                      .$NEW_USER_REGISTER_NOW1.'
                      </div>
                      </form>
                      </div>';
}
//////////////////////////////////////////////////////////////////////




$action = (isset($_POST['action']) ? $_POST['action'] : '');

if ($action=='check' && $u==0)
{
 $jobseeker_email_address=tep_db_prepare_input($_POST['TREF_email_address1']);
	$jobseeker_password=$_POST['TR_password1'];
	$whereClause="jl.jobseeker_email_address='".tep_db_input($jobseeker_email_address)."' and jl.jobseeker_status='Yes' and jl.jobseeker_id=j.jobseeker_id";
 $fields='jl.jobseeker_id,concat(j.jobseeker_first_name," ",j.jobseeker_last_name) as name,jl.jobseeker_email_address,jl.jobseeker_password,jl.ip_address,jl.number_of_logon';
	if($row=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE.' as jl, '.JOBSEEKER_TABLE.' as j',$whereClause,$fields,false))
	{
  if(!tep_validate_password($jobseeker_password, $row['jobseeker_password']))
  {
   $messageStack->add(SORRY_LOGIN_MATCH, 'error');
  }
  else
  {
			$redirect_url=(tep_not_null($_SESSION['REDIRECT_URL'])?HOST_NAME_MAIN.$_SESSION['REDIRECT_URL']:'');
   $ip_address=$_SERVER['REMOTE_ADDR'];
   $last_ip_address=tep_db_prepare_input($row['ip_address']);
   $number_of_logon=$row['number_of_logon']+1;
   $sql_data_array = array('last_login_time' => 'now()',
                           'ip_address' => $ip_address,
                           'last_ip_address' => $last_ip_address,
                           'number_of_logon' => $number_of_logon);
   tep_db_perform(JOBSEEKER_LOGIN_TABLE, $sql_data_array, 'update', "jobseeker_id = '" . $row['jobseeker_id'] . "'");
   $language=$_SESSION['language'];
			$language_id=$_SESSION['languages_id'];
   @session_unset($_SESSION);
   @session_destroy($_SESSION);

   /////////for Cookie ///
   @SetCookie("autologin1", "", 0);
   @SetCookie("autologin2", "", 0);
   if(isset($_POST['auto_login1']))//start if4
   {
    //set login to expire in 1 day
    srand((double) microtime() * 1000000);
    $encoded_login=encode_string($jobseeker_email_address."|");
    @SetCookie("autologin1", $encoded_login, time() + ( 24 * 3600 * 365 ));
   }
   ////////
   $_SESSION['sess_jobseekername']=tep_db_output($row['name']);
   $_SESSION['sess_jobseekerlogin']="y";
   $_SESSION['sess_jobseekerid']=$row["jobseeker_id"];
			$_SESSION['language']=$language;
			$_SESSION['languages_id']=$language_id;
   if(tep_not_null($redirect_url))
			{
 	  tep_redirect($redirect_url);
			}
			else
			{
	   tep_redirect(FILENAME_JOBSEEKER_CONTROL_PANEL);
			}
  }
	}
	else
	{
  $messageStack->add(SORRY_LOGIN_MATCH, 'error');
	}
} //end jobseeker //////////////check/////////////////////////////////////////////////////////////////////////////////////////////
/////******************************************************************************///////////
elseif ($action=='check' && $u==1)
 //recruiter check begins
{
 $recruiter_email_address=tep_db_prepare_input($_POST['TREF_email_address2']);
$recruiter_password=$_POST['TR_password2'];
	$whereClause="rl.recruiter_email_address='".tep_db_input($recruiter_email_address)."' and rl.recruiter_status='Yes' and rl.recruiter_id=r.recruiter_id";
 $fields='rl.recruiter_id,concat(r.recruiter_first_name," ",r.recruiter_last_name) as name,rl.recruiter_email_address,rl.recruiter_password,rl.ip_address,rl.number_of_logon';
	if($row=getAnyTableWhereData(RECRUITER_LOGIN_TABLE.' as rl, '.RECRUITER_TABLE.' as r',$whereClause,$fields))
	{
  if(!tep_validate_password($recruiter_password, $row['recruiter_password']))
  {
   $messageStack->add(SORRY_LOGIN_MATCH, 'error');
  }
  else
  {
    $_SESSION["hash_login"] = date("his") . rand(1,1000);
    $sql_data_array_logout = [
      "status_log" => $_SESSION["hash_login"]
  ];
  
  tep_db_perform('recruiter', $sql_data_array_logout, 'update',"recruiter_id='".$row['recruiter_id']."'");

			$redirect_url=(tep_not_null($_SESSION['REDIRECT_URL'])?HOST_NAME_MAIN.$_SESSION['REDIRECT_URL']:'');
   $ip_address=$_SERVER['REMOTE_ADDR'];
   $last_ip_address=tep_db_prepare_input($row['ip_address']);
   $number_of_logon=$row['number_of_logon']+1;
   $sql_data_array = array('last_login_time' => 'now()',
                           'ip_address' => $ip_address,
                           'last_ip_address' => $last_ip_address,
                           'number_of_logon' => $number_of_logon);
			$language=$_SESSION['language'];
			$language_id=$_SESSION['languages_id'];
			//print_r($_SESSION);die();
   tep_db_perform(RECRUITER_LOGIN_TABLE, $sql_data_array, 'update', "recruiter_id = '" . $row['recruiter_id'] . "'");
   @session_unset($_SESSION);
   @session_destroy($_SESSION);

   /////////for Cookie ///
   @SetCookie("autologin1", "", 0);
   @SetCookie("autologin2", "", 0);
   if(isset($_POST['auto_login2']))//start if4
   {
    //set login to expire in 1 day
    srand((double) microtime() * 1000000);
    $encoded_login=encode_string($recruiter_email_address."|");
    @SetCookie("autologin2", $encoded_login, time() + ( 24 * 3600 * 365 ));
   }
   ////////
   $_SESSION['sess_recruiterlogin']="y";
   $_SESSION['sess_recruiterid']=$row["recruiter_id"];
   $_SESSION['language']=$language;
			$_SESSION['languages_id']=$language_id;
			if(tep_not_null($redirect_url))
			{
 	  tep_redirect($redirect_url);
			}
			else
			{
	   tep_redirect(FILENAME_RECRUITER_CONTROL_PANEL);
			}
  }
	}
 else if($row=getAnyTableWhereData(RECRUITER_USERS_TABLE,"email_address='".tep_db_input($recruiter_email_address)."' and status='Yes'","id,recruiter_id,name,email_address,password,ip_address,number_of_logon"))
	{
  if(!tep_validate_password($recruiter_password, $row['password']))
  {
   $messageStack->add(SORRY_LOGIN_MATCH, 'error');
  }
  else
  {
   $ip_address=$_SERVER['REMOTE_ADDR'];
   $last_ip_address=tep_db_prepare_input($row['ip_address']);
   $number_of_logon=$row['number_of_logon']+1;
   $sql_data_array = array('last_login_time' => 'now()',
                           'ip_address' => $ip_address,
                           'last_ip_address' => $last_ip_address,
                           'number_of_logon' => $number_of_logon);
			tep_db_perform(RECRUITER_USERS_TABLE, $sql_data_array, 'update', "id = '" . $row['id'] . "'");
			$language=$_SESSION['language'];
			$language_id=$_SESSION['languages_id'];
   @session_unset($_SESSION);
   @session_destroy($_SESSION);

   /////////for Cookie ///
   @SetCookie("autologin1", "", 0);
   @SetCookie("autologin2", "", 0);
   if(isset($_POST['auto_login2']))//start if4
   {
    //set login to expire in 1 day
    srand((double) microtime() * 1000000);
    $encoded_login=encode_string($recruiter_email_address."|");
    @SetCookie("autologin2", $encoded_login, time() + ( 24 * 3600 * 365 ));
   }
   ////////
   $_SESSION['sess_recruiterlogin']="y";
   $_SESSION['sess_recruiterid']=$row["recruiter_id"];
   $_SESSION['sess_recruiteruserid']=$row["id"];
		 $_SESSION['language']=$language;
			$_SESSION['languages_id']=$language_id;
   tep_redirect(FILENAME_RECRUITER_CONTROL_PANEL);
  }
 }
	else
	{
  $messageStack->add(SORRY_LOGIN_MATCH, 'error');
	}
}// recruiter check end



$template->assign_vars(array(
'INFO_TEXT_JSCRIPT_FILE1'  => $jscript_file,
//'INFO_TEXT_SOCIAL_LOGIN_BUTTON1'=>$social_login_button,
//'INFO_TEXT_SOCIAL_LOGIN_BUTTON2'=>$social_login_button2,
'HEADING_TITLE1'=>$heading_title1,
'HEADING_TITLE2'=>$heading_title2,
'AREA1'=>$area1,
'AREA2'=>$area2,
'SIGN_IN'=>SIGN_IN,
'INTO_LOG_IN'=>INTO_LOG_IN,
'INFO_LOGIN_WITH'=>INFO_LOGIN_WITH,
'INFO_NO_ACCOUNT'=>INFO_NO_ACCOUNT,
 'LEFT_BOX_WIDTH'=>LEFT_BOX_WIDTH1,
 'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH1,
 'LEFT_HTML'=>LEFT_HTML,
 'RIGHT_HTML'=>RIGHT_HTML,
 'update_message'=>$messageStack->output()));
$template->pparse('login');
?>