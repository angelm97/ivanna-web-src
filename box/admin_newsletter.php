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
$heading[] = array('text'  => BOX_HEADING_NEWSLETTER,
																			'link'  => FILENAME_ADMIN1_NEWS_LETTER.'?selected_box=newsletter',
                   'default_row'=>(($_SESSION['selected_box'] == 'newsletter') ?'1':''),
                   'text_image'=>'<i class="fas fa-file-alt admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'newsletter')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_NEWS_LETTER, BOX_NEWS_LETTER_MANAGER);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_NEWSLETTERS, BOX_JOBSEEKER_NEWS_LETTER,'newsletter_for=jobseeker');
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_NEWSLETTERS, BOX_RECRUITER_NEWS_LETTER,'newsletter_for=recruiter');
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>