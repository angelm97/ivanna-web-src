<?
/*
************************************************************
**********#	Name				      : Shambhu Prasad Patnaik #********
**********#	Company			    : Aynsoft	Pvt. Ltd.   #***********
**********#	Copyright (c) www.aynsoft.com 2004	 #***********
************************************************************
*/
include_once("include_files.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_JOBSEEKER_VIEW_RESUME);
$template->set_filenames(array('view_resume' => 'view_resume.htm', //resume which display from my resume section
'view_resume1' => 'view_resume1.htm',//prinout
'view_resume2' => 'view_resume2.htm',//  download Resume
'view_resume3' => 'view_resume3.htm',//tell to friend
'view_resume4' => 'view_resume4.htm',//contact to me
'book_mark'    => 'view_resume5.htm',//bookmarks
'view_resume6' => 'view_resume6.htm'//general user
));

include_once(FILENAME_BODY);
$jscript_file=PATH_TO_LANGUAGE.$language."/jscript/".'view_resume.js';

//print_r($_SERVER['HTTP_REFERER']);
//print_r($_SESSION);die();
//die();
$action=(isset($_GET['action'])?$_GET['action']:'');
$action1 = (isset($_POST['action1']) ? $_POST['action1'] : '');
$show_detail=false;
$from_application=false;
$adminedit=false;
if(check_login('admin'))
{
$adminedit=true;
}
#################################################################
if(tep_not_null($_GET['query_string2']))
{
if(!check_login("recruiter"))
{
if(tep_not_null($query_string2))
$_SESSION['REDIRECT_URL']=$_SERVER['REQUEST_URI'];
$messageStack->add_session(LOGON_FIRST_MESSAGE, 'error');
tep_redirect(tep_href_link(FILENAME_RECRUITER_LOGIN));
}
}
if(isset($_GET['query_string4']))
{
$resume_id =check_data($_GET['query_string4'],"==","view_resume","search");
$query_string4=encode_string("view_resume==".$resume_id."==search");
$hidden=MESSAGE_JOBSEEKER_PRIVACY;
}
elseif(isset($_GET['query_string6']))
{
$resume_id =check_data($_GET['query_string6'],"==","view_resume_general","search_general");
$query_string6=encode_string("view_resume_general==".$resume_id."==search_general");
$hidden=MESSAGE_JOBSEEKER_PRIVACY;
}
elseif(check_login('recruiter') || ($adminedit==true && !check_login('jobseeker') ))
{
if(isset($_GET['query_string']))///Apply Resume
{
$resume_id =check_data($_GET['query_string'],"=","application_id","application_id");
$from_application=true;
}
else if(isset($_GET['query_string1']))///Resume Search\\\\\\
$resume_id =check_data($_GET['query_string1'],"==","search_id","search");
else if(isset($_GET['query_string2']))//Email Alert\
$resume_id =check_data($_GET['query_string2'],"=","resume_id","resume_id");
$query_string1=encode_string("search_id==".$resume_id."==search");
//if($action=='download')
//////// $show_detail=true;
$hidden=MESSAGE_JOBSEEKER_PRIVACY;
}
else if(check_login("jobseeker"))
{
$show_detail=true;
if(isset($_POST['resume_id']))
$resume_id= $_POST['resume_id'];
else if(isset($_GET['resume']))
$resume_id =check_data($_GET['resume'],"@@@","resume","resume");
else if(isset($_GET['query_string']))
$resume_id =check_data($_GET['query_string'],"@@@","resume_id","resume");
$query_string=encode_string("resume@@@".$resume_id."@@@resume");
$jobseeker_id = $_SESSION['sess_jobseekerid'];
}
else
{
$_SESSION['REDIRECT_URL']=$_SERVER['REQUEST_URI'];
$messageStack->add_session(LOGON_FIRST_MESSAGE, 'error');
tep_redirect(tep_href_link(FILENAME_LOGIN));
}
if($check_resume=getAnyTableWhereData(JOBSEEKER_RESUME1_TABLE," resume_id='".$resume_id."'",'jobseeker_id,resume_id'))
{
$resume_id    = $check_resume['resume_id'];
$jobseeker_id = $check_resume['jobseeker_id'];
}
else
{
$messageStack->add_session(MESSAGE_RESUME_ERROR, 'error');
tep_redirect(FILENAME_ERROR);
}

//////////////////////////////////////////
$add_button='';
$referer =explode('?',$_SERVER['HTTP_REFERER']);
if(check_login("jobseeker"))
{
$add_button.='<a class="btn btn-secondary" href="'.$_SERVER['HTTP_REFERER'].'"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>';
$add_button.='<a id="printt" class="btn btn-secondary" href="#" ><i class="fa fa-print" title="Print" aria-hidden="true"></i></a>';
}
elseif(check_login("recruiter") && (($referer[0]!=HOST_NAME.FILENAME_RECRUITER_SEARCH_RESUME) && $referer[0]!=''))
{
$add_button.='<a class="btn btn-secondary" href="'.tep_href_link(FILENAME_RECRUITER_APPLICANT_TRACKING).'"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>';
$add_button.='<a class="btn btn-secondary" href="#" onclick="popUp(\''.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=print').'\')"><i class="fa fa-print" title="Print" aria-hidden="true"></i></a>';
$add_button.='<a class="btn btn-secondary" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=download').'" ><i class="fa fa-download" title="Download" aria-hidden="true"></i></a>';
$add_button.='<a class="btn btn-secondary" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=send_to_friend').'"><i class="fa fa-share-square" title="Send to Friend" aria-hidden="true"></i></a>';
$add_button.='<a class="btn btn-secondary" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=contact').'"><i class="fa fa-envelope" title="Contact" aria-hidden="true"></i></a>';
$add_button.=tep_draw_form('save_form', FILENAME_JOBSEEKER_VIEW_RESUME, tep_get_all_get_params(), 'post', '').tep_draw_hidden_field('action1','save_resume').'<button type="submit" class="btn btn-secondary"><i class="fa fa-floppy-o" title="Save" aria-hidden="true"></i></button></form>';
$add_button.='<a class="btn btn-secondary" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=book_mark').'"><i class="fa fa-bookmark" title="Bookmark" aria-hidden="true"></i></a>';
}
elseif(check_login("recruiter"))
{
$add_button.=(($_SERVER['HTTP_REFERER']==FILENAME_RECRUITER_SEARCH_RESUME)?tep_draw_form('search_resume', FILENAME_RECRUITER_SEARCH_RESUME,'','post').tep_draw_hidden_field('action','search').'<button type="submit" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></form>':'<a class="btn btn-secondary" href="javascript:history.back();"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>');
$add_button.='<a id="printt" class="btn btn-secondary" href="#" ><i class="fa fa-print" title="Print" aria-hidden="true"></i></a>';
$add_button.='<a id="downl"  class="btn btn-secondary" ><i class="fa fa-download" title="Download" aria-hidden="true"></i></a>';
$add_button.='<a class="btn btn-secondary" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=send_to_friend').'"><i class="fa fa-share-square" title="Send to Friend" aria-hidden="true"></i></a>';
$add_button.='<a class="btn btn-secondary" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=contact').'"><i class="fa fa-envelope" title="Contact" aria-hidden="true"></i></a>';
$add_button.=tep_draw_form('save_form', FILENAME_JOBSEEKER_VIEW_RESUME, tep_get_all_get_params(), 'post', '').tep_draw_hidden_field('action1','save_resume').'<button type="submit" class="btn btn-secondary"><i class="fa fa-floppy-o" title="Save" aria-hidden="true"></i></button></form>';
$add_button.='<a class="btn btn-secondary" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=book_mark').'"><i class="fa fa-bookmark" title="Bookmark" aria-hidden="true"></i></a>';
}
elseif(check_login("admin") && (($referer[0]!=HOST_NAME.FILENAME_RECRUITER_SEARCH_RESUME) && $referer[0]!=''))
{
$add_button.='<a class="btn btn-secondary" href="javascript:history.back();"><i class="fa fa-arrow-left" aria-hidden="true"></i>
</a>';
$add_button.='<a class="btn btn-secondary" href="#" onclick="popUp(\''.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().'action=print').'\')"><i class="fa fa-print" title="Print" aria-hidden="true"></i></a>';
}
else
{
$add_button.='<a class="btn btn-secondary" href="#" onclick="popUp(\''.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params(array('action','query_string4')).'action=print&query_string4='.$query_string4).'\')"><i class="fa fa-print" title="Print" aria-hidden="true"></i></a>';
}
$add_button.='';
////////////// add statistics to this resume starts///////
if((!tep_not_null($action)) && (!tep_not_null($action1)))
{
if(check_login("recruiter"))
{
if($row_check=getAnyTableWhereData(RESUME_STATISTICS_TABLE,"resume_id='".tep_db_input($resume_id)."' and recruiter_id='".$_SESSION['sess_recruiterid']."'"))
{
  $sql_data_array=array('resume_id'=>$resume_id,
  'viewed'=>($row_check['viewed']+1),
  'recruiter_id'=>$_SESSION['sess_recruiterid']
);
tep_db_perform(RESUME_STATISTICS_TABLE, $sql_data_array, 'update', "resume_id='".$resume_id."' and recruiter_id='".$_SESSION['sess_recruiterid']."'");
}
else
{
$sql_data_array=array('resume_id'=>$resume_id,
'viewed'=>1,
'recruiter_id'=>$_SESSION['sess_recruiterid']
);
tep_db_perform(RESUME_STATISTICS_TABLE, $sql_data_array);
}
}
}
////////////// add statistics to this resume ends///////
###############################################################
$table_name   = JOBSEEKER_LOGIN_TABLE." as jl left outer join  ".JOBSEEKER_TABLE."  as j  on (jl.jobseeker_id=j.jobseeker_id) left outer join ".JOBSEEKER_RESUME1_TABLE." as jr  on (j.jobseeker_id=jr.jobseeker_id) left outer join ".JOB_CATEGORY_TABLE." as jc on (jr.job_category=jc.id)";
$fields= "jl.jobseeker_email_address,jobseeker_first_name,jobseeker_middle_name,jobseeker_last_name,jr.jobseeker_nationality,j.jobseeker_address1,j.jobseeker_address2,j.jobseeker_country_id,j.jobseeker_state,j.jobseeker_state_id,j.jobseeker_city,j.jobseeker_zip,j.jobseeker_phone,j.jobseeker_mobile,j.jobseeker_work_phone,jr.objective ,jr.job_type_id ,jr.expected_salary, jr.currency ,jr.expected_salary_per ,jr.target_job_titles ,jr.job_category, jc.category_name, jr.relocate ,jr.jobseeker_resume,jr.jobseeker_resume_text,jr.jobseeker_photo,j.jobseeker_privacy";
$row=getAnyTableWhereData($table_name," jr.jobseeker_id='".$jobseeker_id."' and jr.resume_id='".$resume_id."'",$fields);
if(isset($_GET['query_string6']))
{
$show_detail=false;
}
elseif(check_login('recruiter'))
{
if($from_application)
{
$show_detail=(($row['jobseeker_privacy']==2 || $row['jobseeker_privacy']==3)?true:false);
}
else
{
$show_detail=(($row['jobseeker_privacy']==3)?true:false);
}
}
elseif(isset($_GET['query_string4']))
{
$show_detail=(($row['jobseeker_privacy']==3)?true:false);
}
//print_r($row);
///////////////////////  RETING //////////////////////////////////////////////////////
// add/edit
if(tep_not_null($action1))
{
if(!check_login('recruiter') && ($adminedit==false))
{
$_SESSION['REDIRECT_URL']=$_SERVER['REQUEST_URI'];
$messageStack->add_session(LOGON_FIRST_MESSAGE, 'error');
tep_redirect(tep_href_link(FILENAME_LOGIN));
}
switch($action1)
{
case 'rate_it':
  if(check_login('admin'))
  {
	$adminedit=true;
	$sql_data_array=array('resume_id'=>$resume_id,
	'point'=>tep_db_prepare_input($_POST['rate_it']),
	'admin_rate'=>'Y',
  );
  if($row_rating=getAnyTableWhereData(JOBSEEKER_RATING_TABLE," resume_id='".$resume_id."' and  admin_rate ='Y'",'rating_id'))
  {
	tep_db_perform(JOBSEEKER_RATING_TABLE, $sql_data_array, 'update',"rating_id='".$row_rating['rating_id']."'");
  }
  else
  {
	tep_db_perform(JOBSEEKER_RATING_TABLE, $sql_data_array);
  }
  $messageStack->add_session(MESSAGE_SUCCESS_RATED, 'success');
  tep_redirect(tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params()));
}
if(check_login('recruiter') && $adminedit==false)
{
  $sql_data_array=array('resume_id'=>$resume_id,
  'recruiter_id'=>$_SESSION['sess_recruiterid'],
  'admin_rate'=>'N',
  'point'=>tep_db_prepare_input($_POST['rate_it']),
  'private_notes'=>tep_db_prepare_input($_POST['private_notes']),
);
if($row_rating=getAnyTableWhereData(JOBSEEKER_RATING_TABLE,"recruiter_id='".$_SESSION['sess_recruiterid']."' and resume_id='".$resume_id."'",'rating_id'))
{
  tep_db_perform(JOBSEEKER_RATING_TABLE, $sql_data_array, 'update',"rating_id='".$row_rating['rating_id']."'");
}
else
{
  tep_db_perform(JOBSEEKER_RATING_TABLE, $sql_data_array);
}
$messageStack->add_session(MESSAGE_SUCCESS_RATED, 'success');
}
tep_redirect(tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params()));
break;
case 'bookmark_to_job':
$job_id =(int)tep_db_prepare_input($_POST['job_id']);
if(!$check_row=getAnyTableWhereData(JOB_TABLE," job_id='".$job_id ."' and recruiter_id='".$_SESSION['sess_recruiterid']."'",'job_id'))
{
$messageStack->add_session(MESSAGE_ERROR_JOB_NOT_EXIST, 'error');
tep_redirect(tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params()));
}
if($row=getAnyTableWhereData(APPLICATION_TABLE,"resume_id='".$resume_id."' and jobseeker_id='".$jobseeker_id."' and  job_id='".$job_id."' ","application_id"))
{
$messageStack->add_session(MESSAGE_ERROR_ALREADY_BOOKMARKED, 'error');
tep_redirect(tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params()));
}
$sql_data_array=array('resume_id'     => $resume_id,
'jobseeker_id'  => $jobseeker_id,
'job_id'        => $job_id,
'source'        => 'search_resume',
'inserted'      => 'now()',
);
tep_db_perform(APPLICATION_TABLE, $sql_data_array);
/////////////////////////////////////////////////////////
if($check_row=getAnytableWhereData(JOB_STATISTICS_TABLE,"job_id='".$job_id."'",'applications'))
{
$sql_data_array=array('job_id'=>$job_id,
'applications'=>($check_row['applications']+1)
);
tep_db_perform(JOB_STATISTICS_TABLE, $sql_data_array, 'update', "job_id='".$job_id."'");
}
else
{
$sql_data_array=array('job_id'=>$job_id,
'applications'=>1
);
tep_db_perform(JOB_STATISTICS_TABLE, $sql_data_array);
}
/////////////////////////////////////////////////////////
if($applicant_id=getAnytableWhereData(APPLICATION_TABLE,"jobseeker_id='".$jobseeker_id."' and job_id='".$job_id."' order by inserted desc limit 0,1",'id,job_id'))
{
$row_round =getAnyTableWhereData(SELECTION_ROUND_TABLE," 1 order by value limit 0,1",'*');
$sql_data_array1=array('application_id'=>$applicant_id['id'],
'cur_status'=>1,
'process_round '=>$row_round['id'],
'inserted'=>'now()',
);
//tep_db_perform(APPLICANT_STATUS_TABLE, $sql_data_array1);
$sql_data_array=array('application_id'=>get_job_enquiry_code($applicant_id['job_id']).'-'.($applicant_id['id']+1000));
tep_db_perform(APPLICATION_TABLE, $sql_data_array, 'update', "id = '" .$applicant_id['id']."'");
}
$messageStack->add_session(MESSAGE_SUCCESS_BOOKMARK, 'success');
tep_redirect(tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params()));
break;
case 'save_resume':
$sql_data_array=array('resume_id'=>$resume_id,
'recruiter_id'=>$_SESSION['sess_recruiterid'],
'inserted'=>'now()',
);
if(!$row_rating=getAnyTableWhereData(SAVE_RESUME_TABLE,"recruiter_id='".$_SESSION['sess_recruiterid']."' and resume_id='".$resume_id."'",'resume_id'))
tep_db_perform(SAVE_RESUME_TABLE, $sql_data_array);
$messageStack->add_session(MESSAGE_SUCCESS_SAVED, 'success');
tep_redirect(tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params()));
break;
case 'send':
$query_string4=encode_string("view_resume==".$resume_id."==search");
$recruiter_email   = getAnyTableWhereData(RECRUITER_LOGIN_TABLE," recruiter_id='".$_SESSION['sess_recruiterid']."'",'recruiter_email_address');
$to_name=tep_db_output($_POST['TR_your_friend_full_name']);
$to_email_address=tep_db_output($_POST['TREF_your_friend_email_address']);
$from_email_name=tep_db_output($_POST['TR_your_full_name']);
$from_email_address=tep_db_output($recruiter_email['recruiter_email_address']);
$email_text='<div style="font: normal 12px/17px Verdana, Arial, Helvetica, sans-serif;">'.INFO_TEXT_HI.' <b>'.$to_name.',</b>';
$email_text.='<br>&nbsp;'.INFO_TEXT_YOUR_FRIEND.' <b>'.$from_email_name.'</b> '.INFO_TEXT_HAS_SENT;
$email_text.='<br>&nbsp;'.INFO_TEXT_EMAIL_ADDRESS_IS.' <b>'.$from_email_address.' </b>.';
$email_text.='<br>&nbsp;'.INFO_TEXT_MESSAGE_HIS_HER.'<hr>';
$email_text.='<br>'.INFO_TEXT_RESUME_LINK.'<a style="color:blue;" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,'query_string4='.$query_string4).'">'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,'query_string4='.$query_string4).'</a><br><br>';
$email_text.=nl2br(stripslashes($_POST['TR_message']));
$email_text.='</div>';
$TR_message=(stripslashes($_POST['TR_message']));
$subject=tep_db_output($_POST['TR_subject']);
$error =false;
if(!tep_not_null($from_email_name))
{
$error =true;
$messageStack->add(YOUR_NAME_ERROR, 'error');
}
if(!tep_not_null($to_name))
{
$error =true;
$messageStack->add(YOUR_FRIEND_NAME_ERROR, 'error');
}
if(!tep_not_null($to_email_address))
{
$error =true;
$messageStack->add(YOUR_FRIEND_EMAIL_ERROR, 'error');
}
if(!tep_not_null($subject))
{
$error =true;
$messageStack->add(EMAIL_SUBJECT_ERROR, 'error');
}
if(!tep_not_null($TR_message))
{
$error =true;
$messageStack->add(EMAIL_MESSAGE_ERROR, 'error');
}

