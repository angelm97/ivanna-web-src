<?php
if($_SESSION['language']=='english')
  include_once(dirname(__FILE__).'/language/home_english.php');


#################FEATURED EMPLOYER############################
$featured_emp=banner_display("7",18,85," class='img-fluid img-thumbnail img-hover border mini-profile-img'");
$b1=$featured_emp[0];
$b2=$featured_emp[1];
$b3=$featured_emp[2];
$b4=$featured_emp[3];
$b5=$featured_emp[4];
$b6=$featured_emp[5];

for($i=6;$i<count($featured_emp);$i=$i+6)
{
  $template->assign_block_vars('banner', array(
                                'banner1'=>$featured_emp[$i],
								'banner2'=>$featured_emp[$i+1],
								'banner3'=>$featured_emp[$i+2],
								'banner4'=>$featured_emp[$i+3],
								'banner5'=>$featured_emp[$i+4],
								'banner6'=>$featured_emp[$i+5],
								));
}
/////////// FEATURED EMPLOYER END///////////////


#################JOB CATEGORY############################
$field_names="id,".TEXT_LANGUAGE."category_name";
$whereClause=" where sub_cat_id is null";
$query11 = "select $field_names from ".JOB_CATEGORY_TABLE." $whereClause  order by ".TEXT_LANGUAGE."category_name  asc limit 0,".(int) MODULE_THEME_THEME4_MAX_JOB_CATEORY;
$result11=tep_db_query($query11);
$i=1;
$job_category="<div class='row'><div class='col-md-4'>";
while($row11 = tep_db_fetch_array($result11))
{
 $ide=$row11["id"];
 $job_category_form=tep_draw_form('job_category'.$i, FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
 //$key=((strlen($row11['category_name'])<30)?$row11['category_name']:substr($row11['category_name'],0,27)."...");
	$key=((strlen($row11[TEXT_LANGUAGE.'category_name'])<30)?$row11[TEXT_LANGUAGE.'category_name']:substr($row11[TEXT_LANGUAGE.'category_name'],0,28)."..");
	$key1=$row11[TEXT_LANGUAGE.'category_name'];
	$job_category.="<p><a href='".$ide.'/'.encode_category($key1)."-jobs.html"."'  title='".tep_db_output($key1)."'>".tep_db_output($key1)."</a></p>";
	if($i%5 == 0)
	{
     $job_category.="</div>	 <div class='col-md-4 for-mobile'>";
	}
$i++;
}
$job_category.="</div></div>";
/****************end of JOB CATEGORY******************/

#################JOB LOCATION############################
$default_country_value=DEFAULT_COUNTRY_ID;
$field_name12="zone_id,".TEXT_LANGUAGE."zone_name";
$whereclause12="where zone_country_id=$default_country_value";
$query12="select $field_name12 from ".ZONES_TABLE." $whereclause12 order by ".TEXT_LANGUAGE."zone_name asc limit 0,40";//.(int) MODULE_THEME_THEME4_MAX_JOB_LOCATION;
$result12=tep_db_query($query12);
$j=1;
$job_location="<div class='row'><div class='col-md-4'>";
while($row12=tep_db_fetch_array($result12))
{
	$id12=$row12['zone_id'];
 $location_form=tep_draw_form('job_location'.$j, FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
	$key12=((strlen($row12[TEXT_LANGUAGE.'zone_name'])<23)?$row12[TEXT_LANGUAGE.'zone_name']:substr($row12[TEXT_LANGUAGE.'zone_name'],0,20)."...");
$key2=$row12[TEXT_LANGUAGE.'zone_name'];
	$job_location.="<p>".$location_form."<input type='hidden' name='state[]' value='".$row12['zone_name']."'><a href='#' title='".tep_db_output($key2)."' onclick='document.job_location".$j.".submit()'>".tep_db_output($key2)."</a></p></form>";
	if($j%5 == 0)
	{
  $job_location.="</div><div class='col-md-4'>";
	}
$j++;
}
$job_location.="</div></div>";
/****************end of JOB LOCATION******************/

/****************JOBS BY COMPANY*****************************/
$whereClause1="where rl.recruiter_status='Yes'";
$fields_c="recruiter_company_name,recruiter_email_address";
$query_c = "select $fields_c  from ".RECRUITER_TABLE." as r left join ".RECRUITER_LOGIN_TABLE." as rl on ( r.recruiter_id = rl.recruiter_id) $whereClause1 limit 0,40";
$result_c=tep_db_query($query_c);//echo "<br>$query";//exit;
$x=tep_db_num_rows($result_c);//echo $x;exit;
$k=1;
$company_name1_old="";
$company_form=tep_draw_form('company_search', FILENAME_JOBSEEKER_COMPANY_PROFILE,'','post').tep_draw_hidden_field('action','search').tep_draw_hidden_field('company_name','');
$job_company="<div class='col-md-4'>".$company_form."";
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
	if($k%5 == 0)
	{
  $job_company.="</div><div class='col-md-4'>";
	}
	$company_name1_old=$company_name1;
 $k++;
}
//$job_company.="<td align='right' colspan='4'><a href='".tep_href_link(FILENAME_JOBSEEKER_COMPANY_PROFILE)."' class='home_4'>".INFO_TEXT_HOME_MORE."&gt;&gt;</a></td></tr></form>";
$job_company.="</form></div>";
/***************end of JOBS BY COMPANY************************/



//////////////////// LATEST JOBS STARTS ///////////////////
$now=date('Y-m-d H:i:s');
$table_names=JOB_TABLE." as j,".RECRUITER_LOGIN_TABLE.' as rl,'.RECRUITER_TABLE.' as r';
$whereClause="j.recruiter_id=rl.recruiter_id and rl.recruiter_id=r.recruiter_id and rl.recruiter_status='Yes'and j.expired >='$now' and j.re_adv <='$now' and j.job_status='Yes' and ( j.deleted is NULL or j.deleted='0000-00-00 00:00:00') ";//
$field_names="j.job_id, j.job_title, j.job_salary, j.job_location,j.job_short_description,j.inserted, r.recruiter_company_name,job_country_id,r.recruiter_logo";
$order_by_field_name = "j.inserted";
$query = "select $field_names from $table_names where $whereClause order by $order_by_field_name limit 0,5";
// $query = "select $field_names from $table_names where $whereClause order by rand() limit 0,6" ;// " . (int) MODULE_THEME_JOBSITE12_MAX_LATEST_JOB;

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

///////////////
$description=(tep_not_null(strlen($row['job_short_description']))>100?substr($row['job_short_description'],0,98).'..':$row['job_short_description']);
if(strlen($row['job_title']) > 20)
  $name_short=	substr($row['job_title'],0,15).'..';
 else
  $name_short=	substr($row['job_title'],0,20);
 $title=' <a href="'.tep_href_link($ide.'/'.$title_format.'.html').'" target="_blank">'.$name_short.'</a>';
 $template->assign_block_vars('latest_jobs', array(
                              'title'    => $title,
                              'location' => tep_db_output($row['job_location']),
						      'logo'	 =>$recruiter_logo,
                              'summary'   => $description,
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
$articles1.='<table  border="0" cellspacing="0" cellpadding="0">
																		<tr valign="top">';
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
    $article_image='<a href="article_'.$ide.'.html"  target="_blank">'.tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_ARTICLE_PHOTO.$article["article_photo"]."&size=300",'','','','class="img-responsive img-portfolio img-hover"').'</a>';
  else
    $article_image='<a href="article_'.$ide.'.html" target="_blank">'.tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_ARTICLE_PHOTO."blank_com.gif",'','','','class="img-responsive img-portfolio img-hover"').'</a>';
 	$description=((strlen($article['short_description'])<120)?$article['short_description']:substr($article['short_description'],0,100)."..");
$MORE='<a href="article_'.$ide.'.html"  target="_blank"><span class="new_style13">...<u>more&gt;&gt;</u></span></a>';
$articles1.='<div class="col-md-4 col-sm-6" align="center">'.$article_image.'<br><p class="article-desc ">'.tep_db_output($description).''.$MORE.' </p></div>';
$count++;
}
//// CAREER TOOLS ENDS ////

