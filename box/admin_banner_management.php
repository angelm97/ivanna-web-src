<?
/*
***********************************************************
***********************************************************
**********# Name          : Hema Chawla         #**********
**********# Company       : Aynsoft             #**********
**********# Date Created  : 11/02/04            #**********
**********# Date Modified : 11/02/04            #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
***********************************************************
***********************************************************
*/

$heading = array();
$contents = array();
$heading[] = array('text'  => BOX_HEADING_BANNER_MANAGEMENT,
                   'link'  => FILENAME_ADMIN1_BANNER_UPLOAD."?selected_box=banner_management",
                   'default_row'=>(($_SESSION['selected_box'] == 'banner_management') ?'1':''),
                   'text_image'=>'<i class="fas fa-arrows-alt admin-left-icon"></i>',
                   );


if ($_SESSION['selected_box'] == 'banner_management')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_BANNER_UPLOAD, BOX_BANNER_UPLOAD);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
$content=tep_admin_files_boxes(FILENAME_ADMIN1_BANNER_MANAGEMENT, BOX_BANNER_MANAGE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_BANNER_STATISTICS, BOX_BANNER_STATISTICS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>
