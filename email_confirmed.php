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

// verificar que no hay otra session abierta con el mismo usuario



if (isset($_GET['code'])) {
  if (isset($_GET['jobseeker'])) {
    $sql_data_array_ct_email_confirmation = array(
      'email_confirmed'  =>  'true'
    );

    $code = $_GET['code'];

    $result_log_query = tep_db_query("select jobseeker_id from email_confirmation_jobseeker where code = '$code'");
    $result_log = tep_db_fetch_array($result_log_query);
    $email_user = $result_log['jobseeker_id'];


    tep_db_perform('jobseeker', $sql_data_array_ct_email_confirmation, 'update', "jobseeker_id = '" . $result_log['jobseeker_id'] . "'");

    echo "<script>window.location.href = '/?email_activated=true';</script>";
  }else{
    $sql_data_array_ct_email_confirmation = array(
      'email_confirmed'  =>  'true'
    );

    $code = $_GET['code'];

    $result_log_query = tep_db_query("select recruiter_id from email_confirmation where code = '$code'");
    $result_log = tep_db_fetch_array($result_log_query);
    $email_user = $result_log['recruiter_id'];


    tep_db_perform('recruiter', $sql_data_array_ct_email_confirmation, 'update', "recruiter_id = '" . $result_log['recruiter_id'] . "'");

    echo "<script>window.location.href = '/?email_activated=true';</script>";
  }
}else{
    echo 'no hay';
}

?>
