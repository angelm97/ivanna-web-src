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
include_once("include_files.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_RECRUITER_APPLICANT_TRACKING);
$template->set_filenames(array('applicant_track1' =>'applicant_tracking1.htm'));
$jscript_file=PATH_TO_LANGUAGE.$language."/jscript/".'applicant_tracking.js';
include_once(FILENAME_BODY);
$action1            = (isset($_POST['action1']) ? $_POST['action1'] : 'search');
$process_round      = (isset($_POST['process_round']) ? $_POST['process_round'] : '');
$application_status = (isset($_POST['application_status']) ? $_POST['application_status'] : '');
$cand_select = (isset($_POST['cand_select']) ? $_POST['cand_select'] : '');

$excel = (isset($_POST['excel']) ? $_POST['excel'] : '');
if(!check_login("recruiter"))
{
 $messageStack->add_session(LOGON_FIRST_MESSAGE, 'error');
 tep_redirect(FILENAME_RECRUITER_LOGIN);
}

/***********************************/
if($excel=='excel')
{
 $excel=true;
}
else
{
 $excel=false;
}
/***********************************/
$hidden_fields = tep_draw_hidden_field('show_result','all');

if(tep_not_null($action1))
{
 switch($action1)
 {
  case 'selected':
   $output            = (isset($_POST['output']) ? tep_db_input($_POST['output']) : '');
   $query_string3     = (isset($_GET['query_string3']) ? tep_db_input($_GET['query_string3']) : '');
   $search_id         = check_data1($query_string3,"*=*","application","application_id");
   if($search_id)
   tep_db_query("update ".APPLICATION_TABLE." set applicant_select='Yes',selected_date=now()  where application_id='".tep_db_input($search_id)."'");
   die('Shortlisted');
  break;
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
    $show_result   = tep_db_prepare_input($_POST['show_result']);

    $hidden_fields = tep_draw_hidden_field('action1',$action1);
    $field         = tep_db_prepare_input($_POST['field']);
    $order         = tep_db_prepare_input($_POST['order']);
    $lower         = (int)tep_db_prepare_input($_POST['lower']);
    $higher        = (int)tep_db_prepare_input($_POST['higher']);
    $whereClause   = '';
	$whereClause  .= "jb.recruiter_id ='".tep_db_input($_SESSION['sess_recruiterid'])."'";
	$whereClause1=$whereClause;

    /////////////////////////////////////////////////////////////////////////////
	if($show_result=='selected')
	{
	 $whereClause  .= " and a.applicant_select ='Yes' ";
     $hidden_fields .= tep_draw_hidden_field('show_result',$show_result);
 	}
	else
    {
     if(tep_not_null($process_round) ||  tep_not_null($application_status))
     {
      $whereClause1=$whereClause;
      if(tep_not_null($application_status))
	  $whereClause1.=" and ap.cur_status ='".$application_status."'";

      if(tep_not_null($process_round))
	   $whereClause1.=" and ap.process_round ='".$process_round."'";
      $whereClause .=" and  a.id in (select distinct(ap.application_id) from ".APPLICANT_STATUS_TABLE." as ap left join ".APPLICATION_TABLE." as a on (a.id = ap.application_id) where $whereClause1 and ap.id in (select max( ap.id ) from ".APPLICANT_STATUS_TABLE." as ap left join ".APPLICATION_TABLE." as a  on ( a.id = ap.application_id )  left outer join ".JOB_TABLE." as jb on(a.job_id =jb.job_id) where recruiter_id='".tep_db_input($_SESSION['sess_recruiterid'])."' group by ap.application_id, ap.process_round ) )  ";//tep_db_input($_SESSION['sess_recruiterid'])
     }
     $hidden_fields .= tep_draw_hidden_field('show_result','all');
    }

/////////////////////////////////////////////////////////////////////
    $field_names   = 'a.job_id, a.id,a.applicant_select, a.application_id, j.jobseeker_first_name, j.jobseeker_last_name, jl.jobseeker_email_address, j.jobseeker_privacy,j.jobseeker_city,jb.job_title,a.inserted, jr1.jobseeker_photo, a.resume_id, a.applicant_select';

   $table_names   = APPLICATION_TABLE." as a   left join  ".JOB_TABLE." as jb  on (a.job_id =jb.job_id) left  join ".JOBSEEKER_TABLE." as j on (j.jobseeker_id=a.jobseeker_id) left outer join ".JOBSEEKER_RESUME1_TABLE." as jr1 on (a.resume_id=jr1.resume_id) left join ".JOBSEEKER_LOGIN_TABLE." as jl on (j.jobseeker_id=jl.jobseeker_id) ";
   $query1 = "select count(distinct(a.application_id)) as x1 from $table_names where $whereClause";

   //echo $query1;
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
/**************************************/
   if($excel)
   {
    $field_names   = 'a.job_id, jb.job_title, a.application_id, j.jobseeker_first_name, j.jobseeker_last_name, if(j.jobseeker_privacy=3,jl.jobseeker_email_address,"*****") as email_address  , j.jobseeker_city,a.inserted,a.applicant_select';
    //$field_names   = 'a.job_id,  a.application_id, j.jobseeker_first_name, j.jobseeker_last_name, jl.jobseeker_email_address, j.jobseeker_privacy,j.jobseeker_city,jb.job_title,a.inserted, a.resume_id, a.applicant_select';
    $query = "select $field_names from $table_names where $whereClause ORDER BY ".$order_by_clause;
    include_once(PATH_TO_MAIN_PHYSICAL_CLASS . 'mysql_to_excel.php');
    $obj_excel_create=new mysql_to_excel($query,"List of Applicants","excel");
   }
/********************************************/
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
       $round=get_current_round_status($row['id'],$process_round);
       $query_string3=encode_string("application*=*".$ide."*=*application_id");
       $template->assign_block_vars('applicant_track', array(
          'application_id'=>$application_id,
		  'applicant_pipeline'=>'<a href="'.tep_href_link(FILENAME_RECRUITER_APPLICATION_REPORT,'jobID='.$job_id).'#Pipeline">Applicant Pipeline</a>',
		  //'view_resume'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,'query_string='.$query_string).'">View Resume</a>',
		  'action'=>'<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS,'query_string3='.$query_string3.'&job_id='.$job_id.'&action1=change_status').'">Edit</a> | <span id="s_'.$ide.'" >'.(($row['applicant_select']=='Yes')?'Shortlisted':'<a href="'.tep_href_link(FILENAME_RECRUITER_APPLICANT_TRACKING,'query_string3='.$query_string3).'" class="select_link">Select</a>').'</span> | <a href="'.tep_href_link(FILENAME_EMPLOYER_INTERACTION,"query_string3=".$query_string3).'" target="_blank">Contact</a><br> <a href="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME,'query_string='.$query_string).'"><nobr>View Resume</nobr></a>',
  		  'photo'=>(tep_not_null($row['jobseeker_photo']) && is_file(PATH_TO_MAIN_PHYSICAL_PHOTO.$row['jobseeker_photo'])?tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_PHOTO.$row['jobseeker_photo'],tep_db_output(SITE_TITLE),'','','class="candidate-picture"'):'<img src="'.HOST_NAME.'/img/nopic.jpg" class="candidate-picture">'),
          'name' =>'<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_APPLICATIONS,"&search_id=".$ide).'" target="_blank">'. tep_db_output($row['jobseeker_first_name'].' '.$row['jobseeker_last_name']).'</a>',
          'email_address' =>($row['jobseeker_privacy']==3?tep_db_output($row['jobseeker_email_address']):'*****'),//tep_db_output($row['jobseeker_email_address']),
          'inserted' => tep_date_short($row['inserted']),
          'job_title' => tep_db_output($row['job_title']),
          'city' => tep_db_output($row['jobseeker_city']),
	      'applicant_status'=> $round."<br>",
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
case 'selectedcand':
break;
 }
}
/****************************************/
///$hidden_fields1=tep_draw_hidden_field('excel',$excel);
//print_r($_POST);

 $template->assign_vars(array(
  'HEADING_TITLE'              => (($show_result=='selected')?'Selected Candidates':HEADING_TITLE),
  'show_result'                => (($show_result=='selected')?'<a  href="#" onclick="show_result(\'All\');">Todos los candidatos</a>':'<a  href="#" onclick="show_result(\'selected\');">Candidatos seleccionados</a>'),
  'INFO_TEXT_TRACKING_ROUND1'  => (($show_result=='selected')?'':LIST_SET_DATA(SELECTION_ROUND_TABLE,"",TEXT_LANGUAGE.'round_name','id',"value",'name="process_round" class="form-control"  onchange="this.form.submit()"','All','',$process_round)),
  'INFO_TEXT_APPLICATION_STATUS1'  => (($show_result=='selected')?'':LIST_SET_DATA(APPLICATION_STATUS_TABLE,"",'application_status','id',"priority",'name="application_status" class="form-control"  onchange="this.form.submit()"','All','',$application_status)),
  'RIGHT_HTML'=>$JOB_RIGHT,
//'HEADING_SEARCH'=>HEADING_SEARCH,
'create_excel_button'=>'<a href="#" onclick="excelpage_submit(\'excel\');">'.tep_image(PATH_TO_BUTTON.'button_create_excel_report.gif', IMAGE_EXCEL).'</a>',
 //'selected_candidate'=>tep_draw_form('search_selapp',FILENAME_RECRUITER_APPLICANT_TRACKING,'','post','onsubmit="return ValidateForm(this)" ').tep_draw_hidden_field('cand_select','Yes').'<button type="submit" class="btn btn-outline-secondary"> Selected Applicants</button></form>',

'TABLE_HEADING_APPL_ACTION'=>TABLE_HEADING_APPL_ACTION,
'no_of_applicants'=>$x1,
//'search_resume_form'=>tep_draw_form('applicant_track', FILENAME_RECRUITER_APPLICANT_TRACKING,'','post').tep_draw_hidden_field('action1','search'),
'TABLE_HEADING_APPL_PHOTO'=>TABLE_HEADING_APPL_PHOTO,
'TABLE_HEADING_APPL_NAME'=>TABLE_HEADING_APPL_NAME,
'TABLE_HEADING_APPL_EMAIL'=>TABLE_HEADING_APPL_EMAIL,
'TABLE_HEADING_APPL_JOB_TITLE'=>TABLE_HEADING_APPL_JOB_TITLE,
'TABLE_HEADING_APPL_STATUS'=>TABLE_HEADING_APPL_STATUS,
'TABLE_HEADING_DATE_OF_APPLICATION'=>TABLE_HEADING_DATE_OF_APPLICATION,
'appl_form'=>tep_draw_form('page',FILENAME_RECRUITER_APPLICANT_TRACKING,'','post').tep_draw_hidden_field('action1','search'),

//'TABLE_HEADING_ACTION'=>TABLE_HEADING_ACTION,
  'INFO_TEXT_JSCRIPT_FILE' => '<script src="'.tep_href_link($jscript_file).'"></script>',

  'hidden_fields' => $hidden_fields,
  'LEFT_BOX_WIDTH'   => LEFT_BOX_WIDTH1,
  'RIGHT_BOX_WIDTH'  => RIGHT_BOX_WIDTH1,
  'LEFT_HTML'        => LEFT_HTML,
  'RIGHT_HTML'       => RIGHT_HTML,
  'update_message'=>$messageStack->output()));
 $template->pparse('applicant_track1');
?>