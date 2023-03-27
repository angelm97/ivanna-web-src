<?
include_once("include_files.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_JOBSEEKER_REGISTER1);
$template->set_filenames(array('registration' => 'jobseeker_registration_step1.htm','email'=>'jobseeker_registration_template.htm','es_email'=>'es_jobseeker_registration_template.htm'));
include_once(FILENAME_BODY);
$jscript_file=PATH_TO_LANGUAGE.$language."/jscript/".'jobseeker_registation.js';
//print_r($_POST);exit;
$password_data="";
$resume_data='';
$gogle_captcha='';
$resume='';
$state_error=false;
$action = (isset($_POST['action']) ? $_POST['action'] : '');
$from_job_detail=tep_db_prepare_input($_GET['job']);
$from_job_apply=tep_db_prepare_input($_GET['job_apply']);

//print_r($_SERVER);die();
if(tep_not_null($from_job_detail))
{
 $job_id=check_data($from_job_detail,"=","job_id","job_id");
 if($row=getAnyTableWhereData(JOB_TABLE,"job_id='".$job_id."'",'job_id'))
 $_SESSION['REDIRECT_URL']="/".PATH_TO_MAIN.FILENAME_JOB_DETAILS.'?query_string='.$from_job_detail;
}
elseif(tep_not_null($from_job_apply))
{
 $_SESSION['REDIRECT_URL']="/".PATH_TO_MAIN.FILENAME_BULK_APPLY_NOW.'?query_string='.$from_job_apply;
}
$g_captcha =false;
if(MODULE_G_CAPTCHA_PLUGIN=='enable' &&  MODULE_G_CAPTCHA_WEB_R_JOBSEEKER=='enable')
{
 include_once "class/reCaptcha.php";
 //$g_captcha =true;
 //$reCaptcha=new reCaptcha();
}
// add/edit
if(tep_not_null($action))
{
 switch($action)
 {
  case 'new':
  case 'edit':
   $privacy=(tep_not_null($_POST['privacy'])?tep_db_prepare_input($_POST['privacy']):'3');
   $cv_searchable=(tep_not_null($_POST['cv_searchable'])?tep_db_prepare_input($_POST['cv_searchable']):'Yes');
   $first_name=tep_db_prepare_input($_POST['TR_first_name']);
   $middle_name=tep_db_prepare_input($_POST['middle_name']);
   $last_name=tep_db_prepare_input($_POST['TR_last_name']);
   $cedula=tep_db_prepare_input($_POST['TR_cedula']);
   $email_address=tep_db_prepare_input($_POST['TREF_email_address']);
   $password=tep_db_prepare_input($_POST['TR_password']);
   $full_address1=tep_db_prepare_input($_POST['TR_full_address']);
  // $address2=tep_db_prepare_input($_POST['address_line2']);
   $nationality=tep_db_prepare_input($_POST['TR_nationality']);
   $country=(tep_not_null($_POST['TR_country'])?(int)tep_db_prepare_input($_POST['TR_country']):DEFAULT_COUNTRY_ID);

   if(isset($_POST['state']) && $_POST['state']!='')
   $state_value=tep_db_prepare_input($_POST['state']);
   elseif(isset($_POST['state1']))
   $state_value=tep_db_prepare_input($_POST['state1']);

   $city=tep_db_prepare_input($_POST['TR_city']);
   $zip=tep_db_prepare_input($_POST['zip']);
   $home_phone=tep_db_prepare_input($_POST['primary_phone']);
   //$mobile_no=tep_db_prepare_input($_POST['mobile_no']);
   $mobile=tep_db_prepare_input($_POST['mobile']);
   $newsletter=(tep_not_null($_POST['newsletter'])?tep_db_prepare_input($_POST['newsletter']):'No');
   $error=false;
   //////privacy check ////
   if (!in_array($privacy,array('1','2','3')))
   {
    $error = true;
    $messageStack->add(PRIVACY_ERROR,'jobseeker_account');
   }
   //Check
   if($row=getAnyTableWhereData(RECRUITER_LOGIN_TABLE,"recruiter_email_address='".tep_db_input($email_address)."'","recruiter_id"))
   {
    $error = true;
    $messageStack->add(EMAIL_ADDRESS_ERROR,'jobseeker_account');
   }
   else if($row=getAnyTableWhereData(RECRUITER_USERS_TABLE,"email_address='".tep_db_input($email_address)."'","id"))
   {
    $error = true;
    $messageStack->add(EMAIL_ADDRESS_ERROR,'jobseeker_account');
   }
   else if($row=getAnyTableWhereData(ADMIN_TABLE,"admin_email_address='".tep_db_input($email_address)."'","admin_id"))
   {
    $error = true;
    $messageStack->add(EMAIL_ADDRESS_ERROR,'jobseeker_account');
   }
   else if(check_login('jobseeker'))
   {
    if($row=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE,"jobseeker_email_address='".tep_db_input($email_address)."' and jobseeker_id!='".$_SESSION['sess_jobseekerid']."'","jobseeker_id"))
    {
     $error = true;
     $messageStack->add(EMAIL_ADDRESS_ERROR,'jobseeker_account');
    }
   }
   else
   {
    if($row=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE,"jobseeker_email_address='".tep_db_input($email_address)."'","jobseeker_id"))
    {
     $error = true;
     $messageStack->add(EMAIL_ADDRESS_ERROR,'jobseeker_account');
    }
   }
   if(!$error)
   {
    $error_email=false;
    if(tep_validate_email($email_address) == false)
    {
     $error_email=true;
     $error = true;
     $messageStack->add(EMAIL_ADDRESS_INVALID_ERROR,'jobseeker_account');
    }
    //// password check
    if(!check_login('jobseeker'))
    {
     $error_password=false;
     if (strlen($password) < MIN_PASSWORD_LENGTH)
     {
      $error_password=true;
      $error = true;
      $messageStack->add(MIN_PASSWORD_ERROR,'jobseeker_account');
     }
   /*  if (strlen($password) < MIN_PASSWORD_LENGTH)
     {
      $error_password=true;
      $error = true;
      $messageStack->add(MIN_CONFIRM_PASSWORD_ERROR,'jobseeker_account');
     }
     if(!$error_password)
     {
      if($password!=$confirm_password)
      {
       $error = true;
       $messageStack->add(PASSWORD_MATCH_ERROR,'jobseeker_account');
      }
     }*/
 	 if($g_captcha)
     {
      if(!$reCaptcha->reCaptchaVerify())
      {
       $error = true;
       $messageStack->add(CAPTCHA_ERROR,'jobseeker_account');
	  }
	 }

					if(!$error)
					{
						if(tep_not_null($_FILES['my_resume']['name']))
				  {
       $resume_directory=date("Ym");
       if(check_directory(PATH_TO_RESUME.$resume_directory))
       {
        if($obj_resume = new upload('my_resume', PATH_TO_MAIN_PHYSICAL_RESUME.$resume_directory.'/','644',array('doc','pdf','txt','docx','jpeg','png')))
        {
         $resume=tep_db_input($obj_resume->filename);
        }
       }
				  }
					}
    }
				/////////// check state //
    if(is_numeric($state_value))
    {
     $zone_id = 0;//echo $state_value;
     if($check_query = getAnyTableWhereData(ZONES_TABLE, "zone_country_id = '" . tep_db_input($country) . "'", "zone_country_id"))
     {
      $zone_query = tep_db_query("select distinct zone_id from " . ZONES_TABLE . " where zone_country_id = '" . tep_db_input($country) . "' and (zone_id ='" . tep_db_input($state_value) . "' )");
      if (tep_db_num_rows($zone_query) == 1)
      {
       $zone = tep_db_fetch_array($zone_query);
       $zone_id = $zone['zone_id'];
      }
      else
      {
       //$state_error=true;
       //$error = true;
       //$messageStack->add(ENTRY_STATE_ERROR_SELECT,'jobseeker_account');
      }
     }
     else
     {
      //$state_error=true;
      //$error = true;
      //$messageStack->add(ENTRY_STATE_ERROR_SELECT,'jobseeker_account');
     }
    }
    else
    {
     if(tep_not_null($state_value))
     if($row11 = getAnyTableWhereData(ZONES_TABLE, "zone_country_id = '" . tep_db_input($country) . "'", "zone_country_id"))
     {
      $state_error=true;
      $error = true;
      $messageStack->add(ENTRY_STATE_ERROR_SELECT,'jobseeker_account');
     }
     elseif (strlen($state_value) <= 0)
     {
      //$state_error=true;
      //$error = true;
      //$messageStack->add(ENTRY_STATE_ERROR,'jobseeker_account');
     }
    }
    /////////  /////////// end check state ///////////////////////
    if (strlen($first_name) < MIN_FIRST_NAME_LENGTH)
    {
     $error = true;
     $messageStack->add(MIN_FIRST_NAME_ERROR,'jobseeker_account');
    }
    if (!(preg_match("/[A-Za-z]/i", $first_name)))
    {
     $error = true;
     $messageStack->add("Oops no aceptamos caracteres especiales en tu Primero Nombre",'jobseeker_account');
    }

    if (strlen($last_name) < MIN_LAST_NAME_LENGTH)
    {
     $error = true;
     $messageStack->add(MIN_LAST_NAME_ERROR,'jobseeker_account');
    }
    if (!(preg_match("/[A-Za-z]/i", $last_name)))
    {
     $error = true;
     $messageStack->add("Oops no aceptamos caracteres especiales en tus Apellidos",'jobseeker_account');
    }


    if (strlen($cedula) < 11)
    {
     $error = true;
     $messageStack->add('Oops cedula muy corta','jobseeker_cedula');
    } else {

        $sum = 0;
    for ( $i = 0; $i < 10; ++$i) {
         $n = (($i + 1) % 2 != 0 ? 1 : 2) * intval($cedula[$i]);
        $sum += ($n <= 9 ? $n : $n % 10 + 1);
    }
     $dig = ((10 - $sum % 10) % 10);

    if ($dig == intval($cedula[10])){

        }else{  $error = true;
     $messageStack->add('Oops cedula invalida','jobseeker_cedula');}

    }



    if (strlen($full_address1) < MIN_ADDRESS_LINE1_LENGTH)
    {
     $error = true;
     $messageStack->add(MIN_ADDRESS_LINE1_ERROR,'jobseeker_account');
    }
    if(is_numeric($country) == false)
    {
     $error = true;
     $messageStack->add(ENTRY_COUNTRY_ERROR,'jobseeker_account');
    }
    if (strlen($city) < MIN_CITY_LENGTH)
    {
     $error = true;
     $messageStack->add(MIN_CITY_ERROR,'jobseeker_account');
    }
    if (strlen($home_phone) < 0)
    {
     $error = true;
     $messageStack->add(ENTRY_HOME_PHONE_ERROR,'jobseeker_account');
    }

   }
   if(!$error)
   {
     $sql_data_array=array('jobseeker_privacy'=>$privacy,
                           'jobseeker_cv_searchable'=>$cv_searchable,
                           'jobseeker_first_name'=>$first_name,
                           'jobseeker_middle_name'=>$middle_name,
                           'jobseeker_last_name'=>$last_name,
                           'jobseeker_address1'=>$full_address1,
                         //  'jobseeker_address2'=>$address2,
                           'jobseeker_country_id'=>$country,
                           'jobseeker_city'=>$city,
                           'jobseeker_zip'=>$zip,
                           'jobseeker_phone'=>$home_phone,
                           'jobseeker_mobile'=>$mobile,
                           'jobseeker_newsletter'=>$newsletter,
                           'jobseeker_cedula'=>$cedula,
                           );
					if($zone_id > 0)
    {
     $sql_data_array['jobseeker_state']=NULL;
     $sql_data_array['jobseeker_state_id']=$zone_id;
    }
    else
    {
     $sql_data_array['jobseeker_state']=$state_value;
     $sql_data_array['jobseeker_state_id']=0;
    }
				$full_location =	trim((($city!='')?$city.",":"").((tep_not_null($state_value)||$zone_id>0)?(is_numeric($zone_id)?get_name_from_table(ZONES_TABLE,TEXT_LANGUAGE.'zone_name', 'zone_id',$zone_id): $state_value):''));
    $full_location =   (($full_location!='')?$full_location.",":"").get_name_from_table(COUNTRIES_TABLE,'es_country_name', 'id', $country);
				$result=getLocationGeoAddress('address='.urlencode($full_location));
				//print_r($result);die();
	   if(is_array($result))
	   {
     $sql_data_array['latitude']=$result['latitude'];
     $sql_data_array['longitude']=$result['longitude'];
	   }
    if(check_login('jobseeker'))
    {
     tep_db_query('update '.JOBSEEKER_LOGIN_TABLE ." set updated='".date("Y-m-d H:i:s")."', jobseeker_email_address='$email_address' where jobseeker_id = '" . $_SESSION['sess_jobseekerid'] . "'");
     tep_db_query('update '.JOBSEEKER_RESUME1_TABLE ." set search_status='".$cv_searchable."' where jobseeker_id = '" . $_SESSION['sess_jobseekerid'] . "'");
     tep_db_perform(JOBSEEKER_TABLE, $sql_data_array, 'update', "jobseeker_id = '" . $_SESSION['sess_jobseekerid'] . "'");
 	   $messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
					if($_SESSION['sess_new_jobseeker']=='y')
					{
	     tep_redirect(tep_href_link(FILENAME_JOBSEEKER_RESUME1));
					}
     tep_redirect(tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL));
    }
    else
    {
     $sql_data_array1=array('inserted'=>'now()',
                           'jobseeker_email_address'=>$email_address,
                           'jobseeker_password'=>tep_encrypt_password($password)
                           );
     tep_db_perform(JOBSEEKER_LOGIN_TABLE, $sql_data_array1);

     $row=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE,"jobseeker_email_address='".tep_db_input($email_address)."'","jobseeker_id");
     $_SESSION['sess_jobseekerid']=$row['jobseeker_id'];
     $sql_data_array['jobseeker_id']=$_SESSION['sess_jobseekerid'];
     tep_db_perform(JOBSEEKER_TABLE, $sql_data_array);

					if(tep_not_null($resume))
     {
      $sql_data_array_r=array('inserted'=>'now()',
                           'availability_date'=>'now()',
                           'jobseeker_id'=>$_SESSION['sess_jobseekerid'],
                           'resume_title' => 'Resume :'.$first_name,
							                    'target_job_titles' =>'job',
                           'jobseeker_resume' => $resume,
                           );

    	 tep_db_perform(JOBSEEKER_RESUME1_TABLE, $sql_data_array_r,'insert');
     }
     $template->assign_vars(array(
      'jobseeker_name'=>tep_db_output($first_name.' '.$middle_name.' '.$last_name),
      'site_title'=>tep_db_output(SITE_TITLE),
      'user_name'=>tep_db_output($email_address),
      'password'=>tep_db_output($password),
      'admin_email'=>stripslashes(CONTACT_ADMIN),
      'logo'=>'<a href="'.tep_href_link("").'">'.tep_image(PATH_TO_IMG.DEFAULT_SITE_LOGO,tep_db_output(SITE_TITLE),'','','class="internal-logo"').'</a>',
      ));
     $email_text=stripslashes($template->pparse1(TEXT_LANGUAGE.'email'));
     //echo $email_text;die();
     tep_mail($first_name.' '.$middle_name.' '.$last_name , $email_address, NEW_JOBSEEKER_SUBJECT, $email_text, SITE_OWNER, EMAIL_FROM);

     $_SESSION['sess_jobseekerlogin']='y';
     $_SESSION['sess_new_jobseeker']='y';
     //quite el apellido de $_SESSION['sess_user_name']
     $_SESSION['sess_user_name']=$first_name."";
     $_SESSION['sess_email_address']=$email_address;
     $_SESSION['sess_password']=$password;
     tep_redirect(tep_href_link(FILENAME_JOBSEEKER_REGISTRATION_CONFIRM));
   	}
   }
  break;
 }
}
//////////////////////////////
//if(check_login('jobseeker') && $_SESSION['sess_new_jobseeker']!='y')
if(check_login('jobseeker') )
{
 $add_save_button=tep_draw_submit_button_field('register','Actualizar','class="btn btn-primary btn-block"');//tep_image_submit(PATH_TO_BUTTON.'button_update.gif', IMAGE_UPDATE);
 $registration_form=tep_draw_form('registration', FILENAME_JOBSEEKER_REGISTER1, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','edit');
}
else
{
 $add_save_button=tep_draw_submit_button_field('register','Siguiente','class="btn btn-primary btn-block"');//tep_image_submit(PATH_TO_BUTTON.'button_next.gif', IMAGE_NEXT);
 $registration_form=tep_draw_form('registration', FILENAME_JOBSEEKER_REGISTER1, '', 'post', 'enctype="multipart/form-data" onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','new');
}
if($error)
{
 $privacy=$privacy;
 $cv_searchable=$cv_searchable;
 $TR_first_name=$first_name;
 $TR_last_name=$last_name;
 $TR_cedula=$cedula;
 $middle_name=$middle_name;
 $TREF_email_address=$email_address;
 $TREF_confirm_email_address=$confirm_email_address;
 if(!check_login('jobseeker'))
 {
  $TR_password=$password;
  $TR_confirm_password=$confirm_password;

 }
 $TR_full_address=$full_address1;
 $TR_nationality=$nationality;
 $TR_country=$country;
 $state_value=$state_value;
 $TR_city=$city;
 $zip=$zip;
 $primary_phone=$home_phone;
 $mobile=$mobile;
 $newsletter= $newsletter;
}
else if(check_login('jobseeker'))
{
 $fields="j.jobseeker_privacy,j.jobseeker_first_name, j.jobseeker_last_name, j.jobseeker_middle_name, ";
 $fields.="jl.jobseeker_email_address, j.jobseeker_address1,j.jobseeker_cv_searchable, ";
 $fields.="j.jobseeker_country_id, j.jobseeker_state_id, j.jobseeker_state, ";
 $fields.="j.jobseeker_city, j.jobseeker_zip, j.jobseeker_phone, j.jobseeker_mobile,j.jobseeker_newsletter";
 $row=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE.' as jl, '.JOBSEEKER_TABLE.' as j',"jl.jobseeker_id=j.jobseeker_id and j.jobseeker_id='".$_SESSION['sess_jobseekerid']."'",$fields);
 $privacy=$row['jobseeker_privacy'];
 $cv_searchable=$row['jobseeker_cv_searchable'];

 $TR_first_name=$row['jobseeker_first_name'];
 $TR_last_name=$row['jobseeker_last_name'];
 $TR_cedula=$row['jobseeker_cedula'];
 $middle_name=$row['jobseeker_middle_name'];
 $TREF_email_address=$row['jobseeker_email_address'];
 $TREF_confirm_email_address=$row['jobseeker_email_address'];
 $TR_full_address=$row['jobseeker_address1'];
 $TR_country=$row['jobseeker_country_id'];
	$state_value=(int)$row['jobseeker_state_id'];
 if($state_value > 0 and is_int($state_value) )
 {
  $state_value=$state_value;//get_name_from_table(ZONES_TABLE,'zone_name', 'zone_id',$state_value);
 }
 else
 {
  $state_value=$row['jobseeker_state'];
 }
 $TR_city=$row['jobseeker_city'];
 $zip=$row['jobseeker_zip'];
 $primary_phone=$row['jobseeker_phone'];
 $mobile=$row['jobseeker_mobile'];
 $newsletter=$row['jobseeker_newsletter'];
}
else
{
 $privacy='3';
 $cv_searchable="Yes";
 $TR_first_name='';
 $TR_last_name='';
 $TR_cedula='';
 $middle_name='';
 $TREF_email_address='';
 $TREF_confirm_email_address='';
 $TR_password='';
 $TR_confirm_password='';
 $TR_full_address='';
 $TR_nationality='';
 $address_line2='';
 $TR_country=DEFAULT_COUNTRY_ID;
	$state_value="";
 $TR_city="";
 $zip="";
 $primary_phone="";
 $mobile="";
 $newsletter="Yes";
}
if(!check_login('jobseeker'))
{
 $password_data='<div class="form-group">
				<td>'.tep_draw_password_field('TR_password','',false,'class="form-control required" placeholder="Contraseña"').'</td>
				</div>
				<!--<tr>
				<td>'.tep_draw_password_field('TR_confirm_password','',true,'class="form-control" placeholder="Contraseña"').'</td>
			</tr>-->';
  $resume_data='<div class="form-group">
            	 <p class="label-text"><small id="emailHelp" class="form-text text-muted">'.INFO_TEXT_UPLOAD_RESUME.'</p>
				 '.tep_draw_file_field("cmy_resume").''.INFO_TEXT_UPLOAD_RESUME_HELP.'</small>

				 </div>';
if($g_captcha)
 $gogle_captcha='<div class="form-group">'.$reCaptcha->reCaptchaGetCaptcha().'</div>';


}
if(check_login('jobseeker'))
{
$design='<td width="19%" valign="top">
				 	<!-- Left Starts -->
					'.LEFT_HTML_JOBSEEKER.'
					<!-- Left Ends -->
					<!-- Middle Starts -->
				</td>
                    <td width="67%" valign="top">';
}
else{
$design='
				<td width="86%">';
}
if($state_error)
{
 //echo $state_value; die();
 $zones_array=tep_get_country_zones($TR_country);
 if(sizeof($zones_array) > 1)
 {
  define('INFO_TEXT_STATE1',LIST_SET_DATA(ZONES_TABLE,"",'zone_name','zone_id',"zone_name",'name="state" class="form-control"',"state",'',$state_value)." ");
define('INFO_TEXT_OTHER_STATE',tep_draw_input_field('state1',is_numeric($state_value)?'': $state_value,'class="form-control-state1" placeholder="Other State"',false));
 }
 else
 {
  define('INFO_TEXT_STATE1',LIST_SET_DATA(ZONES_TABLE,"",'zone_name','zone_id',"zone_name",'name="state" class="form-control"',"state",'',$state_value)." ");
define('INFO_TEXT_OTHER_STATE',tep_draw_input_field('state1',is_numeric($state_value)?'': $state_value,'class="form-control-state1" placeholder="Other State"',false));
 }
}
else
{
 define('INFO_TEXT_STATE1',LIST_SET_DATA(ZONES_TABLE,"",'zone_name','zone_id',"zone_name",'name="state" class="form-control"',"state",'',$state_value)." ");
define('INFO_TEXT_OTHER_STATE',tep_draw_input_field('state1',is_numeric($state_value)?'': $state_value,'class="form-control-state1" placeholder="Other State"',false));
}
$social_button='';
if(!check_login("jobseeker"))
{
 if(MODULE_FACEBOOK_PLUGIN=='enable' && MODULE_FACEBOOK_PLUGIN_JOBSEEKER=='enable')
 $social_button='<a href="'.FILENAME_FACEBOOK_APPLICATION.'" title="Sign in with Facebook"><i class="fa fa-facebook-square social-login" aria-hidden="true"></i></a>';
 if(MODULE_GOOGLE_PLUGIN=='enable' && MODULE_GOOGLE_PLUGIN_JOBSEEKER=='enable')
 $social_button.=' <a href="'.FILENAME_GOOGLE_APPLICATION.'" title="Sign in with Google"><i class="fa fa-google-plus-square social-login" aria-hidden="true"></i></a>';
 if(MODULE_LINKEDIN_PLUGIN=='enable' && MODULE_LINKEDIN_PLUGIN_JOBSEEKER=='enable')
 $social_button.=' <a href="'.FILENAME_LINKEDIN_APPLICATION.'" title="Sign in with Linkedin"><i class="fa fa-linkedin-square social-login" aria-hidden="true"></i></a>';
 if(MODULE_TWITTER_PLUGIN_JOBSEEKER=='enable' && MODULE_TWITTER_SUBMITTER_OAUTH_CONSUMER_KEY!='')
 $social_button.=' <a href="'.FILENAME_TWITTER_APPLICATION.'" title="Sign in with Twitter"><i class="fa fa-twitter-square social-login" aria-hidden="true"></i></a>';

 $social_button=trim($social_button);
 if($social_button!='')
 $social_button='<tr>
            	      <td><table border="0" align="right" cellpadding="0" cellspacing="0">
            	        <tr>
            	          <td><div class="orloginwith2">Únete usando '.$social_button.'</div></td>

          	          </tr>
          	        </table></td>
          	      </tr>';
}

