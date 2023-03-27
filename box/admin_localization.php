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
$heading[] = array('text'  => BOX_HEADING_LOCALIZATION,
																			'link'  => FILENAME_ADMIN1_ADMIN_CURRENCIES.'?selected_box=admin_localization',
                   'default_row'=>(($_SESSION['selected_box'] == 'admin_localization') ?'1':''),
                   'text_image'=>'<i class="fas fa-user-clock admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'admin_localization')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_CURRENCIES, BOX_LOCALIZATION_CURRENCIES);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_LANGUAGES, BOX_LOCALIZATION_LANGUAGES);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_ORDERS_STATUS, BOX_LOCALIZATION_ORDER_STATUS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>