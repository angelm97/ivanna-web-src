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
include_once("../include_files.php");
include_once(PATH_TO_MAIN_ADMIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_ADMIN1_ADMIN_ZONE);
$template->set_filenames(array('zones' => 'zones.htm'));
include_once(FILENAME_ADMIN_BODY);

$action = (isset($_GET['action']) ? $_GET['action'] : '');

if (tep_not_null($action))
{
 switch ($action)
 {
  case 'insert':
   $zone_country_id = tep_db_prepare_input($_POST['zone_country_id']);
   $zone_code = tep_db_prepare_input($_POST['zone_code']);
   $zone_name = tep_db_prepare_input($_POST['zone_name']);
   $es_zone_name = tep_db_prepare_input($_POST['es_zone_name']);
   tep_db_query("insert into " . ZONES_TABLE . " (zone_country_id, zone_code, zone_name,es_zone_name) values ('" . (int)$zone_country_id . "', '" . tep_db_input($zone_code) . "', '" . tep_db_input($zone_name) . "','" . tep_db_input($es_zone_name) . "')");
			$messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE));
  break;
  case 'save':
   $zone_id = tep_db_prepare_input($_GET['zID']);
   $zone_country_id = tep_db_prepare_input($_POST['zone_country_id']);
   $zone_code = tep_db_prepare_input($_POST['zone_code']);
   $zone_name = tep_db_prepare_input($_POST['zone_name']);
			$es_zone_name = tep_db_prepare_input($_POST['es_zone_name']);

   tep_db_query("update " . ZONES_TABLE . " set zone_country_id = '" . (int)$zone_country_id . "', zone_code = '" . tep_db_input($zone_code) . "', zone_name = '" . tep_db_input($zone_name) . "' , es_zone_name = '" . tep_db_input($es_zone_name) . "' where zone_id = '" . (int)$zone_id . "'");
			$messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zone_id));
  break;
  case 'deleteconfirm':
   $zone_id = tep_db_prepare_input($_GET['zID']);
   tep_db_query("delete from " . ZONES_TABLE . " where zone_id = '" . (int)$zone_id . "'");
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page']));
  break;
 }
}
///////////// Middle Values
$zones_query_raw = "select z.zone_id, c.id, c.country_name, z.zone_name , z.es_zone_name , z.zone_code, z.zone_country_id from " . ZONES_TABLE . " z, " . COUNTRIES_TABLE . " c where z.zone_country_id = c.id order by c.country_name, z.zone_name";
$zones_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $zones_query_raw, $zones_query_numrows);
$zones_query = tep_db_query($zones_query_raw);
if(tep_db_num_rows($zones_query) > 0)
{
 $alternate=1;
 while ($zones = tep_db_fetch_array($zones_query))
 {
  if ((!isset($_GET['zID']) || (isset($_GET['zID']) && ($_GET['zID'] == $zones['zone_id']))) && !isset($zInfo) && (substr($action, 0, 3) != 'new'))
  {
   $zInfo = new objectInfo($zones);
  }
  if (isset($zInfo) && is_object($zInfo) && ($zones['zone_id'] == $zInfo->zone_id))
  {
   $row_selected=' id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zInfo->zone_id . '&action=edit') . '\'"';
  }
  else
  {
   $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zones['zone_id']) . '\'"';
  }
  $alternate++;
  if ( (isset($zInfo) && is_object($zInfo)) && ($zones['zone_id'] == $zInfo->zone_id) )
  {
   $action_image=tep_image(PATH_TO_IMAGE.'icon_arrow_right.gif',IMAGE_EDIT);
  }
  else
  {
   $action_image='<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page='.$_GET['page'].'&zID=' . $zones['zone_id']) . '">'.tep_image(PATH_TO_IMAGE.'icon_info.gif',IMAGE_INFO).'</a>';
  }
  $template->assign_block_vars('zones', array( 'row_selected' => $row_selected,
   'action' => $action_image,
   'country_name' => tep_db_output($zones['country_name']),
   'zone_name' => tep_db_output($zones['zone_name']),
   'es_zone_name' => tep_db_output($zones['es_zone_name']),
   'zone_code' => tep_db_output($zones['zone_code']),
   'row_selected' => $row_selected
   ));
 }
}
//// for right side
$ADMIN_RIGHT_HTML="";

