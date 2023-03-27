<?
/*
***********************************************************
***********************************************************
**********# Name          : Shambhu Prasad Patnaik				#********
**********# Company       : Aynsoft										#**********
**********# Copyright (c) www.aynsoft.com 2004				#**********
**********# Modified in Nov 2017										#**********
**********# Version Jobboard Software :Version 4.1			#**********
***********************************************************
***********************************************************
*/
session_cache_limiter('private_no_expire');
include_once("include_files.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_RECRUITER_APPLICANT_TRACKING);
$template->set_filenames(array('applicant_track1' =>'applicant_tracking1.htm'));
$jscript_file=PATH_TO_LANGUAGE.$language."/jscript/".'search_applicant.js';
include_once(FILENAME_BODY);
$action1            = (isset($_POST['action1']) ? $_POST['action1'] : '');
$process_round      = (isset($_POST['process_round']) ? $_POST['process_round'] : '');
$application_status = (isset($_POST['application_status']) ? $_POST['application_status'] : '');
echo "ss".$application_id;
//print_r($_POST);

///*****check whether apply without login is true or not*/
	if($row_check_login=getAnyTableWhereData(RECRUITER_TABLE ,"recruiter_id='".$_SESSION['sess_recruiterid']."'","recruiter_applywithoutlogin"))
		$direct_login=($row_check_login['recruiter_applywithoutlogin']=='Yes'?'Yes':'No');
///*****check whether apply without login is true or not*/

if(tep_not_null($action1))
{
 switch($action1)
 {
  case 'search':
   if(tep_not_null($_POST['application_id']))
   {
    $application_id=tep_db_input($_POST['application_id']);
    if($row_check_search=getAnyTableWhereData(APPLICATION_TABLE ,"application_id='".$application_id."' order by id desc ","id"))
     tep_redirect(tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS,(tep_not_null($application_id)?"&search_id=".$application_id:"")));
    else
    {
     $messageStack->add_session(ERROR_APPLICATION_NOT_EXIST, 'error');
     tep_redirect(tep_href_link(FILENAME_RECRUITER_APPLICANT_TRACKING));
    }
   }
   else
   {
    $action1       = tep_db_prepare_input($_POST['action1']);

    $hidden_fields = tep_draw_hidden_field('action1',$action1);
    $field         = tep_db_prepare_input($_POST['field']);
    $order         = tep_db_prepare_input($_POST['order']);
    $lower         = (int)tep_db_prepare_input($_POST['lower']);
    $higher        = (int)tep_db_prepare_input($_POST['higher']);
    $whereClause   = '';


    $whereClause  .= "jb.recruiter_id ='".tep_db_input($_SESSION['sess_recruiterid'])."'";
	$whereClause   .= (tep_not_null($whereClause)?$whereClause.' and ':'');

/////////////////////////////////////////////////////////////////////////////
 if(tep_not_null($process_round) ||  tep_not_null($application_status))
 {
	$whereClause1=$whereClause;
  if(tep_not_null($application_status))
   $whereClause1=" ap.cur_status ='".$application_status."' and ";
  	$whereClause1   .= (tep_not_null($whereClause1)?$whereClause1.' and ':'');
if(tep_not_null($process_round))
   $whereClause1=" ap.process_round='".$process_round;
/////////////////////////////////////////////////////////////////////

echo $whereClause."<br>1      :".$whereClause1;
    $table_names   = APPLICATION_TABLE." as a left join  ".JOB_TABLE." as jb  on (a.job_id =jb.job_id) left  join ".JOBSEEKER_TABLE." as j on (j.jobseeker_id=a.jobseeker_id) left outer join ".JOBSEEKER_RESUME1_TABLE." as jr1 on (a.resume_id=jr1.resume_id) left join ".JOBSEEKER_LOGIN_TABLE." as jl on (j.jobseeker_id=jl.jobseeker_id)  ";
    $field_names   = 'a.job_id, a.id, a.application_id, j.jobseeker_first_name, j.jobseeker_last_name, jl.jobseeker_email_address, j.jobseeker_privacy,j.jobseeker_city,jb.job_title,a.inserted, jr1.jobseeker_photo, a.resume_id, a.applicant_select';
    $query1 = "select count(a.id) as x1 from $table_names where $whereClause";
    echo $query1;
    $result1=tep_db_query($query1);
    $tt_row=tep_db_fetch_array($result1);
    $x1=$tt_row['x1'];
    include_once(PATH_TO_MAIN_PHYSICAL_CLASS.'sort_by_clause.php');
    $sort_array=array('a.application_id','j.jobseeker_first_name','jl.jobseeker_email_address','jb.job_title','a.inserted',);
    include_once(PATH_TO_MAIN_PHYSICAL_CLASS.'sort_by_clause.php');
    $obj_sort_by_clause=new sort_by_clause($sort_array,'a.inserted desc');
    $order_by_clause=$obj_sort_by_clause->return_value;
    $see_before_page_number_array=see_before_page_number($sort_array,$field,'a.inserted ',$order,'desc',$lower,'0',$higher,MAX_DISPLAY_LIST_OF_APPLICATIONS);//MAX_DISPLAY_LIST_OF_APPLICATIONS
    //print_r($see_before_page_number_array);
    $lower=$see_before_page_number_array['lower'];
    $higher=$see_before_page_number_array['higher'];
    $field=$see_before_page_number_array['field'];
    $order=$see_before_page_number_array['order'];
    $hidden_fields.=tep_draw_hidden_field('sort',$sort);
    $template->assign_vars(array(
     'TABLE_HEADING_APPL_NAME'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][0]."','".$lower."');\"><u>".TABLE_HEADING_APPL_NAME.'</u>'.$obj_sort_by_clause->return_sort_array['image'][0]."</a>",
     'TABLE_HEADING_APPL_EMAIL'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][1]."','".$lower."');\"><u>".TABLE_HEADING_APPL_EMAIL.'</u>'.$obj_sort_by_clause->return_sort_array['image'][1]."</a>",
     'TABLE_HEADING_APPL_JOB_TITLE'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][2]."','".$lower."');\"><u>".TABLE_HEADING_APPL_JOB_TITLE.'</u>'.$obj_sort_by_clause->return_sort_array['image'][2]."</a>",
     'TABLE_HEADING_APPL_STATUS'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][3]."','".$lower."');\"><u>".TABLE_HEADING_APPL_STATUS.'</u>'.$obj_sort_by_clause->return_sort_array['image'][3]."</a>",
     'TABLE_HEADING_DATE_OF_APPLICATION'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][4]."','".$lower."');\"><u>".TABLE_HEADING_DATE_OF_APPLICATION.'</u>'.$obj_sort_by_clause->return_sort_array['image'][4]."</a>",
     ));
     $totalpage=ceil($x1/$higher);
     $query = "select $field_names from $table_names where $whereClause ORDER BY $order_by_clause limit $lower,$higher ";
     $result=tep_db_query($query);
     //echo "<br>$query";//exit;
     $x=tep_db_num_rows($result);
     //echo $x;exit;
     $pno= ceil($lower+$higher)/($higher);
     if($x > 0 && $x1 > 0)
     {
      $alternate=1;
      while($row = tep_db_fetch_array($result))
      {
       $ide=$row["application_id"];
		$job_id=$row['job_id'];
		$resume_id=$row['resume_id'];
		$query_string=encode_string("application_id=".$resume_id."=application_id");

       $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'3').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"';
       $application_id='<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS,"&search_id=".$ide).'" target="_blank">'.tep_db_output($ide).'</a>';

////////////////////////////////////////////
$round_st   = getAnyTableWhereData(APPLICATION_STATUS_TABLE.' as apn_st left outer join '.APPLICANT_STATUS_TABLE.' as ap_st on (apn_st.id=ap_st.cur_status) left outer join '.SELECTION_ROUND_TABLE.' as sel_rd on (ap_st.process_round=sel_rd.id)'," ap_st.application_id='".$row['id']."' order by inserted desc limit 0,1",'apn_st.application_status,sel_rd.round_name,ap_st.cur_status');
//echo $round_name;
 $query_string3=encode_string("application*=*".$ide."*=*application_id");

//////////*********************************////
//////**********************************************//
if($row['applicant_select']=='Yes')
	$applicant_selection_status='Shortlisted <br>('.$round_st['round_name'].' Round - '.$round_st['application_status'].' )';
elseif($row['applicant_select']=='No' and tep_db_query("select * from ".APPLICANT_STATUS_TABLE." where application_id='".$application_id."'"))
	$applicant_selection_status='On Process';
else
	$applicant_selection_status='Resume Submitted';
////////*********************************************//

////*****************************************************************///

       $template->assign_block_vars('applicant_track', array(
          'application_id'=>$application_id,
		  'applicant_pipeline'=>'<a href="'.tep_href_link(FILENAME_RECRUITER_APPLICATION_REPORT,'jobID='.$job_id).'#Pipeline">Applicant Pipeline</a>',
		  //'view_resume'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,'query_string='.$query_string).'">View Resume</a>',
		  'action'=>'<a class="btn btn-sm btn-primary mr-1" href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS,'query_string3='.$query_string3).'"><i class="fa fa-check" aria-hidden="true"></i> Select</a> <a class="btn btn-sm btn-secondary mr-1" href="'.tep_href_link(FILENAME_EMPLOYER_INTERACTION,"query_string3=".$query_string3).'"><i class="fa fa-envelope" aria-hidden="true"></i></a> <a class="btn btn-sm btn-secondary mr-1" href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS,'query_string3='.$query_string3.'&job_id='.$job_id.'&action1=change_status').'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a class="btn btn-sm btn-secondary" href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,'query_string='.$query_string).'"><i class="fa fa-eye" aria-hidden="true"></i></a>',
  		  'photo'=>(tep_not_null($row['jobseeker_photo']) && is_file(PATH_TO_MAIN_PHYSICAL_PHOTO.$row['jobseeker_photo'])?tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_PHOTO.$row['jobseeker_photo'],tep_db_output(SITE_TITLE),'','','class="extra-mini-profile-img img-thumbnail"'):'<img src="'.HOST_NAME.'/img/nopic.jpg" class="extra-mini-profile-img img-thumbnail">'),
          'name' =>'<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS,"&search_id=".$ide).'" target="_blank">'. tep_db_output($row['jobseeker_first_name'].' '.$row['jobseeker_last_name']).'</a>',
          'email_address' =>($row['jobseeker_privacy']==3?tep_db_output($row['jobseeker_email_address']):'*****'),//tep_db_output($row['jobseeker_email_address']),
          'inserted' => tep_date_short($row['inserted']),
          'job_title' => tep_db_output($row['job_title']),
          'city' => tep_db_output($row['jobseeker_city']),
	     'applicant_select'=> $applicant_selection_status,
          'row_selected'=>$row_selected
          ));
       $alternate++;
       $lower = $lower + 1;
      }
      $plural=($x1=="1")?INFO_TEXT_APPLICATION:INFO_TEXT_APPLICATIONS;
      $template->assign_vars(array('total'=>tep_db_output(SITE_TITLE).INFO_TEXT_HAS_MATCHED." <font color='red'><b>$x1</b></font> ".$plural." ".INFO_TEXT_TO_YOUR_SEARCH));
     }
     else
     {
      $template->assign_vars(array('total'=>tep_db_output(SITE_TITLE)." ".INFO_TEXT_HAS_NOT_MATCHED));
     }
     see_page_number();
     tep_db_free_result($result1);
     tep_db_free_result($result);
   }
   break;
 }
}


 $template->assign_vars(array(
  'HEADING_TITLE'         => HEADING_TITLE,
  'RIGHT_HTML'=>$JOB_RIGHT,
'HEADING_SEARCH'=>HEADING_SEARCH,
'TABLE_HEADING_APPL_ACTION'=>TABLE_HEADING_APPL_ACTION,
'no_of_applicants'=>$x1,
'search_resume_form'=>tep_draw_form('applicant_track', FILENAME_RECRUITER_APPLICANT_TRACKING,'','post').tep_draw_hidden_field('action1','search'),
  'INFO_TEXT_APPLICATION1'=> tep_draw_input_field('application_id','', 'class="form-control-applicant" placeholder="Application ID"', false ),
  'INFO_TEXT_FIRST_NAME1' => tep_draw_input_field('first_name',$first_name, 'class="form-control" placeholder="First Name"',false),
  'INFO_TEXT_LAST_NAME1'  => tep_draw_input_field('last_name',$last_name, 'class="form-control" placeholder="Last Name"',false),
  'INFO_TEXT_EMAIL_ADDRESS1'=> tep_draw_input_field('TNEF_email_address',$email_address, 'class="form-control-applicant" placeholder="Email Address"', false),
  'buttons'  => tep_draw_submit_button_field('','Search','class="btn btn-primary"'),
'applicant_tracking'=>'<li>'.tep_draw_form('search_app',FILENAME_RECRUITER_APPLICANT_TRACKING,'','post','').tep_draw_hidden_field('action1','search').'<button type="submit" class="ats-left-bar-btn"> >  All Applicants</button></form></li>
                                <li><button onclick="location.href=\''.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS).'?jobID=\''.$JOB_ID.'"  class="ats-left-bar-btn"> > Applicant Pipeline</button></li>
		<li><a href="'.tep_href_link(FILENAME_RECRUITER_APPLICATION_REPORT).'&search_id='.$JOB_ID.'"  class="ats-left-bar-btn"> > Applicant Pipeline</a></li>
<li><button href="'.tep_href_link(FILENAME_RECRUITER_APPLICANT_TRACKING).'" type="button" class="ats-left-bar-btn"> > Search Applicants</button></li>
<li>'.tep_draw_form('search_app',FILENAME_RECRUITER_LIST_OF_SELECTD_APPLICANT,'','post','onsubmit="return ValidateForm(this)" ').tep_draw_hidden_field('action1','search').'<button type="submit" class="ats-left-bar-btn"> > Selected Applicants</button></form></li>',
'direct_applicants'=>($direct_login=='Yes'?'<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_UNREGISTERED_RESUMES).'" title="'.INFO_TEXT_UNREGISTERED_RESUMES.'">'.INFO_TEXT_UNREGISTERED_RESUMES.'</a>':''),
'TABLE_HEADING_APPL_PHOTO'=>TABLE_HEADING_APPL_PHOTO,
'TABLE_HEADING_APPL_NAME'=>TABLE_HEADING_APPL_NAME,
'TABLE_HEADING_APPL_EMAIL'=>TABLE_HEADING_APPL_EMAIL,
'TABLE_HEADING_APPL_JOB_TITLE'=>TABLE_HEADING_APPL_JOB_TITLE,
'TABLE_HEADING_APPL_STATUS'=>TABLE_HEADING_APPL_STATUS,
'TABLE_HEADING_DATE_OF_APPLICATION'=>TABLE_HEADING_DATE_OF_APPLICATION,

//'appl_form'=>tep_draw_form('search_appl',FILENAME_RECRUITER_APPLICANT_TRACKING,'','post').tep_draw_hidden_field('action1','search'),
// 'INFO_TEXT_TRACKING_ROUND1' => LIST_SET_DATA(SELECTION_ROUND_TABLE,"",TEXT_LANGUAGE.'round_name','id',"value",'name="process_round" class="form-control" style="width:170px" onchange="this.form.submit()"','All','',$process_round),
// 'INFO_TEXT_APPLICATION_STATUS1' => LIST_SET_DATA(APPLICATION_STATUS_TABLE,"",'application_status','id',"priority",'name="application_status" class="form-control" style="width:170px" onchange="this.form.submit()"','All','',$application_status),

'TABLE_HEADING_ACTION'=>TABLE_HEADING_ACTION,
  'hidden_fields' => $hidden_fields,
  'LEFT_BOX_WIDTH'   => LEFT_BOX_WIDTH1,
  'RIGHT_BOX_WIDTH'  => RIGHT_BOX_WIDTH1,
  'LEFT_HTML'        => LEFT_HTML,
  'RIGHT_HTML'       => RIGHT_HTML,
  'update_message'=>$messageStack->output()));
 $template->pparse('applicant_track1');
?>