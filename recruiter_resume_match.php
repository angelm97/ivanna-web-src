<?
/*
***********************************************************
***********************************************************
**********# Name          : Shambhu Prasad Patnaik #*******
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
***********************************************************
***********************************************************
*/
include_once("include_files.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_RECRUITER_RESUME_MATCH);
include_once(FILENAME_BODY);
include_once("general_functions/weight_function.php");
$template->set_filenames(array('resume_match' => 'recruiter_resume_match.htm'));
if(!check_login("recruiter"))
{
 $messageStack->add_session(LOGON_FIRST_MESSAGE, 'error');
 tep_redirect(FILENAME_RECRUITER_LOGIN);
}
$job_id         =(int) (isset($_GET['jobID']) ? $_GET['jobID'] : '');
$application_id =tep_db_prepare_input($_GET['application_id']);
if(!$row_check=getAnyTableWhereData(JOB_TABLE ," job_id='".$job_id."'  and recruiter_id='".$_SESSION['sess_recruiterid']."'","job_id"))
{
 $messageStack->add_session(ERROR_JOB_NOT_EXIST, 'error');
 tep_redirect(FILENAME_RECRUITER_LIST_OF_JOBS);
}

$row_check_resume=getAnyTableWhereData(APPLICATION_TABLE . " as a left outer join  ".JOBSEEKER_TABLE." as j on(a.jobseeker_id=j.jobseeker_id) left outer join  ".JOBSEEKER_RESUME1_TABLE." as r on (a.resume_id=r.resume_id)","a.application_id='".tep_db_input($application_id)."' and a.job_id='".tep_db_input($job_id)."' ","a.id,j.jobseeker_first_name,j.jobseeker_last_name,r.resume_id");
if((int)$row_check_resume['resume_id']<=0)
{
 $messageStack->add_session(ERROR_RESUME_NOT_EXIST, 'error');
 //tep_redirect(FILENAME_RECRUITER_LIST_OF_APPLICATIONS,'jobID='.$job_id);
}

if($rows=getAnyTableWhereData(RESUME_WEIGHT_TABLE ," job_id='".$job_id."'"))
{
}
else
$rows=getAnyTableWhereData(RESUME_WEIGHT_TABLE ," job_id='0'");
$match_row=(get_resume_weight($row_check_resume['resume_id'],$job_id,true));
//print_r($match_row);
$resume_location_weight=$resume_industry_weight=$resume_job_type_weight=$resume_experience_weight='--';

$job_location_weight=tep_db_output($rows['location']."%");
if($rows['location']>0)
$resume_location_weight=$match_row['location']."%";

$job_industry_weight=tep_db_output($rows['industry']."%");
if($rows['industry']>0)
$resume_industry_weight=$match_row['industry']."%";

$job_job_type_weight=tep_db_output($rows['job_type']."%");
if($rows['job_type']>0)
$resume_job_type_weight=$match_row['job_type']."%";

$job_experience_weight=tep_db_output($rows['experience']."%");
if($rows['experience']>0)
$resume_experience_weight=$match_row['experience']."%";



// mi code 
// job info
$result_log_query = tep_db_query("select * from jobs where job_id = '" . (int)$job_id . "'");
$result_log = tep_db_fetch_array($result_log_query);
$jobs_info = $result_log;

//job_seeker_resume_id 
$result_log_query = tep_db_query("select resume_id from application where application_id = '" . $application_id . "'");
$result_log = tep_db_fetch_array($result_log_query);
$job_seeker_resume_id = $result_log['resume_id'];


//job_seeker_resume info
$result_log_query = tep_db_query("select * from jobseeker_resume1 where resume_id = '" . (int)$job_seeker_resume_id . "'");
$result_log = tep_db_fetch_array($result_log_query);
$jobseeker_info = $result_log;

//job_seeker_resume_expirience info
$result_log_query = tep_db_query("select * from jobseeker_resume2 where resume_id = '" . (int)$job_seeker_resume_id . "'");
$result_log = tep_db_fetch_array($result_log_query);
$jobseeker_expiriences_info = $result_log;



//job_seeker_resume_education info
$result_log_query = tep_db_query("select degree from jobseeker_resume3 where resume_id = '" . (int)$job_seeker_resume_id . "'");
$result_log = tep_db_fetch_array($result_log_query);
$jobseeker_education_info = $result_log['degree'];


//job_seeker_resume_education info
$result_log_query_skill = tep_db_query("select * from jobseeker_resume4 where resume_id = '" . (int)$job_seeker_resume_id . "'");


//job_seeker_id 
$result_log_query = tep_db_query("select jobseeker_id from application where application_id = '" . $application_id . "'");
$result_log = tep_db_fetch_array($result_log_query);
$job_seeker_id = $result_log['jobseeker_id'];

//job_seeker_info
$result_log_query = tep_db_query("select * from jobseeker where jobseeker_id = '" . $job_seeker_id . "'");
$result_log = tep_db_fetch_array($result_log_query);
$job_seeker_info_cuidad = $result_log['jobseeker_state_id'];

//job_cuidad_nombre
$result_log_query = tep_db_query("select * from zones where zone_id = '" . $jobs_info['job_state_id'] . "'");
$result_log = tep_db_fetch_array($result_log_query);
$job_city_name = $result_log['zone_name'];

//job_seeker_cuidad_nombre
$result_log_query = tep_db_query("select * from zones where zone_id = '" . $job_seeker_info_cuidad . "'");
$result_log = tep_db_fetch_array($result_log_query);
$job_seeker_city_name = $result_log['zone_name'];

// match califications
$result_log_query = tep_db_query("select * from resume_weight where job_id = '" . (int)$job_id . "'");
$result_log = tep_db_fetch_array($result_log_query);
$match_califications = $result_log;

$result_log_query = tep_db_query("select * from jobseeker_resume2 where resume_id = '" . (int)$job_seeker_resume_id . "'");
$get_jobseeker_array = $result_log_query;

//job_cuidad_nombre
$jobs_info['job_state_id'];

$municipio1 = str_replace(" ","%20",$job_city_name);
$municipio2 = str_replace(" ","%20",$job_seeker_city_name);

$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$municipio1%20republica%20dominicana&destinations=$municipio2%20republica%20dominicana&key=AIzaSyD2tnF8A_5fR0I7KRYXuVAec29erzrbXbk";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);

$distance = (json_decode($resp, true));

$distance = (json_encode($distance["rows"], true));

$distance = (json_decode($distance, true));

$distance_total = ( (array) $distance[0]["elements"][0]["distance"]["value"]);

// distancia total en kilometros.
$distance_total = $distance_total[0];

curl_close($curl);

// months to years
//  application_id
$total_of_match = 0;
// Experice Listo
if ($jobs_info && $jobseeker_info) {

    // $jobs_info['min_experience'];  esta en meses
    //  $jobseeker_info['experience_year'] esta en year
    
    $exp_req = $jobs_info['min_experience'];
    $year_jobseeker_info = $jobseeker_info['experience_year'] * 12;

    $c = $exp_req; // maximo
    $u = $year_jobseeker_info;  // % a buscar
    $total_result_expi = (($u / $c) * 100); 

    if ($total_result_expi > 100) {
        $total_result_expi = 100;
    }

    $resume_experience_weight = $total_result_expi . '%'; 
}else{
    $resume_experience_weight=0 ."%";
}

// Education  Listo
$jobseeker_education_info = $jobseeker_education_info - 1;
$jobs_info['TR_degree'] = $jobs_info['TR_degree'] - 1;
$resume_industry_weight = 0;
if ($jobs_info && $jobseeker_info && $jobseeker_education_info) {
    if ($jobseeker_education_info >= $jobs_info['TR_degree']) {
        $resume_industry_weight=100 ."%"; 
    }elseif ($jobs_info['TR_degree'] == 7 && $jobseeker_education_info == 6) {
        $resume_industry_weight=66 ."%"; 
    }elseif ($jobs_info['TR_degree'] == 7 && $jobseeker_education_info == 5) {
        $resume_industry_weight=33 ."%"; 
    }elseif ($jobs_info['TR_degree'] == 2 && $jobseeker_education_info == 1) {
        $resume_industry_weight=30 ."%"; 
    }elseif ($jobs_info['TR_degree'] == 3 && $jobseeker_education_info == 2) {
        $resume_industry_weight=30 ."%"; 
    }elseif ($jobs_info['TR_degree'] == 4 && $jobseeker_education_info == 3) {
        $resume_industry_weight=66 ."%"; 
    }elseif ($jobs_info['TR_degree'] == 8 && $jobseeker_education_info == 7) {
        $resume_industry_weight=30 ."%"; 
    }

}else{
    $resume_industry_weight=0 ."%";
}



// Location  Listo
/*
******************* Ciudad del Trabajo *****************
******************* Proximidad KM	% Match ************
******************* 20	100.00% ************************
******************* 25	90% ****************************
******************* 30	80% ****************************
******************* 40	50% ****************************
******************* 50	30% ****************************
******************* 70	0% *****************************
*/

if ($distance_total >= 70000 || $distance_total <= 70000) {
    $resume_location_weight= 0 ."%"; 
}

if ($distance_total <= 50000 && $distance_total > 40000) {
    $resume_location_weight= 30 ."%"; 
}

if ($distance_total <= 40000 && $distance_total > 30000) {
    $resume_location_weight= 50 ."%"; 
}

if ($distance_total <= 30000 && $distance_total > 25000) {
    $resume_location_weight= 80 ."%"; 
}

if ($distance_total <= 25000 && $distance_total > 20000) {
    $resume_location_weight= 90 ."%"; 
}

if ($distance_total <= 20000) {
    $resume_location_weight= 100 ."%"; 
}


// Industry  Listo

$job_industries = explode(",", $jobs_info['job_industry_sector']);
$job_industries_matched = false;
while ($row = tep_db_fetch_array($get_jobseeker_array))
{
    foreach ($job_industries as $industry_value) {
        if ($industry_value == $row['company_industry']) {
            $job_industries_matched = true;
        }
    }
}

foreach ($job_industries as $industry_value) {
    if ($industry_value == $jobseeker_expiriences_info['company_industry']) {
        $job_industries_matched = true;
    }
}

if ($job_industries_matched) {
    $resume_education_weight=100 ."%"; 
}else {
    $resume_education_weight=0 ."%";
}


// skills

$jobseeker_skills = [];
$job_skills = explode(",", $jobs_info['job_skills']);
array_pop($job_skills); 
$skills_req = count($job_skills);
$skills_had = 0;
 
while($row = tep_db_fetch_array($result_log_query_skill)){
    array_push($jobseeker_skills, $row["skill"]);
}

foreach($job_skills as $skill_i){
    foreach($jobseeker_skills as $skill_j){
        if ($skill_i == $skill_j) {
            $skills_had++;
        }
    }
}


$total_result_skills = (($skills_had / $skills_req) * 100); 
$resume_skill_weight = $total_result_skills . '%';

// total of % 
$total_max = 400;

// match califications logic

if ($match_califications['location'] == 0 && $match_califications['industry'] == 0 && $match_califications['job_type'] == 0 && $match_califications['experience'] == 0 && $match_califications['skill'] == 0 ) {
    
    $match_califications['location'] = 20;
    $match_califications['industry']= 20;
    $match_califications['job_type']= 20;
    $match_califications['experience']= 20;
    $match_califications['skill']= 20;
}

$resume_location_weight = (($resume_location_weight * $match_califications['location']) / 100);
$resume_education_weight = (($resume_education_weight * $match_califications['industry']) / 100);
$resume_industry_weight = (($resume_industry_weight * $match_califications['job_type']) / 100);
$resume_experience_weight = (($resume_experience_weight * $match_califications['experience']) / 100); 
$resume_skill_weight = (($resume_skill_weight * $match_califications['skill']) / 100); 

$resume_location_weight = number_format($resume_location_weight, 1). " %";
$resume_education_weight = number_format($resume_education_weight, 1). " %";
$resume_industry_weight = number_format($resume_industry_weight, 1). " %";
$resume_experience_weight = number_format($resume_experience_weight, 1). " %";
$resume_skill_weight = number_format($resume_skill_weight, 1). " %";
     



// logic end





$total = ($resume_location_weight + $resume_education_weight + $resume_industry_weight + $resume_experience_weight + $resume_skill_weight) . ' %';
$template->assign_vars(array(
 'HEADING_TITLE'=>HEADING_TITLE,
 'INFO_TEXT_JOBSEEKER_NAME'   => tep_db_output(ucfirst($row_check_resume['jobseeker_first_name'].' '.$row_check_resume['jobseeker_last_name'])),
 'INFO_TEXT_JOBSEEKER_APP_ID' => INFO_TEXT_JOBSEEKER_APP_ID,
 'INFO_TEXT_JOBSEEKER_APP_ID1'=> tep_db_output($application_id),
 'INFO_TEXT_FIELDS'           => INFO_TEXT_FIELDS,
 'INFO_TEXT_JOB_WEIGHTS'      => INFO_TEXT_JOB_WEIGHTS,
 'INFO_TEXT_RESUME_WEIGHTS'   => INFO_TEXT_RESUME_WEIGHTS,

 'INFO_TEXT_LOCATION'         => INFO_TEXT_LOCATION,
 'INFO_TEXT_JOB_LOCATION1'    => $match_califications['location'] . ' %',
 'INFO_TEXT_RESUME_LOCATION1' => $resume_location_weight,

 'INFO_TEXT_INDUSTRY'         => INFO_TEXT_INDUSTRY,
 'INFO_TEXT_JOB_INDUSTRY1'    => $match_califications['job_type'] . ' %',
 'INFO_TEXT_RESUME_INDUSTRY1' => $resume_industry_weight,

 'INFO_TEXT_RESUME_EDUCATION' => $resume_education_weight,
 'INFO_TEXT_RESUME_LOCATION_ORIGIN' => $resume_location_weight,
 
 'INFO_TEXT_EXPERIENCE'       => INFO_TEXT_EXPERIENCE,
 'INFO_TEXT_JOB_EXPERIENCE'   => $match_califications['experience'] . ' %',
 'INFO_TEXT_JOB_EXPERIENCE22' => $match_califications['industry'] . ' %',
 'INFO_TEXT_JOB_SKILL' => $match_califications['skill'] . ' %',
 'INFO_TEXT_RESUME_EXPERIENCE'=>$resume_experience_weight,
 'INFO_TEXT_RESUME_SKILL'=>$resume_skill_weight,

 'INFO_TEXT_JOB_TYPE'         => INFO_TEXT_JOB_TYPE,
 'INFO_TEXT_JOB_JOB_TYPE1'    => $job_job_type_weight,
 'INFO_TEXT_RESUME_JOB_TYPE1' => $resume_job_type_weight,

 'INFO_TEXT_TOTAL'            => INFO_TEXT_TOTAL,
 'INFO_TEXT_TOTAL1'           => $total,
 
 'LEFT_BOX_WIDTH'=>LEFT_BOX_WIDTH1,
 'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH1,
 'LEFT_HTML'=>LEFT_HTML,
 'RIGHT_HTML'=>RIGHT_HTML,
 'update_message'=>$messageStack->output()));
$template->pparse('resume_match');
?>