<?php
if($_SESSION['language']=='english')
  include_once(dirname(__FILE__).'/language/home_english.php');
################################RIGHT BANNER #################
$home_rt_banner=banner_display("1",1,250,"class='img-responsive'");
$right_banner=$home_rt_banner[0];
########################################################
#################FEATURED EMPLOYER############################
$featured_emp=banner_display("7",12,125,"class='img-fluid img-thumbnail mb-2 mini-profile-img theme7-featured-logo'");
for($i=0;$i<count($featured_emp);$i++)
{
  $template->assign_block_vars('employer', array(
                                'emp'=>$featured_emp[$i],
                              ));
}
/////////// FEATURED EMPLOYER END///////////////
#################JOB CATEGORY############################
$field_names="id,".TEXT_LANGUAGE."category_name";
$whereClause=" where sub_cat_id is null";
$query11 = "select $field_names from ".JOB_CATEGORY_TABLE." $whereClause  order by ".TEXT_LANGUAGE."category_name  asc limit 0,21";//.(int) MODULE_THEME_SAMPLE2_MAX_JOB_CATEORY;
$result11=tep_db_query($query11);
$i=1;
$job_category="";
while($row11 = tep_db_fetch_array($result11))
{
 $ide=$row11["id"];
 $row11[TEXT_LANGUAGE.'category_name'];
 $job_category_form=tep_draw_form('job_category'.$i, FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
	$key=((strlen($row11[TEXT_LANGUAGE.'category_name'])<30)?$row11[TEXT_LANGUAGE.'category_name']:substr($row11[TEXT_LANGUAGE.'category_name'],0,28)."..");
	$key1=$row11[TEXT_LANGUAGE.'category_name'];
	$job_category.="<div class='mb-2'><a href='".$ide.'/'.encode_category($key1)."-jobs.html"."'  title='".tep_db_output($key1)."'>".tep_db_output($key)."</a></div>";
$i++;
}
$job_category.="</ul>";
/****************end of JOB CATEGORY******************/
//////////////////// LATEST JOBS STARTS ///////////////////
$now=date('Y-m-d H:i:s');
$table_names=JOB_TABLE." as j,".RECRUITER_LOGIN_TABLE.' as rl,'.RECRUITER_TABLE.' as r';
$whereClause="j.recruiter_id=rl.recruiter_id and rl.recruiter_id=r.recruiter_id and rl.recruiter_status='Yes' and j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and j.job_featured='No' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00') ";//
$field_names="j.job_id, j.job_title, j.job_salary, j.job_location,j.job_short_description,j.inserted, r.recruiter_company_name,job_country_id,r.recruiter_logo";
$order_by_field_name = "j.inserted";
$query = "select $field_names from $table_names where $whereClause order by $order_by_field_name limit 0,5";

$result=tep_db_query($query);
$x=tep_db_num_rows($result);
//echo $x;exit;
$count=1;
while($row = tep_db_fetch_array($result))
{
 $ide=$row["job_id"];
 $title_format=encode_category($row['job_title']);
 $query_string=encode_string("job_id=".$ide."=job_id");
 
  ///logo
$comp_logo='';
if(tep_not_null($row["recruiter_logo"]) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_LOGO.$row["recruiter_logo"]))
    $comp_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$row["recruiter_logo"]."&size=100",'','','','');
  else
    $comp_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_IMG."nologo.jpg&size=100",'','','','');
  ///////////
  
/////logo
 $recruiter_logo='';
 $company_logo=$row['recruiter_logo'];
 if(tep_not_null($company_logo) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_LOGO.$company_logo))
     $recruiter_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$company_logo."&size=150",'','','','class="featured-logo thumbnail img-responsive img-hover"');
