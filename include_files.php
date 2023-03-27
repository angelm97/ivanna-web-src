<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/
if(is_dir('maintenance'))
{
 include('maintenance/index.htm');
 exit;
}


// Start the clock for the page parse time log
define('PAGE_PARSE_START_TIME', microtime());

/*
ini_set('error_reporting',E_ALL ^ ( E_NOTICE| E_WARNING ));
ini_set('display_errors','1');
//ini_set('SMTP','');//jobboard7bs
*/
ini_set('error_reporting','0');
ini_set('display_errors','0');


//waojobs.com

$host_array=array('localhost','www.waojobs.com','waojobs.com','127.0.0.1','104.207.146.163');

$host_name=strtolower($_SERVER['HTTP_HOST']);
if(!in_array($host_name,$host_array))
{
 //die("Forbidden :You don't have permission to access");
}
include_once("classinc/session.php");
include_once("classinc/variables.php");
include_once("classinc/main_config.php");

include_once("classinc/file_name.php");
include_once("classinc/table_names.php");

include_once("general_functions/database.php");
include_once("classinc/connect.php");
tep_db_connect() or die('Unable to connect to database server!');
include_once("classinc/variable1.php");
include_once("classinc/functions.php");

include_once("general_functions/functions.php");
include_once("general_functions/extra_functions.php");
include_once("general_functions/html_output.php");
include_once("general_functions/validations.php");
include_once("general_functions/recruiter_functions.php");
include_once("general_functions/password_funcs.php");

include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'mime.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'email.php');
if(basename(strtolower($_SERVER['PHP_SELF']))!=FILENAME_IMAGE)
{
 ///// online users
 include_once("general_functions/whos_online.php");
 tep_update_whos_online();
 ///
}

include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'template.php');
$template = new Template(PATH_TO_TEMPLATE);

include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'logger.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'table_block.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'table_block_left.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'table_block_right.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'box.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'message_stack.php');
$messageStack = new messageStack;

include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'split_page_results.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'object_info.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'upload.php');

include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'block_ip_address.php');
$obj_block_ip_address = new block_ip_address;

include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'title_metakeyword.php');
$obj_title_metakeyword = new title_metakeyword;
//////////////////////////
// include currencies class and create an instance
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'currencies.php');
$currencies = new currencies();
// include pagination class and create ajax pagination
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'pagination_class.php');
include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'pagination_class1.php');
// set the language
if(!tep_not_null($_SESSION['language']) || isset($_GET['language']))
{
 include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'language.php');
 $lng = new language();
 if (isset($_GET['language']) && tep_not_null($_GET['language']))
 {
  $lng->set_language($_GET['language']);
 }
 else
 {
  $lng->set_language('english');
  //$lng->get_browser_language();
 }
 $_SESSION['language']=$lng->language['directory'];
 $_SESSION['languages_id']=$lng->language['id'];
 $language=$_SESSION['language'];
 $languages_id=$_SESSION['languages_id'];
}
else
{
 $language=$_SESSION['language'];
 $languages_id=$_SESSION['languages_id'];
}
//print_r($_SESSION);
// include the language translations
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE . $language . '.php');

define("PATH_TO_BUTTON",PATH_TO_LANGUAGE.$language."/images/button/");        //Path to buttons
define("PATH_TO_MAIN_PHYSICAL_LANGUAGE_MODULE",PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language."/".PATH_TO_MODULE);        //Path to modules

