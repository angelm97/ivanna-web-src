<?php
if($_SESSION['language']=='spanish')
  include_once(dirname(__FILE__).'/language/home_spanish.php');
elseif($_SESSION['language']=='english')
  include_once(dirname(__FILE__).'/language/home_english.php');

#######################BEGIN FEATURED BANNER################################
$home_right_banner=banner_display("7",10,300,'class="img-fluid img-thumbnail theme5-featured-img text-center m-3 mobile-margin-bottom"');
for($i=0;$i<count($home_right_banner);$i=$i+5)
{
	$template->assign_block_vars('banner',array(
												'banner1'=>$home_right_banner[$i],
												'banner2'=>$home_right_banner[$i+1],
												'banner3'=>$home_right_banner[$i+2],
												'banner4'=>$home_right_banner[$i+3],
												'banner5'=>$home_right_banner[$i+4],
												));
}

#######################END FEATURED BANNER ################################

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$jobseeker_query = tep_db_query("select distinct jobseeker_id from " . JOBSEEKER_LOGIN_TABLE );
$no_of_jobseekers= tep_db_num_rows($jobseeker_query);
$jobs_query = tep_db_query("select distinct job_id from " . JOB_TABLE );
$no_of_jobs= tep_db_num_rows($jobs_query);
$recruiter_query = tep_db_query("select distinct recruiter_id from " . RECRUITER_LOGIN_TABLE );
$no_of_recruiters= tep_db_num_rows($recruiter_query);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
$field_names="j.job_id, j.job_title, j.job_type, j.job_salary, j.job_location,j.job_short_description,j.inserted, r.recruiter_company_name,r.recruiter_logo,job_country_id";
$order_by_field_name = "j.inserted";
$query = "select $field_names from $table_names where $whereClause order by $order_by_field_name DESC limit 0,10";

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

 ///logo
$comp_logo='';
if(tep_not_null($row["recruiter_logo"]) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_LOGO.$row["recruiter_logo"]))
    $comp_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_LOGO.$row["recruiter_logo"]."&size=50",'','','','');
  else
    $comp_logo=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_IMG."nologo.jpg&size=50",'','','','');
  ///////////

  ///job type
	$row_type=getAnyTableWhereData(JOB_TYPE_TABLE,"id='".$row['job_type']."'",'type_name');
	//echo $row_type['type_name'];
	if ($row_type['type_name'])
		 //  $jobtype=' <a href="'.tep_href_link($ide.'/'.$title_format.'.html').'" target="_blank">'.$row_type['type_name'].'</a>';
		 $jobtype='<span class="'.$row_type['type_name'].'">'.$row_type['type_name'].'</span>';
	else
			$jobtype='<span class="Full-time">Full time</span>';//'<span class="not-mention"> NOT MENTIONED </span>';

  //////

///date
if ($row['inserted']==$now)
	$idate='TODAY';
elseif ($row['inserted']<$now)
	{
		$secs= strtotime($now) - strtotime($row['inserted']);
		$diff = floor($secs / 86400);
		$idate=$diff." DAYS AGO";

	}
	else{
		$idate=$row['inserted'];}

//////
/*  if(strlen($row['recruiter_company_name']) > 20)
  $company_name_short=	substr($row['recruiter_company_name'],0,15).'..';
 else
  $company_name_short=	substr($row['recruiter_company_name'],0,20);
*/
	$company=$row['recruiter_company_name'];

/*if(strlen($row['job_title']) > 20)
  $name_short=	substr($row['job_title'],0,15).'..';
 else
  $name_short=	substr($row['job_title'],0,20);
*/
 $title=' <a class="d-block theme5-jobtitle" href="'.tep_href_link($ide.'/'.$title_format.'.html').'" target="_blank">'.$row['job_title'].'</a>';
