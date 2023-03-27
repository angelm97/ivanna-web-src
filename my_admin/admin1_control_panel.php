<?
/*
***********************************************************
**********# Name          : Shambhu Prasad Patnaik #*******
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2009  #**********
***********************************************************
*/
include_once("../include_files.php");
include_once(PATH_TO_MAIN_ADMIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_ADMIN1_CONTROL_PANEL);
$template->set_filenames(array('control_panel' => 'admin1_control_panel.htm'));
include_once(FILENAME_ADMIN_BODY);

$year=(int)tep_db_prepare_input($_POST['year']);
if($year < 2009)
 $year=date('Y');
$year_listing=year_listing(date('Y'),'2009','name="year"','Year','',$year);
{
 for($i=1;$i<=12;$i++)
 {
  $month_array[]=array("id"=>$i, "text"=>date("M",mktime(0,0,0,$i,2,$year)));
 }
}
rsort($month_array);

$alternate=1;
$chrt_array=array();
for($i=0;$i<count($month_array);$i++)
{
 $start_month=date("Y-m-d H:i:s",mktime(0,0,0, $month_array[$i]['id'],1,$year));
 $end_month=date("Y-m-d H:i:s",mktime(0,0,0, $month_array[$i]['id'],cal_days_in_month(CAL_GREGORIAN, $month_array[$i]['id'],$year), $year));
 $no_of_jobseekers=no_of_records(JOBSEEKER_LOGIN_TABLE,"inserted > '$start_month' and inserted <= '$end_month'");
 $no_of_recruiters=no_of_records(RECRUITER_LOGIN_TABLE,"inserted > '$start_month' and inserted <= '$end_month'");
 $no_of_jobs=no_of_records(JOB_TABLE,"inserted > '$start_month' && inserted <= '$end_month'");
 $query="select ot.value from ".ORDER_TABLE." as o,".ORDER_TOTAL_TABLE." as ot where o.orders_id=ot.orders_id and ot.class='ot_total' and o.orders_date_finished > '$start_month' && o.orders_date_finished <= '$end_month'";
 //echo $query;die();
 $result=tep_db_query($query);
 $sales=0.00;
 if(tep_db_num_rows($result) >= 1)
 {
  while($row=tep_db_fetch_array($result))
   $sales+=$row['value'];
 }
 $row_selected=' class="DBdataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"';
 $alternate++;
	if($year==date("Y"))
	{
	 if($month_array[$i]['id']<=date("n"))
		$chart_array[$i]=array('x_group'=>$month_array[$i]['text'],'jobseeker'=>$no_of_jobseekers ,'recruiter'=>$no_of_recruiters,'jobs'=>$no_of_jobs);
 }
 else
	{
		$chart_array[$i]=array('x_group'=>$month_array[$i]['text'],'jobseeker'=>$no_of_jobseekers ,'recruiter'=>$no_of_recruiters,'jobs'=>$no_of_jobs);
 }
 $template->assign_block_vars('report', array('row_selected'=>$row_selected,
  'TEXT_INFO_MONTH'=>$month_array[$i]['text'],
  'TEXT_INFO_JOBSEEKERS2'=>$no_of_jobseekers,
  'TEXT_INFO_FEATURED_JOBSEEKERS2'=>$no_of_featured_jobseekers,
  'TEXT_INFO_TOTAL_RECRUITERS2'=>$no_of_recruiters,
  'TEXT_INFO_ACTIVE_RECRUITERS2'=>$no_of_active_recruiters,
  'TEXT_INFO_INACTIVE_RECRUITERS2'=>$no_of_inactive_recruiters,
  'TEXT_INFO_FEATURED_RECRUITERS2'=>$no_of_featured_recruiters,
  'TEXT_INFO_TOTAL_JOBS2'=>$no_of_jobs,
  'TEXT_INFO_ACTIVE_JOBS2'=>$no_of_active_jobs,
  'TEXT_INFO_DELETED_JOBS2'=>$no_of_deleted_jobs,
  'TEXT_INFO_EXPIRED_JOBS2'=>$no_of_expired_jobs,
  'TEXT_INFO_OTHER_JOBS2'=>$no_of_other_jobs,
  'TEXT_INFO_SALES2'=>$currencies->format($sales, true, DEFAULT_CURRENCY),
  'TEXT_INFO_JOBSEEKERS'=>TEXT_INFO_JOBSEEKERS,
  'TEXT_INFO_FEATURED_JOBSEEKERS'=>TEXT_INFO_FEATURED_JOBSEEKERS,
  'TEXT_INFO_TOTAL_RECRUITERS'=>TEXT_INFO_TOTAL_RECRUITERS,
  'TEXT_INFO_ACTIVE_RECRUITERS'=>TEXT_INFO_ACTIVE_RECRUITERS,
  'TEXT_INFO_INACTIVE_RECRUITERS'=>TEXT_INFO_INACTIVE_RECRUITERS,
  'TEXT_INFO_FEATURED_RECRUITERS'=>TEXT_INFO_FEATURED_RECRUITERS,
  'TEXT_INFO_TOTAL_JOBS'=>TEXT_INFO_TOTAL_JOBS,
  'TEXT_INFO_ACTIVE_JOBS'=>TEXT_INFO_ACTIVE_JOBS,
  'TEXT_INFO_DELETED_JOBS'=>TEXT_INFO_DELETED_JOBS,
  'TEXT_INFO_EXPIRED_JOBS'=>TEXT_INFO_EXPIRED_JOBS,
  'TEXT_INFO_OTHER_JOBS'=>TEXT_INFO_OTHER_JOBS,
  'TEXT_INFO_SALES'=>TEXT_INFO_SALES,
 ));
}
//
krsort($chart_array);
$chart_data='["Month","Recruiter","Jobs"],'."\n";
$chart_data1='["Month", "Jobseeker"],'."\n";
foreach($chart_array as $chart)
{
 $chart_data.='["'.$chart['x_group'] .'",'.$chart['recruiter'] .','.$chart['jobs'] .'],'."\n";
 $chart_data1.='["'.$chart['x_group'] .'", '.$chart['jobseeker'] .'],'."\n";
}
$chart_data=substr($chart_data,0,-2);
$chart_data1=substr($chart_data1,0,-2);