/*if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
 include_once("general_functions/mobile_functions.php");
 if(socialCMS_is_MobileBrowser())
 {
  tep_redirect("mobile/");
 }
}
*/
//include_once(FILENAME_BODY);
foreach ($_GET as $secvalue)
{
 if(is_array($secvalue))
 {
   $secvalue1=$secvalue;
   foreach ($secvalue as $secvalue1)
   if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue1)) || (preg_match("/<[^>]*object*\"?[^>]*>/i", $secvalue1)) || (preg_match("/<[^>]*iframe*\"?[^>]*>/i", $secvalue1)) || (preg_match("/<[^>]*applet*\"?[^>]*>/i", $secvalue1)) || (preg_match("/<[^>]*meta*\"?[^>]*>/i", $secvalue1)) || (preg_match("/<[^>]*style*\"?[^>]*>/i", $secvalue1)) ||(preg_match("/<[^>]*form*\"?[^>]*>/i", $secvalue1)) ||(preg_match("/\([^>]*\"?[^)]*\)/i", $secvalue1)) ||(preg_match("/\"/i", $secvalue1)) ||(preg_match("/'/i", $secvalue1)))
   {
    $messageStack->add_session(ERROR_WRONG_TAG, 'error');
    tep_redirect("error.php");
   }
  }
  elseif ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue)) ||
     (preg_match("/<[^>]*object*\"?[^>]*>/i", $secvalue)) ||
     (preg_match("/<[^>]*iframe*\"?[^>]*>/i", $secvalue)) ||
     (preg_match("/<[^>]*applet*\"?[^>]*>/i", $secvalue)) ||
     (preg_match("/<[^>]*meta*\"?[^>]*>/i", $secvalue)) ||
     (preg_match("/<[^>]*style*\"?[^>]*>/i", $secvalue)) ||
     (preg_match("/<[^>]*form*\"?[^>]*>/i", $secvalue)) ||
     (preg_match("/\([^>]*\"?[^)]*\)/i", $secvalue)) ||
     (preg_match("/\"/i", $secvalue)) ||
     (preg_match("/'/i", $secvalue)))
 {
  $messageStack->add_session(ERROR_WRONG_TAG, 'error');
		tep_redirect("error.php");
 }
}
if(!check_login('admin'))
{
 foreach ($_POST as $secvalue)
 {
  if(is_array($secvalue))
  {
   $secvalue1=$secvalue;
   foreach ($secvalue as $secvalue1)
   if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue1)) ||	(preg_match("/<[^>]style*\"?[^>]*>/i", $secvalue1)))
   {
    $messageStack->add_session(ERROR_WRONG_TAG, 'error');
    tep_redirect("error.php");
   }
  }
  elseif ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue)) ||	(preg_match("/<[^>]style*\"?[^>]*>/i", $secvalue)))
  {
   $messageStack->add_session(ERROR_WRONG_TAG, 'error');
   tep_redirect("error.php");
  }
 }
}
if((basename(strtolower($_SERVER['PHP_SELF']))!=FILENAME_JOB_SEARCH) && (basename(strtolower($_SERVER['PHP_SELF']))!=FILENAME_JOB_DETAILS))
{
  unset($_SESSION['sess_jobsearch']);
}
if(check_login("recruiter"))
{
 if(basename(strtolower($_SERVER['PHP_SELF']))==FILENAME_RECRUITER_SEARCH_RESUME)
 {
  include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'recruiter_accounts.php');
  $obj_account=new recruiter_accounts('','resume_search');
  //print_r($obj_account->allocated_amount);
  $cv=$obj_account->allocated_amount['cv'];
  $enjoyed_cv=$obj_account->enjoyed_amount['cv'];
  $incerment=false;
  if($cv!="Unlimited")
  {
   if($enjoyed_cv > $cv || $cv=='0')
   {
    $incerment=false;
   }
   else
    $incerment=true;
  }
  else
     $incerment=true;

  if($incerment==true)
  {
   recruiter_plan_type_name();
   include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'recruiter_account_cv.php');
   $obj_recruiter_account_cv = new recruiter_account_cv;
  }
 }
 else if((basename(strtolower($_SERVER['PHP_SELF']))!=FILENAME_JOBSEEKER_VIEW_RESUME) && (basename(strtolower($_SERVER['PHP_SELF']))!=FILENAME_JOBSEEKER_RESUME_DOWNLOAD) && (basename(strtolower($_SERVER['PHP_SELF']))!=FILENAME_RECRUITER_SEARCH_RESUME))
 {
   unset($_SESSION['sess_cvsearch']);
 }
}


// verificar que no hay otra session abierta con el mismo usuario

if (isset($_SESSION["hash_login"])) {
  $result_log_query = tep_db_query("select status_log from recruiter where recruiter_id = '" . (int)$_SESSION['sess_recruiterid'] . "'");
    $result_log = tep_db_fetch_array($result_log_query);
    $is_online = $result_log['status_log'];

    if ($is_online != $_SESSION["hash_login"]) {
      unset($_SESSION["hash_login"]);
      echo "<script>window.location.href = '/multi_login.html';</script>";
    }
}

// verificar si el correo esta confirmado

if (isset($_SESSION["hash_login"])) {
  $result_log_query = tep_db_query("select email_confirmed from recruiter where recruiter_id = '" . (int)$_SESSION['sess_recruiterid'] . "'");
    $result_log = tep_db_fetch_array($result_log_query);
    $email_confirmed = $result_log['email_confirmed'];
}