///////////////
 $title=' <a href="'.tep_href_link($ide.'/'.$title_format.'.html').'" target="_blank">'.$row['job_title'].'</a>';
 $template->assign_block_vars('latest_jobs', array(
                              'title'    => $title,
                              'location' => tep_db_output($row['job_location']),
                              'company'   =>tep_db_output($row['recruiter_company_name']),
							  'clogo'=>$comp_logo,
                              ));
 $count++;
}
//// LATEST JOB ENDS ////
//////////////////// FEATURED JOBS STARTS ///////////////////
$now=date('Y-m-d H:i:s');
$table_names=JOB_TABLE." as j,".RECRUITER_LOGIN_TABLE.' as rl,'.RECRUITER_TABLE.' as r';
$whereClause="j.recruiter_id=rl.recruiter_id and rl.recruiter_id=r.recruiter_id and rl.recruiter_status='Yes'and j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and j.job_featured='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00') ";//
$field_names="j.job_id, j.job_title, j.job_salary, j.job_location,j.job_short_description,j.inserted, r.recruiter_company_name,job_country_id,r.recruiter_logo";
$query = "select $field_names from $table_names where $whereClause order by rand() limit 0,4" ;// " . (int) MODULE_THEME_JOBSITE12_MAX_LATEST_JOB;
//echo "<br>$query";//exit;
$result=tep_db_query($query);
$x=tep_db_num_rows($result);
//echo $x;exit;
$count=1;
while($row = tep_db_fetch_array($result))
{
 $ide=$row["job_id"];
 $title_format=encode_category($row['job_title']);
 $query_string=encode_string("job_id=".$ide."=job_id");
  if(strlen($row['recruiter_company_name']) > 20)
  $company_name_short=	substr($row['recruiter_company_name'],0,15).'..';
 else
  $company_name_short=	substr($row['recruiter_company_name'],0,20);
	$company=$company_name_short;
/////logo
 $recruiter_logo='';
 $company_logo=$row['recruiter_logo'];
 if(tep_not_null($company_logo) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_LOGO.$company_logo))
     $recruiter_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$company_logo,'','','','class="img-fluid img-thumbnail theme7-featured"');
