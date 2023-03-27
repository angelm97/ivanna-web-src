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
$heading[] = array('text'  => BOX_HEADING_CONFIGURATION,
																			'link'  => FILENAME_ADMIN1_CONFIGURATION."?selected_box=configuration&gid=1",
                   'default_row'=>(($_SESSION['selected_box'] == 'configuration') ?'1':''),
                   'text_image'=>'<i class="fas fa-clipboard-check admin-left-icon"></i>',
                   );

if ($_SESSION['selected_box'] == 'configuration')
{
 $blank_space='&nbsp;&nbsp;&nbsp;<img src="../img/red_aero.gif">&nbsp;';
	$cfg_groups = '';
	$configuration_groups_query = tep_db_query("select id, configuration_group_title from ".CONFIGURATION_GROUP_TABLE." where visible = 'Yes' order by priority");
	while ($configuration_groups = tep_db_fetch_array($configuration_groups_query))
	{
		$contents[] = array('text' => $blank_space.'<a href="'.tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_CONFIGURATION,'gid='.$configuration_groups['id']).'">' . $configuration_groups['configuration_group_title'] . '</a>');
	}
}
$box = new left_box;
$LEFT_HTML.=$box->menuBox($heading, $contents);
?>