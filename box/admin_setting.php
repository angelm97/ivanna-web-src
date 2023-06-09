<?
/*
***********************************************************
***********************************************************
**********# Name          : Kamal Kumar Sahoo   #**********
**********# Company       : Aynsoft             #**********
**********# Date Created  : 11/02/04            #**********
**********# Date Modified : 11/02/04            #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
***********************************************************
***********************************************************
*/
$heading = array();
$contents = array();
$heading[] = array('text'  => BOX_HEADING_SETTING,
																			'link'  => FILENAME_ADMIN1_ADMIN_USER_CATEGORY."?selected_box=admin_configuration",
                   'default_row'=>($_SESSION['selected_box'] == 'admin_configuration') ?'1':'',
                   'text_image'=>'<i class="fas fa-cog admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'admin_configuration')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_USER_CATEGORY, BOX_SETTING_USER_NAME);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }

 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_CONTINENT, BOX_SETTING_CONTINENT);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_COUNTRY, BOX_SETTING_COUNTRY);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_ZONE, BOX_SETTING_ZONE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ZIP_CODES, BOX_SETTING_ZIP_CODE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_JOB_TYPE, BOX_SETTING_JOB_TYPE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_JOB_CATEGORY, BOX_SETTING_JOB_CATEGORY);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_JOBSEEKER_LANGUAGE, BOX_SETTING_JOBSEEKER_LANGUAGE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_PROFICIENCY, BOX_SETTING_LANGUAGE_PROFICIENCY);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_CAREER_LEVEL, BOX_SETTING_CAREER_LEVEL);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_EXPERIENCE, BOX_SETTING_EXPERIENCE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, BOX_SETTING_EDUCATION_LEVEL);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_SKILL_LAST_USED, BOX_SETTING_SKILL_LAST_USED);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_SKILL_LEVEL, BOX_SETTING_SKILL_LEVEL);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_RESUME_WEIGHT, BOX_SETTING_RESUME_WEIGHT);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_G_CAPTCHA_PLUGIN, BOX_SETTING_GOOGLE_CAPTCHA);

 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_SALARY, BOX_SETTING_SALARY);

 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }

}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>