$heading = array();
$contents = array();
switch ($action)
{
 case 'new':
  $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_ZONE . '</b>');
  $contents = array('form' => tep_draw_form('zones', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&action=insert'));
  $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
  $contents[] = array('text' => '<br>' . TEXT_INFO_ZONES_NAME . '<br>' . tep_draw_input_field('zone_name'));
  $contents[] = array('text' => '<br>' . TEXT_INFO_FR_ZONES_NAME . '<br>' . tep_draw_input_field('es_zone_name'));
  $contents[] = array('text' => '<br>' . TEXT_INFO_ZONES_CODE . '<br>' . tep_draw_input_field('zone_code'));
  $contents[] = array('text' => '<br>' . TEXT_INFO_COUNTRY_NAME . '<br>' . tep_draw_pull_down_menu('zone_country_id', tep_get_countries()));
  $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit(PATH_TO_BUTTON.'button_insert.gif', IMAGE_INSERT) . '&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page']) . '">' . tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL) . '</a>');
 break;
 case 'edit':
  $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_ZONE . '</b>');
  $contents = array('form' => tep_draw_form('zones', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zInfo->zone_id . '&action=save'));
  $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
  $contents[] = array('text' => '<br>' . TEXT_INFO_ZONES_NAME . '<br>' . tep_draw_input_field('zone_name', $zInfo->zone_name));
  $contents[] = array('text' => '<br>' . TEXT_INFO_FR_ZONES_NAME . '<br>' . tep_draw_input_field('es_zone_name', $zInfo->es_zone_name));
  $contents[] = array('text' => '<br>' . TEXT_INFO_ZONES_CODE . '<br>' . tep_draw_input_field('zone_code', $zInfo->zone_code));
  $contents[] = array('text' => '<br>' . TEXT_INFO_COUNTRY_NAME . '<br>' . tep_draw_pull_down_menu('zone_country_id', tep_get_countries(), $zInfo->id));
  $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit(PATH_TO_BUTTON.'button_update.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zInfo->zone_id) . '">' . tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL) . '</a>');
 break;
 case 'delete':
  $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ZONE . '</b>');
  $contents = array('form' => tep_draw_form('zones', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zInfo->zone_id . '&action=deleteconfirm'));
  $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
  $contents[] = array('text' => '<br><b>' . $zInfo->zone_name . '</b>');
  $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit(PATH_TO_BUTTON.'button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zInfo->zone_id) . '">' . tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL) . '</a>');
 break;
 default:
  if (isset($zInfo) && is_object($zInfo))
  {
   $heading[] = array('text' => '<b>' . $zInfo->zone_name . '</b>');
   $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zInfo->zone_id . '&action=edit') . '">' . tep_image_button(PATH_TO_BUTTON.'button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] . '&zID=' . $zInfo->zone_id . '&action=delete') . '">' . tep_image_button(PATH_TO_BUTTON.'button_delete.gif', IMAGE_DELETE) . '</a>');
   $contents[] = array('text' => '<br>' . TEXT_INFO_ZONES_NAME . '<br>' . $zInfo->zone_name . ' (' . $zInfo->zone_code . ')');
   $contents[] = array('text' => '<br>' . TEXT_INFO_COUNTRY_NAME . ' ' . $zInfo->country_name);
  }
 break;
}
if ( (tep_not_null($heading)) && (tep_not_null($contents)) )
{
 $box = new right_box;
 $ADMIN_RIGHT_HTML.= $box->infoBox($heading, $contents);
	$RIGHT_BOX_WIDTH=RIGHT_BOX_WIDTH;
}
else
{
	$RIGHT_BOX_WIDTH='0';
}
/////
$template->assign_vars(array(
 'TABLE_HEADING_COUNTRY_NAME'=>TABLE_HEADING_COUNTRY_NAME,
 'TABLE_HEADING_ZONE_NAME'=>TABLE_HEADING_ZONE_NAME,
 'TABLE_HEADING_FR_ZONE_NAME'=>TABLE_HEADING_FR_ZONE_NAME,
 'TABLE_HEADING_ZONE_CODE'=>TABLE_HEADING_ZONE_CODE,
 'TABLE_HEADING_ACTION'=>TABLE_HEADING_ACTION,
 'count_rows'=>$zones_split->display_count($zones_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ZONES),
 'no_of_pages'=>$zones_split->display_links($zones_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']),
 'new_button'=>'<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ZONE, 'page=' . $_GET['page'] .'&action=new') . '">'.tep_image_button(PATH_TO_BUTTON.'button_new.gif',IMAGE_NEW).'</a>&nbsp;&nbsp;',
 'HEADING_TITLE'=>HEADING_TITLE,
 'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH,
 'ADMIN_RIGHT_HTML'=>$ADMIN_RIGHT_HTML,
 'update_message'=>$messageStack->output()));
$template->pparse('zones');
?>