if(!$error)
{
tep_mail($to_name , $to_email_address, $subject, $email_text, SITE_OWNER, ADMIN_EMAIL);
$messageStack->add_session(MESSAGE_SUCCESS_SEND_LINK, 'success');
tep_redirect(tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params(array('action'))));
}
else
$action ='send_to_friend';

//$email_text;die();
break;
case 'send1':
$to_name           = tep_db_output($row['jobseeker_first_name'].' '.$row['jobseeker_middle_name'].' '.$row['jobseeker_last_name']);
$to_email_address  = tep_db_output($row['jobseeker_email_address']);
if($company_name   = getAnyTableWhereData(RECRUITER_TABLE.' as r left outer join '.RECRUITER_LOGIN_TABLE.' as rl on (rl.recruiter_id=r.recruiter_id)'," r.recruiter_id='".$_SESSION['sess_recruiterid']."'",'recruiter_company_name,recruiter_email_address'))
$email_text        = tep_db_output(sprintf(INFO_TEXT_DEFALUT,$to_name,$company_name['recruiter_company_name'],$company_name['recruiter_email_address']));
$email_text       .= tep_db_output(nl2br($_POST['TR_message']));
$subject=tep_db_output($_POST['TR_subject']);
tep_mail($to_name , $to_email_address, $subject, $email_text,SITE_OWNER,ADMIN_EMAIL);
$messageStack->add_session(SUCCESS_EMAIL_SENT, 'success');
tep_redirect(tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params().""));
break;
}
}
if(check_login('admin'))
{
$adminedit=true;
$row_rating=getAnyTableWhereData(JOBSEEKER_RATING_TABLE," resume_id='".$resume_id."' and admin_rate='Y'",'point');
$rate_it_array=array();
for($i=1;$i<=5;$i++)
{
$rate_it_array[]=array("id"=>$i,"text"=>$i);
}
$rate_it_string='';
$rate_it_string.=INFO_TEXT_CURRENT_RATE_IT.'';
$rate_it_string.=tep_draw_pull_down_menu('rate_it', $rate_it_array, tep_not_null($row_rating['point'])?$row_rating['point']:'3', '', false);
$rate_it_string.='';
$rate_it_string.=''.tep_image_submit(PATH_TO_BUTTON.'button_rate.gif',IMAGE_RATE).'';
}
if(check_login('recruiter') && $adminedit==false)
{
$row_rating=getAnyTableWhereData(JOBSEEKER_RATING_TABLE," recruiter_id='".$_SESSION['sess_recruiterid']."' and resume_id='".$resume_id."'",'point,private_notes');
$rate_it_array=array();
for($i=1;$i<=5;$i++)
{
$rate_it_array[]=array("id"=>$i,"text"=>$i);
}
$rate_it_string.='<div class="form-group row" id="rate_id_div"><label class="col-md-2 text-right">'.INFO_TEXT_CURRENT_RATE_IT.':</label>';
$rate_it_string.='<div class="col-md-10">'.tep_draw_pull_down_menu('rate_it', $rate_it_array, tep_not_null($row_rating['point'])?$row_rating['point']:'3', '', false).'</div></div>';
$rate_it_string.='';
$rate_it_string.='<div class="form-group row" id="rate_id_div"><label class="col-md-2 text-right">'.INFO_TEXT_PRIVATE_NOTES.':</label>';
$rate_it_string.='<div class="col-md-10">'.tep_draw_textarea_field('private_notes', 'soft', '60', '4', tep_not_null($row_rating['private_notes'])?$row_rating['private_notes']:'', '', '',false).'</div></div>';
$rate_it_string.=''.(check_login("recruiter")?tep_draw_submit_button_field('','Add','class="btn btn-primary mt-1 float-right mb-3"'):'').'';
}
$add_sec_header='';
$add_sec_header1='
';
$add_sec_footer='
';