$result_log_query = tep_db_query("select email_confirmed from recruiter where recruiter_id = '" . (int)$_SESSION['sess_recruiterid'] . "'");
$result_log = tep_db_fetch_array($result_log_query);
$email_confirmed = $result_log['email_confirmed'];

$result_log_query_js = tep_db_query("select email_confirmed from jobseeker where jobseeker_id = '" . (int)$_SESSION['sess_jobseekerid'] . "'");
$result_log_js = tep_db_fetch_array($result_log_query_js);
$email_confirmed_js = $result_log_js['email_confirmed'];

// Descomentar verificar correo para recluter y jobseeker 

/*

if ($email_confirmed == NULL && $_SESSION['sess_recruiterid'] != NULL) {

  $code = '082819' . $_SESSION['sess_recruiterid'] . date("his") . $_SESSION['sess_recruiterid'] . rand(1,1000) . $_SESSION['sess_recruiterid'] . date("his") . $_SESSION['sess_recruiterid'] . rand(1,1000) . $_SESSION['sess_recruiterid'] . date("his") . $_SESSION['sess_recruiterid'] . rand(1,1000) . $_SESSION['sess_recruiterid'] . '22101997';
  $_SESSION['confirmation_code'] = $code;
  $sql_data_array_ct_email_confirmation = array(
    'code'                => $_SESSION['confirmation_code'],
    'recruiter_id'        => $_SESSION['sess_recruiterid']
  );
  tep_db_perform('email_confirmation', $sql_data_array_ct_email_confirmation,'insert');

  $result_log_query = tep_db_query("select recruiter_email_address from recruiter_login where recruiter_id = '" . (int)$_SESSION['sess_recruiterid'] . "'");
  $result_log = tep_db_fetch_array($result_log_query);
  $email_user = $result_log['recruiter_email_address'];
  $_SESSION['email_user_confirmation'] = $email_user;

  $result_log_query = tep_db_query("select recruiter_first_name from recruiter where recruiter_id = '" . (int)$_SESSION['sess_recruiterid'] . "'");
  $result_log = tep_db_fetch_array($result_log_query);
  $user_name = $result_log['recruiter_first_name'];
  $_SESSION['user_name'] = $user_name;

  echo "<script>window.location.href = '/email_confirmation.php';</script>";
}

*/

//enviar correo de confirmacion para jobseeker

/*

if ($email_confirmed_js == NULL && $_SESSION['sess_jobseekerid'] != NULL) {

  $code = '082819' . $_SESSION['sess_jobseekerid'] . date("his") . $_SESSION['sess_jobseekerid'] . rand(1,1000) . $_SESSION['sess_jobseekerid'] . date("his") . $_SESSION['sess_jobseekerid'] . rand(1,1000) . $_SESSION['sess_jobseekerid'] . date("his") . $_SESSION['sess_jobseekerid'] . rand(1,1000) . $_SESSION['sess_jobseekerid'] . '22101997';
  $_SESSION['confirmation_code'] = $code;
  $sql_data_array_ct_email_confirmation_jobseeker = array(
    'code'                => $_SESSION['confirmation_code'],
    'jobseeker_id'        => $_SESSION['sess_jobseekerid']
  );

  tep_db_perform('email_confirmation_jobseeker', $sql_data_array_ct_email_confirmation_jobseeker,'insert');

  $result_log_query = tep_db_query("select jobseeker_email_address from jobseeker_login where jobseeker_id = '" . (int)$_SESSION['sess_jobseekerid'] . "'");
  $result_log = tep_db_fetch_array($result_log_query);
  $email_user = $result_log['jobseeker_email_address'];
  $_SESSION['email_user_confirmation_jobseeker'] = $email_user;

  $result_log_query = tep_db_query("select jobseeker_first_name from jobseeker where jobseeker_id = '" . (int)$_SESSION['sess_jobseekerid'] . "'");
  $result_log = tep_db_fetch_array($result_log_query);
  $user_name = $result_log['jobseeker_first_name'];
  $_SESSION['user_name'] = $user_name;

  echo "<script>window.location.href = '/email_confirmation.php';</script>";
}

*/

$add_language_field_constant='';
if($_SESSION['language']=="spanish")
 $add_language_field_constant="es_";
define('TEXT_LANGUAGE',$add_language_field_constant);
?>
