<?
if(!((strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_INDEX)) || (strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_ABOUT_US)) || (strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_PRIVACY)) || (strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_TERMS)) || (strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_ARTICLE)) || (strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_SITE_MAP)) || (strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_CONTACT_US)) || (strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_INDUSTRY_RSS)) || (strtolower($_SERVER['PHP_SELF'])==("/".PATH_TO_MAIN.FILENAME_FAQ))))
{
  ////// Recruiter starts///////
  if(check_login('recruiter'))
  {
    $today=date("Y-m-d H:i:s");
    $no_of_save_resume=no_of_records(SAVE_RESUME_TABLE," recruiter_id ='".$_SESSION['sess_recruiterid']."'",'id');
    $no_of_save_search=no_of_records(SEARCH_RESUME_RESULT_TABLE," recruiter_id ='".$_SESSION['sess_recruiterid']."'",'id');
    $no_of_news_letters=no_of_records(NEWSLETTERS_HISTORY_TABLE," send_to ='recruiter'",'id');
    $no_of_active_job=no_of_records(JOB_TABLE," recruiter_id ='".$_SESSION['sess_recruiterid']."' and re_adv <= '".$today."' and expired >= '".$today."' and deleted is NULL",'job_id');
    $no_of_expired_job=no_of_records(JOB_TABLE," recruiter_id ='".$_SESSION['sess_recruiterid']."' and re_adv <= '".$today."' and expired <= '".$today."' and deleted is NULL",'job_id');
    $no_of_job=(int)no_of_records(JOB_TABLE," recruiter_id ='".$_SESSION['sess_recruiterid']."'",'job_id');
    $no_of_applicant=(int)no_of_records(APPLICATION_TABLE." as a  left outer join ".JOB_TABLE." as jb on (a.job_id=jb.job_id)"," jb.recruiter_id ='".$_SESSION['sess_recruiterid']."' ",'a.id');
    $no_of_selectd_applicant=(int)no_of_records(APPLICATION_TABLE." as a  left outer join ".JOB_TABLE." as jb on (a.job_id=jb.job_id)","a.applicant_select='Yes' and  jb.recruiter_id ='".$_SESSION['sess_recruiterid']."' ",'a.id');
    $no_of_contact=no_of_records(USER_CONTACT_TABLE,"user_id='".$_SESSION['sess_recruiterid']."' and user_type='recruiter'",'id');
    $no_of_user=no_of_records(RECRUITER_USERS_TABLE,"recruiter_id='".$_SESSION['sess_recruiterid']."' ",'id');
    /////////////////////
    $row_contact=getAnyTableWhereData(RECRUITER_LOGIN_TABLE." as rl left join  ".RECRUITER_TABLE." as r on (rl.recruiter_id=r.recruiter_id) left join  ".COUNTRIES_TABLE." as c on (r.recruiter_country_id=c.id) left join ".ZONES_TABLE." as z on(r.recruiter_state_id=z.zone_id or z.zone_id is NULL)"," rl.recruiter_id ='".$_SESSION['sess_recruiterid']."'","r.recruiter_first_name,r.recruiter_last_name,r.recruiter_logo,r.recruiter_company_name,r.recruiter_address1,r.recruiter_address2,c.country_name,if(r.recruiter_state_id,z.zone_name,r.recruiter_state) as location,r.recruiter_state_id,r.recruiter_state,r.recruiter_city,r.recruiter_zip,r.recruiter_telephone,r.fax,r.recruiter_url,rl.recruiter_email_address");

    $post_a_job     = '<a href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'" title="'.INFO_TEXT_POST_A_JOB.'">'.INFO_TEXT_POST_A_JOB.'</a>';
    $list_of_jos    = '<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_JOBS).'" title="'.INFO_TEXT_L_LIST_OF_JOBS.'" >'.INFO_TEXT_L_LIST_OF_JOBS.'</a>';
    $active_jobs    = '<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_JOBS).'" title="'.INFO_TEXT_L_ACTIVE_JOBS.'" >'.INFO_TEXT_L_ACTIVE_JOBS.'</a> '.(($no_of_active_job>0)?'('.$no_of_active_job.')':'');
    $expired_jobs   = '<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_JOBS,'j_status=expired').'" title="'.INFO_TEXT_L_EXPIRED_JOBS.'" >'.INFO_TEXT_L_EXPIRED_JOBS.'</a> '.(($no_of_expired_job>0)?'('.$no_of_expired_job.')':'');
    $import_multiple_jobs = '<a href="'.tep_href_link(FILENAME_RECRUITER_IMPORT_JOBS).'" title="'.INFO_TEXT_L_IMPORT_MULTIPLE_JOBS.'" >'.INFO_TEXT_L_IMPORT_MULTIPLE_JOBS.'</a> ';

    $search_resumes = '<a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'" title="'.INFO_TEXT_L_SEARCH_RESUMES.'" >'.INFO_TEXT_L_SEARCH_RESUMES.'</a>';
    $search_applicant = '<a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_APPLICANT).'" title="'.INFO_TEXT_L_SEARCH_APPLICANT.'" >'.INFO_TEXT_L_SEARCH_APPLICANT.'</a>';
    $resume_search_agents = '<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_RESUME_SEARCH_AGENTS).'" title="'.INFO_TEXT_L_RESUME_SEARCH_AGENTS.'" >'.INFO_TEXT_L_RESUME_SEARCH_AGENTS.'</a> '.(($no_of_save_search>0)?'('.$no_of_save_search.')':'');
    $my_saved_resumes     = '<a href="'.tep_href_link(FILENAME_RECRUITER_SAVE_RESUME).'" title="'.INFO_TEXT_MY_SAVED_RESUMES.'" >'.INFO_TEXT_MY_SAVED_RESUMES.'</a> '.(($no_of_save_resume>0)?'('.$no_of_save_resume .')':'');
    $edit_profile  = '<a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'" title="'.INFO_TEXT_L_EDIT_PROFILE.'" >'.INFO_TEXT_L_EDIT_PROFILE.'</a>';
    $company_description = '<a href="'.tep_href_link(FILENAME_RECRUITER_COMPANY_DESCRIPTION).'" title="'.INFO_TEXT_L_COMPANY_DESCRIPTION.'" >'.INFO_TEXT_L_COMPANY_DESCRIPTION.'</a>';
    $order_history   = '<a href="'.tep_href_link(FILENAME_RECRUITER_ACCOUNT_HISTORY_INFO).'" title="'.INFO_TEXT_L_ORDER_HISTORY.'" >'.INFO_TEXT_L_ORDER_HISTORY.'</a>';
    $manage_users    = '<a href="'.tep_href_link(FILENAME_RECRUITER_LIST_OF_USERS).'" title="'.INFO_TEXT_MANAGE_USERS.'" >'.INFO_TEXT_MANAGE_USERS.'</a> '.(($no_of_user>0)?'('.$no_of_user.')':'');
    $contact_list    = '<a href="'.tep_href_link(FILENAME_RECRUITER_CONTACT_LIST).'" title="'.INFO_TEXT_L_CONTACT_LIST.'" >'.INFO_TEXT_L_CONTACT_LIST.'</a>'.(($no_of_contact>0)?'('.$no_of_contact.')':'');
    $news_letter     = '<a href="'.tep_href_link(FILENAME_LIST_OF_NEWSLETTERS).'" title="'.INFO_TEXT_L_NEWS_LETTER.'" >'.INFO_TEXT_L_NEWS_LETTER.'</a> '.(($no_of_news_letters>0)?'('.$no_of_news_letters.')':'');
    $change_password = '<a href="'.tep_href_link(FILENAME_RECRUITER_CHANGE_PASSWORD).'" title="'.INFO_TEXT_L_CHANGE_PASSWORD.'" >'.INFO_TEXT_L_CHANGE_PASSWORD.'</a>';
    $log_out         = '<a href="'.tep_href_link(FILENAME_LOGOUT).'" title="'.INFO_TEXT_L_LOG_OUT.'" >'.INFO_TEXT_L_LOG_OUT.'</a>';
    $rate_card       = '<a href="'.tep_href_link(FILENAME_RECRUITER_RATES).'" title="'.INFO_TEXT_RATE_CARD.'" >'.INFO_TEXT_RATE_CARD.'</a>';

    $total_jobs_posted = INFO_TEXT_TOTAL_JOBS_POSTED." : ".$no_of_job;
    $total_applicants  = INFO_TEXT_TOTAL_APPLICANTS." : ".$no_of_applicant;
    $selected_applicant = INFO_TEXT_L_SELECTED_APPLICANT." : ".$no_of_selectd_applicant;
  }
  ////// Recruiter ends///////


  if(check_login('recruiter'))
  define('LEFT_HTML','

  <div class="card card-custom-left-nav mb-3">
  <div class="card-header card-header-custom-left-nav alert-primary">
  <h6>'.INFO_TEXT_L_JOB_POSTING.'
  </h6></div>
  <div class="card-body card-body-custom-left-nav">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$post_a_job.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$list_of_jos.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$active_jobs.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$expired_jobs.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$import_multiple_jobs.'</div>
  </div>
  </div>

  <div class="card card-custom-left-nav mb-3">
  <div class="card-header card-header-custom-left-nav alert-primary">
  '.INFO_TEXT_L_MY_ACCOUNT.'
  </div>
  <div class="card-body card-body-custom-left-nav">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$edit_profile.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$company_description.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$order_history.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$manage_users.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$contact_list.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$news_letter.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$change_password.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$log_out.'</div>
  </div>
  </div>

  <div class="card card-custom-left-nav mb-3">
  <div class="card-header card-header-custom-left-nav alert-primary">
  '.INFO_TEXT_SEARCH_RESUME.'
  </div>
  <div class="card-body card-body-custom-left-nav">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$search_resumes.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$search_applicant.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$resume_search_agents.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$my_saved_resumes.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$rate_card.'</div>
  </div>
  </div>


  <div class="card card-custom-left-nav mb-3">
  <div class="card-header card-header-custom-left-nav alert-primary">
  '.INFO_TEXT_L_CURRENT_STATUS.'
  </div>
  <div class="card-body card-body-custom-left-nav">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$total_jobs_posted.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$total_applicants.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$selected_applicant.'</div>
  </div>
  </div>
  ');
  else
  define('LEFT_HTML','');

  //////Jobseeker starts///////
  if(check_login('jobseeker'))
  {
    $no_of_applications=no_of_records(APPLY_TABLE.' as a, '.JOB_TABLE." as j","a.job_id=j.job_id and a.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and jobseeker_apply_status='active'",'a.id');
    $no_of_cover_letters=no_of_records(JOBSEEKER_LOGIN_TABLE . " as jl, ".COVER_LETTER_TABLE." as c","jl.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and jl.jobseeker_id=c.jobseeker_id",'c.cover_letter_id');
    $no_of_saved_searches=no_of_records(SEARCH_JOB_RESULT_TABLE . " as sr ","sr.jobseeker_id='".$_SESSION['sess_jobseekerid']."'",'sr.id');
    $no_of_saved_jobs=no_of_records(SAVE_JOB_TABLE . " as s, ".JOB_TABLE." as j, ".RECRUITER_TABLE." as r, ".RECRUITER_LOGIN_TABLE." as rl","s.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and s.job_id=j.job_id and j.recruiter_id=rl.recruiter_id and j.recruiter_id=r.recruiter_id and rl.recruiter_status='Yes'",'s.id');
    $no_of_resumes=no_of_records(JOBSEEKER_RESUME1_TABLE . " as j1","j1.jobseeker_id='".$_SESSION['sess_jobseekerid']."'",'j1.jobseeker_id');
    $no_of_unread_mail=no_of_records(APPLICANT_INTERACTION_TABLE." as ai left join ".APPLICATION_TABLE."  as a on (a.id=ai.application_id) ","a.jobseeker_id='".$_SESSION['sess_jobseekerid']."' and ai.receiver_mail_status='active'  and ai.user_see ='No' and  sender_user='recruiter'",'ai.id');
    $no_of_contact=no_of_records(USER_CONTACT_TABLE,"user_id='".$_SESSION['sess_jobseekerid']."' and user_type='jobseeker'",'id');
    $no_of_companies=no_of_records(RECRUITER_LOGIN_TABLE . " as r1","r1.recruiter_id");


    $table_names1=JOBSEEKER_RESUME1_TABLE." as jr1 ";
    $whereClause1.="jr1.jobseeker_id='".$_SESSION['sess_jobseekerid']."' order by jr1.inserted desc";
    $field_names1="jr1.resume_id,jr1.resume_title,jr1.inserted,jr1.updated,jr1.availability_date,jr1.search_status ";//;,sum(rs.viewed) as viewed";

    $resume_query_raw="select $field_names1 from $table_names1 where $whereClause1";
    $resume_query = tep_db_query($resume_query_raw);
    $resume_query_numrows=tep_db_num_rows($resume_query);
    $available_status='';
    if($resume_query_numrows > 0)
    {
      while ($resume = tep_db_fetch_array($resume_query))
      {
        if(tep_not_null($resume['availability_date']))
        {
          $available_status='<a href="' . tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL, 'action=available_inactive') . '">' . tep_image(PATH_TO_IMAGE.'icon_status_red_light.gif', INFO_TEXT_L_STATUS_NOT_AVAILABLE, 15, 9) . '</a>&nbsp;' . tep_image(PATH_TO_IMAGE.'icon_status_green.gif', INFO_TEXT_L_STATUS_AVAILABLE, 15, 9);
        }
        else
        {
          $available_status=tep_image(PATH_TO_IMAGE.'icon_status_red.gif', INFO_TEXT_L_STATUS_NOT_AVAILABLITY, 15, 9) . '&nbsp;<a href="' . tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL, 'action=available_active') . '">' . tep_image(PATH_TO_IMAGE.'icon_status_green_light.gif', INFO_TEXT_L_STATUS_AVAILABLITY, 15, 9) . '</a>';
        break;
      }
    }
  }

  $action=((isset($_GET['action']) && ($_GET['action']=='available_active' || $_GET['action']=='available_inactive'))?$_GET['action']:'');
  {
    $action = $_GET['action'] ;
  }
  if(tep_not_null($action))
  {
    switch($action)
    {
      case 'available_active':
        case 'available_inactive':
          if($action=='available_active')
          {
            tep_db_query("update ".JOBSEEKER_RESUME1_TABLE." set availability_date=now() where jobseeker_id='".$_SESSION['sess_jobseekerid']."'");
            $messageStack->add_session(MESSAGE_SUCCESS_UPDATED_AVAILABLE, 'success');
          }
          else
          {
            tep_db_query("update ".JOBSEEKER_RESUME1_TABLE." set availability_date=NULL where jobseeker_id='".$_SESSION['sess_jobseekerid']."'");
            $messageStack->add_session(MESSAGE_SUCCESS_UPDATED_NOT_AVAILABLE, 'success');
          }
          tep_redirect(FILENAME_JOBSEEKER_CONTROL_PANEL);
        break;
      }
    }
    $row_contact1=getAnyTableWhereData(JOBSEEKER_LOGIN_TABLE." as jl left join  ".JOBSEEKER_TABLE." as j on (jl.jobseeker_id=j.jobseeker_id) left join  ".COUNTRIES_TABLE." as c on (j.jobseeker_country_id=c.id) left join ".ZONES_TABLE." as z on(j.jobseeker_state_id=z.zone_id or z.zone_id is NULL)"," jl.jobseeker_id ='".$_SESSION['sess_jobseekerid']."'","j.jobseeker_first_name,j.jobseeker_last_name,j.jobseeker_address1,j.jobseeker_address2,c.country_name,if(j.jobseeker_state_id,z.zone_name,j.jobseeker_state) as location,j.jobseeker_city,j.jobseeker_zip,j.jobseeker_phone,j.jobseeker_mobile,jl.jobseeker_email_address");

    $add_resume= '<a href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME1).'" title="'.INFO_TEXT_L_ADD_RESUMES.'">'.INFO_TEXT_L_ADD_RESUMES.'</a>';
    $my_resumes= '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_RESUMES).'" title="'.INFO_TEXT_MY_RESUMES.'">'.INFO_TEXT_MY_RESUMES.'</a>'.(($no_of_resumes>0)?"(".$no_of_resumes.")":" ");
    $set_status= '<a href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL, 'action=available_active').'" title="'.INFO_TEXT_SET_STATUS_AS_AVAILALE_NOW.'">'.INFO_TEXT_SET_STATUS_AS_AVAILALE_NOW.'</a> '.$available_status.'';

    $my_saved_jobs = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_SAVED_JOBS).'" title="'.INFO_TEXT_MY_SAVED_JOBS.'">'.INFO_TEXT_MY_SAVED_JOBS.'</a>'.(($no_of_saved_jobs>0)?'('.$no_of_saved_jobs.')':'');
    $my_applications= '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_APPLICATIONS).'" title="'.INFO_TEXT_MY_APPLICATIONS.'">'.INFO_TEXT_MY_APPLICATIONS.'</a>'.(($no_of_applications>0)?"(".$no_of_applications.")":"");
    $response_from_employer = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_MAILS).'" title="'.INFO_TEXT_RESPONSE_FROM_EMPLOYER.'">'.INFO_TEXT_RESPONSE_FROM_EMPLOYER.'</a>'.(($no_of_unread_mail>0)?"(".$no_of_unread_mail.")":"");

    $edit_personal_details  = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'" title="'.INFO_TEXT_L_EDIT_PERSONAL_DETAILS.'">'.INFO_TEXT_L_EDIT_PERSONAL_DETAILS.' </a>';
    $my_cover_letters= '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_COVER_LETTERS).'" title="'.INFO_TEXT_MY_COVER_LETTERS.'">'.INFO_TEXT_MY_COVER_LETTERS.'</a>'.(($no_of_cover_letters>0)?"(".$no_of_cover_letters.")":"");
    $change_password = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_CHANGE_PASSWORD).'" title="'.INFO_TEXT_L_CHANGE_PASSWORD.'">'.INFO_TEXT_L_CHANGE_PASSWORD.'</a>';
    $newsletters = '<a href="'.tep_href_link(FILENAME_LIST_OF_NEWSLETTERS).'" title="'.INFO_TEXT_NEWSLETTERS.'">'.INFO_TEXT_NEWSLETTERS.'</a>';
    $contact_list = '<a href="'.tep_href_link(FILENAME_RECRUITER_CONTACT_LIST).'" title="'.INFO_TEXT_L_CONTACT_LIST.'">'.INFO_TEXT_L_CONTACT_LIST.'</a>'.(($no_of_contact>0)?"(".$no_of_contact.")":"");
    $video_resume = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_RESUMES).'"  title="'.INFO_TEXT_L_VIDEO_RESUME.'">'.INFO_TEXT_L_VIDEO_RESUME.'</a>';

    $search_jobs = '<a href="'.tep_href_link(FILENAME_JOB_SEARCH).'" title="'.INFO_TEXT_L_SEARCH_JOBS.'">'.INFO_TEXT_L_SEARCH_JOBS.'</a>';
    $jobs_by_location= '<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_LOCATION).'"  title="'.INFO_TEXT_JOBS_BY_LOCATION.'">'.INFO_TEXT_JOBS_BY_LOCATION.'</a>';
    $jobs_by_map= (GOOGLE_MAP=='true'?'<div><i class="fa fa-angle-right" aria-hidden="true"></i> <a href="'.tep_href_link(FILENAME_JOB_BY_MAP).'" title="'.INFO_TEXT_JOBS_BY_MAP.'">'.INFO_TEXT_JOBS_BY_MAP.'</a></div>':'');
    $jobs_by_category = '<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'" title="'.INFO_TEXT_JOBS_BY_INDUSTRY.'">'.INFO_TEXT_JOBS_BY_INDUSTRY.'</a>';
    $jobs_by_skill = '<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_SKILL).'" title="'.INFO_TEXT_JOBS_BY_SKILL.'">'.INFO_TEXT_JOBS_BY_SKILL.'</a>';
    $jobs_by_companies = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_COMPANY_PROFILE).'" title="'.INFO_TEXT_JOBS_BY_COMPANIES.'">'.INFO_TEXT_JOBS_BY_COMPANIES.'</a>'.(($no_of_companies>0)?"(".$no_of_companies.")":'');
    $my_saved_searches = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_SAVED_SEARCHES).'"  title="'.INFO_TEXT_MY_SAVED_SEARCHES.'">'.INFO_TEXT_MY_SAVED_SEARCHES.'</a>'.(($no_of_saved_searches>0)?"(".$no_of_saved_searches.")":'');
    $job_alert_agent = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_SAVED_SEARCHES).'"  title="'.INFO_TEXT_L_JOB_ALERT_AGENT.'">'.INFO_TEXT_L_JOB_ALERT_AGENT.' </a>'.(($no_of_saved_searches>0)?"(".$no_of_saved_searches.")":'');
  }
  //////Jobseeker ends///////
  if(check_login('jobseeker'))
  define('LEFT_HTML_JOBSEEKER','
  <div class="left-sidebar  for-mobile">
  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="left-panel-container">
  <tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td>
  <div class="card mb-3 for-mobile">
  <div class="card-header alert-primary">
  '.INFO_TEXT_L_RESUME_MANAGER.'
  </div>
  <div class="card-body">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$add_resume.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$my_resumes.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$set_status.'</div>
  </div>
  </div>

  <div class="card mb-3 for-mobile">
  <div class="card-header alert-primary">
  '.INFO_TEXT_L_JOBS.'
  </div>
  <div class="card-body">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$my_saved_jobs.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$my_applications.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$response_from_employer.'</div>
  </div>
  </div>

  <div class="card mb-3 for-mobile">
  <div class="card-header alert-primary">
  '.INFO_TEXT_L_MY_ACCOUNT.'
  </div>
  <div class="card-body">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$edit_personal_details.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$my_cover_letters.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$contact_list.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$newsletters.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$change_password.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$video_resume.'</div>
  </div>
  </div>

  <div class="card mb-3 for-mobile">
  <div class="card-header alert-primary">
  '.INFO_TEXT_MY_JOB_SEARCH.'
  </div>
  <div class="card-body">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$search_jobs.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$jobs_by_companies.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$jobs_by_location.'</div>
  '.$jobs_by_map.'
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$jobs_by_skill.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$jobs_by_category.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$my_saved_searches.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$job_alert_agent.'</div>
  </div>
  </div>


  <div class="left-panel-bar"></div></td>
  </tr>
  <tr>
  <td>
  <ul class="left-panel-list">

  </ul>
  <div id="leftpanelbox">&nbsp;</div>
  </td>
  </tr>
  </table></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td><div class="left-panel-bar"></div></td>
  </tr>
  <tr>
  <td>
  <div id="leftpanelbox">&nbsp;</div>
  </td>
  </tr>
  </table></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td><div class="left-panel-bar"></div></td>
  </tr>
  <tr>
  <td><ul class="left-panel-list">

  </ul>
  <div id="leftpanelbox">&nbsp;</div>
  </td>
  </tr>
  </table></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td><div class="left-panel-bar"></div></td>
  </tr>
  <tr>
  <td><ul class="left-panel-list">

  </ul>

  </td>
  </tr>
  </table></td>
  </tr>
  </table>

  </div>
  ');
  else
  define('LEFT_HTML_JOBSEEKER','');


  //////// Job Search start//////////
  $jobs_by_location       = '<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_LOCATION).'" class="style27" title="'.INFO_TEXT_L_BY_LOCATION.'">'.INFO_TEXT_L_BY_LOCATION.'</a>';
  $jobs_by_map       = (GOOGLE_MAP=='true'?'<div><i class="fa fa-angle-right" aria-hidden="true"></i> <a href="'.tep_href_link(FILENAME_JOB_BY_MAP).'" class="style27" title="'.INFO_TEXT_L_BY_MAP.'">'.INFO_TEXT_L_BY_MAP.'</a></div>':'');
  $jobs_by_skill       = '<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_SKILL).'" class="style27" title="'.INFO_TEXT_L_BY_SKILL.'">'.INFO_TEXT_L_BY_SKILL.'</a>';
  $jobs_by_category       = '<a href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'" class="style27" title="'.INFO_TEXT_L_BY_CATEGORY.'">'.INFO_TEXT_L_BY_CATEGORY.'</a>';
  $jobs_by_companies      = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_COMPANY_PROFILE).'" class="style27" title="'.INFO_TEXT_L_BY_COMPANY.'">'.INFO_TEXT_L_BY_COMPANY.'</a>'.(($no_of_companies>0)?" ( ".$no_of_companies." )":'');
  $my_saved_jobs1          = '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_SAVED_SEARCHES).'" class="style27" title="'.INFO_TEXT_MY_SAVED_JOBS.'">'.INFO_TEXT_MY_SAVED_JOBS.'</a>'.(($no_of_saved_searches>0)?" ( ".$no_of_saved_searches." )":'');
  $week_form1             = tep_draw_form('week1_form', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').tep_draw_hidden_field('job_post_day','7');
  $lastoneweek1           = '<a href="#" onclick="document.week1_form.submit()" class="style27" title="'.INFO_TEXT_LAST_ONE_WEEK.'">'.INFO_TEXT_LAST_ONE_WEEK.'</a>';
  $week_form2             = tep_draw_form('week2_form', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').tep_draw_hidden_field('job_post_day','14');
  $lastoneweek2           = '<a href="#" onclick="document.week2_form.submit()" class="style27" title="'.INFO_TEXT_LAST_TWO_WEEKS.'">'.INFO_TEXT_LAST_TWO_WEEKS.'</a>';
  $week_form3             = tep_draw_form('week3_form', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').tep_draw_hidden_field('job_post_day','21');
  $lastoneweek3           = '<a href="#" onclick="document.week3_form.submit()" class="style27" title="'.INFO_TEXT_LAST_THREE_WEEKS.'">'.INFO_TEXT_LAST_THREE_WEEKS.'</a>';
  $week_form4             = tep_draw_form('week4_form', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search').tep_draw_hidden_field('job_post_day','30');
  $lastoneweek4           = '<a href="#" onclick="document.week4_form.submit()" class="style27" title="'.INFO_TEXT_LAST_ONE_MONTH.'">'.INFO_TEXT_LAST_ONE_MONTH.'</a>';

  if(check_login('jobseeker'))
  {
    $job_serach_left1 ='
    <div class="card mt-3  for-mobile">
      <div class="card-header alert-primary">
        Applicant Tracking
      </div>
      <div class="card-body">
      <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$my_applications.'</div>
      <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$response_from_employer.'</div>
      <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$my_saved_searches.'</div>
      <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$job_alert_agent.'</div>
      </div>
    </div>
    ';
  }
  else
  $job_serach_left1 ='';

  define('JOB_SEARCH_LEFT','
  <div class="card card-custom-left-nav mb-3 for-mobile">
  <div class="card-header card-header-custom-left-nav alert-primary">
  Refine Search
  </div>
  <div class="card-body card-body-custom-left-nav">
  '.tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search'). tep_draw_input_field('keyword','','placeholder="e.g. Sales Executive" type="text" class="form-control mb-2"',false).
  LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control mb-2'","All Locations","",DEFAULT_COUNTRY_ID).'
  <input type="submit" name="login2" value="search now" class="btn btn-primary btn-block" /></form>
  <div class="text-center mt-2"><a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Advanced search</a></div>
  </div>
  </div>




  <div class="card card-custom-left-nav mb-3 for-mobile">
  <div class="card-header card-header-custom-left-nav alert-primary">
  Search Jobs
  </div>
  <div class="card-body card-body-custom-left-nav">
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$jobs_by_category.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$jobs_by_companies.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$jobs_by_location.'</div>
  <div><i class="fa fa-angle-right" aria-hidden="true"></i> '.$jobs_by_skill.'</div>
  '.$jobs_by_map.'
  </div>
  </div>


  <div class="card for-mobile for-mobile">
    <div class="card-header alert-primary">
      Date Posted
    </div>
    <div class="card-body">
    '.$week_form1.'<i class="fa fa-angle-right" aria-hidden="true"></i> '.$lastoneweek1.'</form>
    '.$week_form2.'<i class="fa fa-angle-right" aria-hidden="true"></i> '.$lastoneweek2.'</form>
    '.$week_form3.'<i class="fa fa-angle-right" aria-hidden="true"></i> '.$lastoneweek3.'</form>
    '.$week_form4.'<i class="fa fa-angle-right" aria-hidden="true"></i> '.$lastoneweek4.'</form>
    <!--'. $job_serach_left1.'-->

    </div>
  </div>

  <!-- New Card part when user is logged in-->

  '. $job_serach_left1.'


  ');

}



//////// Job Search ends//////////

?>