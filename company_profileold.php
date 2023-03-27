<?
/*
***********************************************************
**********# Name          : Shambhu Prasad Patnaik#********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
***********************************************************
*/
session_cache_limiter('private_no_expire');
include_once("include_files.php");
//ini_set('max_execution_time','0');
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_JOBSEEKER_COMPANY_PROFILE);
$template->set_filenames(array('company_profile' => 'company_profile.htm','company_profile_result'=>'company_profile_result.htm'));
include_once(FILENAME_BODY);
$state_error=false;
$action = (isset($_POST['action']) ? $_POST['action'] : '');
//print_r($_POST);
// search
if(tep_not_null($action))
{
 switch($action)
 {
  case 'search':
   $action=tep_db_prepare_input($_POST['action']);
   $hidden_fields.=tep_draw_hidden_field('action',$action);
   $company_name=tep_db_prepare_input($_POST['company_name']);
   $recruiter_email_address=check_data1($company_name,"=","recruiter_email","mail");
   $field=tep_db_prepare_input($_POST['field']);
   $order=tep_db_prepare_input($_POST['order']);
   $lower=(int)tep_db_prepare_input($_POST['lower']);
   $higher=(int)tep_db_prepare_input($_POST['higher']);
   $whereClause='';
   $whereClause.=" rl.recruiter_email_address ='".tep_db_input($recruiter_email_address)."'  ";
   $hidden_fields.=tep_draw_hidden_field('company_name',$company_name);
   // company_name ends ///
   $whereClause=(tep_not_null($whereClause)?$whereClause.' and ':'');
   ////
   $now=date('Y-m-d H:i:s');
   $field_names="j.job_id,j.job_title,j.job_industry_sector,j.re_adv,j.expired,r.recruiter_featured,r.recruiter_company_name";
   $table_names=RECRUITER_TABLE.' as r, '.RECRUITER_LOGIN_TABLE.' as rl, '.JOB_TABLE." as j";
   $whereClause.="r.recruiter_id=rl.recruiter_id and rl.recruiter_status='Yes' and r.recruiter_id=j.recruiter_id  and j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00')";
   $query1 = "select count(j.job_id) as x1 from $table_names where $whereClause ";
   //echo "<br>$query1";//exit;
   $result1=tep_db_query($query1);
   $tt_row=tep_db_fetch_array($result1);
   $x1=$tt_row['x1'];
   //echo $x1;//exit;
   //////////////////
  ///only for sorting starts
   include_once('class/'.'sort_by_clause.php');
   $sort_array=array("j.job_title",'r.recruiter_company_name','j.re_adv','j.expired');
   $obj_sort_by_clause=new sort_by_clause($sort_array,'j.re_adv desc');
   $order_by_clause=$obj_sort_by_clause->return_value;
   $see_before_page_number_array=see_before_page_number123($sort_array,$field,'j.re_adv',$order,'desc',$lower,'0',$higher,'20');
   $lower=$see_before_page_number_array['lower'];
   $higher=$see_before_page_number_array['higher'];
   $field=$see_before_page_number_array['field'];
   $order=$see_before_page_number_array['order'];
   $hidden_fields.=tep_draw_hidden_field('sort',$sort);
   $template->assign_vars(array('TABLE_HEADING_JOB_TITLE'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][0]."','".$lower."');\"><u>".TABLE_HEADING_JOB_TITLE.'</u>'.$obj_sort_by_clause->return_sort_array['image'][0]."</a>",
                                'TABLE_HEADING_COMPANY_NAME'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][1]."','".$lower."');\"><u>".TABLE_HEADING_COMPANY_NAME.'</u>'.$obj_sort_by_clause->return_sort_array['image'][1]."</a>",
                                'TABLE_HEADING_ADVERTISED'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][2]."','".$lower."');\"><u>".TABLE_HEADING_ADVERTISED.'</u>'.$obj_sort_by_clause->return_sort_array['image'][2]."</a>",
                                'TABLE_HEADING_EXPIRED'=>"<a href='#' class='white' onclick=\"submit_thispage('".$obj_sort_by_clause->return_sort_array['name'][3]."','".$lower."');\"><u>".TABLE_HEADING_EXPIRED.'</u>'.$obj_sort_by_clause->return_sort_array['image'][3]."</a>"));
  ///only for sorting ends

   $totalpage=ceil($x1/$higher);
   $query = "select $field_names from $table_names where $whereClause ORDER BY ".$order_by_clause." limit $lower,$higher";
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
     $ide=$row["job_id"];
     $job_category="";
     $title_format=encode_category($row['job_title']);
     $query_string=encode_string("job_id=".$ide."=job_id");
     $company_name=tep_db_output($row['recruiter_company_name']);
     if($row['recruiter_featured']=='Yes')
     {
      $company_name='<a href="'.tep_href_link(FILENAME_JOBSEEKER_COMPANY_DETAILS,'query_string='.$query_string).'">'.$company_name.'</a>';
     }
	 ///////////jobcategory extraction//////////////
	 $query_catid="select * from ".JOB_JOB_CATEGORY_TABLE." where job_id='".$ide."'";
	 $result_catid=tep_db_query($query_catid);
	 while($row_catid = tep_db_fetch_array($result_catid))
		{
			$job_category.=get_name_from_table(JOB_CATEGORY_TABLE,TEXT_LANGUAGE.'category_name', 'id',$row_catid["job_category_id"])."<br>";
		}
   ////////////////////////////////////////////////////////////////////////
     $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"';
     $template->assign_block_vars('result', array( 'row_selected' => $row_selected,
      'job_title' => '<a href="'.tep_href_link($ide.'/'.$title_format.'.html').'">'.tep_db_output($row['job_title']).'</u></a>',
      'company_name' => $company_name,
      'job_category' => $job_category,//get_name_from_table(JOB_CATEGORY_TABLE,TEXT_LANGUAGE.'category_name', 'id',$row['job_industry_sector']),
      're_adv' => tep_date_long(tep_db_output($row['re_adv'])),
      'expired' => tep_date_long(tep_db_output($row['expired'])),
      'apply' => '<a href="'.tep_href_link(FILENAME_APPLY_NOW,'query_string='.$query_string).'">'.INFO_TEXT_APPLY_NOW.'</a>',
      ));
     $alternate++;
     $lower = $lower + 1;
    }
    $plural=($x1=="1")? INFO_TEXT_JOB:INFO_TEXT_JOBS;
    $template->assign_vars(array('total'=>tep_db_output(SITE_TITLE).INFO_TEXT_HAS_MATCHED." <font color='red'><b>$x1</b></font> ".$plural. INFO_TEXT_TO_YOUR_SEARCH_CRITERIA));
   }
   else
   {
    $template->assign_vars(array('total'=>tep_db_output(SITE_TITLE)." ".INFO_TEXT_HAS_NOT_MATCHED));
   }
   see_page_number();
   tep_db_free_result($result1);
   tep_db_free_result($result);

  }
  $company_name=tep_db_prepare_input($_POST['company_name']);
  $recruiter_email_address=check_data1($company_name,"=","recruiter_email","mail");
  $filed_names='r.recruiter_company_name,recruiter_logo,r.recruiter_url,d.description,r.recruiter_city,if(r.recruiter_state_id,z.zone_name,r.recruiter_state) as recruiter_state,c.country_name,r.recruiter_zip,r.recruiter_telephone';
  $recuiter_address='';
  $company_logo1='';
  $company_description='';
  if($row_info=getAnyTableWhereData(RECRUITER_LOGIN_TABLE." as rl left join ".RECRUITER_TABLE." as r on ( r.recruiter_id = rl.recruiter_id)  left outer join ".COMPANY_DESCRIPTION_TABLE." as d on (rl.recruiter_id=d.recruiter_id) left outer join  ".COUNTRIES_TABLE." as c on (r.recruiter_country_id=c.id) left outer join ".ZONES_TABLE." as z on(r.recruiter_state_id=z.zone_id )" ," rl.recruiter_email_address= '".tep_db_input($recruiter_email_address)."'",$filed_names))
  {
   $query_string1=encode_string("recruiter_email=".$recruiter_email_address."=mail");
   if($row_info['recruiter_city']!='')
   $recuiter_address=$row_info['recruiter_city'];
   $recuiter_address.=' '.$row_info['recruiter_state'];
   $recuiter_address.=' '.$row_info['country_name'];
   $recuiter_address =trim($recuiter_address);
   if($recuiter_address!='' && $row_info['recruiter_telephone']!='')
    $recuiter_address.="<br>Ph:".$row_info['recruiter_telephone'];
   if($recuiter_address!='' && $row_info['recruiter_zip']!='')
   $recuiter_address.="<br>".$row_info['recruiter_zip'];

   $recruiter_company_name=tep_db_output($row_info['recruiter_company_name']);
   $header_title='<title>'.tep_db_output($row_info['recruiter_company_name']).'</title>';
   $company_logo=$row_info['recruiter_logo'];
   $company_description= strip_tags($row_info['description'],'<a><b><i><u><br>');
   if($company_description!='')
   {
    if(strlen($company_description)>=350)
     $company_description='<div><b>Description</b><br>'.stripslashes(substr($company_description,0,350)).' <a href="'.tep_href_link(FILENAME_JOBSEEKER_COMPANY_DETAILS,'query_string1='.$query_string1).'"  style="color:red;">more >></a>'.' </div>';
    else
    $company_description='<div><b>Description</b><br>'.stripslashes($company_description).'</div>';
   }
   if(tep_not_null($company_logo) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_LOGO.$company_logo))
   {
    if(tep_not_null($row['recruiter_url']))
    {
     $photo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$company_logo,'','','','class="employer-logo"');
     $company_logo1='<a href="'.$row['recruiter_url'].'" target="new_site">'.$photo.'</a>';
    }
    else
    {
     $photo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$company_logo,'','','','class="employer-logo"');
     $company_logo1=$photo;
    }
   }
  }

  $template->assign_vars(array(
 'HEADING_TITLE'=>$recruiter_company_name,
 'INFO_TEXT_HEADER_TITLE'=>$header_title,
 'INFO_TEXT_RECRUITER_LOGO'=>$company_logo1,
 'INFO_TEXT_RECRUITER_DESC'=>$company_description,
 'INFO_TEXT_RECRUITER_ADDRESS'=>$recuiter_address,
 'TABLE_HEADING_APPLY'=>TABLE_HEADING_APPLY,
 'TABLE_HEADING_JOB_CATEGORY'=>TABLE_HEADING_JOB_CATEGORY,
 'hidden_fields' => $hidden_fields,
 'back_button' => tep_image_button(PATH_TO_BUTTON.'button_back.gif', IMAGE_BACK,'onclick="history.back();"'),
 'INFO_TEXT_COMPANY_NAME' => INFO_TEXT_COMPANY_NAME,
 'INFO_TEXT_COMPANY_NAME1' => $company_string,
 'hidden_fields' => $hidden_fields,
 'RIGHT_BOX_WIDTH' => RIGHT_BOX_WIDTH1,
 'RIGHT_HTML' => RIGHT_HTML,
 'JOB_SEARCH_LEFT' => JOB_SEARCH_LEFT,
 'update_message' => $messageStack->output(),
 ));
 $template->pparse('company_profile_result');
}
else
{
 define('MAX_DISPLAY_DIRECTORY_RESULT',100);
	$now=date('Y-m-d H:i:s');
 $whereClause1=" select distinct(j.recruiter_id) as recruiter_id from ".JOB_TABLE."  as j  where j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00')";
 $whereClause="where rl.recruiter_status='Yes' and r.recruiter_id in ($whereClause1)";
// $whereClause="where rl.recruiter_status='Yes'";
 $query1 = "select count(r.recruiter_id ) as x1 from ".RECRUITER_TABLE." as r left join ".RECRUITER_LOGIN_TABLE." as rl on ( r.recruiter_id = rl.recruiter_id) ". $whereClause;
 $result1=tep_db_query($query1);
 $tt_row=tep_db_fetch_array($result1);
 $x1=$tt_row['x1'];//echo $query1;
 //echo $x1;die();
 ///only for sorting starts
 include_once('class/'.'sort_by_clause.php');
 $sort_array=array("recruiter_company_name",'inserted');
 $obj_sort_by_clause=new sort_by_clause($sort_array,'recruiter_company_name asc');
 $order_by_clause=$obj_sort_by_clause->return_value;
 if(tep_not_null($_GET['directoru_char']))
 {
  $get_char=$_GET['directoru_char'];
  if (in_array($get_char,array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z' )) && $get_char!='')
  {
   $recofigar_limit=(int)get_company_direct_limit($get_char);
   if($recofigar_limit>MAX_DISPLAY_DIRECTORY_RESULT)
    $recofigar_limit=$recofigar_limit-($recofigar_limit%MAX_DISPLAY_DIRECTORY_RESULT);//
   $_POST['lower']=$recofigar_limit;
   if($recofigar_limit>0)
   $_POST['page'][0]=(int)$recofigar_limit/MAX_DISPLAY_DIRECTORY_RESULT;

  }
 }

 $see_before_page_number_array=see_before_page_number123($sort_array,$field,'recruiter_company_name',$order,'asc',$lower,'0',$higher,MAX_DISPLAY_DIRECTORY_RESULT);
 //$lower=
 $lower=$see_before_page_number_array['lower'];
 $higher=$see_before_page_number_array['higher'];
 $field=$see_before_page_number_array['field'];
 $order=$see_before_page_number_array['order'];
 $hidden_fields.=tep_draw_hidden_field('sort',$sort);
 $totalpage=ceil($x1/$higher);
 $fields="recruiter_company_name,recruiter_email_address,recruiter_logo,recruiter_country_id,recruiter_city";
 $query = "select $fields  from ".RECRUITER_TABLE." as r left join ".RECRUITER_LOGIN_TABLE." as rl on ( r.recruiter_id = rl.recruiter_id) $whereClause ORDER BY  $field $order limit $lower,$higher   ";
 $result=tep_db_query($query);//echo "<br>$query";//exit;
 $x=tep_db_num_rows($result);//echo $x;exit;
 $pno= ceil($lower+$higher)/($higher);
 $link_array=array();
	if($x > 0 && $x1 > 0)
 {
  $alternate=1;
  $company_name1_old="";
  $company_list='';
  while($row =  tep_db_fetch_array($result))
  {

   $company_name1=strtoupper(substr($row["recruiter_company_name"],0,1));
   $title="";
   $company_name="";
   if($company_name1!=$company_name1_old || $company_name1_old=='')
   {
    $title="<a id='".tep_db_output($company_name1)."'>".tep_db_output($company_name1)."</a>";
    $link_array[]=$company_name1;
   }
			$company_logo=$row['recruiter_logo'];
   if(tep_not_null($company_logo) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_LOGO.$company_logo))
			{
			 $company_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$company_logo,'','','','class="img-responsive bycompany"');

			}
			else $company_logo=tep_image('img/no_image_available.jpg','logo','','','class="img-responsive bycompany"');


   $email_id=$row["recruiter_email_address"];
   $query_string1=encode_string("recruiter_email=".$email_id."=mail");
//////////////////////
 $country=get_name_from_table(COUNTRIES_TABLE, 'country_name', 'id',tep_db_output($row['recruiter_country_id']));
 $city=tep_db_output($row['recruiter_city']);
 $company_address=tep_not_null($city)?"$city, $country":"$country";
 $company_name="<a href='#' onclick='search_company(\"".$query_string1."\")'>".tep_db_output($row['recruiter_company_name'])."</a>";
 $company_logo_link="<a href='#' onclick='search_company(\"".$query_string1."\")'>".$company_logo."</a>";
 $view_jobs="<span class='company-jobs'><a href='#' onclick='search_company(\"".$query_string1."\")'><i class='fa fa-briefcase' aria-hidden='true'></i> View Jobs</a></span>";
$company_list='<td><div class="panel"><h3 class="panel-title"><strong>'.$company_name.'</strong></h3>'.$company_logo_link.'<span class="company-location"><i class="fa fa-map-marker" aria-hidden="true"></i> '.$company_address.'</span><br>'.$view_jobs.'</div></td>';
////////////////////////////
   $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"';
  $alternate++;

/*	if($alternate%3 == 0)
	{
   $company_list.="</tr><tr>";
	}
	else
	{
   $company_list.="</div></td><td><div class='panel'>";
	}
*/
   $template->assign_block_vars('company_list', array( 'row_selected'   => $row_selected,
                                                       'company_list'   => $company_list,
                                                       'title'          => $title,
                                                      ));


   $company_name1_old=$company_name1;
   $lower = $lower + 1;
  }
$company_list.="</tr>";
  see_page_number();
  $template->assign_vars(array('total'=>SITE_TITLE." ".INFO_TEXT_HAVE."  <span  class='red'>$x1</span> ".INFO_TEXT_COMPANY_IN_DIRECTORY));
 }
 else
  {
   $template->assign_vars(array('total'=>INFO_TEXT_NO_COMPANY_DIRECTORY));
  }
 tep_db_free_result($result);
 tep_db_free_result($result1);
 $header_link='<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="abcd"><tr>';
$header_link.='<td><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a></td>';
for($i='A';$i!='AA';$i++)
 {
  if(in_array($i,$link_array))
   $header_link.='<td align="center" class="style12"><a href="#'.$i.'" class="blue">'.$i.'</a></td>';
  //elseif($row=getAnyTableWhereData(RECRUITER_TABLE," recruiter_company_name like '".tep_db_input($i)."%'",'recruiter_id'))
  // $header_link.='<td align="center" class="style12"><a href="'.FILENAME_JOBSEEKER_COMPANY_PROFILE.'?directoru_char='.$i.'#'.$i.'" class="blue">'.$i.'</a></td>';
  else
   $header_link.='<td align="center" class="style12">'.$i.'</td>';
 }
	$header_link.='</tr></table>';
// echo $header_link=substr($header_link,0,-7);
 //////////////////////////////////////////////////////////
 $template->assign_vars(array(
  'HEADING_TITLE'         => HEADING_TITLE,
  'form'                  => tep_draw_form('company_search', FILENAME_JOBSEEKER_COMPANY_PROFILE,'','post').tep_draw_hidden_field('action','search').tep_draw_hidden_field('company_name',''),
  'INFO_TEXT_HEADER_LINK' => $header_link,
	'COMPANY_LIST'=>$company_list,
  'hidden_fields'         => $hidden_fields,
  'INFO_TEXT_MAIN'        => INFO_TEXT_MAIN,
  'LEFT_BOX_WIDTH'        => LEFT_BOX_WIDTH1,
  'RIGHT_BOX_WIDTH'       => RIGHT_BOX_WIDTH1,
  'HEADER_HTML'           => HEADER_HTML,
  'LEFT_HTML'             => '',
  'RIGHT_HTML'            => RIGHT_HTML,
  'JOB_SEARCH_LEFT'       => JOB_SEARCH_LEFT,
  'update_message'=>$messageStack->output()));
  $template->pparse('company_profile');
}
?>