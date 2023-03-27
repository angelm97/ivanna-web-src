<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/
include_once("include_files.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_JOBSEEKER_CONTROL_PANEL);
$template->set_filenames(array('control_panel' => 'jobseeker_control_panel.htm'));
include_once(FILENAME_BODY);
if(!check_login("jobseeker"))
{
 $messageStack->add_session(LOGON_FIRST_MESSAGE, 'error');
 tep_redirect(FILENAME_JOBSEEKER_LOGIN);
}
$no_of_applications=no_of_records(APPLY_TABLE.' as a, '.JOB_TABLE." as j","a.job_id=j.job_id and a.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and jobseeker_apply_status='active'",'a.id');
$no_of_cover_letters=no_of_records(JOBSEEKER_LOGIN_TABLE . " as jl, ".COVER_LETTER_TABLE." as c","jl.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and jl.jobseeker_id=c.jobseeker_id",'c.cover_letter_id');
$no_of_saved_searches=no_of_records(SEARCH_JOB_RESULT_TABLE . " as sr ","sr.jobseeker_id='".$_SESSION['sess_jobseekerid']."'",'sr.id');
$no_of_saved_jobs=no_of_records(SAVE_JOB_TABLE . " as s, ".JOB_TABLE." as j, ".RECRUITER_TABLE." as r, ".RECRUITER_LOGIN_TABLE." as rl","s.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and s.job_id=j.job_id and j.recruiter_id=rl.recruiter_id and j.recruiter_id=r.recruiter_id and rl.recruiter_status='Yes'",'s.id');
$no_of_resumes=no_of_records(JOBSEEKER_RESUME1_TABLE . " as j1","j1.jobseeker_id='".$_SESSION['sess_jobseekerid']."'",'j1.jobseeker_id');
$no_of_unread_mail=no_of_records(APPLICANT_INTERACTION_TABLE." as ai left join ".APPLICATION_TABLE."  as a on (a.id=ai.application_id) ","a.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and ai.receiver_mail_status='active'  and ai.user_see ='No' and  sender_user='recruiter' ",'ai.id');
$no_of_contact=no_of_records(USER_CONTACT_TABLE,"user_id='".$_SESSION['sess_jobseekerid']."' and user_type='jobseeker'",'id');

//*******coding for search status as availablenow***************//
$jobseeker_status=(tep_not_null($_POST['jobseeker_status'])?tep_db_prepare_input($_POST['jobseeker_status']):'');
$action=(tep_not_null($_POST['action'])?tep_db_prepare_input($_POST['action']):'');
//*********//

//////////////////////////////////DISPLAY No OF TIMES RESUME VIEWED ////////////////////////////////////////////////////
$query_view = "select * from ".JOBSEEKER_RESUME1_TABLE. " as jr1 left join ".RESUME_STATISTICS_TABLE." as rs on (jr1.resume_id=rs.resume_id) where jr1.jobseeker_id='".$_SESSION['sess_jobseekerid']."'";
//echo query;
$result_view=tep_db_query($query_view);
$total_view='0';
while($row_view = tep_db_fetch_array($result_view))
{
$total_view=$total_view + $row_view['viewed'];
}
//echo "total=".$total_view;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$table_names=JOBSEEKER_RESUME1_TABLE." as jr1 ";
$whereClause.="jr1.jobseeker_id='".$_SESSION['sess_jobseekerid']."' order by jr1.inserted desc";
$field_names="jr1.resume_id,jr1.resume_title,jr1.inserted,jr1.updated,jr1.availability_date,jr1.search_status ";//;,sum(rs.viewed) as viewed";

$resume_query_raw="select $field_names from $table_names where $whereClause";
$resume_query = tep_db_query($resume_query_raw);
$resume_query_numrows=tep_db_num_rows($resume_query);
//$available_status='';
if($resume_query_numrows > 0)
{
 while ($resume = tep_db_fetch_array($resume_query))
 {
if($resume_query_numrows > 0)
$jobseeker_status=(tep_not_null($resume['availability_date'])?'Yes':'No');

  /*if(tep_not_null($resume['availability_date']))
  {
   $available_status='<a href="' . tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL, 'action=available_inactive') . '">' . tep_image(PATH_TO_IMAGE.'icon_status_red_light.gif', STATUS_NOT_AVAILABLE, 30, 17) . '</a>&nbsp;' . tep_image(PATH_TO_IMAGE.'icon_status_green.gif', STATUS_AVAILABLE, 30, 17);
  }
  else
  {
   $available_status=tep_image(PATH_TO_IMAGE.'icon_status_red.gif', STATUS_NOT_AVAILABLITY, 30, 17) . '&nbsp;<a href="' . tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL, 'action=available_active') . '">' . tep_image(PATH_TO_IMAGE.'icon_status_green_light.gif', STATUS_AVAILABLITY, 30, 17) . '</a>';
   break;
  }
*/
 }
}

/*$action=((isset($_GET['action']) && ($_GET['action']=='available_active' || $_GET['action']=='available_inactive'))?$_GET['action']:'');
{
 $action = $_GET['action'] ;
}
*/
if(tep_not_null($action))
{
 switch($action)
 {
  case 'available_active':
  case 'available_inactive':
   if($action=='available_active')
   {
    tep_db_query("update ".JOBSEEKER_RESUME1_TABLE." set availability_date=now() where jobseeker_id='".$_SESSION['sess_jobseekerid']."'");
	tep_db_query("update ".JOBSEEKER_TABLE." set jobseeker_cv_searchable='Yes' where jobseeker_id='".$_SESSION['sess_jobseekerid']."'");
    $messageStack->add_session(MESSAGE_SUCCESS_UPDATED_AVAILABLE, 'success');
   }
   else
   {
    tep_db_query("update ".JOBSEEKER_RESUME1_TABLE." set availability_date=NULL where jobseeker_id='".$_SESSION['sess_jobseekerid']."'");
    tep_db_query("update ".JOBSEEKER_TABLE." set jobseeker_cv_searchable='No' where jobseeker_id='".$_SESSION['sess_jobseekerid']."'");
    $messageStack->add_session(MESSAGE_SUCCESS_UPDATED_NOT_AVAILABLE, 'success');
   }
   tep_redirect(FILENAME_JOBSEEKER_CONTROL_PANEL);
  break;
 }
}
$row_contact=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE." as jl left join  ".JOBSEEKER_TABLE." as j on (jl.jobseeker_id=j.jobseeker_id) left join  ".COUNTRIES_TABLE." as c on (j.jobseeker_country_id=c.id) left join ".ZONES_TABLE." as z on(j.jobseeker_state_id=z.zone_id or z.zone_id is NULL)"," jl.jobseeker_id ='".$_SESSION['sess_jobseekerid']."'","j.jobseeker_first_name,j.jobseeker_last_name,j.jobseeker_address1,j.jobseeker_address2,c.".TEXT_LANGUAGE."country_name,if(j.jobseeker_state_id,z.".TEXT_LANGUAGE."zone_name,j.jobseeker_state) as location,j.jobseeker_city,j.jobseeker_zip,j.jobseeker_phone,j.jobseeker_mobile,jl.jobseeker_email_address");
$resume_photo_check=getAnyTableWhereData(JOBSEEKER_RESUME1_TABLE,"jobseeker_id='".$_SESSION['sess_jobseekerid']."' and jobseeker_photo!='' ","jobseeker_photo,resume_id");
$photo='';
if(tep_not_null($resume_photo_check['jobseeker_photo']) && is_file(PATH_TO_MAIN_PHYSICAL_PHOTO.$resume_photo_check['jobseeker_photo']))
{
 $photo = tep_image(FILENAME_IMAGE.'?image_name='.PATH_TO_PHOTO.$resume_photo_check['jobseeker_photo'].'','','');
 $query_string=encode_string("resume_id@@@".$resume_photo_check['resume_id']."@@@resume");
 $photo='<div class="logo-dashboard mr-3">'.$photo.'</div>
 <div class="dashboard-pic"><a href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME5,'query_string='.$query_string).'" class="btn btn-sm btn-text border mt-2"><i class="fa fa-pencil" aria-hidden="true"></i> '.INFO_TEXT_EDIT_PHOTO.'</a></div>';
}
else
{
 if($resume_photo_check1=getAnyTableWhereData(JOBSEEKER_RESUME1_TABLE,"jobseeker_id='".$_SESSION['sess_jobseekerid']."' order by resume_id desc","resume_id"))
 {
  $query_string=encode_string("resume_id@@@".$resume_photo_check1['resume_id']."@@@resume");
  $photo='<div><img src="image/no_pic.gif" class="mr-3 img-thumbnail"></div>
  <div class="dashboard-pic"><a href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME5,'query_string='.$query_string).'" class="btn btn-sm btn-text border mt-2">'.INFO_TEXT_ADD_PHOTO.'</a></div>';
 }
 else
 {
  $photo='<td  bgcolor="#ffffff" height="19" valign="center" width="12%" align="left"><img src="image/no_pic.gif" class="logo-dashboard mr-3 img-thumbnail"><br><a href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME1).'" class="btn btn-sm btn-text border mt-2">'.INFO_TEXT_ADD_PHOTO.'</a></td><td width="2%"><img src="img/dot.gif" height="10" width="10"></td>';
 }
}
$jobseeker_name= tep_db_output($row_contact['jobseeker_first_name']).' '.tep_db_output($row_contact['jobseeker_last_name']);
$template->assign_vars(array(
 'HEADING_TITLE'=>HEADING_TITLE,
 'INFO_TEXT_PHOTO'         => $photo,
	'JOBSEEKER_NAME'          => $jobseeker_name,
 'INFO_TEXT_BRIEFPROFILE'  => INFO_TEXT_BRIEFPROFILE,
 'INFO_TEXT_EMAIL_ADDRESS' => INFO_TEXT_EMAIL_ADDRESS,
 'INFO_TEXT_EMAIL_ADDRESS1'=> tep_db_output($row_contact['jobseeker_email_address']),
 'INFO_TEXT_ADDRESS'       => INFO_TEXT_ADDRESS,
 'INFO_TEXT_ADDRESS1'      => tep_db_output($row_contact['jobseeker_address1'].(tep_not_null($row_contact['jobseeker_address2'])?', '.$row_contact['jobseeker_address2']:'')).(tep_not_null($row_contact['jobseeker_city'])?', '.$row_contact['jobseeker_city']:'').(tep_not_null($row_contact['location'])?', '.$row_contact['location']:'').(tep_not_null($row_contact[TEXT_LANGUAGE.'country_name'])?', '.$row_contact[TEXT_LANGUAGE.'country_name']:''),
 'INFO_TEXT_PHONE'         => INFO_TEXT_PHONE,
 'INFO_TEXT_PHONE1'        => tep_db_output($row_contact['jobseeker_phone']),
 'INFO_TEXT_MOBILE'        => INFO_TEXT_MOBILE,
 'INFO_TEXT_MOBILE1'       => $row_contact["jobseeker_mobile"],
'INFO_TEXT_RESUME_VIEWED'=>INFO_TEXT_RESUME_VIEWED,
'INFO_TEXT_RESUME_VIEWED1'=>$total_view,
 'INFO_TEXT_RESUME_MANAGER'=> INFO_TEXT_RESUME_MANAGER,
 'INFO_TEXT_ADD_RESUMES'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME1).'" class="style39">'.INFO_TEXT_ADD_RESUMES.'</a>',
 'INFO_TEXT_LIST_OF_RESUMES'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_RESUMES).'" class="style39">'.INFO_TEXT_LIST_OF_RESUMES.'</a>'.(($no_of_resumes>0)?" (".$no_of_resumes.")":" "),
