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
$heading[] = array('text'  => BOX_HEADING_SEARCH,
				   'link'  => FILENAME_ADMIN1_JOBSEEKER_REPORTS.'?selected_box=search',
                   'default_row'=>(($_SESSION['selected_box'] == 'search') ?'1':''),
                   'text_image'=>'<i class="fas fa-search admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'search')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_JOBSEEKER_REPORTS, BOX_SEARCH_JOBSEEKER);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_RATE_RESUMES, BOX_RATE_RESUMES);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_RECRUITER_REPORTS, BOX_SEARCH_RECRUITER);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
$content=tep_admin_files_boxes(FILENAME_ADMIN1_APPLICANT_REPORTS, BOX_SEARCH_APPLICANT);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>