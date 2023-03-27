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
$heading[] = array('link'  =>FILENAME_ADMIN1_JOBSEEKERS.'?selected_box=jobseekers',
                   'text'  =>BOX_HEADING_JOBSEEKERS,
                   'default_row'=>(($_SESSION['selected_box'] == 'jobseekers') ?'1':''),
                   'text_image'=>'<i class="fas fa-users admin-left-icon"></i>',
                  );

if ($_SESSION['selected_box'] == 'jobseekers')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_JOBSEEKERS, BOX_JOBSEEKER);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_PAID_JOBSEEKERS, BOX_PAID_JOBSEEKERS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_IMPORT_JOBSEEKER, BOX_IMPORT_JOBSEEKERS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>