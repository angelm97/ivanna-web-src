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
$heading[] = array('text'  =>BOX_HEADING_RATE_CARD,
                   'link'  =>FILENAME_ADMIN1_ADMIN_PLAN_TYPE.'?selected_box=admin_rate_card',
                   'default_row'=>(($_SESSION['selected_box'] == 'admin_rate_card') ?'1':''),
                   'text_image'=>'<i class="fas fa-dollar-sign admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'admin_rate_card')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_PLAN_TYPE, BOX_RATE_CARD_PLAN);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_JOBSEEKER_PLAN_TYPE, BOX_SETTING_JOBSEEKER_PLAN_TYPE);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_ADMIN_MODULES, BOX_RATE_CARD_PAYMENT, 'set=payment');
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_COUPONS, BOX_HEADING_COUPON);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}

$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);

?>