$add_sec_footer1='';

///////////////////////////////////// Attachment /////////////////////////////////////
$attachment_query="select * from ".JOBSEEKER_RESUME1_TABLE." where resume_id='".$resume_id."' ";
$attachment_result = tep_db_query($attachment_query);
$rows=tep_db_num_rows($attachment_result);
$attachment='';
$r_no=1;
while ($row1= tep_db_fetch_array($attachment_result))
{

$resume_directory=get_file_directory($row1['jobseeker_resume'],6);
if(is_file(PATH_TO_MAIN_PHYSICAL_RESUME.$resume_directory.'/'.stripslashes($row1['jobseeker_resume'])))
{
$resume='';
$query_string3 = encode_string("resume_id@@@".$row1['resume_id']."@@@resume");
$resume="<a href='".tep_href_link(FILENAME_JOBSEEKER_RESUME_DOWNLOAD,(tep_not_null($resume_id)?'query_string='.$query_string3:''))."'>".stripslashes(stripslashes(substr($row1['jobseeker_resume'],14)))."</a>";

$attachment1=$resume;
}
$r_no++;
}
if($attachment1!='')
{
$SECTION_DOCUMENT_UPLOAD=$add_sec_header.SECTION_DOCUMENT_UPLOAD.$attachment1.$add_sec_footer;
$SECTION_DOCUMENT_UPLOAD.=$attachment."</table></td></tr></table> ";
}
///////////////////////////////////// Attachment /////////////////////////////////////
///////////////////////////////////// target_job ////////////////////////////////////////////
$target_category=get_category_name_with_parent(get_name_from_table(RESUME_JOB_CATEGORY_TABLE,'job_category_id','resume_id',tep_db_output($resume_id)));
$target_job.='
<tr>
<th>'.INFO_TEXT_TARGET_JOB_TITLES.'</th>
<td><span class="center-title-resume">:</span></td>
<td><span class="right-title-resume">'.tep_db_output($row['target_job_titles']).'</span></td>
</tr>
<tr>
<th>'.INFO_TEXT_JOB_TYPE.'</th>
<td><span class="center-title-resume">:</span></td>
<td><span class="right-title-resume"> '.(tep_not_null($row['job_type_id'])?get_name_from_table(JOB_TYPE_TABLE,TEXT_LANGUAGE.'type_name', 'id',$row['job_type_id']):INFO_TEXT_ANY_TYPE).'</span></td>
</tr>
<tr>
<th>'.INFO_TEXT_INDUSTRY.'</th>
<td><span class="center-title-resume">:</span></td>
<td><span class="right-title-resume"> '.tep_db_output($target_category).'</span></td>
</tr>
<tr>
<th>'.INFO_TEXT_DESIRED_SALARY.'</th>
<td><span class="center-title-resume">:</span></td>
<td><span class="right-title-resume"> '.(tep_not_null($row['expected_salary'])? get_name_from_table(CURRENCY_TABLE,'code', 'currencies_id',$row['currency']).' '.tep_db_output($row['expected_salary'].'/'.$row['expected_salary_per']):"--").'</span></td>
</tr>';
if($row['relocate']!='')
$target_job.='
<tr>
<th>'.INFO_TEXT_RELOCATE.'</th>
<td><span class="center-title-resume">:</span></td>
<td><span class="right-title-resume"> '.tep_db_output($row['relocate']).'</span></td>
</tr>
';
if($attachment1!='')
$target_job.='
<tr>
<th>Hoja de vida</th>
<td><span class="center-title-resume">:</span></td>
<td class="text-primary">'.$attachment1.'</td>
</tr>';
if($target_job!='')
{
$SECTION_TARGET_JOB='<div class="table-responsive-sm"><table class="table table-sm border-bottom">';
$SECTION_TARGET_JOB.=$target_job."</table></div>";
if($row['job_type_id']=='' && $row['expected_salary']=='' && $row['expected_salary_per']=='' && $row['target_job_titles']=='' && $target_category=='')
$SECTION_TARGET_JOB='';
}
///////////////////////////////////// target_job ////////////////////////////////////////////

////////////////////////// resume_video //////////////////////////