if($messageStack->size('jobseeker_account') > 0)
 $update_message=$messageStack->output('jobseeker_account');
else
$update_message=$messageStack->output();
$template->assign_vars(array(
 'HEADING_TITLE'           => HEADING_TITLE,
 'SECTION_ACCOUNT_DETAILS' => SECTION_ACCOUNT_DETAILS,
 'SECTION_ACCOUNT_PRIVACY' => SECTION_ACCOUNT_PRIVACY,
 'SECTION_CONTACT_DETAILS' => SECTION_CONTACT_DETAILS,
'INFO_TEXT_CREATE_ACCOUNT'=>INFO_TEXT_CREATE_ACCOUNT,
 'INFO_TEXT_SOCIAL_BUTTON' =>$social_button,
 'add_save_button'         => $add_save_button,
 'registration_form'       => $registration_form,
 'password_data'           => $password_data,
 'resume_data'             => $resume_data,
'google_captcha'=>$gogle_captcha,
'INFO_TEXT_EMAIL_ADDRESS1'=>(check_login('jobseeker')? tep_draw_input_field('TREF_email_address', $TREF_email_address,'class="form-control required" placeholder="Correo electrónico"  disabled',false).tep_draw_hidden_field('TREF_email_address',$TREF_email_address): tep_draw_input_field('TREF_email_address', $TREF_email_address,'class="form-control mb-2 required" placeholder="Correo electrónico"',false)),
//'INFO_TEXT_CONFIRM_EMAIL_ADDRESS1'=> tep_draw_input_field('TREF_confirm_email_address', $TREF_confirm_email_address,'class="form-control" placeholder="Confirm Email address"',false),
'INFO_TEXT_FIRST_NAME1'=> tep_draw_input_field('TR_first_name', $TR_first_name,'placeholder="Primer nombre" class="form-control mb-2 required"',false),
'INFO_TEXT_LAST_NAME1'    => tep_draw_input_field('TR_last_name', $TR_last_name,'placeholder="Apellido" class="form-control mb-2 required"',false),
'INFO_TEXT_CEDULA'=> tep_draw_input_field('TR_cedula', $TR_cedula,'placeholder="Cédula" class="form-control mb-2 required" pattern="[0-9]{1,11}" title="Oops, debes revisar tu número de cédula. Escribir sin guión y solo 11 dígitos. "',false),
'INFO_TEXT_FULL_ADDRESS1'=>tep_draw_textarea_field('TR_full_address', 'soft', '45', '3', $TR_full_address, 'id="TR_full_address" placeholder="Dirección" class="form-control mb-2 required"', false),
 'COUNTRY_STATE_SCRIPT'    => country_state($c_name='TR_country',$c_d_value='Dirección',$s_name='state',$s_d_value='Ciudad','zone_id',$state_value),
'INFO_TEXT_ZIP1' => tep_draw_input_field('zip', $zip,'placeholder="Código postal (opcional)" class="form-control mb-2"',false),
 'INFO_TEXT_CITY1'=> tep_draw_input_field('TR_city', $TR_city,'placeholder="Sector" class="form-control mb-2 required"',false),
 'INFO_TEXT_HOME_PHONE1'=> tep_draw_input_field('primary_phone', $primary_phone,'placeholder="Teléfono" class="form-control mb-2 required"'),
 'INFO_TEXT_MOBILE1' => tep_draw_input_field('mobile', $mobile,'placeholder="Móvil" class="form-control mb-2 required"'),
// 'INFO_TEXT_COUNTRY1' => tep_get_country_list('TR_country',$TR_country),
 'INFO_TEXT_COUNTRY1' => tep_get_country_list('TR_country',$TR_country,'class="form-control mb-2"'),
 'INFO_TEXT_JSCRIPT_FILE'  => $jscript_file,
  'INFO_TEXT_STATE'         => INFO_TEXT_STATE,
 'INFO_TEXT_STATE1'        => INFO_TEXT_STATE1,
 'INFO_TEXT_OTHER_STATE'   => INFO_TEXT_OTHER_STATE,
 'INFO_TEXT_PRIVACY1'      =>'<div class="custom-control custom-radio">'.tep_draw_radio_field('privacy', '1', '', $privacy, 'id="radio_privacy1" class="custom-control-input"').'&nbsp;<label class="custom-control-label small" for="radio_privacy1">'.INFO_TEXT_PRIVACY_HIDE_ALL.'</label></div>
<div class="custom-control custom-radio">'.tep_draw_radio_field('privacy', '2', '', $privacy, 'id="radio_privacy2" class="custom-control-input"').'&nbsp;<label class="custom-control-label  small" for="radio_privacy2">'.INFO_TEXT_PRIVACY_HIDE_CONTACT.'</label></div>
<div class="custom-control custom-radio">'.tep_draw_radio_field('privacy', '3', '', $privacy, 'id="radio_privacy3" class="custom-control-input"').'&nbsp;<label class="custom-control-label  small" for="radio_privacy3">'.INFO_TEXT_PRIVACY_HIDE_NOTHING.'</label></div>',
'RESUME_SEARCHABLE'=>RESUME_SEARCHABLE,
'INFO_TEXT_RESUME_SEARCHEABLE1'=>'<div class="custom-control custom-radio">'.tep_draw_radio_field('cv_searchable', 'Yes', '', $cv_searchable, 'id="radio_cv_searchable1" class="custom-control-input" ').'&nbsp;<label class="custom-control-label small" for="radio_cv_searchable1" onMouseOver="this.style.color=\'#0000aa\'" onMouseOut="this.style.color=\'#000000\'">'.INFO_TEXT_YES.'</label></div>
<div class="custom-control custom-radio">'.tep_draw_radio_field('cv_searchable', 'No', '', $cv_searchable, 'id="radio_cv_searchable2" class="custom-control-input"').'&nbsp;<label class="custom-control-label small" for="radio_cv_searchable2" onMouseOver="this.style.color=\'#0000aa\'" onMouseOut="this.style.color=\'#000000\'">'.INFO_TEXT_NO.'</label></div>',
 'INFO_TEXT_NEWS_LETTER'   => INFO_TEXT_NEWS_LETTER,
 'INFO_TEXT_NEWS_LETTER1'=>'<div class="custom-control custom-checkbox">
  '.tep_draw_checkbox_field('newsletter', 'Yes', '',$newsletter,'class="custom-control-input" id="checkbox_news"').'
  <label class="custom-control-label small" for="checkbox_news">Quiero suscribirme</label>
</div>',
'INFO_TEXT_CREATE_ACCOUNT'=>INFO_TEXT_CREATE_ACCOUNT,
'INFO_TEXT_JOIN'=>INFO_TEXT_JOIN,
 'INFO_TEXT_AGREEMENT'     => INFO_TEXT_AGREEMENT,
'ALREADY_MEMBER'=>(check_login("jobseeker")?'':' <div class="float-right small">¿Ya tienes una cuenta? <a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">Iniciar sesión</a> </div>'),
 'INFO_TEXT_NATIONALITY1'  => tep_draw_input_field('TR_nationality', $TR_nationality,'placeholder="Nacionalidad" class="form-control form-control-1"',false),
'INFO_TEXT_NATIONALITY1'=>INFO_TEXT_NATIONALITY1,
 'design'                  => $design,


 'LEFT_BOX_WIDTH'          => LEFT_BOX_WIDTH1,
 'RIGHT_BOX_WIDTH'         => RIGHT_BOX_WIDTH1,
 'LEFT_HTML'               => LEFT_HTML,
 'LEFT_HTML_JOBSEEKER'     => LEFT_HTML_JOBSEEKER,
 'RIGHT_HTML'              => RIGHT_HTML,
 'update_message'=>$update_message));
$template->pparse('registration');
?>