$template->assign_vars(array(
 'HEADING_TITLE'=>HEADING_TITLE,
 'TABLE_HEADING_REPORT_YEAR1'=>sprintf(TABLE_HEADING_REPORT_YEAR,$year),
 'TABLE_HEADING_REPORT'=>TABLE_HEADING_REPORT,
 'TABLE_HEADING_STATISTICS'=>TABLE_HEADING_STATISTICS,
 'TEXT_INFO_JOBSEEKERS'=>TEXT_INFO_JOBSEEKERS,
 'TEXT_INFO_FEATURED_JOBSEEKERS'=>TEXT_INFO_FEATURED_JOBSEEKERS,
 'TEXT_INFO_TOTAL_RECRUITERS'=>TEXT_INFO_TOTAL_RECRUITERS,
 'TEXT_INFO_ACTIVE_RECRUITERS'=>TEXT_INFO_ACTIVE_RECRUITERS,
 'TEXT_INFO_INACTIVE_RECRUITERS'=>TEXT_INFO_INACTIVE_RECRUITERS,
 'TEXT_INFO_FEATURED_RECRUITERS'=>TEXT_INFO_FEATURED_RECRUITERS,
 'TEXT_INFO_TOTAL_JOBS'=>TEXT_INFO_TOTAL_JOBS,
 'TEXT_INFO_ACTIVE_JOBS'=>TEXT_INFO_ACTIVE_JOBS,
 'TEXT_INFO_DELETED_JOBS'=>TEXT_INFO_DELETED_JOBS,
 'TEXT_INFO_EXPIRED_JOBS'=>TEXT_INFO_EXPIRED_JOBS,
 'TEXT_INFO_FEATURED_JOBS'=>TEXT_INFO_FEATURED_JOBS,
 'TEXT_INFO_OTHER_JOBS'=>TEXT_INFO_OTHER_JOBS,
 'TEXT_INFO_SALES'=>TEXT_INFO_SALES,
 'form'=>tep_draw_form('report', PATH_TO_ADMIN.FILENAME_ADMIN1_CONTROL_PANEL, 'action=show_report', 'post'),
 'button'=>'<input type="submit" name="report" value="Go">',
 'TABLE_HEADING_MONTH'=>TABLE_HEADING_MONTH,
 'TABLE_HEADING_JOBSEEKER'=>TABLE_HEADING_JOBSEEKER,
 'TABLE_HEADING_JOB'=>TABLE_HEADING_JOB,
 'TABLE_HEADING_RECRUITER'=>TABLE_HEADING_RECRUITER,
 'TABLE_HEADING_SALES'=>TABLE_HEADING_SALES,
 'CHART_DATA_REPORT_YEAR'=>strip_tags(sprintf(TABLE_HEADING_REPORT_YEAR,$year)),
 'chart_data' =>$chart_data,
 'chart_data1' =>$chart_data1,

 'update_message'=>$messageStack->output()));