if($video_row=getAnyTableWhereData(JOBSEEKER_RESUME1_TABLE,"resume_id='".$resume_id."'","jobseeker_video"))
{
//	echo $video_row['jobseeker_video'];
if($video_row['jobseeker_video']!='')
{
	$jobseeker_video_link=$video_row['jobseeker_video'];
if (preg_match("/watch\?v=/i",$jobseeker_video_link))
{
  $photo_arr=(explode("watch?v=",(basename($jobseeker_video_link))));
  $photo_vd ='https://img.youtube.com/vi/'.trim($photo_arr[1]).'/2.jpg';
}
elseif (preg_match("#youtu.be/(.*)#i",$jobseeker_video_link,$mat))
$photo_vd ='https://img.youtube.com/vi/'.trim($mat[1]).'/2.jpg';
$vquery_string=encode_string("video_dispaly===".$resume_id."===videoid");
//$video ='<a href="#" onclick=\'popUp1("'.tep_href_link(FILENAME_DISPLAY_VIDEO,"query_string1=".$vquery_string).'")\' ><img width="436" height="273" src="'.$photo_vd.'" alt="" ></a>';

$video='<iframe width="560" height="315" src="'.tep_href_link(FILENAME_DISPLAY_VIDEO,"query_string1=".$vquery_string).'" scrolling="no" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen noscrollbars></iframe>';

}
}
if($video!='')
{
//$SECTION_DOCUMENT_VIDEO.='<section><iframe src="'.tep_href_link(FILENAME_DISPLAY_VIDEO,"query_string1=".$vquery_string).'" frameBorder="0" width="200" height="120" allowfullscreen ></iframe></section>';
$SECTION_DOCUMENT_VIDEO.='<div class="badge-custom">'.SECTION_DOCUMENT_VIDEO.'</div><div class="d-block"></div>';
$SECTION_DOCUMENT_VIDEO.=$video;
}
else
$SECTION_DOCUMENT_VIDEO='';
////////////////////////// resume_video //////////////////////////
///////////////////////////////////// objective_details ////////////////////////////////////////////
$total_experience='';
if($objective_row=getAnyTableWhereData(JOBSEEKER_RESUME1_TABLE,"resume_id='".$resume_id."'","objective,experience_year,experience_month"))
{
if($objective_row['objective']!='')
{
$objective='
<div class="badge-custom">'.INFO_TEXT_OBJECTIVE.'</div>
<p class="m-0 p-0">'.tep_db_output($objective_row['objective']).'</p></div>
';

$objective2='<div class="aboutme">
<div class="head">
	<div class="icon">
		<svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
			<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
		  </svg>
	</div>
	<div class="title">
		<p>Sobre Mi</p>
	</div>
</div>
<div class="body">
	<p> '. tep_db_output($objective_row['objective']) .' 
	</p>
</div>
</div>';

}
if($objective_row['experience_year']>0 || $objective_row['experience_month']>0)
{
$experience_string='';
if($objective_row['experience_year']>1)
$experience_string=$objective_row['experience_year'].' '.INFO_TEXT_YEARS;
elseif($objective_row['experience_year']>0)
$experience_string=$objective_row['experience_year'].' '.INFO_TEXT_YEAR;
if($objective_row['experience_month']>1)
$experience_string.=$objective_row['experience_month'].' '.INFO_TEXT_MONTHS;
elseif($objective_row['experience_month']>0)
$experience_string.=$objective_row['experience_month'].' '.INFO_TEXT_MONTH;

$total_experience='
<tr class="">
<th class="" colspan="2" width="40%">'.tep_db_output(INFO_TEXT_WORK_EXPERIENCE).'</th>
<td align="left" colspan="4">'.tep_db_output($experience_string).'</td>
</tr>
';
}

}
if($objective!='')
{
$SECTION_OBJECTIVE2= $objective2 ;
}

if($objective!='')
{
$SECTION_OBJECTIVE='<div class="resume-right-format">'.$objective.'</div>';
}
else
$SECTION_OBJECTIVE='';

///////////////////////////////////// end professional_details ////////////////////////////////////////////
///////////////////////    Work History  /////////////////////////////////////////////////////
$work_history_query="select * from ".JOBSEEKER_RESUME2_TABLE." where resume_id='".$resume_id."' order by start_year desc ,start_month desc";
$work_history_result = tep_db_query($work_history_query);
$rows=tep_db_num_rows($work_history_result);
$work_history='';
if($rows>0)
{
$work_history.='
<tr class="table-border-data">
<th class="resume-table-head">'.INFO_TEXT_COMPANY.'</th>
<th class="resume-table-head">'.INFO_TEXT_JOB_TITLE.'</th>
<th class="resume-table-head">'.INFO_TEXT_INDUSTRY.'</th>
<th class="resume-table-head">'.INFO_TEXT_LOCATION.'</th>
<th class="resume-table-head">'.INFO_TEXT_JOB_PERIOD.'</th>
<th class="resume-table-head">'.INFO_TEXT_RELATED_INFO.'</th>
</tr>
';

$work_history2='<div class="experiences">
<div class="head">
	<div class="icon">
		<svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
			<path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
			<path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
		  </svg>
	</div>
	<div class="title">
		<p>Experiencia</p>
	</div>
</div>
<div class="body">';


}
$r_no=1;
while ($row1= tep_db_fetch_array($work_history_result))
{
if($row1['start_month'] >0 and  $row1['start_year']>0  )
$start_date=formate_date($row1['start_year'].'-'.$row1['start_month'].'-1',"M Y");
else
$start_date='-';

if($row1['end_month']>0 and  $row1['end_year']>0  )
$end_date=formate_date($row1['end_year'].'-'.$row1['end_month'].'-1',"M Y");
elseif($row1['still_work']=='Yes'  )
$end_date='still working ';
else
$end_date='-';
$description='';

if(tep_db_output($row1['state_id']) > 0)
$state_display=get_name_from_table(ZONES_TABLE,TEXT_LANGUAGE.'zone_name', 'zone_id',tep_db_output($row1['state_id']));
else
$state_display=tep_db_output($row1['state']);

$work_history.='<tr>
<td  align="left" width="15%"> '.tep_db_output($row1['company']).'</td>
<td align="left" width="15%">'.tep_db_output($row1['job_title']).'</td>
<td align="left"  width="20%">'.get_name_from_table(JOB_CATEGORY_TABLE,TEXT_LANGUAGE.'category_name', 'id',tep_db_output($row1['company_industry'])).'</td>
<td align="left" width="15%"> '.get_name_from_table(COUNTRIES_TABLE,TEXT_LANGUAGE.'country_name', 'id',tep_db_output($row1['country'])).', '.tep_db_output($row1['city']).'</td>
<td align="left" width="15%"> '.$start_date.'-'.$end_date.'</td>
<td  align="left" width="20%">
'.($row1['description']!=''?nl2br(tep_db_output($row1['description'])):'---').'</td>
</tr>';

$work_history2.='<div class="experience">
<div class="nameanddate">
	<p class="empresaname"> > '.tep_db_output($row1['company']).' </p>
	<p class="date"> '.$start_date.'-'.$end_date.' </p>
</div>
<div class="experiencedesp">
	<p> '.($row1['description']!=''?nl2br(tep_db_output($row1['description'])):'---').'
	</p>
</div>
</div>';

$r_no++;
}

$work_history2.= '</div>
</div>';
tep_db_free_result($work_history_result);

if($work_history2!='')
{
$SECTION_WORK_HISTORY_DETAIL2 = $work_history2;
}


if($work_history!='' || $total_experience!='')
{
$SECTION_WORK_HISTORY_DETAIL.='<div class="badge-custom">Experiencia laboral</div>
<div class="table-responsive-sm">
<table class="table table-sm">'.$total_experience.$work_history."</table></div>";
}
///////////////////////    end Work History  /////////////////////////////////////////////////////

///////////////////////////////////// reference_details //////////////////////////////////////////
$reference_query="select * from ".JOBSEEKER_RESUME6_TABLE." where resume_id='".$resume_id."' ";
$reference_result = tep_db_query($reference_query);
$rows=tep_db_num_rows($reference_result);
$reference='';
if($rows>0)
{
$reference='
<tr class="table-border-data">
<th class="resume-table-head">'.INFO_TEXT_REFERENCE_NAME.' </th>
<th class="resume-table-head">'.INFO_TEXT_COMPANY_NAME.'</th>
<th class="resume-table-head">'.INFO_TEXT_LOCATION.'</th>
<th class="resume-table-head">'.INFO_TEXT_POSITION_TITLE.'</th>
<th class="resume-table-head">'.INFO_TEXT_CONTACT_DETAILS.'</th>
<th class="resume-table-head">'.INFO_TEXT_RELATIONSHIP.'</th>
</tr>';
}
$r_no=1;
while ($row1= tep_db_fetch_array($reference_result))
{
$reference.='<tr>
<td width="15%" align="left">'.tep_db_output($row1['name']).'</td>
<td align="left" width="15%">'.tep_db_output($row1['company_name']).'</td>
<td  align="left" width="15%"> '.get_name_from_table(COUNTRIES_TABLE,TEXT_LANGUAGE.'country_name', 'id',tep_db_output($row1['country'])).'</td>
<td  width="15%">'.tep_db_output($row1['position_title']).'</td>
<td align="left" width="20%"><a href="mailto:"'.tep_db_output($row1['email_address']).'">'.tep_db_output($row1['email_address']).'</a><br>'.tep_db_output($row1['contact_no']).'</td>
<td width="20%" align="left">'.tep_db_output($row1['relationship']).'</td>
</tr>';
if($rows!=$r_no)
$reference.='';


$r_no++;
}
tep_db_free_result($reference_result);
if($reference!='')
{
$SECTION_REFERENCE_DETAILS='
<div class="badge-custom">'.SECTION_REFERENCE_DETAILS.'</div>
<div class="table-responsive-sm">
<table class="table table-sm">';
$SECTION_REFERENCE_DETAILS.=$reference."</table></div>";
}
///////////////////////////////////// end reference_details ////////////////////////////////////////////

