<?
/*
***********************************************************
***********************************************************
**********#	Name				      : Shambhu Prasad Patnaik#***********
**********#	Company			    : Aynsoft	Pvt. Ltd.   #***********
**********#	Copyright (c) www.aynsoft.com 2004	#***********
***********************************************************
***********************************************************
*/


include_once("include_files.php");
include_once("general_functions/password_funcs.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_RECRUITER_REGISTRATION);
$template->set_filenames(array('registration' => 'recruiter_registration.htm','email'=>'recruiter_registration_template.htm','es_email'=>'es_recruiter_registration_template.htm'));
$jscript_file=PATH_TO_LANGUAGE.$language."/jscript/".'recruiter_registation.js';
include_once(FILENAME_BODY);
//////
if(isset($_SESSION['sess_recruiteruserid']))
{
 $messageStack->add_session(ACCESS_DENIED, 'error');
 tep_redirect(FILENAME_RECRUITER_CONTROL_PANEL);
}
//////
$password_data="";
//$state_error=false;
$action = (isset($_POST['action']) ? $_POST['action'] : '');
if(check_login("admin"))
{
 $session_array=array("sess_recruiterid"=>$_GET['rID'],"sess_recruiterlogin"=>"y");
 if(isset($_GET['rID']))
 {
  if($row=getAnyTableWhereData(RECRUITER_TABLE,"recruiter_id='".(int)tep_db_input($_GET['rID'])."'",'recruiter_id'))
  {
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
  unset_session_value($session_array);
 }
}
 else if($_GET['add']=='recruiter')
 {
  unset_session_value($session_array);
 }
 //gcaptcha code
 $g_captcha =false;
if(MODULE_G_CAPTCHA_PLUGIN=='enable' &&  MODULE_G_CAPTCHA_WEB_R_RECRUITER=='enable')
{
 include_once "class/reCaptcha.php";
 // Descomentar el captcha fuera del localhost
 //$g_captcha =true;
 //$reCaptcha=new reCaptcha();
}

//print_r($_POST);
//////////////////////////////
// add/edit
if(tep_not_null($action))
{
 switch($action)
 {
  case 'new':
  case 'edit':
   $first_name         = tep_db_prepare_input($_POST['TR_first_name']);
   $last_name          = tep_db_prepare_input($_POST['TR_last_name']);
   $email_address      = tep_db_prepare_input($_POST['TREF_email_address']);
   $confirm_email_address=tep_db_prepare_input($_POST['TREF_confirm_email_address']);
   $password           = tep_db_prepare_input($_POST['TR_password']);
   $confirm_password   = tep_db_prepare_input($_POST['TR_confirm_password']);
   $position           = tep_db_prepare_input($_POST['TR_position']);
   $company_rnc        = tep_db_prepare_input($_POST['TR_company_rnc']);
   $company_name        = tep_db_prepare_input($_POST['TR_company_name']);
   $company_state        = tep_db_prepare_input($_POST['recruiter_company_state']);
   $address1           = tep_db_prepare_input($_POST['TR_address_line1']);
   $address2           = tep_db_prepare_input($_POST['address_line2']);
   $city               = tep_db_prepare_input($_POST['city']);
   $country            = (tep_not_null($_POST['TR_country'])?(int)tep_db_prepare_input($_POST['TR_country']):DEFAULT_COUNTRY_ID);

   if(isset($_POST['state']) and $_POST['state']!='')
   $state_value        =tep_db_prepare_input($_POST['state']);
   elseif(isset($_POST['state1']))
   $state_value        =tep_db_prepare_input($_POST['state1']);

   $zip_code           = tep_db_prepare_input($_POST['zip_code']);
   $telephone          = tep_db_prepare_input($_POST['TR_telephone_number']);
   $url                = tep_db_prepare_input($_POST['url']);
   $newsletter         = (tep_not_null($_POST['newsletter'])?tep_db_prepare_input($_POST['newsletter']):'Yes');
   $error              = false;

   //Check
   if($row=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE,"jobseeker_email_address='".tep_db_input($email_address)."'","jobseeker_id"))
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
   else if(check_login('recruiter'))
   {
    if($row=getAnyTableWhereData(RECRUITER_LOGIN_TABLE,"recruiter_email_address='".tep_db_input($email_address)."' and recruiter_id!='".$_SESSION['sess_recruiterid']."'","recruiter_id"))
    {
     $error = true;
     $messageStack->add(EMAIL_ADDRESS_ERROR,'recruiter_account');
    }
   }
   else
   {
    if($row=getAnyTableWhereData(RECRUITER_LOGIN_TABLE,"recruiter_email_address='".tep_db_input($email_address)."'","recruiter_id"))
    {
     $error = true;
     $messageStack->add(EMAIL_ADDRESS_ERROR,'recruiter_account');
    }
   }
   if(!$error)
   {
    if (strlen($first_name) < MIN_FIRST_NAME_LENGTH)
    {
     $error = true;
     $messageStack->add(MIN_FIRST_NAME_ERROR,'recruiter_account');
    }
    if (!(preg_match("/[A-Za-z]/i", $first_name)))
    {
     $error = true;
     $messageStack->add("Please enter characters only for First Name",'recruiter_account');
    }

    if (strlen($last_name) < MIN_LAST_NAME_LENGTH)
    {
     $error = true;
     $messageStack->add(MIN_LAST_NAME_ERROR,'recruiter_account');
    }
    if (!(preg_match("/[A-Za-z]/i", $last_name)))
    {
     $error = true;
     $messageStack->add("Please enter characters only for Last Name",'recruiter_account');
    }

    $error_email=false;
    if(tep_validate_email($email_address) == false)
    {
     $error_email=true;
     $error = true;
     $messageStack->add(EMAIL_ADDRESS_INVALID_ERROR,'recruiter_account');
    }

    //// password check
    if(!check_login('recruiter'))
    {
     $error_password=false;
     if (strlen($password) < MIN_PASSWORD_LENGTH)
     {
      $error_password=true;
      $error = true;
      $messageStack->add(MIN_PASSWORD_ERROR,'recruiter_account');
     }
	 //gcaptcha code
	 if($g_captcha)
     {
      if(!$reCaptcha->reCaptchaVerify())
      {
       $error = true;
       $messageStack->add(CAPTCHA_ERROR,'recruiter_account');
	  }
	 }

////
    }
    //////recruiter position check
    if (strlen($position) <= 0)
    {
     $error = true;
     $messageStack->add(POSITION_ERROR,'recruiter_account');
    }
    //////company name check
    if (strlen($company_name) < MIN_COMPANY_NAME_LENGTH)
    {
     $error = true;
     $messageStack->add(MIN_COMPANY_NAME_ERROR,'recruiter_account');
    }
    //////Address Line error check
    if (strlen($address1) < MIN_ADDRESS_LINE1_LENGTH)
    {
     $error = true;
     $messageStack->add(MIN_ADDRESS_LINE1_ERROR,'recruiter_account');
    }
    if(is_numeric($country) == false)
    {
     $error = true;
     $messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
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
      // $error = true;
       //$messageStack->add(ENTRY_STATE_ERROR_SELECT,'recruiter_account');
      }
     }
     else
     {
      // $state_error=true;
       //$error = true;
      // $messageStack->add(ENTRY_STATE_ERROR_SELECT,'recruiter_account');
     }
    }
    else
    {
     if(tep_not_null($state_value))
     if($row11 = getAnyTableWhereData(ZONES_TABLE, "zone_country_id = '" . tep_db_input($country) . "'", "zone_country_id"))
     {
      $state_error=true;
      $error = true;
      $messageStack->add(ENTRY_STATE_ERROR_SELECT,'recruiter_account');
     }
     //if (strlen($state_value) <= 0)
     //{
      //$state_error=true;
      //$error = true;
      //$messageStack->add(ENTRY_STATE_ERROR,'recruiter_account');
     //}
    }
    ////// Zip code error check
    /*
    if (strlen($zip_code) <= 0)
    {
     $error = true;
     $messageStack->add(ZIP_CODE_ERROR,'recruiter_account');
    }
    */
    //////Telephone error check
    if (strlen($telephone) <= 0)
    {
     $error = true;
     $messageStack->add(TELEPHONE_ERROR,'recruiter_account');
    }
    ////////Already member hidden while editing//////////////
    if ($action=='edit')
		$already_member='<tr>
            	      <td><br /> <div class="center-text">'.INFO_ALREADY_MEMBER.' <a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">'.INFO_SIGN_IN.'</a></div></td>
          	      </tr>';
	else
		$already_member='';
//////////////////////////////////////////

   //////// logo upload starts //////
    ///*

    /* Subir foto de la empresa no es required !!
	   if((strlen(tep_not_null($_FILES['my_photo']['size'])) <= 0))
    {
   	 if($action=='new')
     {
      $error = true;
      $messageStack->add(LOGO_UPLOAD_ERROR,'recruiter_account');
     }
     else
     {
      $logo_check=getAnyTableWhereData(RECRUITER_TABLE,"recruiter_id='".$_SESSION['sess_recruiterid']."'","recruiter_logo");
      if(($action=='edit') && (!tep_not_null($logo_check['recruiter_logo'])))
      {
       $error = true;
       $messageStack->add(LOGO_UPLOAD_ERROR,'recruiter_account');
      }
     }
	   }

     */
    //*/
    //////// logo upload ends //////
   }
   if(!$error)
   {
    $logo='';
    if(tep_not_null($_FILES['my_photo']['name']))
    {
	    if((substr($_FILES['my_photo']['name'],-4)=='.gif') || (substr($_FILES['my_photo']['name'],-4)=='.jpg') || (substr($_FILES['my_photo']['name'],-4)=='.png') || (substr($_FILES['my_photo']['name'],-5)=='.jpeg'))
	    {
      if($obj_logo = new upload('my_photo', PATH_TO_MAIN_PHYSICAL_LOGO,'644',array('gif','jpg','png','jpeg')))
      {
       $logo=tep_db_input($obj_logo->filename);
       if(check_login('recruiter'))
       {
        $logo_check=getAnyTableWhereData(RECRUITER_TABLE,"recruiter_id='".$_SESSION['sess_recruiterid']."'","recruiter_logo");
        if(tep_not_null($logo_check['recruiter_logo']))
        {
         if(is_file(PATH_TO_MAIN_PHYSICAL_LOGO.$logo_check['recruiter_logo']))
         {
          @unlink(PATH_TO_MAIN_PHYSICAL_LOGO.$logo_check['recruiter_logo']);
         }
        }
       }
      }
	     else
      {
       $error=true;
      }
	    }
	    else
     {
	     $error = true;
      $messageStack->add(LOGO_UPLOAD_TYPE_ERROR,'recruiter_account');
	    }
    }
   }
   if(!$error)
   {
     $sql_data_array=array('recruiter_first_name'  => $first_name,
                           'recruiter_last_name'   => $last_name,
                           'recruiter_position'    => $position,
                           'recruiter_company_rnc'=> $company_rnc,
                           'recruiter_company_name'=> $company_name,
                           'recruiter_company_state'=> $company_state,
                           'recruiter_address1'    => $address1,
                           'recruiter_address2'    => $address2,
                           'recruiter_city'        => $city,
                           'recruiter_country_id'  => $country,
                           'recruiter_zip'         => $zip_code,
                           'recruiter_telephone'   => $telephone,
                           'recruiter_url'         => ($url=='http://')?"":$url,
                           'recruiter_newsletter'  => $newsletter
                           );
    if($zone_id > 0)
    {
     $sql_data_array['recruiter_state']='null';
     $sql_data_array['recruiter_state_id']=$zone_id;
    }
    else
    {
     $sql_data_array['recruiter_state']=$state_value;
     $sql_data_array['recruiter_state_id']=0;
    }
    if($logo!='')
    {
     $sql_data_array['recruiter_logo']=$logo;
    }
    if(check_login('recruiter'))
    {
     $row_cal=getAnyTableWhereData(RECRUITER_LOGIN_TABLE,"recruiter_id='".$_SESSION['sess_recruiterid']."'","recruiter_email_address");
     tep_db_query('update '.RECRUITER_LOGIN_TABLE ." set updated=now(), recruiter_email_address='".tep_db_input($email_address)."' where recruiter_id = '" . $_SESSION['sess_recruiterid'] . "'");
     tep_db_perform(RECRUITER_TABLE, $sql_data_array, 'update', "recruiter_id = '" . $_SESSION['sess_recruiterid'] . "'");
 	   $messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
     tep_redirect(tep_href_link(FILENAME_RECRUITER_CONTROL_PANEL));
    }
    else
    {
     $recruiter_password=tep_encrypt_password($password);
     $sql_data_array1=array('inserted'=>'now()',
                           'recruiter_email_address'=>$email_address,
                           'recruiter_password'=>$recruiter_password
                           );
     tep_db_perform(RECRUITER_LOGIN_TABLE, $sql_data_array1);
     $row=getAnyTableWhereData(RECRUITER_LOGIN_TABLE,"recruiter_email_address='".tep_db_input($email_address)."'","recruiter_id");
     $_SESSION['sess_recruiterid']=$row['recruiter_id'];
     $sql_data_array['recruiter_id']=$_SESSION['sess_recruiterid'];
     tep_db_perform(RECRUITER_TABLE, $sql_data_array);
 	   //$messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
     $template->assign_vars(array(
      'recruiter_name'=>tep_db_output($first_name.' '.$last_name),
      'site_title'=>tep_db_output(SITE_TITLE),
      'user_name'=>tep_db_output($email_address),
      'password'=>tep_db_output($password),
      'admin_email'=>stripslashes(CONTACT_ADMIN),
      'logo'=>'<a href="'.tep_href_link("").'">'.tep_image(PATH_TO_IMG.DEFAULT_SITE_LOGO,tep_db_output(SITE_TITLE),'','','class="internal-logo"').'</a>',

      ));
     $email_text=stripslashes($template->pparse1(TEXT_LANGUAGE.'email'));
     //echo $email_text;die();
     tep_mail($first_name.' '.$last_name , $email_address, NEW_RECRUITER_SUBJECT, $email_text, SITE_OWNER, ADMIN_EMAIL);

     $_SESSION['sess_recruiterlogin']='y';
     $_SESSION['sess_new_recruiter']='y';
     $_SESSION['sess_email_address']=$email_address;
     $_SESSION['sess_password']=$password;
     //quite el apellido de $_SESSION['sess_user_name']
     $_SESSION['sess_user_name']=$first_name."";
     tep_redirect(tep_href_link(FILENAME_RECRUITER_REGISTRATION_CONFIRM));
    }
   }
  break;
 }
}
//////////////////////////////
//gcaptcha code ---display robot if enable
$gcaptcha_data='';
////////////
if(check_login('recruiter'))
{
 $add_save_button=tep_draw_submit_button_field('register','Guardar','class="btn btn-primary btn-block"');//tep_image_submit(PATH_TO_BUTTON.'button_update.gif', IMAGE_UPDATE);
 $registration_form=tep_draw_form('registration', FILENAME_RECRUITER_REGISTRATION, '', 'post', 'enctype="multipart/form-data" onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','edit');
}
else
{
 $add_save_button=tep_draw_submit_button_field('register',INFO_SIGN_UP,'class="btn btn-primary btn-block"');//tep_image_submit(PATH_TO_BUTTON.'button_submit.gif', IMAGE_INSERT);
 $registration_form=tep_draw_form('registration', FILENAME_RECRUITER_REGISTRATION, '', 'post', 'enctype="multipart/form-data" onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','new');

if($g_captcha)
 $gcaptcha_data.='<tr>
				<td  >'.$reCaptcha->reCaptchaGetCaptcha().'</td>
				</tr>';
}
if($error)
{
 $TR_first_name             = $first_name;
 $TR_last_name              = $last_name;
 $TREF_email_address        = $email_address;
 $TREF_confirm_email_address= $confirm_email_address;
 if(!check_login('recruiter'))
 {
  $TR_password='';
  $TR_confirm_password='';
 }
 $TR_position        = $position;
 $TR_company_rnc     = $company_rnc;
 $TR_company_name    = $company_name;
 $TR_company_state   = $company_state;
 $TR_address_line1   = $address1;
 $address_line2      = $address2;
 $TR_country         = $country;
 $city               = $city;
 $state_value        = $state_value;
 $zip_code        = $zip_code;
 $TR_telephone_number= $telephone;
 $url                = $url;
 $newsletter         = $newsletter;
}
else if(check_login('recruiter'))
{
 $row=getAnyTableWhereData(RECRUITER_LOGIN_TABLE." as rl, ".RECRUITER_TABLE." as r","rl.recruiter_id=r.recruiter_id and rl.recruiter_id='".$_SESSION['sess_recruiterid']."'");
 $TR_first_name         = $row['recruiter_first_name'];
 $TR_last_name          = $row['recruiter_last_name'];
 $TREF_email_address    = $row['recruiter_email_address'];
 $TREF_confirm_email_address=$row['recruiter_email_address'];
 $TR_position           = $row['recruiter_position'];
 $TR_company_rnc        = $row['recruiter_company_rnc'];
 $TR_company_name       = $row['recruiter_company_name'];
 $TR_company_state      = $row['recruiter_company_state'];
 $TR_address_line1      = $row['recruiter_address1'];
 $address_line2         = $row['recruiter_address2'];
 $TR_country            = $row['recruiter_country_id'];
 $city                  = $row['recruiter_city'];
 $state_value           =(int) $row['recruiter_state_id'];
 if($state_value > 0 and is_int($state_value) )
 {
  $state_value         = $state_value;//get_name_from_table(ZONES_TABLE,'zone_name', 'zone_id',$TR_state);
 }
 else
 {
  $state_value        = $row['recruiter_state'];
 }
 $zip_code         = $row['recruiter_zip'];
 $TR_telephone_number = $row['recruiter_telephone'];
 $url                 = $row['recruiter_url'];
 $logo=$row['recruiter_logo'];
 if(tep_not_null($logo))
 {
  if(is_file(PATH_TO_MAIN_PHYSICAL_LOGO.$logo))
  {
   $logo="&nbsp;&nbsp;[&nbsp;&nbsp;<a href='#' onclick=\"javascript:popupimage('".PATH_TO_LOGO.$logo."','')\" class='label'>".INFO_PREVIEW."</a>&nbsp;&nbsp;]";
  }
  else
   $logo='';
 }
 $newsletter=$row['recruiter_newsletter'];
}
else
{
 $TR_first_name     = '';
 $TR_last_name      = '';
 $TREF_email_address= '';
 $TREF_confirm_email_address='';
 $TR_password       = '';
 $TR_confirm_password='';
 $TR_position       = '';
 $TR_company_rnc    = '';
 $TR_company_name   = '';
 $TR_company_state  = '';
 $TR_address_line1  ='';
 $address_line2     ='';
 $TR_country        = DEFAULT_COUNTRY_ID;
 $state_value       = "";
 $city              = "";
 $zip_code       = "";
 $TR_telephone_number="";
 $url               = 'http://';
 $newsletter        = "Yes";
}
if(!check_login('recruiter'))
{
 $password_data='<tr>
							<td>'.tep_draw_password_field('TR_password','',false,'class="form-control mb-2 required" placeholder="Contraseña"').'</td>
						</tr>';
}
if(check_login('recruiter'))
{
$design='<td width="20%" align="left">
				 	<!-- Left Starts -->
					'.LEFT_HTML.'
					<!-- Left Ends -->
					<!-- Middle Starts -->
				</td>
				<td width="1%" align="left"><img src="img/spacer.gif" width="10" height="5"></td>
				<td width="79%"><div align="left">';
}
else{
$design='
				<td width="86%">';
}
if($state_error)
{
 $zones_array=tep_get_country_zones($TR_country);
 if(tep_not_null($zones_array))
{
  $INFO_TEXT_STATE1=LIST_SET_DATA(ZONES_TABLE,"",'zone_name','zone_id',"zone_name",'name="state" class="form-control mb-2"',"Ciudad",'',$state_value)." ";
  $INFO_TEXT_OTHER_STATE=tep_draw_input_field('state1',is_numeric($state_value)?'': $state_value,'class="form-control mb-2"',false);
}
 else
{
  $INFO_TEXT_STATE1=LIST_SET_DATA(ZONES_TABLE,"",'zone_name','zone_id',"zone_name",'name="state" class="form-control mb-2"',"Ciudad",'',$state_value)." ";
  $INFO_TEXT_OTHER_STATE=tep_draw_input_field('state1',is_numeric($state_value)?'': $state_value,'class="form-control mb-2"',false);
}
}
else
{
 $INFO_TEXT_STATE1=LIST_SET_DATA(ZONES_TABLE,"",'zone_name','zone_id',"zone_name",'name="state" class="form-control mb-2"',"Ciudad",'',$state_value)." ";
$INFO_TEXT_OTHER_STATE=tep_draw_input_field('state1',is_numeric($state_value)?'': $state_value,'placeholder="Other State" class="form-control mb-2"',false);
}

