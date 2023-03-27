<?
include_once("../include_files.php");
include_once(PATH_TO_MAIN_ADMIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL);
$template->set_filenames(array('education_level' => 'education_level.htm'));
include_once(FILENAME_ADMIN_BODY);

$action = (isset($_GET['action']) ? $_GET['action'] : '');

if ($action!="")
{
 switch ($action)
	{
  case 'confirm_delete':
   $id = tep_db_prepare_input($_GET['id']);
   tep_db_query("delete from " . EDUCATION_LEVEL_TABLE . " where id = '" . (int)$id . "'");
			$messageStack->add_session(MESSAGE_SUCCESS_DELETED, 'success');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'page=' . $_GET['page']));
  break;
  case 'insert':
  case 'save':
   $education_level_name=tep_db_prepare_input($_POST['TR_education_level_name']);
   $es_education_level_name=tep_db_prepare_input($_POST['TR_es_education_level_name']);
   $priority = tep_db_prepare_input($_POST['IN_priority']);
   $sql_data_array['education_level_name'] = $education_level_name;
   $sql_data_array['es_education_level_name'] = $es_education_level_name;
   $sql_data_array['priority'] = $priority;

			if($action=='insert')
			{
				if($row_chek=getAnyTableWhereData(EDUCATION_LEVEL_TABLE,"education_level_name='".tep_db_input($education_level_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				else if($row_chek=getAnyTableWhereData(EDUCATION_LEVEL_TABLE,"es_education_level_name='".tep_db_input($es_education_level_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_FR_NAME_ERROR, 'error');
				}
				else
				{
     tep_db_perform(EDUCATION_LEVEL_TABLE, $sql_data_array);
  			$messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL);
				}
			}
			else
			{
    $id=(int)$_GET['id'];
				if($row_chek=getAnyTableWhereData(EDUCATION_LEVEL_TABLE,"education_level_name='".tep_db_input($education_level_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
					$action='edit';
				}
				else if($row_chek=getAnyTableWhereData(EDUCATION_LEVEL_TABLE,"es_education_level_name='".tep_db_input($es_education_level_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_FR_NAME_ERROR, 'error');
					$action='edit';
				}
				else
				{
     tep_db_perform(EDUCATION_LEVEL_TABLE, $sql_data_array, 'update', "id = '" . (int)$id . "'");
  			$messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL.'?page='.$_GET['page'].'&id='.$id);
				}
			}
  break;
 }
}
///////////// Middle Values
$education_level_query_raw="select id, education_level_name,es_education_level_name,priority from " . EDUCATION_LEVEL_TABLE ." order by priority";
$education_level_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $education_level_query_raw, $education_level_query_numrows);
$education_level_query = tep_db_query($education_level_query_raw);
if(tep_db_num_rows($education_level_query) > 0)
{
 $alternate=1;
 while ($education_level = tep_db_fetch_array($education_level_query))
 {
  if ((!isset($_GET['id']) || (isset($_GET['id']) && ($_GET['id'] == $education_level['id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new'))
  {
   $cInfo = new objectInfo($education_level);
  }
  if ( (isset($cInfo) && is_object($cInfo)) && ($education_level['id'] == $cInfo->id) )
  {
   $row_selected=' id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL . '?page='.$_GET['page'].'&id=' . $cInfo->id . '&action=edit\'"';
  }
  else
  {
   $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL . '?page='.$_GET['page'].'&id=' . $education_level['id'] . '\'"';
  }
  $alternate++;
  if ( (isset($cInfo) && is_object($cInfo)) && ($education_level['id'] == $cInfo->id) )
  {
   $action_image=tep_image(PATH_TO_IMAGE.'icon_arrow_right.gif',IMAGE_EDIT);
  }
  else
  {
   $action_image='<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'page='.$_GET['page'].'&id=' . $education_level['id']) . '">'.tep_image(PATH_TO_IMAGE.'icon_info.gif',IMAGE_INFO).'</a>';
  }
  $template->assign_block_vars('education_level', array( 'row_selected' => $row_selected,
   'action' => $action_image,
   'name' => tep_db_output($education_level['education_level_name']),
   'es_name' => tep_db_output($education_level['es_education_level_name']),
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
		$heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_EDUCATION_LEVEL.'</b>');
  $contents = array('form' => tep_draw_form('education_level', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'action=insert','post',' onsubmit="return ValidateForm(this)"'));
		$contents[] = array('text' => TEXT_INFO_NEW_INTRO);
		$contents[] = array('text' => '<br>'.TEXT_INFO_EDUCATION_LEVEL_NAME.'<br>'.tep_draw_input_field('TR_education_level_name', $_POST['TR_education_level_name'], '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_FR_EDUCATION_LEVEL_NAME.'<br>'.tep_draw_input_field('TR_es_education_level_name', $_POST['TR_es_education_level_name'], '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_EDUCATION_LEVEL_PRIORITY.'<br>'.tep_draw_input_field('IN_priority', $_POST['IN_priority'], '' ));
		$contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_insert.gif', IMAGE_INSERT).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL).'</a>');
  break;
 case 'edit':
  $value_field=tep_draw_input_field('TR_education_level_name', $cInfo->education_level_name, '' );
  $heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_EDUCATION_LEVEL.'</b>');
  $contents = array('form' => tep_draw_form('education_level', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'id=' . $cInfo->id.'&page='.$_GET['page'].'&action=save','post',' onsubmit="return ValidateForm(this)"'));
		$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
		$contents[] = array('text' => '<br>'.TEXT_INFO_EDUCATION_LEVEL_NAME.'<br>'.tep_draw_input_field('TR_education_level_name', $cInfo->education_level_name, '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_FR_EDUCATION_LEVEL_NAME.'<br>'.tep_draw_input_field('TR_es_education_level_name', $cInfo->es_education_level_name, '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_EDUCATION_LEVEL_PRIORITY.'<br>'.tep_draw_input_field('IN_priority', $cInfo->priority, '' ));
  $contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_update.gif',IMAGE_UPDATE).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'gid=' . $_GET['gid'] . '&id=' . $cInfo->id ). '">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif',IMAGE_CANCEL).'</a>');
  break;
 case 'delete':
  $heading[] = array('text' => '<b>' . $cInfo->education_level_name . '</b>');
  $contents = array('form' => tep_draw_form('education_level_delete', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'page=' . $_GET['page'] . '&id=' . $nInfo->id . '&action=deleteconfirm'));
  $contents[] = array('text' => TEXT_DELETE_INTRO);
  $contents[] = array('text' => '<br><b>' . $cInfo->education_level_name . '</b>');
  $contents[] = array('align' => 'center', 'text' => '
  <table>
   <tr>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'page=' . $_GET['page'] . '&id=' . $_GET['id'].'&action=confirm_delete') . '">'.tep_image_button(PATH_TO_BUTTON.'button_confirm.gif', IMAGE_CONFIRM).'</a>
   </td>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'page=' . $_GET['page'] . '&id=' . $_GET['id']) . '">' . tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL) . '</a>
   </td>
   </tr>
   </table>
  ');
 break;
 default:
  if (isset($cInfo) && is_object($cInfo))
		{
   $heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_EDUCATION_LEVEL.'</b>');
   $contents[] = array('text' => tep_db_output($cInfo->education_level_name));
   $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'page=' . $_GET['page'] .'&id=' . $cInfo->id . '&action=edit') . '">'.tep_image_button(PATH_TO_BUTTON.'button_edit.gif',IMAGE_EDIT).'</a>&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'page=' . $_GET['page'] .'&id=' . $cInfo->id . '&action=delete') . '">'.tep_image_button(PATH_TO_BUTTON.'button_delete.gif',IMAGE_DELETE).'</a>');
   $contents[] = array('text' => '<br>'.TEXT_INFO_ACTION);
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
 'TABLE_HEADING_FR_EDUCATION_LEVEL_NAME'=>TABLE_HEADING_FR_EDUCATION_LEVEL_NAME,
 'TABLE_HEADING_EDUCATION_LEVEL_NAME'=>TABLE_HEADING_EDUCATION_LEVEL_NAME,
 'TABLE_HEADING_ACTION'=>TABLE_HEADING_ACTION,
 'count_rows'=>$education_level_split->display_count($education_level_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_EDUCATION_LEVEL),
 'no_of_pages'=>$education_level_split->display_links($education_level_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']),
 'new_button'=>'<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_EDUCATION_LEVEL, 'page=' . $_GET['page'] .'&action=new') . '">'.tep_image_button(PATH_TO_BUTTON.'button_new.gif',IMAGE_NEW).'</a>&nbsp;&nbsp;',
 'HEADING_TITLE'=>HEADING_TITLE,
 'RIGHT_BOX_WIDTH'=>$RIGHT_BOX_WIDTH,
 'ADMIN_RIGHT_HTML'=>$ADMIN_RIGHT_HTML,
 'update_message'=>$messageStack->output()));
$template->pparse('education_level');
?>