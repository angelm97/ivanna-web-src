<?php
if($_SESSION['language']=="arabic")
{
 include_once(dirname(__FILE__).'/language/home_arabic.php');
}
else
{
 include_once(dirname(__FILE__).'/language/home_english.php');
}
	#################FEATURED EMPLOYER############################
$feat_emp=banner_display("7",18,155,"class='img-fluid img-thumbnail extra-mini-profile-img img-hover mr-2 mb-4 theme10-featured-logo'");
for($i=0;$i<=count($feat_emp);$i++)
{
  $template->assign_block_vars('featured', array(
                                'employer'=>$feat_emp[$i],
                              ));
}
/////////// FEATURED EMPLOYER END///////////////

#################JOB CATEGORY############################
$now=date('Y-m-d H:i:s');
$field_names="id,".TEXT_LANGUAGE."category_name";
$whereClause=" where sub_cat_id is null";
$query11 = "select $field_names from ".JOB_CATEGORY_TABLE." $whereClause  order by ".TEXT_LANGUAGE."category_name  asc limit 0,10";
$result11=tep_db_query($query11);
$i=1;
$job_category="";
while($row11 = tep_db_fetch_array($result11))
{
 $ide=$row11["id"];
// $category=$row11[TEXT_LANGUAGE.'category_name'];
 $job_category_form=tep_draw_form('job_category'.$i, FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
 $key1=$row11[TEXT_LANGUAGE.'category_name'];
 $job_category.="<p><a href='".$ide.'/'.encode_category($key1)."-jobs.html"."'  title='".tep_db_output($key1)."'>".tep_db_output($key1)."</a></p>
                    ";
$i++;
}

/****************end of JOB CATEGORY******************/

#################JOB LOCATION############################
$field_names="z.zone_name,c.country_name,ct.continent_name ";
$whereClause=" where z.zone_country_id ='".DEFAULT_COUNTRY_ID."' ";
$query11 = "select $field_names from ".ZONES_TABLE."  as z  left outer join ".COUNTRIES_TABLE." as c on (z.zone_country_id =c.id) left outer join  ".CONTINENT_TABLE." as ct on (c.continent_id = ct.id ) $whereClause  order by zone_name  asc limit 0,10";//. (int) MODULE_THEME_SAMPLE12_MAX_JOB_LOCATION;
$result11=tep_db_query($query11);
$i=1;
while($row1 = tep_db_fetch_array($result11))
{
 $continent_name = $row1['continent_name'];
 $country_name   = $row1['country_name'];
 $zone_name      = $row1['zone_name'];
 $template->assign_block_vars('job_location1', array(
                              'job_location'    => '<a href="'.encode_forum($continent_name).'/'.encode_forum($country_name).'/'.encode_forum($zone_name).'/"   title="'.tep_db_output($zone_name).'">' .tep_db_output($zone_name).'</a>',
                              ));
 $i++;

}
tep_db_free_result($result11);
/****************end of JOB LOCATION******************/

/****************JOBS BY COMPANY*****************************/
$now=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
$whereClause1="where rl.recruiter_status='Yes'";
$whereClause1.="and r.recruiter_id in (select distinct(j.recruiter_id) as recruiter_id from ".JOB_TABLE."  as j  where j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00'))";
$fields_c="recruiter_company_name,recruiter_email_address";
$query_c = "select $fields_c  from ".RECRUITER_TABLE." as r left join ".RECRUITER_LOGIN_TABLE." as rl on ( r.recruiter_id = rl.recruiter_id) $whereClause1 limit 0,11";//.(int) MODULE_THEME_SAMPLE12_MAX_JOB_COMPANY;
$result_c=tep_db_query($query_c);//echo "<br>$query";//exit;
$x=tep_db_num_rows($result_c);//echo $x;exit;
$k=1;
$company_name1_old="";
$company_form=tep_draw_form('company_search', FILENAME_JOBSEEKER_COMPANY_PROFILE,'','post').tep_draw_hidden_field('action','search').tep_draw_hidden_field('company_name','');
$job_company="".$company_form."";
while($row_c=tep_db_fetch_array($result_c))
{
	$company_name1=strtoupper(substr($row_c["recruiter_company_name"],0,1));
	$company_name="";
 if($company_name1!=$company_name1_old || $company_name1_old=='')
 {
  $title="<p><a id='".tep_db_output($company_name1)."'>".tep_db_output($company_name1)."</a></p>";
  $link_array[]=$company_name1;
 }
 $email_id=$row_c["recruiter_email_address"];
 $query_string1=encode_string("recruiter_email=".$email_id."=mail");
 $company_name="<a href='#' onclick='search_company(\"".$query_string1."\")'>".tep_db_output($row_c['recruiter_company_name'])."</a> ";
	$job_company.="<p>".$company_name."</p>";
	$company_name1_old=$company_name1;
 $k++;
}
$job_company.="</form>";
/***************end of JOBS BY COMPANY************************/

//////////////////// LATEST JOBS STARTS ///////////////////
$now=date('Y-m-d H:i:s');
$table_names=JOB_TABLE." as j,".RECRUITER_LOGIN_TABLE.' as rl,'.RECRUITER_TABLE.' as r';
$whereClause="j.recruiter_id=rl.recruiter_id and rl.recruiter_id=r.recruiter_id and rl.recruiter_status='Yes'and j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00') ";//
$field_names="j.job_id, j.job_title,j.job_location,j.job_short_description,j.inserted,r.recruiter_logo,r.recruiter_company_name,job_country_id";
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
	if(strlen($row['job_title']) > 20)
  $name_short=	substr($row['job_title'],0,100).'..';
 else
  $name_short=	substr($row['job_title'],0,20);
 $title='<a href="'.tep_href_link($ide.'/'.$title_format.'.html').'" target="_blank">'.$name_short.'</a>
 <div class="float-right for-mobile"><a class="btn btn-sm theme10-btn-orange" href="'.tep_href_link($ide.'/'.$title_format.'.html').'" target="_blank">Apply Now</a></div>';
 if(strlen($row['recruiter_company_name']) > 20)
  $company_name_short=	substr($row['recruiter_company_name'],0,15).'..';
 else
  $company_name_short=	substr($row['recruiter_company_name'],0,20);
	$company=$company_name_short;

/////logo
 $recruiter_logo='';
 $company_logo=$row['recruiter_logo'];
 if(tep_not_null($company_logo) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_LOGO.$company_logo))
     $recruiter_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$company_logo."&size=150",'','','','class="img-fluid img-thumbnail mini-profile-img theme10-mini-profile-img img-hover float-left mr-3 mobile-margin-bottom"');
 else
	$recruiter_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_IMG."nologo.jpg&size=150",'','','','class="img-fluid img-thumbnail mini-profile-img theme10-mini-profile-img img-hover float-left mr-3 mobile-margin-bottom"');