// 'INFO_TEXT_AVAILABILITY'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL, 'action=available_active').'"  class="style39">'.INFO_TEXT_AVAILABILITY.'</a> '.$available_status,
'INFO_TEXT_AVAILABILITY'=>tep_draw_form('jstatus', FILENAME_JOBSEEKER_CONTROL_PANEL, '', 'post', '').($jobseeker_status=='Yes'?tep_draw_hidden_field('action','available_inactive'):tep_draw_hidden_field('action','available_active')).'
  <i class="fa fa-angle-right icon-page-title" aria-hidden="true">
</i> '.INFO_TEXT_AVAILABILITY.'<label for="checkbox_jsstatus" class="switch">'.tep_draw_checkbox_field('jobseeker_status','Yes','',$jobseeker_status,' class="inputdemo" id="checkbox_jsstatus" onchange="this.form.submit();"').'<span class="slider round"></span></label></form>',

 'INFO_TEXT_JOBS'          =>INFO_TEXT_JOBS,
 'INFO_TEXT_LIST_OF_SAVED_JOBS'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_SAVED_JOBS).'" class="style39">'.INFO_TEXT_LIST_OF_SAVED_JOBS.'</a>'.(($no_of_saved_jobs>0)?' ('.$no_of_saved_jobs.')':''),
 'INFO_TEXT_LIST_OF_SAVED_JOBS1'=>$no_of_saved_jobs,
 'INFO_TEXT_LIST_OF_APPLICATIONS'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_APPLICATIONS).'" class="style39">'.INFO_TEXT_LIST_OF_APPLICATIONS.'</a>'.(($no_of_applications>0)?" (".$no_of_applications.")":""),
 'INFO_TEXT_MY_MAILS'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_MAILS).'" class="style39">'.INFO_TEXT_MY_MAILS.'</a>'.(($no_of_unread_mail>0)?"(".$no_of_unread_mail.")":""),


 'INFO_TEXT_MY_ACCOUNT'=>INFO_TEXT_MY_ACCOUNT,
 'INFO_TEXT_EDIT_PERSONAL_DETAILS'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'" class="style39">'.INFO_TEXT_EDIT_PERSONAL_DETAILS.'</a>',
 'INFO_TEXT_LIST_OF_COVER_LETTERS'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_COVER_LETTERS).'" class="style39">'.INFO_TEXT_LIST_OF_COVER_LETTERS.'</a>'.(($no_of_cover_letters>0)?" (".$no_of_cover_letters.") ":""),
 'INFO_TEXT_CHANGE_PASSWORD'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_CHANGE_PASSWORD).'" class="style39">'.INFO_TEXT_CHANGE_PASSWORD.'</a>',
 'INFO_TEXT_NEWSLETTER'=>'<a href="'.tep_href_link(FILENAME_LIST_OF_NEWSLETTERS).'" class="style39">'.INFO_TEXT_NEWSLETTER.'</a>',
 'INFO_TEXT_CONTACT_LIST'=>'<a href="'.tep_href_link(FILENAME_RECRUITER_CONTACT_LIST).'" class="style39">'.INFO_TEXT_CONTACT_LIST.'</a>'.(($no_of_contact>0)?" (".$no_of_contact.") ":""),
 'INFO_TEXT_VIDEO_RESUME'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_RESUMES).'" class="style39">'.INFO_TEXT_VIDEO_RESUME.'</a>',
 'INFO_TEXT_LOGOUT'=>'<a href="'.tep_href_link(FILENAME_LOGOUT).'" >'.INFO_TEXT_LOGOUT.'</a>',

	'INFO_TEXT_JOIN_FORUM'    =>'<a href="'.tep_href_link(PATH_TO_FORUM).'" class="style39">'.INFO_TEXT_JOIN_FORUM.'</a>',

 'INFO_TEXT_HEADER_JOB_SEARCH'=>INFO_TEXT_HEADER_JOB_SEARCH,
 'INFO_TEXT_JOB_SEARCH'=>'<a href="'.tep_href_link(FILENAME_JOB_SEARCH).'" class="style39">'.INFO_TEXT_JOB_SEARCH.'</a>',
 'INFO_TEXT_SERCH_BY_LOCATION'=>'<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_LOCATION).'" class="style39">'.INFO_TEXT_SERCH_BY_LOCATION.'</a>',
 'INFO_TEXT_SERCH_BY_CATEGORY'=>'<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'" class="style39">'.INFO_TEXT_SERCH_BY_CATEGORY.'</a>',
 'INFO_TEXT_COMPANY_PROFILE'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_COMPANY_PROFILE).'" class="style39">'.INFO_TEXT_COMPANY_PROFILE.'</a>'.(($no_of_companies>0)?" (".$no_of_companies.")":''),
 'INFO_TEXT_LIST_OF_SAVED_SEARCHES'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_SAVED_SEARCHES).'" class="style39">'.INFO_TEXT_LIST_OF_SAVED_SEARCHES.'</a>'.(($no_of_saved_searches>0)?" ( ".$no_of_saved_searches." )":''),
 'INFO_TEXT_JOB_ALERT_AGENT'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_SAVED_SEARCHES).'" class="style39">'.INFO_TEXT_JOB_ALERT_AGENT.'</a>'.(($no_of_saved_searches>0)?" (".$no_of_saved_searches.")":''),
 'INFO_TEXT_RESUME_STATISTICS'=>'<a href="'.tep_href_link(FILENAME_RESUME_STATISTICS).'" class="style39">'.INFO_TEXT_RESUME_STATISTICS.'</a>',
 'INFO_TEXT_JOBSEEKER_ORDER_HISTORY'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_ACCOUNT_HISTORY_INFO).'" class="style39">'.INFO_TEXT_JOBSEEKER_ORDER_HISTORY.'</a>',
	'INFO_TEXT_JOBS_BY_KEYWORD'=>'<a href="'.tep_href_link(FILENAME_JOB_SEARCH).'" class="style39">'.INFO_TEXT_JOBS_BY_KEYWORD.'</a>',
'JOB_ALERT_BOX'=>'Destaca tu perfil frente a la empresa ideal. ',
'JOB_ALERT_BOX5'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_RATES).'"><i class="fa fa-shopping-cart" aria-hidden="true">
                                                </i>  Planes Wao</a>',

 'LEFT_BOX_WIDTH'=>LEFT_BOX_WIDTH1,
 'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH1,
 'LEFT_HTML'=>LEFT_HTML,
 'RIGHT_HTML'=>RIGHT_HTML,
 'update_message'=>$messageStack->output()));
$template->pparse('control_panel');
?>