/////////////////////////////////////EDUCATION_details///////////
$education_query="select * from ".JOBSEEKER_RESUME3_TABLE." where resume_id='".$resume_id."' ";
$education_result = tep_db_query($education_query);
$rows=tep_db_num_rows($education_result);
$education='';
$r_no=1;
if($rows>0)

$education.='<div class="badge-custom">Educaci�n</div>
<div class="table-responsive-sm">
<table class="table table-sm">
<tr class="table-border-data">
<th class="resume-table-head">'.INFO_TEXT_DEGREE.' </th>
<th class="resume-table-head">'.INFO_TEXT_INSTITUTION_NAME.'</th>
<th class="resume-table-head">'.INFO_TEXT_COURSE_DURATION.'</th>
<th class="resume-table-head">'.INFO_TEXT_LOCATION.'</th>
<th class="resume-table-head">'.INFO_TEXT_RELATED_INFO.'</th>
</tr>
';

$education2='<div class="educations">
<div class="head">
	<div class="icon">
		<svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
			<path fill-rule="evenodd" d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z"/>
			<path fill-rule="evenodd" d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z"/>
		  </svg>
	</div>
	<div class="title">
		<p>Educacion</p>
	</div>
</div>
<div class="body">';

while ($row1= tep_db_fetch_array($education_result))
{
$start_date=$end_date='';
if($row1['start_year']>0 && $row1['start_month']>0)
$start_date  = formate_date(tep_db_output($row1['start_year']).'-'.tep_db_output($row1['start_month']).'-01'," M Y ");
if($row1['end_year']>0 && $row1['end_month']>0)
$end_date  = formate_date(tep_db_output($row1['end_year']).'-'.tep_db_output($row1['end_month']).'-01'," M Y ");

$education2.='<div class="education">
<div class="nameanddate">
	<p class="empresaname"> > '.(tep_not_null($row1['school'])?tep_db_output($row1['school']):'---').' </p>
	<p class="date">'.$start_date.'-'.$end_date.'</p>
</div>
<div class="educationdesp">
	<p> '.tep_db_output($row1['related_info']).'
	</p>
</div>
</div>';

$education.='<tr>
<td>'.get_name_from_table(EDUCATION_LEVEL_TABLE,TEXT_LANGUAGE.'education_level_name', 'id',tep_db_output($row1['degree'])).(tep_not_null($row1['specialization'])?' ('.tep_db_output($row1['specialization']).')':'').'</td>
<td>'.(tep_not_null($row1['school'])?tep_db_output($row1['school']):'---').'</td>
<td>'.$start_date.'-'.$end_date.'</td>
<td>'.get_name_from_table(COUNTRIES_TABLE,TEXT_LANGUAGE.'country_name', 'id',tep_db_output($row1['country'])).','.tep_db_output($row1['city']).'</td>
<td>'.tep_db_output($row1['related_info']).'</td>
</tr>';
/*if(tep_not_null($row1['related_info']))
$education.= '<tr>
<td  class="resume-table-head" valign="top" width="20%">'.INFO_TEXT_RELATED_INFO.' </td>
<td class="resume_content2" align="left" colspan="3">'.tep_db_output($row1['related_info']).'</td>
</tr>';
$r_no++;
*/
}

$education2.='</div>
</div>';
tep_db_free_result($education_result);
$education.='</table></div>';
if($education2!='')
{
$SECTION_EDUCATION_DETAILS2= $education2 ;
}

if($education!='')
{
$SECTION_EDUCATION_DETAILS='<div class="resume-right-format">'.$education.'</div>';
}
///////////////////////////////////// end EDUCATION_details ////////////////////////////////////////////



///////////////////////////////////// CUT_PASTE RESUME Print/////////////////////////////////////
$cut_paste_query="select * from ".JOBSEEKER_RESUME1_TABLE." where resume_id='".$resume_id."' ";
$cut_paste_result = tep_db_query($cut_paste_query);
$rows=tep_db_num_rows($cut_paste_result);
$cut_paste_resume='';
$r_no=1;

while ($row1= tep_db_fetch_array($cut_paste_result))
{
$cv_text=stripslashes($row1['jobseeker_resume_text']);
if($row1['jobseeker_resume_text']!='')
{
$cut_paste_resume.='<div class="badge-custom">Hoja de vida</div>
<div class="table-responsive-sm">
<table class="table table-sm">
<tr>
<td colspan="3" style="" bgcolor="#fff">'.$cv_text.'</td>
</tr>
';
}
$r_no++;
}
$cut_paste_resume.='</table></div>';
if($cut_paste_resume!='')
{
$SECTION_DOCUMENT_UPLOAD_PRINT.="<div class='resume-right-format'>".$cut_paste_resume."</div>";
}
///////////////////////////////////// CUT_PASTE RESUME ///////////
///////////////////////////////////// skills_details///////////
$skills_query="select * from ".JOBSEEKER_RESUME4_TABLE." where resume_id='".$resume_id."' ";
$skills_result = tep_db_query($skills_query);
$rows=tep_db_num_rows($skills_result);
$skills='';
$r_no=1;
if($rows>0){ 
$skills2='<div class="languages">
<div class="titleinfo">
	<h3 style="font-size:24px">Habilidades</h3>
</div>';
$skills.='<div class="badge-custom">Habilidades</div>
<div class="table-responsive-sm">
<table class="table table-sm">
<tr class="table-border-data">
<th class="resume-table-head">'.INFO_TEXT_SKILL.' </th>
<th class="resume-table-head">'.INFO_TEXT_SKILL_LEVEL.'</th>
<th class="resume-table-head">'.INFO_TEXT_LAST_USED.'</th>
<th class="resume-table-head">'.INFO_TEXT_YEARS_OF_EXP.'</th>
</tr>
';

while ($row1= tep_db_fetch_array($skills_result))
{

	if(get_name_from_table(SKILL_LEVEL_TABLE,TEXT_LANGUAGE.'skill_name', 'id',tep_db_output($row1['skill_level'])) == 'Principiante'){
		$nivelskill = '<div class="level-lenguage">
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
		<div class="pointgris"></div>
		<div class="pointgris"></div>
		<div class="pointgris"></div>
		<div class="pointgris"></div>
	</div>';
	}
	if(get_name_from_table(SKILL_LEVEL_TABLE,TEXT_LANGUAGE.'skill_name', 'id',tep_db_output($row1['skill_level'])) == 'Nivel Medio'){
		$nivelskill = '<div class="level-lenguage">
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
		<div class="pointgris"></div>
		<div class="pointgris"></div>
	</div>';
	}
	if(get_name_from_table(SKILL_LEVEL_TABLE,TEXT_LANGUAGE.'skill_name', 'id',tep_db_output($row1['skill_level'])) == 'Experto/a'){
		$nivelskill = '<div class="level-lenguage">
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
		<div class="pointblanco"></div>
	</div>';
	}
$skills2.='<div class="language">
<p style="font-size:16px !important; color:white !important;">'.tep_db_output($row1['skill']).'</p>
'. $nivelskill .'
</div>';
$skills.='<tr>
<td>'.tep_db_output($row1['skill']).'</td>
<td>'.get_name_from_table(SKILL_LEVEL_TABLE,TEXT_LANGUAGE.'skill_name', 'id',tep_db_output($row1['skill_level'])).'</td>
<td> '.get_name_from_table(SKILL_LAST_USED_TABLE,'skill_last_used', 'id',tep_db_output($row1['last_used'])).'</td>
<td>'.tep_db_output($row1['years_of_exp']).'</td>
</tr>';
$r_no++;
}

$skills.='</table></div>';
$skills2.='</div>';
tep_db_free_result($skills_result);

}

if($skills2!='')
{
$SECTION_SKILLS2= $skills2;
}

if($skills!='')
{
$SECTION_SKILLS='<div class="resume-right-format">'.$skills."</div>";
}

///////////////////////////////////// end skills_details ////////////////////////////////////////////
///////////////////////////////////// certifICATION       ////////////////////////////////////////// xxx

$skills_query="select id_certification AS name from jobseeker_certifications c where c.id_jobseeker='".$jobseeker_id."'";
$skills_result = tep_db_query($skills_query);
$rows=tep_db_num_rows($skills_result);
$certification='';
$r_no=1;

if($rows>0){

$certification=' <div class="follow">
<div class="titleinfo">
	<h3 style="font-size:24px">Certificaciónes</h3>
</div>';

while ($row1= tep_db_fetch_array($skills_result))
{

$certification.='<div class="p">
<svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-award-fill" viewBox="0 0 16 16">
	<path d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z"/>
	<path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
  </svg>
<p class="contactp" style="color:white !important;">'.$row1['name'].'</p>
</div>';

$r_no++;
}
$certification.='</div>';

}