//echo $now."<br>".$row['inserted']."<br>".$idate;
 $template->assign_block_vars('latest_jobs', array(
                              'title'    => $title,
                              'location'    => tep_db_output($row['job_location']),
                              'company'=> $company,
							  'clogo'=>$comp_logo,
							  'jobtype'=>$jobtype,
							  'jobdate'=>$idate,
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
while($article = tep_db_fetch_array($result1))
{
 $ide=$article['id'];
	if(strlen($article['title']) > 20)
  $article_name_short=	substr($article['title'],0,15).'..';
 else
  $article_name_short=	substr($article['title'],0,20);
 $title='<a href="article_'.$ide.'.html"  target="_blank">'.$article['title'].'</a>';
$read_more='<button class="btn btn-sm btn6-theme p-width buttonauto" onclick="location.href=\'article_'.$ide.'.html\'" type="submit">read more</button>';
  $article_image='';
  if(tep_not_null($article["article_photo"]) && is_file(PATH_TO_MAIN_PHYSICAL.PATH_TO_ARTICLE_PHOTO.$article["article_photo"]))
    $article_image='<a href="article_'.$ide.'.html"  target="_blank">'.tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_ARTICLE_PHOTO.$article["article_photo"]."&size=300",'','','','class="card-img-top img-hover rounded"').'</a>';
  else
    $article_image='<a href="article_'.$ide.'.html" target="_blank">'.tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_ARTICLE_PHOTO."blank_com.gif",'','','','class="card-img-top img-hover rounded"').'</a>';
 	$description=((strlen($article['short_description'])<120)?$article['short_description']:substr($article['short_description'],0,100)."..");
//$MORE='<a href="article_'.$ide.'.html"  target="_blank"><span class="new_style13">...<u>more&gt;&gt;</u></span></a>';
$articles1.='<div class="col-lg-4 col-md-12"><div class="card mb-3">  '.$article_image.'  <div class="card-body">    <h5 class="card-title fontt">'. $title.'</h5>    <p class="card-text font30">'.tep_db_output($description).'</p>    '.$read_more.'  </div></div></div>';
$count++;
}
//// CAREER TOOLS ENDS ////

/*************************codeing to display different form and save search link for login and non login users *********************/
if(check_login("jobseeker"))
{
	$save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT,($edit?'sID='.$save_search_id:''),'post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action1','save_search');
    $INFO_TEXT_ALERT_TEXT=$save_search.(($action1=='save_search')?'':"<a href='#' onclick='document.save_search.submit();' class='btn btn-sm btn-info btn-block py-2 mt-2'>Crear alertas de trabajos</a></form>");
}
else
{
	 $save_search= tep_draw_form('save_search', FILENAME_JOB_ALERT_AGENT_DIRECT,'','post','onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','new');
	 $INFO_TEXT_ALERT_TEXT=$save_search.''.tep_draw_input_field('TREF_job_alert_email', $TREF_job_alert_email,'class="form-control form-lg-theme6 " placeholder="Ingresa tu correo electrónico" style="float: left;" ',false).''."<div style='float: right;margin:-46px 0 0 88px;' class='input-group-append'><button type='submit' class='btn btn-lg btn-danger-theme6 py-2 px-4 text-white' style='margin:-2px 0 0 0'>¡Quiero recibirlas!</button></form></div>";
}

if ($_SESSION['sess_recruiterid']) {
	tep_db_query("delete from ". 'email_confirmation' ." where recruiter_id='". $_SESSION['sess_recruiterid'] ."'");
}

if ($_SESSION['sess_jobseekerid']) {
	tep_db_query("delete from ". 'email_confirmation_jobseeker' ." where jobseeker_id='". $_SESSION['sess_jobseekerid'] ."'");
}



/**********************************************************************************************************************************/
///////////////////////////////////////////////////////////

$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>INFO_TEXT_ALL_CATEGORIES));
$default_country = DEFAULT_COUNTRY_ID;
$template->assign_vars(array(
'JOB_CATEGORY'=>$job_category,
'ARTICLE_HOME'=>$articles1,
 'ALL_JOBS'=>tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').'<button class="btn btn-sm btn6-theme"  type="submit">See all jobs</button></form>',
 'ALL_ARTICLES'=> '<a class="btn btn-sm btn6-theme" href="'.tep_href_link(FILENAME_ARTICLE).'" type="button">All Articles</a>',
 'LEFT_BOX_WIDTH'=> '',
'EMP_GET_STARTED'=>'<button class="btn btn-sm btn6-theme" onclick="location.href=\''.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'\'" type="button">GET STARTED</button>',

'JOBSEEKERS'=>$no_of_jobseekers,
'RECRUITERS'=>$no_of_recruiters,
'JOBS'=>$no_of_jobs,

'ALL_CATEGORY'=>'<button class="btn btn-sm btn6-theme text-center" onclick="location.href=\''.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'\'" type="submit">See All Categories</button>',
'CREATE_ALERT'=>$INFO_TEXT_ALERT_TEXT,

 'RIGHT_BOX_WIDTH'=> RIGHT_BOX_WIDTH1,
 'RIGHT_HTML'=> RIGHT_HTML,
 'LEFT_HTML'=> '',
 'update_message'=> $messageStack->output(),
		));
	?>
