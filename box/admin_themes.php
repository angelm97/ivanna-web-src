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
$heading[] = array('text'  => BOX_HEADING_THEMES,
				'link'  => FILENAME_ADMIN1_THEMES."?selected_box=themes",
                   'default_row'=>(($_SESSION['selected_box'] == 'themes') ?'1':''),
                   'text_image'=>'<i class="fas fa-palette admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'themes')
{
 $row_logo=getAnyTableWhereData(CONFIGURATION_TABLE,"configuration_name='DEFAULT_SITE_LOGO'","id");
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_MODULE,BOX_THEMES_LOGO,'id='.$row_logo['id'].'&action=edit');
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_LIST_OF_SLIDERS,BOX_THEMES_SLIDER);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_THEMES, BOX_THEMES_THEMES);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_THEME_EDITOR, BOX_THEMES_THEME_EDITOR);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_MODULE, BOX_THEMES_THEME_MODULE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>