/*************************codeing to display different form and save search link for login and non login users *********************/
if(check_login("jobseeker"))
{
	$save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT,($edit?'sID='.$save_search_id:''),'post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action1','save_search');
    $INFO_TEXT_ALERT_TEXT=$save_search.(($action1=='save_search')?'':"<a href='#' onclick='document.save_search.submit();' class='btn btn-sm theme4-btn-outline3 btn-block py-2 mt-2'>Create Job Alert</a></form>");
}
else
{
	 $save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT_DIRECT,'','post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','new');
	 $INFO_TEXT_ALERT_TEXT=$save_search.''.tep_draw_input_field('TREF_job_alert_email', $TREF_job_alert_email,'class="form-control" placeholder="Email Address" ',false).''."<button type='submit' class='btn btn-sm theme4-btn-outline3 btn-block py-2 mt-2'>Create Job Alert</button></form>";
}

/**********************************************************************************************************************************/


$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>INFO_TEXT_ALL_CATEGORIES));
$default_country = DEFAULT_COUNTRY_ID;
$template->assign_vars(array(

'JOB_CATEGORY'=> $job_category,
'JOB_LOCATION'=>$job_location,
'ARTICLE_HOME'=>$articles1,
'CONTACT_US'=>'<a href="'.tep_href_link(FILENAME_CONTACT_US).'">contact us</a>',
'JOB_COMPANY'=>$job_company,
'HOME_RIGHT_BANNER'=>$home_right_banner,
'JOBSEEKER_SIGN_UP'=>(check_login('jobseeker')?'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_LOGOUT).'\'" type="submit">Sign Out</button>':'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'\'" type="submit">Sign Up</button>'),
'RECRUITER_SIGN_UP'=>(check_login('recruiter')?'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_LOGOUT).'\'" type="submit">Sign Out</button>':'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'\'" type="submit">Sign Up</button>'),
'APPLICANT_TRACKING'=>'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_RECRUITER_SEARCH_APPLICANT).'\'" type="submit">Sign Up</button>',
 'LEFT_BOX_WIDTH'=> '',
 'ALL_JOBS'=>'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_JOB_SEARCH).'\'" type="submit">All Jobs</button>',
 'ALL_CATEGORY'=>'<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'\'" type="submit">All Categories</button>',
 'ALL_ARTICLES'=> '<button class="btn btn-lg btn-primary" onclick="location.href=\''.tep_href_link(FILENAME_ARTICLE).'\'" type="submit">All Articles</button>',
'B1'=>$b1,
'B2'=>$b2,
'B3'=>$b3,
'B4'=>$b4,
'B5'=>$b5,
'B6'=>$b6,
'REGISTER_CV'=>'<a class="btn theme4-btn-outline btn-sm" href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME1).'">Register Your CV</a>',
'START_RECRUITING'=>'<button type="button" class="btn btn-sm theme4-btn-outline" onclick="location.href=\''.tep_href_link(FILENAME_RECRUITER_POST_JOB).'\'">Start Recruiting</button>',
'CREATE_ALERT'=>$INFO_TEXT_ALERT_TEXT,
'JOBS_BY_CATEGORY'=>'<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'" class="btn btn-sm theme4-btn-outline mt-3" role="button">Jobs By Category</a>',
'JOBS_BY_LOCATION'=>'<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_LOCATION).'" class="btn btn-sm theme4-btn-outline mt-3" role="button">Jobs By Location</a>',
'RESUME_ALERT'=>'<a href="'.tep_href_link(FILENAME_JOB_ALERT_AGENT).'" class="btn btn-sm theme4-btn-outline mt-3" role="button">Resume Alert</a>',
'NEWSLETTER'=>'<a href="'.tep_href_link(FILENAME_LIST_OF_NEWSLETTERS).'" class="btn btn-sm theme4-btn-outline mt-3" role="button">Newsletter</a>',
 'RIGHT_BOX_WIDTH'=> RIGHT_BOX_WIDTH1,
 'RIGHT_HTML'=> RIGHT_HTML,
 'LEFT_HTML'=> '',
 'update_message'=> $messageStack->output(),
		));
	?>