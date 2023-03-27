<?php
if($_SESSION['language']=='english')
  include_once(dirname(__FILE__).'/language/home_english.php');


#################FEATURED EMPLOYER############################
$feat_emp=banner_display("7",12,130,'class="img-thumbnail img-fluid img-hover mb-3 theme1-featured-logo"');
for($i=0;$i<count($feat_emp);$i++)
{
  $template->assign_block_vars('featured', array(
                                'employer'=>$feat_emp[$i],
                              ));
}
/////////// FEATURED EMPLOYER END///////////////

#################JOB CATEGORY############################
$field_names="id,".TEXT_LANGUAGE."category_name";
$whereClause=" where sub_cat_id is null";
$query11 = "select $field_names from ".JOB_CATEGORY_TABLE." $whereClause  order by ".TEXT_LANGUAGE."category_name  asc limit 0,20";// . (int)MODULE_THEME_JOBSITE8_MAX_JOB_CATEORY;";
$result11=tep_db_query($query11);
$i=1;
$job_category="<div class='col-md-3'>
			<ul class='categories'>";
while($row11 = tep_db_fetch_array($result11))
{
 $ide=$row11["id"];
 $row11[TEXT_LANGUAGE.'category_name'];
 $job_category_form=tep_draw_form('job_category'.$i, FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
	$key=((strlen($row11[TEXT_LANGUAGE.'category_name'])<20)?$row11[TEXT_LANGUAGE.'category_name']:substr($row11[TEXT_LANGUAGE.'category_name'],0,15)."..");
	$key1=$row11[TEXT_LANGUAGE.'category_name'];
	$job_category.="<li><a href='".$ide.'/'.encode_category($key1)."-jobs.html"."'  title='".tep_db_output($key1)."' class='jobsite11'>".tep_db_output($key1)."</a></li>";
	if($i%5 == 0)
	{
   $job_category.="</ul></div><div class='col-md-3 for-mobile'><ul class='categories'>";
	}
$i++;
}
 $job_category.="</ul></div>";
/****************end of JOB CATEGORY******************/

#################JOB LOCATION############################
$field_names="z.zone_name,c.country_name,ct.continent_name ";
$whereClause=" where z.zone_country_id ='".DEFAULT_COUNTRY_ID."' ";
$query11 = "select $field_names from ".ZONES_TABLE."  as z  left outer join ".COUNTRIES_TABLE." as c on (z.zone_country_id =c.id) left outer join  ".CONTINENT_TABLE." as ct on (c.continent_id = ct.id ) $whereClause  order by zone_name  asc limit 0,15";//. (int) MODULE_THEME_SAMPLE12_MAX_JOB_LOCATION;
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

//////////////////// LATEST JOBS STARTS ///////////////////
$now=date('Y-m-d H:i:s');
$table_names=JOB_TABLE." as j,".RECRUITER_LOGIN_TABLE.' as rl,'.RECRUITER_TABLE.' as r';
$whereClause="j.recruiter_id=rl.recruiter_id and rl.recruiter_id=r.recruiter_id and rl.recruiter_status='Yes'and j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00') ";//
$field_names="j.job_id, j.job_title, j.job_salary, j.job_location,j.job_short_description,j.inserted, r.recruiter_company_name,job_country_id,r.recruiter_logo";
$order_by_field_name = "j.inserted";
// $query = "select $field_names from $table_names where $whereClause order by rand() DESC limit 0,6" ;// " . (int) MODULE_THEME_JOBSITE12_MAX_LATEST_JOB;
$query = "select $field_names from $table_names where $whereClause order by $order_by_field_name DESC limit 0,8" ;// " . (int) MODULE_THEME_JOBSITE12_MAX_LATEST_JOB;

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
     $recruiter_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$company_logo."&size=150",'','','','class="featured-logo thumbnail img-responsive img-hover"');
else
     $recruiter_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_IMG."nologo.jpg"."&size=80",'','','','class="featured-logo thumbnail img-responsive img-hover"');


