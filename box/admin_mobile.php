<?
/*
***********************************************************
**********# Name          : Shambhu Prasad Patnaik #*******
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2011  #**********
***********************************************************
*/
$heading = array();
$contents = array();
$heading[] = array('text'  => BOX_HEADING_MOBILE,
																			'link'  => FILENAME_ADMIN1_MOBILE_THEMES."?selected_box=mobile",
                   'default_row'=>(($_SESSION['selected_box'] == 'mobile') ?'1':''),
                   'text_image'=>'<i class="fas fa-mobile-alt admin-left-icon"></i>',
                   );

if($_SESSION['selected_box'] == 'mobile')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $row_logo=getAnyTableWhereData(CONFIGURATION_TABLE,"configuration_name='MOBILE_SITE_LOGO'","id");
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_CONFIGURATION,BOX_MOBILE_LOGO,'gid=1&id='.$row_logo['id'].'&action=edit');
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_MOBILE_THEMES, BOX_MOBILE_THEMES);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }

 $content=tep_admin_files_boxes(FILENAME_ADMIN1_THEME_APPEARANCE_SETTING,BOX_THEMES_THEME_APPEARANCE);
 if(tep_not_null($content))
 {
  if(file_exists(PATH_TO_MAIN_PHYSICAL_THEMES.MODULE_MOBILE_THEME_DEFAULT_THEME.'/cms_themes_functions.php'))
  {
   include_once(PATH_TO_MAIN_PHYSICAL_THEMES.MODULE_MOBILE_THEME_DEFAULT_THEME.'/cms_themes_functions.php');
   if(function_exists('cms_add_admin_menu_content'))
   {
    $menu_content=cms_add_admin_menu_content();
    if(is_array($menu_content))
    {
     foreach($menu_content as $content)
     $contents[] = array('text'=>$blank_space.$content);
    }
    else
     $contents[] = array('text'=>$blank_space.$menu_content);
   }
  }
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_MOBILE_THEME_EDITOR, BOX_MOBILE_THEME_EDITOR);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>