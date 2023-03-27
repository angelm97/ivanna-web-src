<?
/*
***********************************************************
**********# Name          : Shambhu Prasad Patnaik #*******
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2011  #**********
***********************************************************
*/
include_once("../include_files.php");
include_once("../general_functions/theme_functions.php");
include_once(PATH_TO_MAIN_ADMIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_ADMIN1_MOBILE_THEMES);
$template->set_filenames(array('themes' => 'admin1_mobile_themes.htm'));
include_once(FILENAME_ADMIN_BODY);
$action = (isset($_POST['action']) ? $_POST['action'] : '');
$page   = (isset($_GET['page']) ? $_GET['page'] : 1);

if($action!="")
{
 switch ($action)
	{
  case 'set_default':
   $theme_name = tep_db_prepare_input($_POST['theme_name']);
   if($theme_name=='')
   $theme_name=MODULE_MOBILE_THEME_DEFAULT_THEME;
   if(check_theme_info(PATH_TO_MAIN_PHYSICAL_THEMES.$theme_name))
   {
    $template_file = PATH_TO_MAIN_PHYSICAL_THEMES.$theme_name.'/text.htm';
    $handle = fopen($template_file, "r");
    $contents = fread($handle, filesize($template_file));
    fclose($handle);

    /// create a template file  starts //
    $handle = fopen(PATH_TO_MAIN_PHYSICAL_MOBILE.PATH_TO_TEMPLATE.'text.htm', "w");
    fwrite($handle,stripslashes($contents));
    fclose($handle);
    /// create a template file  ends //
    if(MODULE_MOBILE_THEME_DEFAULT_THEME!=$theme_name)
    {
     $old_theme_name=MODULE_MOBILE_THEME_DEFAULT_THEME;
     if(MODULE_MOBILE_THEME_DEFAULT_THEME !=MODULE_THEME_DEFAULT_THEME)
     if(file_exists(PATH_TO_MAIN_PHYSICAL_THEMES.MODULE_MOBILE_THEME_DEFAULT_THEME.'/theme_configuration.php'))
     {
      include_once(PATH_TO_MAIN_PHYSICAL_THEMES.MODULE_MOBILE_THEME_DEFAULT_THEME.'/theme_configuration.php');
      $class_name='theme_'.MODULE_MOBILE_THEME_DEFAULT_THEME;
      if(class_exists($class_name))
      {
       $obj=new $class_name;
       if(method_exists($obj,'remove_theme'))
       $obj->remove_theme();
      }
     }
     if(MODULE_THEME_DEFAULT_THEME!=$theme_name )
     if(file_exists(PATH_TO_MAIN_PHYSICAL_THEMES.$theme_name.'/theme_configuration.php'))
     {
      include_once(PATH_TO_MAIN_PHYSICAL_THEMES.$theme_name.'/theme_configuration.php');
      $class_name='theme_'.$theme_name;

      if(class_exists($class_name))
      {
       $obj = new $class_name;
       if(method_exists($obj,'install_theme'))
       $obj->install_theme();
      }
     }
     ////////////////////////////////
    }
    tep_db_query("update ".CONFIGURATION_TABLE." set configuration_value='".tep_db_input($theme_name)."' where configuration_name='MODULE_MOBILE_THEME_DEFAULT_THEME'");
    $messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
    tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_MOBILE_THEMES,tep_get_all_get_params(array('action','selected_box'))));
   }
   else
   {
    $messageStack->add(INVALID_THEME, 'error');
   }
   break;

 }
}


 $themes_array =get_themes();
 $themes        =  $themes_array['theme'];
 $mobile_themes =array();

 $theme_directory=(array_keys($themes));
 $default_theme=MODULE_MOBILE_THEME_DEFAULT_THEME;
 $i=0;
 $new_theme_array=array();
 $show_default_theme_array=array();
 foreach($theme_directory as $theme)
 {
  $rows=$themes[$theme];
  if($rows['feature']!='mobile-theme')
   continue;
  if($theme==$default_theme)
  $default_theme_id=1;
  else
  $default_theme_id=0;
  ////////////////
  if($default_theme_id)
  {
   $row_selected=' class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"';
  }
  else
   $row_selected=' class="dataTableRow'.($i%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)"';
  ///////////////////
 // $screenshot         = tep_not_null(!$rows['screenshot'])?'':'<a  onclick="show_image(\''.tep_href_link(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme.'/'.$rows['screenshot']."&size=300").'\')" title="click me for large view">'.tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme.'/'.$rows['screenshot']."&size=240").'</a>';
  $screenshot = tep_not_null(!$rows['screenshot'])?'':tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme.'/'.$rows['screenshot']."&size=140");
  //$screenshot1         = tep_not_null(!$rows['screenshot'])?'':'<a onclick="show_image(\''.tep_href_link(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme.'/'.$rows['screenshot']."&size=350").'\')" title="click me for large view">'.tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme.'/'.$rows['screenshot']."&size=320",'','','','id="default_main_screenshot"').'</a>';