tep_db_free_result($skills_result);

if($certification!='')
{
$view_certification= $certification;
}

///////////////////////////////////// end certification //////////////////////////////////////////////
///////////////////////////////////// language_details ////////////////////////////////////////////
$language_query="select * from ".JOBSEEKER_RESUME5_TABLE." where resume_id='".$resume_id."' ";
$language_result = tep_db_query($language_query);
$rows=tep_db_num_rows($language_result);
$language='';
$r_no=1;
if($rows>0)
{
$language='
<tr  class="table-border-data">
<th class="resume-table-head">'.INFO_TEXT_LANGUAGE.'</th>
<th class="resume-table-head">'.INFO_TEXT_PROFICIENCY.'</th>
</tr>
';
$language2='<div class="languages">
<div class="titleinfo">
	<h3 style="font-size:24px">Idiomas</h3>
</div>';
while ($row1= tep_db_fetch_array($language_result))
{
$language.='<tr  class="table-border-data">
<td>'.get_name_from_table(JOBSEEKER_LANGUAGE_TABLE,'name', 'languages_id',tep_db_output($row1['language'])).'</td>
<td>'.get_name_from_table(LANGUAGE_PROFICIENCY_TABLE,TEXT_LANGUAGE.'language_proficiency', 'id',tep_db_output($row1['proficiency'])).'</td>
</tr>';
//	if($rows!=$r_no)
//$language.='<tr><td colspan="4"></td></tr>';

if (get_name_from_table(LANGUAGE_PROFICIENCY_TABLE,TEXT_LANGUAGE.'language_proficiency', 'id',tep_db_output($row1['proficiency'])) == 'Básico') {
	$nivellanguage = '<div class="level-lenguage">
	<div class="pointblanco"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
</div>';
}
if (get_name_from_table(LANGUAGE_PROFICIENCY_TABLE,TEXT_LANGUAGE.'language_proficiency', 'id',tep_db_output($row1['proficiency'])) == 'Básico Intermedio') {
	$nivellanguage = '<div class="level-lenguage">
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
</div>';
}
if (get_name_from_table(LANGUAGE_PROFICIENCY_TABLE,TEXT_LANGUAGE.'language_proficiency', 'id',tep_db_output($row1['proficiency'])) == 'Intermedio') {
	$nivellanguage = '<div class="level-lenguage">
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
</div>';
}
if (get_name_from_table(LANGUAGE_PROFICIENCY_TABLE,TEXT_LANGUAGE.'language_proficiency', 'id',tep_db_output($row1['proficiency'])) == '	Intermedio Avanzado') {
	$nivellanguage = '<div class="level-lenguage">
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointgris"></div>
	<div class="pointgris"></div>
</div>';
}
if (get_name_from_table(LANGUAGE_PROFICIENCY_TABLE,TEXT_LANGUAGE.'language_proficiency', 'id',tep_db_output($row1['proficiency'])) == 'Avanzado') {
	$nivellanguage = '<div class="level-lenguage">
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointgris"></div>
</div>';
}
if (get_name_from_table(LANGUAGE_PROFICIENCY_TABLE,TEXT_LANGUAGE.'language_proficiency', 'id',tep_db_output($row1['proficiency'])) == 'Nativo') {
	$nivellanguage = '<div class="level-lenguage">
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>
	<div class="pointblanco"></div>

</div>';
}
if (get_name_from_table(LANGUAGE_PROFICIENCY_TABLE,TEXT_LANGUAGE.'language_proficiency', 'id',tep_db_output($row1['proficiency'])) == 'No Aplica') {
	$nivellanguage = '---';
}

$language2.='<div class="language">
<p style="font-size:16px !important; color:white !important;">'.get_name_from_table(JOBSEEKER_LANGUAGE_TABLE,'name', 'languages_id',tep_db_output($row1['language'])).'</p>
'.$nivellanguage.'
</div>';


$r_no++;
}
$language2 .= '</div>';
}
tep_db_free_result($language_result);



if($language2!='')
{
	$SECTION_LANGUAGES2 = $language2;
}
if($language!='')
{
$SECTION_LANGUAGES= '
<div class="badge-custom">'.SECTION_LANGUAGES.'</div>
<div class="table-responsive-sm">
<table class="table table-sm">';
$SECTION_LANGUAGES.=$language."</table></div>";
}
///////////////////////////////////// end language_details ////////////////////////////////////////////

$query_string2=encode_string("resume_id".$resume_id."resume_id");
$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>"All Category"));

/*--------------------left side--------------------------*/
if(check_login("jobseeker"))
{
$search_left_bar='
<!--
<td><div class="search-applicant-box">
'.tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').
tep_draw_input_field('keyword','','placeholder="e.g. Sales Executive" type="text" class="form-control mb-2"',false).
LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control mb-2'","All Locations","",DEFAULT_COUNTRY_ID).
tep_draw_pull_down_menu('job_category[]', $cat_array, '', 'class="form-control mb-2"').'
'.
experience_drop_down('name="experience" class="form-control mb-2"', 'Experience', '', $experience).'
<input type="submit" name="login2" value="search now" class="btn btn-primary btn-block mb-2" />
</form>
<center>
<a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Advanced search</a>
</center>
</div></td>
-->

'.tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').'
<div class="form-group">
'.tep_draw_input_field('keyword','','placeholder="e.g. Sales Executive" type="text" class="form-control"',false).'
</div>
<div class="form-group">
'.LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control'","All Locations","",DEFAULT_COUNTRY_ID).'
</div>
<div class="form-group">
'.tep_draw_pull_down_menu('job_category[]', $cat_array, '', 'class="form-control"').'
</div>
<div class="form-group">
'.experience_drop_down('name="experience" class="form-control mb-2"', 'Experience', '', $experience).'
</div>
<input type="submit" name="login2" value="search now" class="btn btn-primary btn-block mb-2" />
</form>
<div class="form-group text-center">
<a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Advanced search</a>
</div>
';
$applicant_tracking='';
}
else
{
$search_left_bar='
'.tep_draw_form('search_resume', FILENAME_RECRUITER_SEARCH_RESUME,'','post').tep_draw_hidden_field('action','search').'
<div class="form-group">
'.tep_draw_input_field('keyword','','placeholder="e.g. Sales Executive" type="text" class="form-control"',false).'
</div>
<div class="form-group">
'.LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control'","All Locations","",DEFAULT_COUNTRY_ID).'
</div>
<div class="form-group">
'.tep_draw_pull_down_menu('industry_sector[]', $cat_array, '', 'class="form-control"').'
</div>
<div class="form-group">
'.experience_drop_down('name="experience" class="form-control mb-2"', 'Experience', '', $experience).'
</div>
<input type="submit" name="login2" value="search now" class="btn btn-primary btn-block mb-2" />
</form>
<div class="form-group text-center">
<a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Advanced search</a>
</div>';
$applicant_tracking='
<div class="card mt-3 for-mobile">
<div class="card-header">
Applicant Tracking
</div>
<div class="card-body">
<div><i class="fa fa-angle-right" aria-hidden="true"></i> <a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS).'">All Applicants</a></div>
<div><i class="fa fa-angle-right" aria-hidden="true"></i> <a href="'.tep_href_link(FILENAME_RECRUITER_APPLICATION_REPORT).'">Applicant Pipeline</a></div>
<div><i class="fa fa-angle-right" aria-hidden="true"></i> <a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS).'">Search Applicants</a></div>
<div><i class="fa fa-angle-right" aria-hidden="true"></i> <a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_SELECTD_APPLICANT).'">Selected Applicants</a></div>
</div>
</div>
';
}
/*--------------------------------------------------------------------*/
/*-----------------------------------------------------------phone display---------------------------------------------*/
$all_phone_numbers='';
$phone_mobile = $row['jobseeker_mobile'];
if(!$show_detail)
{
$all_phone_numbers=''.$hidden.'';
}
else
{
$phone_mobile = $row['jobseeker_mobile'];
$all_phone_numbers.=($row['jobseeker_phone']!='' || $row['jobseeker_work_phone']!='' || $row['jobseeker_mobile']!='' ?'':'');
$all_phone_numbers.=($row['jobseeker_phone']!=''?tep_db_output($row['jobseeker_phone']):'');
$all_phone_numbers.=($row['jobseeker_work_phone']!=''?'   '.tep_db_output($row['jobseeker_work_phone']):'');
$all_phone_numbers.=($row['jobseeker_mobile']!=''?'   '.tep_db_output($row['jobseeker_mobile']):'');
$all_phone_numbers.=($row['jobseeker_phone']!='' || $row['jobseeker_work_phone']!='' || $row['jobseeker_mobile']!='' ?'</span>':'');
}

$link_api_whatsapp = "https://wa.me/" . "1" . $phone_mobile ."?text=";
/*-----------------------------------------------------------------------------------------------------------------------*/