///////////////
$description=(tep_not_null(strlen($row['job_short_description']))>100?substr($row['job_short_description'],0,98).'..':$row['job_short_description']);  if(strlen($row['job_title']) > 25)  $title=	substr($row['job_title'],0,20).'..'; else  $title=	substr($row['job_title'],0,25);
$titlenew=' <a href="'.tep_href_link($ide.'/'.$title_format.'.html').'" target="_blank">'.$title.'</a>';
 $template->assign_block_vars('featured_jobs', array(
                              'title'    => $titlenew,
						      'logo'	 =>$recruiter_logo,
                              ));
 $count++;
}
//// FEATURED JOB ENDS ////
##############  JOBS BY CATEGORY LOCATION AND COMPANY IN 3 DIFFERENT TABS ##################
##########################  JOB CATEGORY 1 (In TAB) ############################
$field_names="id,".TEXT_LANGUAGE."category_name";
$whereClause=" where sub_cat_id is null";
$query11 = "select $field_names from ".JOB_CATEGORY_TABLE." $whereClause  order by ".TEXT_LANGUAGE."category_name  asc limit 0,14";//.(int) MODULE_THEME_DEFAULT_MAX_JOB_CATEORY;
$result11=tep_db_query($query11);
$c=1;
$job_category1="<div class='row'><div class='col-md-6'>";
while($row11 = tep_db_fetch_array($result11))
{
 $ide=$row11["id"];
 $row11[TEXT_LANGUAGE.'category_name'];
 $job_category1_form=tep_draw_form('job_category1'.$i, FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
 //$key=((strlen($row11['category_name'])<30)?$row11['category_name']:substr($row11['category_name'],0,27)."...");
	$key=((strlen($row11[TEXT_LANGUAGE.'category_name'])<30)?$row11[TEXT_LANGUAGE.'category_name']:substr($row11[TEXT_LANGUAGE.'category_name'],0,28)."..");
	$key1=$row11[TEXT_LANGUAGE.'category_name'];
	$job_category1.="<div class='mb-2'><a href='".$ide.'/'.encode_category($key1)."-jobs.html"."'  title='".tep_db_output($key1)."'>".tep_db_output($key)."</a></div>";
	if($c%7 == 0)
	{
     $job_category1.="</div><div class='col-md-6'>";
	}
$c++;
}
//$job_category1.="<td align='right' colspan='4'><a href='".tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY)."'>More&gt;&gt;</a></td></tr>"
$job_category1.="</div></div>";
/****************end of JOB CATEGORY******************/
#################JOB LOCATION############################
$default_country_value=DEFAULT_COUNTRY_ID;
$field_name12="zone_id,".TEXT_LANGUAGE."zone_name";
$whereclause12="where zone_country_id=$default_country_value";
$query12="select $field_name12 from ".ZONES_TABLE." $whereclause12 order by ".TEXT_LANGUAGE."zone_name asc limit 0,14";//.(int) MODULE_THEME_DEFAULT_MAX_JOB_LOCATION;
$result12=tep_db_query($query12);
$j=1;
$job_location="<div class='row'><div class='col-md-6'>";
while($row12=tep_db_fetch_array($result12))
{
	$id12=$row12['zone_id'];
 $location_form=tep_draw_form('job_location'.$j, FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
	$key12=((strlen($row12[TEXT_LANGUAGE.'zone_name'])<23)?$row12[TEXT_LANGUAGE.'zone_name']:substr($row12[TEXT_LANGUAGE.'zone_name'],0,20)."...");
	$job_location.="<div class='mb-2'>".$location_form."<input type='hidden' name='state[]' value='".$row12['zone_name']."'><a href='#' title='".tep_db_output($key12)."' onclick='document.job_location".$j.".submit()'>".tep_db_output($key12)."</a></div></form>";
	if($j%7 == 0)
	{
  $job_location.="</div><div class='col-md-6'>";
	}
$j++;
}
//$job_location.="<td align='right' colspan='6'><a href='".tep_href_link(FILENAME_JOB_SEARCH_BY_LOCATION)."' class='home_4'>".INFO_TEXT_HOME_MORE."&gt;&gt;</a></td></tr>";
$job_location.="</div></div>";
/****************end of JOB LOCATION******************/
/****************JOBS BY COMPANY*****************************/
$whereClause1="where rl.recruiter_status='Yes'";
$fields_c="recruiter_company_name,recruiter_email_address";
$query_c = "select $fields_c  from ".RECRUITER_TABLE." as r left join ".RECRUITER_LOGIN_TABLE." as rl on ( r.recruiter_id = rl.recruiter_id) $whereClause1 limit 0,14";
$result_c=tep_db_query($query_c);//echo "<br>$query";//exit;
$x=tep_db_num_rows($result_c);//echo $x;exit;
$k=1;
$company_name1_old="";
$company_form=tep_draw_form('company_search', FILENAME_JOBSEEKER_COMPANY_PROFILE,'','post').tep_draw_hidden_field('action','search').tep_draw_hidden_field('company_name','');
$job_company="<div class='col-md-6'>".$company_form."";
while($row_c=tep_db_fetch_array($result_c))
{
	$company_name1=strtoupper(substr($row_c["recruiter_company_name"],0,1));
	$company_name="";
 if($company_name1!=$company_name1_old || $company_name1_old=='')
 {
  $title="<li><a id='".tep_db_output($company_name1)."'>".tep_db_output($company_name1)."</a></li>";
  $link_array[]=$company_name1;
 }
 $email_id=$row_c["recruiter_email_address"];
$query_string1=encode_string("recruiter_email=".$email_id."=mail");
 $company_name="<a href='#' onclick='search_company(\"".$query_string1."\")'>".tep_db_output($row_c['recruiter_company_name'])."</a> ";
	$job_company.="<p>".$company_name."</p>";
	if($k%7 == 0)
	{
  $job_company.="</div><div class='col-md-3'>";
	}
	$company_name1_old=$company_name1;
 $k++;
}
//$job_company.="<td align='right' colspan='4'><a href='".tep_href_link(FILENAME_JOBSEEKER_COMPANY_PROFILE)."' class='home_4'>".INFO_TEXT_HOME_MORE."&gt;&gt;</a></td></tr></form>";
$job_company.="</div>";
/***************end of JOBS BY COMPANY************************/

/*************************codeing to display different form and save search link for login and non login users *********************/
if(check_login("jobseeker"))
{
	$save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT,($edit?'sID='.$save_search_id:''),'post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action1','save_search');
    $INFO_TEXT_ALERT_TEXT=$save_search.(($action1=='save_search')?'':"<a href='#' onclick='document.save_search.submit();' class='btn btn-sm btn-info btn-block py-2 mt-2'>Create Job Alert</a></form>");
}
else
{
	 $save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT_DIRECT,'','post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','new');
	 $INFO_TEXT_ALERT_TEXT=$save_search.''.tep_draw_input_field('TREF_job_alert_email', $TREF_job_alert_email,'class="form-control" placeholder="Email Address" ',false).''."<button type='submit' class='btn btn-sm theme7-btn-outline-warning btn-block py-2 mt-2'>Create Job Alert</button></form>";
}

/**********************************************************************************************************************************/


##############################################################################
$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>INFO_TEXT_ALL_CATEGORIES));
$default_country = DEFAULT_COUNTRY_ID;
$template->assign_vars(array(
'JOB_CATEGORY'=> $job_category,
'JOB_CATEGORY1'=>$job_category1,
'JOB_LOCATION'=>$job_location,
'JOB_COMPANY'=>$job_company,
'RT_BANNER'=>$right_banner,'JOB_ALERT'=>$INFO_TEXT_ALERT_TEXT,
'HOME_RIGHT_BANNER'=>$home_right_banner,
// 'ALL_JOBS'=>'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_JOB_SEARCH).'\'" type="submit">All Jobs</button>',
 'ALL_CATEGORY'=>'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'\'" type="submit">All Categories</button>',
 'LEFT_BOX_WIDTH'=> '',
 'RIGHT_BOX_WIDTH'=> RIGHT_BOX_WIDTH1,
 'RIGHT_HTML'=> RIGHT_HTML,
 'LEFT_HTML'=> '',
 'update_message'=> $messageStack->output(),
		));
	?>