if($messageStack->size('recruiter_account') > 0)
 $update_message=$messageStack->output('recruiter_account');
else
 $update_message=$messageStack->output();

$social_button='';
if(!check_login("recruiter"))
{
 if(MODULE_FACEBOOK_PLUGIN=='enable' && MODULE_FACEBOOK_PLUGIN_RECRUITER=='enable')
 $social_button.=' <a href="'.FILENAME_FACEBOOK_APPLICATION.'?user_type=recruiter" title="Sign in with Facebook"><i class="fa fa-facebook-square social-login" aria-hidden="true"></i></a>';
 if(MODULE_GOOGLE_PLUGIN=='enable' && MODULE_GOOGLE_PLUGIN_RECRUITER=='enable')
 $social_button.=' <a href="'.FILENAME_GOOGLE_APPLICATION.'?user_type=recruiter" title="Sign in with Google"><i class="fa fa-google-plus-square social-login" aria-hidden="true"></i></a>';
 if(MODULE_LINKEDIN_PLUGIN=='enable' && MODULE_LINKEDIN_PLUGIN_RECRUITER=='enable')
 $social_button.=' <a href="'.FILENAME_LINKEDIN_APPLICATION.'?user_type=recruiter" title="Sign in with Linkedin"><i class="fa fa-linkedin-square social-login" aria-hidden="true"></i></a>';
 if(MODULE_TWITTER_PLUGIN_RECRUITER=='enable' &&  MODULE_TWITTER_SUBMITTER_OAUTH_CONSUMER_KEY!='')
 $social_button.=' <a href="'.FILENAME_TWITTER_APPLICATION.'?user_type=recruiter" title="Sign in with Twitter"><i class="fa fa-twitter-square social-login" aria-hidden="true"></i></a>';

 $social_button=trim($social_button);
 if($social_button!='')
 $social_button='<div>Únete usando '.$social_button.'</div>';
}