///////////////
$description=(strlen($row['job_short_description'])>80?substr($row['job_short_description'],0,75).'..':$row['job_short_description']);
if(strlen($row['job_title']) > 30)
  $name_short=	substr($row['job_title'],0,25).'..';
 else
  $name_short=	substr($row['job_title'],0,30);
 $title=' <a href="'.tep_href_link($ide.'/'.$title_format.'.html').'" target="_blank">'.$name_short.'</a>';
 $template->assign_block_vars('latest_jobs', array(
                              'title'    => $title,
                              'location' => tep_db_output($row['job_location']),
						      'logo'	 =>$recruiter_logo,
                              'summary'   => $description,
							  'company'    =>$row['recruiter_company_name'],
                              ));
 $count++;
}
//// LATEST JOB ENDS ////

//////////////////// CAREER TOOLS STARTS ///////////////////
$now=date("Y-m-d H:i:s");
$query = "select a.id,a.title,a.short_description,a.article_photo  from ".ARTICLE_TABLE." as a  where a.show_date <='$now' and a.is_show='Yes'  order by rand() limit 0,3";
//echo "<br>$query";//exit;
$result1=tep_db_query($query);
$x=tep_db_num_rows($result1);
$count=1;
$articles1='';
$articles1.='';
while($article = tep_db_fetch_array($result1))
{
 $ide=$article['id'];
	if(strlen($article['title']) > 20)
  $article_name_short=	substr($article['title'],0,15).'..';
 else
  $article_name_short=	substr($article['title'],0,20);
 $title='<a href="article_'.$ide.'.html"  target="_blank">'.$article_name_short.'</a>';
  $article_image='';
  if(tep_not_null($article["article_photo"]) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_ARTICLE_PHOTO.$article["article_photo"]))
    $article_image='<a href="article_'.$ide.'.html"  target="_blank">'.tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_ARTICLE_PHOTO.$article["article_photo"]."&size=400",'','','','class="img-fluid img-hover"').'</a>';
  else
    $article_image='<a href="article_'.$ide.'.html" target="_blank">'.tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_ARTICLE_PHOTO."blank_com.gif",'','','','class="img-fluid img-hover"').'</a>';
 	$description=((strlen($article['short_description'])<90)?$article['short_description']:substr($article['short_description'],0,75)."..");
//$MORE='<a href="article_'.$ide.'.html"  target="_blank"><span class="new_style13">...<u>more&gt;&gt;</u></span></a>';
$articles1.='


<div class="col-md-4 mb-3">
<div class="card card-theme1">
  '.$article_image.'
  <div class="card-body">
	<h5 class="card-title">'. $title.'</h5>
    <p class="card-text">'.tep_db_output($description).''.$MORE.'</p>
   </div>
</div>
</div>
';

$count++;
}
//// CAREER TOOLS ENDS ////

/*************************codeing to display different form and save search link for login and non login users *********************/
if(check_login("jobseeker"))
{
	$save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT,($edit?'sID='.$save_search_id:''),'post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action1','save_search');
    $INFO_TEXT_ALERT_TEXT=$save_search.(($action1=='save_search')?'':"<a href='#' onclick='document.save_search.submit();' class='btn btn-sm btn-info btn-block py-2 mt-2'>Create Job Alert</a></form>");
}
else
{
	 $save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT_DIRECT,'','post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','new');
	 $INFO_TEXT_ALERT_TEXT=$save_search.''.tep_draw_input_field('TREF_job_alert_email', $TREF_job_alert_email,'class="form-control form-control-lg input-group-theme1 no-radius" placeholder="Email Address" ',false).''."<div class='input-group-append alrt-btn'><button type='submit' class='btn btn-lg btn-theme1 py-2 no-radius' style='height: 53px;'>GO</button></div></form>";
}



/**********************************************************************************************************************************/


