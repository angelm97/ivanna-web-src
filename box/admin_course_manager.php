<?
/*
***********************************************************
***********************************************************
**********# Name          : Kamal Kumar Sahoo   #**********
**********# Company       : Aynsoft             #**********
**********# Date Created  : 3/18/21             #**********
**********# Date Modified : 3/18/21             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
***********************************************************
***********************************************************
*/
$heading = array();
$contents = array();
$heading[] = array('text'  => BOX_HEADING_COURSE,
					'link'  => FILENAME_ADMIN1_LIST_OF_COURSES."?selected_box=course",
                   'default_row'=>(($_SESSION['selected_box'] == 'course') ?'1':''),
                   'text_image'=>'<i class="fas fa-user-edit admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'course')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_COURSES, BOX_COURSE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_COURSE_CATEGORIES, BOX_COURSE_COURSE_CATEGORIES);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }

}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>