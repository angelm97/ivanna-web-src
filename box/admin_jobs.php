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
$heading[] = array('link'  =>FILENAME_ADMIN1_RECRUITER_JOBS.'?selected_box=jobs',
                   'text'  =>BOX_HEADING_JOBS,
                   'default_row'=>(($_SESSION['selected_box'] == 'jobs') ?'1':''),
                   'text_image'=>'<i class="fas fa-briefcase admin-left-icon"></i>',
                  );

if ($_SESSION['selected_box'] == 'jobs')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_RECRUITER_JOBS, BOX_JOBS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_RECRUITER_INDEED_JOBS, BOX_INDEED_JOBS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>