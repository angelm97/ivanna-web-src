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
$heading[] = array('text'  => BOX_HEADING_FORUM,
			       'link'  => FILENAME_ADMIN1_FORUM_CONFIGURATION."?selected_box=forum",
                   'default_row'=>(($_SESSION['selected_box'] == 'forum') ?'1':''),
                   'text_image'=>'<i class="fab fa-wpforms admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'forum')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_FORUM_CONFIGURATION, BOX_FORUM_CONFIGURATION);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_FORUMS, BOX_FORUM);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_FORUM_CATEGORIES, BOX_FORUM_CATEGORIES);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_FORUM_POST, BOX_FORUM_POST);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_FORUM_REPLY, BOX_FORUM_REPLY);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>