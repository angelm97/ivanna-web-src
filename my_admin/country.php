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
include_once(PATH_TO_MAIN_ADMIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_ADMIN1_ADMIN_COUNTRY);
$template->set_filenames(array('country' => 'country.htm'));
include_once(FILENAME_ADMIN_BODY);

$action = (isset($_GET['action']) ? $_GET['action'] : '');

if ($action!="")
{
 switch ($action)
	{
  case 'confirm_delete':
   $id = tep_db_prepare_input($_GET['id']);
   tep_db_query("delete from " . COUNTRIES_TABLE . " where id = '" . (int)$id . "'");
			$messageStack->add_session(MESSAGE_SUCCESS_DELETED, 'success');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'page=' . $_GET['page']));
  break;
  case 'insert':
  case 'save':
   $continent_name = tep_db_prepare_input($_POST['TR_continent_name']);
   $country_name   = tep_db_prepare_input($_POST['TR_country_name']);
			$es_country_name= tep_db_prepare_input($_POST['TR_es_country_name']);
			$country_code   = tep_db_prepare_input($_POST['country_code']);
   $priority = tep_db_prepare_input($_POST['IN_priority']);
   $sql_data_array['continent_id'] = $continent_name;
   $sql_data_array['country_name'] = $country_name;
			$sql_data_array['es_country_name'] = $es_country_name;
   $sql_data_array['country_code'] = $country_code;
   $sql_data_array['priority'] = $priority;

			if($action=='insert')
			{
				if($row_chek=getAnyTableWhereData(COUNTRIES_TABLE,"country_name='".tep_db_input($country_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				else if($row_chek=getAnyTableWhereData(COUNTRIES_TABLE,"es_country_name='".tep_db_input($es_country_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_FR_NAME_ERROR, 'error');
				}
				else
				{
     tep_db_perform(COUNTRIES_TABLE, $sql_data_array);
     $row_id_check=getAnyTableWhereData(COUNTRIES_TABLE,"1 order by id desc limit 0,1","id");
     $id = $row_id_check['id'];
  			$messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_COUNTRY);
				}
			}
			else
			{
    $id=(int)$_GET['id'];
				if($row_chek=getAnyTableWhereData(COUNTRIES_TABLE,"country_name='".tep_db_input($country_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
					$action='edit';
				}
				else if($row_chek=getAnyTableWhereData(COUNTRIES_TABLE,"es_country_name='".tep_db_input($es_country_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_FR_NAME_ERROR, 'error');
					$action='edit';
				}
				else
				{
     tep_db_perform(COUNTRIES_TABLE, $sql_data_array, 'update', "id = '" . (int)$id . "'");
  			$messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_COUNTRY.'?page='.$_GET['page'].'&id='.$id);
				}
			}
  break;
 }
}
///////////// Middle Values
$country_query_raw="select c.id, c.continent_id, cont.continent_name, c.country_name, c.es_country_name,c.country_code,c.priority from " . COUNTRIES_TABLE ." as c left join ".CONTINENT_TABLE." as cont on (c.continent_id=cont.id) order by c.country_name";
$country_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $country_query_raw, $country_query_numrows);
$country_query = tep_db_query($country_query_raw);
if(tep_db_num_rows($country_query) > 0)
{
 $alternate=1;
 while ($country = tep_db_fetch_array($country_query))
 {
  if ((!isset($_GET['id']) || (isset($_GET['id']) && ($_GET['id'] == $country['id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new'))
  {
   $cInfo = new objectInfo($country);
  }
  if ( (isset($cInfo) && is_object($cInfo)) && ($country['id'] == $cInfo->id) )
  {
   $row_selected=' id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_ADMIN_COUNTRY . '?page='.$_GET['page'].'&id=' . $cInfo->id . '&action=edit\'"';
  }
  else
  {
   $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_ADMIN_COUNTRY . '?page='.$_GET['page'].'&id=' . $country['id'] . '\'"';
  }
  $alternate++;
  if ( (isset($cInfo) && is_object($cInfo)) && ($country['id'] == $cInfo->id) )
  {
   $action_image=tep_image(PATH_TO_IMAGE.'icon_arrow_right.gif',IMAGE_EDIT);
  }
  else
  {
   $action_image='<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'page='.$_GET['page'].'&id=' . $country['id']) . '">'.tep_image(PATH_TO_IMAGE.'icon_info.gif',IMAGE_INFO).'</a>';
  }
  $template->assign_block_vars('country', array( 'row_selected' => $row_selected,
   'action' => $action_image,
   'country_name' => tep_db_output($country['country_name']),
   'es_country_name' => tep_db_output($country['es_country_name']),
   'continent_name' => tep_db_output($country['continent_name']),
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
 case 'insert':
 case 'save':
		$heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_COUNTRY.'</b>');
  $contents = array('form' => tep_draw_form('country', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'action=insert','post',' onsubmit="return ValidateForm(this)"'));
		$contents[] = array('text' => TEXT_INFO_NEW_INTRO);
		$contents[] = array('text' => '<br>'.TEXT_INFO_CONTINENT_NAME.'<br>'.LIST_TABLE(CONTINENT_TABLE, 'continent_name', 'continent_name', 'name="TR_continent_name"', '', '' ,$_POST['TR_continent_name']));
		$contents[] = array('text' => '<br>'.TEXT_INFO_COUNTRY_NAME.'<br>'.tep_draw_input_field('TR_country_name', $_POST['TR_country_name'], '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_FR_COUNTRY_NAME.'<br>'.tep_draw_input_field('TR_es_country_name', $_POST['TR_es_country_name'], '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_COUNTRY_CODE.'<br>'.tep_draw_input_field('country_code', $_POST['country_code'], '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_COUNTRY_PRIORITY.'<br>'.tep_draw_input_field('IN_priority', $_POST['IN_priority'], '' ));
		$contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_insert.gif', IMAGE_INSERT).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL).'</a>');
  break;
 case 'edit':
  $value_field=tep_draw_input_field('TR_country_name', $cInfo->country_name, '' );
  $heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_COUNTRY.'</b>');
  $contents = array('form' => tep_draw_form('country', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'id=' . $cInfo->id.'&page='.$_GET['page'].'&action=save','post',' onsubmit="return ValidateForm(this)"'));
		$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
		$contents[] = array('text' => '<br>'.TEXT_INFO_CONTINENT_NAME.'<br>'.LIST_TABLE(CONTINENT_TABLE, 'continent_name', 'continent_name', 'name="TR_continent_name"', '', '' ,$cInfo->continent_id));
		$contents[] = array('text' => '<br>'.TEXT_INFO_COUNTRY_NAME.'<br>'.tep_draw_input_field('TR_country_name', $cInfo->country_name, '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_FR_COUNTRY_NAME.'<br>'.tep_draw_input_field('TR_es_country_name', $cInfo->es_country_name, '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_COUNTRY_CODE.'<br>'.tep_draw_input_field('country_code', $cInfo->country_code, '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_COUNTRY_PRIORITY.'<br>'.tep_draw_input_field('IN_priority', $cInfo->priority, '' ));
  $contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_update.gif',IMAGE_UPDATE).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'gid=' . $_GET['gid'] . '&id=' . $cInfo->id ). '">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif',IMAGE_CANCEL).'</a>');
  break;
 case 'delete':
  $heading[] = array('text' => '<b>' . $cInfo->country_name . '</b>');
  $contents = array('form' => tep_draw_form('country_delete', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'page=' . $_GET['page'] . '&id=' . $nInfo->id . '&action=deleteconfirm'));
  $contents[] = array('text' => TEXT_DELETE_INTRO);
  $contents[] = array('text' => '<br><b>' . $cInfo->country_name . '</b>');
  $contents[] = array('align' => 'center', 'text' => '
  <table>
   <tr>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'page=' . $_GET['page'] . '&id=' . $_GET['id'].'&action=confirm_delete') . '">'.tep_image_button(PATH_TO_BUTTON.'button_confirm.gif', IMAGE_CONFIRM).'</a>
   </td>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'page=' . $_GET['page'] . '&id=' . $_GET['id']) . '">' . tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL) . '</a>
   </td>
   </tr>
   </table>
  ');
 break;
 default:
  if (isset($cInfo) && is_object($cInfo))
		{
   $heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_COUNTRY.'</b>');
   $contents[] = array('text' => tep_db_output($cInfo->country_name));
   $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'page=' . $_GET['page'] .'&id=' . $cInfo->id . '&action=edit') . '">'.tep_image_button(PATH_TO_BUTTON.'button_edit.gif',IMAGE_EDIT).'</a>&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'page=' . $_GET['page'] .'&id=' . $cInfo->id . '&action=delete') . '">'.tep_image_button(PATH_TO_BUTTON.'button_delete.gif',IMAGE_DELETE).'</a>');
   $contents[] = array('text' => '<br>'.TEXT_INFO_ACTION);
  }
  break;
}
if((tep_not_null($heading)) && (tep_not_null($contents)) )
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
	'TABLE_HEADING_FR_COUNTRY_NAME'=>TABLE_HEADING_FR_COUNTRY_NAME,
 'TABLE_HEADING_CONTINENT_NAME'=>TABLE_HEADING_CONTINENT_NAME,
 'TABLE_HEADING_ACTION'=>TABLE_HEADING_ACTION,
 'count_rows'=>$country_split->display_count($country_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_COUNTRIES),
 'no_of_pages'=>$country_split->display_links($country_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']),
 'new_button'=>'<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_COUNTRY, 'page=' . $_GET['page'] .'&action=new') . '">'.tep_image_button(PATH_TO_BUTTON.'button_new.gif',IMAGE_NEW).'</a>&nbsp;&nbsp;',
 'HEADING_TITLE'=>HEADING_TITLE,
 'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH,
 'ADMIN_RIGHT_HTML'=>$ADMIN_RIGHT_HTML,
 'update_message'=>$messageStack->output()));
$template->pparse('country');
?>