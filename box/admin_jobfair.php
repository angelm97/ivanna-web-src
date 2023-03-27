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
$heading[] = array('text'  =>BOX_HEADING_JOBFAIR,
                   'link'  =>FILENAME_ADMIN1_LIST_OF_JOBFAIRS.'?selected_box=jobfair',
                   'default_row'=>(($_SESSION['selected_box'] == 'jobfair') ?'1':''),
                   'text_image'=>'<i class="fas fa-user-tie admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'jobfair')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_JOBFAIRS, BOX_JOBFAIR);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_RECRUITER_PARTICIPATE_JOBFAIR, BOX_RECRUITER_PARTICIPATE_JOBFAIR);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }

}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);

?>