$screenshot1         = tep_not_null(!$rows['screenshot'])?'':tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme.'/'.$rows['screenshot']."&size=220",'','','','id="default_main_screenshot"');
  $theme_scree_name   = tep_db_output($rows['name']);
  $theme_dir_name     = 'themes/'.tep_db_output($theme);
  $theme_description  = stripslashes($rows['description']);
  $theme_version      = tep_db_output($rows['version']);
  $theme_radio_button = tep_draw_radio_field('theme_name',$theme,'',$default_theme);

  if($default_theme_id)
  $show_default_theme_array= array('id'=>$theme,'default_theme'=>$default_theme_id,'row_selected' =>$row_selected,'screenshot' => $screenshot1,'theme_scree_name'=>$theme_scree_name,'theme_dir_name'=>$theme_dir_name,'theme_description'=>$theme_description,'theme_version'=>$theme_version,'theme_radio_button' =>$theme_radio_button);
  $new_theme_array[]       = array('id'=>$theme,'default_theme'=>$default_theme_id,'row_selected' =>$row_selected,'screenshot' => $screenshot,'theme_scree_name'=>$theme_scree_name,'theme_dir_name'=>$theme_dir_name,'theme_description'=>$theme_description,'theme_version'=>$theme_version,'theme_radio_button' =>$theme_radio_button);
  $i++;
 }
 $total_themes=count($new_theme_array);
 ////////////------- PAGING ------////////////
 for($i=0;$i<$total_themes;$i++)
 {
  $template->assign_block_vars('themes', array( 'row_selected' => $new_theme_array[$i]['row_selected'],
  'screenshot' =>$new_theme_array[$i]['screenshot'],
  'directory' =>$new_theme_array[$i]['theme_dir_name'],
  'name' =>$new_theme_array[$i]['theme_scree_name'],
  'description' =>$new_theme_array[$i]['theme_description'],
  'version' =>$new_theme_array[$i]['theme_version'],
  'radio_button' =>$new_theme_array[$i]['theme_radio_button'],
  ));
 }
 ////////////------- PAGING ------////////////
 //////////
if($total_themes>0)
{
 $screenshot_array =get_site_theme_screen($show_default_theme_array['theme_dir_name']);
 $theme_id=$show_default_theme_array['id'];
 if(is_array($screenshot_array))
 {
  sort($screenshot_array);
 }
 $addtional_screenshots='';
 if(count($screenshot_array)>1)
 {
  foreach($screenshot_array as $image)
  {
   //$addtional_screenshots.=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme_id.'/'.$image."&size=120",'click me for  large view','','','class="theme_screenshots_addtional" onclick="show_screenshot(\''.tep_href_link(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme_id.'/'.$image."&size=350").'\');"').' ';
   $addtional_screenshots.=tep_image(FILENAME_IMAGE."?image_name=".PATH_TO_THEMES."/".$theme_id.'/'.$image."&size=120",'','','','class="theme_screenshots_addtional"');
  }
 }
 $template->assign_vars(array(
   'CURRENT_THEME_SCREENSHOT1' => $addtional_screenshots,
   'CURRENT_THEME_SCREENSHOT' => $show_default_theme_array['screenshot'],
   'CURRENT_THEME_NAME'       => $show_default_theme_array['theme_scree_name'],
   'CURRENT_THEME_DIRECTORY'  => $show_default_theme_array['theme_dir_name'],
   'CURRENT_THEME_DESCRIPTION'=> $show_default_theme_array['theme_description'],
   'CURRENT_THEME_VERSION'    => $show_default_theme_array['theme_version'],
  ));
}

/////
$template->assign_vars(array(
 'HEADING_TITLE'                => HEADING_TITLE,
 'TABLE_HEADING_THEME_NAME'     => TABLE_HEADING_THEME_NAME,
 'TABLE_HEADING_THEME_VERSION'  => TABLE_HEADING_THEME_VERSION,
 'TABLE_HEADING_THEME_DEFAULT'  => TABLE_HEADING_THEME_DEFAULT,
 'TABLE_HEADING_THEME_ERROR'    => TABLE_HEADING_THEME_ERROR,
 'INFO_TEXT_THEMES_STYLE'       => ($total_themes>0)?'':'style="display:none"',
 'INFO_TEXT_VIEW_MOBILE_SITE'=> '<a href="'.tep_href_link('mobile/').'" target="_blank">'.INFO_TEXT_VIEW_MOBILE_SITE.'</a>',
 'theme_form'   => tep_draw_form('thems', PATH_TO_ADMIN.FILENAME_ADMIN1_MOBILE_THEMES,'','post',' onsubmit="return ValidateForm(this)"').tep_draw_hidden_field('action','set_default'),
 'button'       => tep_draw_submit_button_field('','Save','class="btn btn-secondary"'),//tep_image_submit(PATH_TO_BUTTON.'button_save.gif',IMAGE_SAVE),
 'update_message'=>$messageStack->output()));
$template->pparse('themes');
?>