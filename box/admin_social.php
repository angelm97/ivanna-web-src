<?
/*
***********************************************************
**********# Name          : Shambhu Prasad Patnaik #*******
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2009  #**********
***********************************************************
*/
$heading = array();
$contents = array();
$heading[] = array('text'  =>BOX_HEADING_SOCIAL,
                   'link'  => FILENAME_ADMIN1_LINKEDIN_PLUGIN.'?selected_box=social',
                   'default_row'=>(($_SESSION['selected_box'] == 'social') ?'1':''),
                   'text_image'=>'<i class="fas fa-share-square admin-left-icon"></i>',
                  );
if ($_SESSION['selected_box'] == 'social')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
  $content=tep_admin_files_boxes(FILENAME_ADMIN1_LINKEDIN_PLUGIN, BOX_SETTING_LINKEDIN_PLUGIN);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_GOOGLE_PLUGIN, BOX_SETTING_GOOGLE_PLUGIN);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_FACEBOOK_PLUGIN, BOX_SETTING_FACEBOOK_PLUGIN);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 	$content=tep_admin_files_boxes(FILENAME_ADMIN1_TWITTER_TOOLS,BOX_SEO_TWITTER_SUBMITTER);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 	$content=tep_admin_files_boxes(FILENAME_ADMIN1_SOCIAL_FOOTER_LINKS,BOX_SOCIAL_FOOTER_LINKS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }

}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>