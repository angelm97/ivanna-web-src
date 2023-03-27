<?php

include_once("include_files.php");
include_once(PATH_TO_MAIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_JOBSEEKER_RESUME3);
$template->set_filenames(array('resume_step3' => 'jobseeker_resume3.htm'));
include_once(FILENAME_BODY);
$jscript_file=PATH_TO_LANGUAGE.$language."/jscript/".'jobseeker_resume3.js';
if(!check_login("jobseeker"))
{
 $messageStack->add_session(LOGON_FIRST_MESSAGE, 'error');
 tep_redirect(FILENAME_JOBSEEKER_LOGIN);
}
//print_r($_POST);echo "<br> ";
################# EDUCTION DELETE ##########################
if($_GET['data_delete']=='ResultDelete' && isset($_GET['r3_id']))
{
 $r3_id= explode(",",$_GET['r3_id']);
 for($i=0;$i<count($r3_id);$i++)
	{
	 $table_name=JOBSEEKER_RESUME3_TABLE." as  r3  left outer join ".JOBSEEKER_RESUME1_TABLE ." as r1  on (r1.resume_id =r3.resume_id)";
	 $whereCluse=" r3.r3_id ='".$r3_id[$i] ."' and jobseeker_id='".$_SESSION['sess_jobseekerid']."'";
  if($check=getAnyTableWhereData($table_name,$whereCluse,"r1.resume_id,r3_id"))
  {
				$resume_id = $check['resume_id'];
				$r3_id     = $check['r3_id'];
				tep_db_query("delete from ".JOBSEEKER_RESUME3_TABLE." where resume_id='".$check['resume_id']."' and r3_id ='".$r3_id."'");
	 }
 }
 $query_string=encode_string("resume_id@@@".$resume_id."@@@resume");
 $messageStack->add_session(MESSAGE_SUCCESS_DELETE,'success');
 tep_redirect(FILENAME_JOBSEEKER_RESUME3."?query_string=".$query_string);
}
################################################
$action = (isset($_POST['action']) ? $_POST['action'] : '');
if (isset($_POST['query_string']))
 $resume_id =check_data($_POST['query_string'],"@@@","resume_id","resume");
elseif (isset($_GET['query_string']))
  $resume_id =check_data($_GET['query_string'],"@@@","resume_id","resume");
elseif (isset($_POST['r3_id']))
{
 if($check=getAnyTableWhereData(JOBSEEKER_RESUME3_TABLE,"r3_id='".$_POST['r3_id']."'","resume_id,r3_id"))
 {
  $resume_id = $check['resume_id'];
  $r3_id     = $check['r3_id'];
 }
 else
 {
  die();
 }
}
$query_string=encode_string("resume_id@@@".$resume_id."@@@resume");
///// Check  Resume  validity///////////
if(!$check1=getAnyTableWhereData(JOBSEEKER_RESUME1_TABLE,"resume_id ='".$resume_id."' and jobseeker_id ='".$_SESSION['sess_jobseekerid']."'",'resume_title'))
{
  $messageStack->add_session(MESSAGE_RESUME_NOT_EXIST,'error');
  tep_redirect(tep_href_link(FILENAME_JOBSEEKER_LIST_OF_RESUMES));
}

//  xxx


// print_r($check1);
#######  EDUCATION LIST #########################
$query_list = "select r3_id,resume_id, degree, school, city, state,state_id, country, start_month, start_year, end_month, end_year, related_info  from " .JOBSEEKER_RESUME3_TABLE . " where resume_id ='".$resume_id."' order by r3_id";
//echo $query_list ;

