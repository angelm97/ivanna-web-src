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
$heading[] = array('text'  =>BOX_HEADING_SEO,
                   'link'  => FILENAME_ADMIN1_ADMIN_SEO.'?selected_box=seo',
                   'default_row'=>(($_SESSION['selected_box'] == 'seo') ?'1':''),
                   'text_image'=>'<i class="fas fa-chart-line admin-left-icon"></i>',
                  );
if ($_SESSION['selected_box'] == 'seo')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_SEO, BOX_SEO_SETTING);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_TITLE_METAKEYWORDS, BOX_SEO_TITLE_METAKEYWORDS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_SEARCH_TAGS, BOX_SEO_SEARCH_TAGS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_SKILL_TAGS, BOX_SEO_SKILL_TAGS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_SITE_MAP, BOX_SEO_SITE_MAP);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_GOOGLE_ANALYTICS, BOX_SEO_GOOGLE_ANALYTICS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_PAGE_RANK,BOX_SEO_PAGE_RANK);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>