$template->assign_vars(array(
'HEADING_TITLE'             => HEADING_TITLE,
'RATE_RESUME_BUTTON_FOR_REC'=>(check_login("jobseeker")?'':'<a class="btn btn-sm btn-outline-warning mb-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-star" title="Print" aria-hidden="true"></i> Califica este perfil</a>'),
'INFO_TEXT_CURRENT_RATING'  =>(check_login('recruiter') || ($adminedit==true)?INFO_TEXT_CURRENT_RATING:''),
'INFO_TEXT_CURRENT_RATING1' =>(check_login('recruiter') || ($adminedit==true)?(tep_not_null($row_rating['point'])?number_format($row_rating['point'],1):INFO_TEXT_NOT_RATED):''),
'INFO_TEXT_CURRENT_RATE_IT' =>(check_login("recruiter") || ($adminedit==true)?INFO_TEXT_CURRENT_RATE_IT:''),
'INFO_TEXT_CURRENT_RATE_IT1'=>(check_login("recruiter") || ($adminedit==true)?$rate_it_string:''),
'rate_form'=>tep_draw_form('rate_form', FILENAME_JOBSEEKER_VIEW_RESUME, tep_get_all_get_params(), 'post', '').tep_draw_hidden_field('action1','rate_it'),
'comment_start'=>(check_login('recruiter') || ($adminedit==true)?'':'<!--'),
'comment_end'=>(check_login('recruiter') || ($adminedit==true)?'':'-->'),
'SECTION_RATE_RESUME'       => SECTION_RATE_RESUME,
'SECTION_PERSONAL_PROFILE'  => SECTION_PERSONAL_PROFILE,
'add_button'                => $add_button,
'INFO_TEXT_NAME'            => INFO_TEXT_NAME,
'INFO_TEXT_FULL_NAME1'      => tep_db_output($row['jobseeker_first_name'].' '.$row['jobseeker_middle_name'].' '.$row['jobseeker_last_name']),
'INFO_TEXT_TARGET_JOB'=>tep_db_output($row['target_job_titles']),
'INFO_TEXT_NATIONALITY'     => INFO_TEXT_NATIONALITY,
'INFO_TEXT_NATIONALITY1'	 => get_name_from_table(COUNTRIES_TABLE,TEXT_LANGUAGE.'country_name','id',$row['jobseeker_nationality']),
'INFO_TEXT_EMAIL_ADDRESS'   => INFO_TEXT_EMAIL_ADDRESS,
'INFO_TEXT_EMAIL_ADDRESS1'  => ((!$show_detail)?'<span class="small_red">'.$hidden.'</span>':'<a style="color: white !important;"  href="mailto:'.tep_db_output($row['jobseeker_email_address']).'">'.tep_db_output($row['jobseeker_email_address']).'</a></span>'),
'INFO_TEXT_HOME_PHONE'      => INFO_TEXT_HOME_PHONE,
'INFO_TEXT_HOME_PHONE1'     => ((!$show_detail)?'<span class="small_red">'.$hidden.'</span>':tep_db_output($row['jobseeker_phone'])),
'INFO_TEXT_MOBILE'          => INFO_TEXT_MOBILE,
'INFO_TEXT_MOBILE1'         => ((!$show_detail)?'<span class="small_red">'.$hidden.'</span>':(($row['jobseeker_mobile']!='')? ', '.$row['jobseeker_mobile']:'')),
'INFO_TEXT_WORK_PHONE'      => INFO_TEXT_WORK_PHONE,
'INFO_TEXT_WORK_PHONE1'     => ((!$show_detail)?'<span class="small_red">'.$hidden.'</span>':(($row['jobseeker_work_phone']!='')?tep_db_output($row['jobseeker_work_phone']):'')),
'INFO_TEXT_ALL_PHONE'       => $all_phone_numbers,
'API_WHATSAPP'              => $link_api_whatsapp,
'INFO_TEXT_ADDRESS'         => INFO_TEXT_ADDRESS,
'INFO_TEXT_ADDRESS1'        => ((!$show_detail)?'<span class="small_red">'.$hidden.'</span>':tep_db_output($row['jobseeker_address1'].(tep_not_null($row['jobseeker_address2'])?', '.$row['jobseeker_address2']:'').(tep_not_null($row['jobseeker_city'])?', '.$row['jobseeker_city']:'').(tep_not_null($row['jobseeker_zip'])?', '.$row['jobseeker_zip']:'').($row['jobseeker_state_id'] > 0?', '.get_name_from_table(ZONES_TABLE,TEXT_LANGUAGE.'zone_name','zone_id',$row['jobseeker_state_id']):(tep_not_null($row['jobseeker_state'])?', '.$row['jobseeker_state']:'')).(tep_not_null($row['jobseeker_country_id'])?', '.get_name_from_table(COUNTRIES_TABLE,TEXT_LANGUAGE.'country_name','id',$row['jobseeker_country_id']):''))),
'INFO_TEXT_BASE_URL'        => '<base href="'.tep_href_LINK('').'"/>',

'INFO_TEXT_CATEGORY1'=>$row['category_name'],

'INFO_TEXT_CATEGORY'        => INFO_TEXT_CATEGORY,
'INFO_TEXT_GRADE'           =>INFO_TEXT_GRADE,
'INFO_TEXT_SPECIALITY'      =>INFO_TEXT_SPECIALITY,
'INFO_TEXT_SKILL_SETS'      =>INFO_TEXT_SKILL_SETS,
'INFO_TEXT_JOB_TYPE'        =>INFO_TEXT_JOB_TYPE,
'INFO_TEXT_RELOCATE'        =>INFO_TEXT_RELOCATE,
'INFO_TEXT_AVAILABILITY'    =>INFO_TEXT_AVAILABILITY,

'INFO_TEXT_DEGREE'          =>INFO_TEXT_DEGREE,
'INFO_TEXT_UNIVERSITY'      =>INFO_TEXT_UNIVERSITY,
'INFO_TEXT_DEGREE_OBT_DATE' =>INFO_TEXT_DEGREE_OBT_DATE,

'INFO_TEXT_CERTIFICATE'     =>INFO_TEXT_CERTIFICATE,
'INFO_TEXT_ISSUED_BY'       =>INFO_TEXT_ISSUED_BY,
'INFO_TEXT_LICENSE_DATE_OBTAINED'=>INFO_TEXT_LICENSE_DATE_OBTAINED,
'INFO_TEXT_EXPIRY_DATE'     =>INFO_TEXT_EXPIRY_DATE,

'INFO_TEXT_COUNTRY'         => INFO_TEXT_COUNTRY,
'INFO_TEXT_BOARD'           => INFO_TEXT_BOARD,
'INFO_TEXT_DATE_OBTAINED'   => INFO_TEXT_DATE_OBTAINED ,

'INFO_TEXT_SOCIETY'         => INFO_TEXT_SOCIETY,
'INFO_TEXT_TYPE'            => INFO_TEXT_TYPE,
'INFO_TEXT_DATE'            => INFO_TEXT_DATE,
'INFO_TEXT_PRINT_RESUME'    =>INFO_TEXT_PRINT_RESUME,

'SECTION_OBJECTIVE'         => $SECTION_OBJECTIVE,
'SECTION_OBJECTIVE2'         => $SECTION_OBJECTIVE2, 
'view_certification'         => $view_certification,
'SECTION_WORK_HISTORY_DETAIL'=> $SECTION_WORK_HISTORY_DETAIL,
'SECTION_WORK_HISTORY_DETAIL2'=> $SECTION_WORK_HISTORY_DETAIL2,
'SECTION_REFERENCE_DETAILS' => $SECTION_REFERENCE_DETAILS,
'SECTION_EDUCATION_DETAILS' => $SECTION_EDUCATION_DETAILS,
'SECTION_EDUCATION_DETAILS2' => $SECTION_EDUCATION_DETAILS2,
'SECTION_AFFILIATIONS'      => $SECTION_AFFILIATIONS,
'SECTION_SKILLS'            => $SECTION_SKILLS,
'SECTION_SKILLS2'            => $SECTION_SKILLS2,
'SECTION_LANGUAGES'         => $SECTION_LANGUAGES,
'SECTION_LANGUAGES2'         => $SECTION_LANGUAGES2,
'SECTION_REFERENCES'        => $SECTION_REFERENCES,
'SECTION_ADDITIONAL_INFO'   => $SECTION_ADDITIONAL_INFO,
'SECTION_TARGET_JOB'        => $SECTION_TARGET_JOB,
'SECTION_TARGET_LOCATIONS'  => $SECTION_TARGET_LOCATIONS,
'SECTION_DOCUMENT_VIDEO'    => $SECTION_DOCUMENT_VIDEO,
'SECTION_DOCUMENT_UPLOAD'   => $SECTION_DOCUMENT_UPLOAD,
'SECTION_DOCUMENT_UPLOAD_PRINT'=> $SECTION_DOCUMENT_UPLOAD_PRINT,
'SECTION_SOCUMENT_UPLOAD_PR'=> $SECTION_SOCUMENT_UPLOAD_PR,
'INFO_TEXT_RESUME_TEXT1'=>(tep_not_null($row['jobseeker_resume_text'])?nl2br(stripslashes($row['jobseeker_resume_text'])):'Not available.'),
// 'photo'=>(tep_not_null($row['jobseeker_photo']) && is_file(PATH_TO_MAIN_PHYSICAL_PHOTO.$row['jobseeker_photo'])?'<a href="#" onclick="'.js_popup(PATH_TO_PHOTO.$row['jobseeker_photo'],SITE_TITLE).'">'.tep_image(FILENAME_IMAGE."?size=80&image_name=".PATH_TO_PHOTO.$row['jobseeker_photo'],tep_db_output(SITE_TITLE),'','',' class="resume-pic"').'</a>':''),

// 'photo'=>(tep_not_null($row['jobseeker_photo']) && is_file(PATH_TO_MAIN_PHYSICAL_PHOTO.$row['jobseeker_photo'])
// ?tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_PHOTO.$row['jobseeker_photo'],tep_db_output(SITE_TITLE),'','',' class="img-thumbnail mr-3" width="150"')
// :'<img src='.HOST_NAME.'img/nopic.jpg class="img-thumbnail mr-3" width="150">'),

'photo'=>(tep_not_null($row['jobseeker_photo']) && is_file(PATH_TO_MAIN_PHYSICAL_PHOTO.$row['jobseeker_photo'])?tep_image(FILENAME_IMAGE.'?image_name='.PATH_TO_PHOTO.$row['jobseeker_photo'],'','','','class="logo-dashboard mr-3"'):'<img style="border-radius: 100%;"  src='.HOST_NAME.'img/nopic.jpg class="logo-dashboard mr-3">'),


'identification_id'=>(tep_not_null($row['jobseeker_identification_id']) && is_file(PATH_TO_MAIN_PHYSICAL_PHOTO.$row['jobseeker_identification_id'])?'<div style="float:left;text-align:center;padding:1;border:1px solid #ddd" ><a href="#" onclick="'.js_popup(PATH_TO_PHOTO.$row['jobseeker_identification_id'],SITE_TITLE).'">'.tep_image(FILENAME_IMAGE."?size=80&image_name=".PATH_TO_PHOTO.$row['jobseeker_identification_id'],tep_db_output(SITE_TITLE)).'</a><br> Identification ID</div><div style="float:left"> &nbsp;&nbsp;&nbsp;</div> ':''),
'DOWNLOAD_IMAGE'            =>(check_login('recruiter')?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,'action=download&query_string1='.$query_string1).'"><i class="fa fa-download" aria-hidden="true"></i> '.INFO_TEXT_DOENLOAD_RESUME.'</a>':'&nbsp;'),

'SEARCH'=>(check_login("jobseeker")?'Search Job':'Search Resume'),
'SEARCH_LEFT_BAR'=>$search_left_bar,
'APPLICANT_TRACKING'=>$applicant_tracking,

'LEFT_BOX_WIDTH'            => LEFT_BOX_WIDTH1,
'RIGHT_BOX_WIDTH'           => RIGHT_BOX_WIDTH1,
'LEFT_HTML'                 => '',
'RIGHT_HTML'                => RIGHT_HTML,
'update_message'            => $messageStack->output()));

