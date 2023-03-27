<?
/*
***********************************************************
**********# Name          : Shambhu Prasad Patnaik #*******
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
***********************************************************
*/
//session_cache_limiter('private_no_expire');
include_once("include_files.php");
ini_set('max_execution_time','60');
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_JOB_SEARCH_BY_INDUSTRY);
$template->set_filenames(array('job_search' => 'job_search_by_industry.htm','job_search_result'=>'job_search_result_category.htm'));
include_once(FILENAME_BODY);
$jscript_file=HOST_NAME.PATH_TO_LANGUAGE.$language."/jscript/".'job_search_by_industry.js';
$state_error=false;
$action = (isset($_POST['action']) ? $_POST['action'] : '');
$action1 = (isset($_POST['action1']) ? $_POST['action1'] : '');
$sID = (isset($_GET['sID']) ?(int)$_GET['sID'] : '');
$edit=false;
$search_name='';
/*if(isset($_GET['search_category']))
{
 $search_category=tep_db_prepare_input($_GET['search_category']);
 $search_category=decode_category($search_category);
 if($row_check_cat=getAnyTableWhereData(JOB_CATEGORY_TABLE,"category_name='".tep_db_input($search_category)."'",'id'))
 {
  $action='search';
  $job_category=array($row_check_cat['id']);
  $search_name=$search_category;
 }
}*/
if(isset($_GET['search_category']))
{
 $search_category=tep_db_prepare_input($_GET['search_category']);
 //$search_category=decode_category($search_category);
 if($row_check_cat=getAnyTableWhereData(JOB_CATEGORY_TABLE,"id='".tep_db_input($search_category)."'",TEXT_LANGUAGE.'category_name'))
 {
  $action='search';
  $job_category=array($search_category);
  $search_name=$row_check_cat[TEXT_LANGUAGE.'category_name'];
 }
}
elseif(tep_not_null($_POST['job_category']) && $_POST['job_category'][0]!=0 )
{
 $job_category=$_POST['job_category'];
}
if(tep_not_null($action))
{
 switch($action)
 {
  case 'search':
   $action=tep_db_prepare_input($action);
   $hidden_fields.=tep_draw_hidden_field('action',$action);
   $field=tep_db_prepare_input($_POST['field']);
   $order=tep_db_prepare_input($_POST['order']);
   $lower=(int)tep_db_prepare_input($_POST['lower']);
   $higher=(int)tep_db_prepare_input($_POST['higher']);
   $whereClause='';
   // industry sector starts ///
   if(tep_not_null($job_category[0]))
   {
    //print_r($category_name);die();
    if($job_category['0']!='0')
    {
     $job_category1=implode(",",$job_category);
     $job_category1=remove_child_job_category($job_category1);
     $job_category=explode(',',$job_category1);
     $count_job_category=count($job_category);
     for($i=0;$i<$count_job_category;$i++)
     {
      $hidden_fields.=tep_draw_hidden_field('job_category[]',$job_category[$i]);
     }
     $search_category1 =get_search_job_category($job_category1);
     $now=date('Y-m-d H:i:s');
     $whereClause_job_category=" select distinct (j.job_id) from ".JOB_TABLE."  as j  left join ".JOB_JOB_CATEGORY_TABLE." as jc on(j.job_id=jc.job_id ) where j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00') and jc.job_category_id in (".$search_category1.")";
     $whereClause=(tep_not_null($whereClause)?$whereClause.' and job_id in ( ':' job_id in ( ');
     $whereClause.=$whereClause_job_category;
     $whereClause.=" ) ";
    }
    else
    {
     $hidden_fields.=tep_draw_hidden_field('job_category[]','0');
    }
   }
   $whereClause=(tep_not_null($whereClause)?$whereClause.' and ':'');
   ////
   $now=date('Y-m-d H:i:s');
   $table_names=JOB_TABLE." as j left outer join ".RECRUITER_LOGIN_TABLE.' as rl on (j.recruiter_id=rl.recruiter_id) left outer join '.RECRUITER_TABLE.' as r on (rl.recruiter_id=r.recruiter_id)  left outer join '.ZONES_TABLE.' as z on (j.job_state_id=z.zone_id or z.zone_id is NULL) left outer join '.COUNTRIES_TABLE.' as c on (j.job_country_id =c.id)';
   $whereClause.="rl.recruiter_status='Yes' and j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00')";
   $field_names="j.job_id, j.job_title, j.re_adv, j.job_short_description,  j.recruiter_id,j.min_experience,j.max_experience,j.job_salary,j.job_industry_sector,j.job_type,j.expired,j.recruiter_id,r.recruiter_company_name,r.recruiter_logo,j.job_source,j.post_url,j.url,j.job_featured,concat(case when j.job_location='' then '' else concat(j.job_location,', ') end, if(j.job_state_id,z.zone_name,j.job_state)) as location ,c.country_name";
   $query1 = "select count(j.job_id) as x1 from $table_names where $whereClause ";
   //echo "<br>$query1";//exit;
   $result1=tep_db_query($query1);
   $tt_row=tep_db_fetch_array($result1);
   $x1=$tt_row['x1'];
   //echo $x1;
   //////////////////
  ///only for sorting starts
   include_once('class/'.'sort_by_clause.php');
   $sort_array=array("j.job_title",'r.recruiter_company_name','location','j.re_adv','j.job_salary ');
   $obj_sort_by_clause=new sort_by_clause($sort_array,'if(j.job_source =\'jobsite\',0,1)  ,j.inserted desc');
   $order_by_clause=$obj_sort_by_clause->return_value;
   //print_r($obj_sort_by_clause->return_sort_array['name);
   //print_r($obj_sort_by_clause->return_sort_array['image);
   $see_before_page_number_array=see_before_page_number($sort_array,$field,'if(j.job_source =\'jobsite\',0,1) ,j.inserted',$order,'desc',$lower,'0',$higher,MAX_DISPLAY_SEARCH_RESULTS);
   $lower=$see_before_page_number_array['lower'];
   $higher=$see_before_page_number_array['higher'];
   $field=$see_before_page_number_array['field'];
   $order=$see_before_page_number_array['order'];
   $hidden_fields.=tep_draw_hidden_field('sort',$sort);
   ///only for sorting ends

   $totalpage=ceil($x1/$higher);
   $query = "select $field_names from $table_names where $whereClause ORDER BY  $order_by_clause  limit $lower,$higher ";
   $result=tep_db_query($query);
  // echo "<br>$query";//exit;
   $x=tep_db_num_rows($result);
   //echo $x;exit;
   $pno= ceil($lower+$higher)/($higher);
   if($x > 0 && $x1 > 0)
   {
    while($row = tep_db_fetch_array($result))
    {
     $ide=$row["job_id"];
     $title_format=encode_category($row['job_title']);
     $query_string=encode_string("job_id=".$ide."=job_id");
					if($row['job_featured']=='Yes')
					 $row_selected='jobSearchRowFea';
					else
					{
      $row_selected='jobSearchRow1';
			   //$alternate++;
    	}

					$email_job    ='<a class="btn btn-sm btn-text border bg-white mr-3" href="'.tep_href_link(FILENAME_TELL_TO_FRIEND,'query_string='.$query_string).'" title="'.tep_db_output(INFO_TEXT_EMAIL_THIS_JOB).'" target="_blank"><i class="fa fa-envelope-o mr-1" aria-hidden="true"></i> '.INFO_TEXT_EMAIL_THIS_JOB.'</a>';
					$apply_job    ='<a class="btn btn-block btn-sm btn-primary" href="'.tep_href_link(FILENAME_APPLY_NOW,'query_string='.$query_string).'" title="'.tep_db_output(INFO_TEXT_APPLY_TO_THIS_JOB).'" target="_blank">'.INFO_TEXT_APPLY_TO_THIS_JOB.'</a>';

     $recruiter_logo='';
     $company_logo=$row['recruiter_logo'];
     if(tep_not_null($company_logo) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_LOGO.$company_logo))
     $recruiter_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$company_logo."&size=120");

////*** curency display coding ***********/
$row_cur=getAnyTableWhereData(CURRENCY_TABLE,"code ='".DEFAULT_CURRENCY."'",'symbol_left,symbol_right');
$sym_left=(tep_not_null($row_cur['symbol_left'])?$row_cur['symbol_left'].' ':'');
$sym_rt=(tep_not_null($row_cur['symbol_right'])?' '.$row_cur['symbol_right']:'');
//////**********currency display ***************************/

     $template->assign_block_vars('job_search_result', array(
      'row_selected' => $row_selected,
      'check_box'    => ( $row['post_url']=='Yes')?'&nbsp;':'<input type="checkbox" name="apply_job" value="'.$query_string.'">',
      'job_title'    => '<a href="'.tep_href_link($ide.'/'.$title_format.'.html').'" class="job_search_title" target="_blank">'.tep_db_output($row['job_title']).'</a>',
      'logo'         => $recruiter_logo,
      'company_name' => tep_db_output($row['recruiter_company_name']),
      'location'     => tep_db_output($row['location'].' '.$row['country_name']),
      'experience'   => tep_db_output(calculate_experience($row['min_experience'],$row['max_experience'])),
      'salary'       => (tep_not_null($row['job_salary']))?$sym_left.tep_db_output($row['job_salary']).$sym_rt:'',
      'salary_class' => (tep_not_null($row['job_salary']))?'':'result_hide',
      'description'  => nl2br(tep_db_output(strip_tags($row['job_short_description']))),
      'email_job'    => $email_job,
      'apply_job'    => $apply_job,
      'apply_before' => tep_date_long($row['expired']),
      ));
     /////////////////////////////////////////////////////////
     if($check_row=getAnytableWhereData(JOB_STATISTICS_TABLE,"job_id='".$ide."'",'viewed'))
     {
      $sql_data_array=array('job_id'=>$ide,
                            'viewed'=>($check_row['viewed']+1)
                            );
      tep_db_perform(JOB_STATISTICS_TABLE, $sql_data_array, 'update', "job_id='".$ide."'");
     }
     else
     {
      $sql_data_array=array('job_id'=>$ide,
                            'viewed'=>1
                            );
      tep_db_perform(JOB_STATISTICS_TABLE, $sql_data_array);
     }
     /////////////////////////////////////////////////////////

     $lower = $lower + 1;
    }
    see_page_number();
    $plural=($x1=="1")?INFO_TEXT_JOB:INFO_TEXT_JOBS;
    $template->assign_vars(array('total'=>tep_db_output(SITE_TITLE)." ".INFO_TEXT_HAS_MATCHED."  <font color='red'><b>$x1</b></font> ".$plural.INFO_TEXT_TO_YOUR_SEARCH_CRITERIA));
   }
   else
   {
    $template->assign_vars(array('content_hide'=>'result_hide','total'=>tep_db_output(SITE_TITLE)." ".INFO_TEXT_HAS_NOT_MATCHED." <p><br><br><br><br>&nbsp;&nbsp;&nbsp;"));
   }
   tep_db_free_result($result1);
  break;
 }
}
//echo  $whereClause;
if($action!='search')
{//*
 $field_names="id,".TEXT_LANGUAGE."category_name";
 $whereClause=" where sub_cat_id is null";
 $query11 = "select $field_names from ".JOB_CATEGORY_TABLE." $whereClause  order by ".TEXT_LANGUAGE."category_name  asc ";
 $result11=tep_db_query($query11);
 $i=0;
 while($row11 = tep_db_fetch_array($result11))
 {
////////////////////////////////////////////////////////////
///////////////////////////////////////////////////
/////////no of jobs in a category start/////////
		$now=date('Y-m-d H:i:s');
		$table_names=JOB_TABLE." as j left outer join ".RECRUITER_LOGIN_TABLE.' as rl on (j.recruiter_id=rl.recruiter_id) left outer join '.RECRUITER_TABLE.' as r  on (r.recruiter_id=rl.recruiter_id) left join '.JOB_JOB_CATEGORY_TABLE.' as jjc on(jjc.job_id=j.job_id)';
$whereClause=" j.recruiter_id=rl.recruiter_id and rl.recruiter_id=r.recruiter_id and rl.recruiter_status='Yes' and j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00') and jjc.job_category_id='".$row11['id']."'";
$field_names="jjc.job_id";
$jobs_in_category_query = "select count(jjc.job_id) as x1 from $table_names where $whereClause ";
$no_of_jobs_result=tep_db_query($jobs_in_category_query);
$jobs_row=tep_db_fetch_array($no_of_jobs_result);
$no_of_jobs=$jobs_row['x1'];
$jobs=($no_of_jobs>0?'&nbsp;('.$no_of_jobs.')':'');
		/////////no of jobs in a country end/////////
////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
  $ide=$row11["id"];
  $key1=$row11[TEXT_LANGUAGE.'category_name'];
  if($i%2==0)
  {
   $template->assign_block_vars('job_category1', array(
                                'category_name'=>'<a class="d-block" href="'.$ide.'/'.encode_category($key1).'-jobs.html'.'"  title="'.tep_db_output($key1).'"">'.tep_db_output($key1).$jobs,'</a>'
                               ));
  }
  else
  {
   $template->assign_block_vars('job_category2', array(
                                'category_name'=>'<a class="d-block" href="'.$ide.'/'.encode_category($key1).'-jobs.html'.'"  title="'.tep_db_output($key1).'""   >'.tep_db_output($key1).$jobs,'</a>'
                               ));
  }
  $i++;
 }
 $template->assign_vars(array( 'hidden_fields' => $hidden_fields,
  'form' => tep_draw_form('search', FILENAME_JOB_SEARCH_BY_INDUSTRY,($edit?'sID='.$save_search_id:''),'post').tep_draw_hidden_field('action','search'),
  'button' => tep_image_submit(PATH_TO_BUTTON.'button_search.gif', IMAGE_SEARCH),
  'INFO_TEXT_INDUSTRY_SECTOR' => INFO_TEXT_INDUSTRY_SECTOR,
  ));
}
else
{
 $template->assign_vars(array( 'hidden_fields' => $hidden_fields,
  'INFO_TEXT_KEYWORD'      => INFO_TEXT_KEYWORD,
  'form'                   => tep_draw_form('page',FILENAME_JOB_SEARCH_BY_INDUSTRY,($edit?'sID='.$save_search_id:''),'post'),
  'INFO_TEXT_APPLY_NOW'    => (($x>0)?INFO_TEXT_APPLY_NOW:''),
  'INFO_TEXT_APPLY_NOW1'   => (($x>0)?INFO_TEXT_APPLY_NOW1:''),
  'INFO_TEXT_APPLY_ARROW'  => (($x>0)?tep_image('img/job_search_arrow.gif',''):''),
  
  
  //'INFO_TEXT_APPLY_BUTTON' => (($x>0)?(check_login("jobseeker")?tep_image_button(PATH_TO_BUTTON.'button_apply_selectedjob.gif', IMAGE_APPLY,'onclick="ckeck_application(\'\',\''.HOST_NAME.'\');" style="cursor:pointer;"'):tep_image_button(PATH_TO_BUTTON.'button_registered_user.gif', IMAGE_APPLY,'onclick="ckeck_application(\'\',\''.HOST_NAME.'\');" style="cursor:pointer;"').' '.tep_image_button(PATH_TO_BUTTON.'button_new_user.gif', IMAGE_APPLY,'onclick="ckeck_application(\'new\',\''.HOST_NAME.'\');" style="cursor:pointer;"')):''),
  
   'INFO_TEXT_APPLY_BUTTON' => (($x>0)?(check_login("jobseeker")?'<a class="btn btn-primary" onclick="ckeck_application(\'\');" role="button">Apply to Selected Jobs</a>':'<a class="btn btn-primary" onclick="ckeck_application(\'\');" role="button">Registered User</a><a class="ml-2 btn btn-success" onclick="ckeck_application(\'new\');" role="button">New User</a>'):''),
  
  'INFO_TEXT_COMPANY_NAME' => INFO_TEXT_COMPANY_NAME,
  'INFO_TEXT_LOCATION'     => INFO_TEXT_LOCATION,
  'INFO_TEXT_EXPERIENCE'   => INFO_TEXT_EXPERIENCE,
  'INFO_TEXT_APPLY_BEFORE' => INFO_TEXT_APPLY_BEFORE,
  'JOB_SEARCH_LEFT'        => JOB_SEARCH_LEFT,
  'INFO_TEXT_JSCRIPT_FILE' => $jscript_file,
  'INFO_TEXT_LOCATION_NAME'=>INFO_TEXT_LOCATION_NAME,
  'INFO_TEXT_SALARY'=>INFO_TEXT_SALARY,
  ));
}

$template->assign_vars(array(
 'HEADING_TITLE'=>((tep_not_null($search_name))?tep_db_output($search_name." jobs"):HEADING_TITLE),
 'INFO_TEXT_JOB_TYPE'     => INFO_TEXT_JOB_TYPE,
 'INFO_TEXT_EXPERIENCE'   => INFO_TEXT_EXPERIENCE,
 'INFO_TEXT_POSTED_ON'    => INFO_TEXT_POSTED_ON,
 'INFO_TEXT_LOCATION'     => INFO_TEXT_LOCATION,
 'INFO_TEXT_SEARCH_JOB_TITLE'=>((tep_not_null($search_name))?"<title>".tep_db_output($search_name)." jobs </title>":''),
 'RIGHT_BOX_WIDTH' => RIGHT_BOX_WIDTH1,
 'RIGHT_HTML' => RIGHT_HTML,
 'JOB_SEARCH_LEFT'        => JOB_SEARCH_LEFT,
 'update_message' => $messageStack->output()));
if($action=='search' || $action=='save_search')
{
 $template->pparse('job_search_result');
}
else
{
 $template->pparse('job_search');
}
?>