$template->assign_vars(array(
 'HEADING_TITLE'=>HEADING_TITLE,
 'INFO_TEXT_SOCIAL_BUTTON'=>$social_button,
 'SECTION_ACCOUNT_DETAILS'=>SECTION_ACCOUNT_DETAILS,
 'SECTION_CONTACT_DETAILS'=>SECTION_CONTACT_DETAILS,
 'SECTION_PASSWORD_DETAILS'=>SECTION_PASSWORD_DETAILS,
 'SECTION_COMPANY'=>SECTION_COMPANY,
 'REQUIRED_INFO'=>REQUIRED_INFO,
 'add_save_button'=>$add_save_button,
 'registration_form'=>$registration_form,
 'password_data'=>$password_data,
 'INFO_TEXT_FIRST_NAME1'=>tep_draw_input_field('TR_first_name', $TR_first_name,'placeholder="Primer nombre" class="form-control mb-2 required"',false),
 'INFO_TEXT_LAST_NAME1'=>tep_draw_input_field('TR_last_name', $TR_last_name,'placeholder="Apellido" type="text" class="form-control mb-2 required"',false),
// 'INFO_TEXT_EMAIL_ADDRESS1'=>(check_login('recruiter')?tep_draw_input_field('TREF_email_address', $TREF_email_address,'placeholder="Email address" class="form-control mb-2 required" disabled',false).tep_draw_hidden_field('TREF_email_address',$row['recruiter_email_address']):tep_draw_input_field('TREF_email_address', $TREF_email_address,'placeholder="Email address" class="form-control mb-2 required"',false)),
 'INFO_TEXT_EMAIL_ADDRESS1'=>(check_login('recruiter')?tep_draw_input_field('TREF_email_address',$TREF_email_address,'placeholder="Correo electrónico" class="form-control mb-2 required" disabled',false).tep_draw_hidden_field('TREF_email_address',$TREF_email_address):tep_draw_input_field('TREF_email_address', $TREF_email_address,'placeholder="Correo electrónico" class="form-control mb-2 required"',false)),// 'INFO_TEXT_CONFIRM_EMAIL_ADDRESS1'=>tep_draw_input_field('TREF_confirm_email_address', $TREF_confirm_email_address,'size="50" maxlength="50"',true),
 //////// Company Detail //////////////////////////////
 'INFO_TEXT_POSITION1'=>tep_draw_input_field('TR_position', $TR_position,'placeholder="Tu cargo" class="form-control mb-2 required inputlogin"',false),
 'INFO_TEXT_COMPANY_RNC'=>tep_draw_input_field('TR_company_rnc', $TR_company_rnc,'placeholder="RNC de la empresa" class="form-control mb-2 required inputlogin" id="rnc"',false),
 'INFO_TEXT_COMPANY_NAME1'=>tep_draw_input_field('TR_company_name', $TR_company_name,'placeholder="Nombre de la empresa" class="form-control required mb-2 inputlogin" id="name_company"',false),
 'INFO_TEXT_ADDRESS11'=>tep_draw_textarea_field('TR_address_line1', 'soft', '45', '3', $TR_address_line1, 'id="TR_address_line1" placeholder="Dirección" class="form-control mb-2 required inputlogin"', false),
 'INFO_TEXT_CITY1'=>tep_draw_input_field('city', $city,'placeholder="Ciudad" class="form-control mb-2 INFO_TEXT_CITY1 inputlogin"'),
 'INFO_TEXT_COUNTRY1' => tep_get_country_list('TR_country',$TR_country,'class="form-control mb-2 inputlogin"'),
 'INFO_TEXT_STATE1'=>$INFO_TEXT_STATE1,
 'INFO_TEXT_OTHER_STATE'=>$INFO_TEXT_OTHER_STATE,
 'INFO_TEXT_ZIP_CODE1'=>tep_draw_input_field('zip_code', $zip_code,'placeholder="Código postal (Opcional)" class="form-control mb-2"',false),
 'INFO_TEXT_TELEPHONE1'=>tep_draw_input_field('TR_telephone_number', $TR_telephone_number,'placeholder="Número telefónico" class="form-control mb-2 required"',false),
 'INFO_TEXT_PHOTO'=>INFO_TEXT_PHOTO,
 'INFO_TEXT_PHOTO1'=>tep_draw_file_field("my_photo").$logo,
 'INFO_TEXT_URL1'=>tep_draw_input_field('url', $url,'placeholder="Website URL i.e. http://www.aynsoft.com" class="form-control mb-2"',false),
 'INFO_TEXT_AGREEMENT'     => INFO_TEXT_AGREEMENT,
'INFO_TEXT_ALREADY_MEMBER'=>$already_member,
'TERMS'=>'<a href="'.tep_href_link(FILENAME_TERMS).'">Términos y condiciones </a>',
'PRIVACY'=>'<a href="'.tep_href_link(FILENAME_PRIVACY).'">Política de privacidad</a>',
 'G_CAPTCHA'=>$gcaptcha_data,
 'INFO_TEXT_NEWS_LETTER1'=>'<div class="custom-control custom-checkbox">
  '.tep_draw_checkbox_field('newsletter', 'Yes', '',$newsletter,'class="custom-control-input" id="checkbox_news"').'
  <label class="custom-control-label small" for="checkbox_news">'.INFO_SUBSCRIBE.'</label>
</div>',
 'SCRIPT'                => country_state($c_name='TR_country',$c_d_value='País',$s_name='state',$s_d_value='Ciudad','zone_id',$state_value),
 'LEFT_BOX_WIDTH'=>LEFT_BOX_WIDTH1,
 'INFO_TEXT_JSCRIPT_FILE'  =>$jscript_file,
	'design'        =>$design,
'INFO_PERSONAL_DETAILS'=>INFO_PERSONAL_DETAILS,
'INFO_COMPANY_DETAILS'=>INFO_COMPANY_DETAILS,
'INFO_UPLOAD_GIF'=>INFO_UPLOAD_GIF,
'INFO_TEXT_NEWSLETTER'=>INFO_TEXT_NEWSLETTER,
'INFO_TEXT_CONTINUE'=>INFO_TEXT_CONTINUE,
'INFO_AND'=>INFO_AND,
'INFO_PREVIEW'=>INFO_PREVIEW,

 'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH1,
 'LEFT_HTML'=>LEFT_HTML,
 'RIGHT_HTML'=>RIGHT_HTML,
 'update_message'=>$update_message));
$template->pparse('registration');
?>
