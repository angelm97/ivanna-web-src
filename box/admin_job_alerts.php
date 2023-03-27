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
$heading[] = array('link'  =>FILENAME_ADMIN1_JOBALERTS.'?selected_box=job_alerts',
                   'text'  =>BOX_HEADING_JOBALERTS,
                   'default_row'=>(($_SESSION['selected_box'] == 'jobalerts') ?'1':''),
                   'text_image'=>'<i class="fas fa-envelope admin-left-icon"></i>',
                  );

if ($_SESSION['selected_box'] == 'job_alerts')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
 $content=tep_admin_files_boxes(FILENAME_ADMIN1_JOBALERTS, BOX_JOBALERTS);
 if(tep_not_null($content))
 {
	 $contents[] = array('text'=>$blank_space.$content);
 }
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>