$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>INFO_TEXT_ALL_CATEGORIES));
$default_country = DEFAULT_COUNTRY_ID;
$template->assign_vars(array(
'JOB_CATEGORY'=> $job_category,
'ARTICLE_HOME'=>$articles1,
'CONTACT_US'=>'<a href="'.tep_href_link(FILENAME_CONTACT_US).'">'.CONTACT_US.'</a>',

'HOME_RIGHT_BANNER'=>$home_right_banner,
'JOBSEEKER_SIGN_UP'=>(check_login('jobseeker')?'<button class="btn btn-outline-theme1" onclick="location.href=\''.tep_href_link(FILENAME_LOGOUT).'\'" type="submit">'.SIGN_OUT.'</button>':'<button class="btn btn-outline-theme1" onclick="location.href=\''.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'\'" type="submit">'.SIGN_UP.'</button>'),
'RECRUITER_SIGN_UP'=>(check_login('recruiter')?'<button class="btn btn-outline-theme1" onclick="location.href=\''.tep_href_link(FILENAME_LOGOUT).'\'" type="submit">'.SIGN_OUT.'</button>':'<button class="btn btn-outline-theme1" onclick="location.href=\''.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'\'" type="submit">'.SIGN_UP.'</button>'),
'ADVERTISER_SIGN_UP'=>'<button class="btn btn-outline-theme1" onclick="location.href=\''.tep_href_link(FILENAME_CONTACT_US).'\'" type="submit">Contact Us</button>',
'INFO_MESSAGE1'=>INFO_MESSAGE1,
'LATEST_JOBS'=>LATEST_JOBS,
'JOB_CATEGORY_TEXT'=>JOB_CATEGORY_TEXT,
'FEATURED_RECRUITERS'=>FEATURED_RECRUITERS,
'FEATURED_RECRUITERS_TEXT'=>FEATURED_RECRUITERS_TEXT,
'LATEST_ARTICLES'=>LATEST_ARTICLES,
'WELCOME_MESSAGE'=>WELCOME_MESSAGE,
'WELCOME_MESSAGE_TEXT'=>WELCOME_MESSAGE_TEXT,
'INFO_JOBSEEKER'=>INFO_JOBSEEKER,
'INFO_EMPLOYER'=>INFO_EMPLOYER,
'EMPLOYER_TEXT'=>EMPLOYER_TEXT,
'INFO_ADVERTISER'=>INFO_ADVERTISER,
'ADVERTISER_TEXT'=>ADVERTISER_TEXT,
'ABOUT_US_HEADING'=>ABOUT_US_HEADING,
'ABOUT_US_HEADING2'=>ABOUT_US_HEADING2,
'ABOUT_US_TEXT'=>ABOUT_US_TEXT,
'GET_EMAIL_TEXT'=>GET_EMAIL_TEXT,
'SUBMIT_RESUME_TEXT'=>SUBMIT_RESUME_TEXT,
 'LEFT_BOX_WIDTH'=> '',
 'ALL_JOBS'=>tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').'<button class="btn btn-outline-theme1" type="submit">'.ALL_JOBS.'</button></form>',
 'ALL_CATEGORY'=>'<button class="btn btn-outline-theme1" onclick="location.href=\''.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'\'" type="submit">'.ALL_CATEGORIES.'</button>',
 'ALL_RECRUITERS'=>'<button class="btn btn-outline-theme1" onclick="location.href=\''.tep_href_link(FILENAME_JOBSEEKER_COMPANY_PROFILE).'\'" type="submit">'.ALL_RECRUITERS.'</button>',
 'ALL_ARTICLES'=> '<button class="btn btn-outline-theme1" onclick="location.href=\''.tep_href_link(FILENAME_ARTICLE).'\'" type="submit">'.ALL_ARTICLES.'</button>',
'CREATE_ALERT'=>$INFO_TEXT_ALERT_TEXT,
 'RIGHT_BOX_WIDTH'=> RIGHT_BOX_WIDTH1,
 'RIGHT_HTML'=> RIGHT_HTML,
 'LEFT_HTML'=> '',
 'update_message'=> $messageStack->output(),
		));
	?>