$result_query_list = tep_db_query($query_list);
$list_row = tep_db_num_rows($result_query_list);
$i=1;
while ($row_education = tep_db_fetch_array($result_query_list))
{
	$r_id  = $row_education['r3_id'];
 if($row_education['start_year']!=0 && $row_education['start_month']!=0)
		$start_date  = formate_date(tep_db_output($row_education['start_year']).'-'.tep_db_output($row_education['start_month']).'-01'," M Y ");
 else
		$start_date  = '';
	if($row_education['end_year']!=0 && $row_education['end_month']!=0)
		$end_date  = formate_date(tep_db_output($row_education['end_year']).'-'.tep_db_output($row_education['end_month']).'-01'," M Y ");
 else
		$end_date  = '';
 $row_selected=' class="dataTableRow'.($i%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"';
	$template->assign_block_vars('education', array(
		'row_selected'    => $row_selected,
		'institution_name'=> tep_db_output($row_education['school']),
		'degree'          => get_name_from_table(EDUCATION_LEVEL_TABLE,TEXT_LANGUAGE.'education_level_name', 'id',tep_db_output($row_education['degree'])),
		'start_date'      => $start_date,
		'end_date'        => $end_date,
		'edit'            => "<a href='#' onclick='document.education_list".$i.".submit()'>".TABLE_HEADING_EDIT."</a>",
		'delete'          => "<a href='#' onClick=goRemove('".FILENAME_JOBSEEKER_RESUME3."','r3_id','ResultDelete','$r_id');return false;>". tep_db_output(INFO_TEXT_DELETE)." </a>",
		'list_form'       => tep_draw_form('education_list'.$i, FILENAME_JOBSEEKER_RESUME3, '', 'post','').tep_draw_hidden_field('r3_id',$r_id),
		));
	$i++;
}


    $ct_id_new =  '';
    $ct_title =  '';
    $ct_descrip =  '';
    $ct_sm =  '';
    $ct_sy = '';
    $ct_em =  '';
    $ct_ey =  '';



$i=1;

if (isset($_GET['edit_ct']) ) {
}else{
  $education_button2='<button class="btn btn-primary mb-2 mr-2" type="submit" onclick=set_action_ct("education_add_ct")>Agregar nueva educación</button> <button class="btn btn-secondary mb-2 mr-2" type="submit" onclick=set_action_ct("education_add_next_ct")>Guardar y siguiente</button>';//tep_image_submit(PATH_TO_BUTTON.'add_new_education.gif', IMAGE_SAVE_ADD_NEW," onclick=set_action('education_add')")."&nbsp;&nbsp;&nbsp;".tep_image_submit(PATH_TO_BUTTON.'button_save_next.gif', IMAGE_SAVE_NEXT,"onclick=set_action('education_add_next')");
}

if (isset($_GET['delete_ct'])) {
  $delete_id = $_GET['delete_ct'];
  tep_db_query("delete from jobseeker_certifications where id='".$delete_id."'");
  $messageStack->add_session(MESSAGE_SUCCESS_DELETE,'success');
  tep_redirect(FILENAME_JOBSEEKER_RESUME3."?query_string=".$query_string);
}


if(tep_not_null($action))
{
 switch($action)
 {
  case 'education_add':
  case 'education_add_ct':
  case 'education_add_next':
  case 'education_edit_ct': 
  case 'education_edit_ct': 
  case 'education_add_next_ct':
  case 'education_edit':
   $resume_id                = $resume_id;
   $r3_id                    = $_POST['r3_id'];
   $degree                   = $_POST['TR_degree'];
   $school                   = $_POST['school'];
   $specialization           = $_POST['specialization'];
   $certification           = $_POST['certification'];
   $city                     = $_POST['city'];
   $country                  =(int)tep_db_prepare_input($_POST['TR_country']);
   $start_month              = (int)$_POST['SR_start_month'];
   $ct_start_month              = (int)$_POST['CT_start_month'];
   $start_year               = (int)$_POST['SR_start_year'];
   $ct_start_year               = (int)$_POST['CT_start_year'];
   $end_month                = (int)$_POST['SR_end_month'];
   $ct_end_month                = (int)$_POST['CT_end_month'];
   $end_year                 = (int)$_POST['SR_end_year'];
   $ct_end_year                 = (int)$_POST['CT_end_year'];
   $related_info             = $_POST['related_info'];
   $ct_related_info             = $_POST['certification_description'];
   $error=false;

   $start_date=formate_date($start_year.'-'.$start_month.'-01',"Ym");
   $end_date=formate_date($end_year.'-'.$end_month.'-01',"Ym");

   $ct_start_date=formate_date($ct_start_year.'-'.$ct_start_month.'-01',"Ym");
   $ct_end_date=formate_date($ct_end_year.'-'.$ct_end_month.'-01',"Ym");

   if($start_date>$end_date)
   {
    $start_date.'- '.$start_date;
    $error=true;
    $messageStack->add(MESSAGE_DEGREE_DATE_ERROR, 'error');
   }
   if(is_numeric($country) == false)
   {
    $error = true;
    $messageStack->add(ENTRY_COUNTRY_ERROR,'jobseeker_account');
   }
   if(!$error)
			{
				$sql_data_array=array('resume_id'=>tep_db_prepare_input($resume_id),
                          'degree'                   =>tep_db_prepare_input($degree),
                          'school'                   =>tep_db_prepare_input($school),
                          'specialization'           =>tep_db_prepare_input($specialization),
                          'city'                     =>tep_db_prepare_input($city),
                          'country'                  =>tep_db_prepare_input($country),
                          'start_month'              =>tep_db_prepare_input($start_month),
                          'start_year'               =>tep_db_prepare_input($start_year),
                          'end_month'                =>tep_db_prepare_input($end_month),
                          'end_year'                 =>tep_db_prepare_input($end_year),
                          'related_info'             =>tep_db_prepare_input($related_info));

        $sql_data_array_ct = array(
        'id_certification'                =>tep_db_prepare_input($certification),
        'id_jobseeker'                    =>tep_db_prepare_input($_SESSION['sess_jobseekerid']),
        'title'                           =>tep_db_prepare_input($certification ),
        'description'                     =>tep_db_prepare_input($ct_related_info ),
        'start_month'                     =>tep_db_prepare_input($ct_start_month),
        'start_year'                      =>tep_db_prepare_input($ct_start_year),
        'end_month'                       =>tep_db_prepare_input($ct_end_month),
        'end_year'                        =>tep_db_prepare_input($ct_end_year) 
      );

      $sql_data_array_ct1 = array(
        'id_certification'                => tep_db_prepare_input((int)2),
        'id_jobseeker'                    =>tep_db_prepare_input($_SESSION['sess_jobseekerid']),
        'title'                           =>tep_db_prepare_input($certification ),
        'description'                     =>tep_db_prepare_input($ct_related_info ),
        'start_month'                     =>tep_db_prepare_input($ct_start_month),
        'start_year'                      =>tep_db_prepare_input($ct_start_year),
        'end_month'                       =>tep_db_prepare_input($ct_end_month),
        'end_year'                        =>tep_db_prepare_input($ct_end_year) 
      );

      if($action=='education_add_ct')
	   {
      tep_db_perform('jobseeker_certifications', $sql_data_array_ct,'insert');
      $messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
	   }

     if($action=='education_add_next_ct')
	   {
       tep_db_perform('jobseeker_certifications', $sql_data_array_ct,'insert');
       $messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
	   }

     if ($action=='education_edit_ct') {
       //var_dump($_POST);
       //die(); (int)$_POST["certification"]  ;
       $id_jobseeker_new_update = $_POST['edit_ct'];
       $sql_data_array_ct1['id_certification'] = $_POST["certification"];
	    tep_db_perform('jobseeker_certifications', $sql_data_array_ct1, 'update', "id = '" . $id_jobseeker_new_update . "'");
      $messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
      tep_redirect(tep_href_link(FILENAME_JOBSEEKER_RESUME3."?query_string=".$query_string));
     }
    if($action=='education_edit')
	   { 
     $sql_data_array1['updated']='now()';
	    tep_db_perform(JOBSEEKER_RESUME1_TABLE, $sql_data_array1, 'update', "jobseeker_id = '" . $_SESSION['sess_jobseekerid'] . "' and  resume_id ='".$resume_id ."'");
     tep_db_perform(JOBSEEKER_RESUME3_TABLE, $sql_data_array, 'update', "r3_id = '" .$r3_id. "' and  resume_id ='".$resume_id ."'");
     $query_string = encode_string("resume_id@@@".$resume_id."@@@resume");
     $messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
	   }
    elseif($action=='education_add' or $action=='education_add_next')
    {
     tep_db_perform(JOBSEEKER_RESUME3_TABLE, $sql_data_array,'insert');
     $messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
	   }
		  $sql_data_array1['updated']='now()';
		  tep_db_perform(JOBSEEKER_LOGIN_TABLE, $sql_data_array1, 'update', "jobseeker_id = '" . $_SESSION['sess_jobseekerid'] . "'");
		  $query_string = encode_string("resume_id@@@".$resume_id."@@@resume");
    if($action=='education_add_next' or $action=='education_add_next_ct')
    {
     tep_redirect(tep_href_link(FILENAME_JOBSEEKER_RESUME4."?query_string=".$query_string));
    }
    elseif($action=='education_add' or $action=='education_edit' or $action=='education_add_ct')
     tep_redirect(tep_href_link(FILENAME_JOBSEEKER_RESUME3."?query_string=".$query_string));
			}
			break;
	}
}
//////////////////////////////
if($error)
{
 $query_string=encode_string("resume_id@@@".$resume_id."@@@resume");
 $add_save_button='<button class="btn btn-primary mb-2 mr-2" type="submit">Guardar y siguiente</button>';//tep_image_submit(PATH_TO_BUTTON.'button_save_next.gif', IMAGE_SAVE,"");
 $registration_form=tep_draw_form('defineForm', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('query_string',$query_string).tep_draw_hidden_field('action','add');

 $education_button='<button class="btn btn-primary mb-2 mr-2" type="submit" onclick=set_action("education_add")>Agregar nueva educación</button> <button class="btn btn-secondary mb-2 mr-2" type="submit" onclick=set_action("education_add_next")>Guardar y siguiente</button>';//tep_image_submit(PATH_TO_BUTTON.'add_new_education.gif', IMAGE_SAVE_ADD_NEW," onclick=set_action('education_add_next')")."&nbsp;&nbsp;&nbsp;".tep_image_submit(PATH_TO_BUTTON.'button_save_next.gif', IMAGE_SAVE_NEXT,"onclick=set_action('education_add_next')");
 $education_button2='<button class="btn btn-primary mb-2 mr-2" type="submit" onclick=set_action_ct("education_add_ct")>Agregar nueva educación</button> <button class="btn btn-secondary mb-2 mr-2" type="submit" onclick=set_action_ct("education_add_next_ct")>Guardar y siguiente</button>';//tep_image_submit(PATH_TO_BUTTON.'add_new_education.gif', IMAGE_SAVE_ADD_NEW," onclick=set_action('education_add_next')")."&nbsp;&nbsp;&nbsp;".tep_image_submit(PATH_TO_BUTTON.'button_save_next.gif', IMAGE_SAVE_NEXT,"onclick=set_action('education_add_next')");
 $education_form = tep_draw_form('education', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('query_string',$query_string).tep_draw_hidden_field('action','');
 $education_form_ct = tep_draw_form('certification', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('query_string',$query_string).tep_draw_hidden_field('action','');

	if($_POST['action']=="education_edit" || $_POST['action']=="education_add" || $_POST['action']=="education_add_next")
 {
  if($_POST['action']=="education_edit")
  {
   $resume_id                = $resume_id;
   $resume_name              = $resume_name;
   $organization             = $organization;
   $start_month              = $start_month;
   $start_year               = $start_year;
   $end_month                = $end_month;
   $end_year                 = $end_year;
   $education_button     = '<button class="btn btn-secondary mb-2 mr-2" type="submit">Actualizar</button>';//tep_image_submit(PATH_TO_BUTTON.'button_update.gif', IMAGE_UPDATE);
   
   $query_string=encode_string("resume_id@@@".$resume_id."@@@resume");
   $education_form=tep_draw_form('education', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('r3_id',$r3_id).tep_draw_hidden_field('action','education_edit');
   $education_form_ct = tep_draw_form('certification', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('query_string',$query_string).tep_draw_hidden_field('action','');
  }
  else
  {
   $education_button='<button class="btn btn-primary mb-2 mr-2" type="submit" onclick=set_action("education_add")>Agregar nueva educación</button> <button class="btn btn-secondary mb-2 mr-2" type="submit" onclick=set_action("education_add_next")>Guardar y siguiente</button>';//tep_image_submit(PATH_TO_BUTTON.'add_new_education.gif', IMAGE_SAVE_ADD_NEW," onclick=set_action('education_add')")."&nbsp;&nbsp;&nbsp;".tep_image_submit(PATH_TO_BUTTON.'button_save_next.gif', IMAGE_SAVE_NEXT,"onclick=set_action('education_add_next')");
   $education_button2='<button class="btn btn-primary mb-2 mr-2" type="submit" onclick=set_action_ct("education_add_ct")>Agregar nueva educación</button> <button class="btn btn-secondary mb-2 mr-2" type="submit" onclick=set_action_ct("education_add_next_ct")>Guardar y siguiente</button>';//tep_image_submit(PATH_TO_BUTTON.'add_new_education.gif', IMAGE_SAVE_ADD_NEW," onclick=set_action('education_add')")."&nbsp;&nbsp;&nbsp;".tep_image_submit(PATH_TO_BUTTON.'button_save_next.gif', IMAGE_SAVE_NEXT,"onclick=set_action('education_add_next')");
   $query_string=encode_string("resume_id@@@".$resume_id."@@@resume");
   $education_form=tep_draw_form('education', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('query_string',$query_string).tep_draw_hidden_field('action','');
   $education_form_ct = tep_draw_form('certification', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('query_string',$query_string).tep_draw_hidden_field('action','');
  }
 }
}
else
{
 if(isset($_POST['r3_id']))
 {
  $fields="r3_id,degree, school,specialization, city, state,state_id, country, start_month, start_year, end_month, end_year, related_info ";
  if($row2=getAnyTableWhereData(JOBSEEKER_RESUME3_TABLE,"r3_id='".$r3_id ."' and resume_id ='".$resume_id."'",$fields))
  {
   $r3_id                = tep_db_prepare_input($row2['r3_id']);
   $degree               = tep_db_prepare_input($row2['degree']);
   $school               = tep_db_prepare_input($row2['school']);
   $specialization       = tep_db_prepare_input($row2['specialization']);
   $city                 = tep_db_prepare_input($row2['city']);
   $TR_country           = tep_db_prepare_input($row2['country']);
   $start_month          = tep_db_prepare_input($row2['start_month']);
   $start_year           = tep_db_prepare_input($row2['start_year']);
   $end_month            = tep_db_prepare_input($row2['end_month']);
   $end_year             = tep_db_prepare_input($row2['end_year']);
   $related_info         = tep_db_prepare_input($row2['related_info']);
   $education_button     = '<button class="btn btn-secondary mb-2 mr-2" type="submit">Actualizar</button>';//tep_image_submit(PATH_TO_BUTTON.'button_update.gif', IMAGE_UPDATE);
   $education_form       = tep_draw_form('education', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('r3_id',$r3_id).tep_draw_hidden_field('action','education_edit');
  }
 }
 else
 {
  $TR_country        = DEFAULT_COUNTRY_ID;
  $query_string=encode_string("resume_id@@@".$resume_id."@@@resume");
  $education_button='<button class="btn btn-primary mb-2 mr-2" type="submit" onclick=set_action("education_add")>Agregar nueva educación</button> <button class="btn btn-secondary mb-2 mr-2" type="submit" onclick=set_action("education_add_next")>Guardar y siguiente</button>';//tep_image_submit(PATH_TO_BUTTON.'add_new_education.gif', IMAGE_SAVE_ADD_NEW," onclick=set_action('education_add')")."&nbsp;&nbsp;&nbsp;".tep_image_submit(PATH_TO_BUTTON.'button_save_next.gif', IMAGE_SAVE_NEXT,"onclick=set_action('education_add_next')");
  //$education_button2='<button class="btn btn-primary mb-2 mr-2" type="submit" onclick=set_action_ct("education_add_ct")>Agregar nueva educación</button> <button class="btn btn-secondary mb-2 mr-2" type="submit" onclick=set_action_ct("education_add_next_ct")>Guardar y siguiente</button>';//tep_image_submit(PATH_TO_BUTTON.'add_new_education.gif', IMAGE_SAVE_ADD_NEW," onclick=set_action('education_add')")."&nbsp;&nbsp;&nbsp;".tep_image_submit(PATH_TO_BUTTON.'button_save_next.gif', IMAGE_SAVE_NEXT,"onclick=set_action('education_add_next')");
  $education_form=tep_draw_form('education', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('query_string',$query_string).tep_draw_hidden_field('action','');
  $education_form_ct = tep_draw_form('certification', FILENAME_JOBSEEKER_RESUME3, '', 'post', 'onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('query_string',$query_string).tep_draw_hidden_field('action','');
}
}
$add_next_button = "<a  href='".tep_href_link(FILENAME_JOBSEEKER_RESUME4."?query_string=".$query_string)."' class='btn btn-secondary mb-2'>".tep_db_output(INFO_SKIP_THIS_STEP)."</a>";

 $resume1='<a class="list-group-item list-group-item-action" href ="#"  onclick="document.resume.submit()"><i class="fa fa-file-text icon-resume-left" aria-hidden="true"></i> '.INFO_TEXT_LEFT_RESUME.'</a>';
		  $resume2='<a class="list-group-item list-group-item-action" href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME2.'?query_string='.$query_string).'" ><i class="fa fa-briefcase icon-resume-left" aria-hidden="true"></i> '.INFO_TEXT_LEFT_EXPERIENCE.'</a>';
    $resume3='<a class="list-group-item list-group-item-action active" href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME3.'?query_string='.$query_string).'" ><i class="fa fa-graduation-cap icon-resume-left active-icon" aria-hidden="true"></i> '.INFO_TEXT_LEFT_EDUCATION.'</a>';
		  $resume4='<a class="list-group-item list-group-item-action" href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME4.'?query_string='.$query_string).'" ><i class="fa fa-wrench icon-resume-left" aria-hidden="true"></i> '.INFO_TEXT_LEFT_SKILLS.'</a>';
		  $resume5='<a class="list-group-item list-group-item-action" href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME5.'?query_string='.$query_string).'" ><i class="fa fa-upload icon-resume-left" aria-hidden="true"></i> '.INFO_TEXT_LEFT_UPLOAD.'</a>';
				$resume6='<a class="list-group-item list-group-item-action" href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME6.'?query_string='.$query_string).'" ><i class="fa fa-bookmark icon-resume-left" aria-hidden="true"></i> '.INFO_TEXT_LEFT_REFERENCE.'</a>';
		  $view_resume='<a class="list-group-item list-group-item-action" href ="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME.'?query_string='.$query_string).'" ><i class="fa fa-eye icon-resume-left" aria-hidden="true"></i> '.INFO_TEXT_LEFT_VIEW_RESUME.'</a>';
//////////////Jobseeker resume left start//////
	define('JOBSEEKER_RESUME_LEFT','
			<div class="list-group mb-3">
    '.$resume1.'
    '.$resume2.'
   '.$resume6.'
  '.$resume3.'
   '.$resume4.'
   '.$resume5.'
   '.$view_resume.'
</div>

	   <div class="resume-side-menu" style="display:none;">
	   <ul class="resume-side-nav">'.tep_draw_form('resume', FILENAME_JOBSEEKER_RESUME1, '', 'post').tep_draw_hidden_field('resume_id',$resume_id).'<li class="resume-left-title-inactive"><i class="fa fa-file-text resume-inactive-icon" aria-hidden="true"></i> '.$resume1.'</li></form>
										'.tep_draw_form('resume1', FILENAME_JOBSEEKER_RESUME1, '', 'post').tep_draw_hidden_field('resume_id',$resume_id).'
												<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="#resume_name" onclick="document.resume1.submit()">'.INFO_TEXT_RESUME_NAME.'</a></li></form>
											'.tep_draw_form('resume2', FILENAME_JOBSEEKER_RESUME1, '', 'post').tep_draw_hidden_field('resume_id',$resume_id).'
												<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="#objective" onclick="document.resume2.submit()">'.INFO_TEXT_OBJECTIVE.'</a></li></form>
											'.tep_draw_form('resume3', FILENAME_JOBSEEKER_RESUME1, '', 'post').tep_draw_hidden_field('resume_id',$resume_id).'
												<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="#target_job" onclick="document.resume3.submit()">'.INFO_TEXT_TARGET_JOB.'</a></li></form>
											</ul>
											<ul class="resume-side-nav"><li class="resume-left-title-inactive"><i class="fa fa-briefcase resume-inactive-icon" aria-hidden="true"></i> '.$resume2.'</li><li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME2.'?query_string='.$query_string).'#total_experience" >'.INFO_TEXT_TOTAL_WORK_EXP.'</a></li>
											<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME2.'?query_string='.$query_string).'#experience" >'.INFO_TEXT_YOUR_WORK_EXPERIENCE.'</a></li></ul>
<ul class="resume-side-nav">
	<li class="resume-left-title-inactive"><i class="fa fa-bookmark resume-inactive-icon" aria-hidden="true"></i>'.$resume6.'</li>
	<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME6.'?query_string='.$query_string).'#reference" >'.INFO_TEXT_LIST_OF_REFERENCES.'</a></li>
</ul>
<ul class="resume-side-nav">
	<li class="resume-left-title-active"><i class="fa fa-graduation-cap resume-active-icon" aria-hidden="true"></i>'.$resume3.'</li>
	<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME3.'?query_string='.$query_string).'" >'.INFO_TEXT_EDUCATION_DETAILS.'</a></li>
</ul>
<ul class="resume-side-nav">
	<li class="resume-left-title-inactive"><i class="fa fa-user resume-inactive-icon" aria-hidden="true"></i>'.$resume4.'</li>
	<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME4.'?query_string='.$query_string).'#skill" >'.INFO_TEXT_YOUR_SKILLS.'</a></li>
	<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME4.'?query_string='.$query_string).'#language" >'.INFO_TEXT_LANGUAGES.'</a></li>
</ul>
<ul class="resume-side-nav">
	<li class="resume-left-title-inactive"><i class="fa fa-upload resume-inactive-icon" aria-hidden="true"></i>'.$resume5.'</li>
	<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href ="'.tep_href_link(FILENAME_JOBSEEKER_RESUME5.'?query_string='.$query_string).'" >'.INFO_TEXT_RESUME.'</a></li>
</ul>
<ul class="resume-side-nav">
	<li class="resume-left-title-inactive"><i class="fa fa-eye resume-inactive-icon" aria-hidden="true"></i>'.$view_resume.'</li>
	<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME.'?query_string='.$query_string).'#profile" >'.INFO_TEXT_PERSONAL_PROFILE.'</a></li>
	<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME.'?query_string='.$query_string).'#work_experience" >'.INFO_TEXT_EXPERIENCE.'</a></li>
	<li><i class="fa fa-angle-right" aria-hidden="true"></i> <a href ="'.tep_href_link(FILENAME_JOBSEEKER_VIEW_RESUME.'?query_string='.$query_string).'#target_job" >'.INFO_TEXT_TARGET_JOB.'</a></li></ul></div></td>');
if($messageStack->size('defineForm') > 0)
 $update_message=$messageStack->output('defineForm');
else
 $update_message=$messageStack->output();

 // xxx aqui
 $id_jobseeker_new = $_SESSION['sess_jobseekerid'];
$query_list_ct = "SELECT c.*, c.id AS id_c FROM jobseeker_certifications c, jobseeker j where j.jobseeker_id = c.id_jobseeker AND j.jobseeker_id = $id_jobseeker_new ; ";
//echo $query_list ;



$result_query_list_ct = tep_db_query($query_list_ct);
$list_row_ct = tep_db_num_rows($result_query_list_ct);
$table_new_ct= '';
while ($row_certificado = tep_db_fetch_array($result_query_list_ct))
{

  if (isset($_GET['edit_ct']) && $_GET['edit_ct'] ==  $row_certificado["id_c"]) {
    $edit_ct = $row_certificado["id_c"];
    $ct_id_new =  $row_certificado["id_c"];
    $ct_title =  $row_certificado["id_certification"];
    $ct_descrip =  $row_certificado["description"];
    $ct_sm =  $row_certificado["start_month"];
    $ct_sy =  $row_certificado["start_year"];
    $ct_em =  $row_certificado["end_month"];
    $ct_ey =  $row_certificado["end_year"];
    $education_button2     = '<button class="btn btn-secondary mb-2 mr-2" type="submit" onclick=set_action_ct("education_edit_ct")>Actualizar</button>';//tep_image_submit(PATH_TO_BUTTON.'button_update.gif', IMAGE_UPDATE);

    echo '<script>$("#ff").hide();</script>';
  
  } 


  //echo json_encode($row_certificado['title']);

	$fecha_inicio = formate_date(($row_certificado['start_year']).'-'.($row_certificado['start_month']).'-01'," M Y ");
  $fecha_final = formate_date(($row_certificado['end_year']).'-'.($row_certificado['end_month']).'-01'," M Y ");
  //tep_draw_form("certification22", "adasd.php", "", "post","").tep_draw_hidden_field("r3_id",$r_id);
 $table_new_ct.= '  <tr> '. tep_draw_form("certification22", FILENAME_JOBSEEKER_RESUME3 , "", "post","").tep_draw_hidden_field("edit_ct ",$edit_ct ) . '
 <td class="dataTableContent" >'. $row_certificado["id_certification"] .'</td>
 <td class="dataTableContent" >'. $fecha_inicio .'</td>
 <td class="dataTableContent" >'. $fecha_final .'</td>
 <td class="dataTableContent" ><a href="#" onclick="edit_ct('. $row_certificado["id_c"].')">Editar</a></td> 
 <td class="dataTableContent" ><a href="#" onclick="delete_ct('. $row_certificado["id_c"].')">Borrar</a></td>
 </tr> ';
 
}
 
$db_job_query_raw = "SELECT * FROM certifications";

$db_job_query = tep_db_query($db_job_query_raw);
$db_job_num_row = tep_db_num_rows($db_job_query);

$job_datos_post = (tep_db_fetch_array($db_job_query));

$skills_input_new ='<select id="country" name="certification" class="form-control">
    <option value="'. $ct_title  .'">'. $ct_title .'</option>>'; 
while($row11 = tep_db_fetch_array($db_job_query))
{
  $skills_input_new.= '<option value="'. $row11["name"] .'">'. $row11["name"] .'</option>';
}

$skills_input_new.= '</select>';


tep_db_free_result($result_query_list);

//  xxx
$template->assign_vars(array(
 'HEADING_TITLE'=> HEADING_TITLE,
 'add_save_button'=> $add_save_button,
 'add_next_button'=> $add_next_button,
 'education_button'=> $education_button,
 'education_button2'=> $education_button2,
 'education_form'                 => $education_form,
 'certification_form'                 => $education_form_ct,
 'TABLE_HEADING_INSTITUTION_NAME'=> TABLE_HEADING_INSTITUTION_NAME,
 'TABLE_HEADING_DEGREE'          => TABLE_HEADING_DEGREE,
 'TABLE_HEADING_DEGREE_OBT_DATE' => TABLE_HEADING_DEGREE_OBT_DATE,
 'TABLE_HEADING_DEGREE_END_DATE' => TABLE_HEADING_DEGREE_END_DATE,
 'TABLE_HEADING_COUNTRY_NAME'    => TABLE_HEADING_COUNTRY_NAME,
 'TABLE_HEADING_WORK_STATUS'     => TABLE_HEADING_WORK_STATUS,
 'TABLE_HEADING_ISSUED_BY'       => TABLE_HEADING_ISSUED_BY,
 'TABLE_HEADING_COUNTRY'         => TABLE_HEADING_COUNTRY,
 'TABLE_HEADING_TYPE'            => TABLE_HEADING_TYPE,
 'TABLE_HEADING_EDIT'            => TABLE_HEADING_EDIT,
 'TABLE_HEADING_DELETE'          => TABLE_HEADING_DELETE,

 'SECTION_ACCOUNT_RESUME_NAME'   => SECTION_ACCOUNT_RESUME_NAME,
 'SECTION_EDUCATION_DETAILS'     => SECTION_EDUCATION_DETAILS,

 'REQUIRED_INFO'                  => REQUIRED_INFO,
 'INFO_TEXT_RESUME_NAME'          => INFO_TEXT_RESUME_NAME,
 'INFO_TEXT_RESUME_NAME1'         => $check1['resume_title'],

 'INFO_TEXT_DEGREE'               => INFO_TEXT_DEGREE,
 'INFO_TEXT_DEGREE1'              => LIST_SET_DATA(EDUCATION_LEVEL_TABLE,"",TEXT_LANGUAGE.'education_level_name','id',"id",'name="TR_degree" class="form-control required"',TEXT_PLEASE_SELECT."...",'',$degree),

 'INFO_TEXT_INSTITUTION_NAME'     => INFO_TEXT_INSTITUTION_NAME,
 'INFO_TEXT_INSTITUTION_NAME1'    => tep_draw_input_field('school', $school,'class="form-control" size="46"'),

 'INFO_TEXT_SPECIALIZATION'       => INFO_TEXT_SPECIALIZATION,
 'INFO_TEXT_SPECIALIZATION1'      => tep_draw_input_field('specialization', $specialization,'class="form-control" size="46"'),
 'INFO_TEXT_CERTIFICATION1'      =>  $skills_input_new,
 'TABLE_NEW'                      => $table_new_ct,
 'INFO_TEXT_CITY'                 => INFO_TEXT_CITY,
 'INFO_TEXT_CITY1'                => tep_draw_input_field('city', $city,'class="form-control" size="46"'),

 'INFO_TEXT_COUNTRY'              => INFO_TEXT_COUNTRY,
 'INFO_TEXT_COUNTRY1'             => tep_get_country_list('TR_country',$TR_country, 'class="form-control"'),

 'INFO_TEXT_START_DATE'           => INFO_TEXT_START_DATE,  
 'INFO_TEXT_START_DATE'           => INFO_TEXT_START_DATE, 
 'INFO_TEXT_START_DATE1'          => year_month_list("name='SR_start_year' class='form-control required'",'1970',date(Y),$start_year,"name='SR_start_month' class='form-control required'",$start_month,false,true,true),
 'INFO_TEXT_START_DATE2'          => year_month_list("name='CT_start_year' class='form-control required'",'1970',date(Y),$ct_sy,"name='CT_start_month' class='form-control required'",$ct_sm,false,true,true),
 'INFO_TEXT_END_DATE'             => INFO_TEXT_END_DATE,
 'INFO_TEXT_END_DATE1'            => year_month_list("name='SR_end_year' class='form-control required'",'1970',date(Y),$end_year,"name='SR_end_month' class='form-control required'",$end_month,false,true,true),
 'INFO_TEXT_END_DATE2'            => year_month_list("name='CT_end_year' class='form-control required'",'1970',date(Y),$ct_ey,"name='CT_end_month' class='form-control required'",$ct_em,false,true,true),
 'INFO_TEXT_RELATED_INFO'         => INFO_TEXT_RELATED_INFO,
 'INFO_TEXT_RELATED_INFO1'        => tep_draw_textarea_field('related_info', 'soft', '50', '3', stripslashes($related_info), 'class="form-control"', true, false),
 'INFO_TEXT_RELATED_INFO2'        => tep_draw_textarea_field('certification_description', 'soft', '50', '3', stripslashes($ct_descrip), 'class="form-control"', true, false),
 'INFO_TEXT_JSCRIPT_FILE'         => $jscript_file,
 

 'LEFT_BOX_WIDTH'                 => LEFT_BOX_WIDTH1,
 'RIGHT_BOX_WIDTH'                => RIGHT_BOX_WIDTH1,
 'JOBSEEKER_RESUME_LEFT'          => JOBSEEKER_RESUME_LEFT,
 'LEFT_HTML'                      => LEFT_HTML,
 'RIGHT_HTML'                     => RIGHT_HTML,
 'update_message'=> $update_message));
$template -> pparse('resume_step3');

if (isset($_POST['r3_id'])) {
  echo "<script> var x = document.getElementById('sf');  x.style.display = 'none'; </script>";
}

if (isset($_GET['edit_ct'])) {
  echo "<script> var x = document.getElementById('ff');  x.style.display = 'none'; </script>";
}

?>