if(isset($_GET['query_string6']))
{
$template->pparse('view_resume6');
}
elseif($action=='print')
{
$template->pparse('view_resume1');
}
elseif($action=='download')
{
$file_name=date("YmdHis").randomize(8)."resume.htm";
$handle = fopen(PATH_TO_MAIN_PHYSICAL_DOWNLOAD_RESUME.$file_name, "w");
$string=stripslashes($template->pparse1('view_resume2'));
//echo $string;die();
fwrite($handle, $string);
fclose($handle);
header('Content-Type: application/force-download' );
header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Content-Disposition: attachment; filename="'. substr($file_name,23) . '"');
readfile(PATH_TO_MAIN_PHYSICAL_DOWNLOAD_RESUME.$file_name);
unlink(PATH_TO_MAIN_PHYSICAL_DOWNLOAD_RESUME.$file_name);
}
elseif($action=='book_mark')
{
$today=date("Y-m-d H:i:s");
$template->assign_vars(array(
  'INFO_TEXT_JOB'=>INFO_TEXT_JOB,
  'INFO_TEXT_BOOKMARK_RESUME'=>INFO_TEXT_BOOKMARK_RESUME,
  'INFO_TEXT_JOB1'=>LIST_SET_DATA(JOB_TABLE,"where recruiter_id ='".$_SESSION['sess_recruiterid']."' and re_adv <= '".$today."' and expired >= '".$today."' and deleted is NULL  ",'job_title',"job_id","job_title",'name="job_id" class="form-control form-control-sm"'),
  'form'=>tep_draw_form('book_mark', FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params(array('action')),'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action1','bookmark_to_job'),
  'button'=>tep_button_submit('btn btn-primary', 'Submit'),
  'LEFT_BOX_WIDTH'=>LEFT_BOX_WIDTH1,
  'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH1,
  'LEFT_HTML'=>LEFT_HTML,
  'RIGHT_HTML'=>RIGHT_HTML,
  'update_message'=>$messageStack->output()));
  $template->pparse('book_mark');
}
else if($action=='send_to_friend')
{
  $row=getAnyTableWhereData(RECRUITER_LOGIN_TABLE.' as rl,'.RECRUITER_TABLE.' as r',"rl.recruiter_id='".$_SESSION['sess_recruiterid']."' and rl.recruiter_id=r.recruiter_id","concat(r.recruiter_first_name,' ',r.recruiter_last_name) as name, rl.recruiter_email_address as email_address");
  if(!isset($_POST['TR_your_full_name']))
  $from_email_name=$row['name'];
  $TREF_your_email_address=$row['email_address'];
  $template->assign_vars(array(
	'INFO_TEXT_FROM_NAME'=>INFO_TEXT_FROM_NAME,
	'INFO_TEXT_FROM_NAME1'=>tep_draw_input_field('TR_your_full_name', $from_email_name,'size="40" class="form-control"',true),
	'INFO_TEXT_FROM_EMAIL_ADDRESS'=>INFO_TEXT_FROM_EMAIL_ADDRESS,
	'INFO_TEXT_FROM_EMAIL_ADDRESS1'=>($TREF_your_email_address),
	'INFO_TEXT_TO_NAME'=>INFO_TEXT_TO_NAME,
	'INFO_TEXT_TO_NAME1'=>tep_draw_input_field('TR_your_friend_full_name', $to_name,'size="40" class="form-control"',true),
	'INFO_TEXT_TO_EMAIL_ADDRESS'=>INFO_TEXT_TO_EMAIL_ADDRESS,
	'INFO_TEXT_TO_EMAIL_ADDRESS1'=>tep_draw_input_field('TREF_your_friend_email_address', $to_email_address,'size="40" class="form-control"',true),
	'INFO_TEXT_SUBJECT'=>INFO_TEXT_SUBJECT,
	'INFO_TEXT_SUBJECT1'=>tep_draw_input_field('TR_subject', $subject,'size="40" class="form-control"',true),
	'INFO_TEXT_MESSAGE'=>INFO_TEXT_MESSAGE,
	'INFO_TEXT_MESSAGE1'=>tep_draw_textarea_field('TR_message', 'soft', '70', '12', $TR_message, '', '',false, 'class="form-control"'),
	'form'=>tep_draw_form('send', FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params(array('action')),'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action1','send'),
	'button'=>tep_button_submit('btn btn-primary', IMAGE_SEND),
	'INFO_TEXT_JSCRIPT_FILE'  =>'<script src="'.$jscript_file.'"></script>' ,
	'LEFT_BOX_WIDTH'=>LEFT_BOX_WIDTH1,
	'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH1,
	'LEFT_HTML'=>LEFT_HTML,
	'RIGHT_HTML'=>RIGHT_HTML,
	'update_message'=>$messageStack->output()));
	$template->pparse('view_resume3');
  }
  else if($action=='contact')
  {
	$template->assign_vars(array(
	  'INFO_TEXT_SUBJECT'=>INFO_TEXT_SUBJECT,
	  'INFO_TEXT_SUBJECT1'=>tep_draw_input_field('TR_subject', $TR_subject,'size="40" class="form-control required"',true),
	  'INFO_TEXT_MESSAGE'=>INFO_TEXT_MESSAGE,
	  'INFO_TEXT_MESSAGE1'=>tep_draw_textarea_field('TR_message', 'soft', '70', '12', '', '', '',false,'class="form-control required"'),
	  'form'=>tep_draw_form('send', FILENAME_JOBSEEKER_VIEW_RESUME,tep_get_all_get_params(array('action')),'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action1','send1'),
	  'button'=>tep_button_submit('btn btn-primary', IMAGE_SEND),
	  'INFO_TEXT_JSCRIPT_FILE'  =>'<script src="'.$jscript_file.'"></script>' ,
	  'LEFT_BOX_WIDTH'=>LEFT_BOX_WIDTH1,
	  'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH1,
	  'LEFT_HTML'=>LEFT_HTML,
	  'RIGHT_HTML'=>RIGHT_HTML,
	  'update_message'=>$messageStack->output()));
	  $template->pparse('view_resume4');
	}
	else
	{
	  $template->pparse('view_resume');
	}
	?>