///////////////
$description=(strlen($row['job_short_description'])>70?substr($row['job_short_description'],0,65).'..':$row['job_short_description']);

///location
 $location=tep_db_output($row['job_location']);
 $country=get_name_from_table(COUNTRIES_TABLE, 'country_name', 'id',tep_db_output($row['job_country_id']));
 $company_address=tep_not_null($location)?"$location, $country":"$country";
/////
 $template->assign_block_vars('latest_jobs', array(
                              'title'    => $title,
                              'location'    => $company_address,
 						      'logo'	 =>$recruiter_logo,
                             'company'    =>$row['recruiter_company_name'],
                              'summary'   => $description,
                              ));
 $count++;
}
//// LATEST JOB ENDS ////

/*************************codeing to display different form and save search link for login and non login users *********************/
if(check_login("jobseeker"))
{
	$save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT,($edit?'sID='.$save_search_id:''),'post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action1','save_search');
    $INFO_TEXT_ALERT_TEXT=$save_search.(($action1=='save_search')?'':"<a href='#' onclick='document.save_search.submit();' class='btn btn-sm theme10-btn-orange btn-right py-2' style='position: absolute;right: 14px;top: 0;'>Create Job Alert</a></form>");
}
else
{
	 $save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT_DIRECT,'','post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','new');
	 $INFO_TEXT_ALERT_TEXT=$save_search.''.tep_draw_input_field('TREF_job_alert_email', $TREF_job_alert_email,'class="form-control" placeholder="Email Address" ',false).''."<button type='submit' class='btn btn-sm theme10-btn-orange btn-right py-2' style='position: absolute;right: 14px;top: 0;'>Create Job Alert</button></form>";
}

/**********************************************************************************************************************************/
/////////////////////////////////////////////////////////////////


$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>INFO_TEXT_ALL_CATEGORIES));
$default_country = DEFAULT_COUNTRY_ID;
$template->assign_vars(array(
 'ALL_JOBS'=>tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').'<button class="btn btn-text" type="submit">All Jobs</button></form>',
'JOB_CATEGORY'=>$job_category,
 'ALL_CATEGORIES'=>'<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'" type="button">All Categories</a>',
'JOB_COMPANY'=> $job_company,
 'ALL_LOCATION'=>'<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_LOCATION).'">All Locations</a>',
 'ALL_COMPANY'=>'<a href="'.tep_href_link(FILENAME_JOBSEEKER_COMPANY_PROFILE).'">All Companies</a>',
'SEARCH_JOBS'=>'<button class="btn btn-lg theme10-btn-purple px-4" onclick="location.href=\''.tep_href_link(FILENAME_JOB_SEARCH).'\'"" type="button">See our curated jobs</button>',
'JOBSEEKER_REGISTER'=>'<button class="btn theme10-btn-purple btn-block" onclick="location.href=\''.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'\'"" type="button">Register</button>',
'RECRUITER_REGISTER'=>'<button class="btn theme10-btn-purple btn-block" onclick="location.href=\''.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'\'"" type="button">Register</button>',
'HOME_CONTACT'=>'<button class="btn theme10-btn-purple btn-block" onclick="location.href=\''.tep_href_link(FILENAME_CONTACT_US).'\'"" type="button">Contact Us</button>',
'CREATE_ALERT'=>$INFO_TEXT_ALERT_TEXT,


'RIGHT_BANNER'=>$home_right_banner,
 'JOB_CATEGORY'              => $job_category,
 'LEFT_BOX_WIDTH'     =>'',
 'RIGHT_BOX_WIDTH'    =>RIGHT_BOX_WIDTH1,
 'RIGHT_HTML'         =>RIGHT_HTML,
 'LEFT_HTML'=>'',
 'update_message'=>$messageStack->output()));
?>