//////////////// Global /////
 $year_listing=year_listing(date('Y'),'2009','name="year"','Year','',$year);
 $no_of_jobseekers=no_of_records(JOBSEEKER_LOGIN_TABLE,'1');
 $no_of_featured_jobseekers=no_of_records(JOBSEEKER_TABLE,"jobseeker_featured='Yes'");
 $no_of_recruiters=no_of_records(RECRUITER_LOGIN_TABLE,"1");
 $today=date("Y-m-d");
 $no_of_active_recruiters=no_of_records(RECRUITER_LOGIN_TABLE." as rl,".RECRUITER_ACCOUNT_HISTORY_TABLE." as ra","rl.recruiter_id=ra.recruiter_id and ra.start_date <= '$today' and ra.end_date >='$today'",'distinct(rl.recruiter_id)');
 $no_of_inactive_recruiters=$no_of_recruiters-$no_of_active_recruiters;
 $no_of_featured_recruiters=no_of_records(RECRUITER_TABLE,"recruiter_featured='Yes'");
 $no_of_jobs=no_of_records(JOB_TABLE,"1");
 $today=date("Y-m-d H:i:s");
 $no_of_active_jobs=no_of_records(JOB_TABLE." as j"," j.re_adv <= '".$today."' and j.expired >= '".$today."' and j.deleted is NULL");
 $no_of_deleted_jobs=no_of_records(JOB_TABLE." as j"," j.re_adv <= '".$today."' and j.deleted <= '".$today."'");
 $no_of_expired_jobs=no_of_records(JOB_TABLE." as j"," j.re_adv <= '".$today."' and j.expired <= '".$today."' and j.deleted is NULL");
 $no_of_featured_jobs=no_of_records(JOB_TABLE." as j"," j.re_adv <= '".$today."' and j.expired >= '".$today."' and j.job_featured='Yes' and j.deleted is NULL");
 $no_of_other_jobs=no_of_records(JOB_TABLE." as j"," j.re_adv > '".$today."' and j.expired >= '".$today."' and j.deleted is NULL");
 $no_of_orders=no_of_records(ORDER_TABLE." as o"," 1 ");
 $query="select ot.value from ".ORDER_TABLE." as o,".ORDER_TOTAL_TABLE." as ot where o.orders_id=ot.orders_id and ot.class='ot_total' and o.orders_date_finished <= '$today'";
 $result=tep_db_query($query);
 $sales=0.00;
 if(tep_db_num_rows($result) >= 1)
 {
  while($row=tep_db_fetch_array($result))
   $sales+=$row['value'];
 }
 $orders_query_raw = "select o.orders_id, o.recruiter_name, o.date_purchased, s.orders_status_name, ot.text as order_total from " . ORDER_TABLE . " o left join " . ORDER_TOTAL_TABLE . " ot on (o.orders_id = ot.orders_id) left outer join  " . ORDER_STATUS_TABLE . " s  on (o.orders_status = s.orders_status_id and  s.language_id = '" . (int)$languages_id . "') where  ot.class = 'ot_total' order by o.orders_id DESC limit 0,6";
	$orders_query = tep_db_query($orders_query_raw);
 $total_order = tep_db_num_rows($orders_query);
 $alternate=0;
	while ($orders = tep_db_fetch_array($orders_query))
 {
 	$row_selected=' class="DBdataTableRow'.($alternate%2==1?'1':'2').'"';
  $template->assign_block_vars('recruiter_order', array( 'row_selected' => $row_selected,
   'name' =>  tep_db_output($orders['recruiter_name']),
   'order_total' => strip_tags($orders['order_total']),
   'date_purchased' => tep_date_short($orders['date_purchased']),
   'status' => tep_db_output($orders['orders_status_name']),
   ));
  $alternate++;
 }
 tep_db_free_result($orders_query);


 $template->assign_vars(array('TABLE_HEADING_STATISTICS_YEAR'=>$year_listing,
 'TEXT_INFO_JOBSEEKERS1'=>$no_of_jobseekers,
 'TEXT_INFO_FEATURED_JOBSEEKERS1'=>$no_of_featured_jobseekers,
 'TEXT_INFO_TOTAL_RECRUITERS1'=>$no_of_recruiters,
 'TEXT_INFO_ACTIVE_RECRUITERS1'=>$no_of_active_recruiters,
 'TEXT_INFO_INACTIVE_RECRUITERS1'=>$no_of_inactive_recruiters,
 'TEXT_INFO_FEATURED_RECRUITERS1'=>$no_of_featured_recruiters,
 'TEXT_INFO_TOTAL_JOBS1'=>$no_of_jobs,
 'TEXT_INFO_ACTIVE_JOBS1'=>$no_of_active_jobs,
 'TEXT_INFO_DELETED_JOBS1'=>$no_of_deleted_jobs,
 'TEXT_INFO_FEATURED_JOBS1'=>$no_of_featured_jobs,
 'TEXT_INFO_EXPIRED_JOBS1'=>$no_of_expired_jobs,
 'TEXT_INFO_OTHER_JOBS1'=>$no_of_other_jobs,
 'TEXT_INFO_TOTAL_ORDERS'=>TEXT_INFO_TOTAL_ORDERS,
 'TEXT_INFO_TOTAL_ORDERS1'=>$no_of_orders,

 'TEXT_INFO_SALES1'=>$sales,//$currencies->format($sales, true, DEFAULT_CURRENCY),
 'INFO_TEXT_SECTION_HELP'=>INFO_TEXT_SECTION_HELP,
 'INFO_TEXT_SECTION_ORDER'=>INFO_TEXT_SECTION_ORDER,
 'INFO_TEXT_MORE_ORDER'=>($total_order>0)?'<a href="'.FILENAME_ADMIN1_RECRUITER_ORDERS.'?selected_box=orders" >'.INFO_TEXT_MORE_ORDER.'</a>':'',
 'INFO_TEXT_MORE_HELP'=>'<a href="https://www.youtube.com/user/jobboardsoftware/videos" title="More Help" target="_blank">'.INFO_TEXT_MORE_HELP.'</a>',
  ));
$template->pparse('control_panel');
?>