<?
/*
***********************************************************
***********************************************************
**********# Name          : Shambhu Prasad Patnaik #*******
**********# Company       : Aynsoft             #**********
**********# Date Created  : 23/07/05            #**********
**********# Date Modified : 23/07/05            #**********
**********# Copyright (c) www.aynsoft.com 2005  #**********
***********************************************************
***********************************************************
*/
include_once("../include_files.php");
include_once(PATH_TO_MAIN_ADMIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_ADMIN1_TITLE_METAKEYWORDS);
$template->set_filenames(array('metakeyword' => 'admin1_title_metakeyword.htm',
                               'add_edit' => 'admin1_title_metakeyword1.htm'));
include_once(FILENAME_ADMIN_BODY);
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$file_id = (isset($_GET['fID']) ? tep_db_prepare_input($_GET['fID']) : '');
if(tep_not_null($file_id))
{
 if(!$row=getAnyTableWhereData(TITLE_KEYWORDMETATYPE_TABLE,"id='".(int)$file_id."'"))
 {
  tep_redirect(FILENAME_ADMIN1_TITLE_METAKEYWORDS);
 }
 else
 {
  $file_name=stripslashes($row['file_name']);
  $title=stripslashes($row['title']);
  $meta_keyword=stripslashes($row['meta_keyword']);
  $es_title=stripslashes($row['es_title']);
  $es_meta_keyword=stripslashes($row['es_meta_keyword']);
 }
}
if ($action!="")
{
 switch ($action)
	{
  case 'confirm_delete':
   tep_db_query("delete from " . TITLE_KEYWORDMETATYPE_TABLE . " where id='" . tep_db_input($file_id) . "'");
			$messageStack->add_session(MESSAGE_SUCCESS_DELETED, 'success');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS));
  break;
  case 'insert_file':
  case 'save_file':
   $file_name=tep_db_prepare_input($_POST['TR_file_name']);
   $sql_data_array['file_name']=$file_name;
   if($action=='insert_file')
   {
				if($row_chek=getAnyTableWhereData(TITLE_KEYWORDMETATYPE_TABLE,"file_name='".tep_db_input($file_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				else
				{
     $messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
     tep_db_perform(TITLE_KEYWORDMETATYPE_TABLE,$sql_data_array);
     tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS));
    }
   }
   elseif($action=='save_file')
   {
				if($row_chek=getAnyTableWhereData(TITLE_KEYWORDMETATYPE_TABLE,"file_name='".tep_db_input($file_name)."' and id!='".tep_db_input($fID)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				else
				{
     $messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
     tep_db_perform(TITLE_KEYWORDMETATYPE_TABLE, $sql_data_array,'update',"id='".tep_db_input($file_id)."'");
     tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS));
    }
   }
   break;
  case 'add_both':
  case 'add_title':
  case 'add_metakeyword':
  case 'edit_title':
  case 'edit_metakeyword':
  case 'edit_both':
  case 'insert':
  $middle_string='<tr><td class="label">'.INFO_TEXT_FILE_NAME.'</td><td>'.$file_name.'</td></tr>';
  $middle_string1='<tr><td class="label">'.INFO_TEXT_TITLE.'</td>';
  $middle_string1.="<td>".tep_draw_input_field('title', $title, 'size="45"', false).'</td></tr>';
  $middle_string1.='<tr><td class="label">'.INFO_TEXT_FR_TITLE.'</td>';
  $middle_string1.="<td>".tep_draw_input_field('es_title', $es_title, 'size="45"', false).'</td></tr>';
  $middle_string2='<tr><td class="label" colspan="2">'.INFO_TEXT_META_TAGS.'</td></tr>';
  $middle_string2.='<tr><td colspan="2">'.tep_draw_textarea_field('meta_keyword', 'soft', '90%', '10', $meta_keyword, '', true, true).'</td></tr>';
  $middle_string2.='<tr><td class="label" colspan="2">'.INFO_TEXT_FR_META_TAGS.'</td></tr>';
  $middle_string2.='<tr><td colspan="2">'.tep_draw_textarea_field('es_meta_keyword', 'soft', '90%', '10', $es_meta_keyword, '', true, true).'</td></tr>';
  if($action=='add_both' || $action=='edit_both')
  {
   $middle_string.=$middle_string1.$middle_string2;
  }
  else if($action=='add_title' || $action=='edit_title')
  {
   $middle_string.=$middle_string1;
  }
  else if($action=='add_metakeyword' || $action=='edit_metakeyword')
  {
   $middle_string.=$middle_string2;
  }
  if($action=='add_both' || $action=='add_title' || $action=='add_metakeyword')
  {
   $new_button=tep_image_submit(PATH_TO_BUTTON.'button_insert.gif',IMAGE_INSERT);
  }
  else
  {
   $new_button=tep_image_submit(PATH_TO_BUTTON.'button_update.gif',IMAGE_UPDATE);
  }
  $new_button.='&nbsp;<a href="'.tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif',IMAGE_CANCEL).'</a>';
  if($action=='insert')
  {
   $title=tep_db_prepare_input($_POST['title']);
   $meta_keyword=$_POST['meta_keyword'];
   $es_title=tep_db_prepare_input($_POST['es_title']);
   $es_meta_keyword=$_POST['es_meta_keyword'];
   if(isset($_POST['title']))
    $sql_data_array['title']=$title;
   if(isset($_POST['meta_keyword']))
    $sql_data_array['meta_keyword']=$meta_keyword;
   if(isset($_POST['es_title']))
    $sql_data_array['es_title']=$es_title;
   if(isset($_POST['es_meta_keyword']))
    $sql_data_array['es_meta_keyword']=$es_meta_keyword;
    tep_db_perform(TITLE_KEYWORDMETATYPE_TABLE, $sql_data_array,'update',"id='".tep_db_input($file_id)."'");
   tep_redirect(FILENAME_ADMIN1_TITLE_METAKEYWORDS);
  }
  break;
 }
}
///////////// Middle Values
$title_meta_query_raw="select * from " . TITLE_KEYWORDMETATYPE_TABLE ." order by file_name";
$title_meta_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $title_meta_query_raw, $title_meta_query_numrows);
$title_meta_query = tep_db_query($title_meta_query_raw);
if(tep_db_num_rows($title_meta_query) > 0)
{
 $alternate=1;
 while ($title_meta = tep_db_fetch_array($title_meta_query))
 {
  if ((!isset($_GET['fID']) || (isset($_GET['fID']) && ($_GET['fID'] == $title_meta['id']))) && !isset($fInfo) && (substr($action, 0, 3) != 'new'))
  {
   $fInfo = new objectInfo($title_meta);
  }
  if ( (isset($fInfo) && is_object($fInfo)) && ($title_meta['id'] == $fInfo->id) )
  {
   $row_selected=' id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_TITLE_METAKEYWORDS . '?page='.$_GET['page'].'&fID=' . $fInfo->id . '&action=edit\'"';
  }
  else
  {
   $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_TITLE_METAKEYWORDS . '?page='.$_GET['page'].'&fID=' . $title_meta['id'] . '\'"';
  }
  $alternate++;
  if ( (isset($fInfo) && is_object($fInfo)) && ($title_meta['id'] == $fInfo->id) )
  {
   $action_image=tep_image(PATH_TO_IMAGE.'icon_arrow_right.gif',IMAGE_EDIT);
  }
  else
  {
   $action_image='<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'page='.$_GET['page'].'&fID=' . $title_meta['id']) . '">'.tep_image(PATH_TO_IMAGE.'icon_info.gif',IMAGE_INFO).'</a>';
  }
  $template->assign_block_vars('title_meta', array( 'row_selected' => $row_selected,
   'name' => tep_db_output($title_meta['file_name']),
   'action' => $action_image,
   ));
 }
}

//// for right side
$ADMIN_RIGHT_HTML="";

$heading = array();
$contents = array();
switch ($action)
{
 case 'new_file':
 case 'insert_file':
 case 'save_file':
		$heading[]=array('text' => '<b>'.TEXT_INFO_HEADING_FILE_NAME.'</b>');
  $contents=array('form' => tep_draw_form('file', PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'action=insert_file','post',' onsubmit="return ValidateForm(this)"'));
		$contents[]=array('text' => TEXT_INFO_NEW_INTRO);
		$contents[]=array('text' => '<br>'.TEXT_INFO_FILE_NAME.'<br>'.tep_draw_input_field('TR_file_name', $file_name, '' ));
		$contents[]=array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_insert.gif', IMAGE_INSERT).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL).'</a>');
  break;
 case 'edit':
		$heading[]=array('text' => '<b>'.TEXT_INFO_HEADING_FILE_NAME.'</b>');
  $contents=array('form' => tep_draw_form('file', PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'action=save_file&fID='.$fInfo->id,'post',' onsubmit="return ValidateForm(this)"'));
		$contents[]=array('text' => TEXT_INFO_EDIT_INTRO);
		$contents[]=array('text' => '<br>'.TEXT_INFO_FILE_NAME.'<br>'.tep_draw_input_field('TR_file_name', $fInfo->file_name, '' ));
		$contents[]=array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_update.gif', IMAGE_UPDATE).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL).'</a>');
  break;
 case 'delete':
  $heading[]=array('text' => '<b>' . $fInfo->file_name . '</b>');
  $contents=array('form' => tep_draw_form('file_delete', PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->id . '&action=deleteconfirm'));
  $contents[]=array('text' => TEXT_DELETE_INTRO);
  $contents[]=array('text' => '<br><b>' . $fInfo->file_name . '</b>');
  $contents[]=array('align' => 'center', 'text' => '
  <table>
   <tr>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->id.'&action=confirm_delete') . '">'
   .tep_image_button(PATH_TO_BUTTON.'button_confirm.gif', IMAGE_CONFIRM).'</a>&nbsp;
   </td>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'page=' . $_GET['page'] ) . '">'
   . tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL) . '</a>
   </td>
   </tr>
   </table>
  ');
 break;
 default:
  if (isset($fInfo) && is_object($fInfo))
  {
   $heading[] = array('text' => '<b>&nbsp;' . tep_db_output($fInfo->file_name) . '</b>');
   $contents[] = array('align' => 'center', 'text' => TEXT_INFO_EDIT_INTRO);
   if($fInfo->title=='' && $fInfo->meta_keyword=='')
   {
    $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'fID=' . $fInfo->id.'&action=add_both') . '">'.INFO_TEXT_ADD_BOTH.'</a>');
   }
   else
   {
    if($fInfo->title=='')
    {
     $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'fID=' . $fInfo->id.'&action=add_title') . '">'.INFO_TEXT_ADD_TITLE.'</a>');
    }
    else
    {
     $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'fID=' . $fInfo->id.'&action=edit_title') . '">'.INFO_TEXT_EDIT_TITLE.'</a>');
    }
    if($fInfo->meta_keyword=='')
    {
     $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'fID=' . $fInfo->id.'&action=add_metakeyword') . '">'.INFO_TEXT_ADD_META_TAGS.'</a>');
    }
    else
    {
     $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'fID=' . $fInfo->id.'&action=edit_metakeyword') . '">'.INFO_TEXT_EDIT_META_TAGS.'</a>');
    }
   }
   if($fInfo->title!='' && $fInfo->meta_keyword!='')
   {
    $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'fID=' . $fInfo->id.'&action=edit_both') . '">'.INFO_TEXT_EDIT_BOTH.'</a>');
   }
   $contents[] = array('align' => 'center', 'text' => '<br>'.'<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'fID=' . $fInfo->id.'&action=edit') . '">'.tep_image(PATH_TO_BUTTON.'button_edit.gif',IMAGE_EDIT).'</a>&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'fID=' . $fInfo->id.'&action=delete') . '">'.tep_image(PATH_TO_BUTTON.'button_delete.gif',IMAGE_DELETE).'</a>');
  }
}
////
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
 'TABLE_HEADING_TITLE_META_NAME'=>TABLE_HEADING_TITLE_META_NAME,
 'TABLE_HEADING_ACTION'=>TABLE_HEADING_ACTION,
 'count_rows'=>$title_meta_split->display_count($title_meta_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_FILES),
 'no_of_pages'=>$title_meta_split->display_links($title_meta_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']),
 'new_button'=>$new_button,
 'button'=>'<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS, 'action=new_file') . '">'.tep_image_button(PATH_TO_BUTTON.'button_new.gif',IMAGE_NEW).'</a>&nbsp;&nbsp;',
 'form'=>tep_draw_form('add_edit', PATH_TO_ADMIN.FILENAME_ADMIN1_TITLE_METAKEYWORDS,'fID=' . $file_id . '&action=insert','post', 'onsubmit="return ValidateForm(this)"'),
 'HEADING_TITLE'=>HEADING_TITLE,
 'MIDDLE_STRING'=>$middle_string,
 'RIGHT_BOX_WIDTH'=>$RIGHT_BOX_WIDTH,
 'ADMIN_RIGHT_HTML'=>$ADMIN_RIGHT_HTML,
 'update_message'=>$messageStack->output()));
if($action=='add_both' || $action=='edit_both' || $action=='add_title' || $action=='edit_title' ||
   $action=='add_metakeyword' || $action=='edit_metakeyword' || $action=='insert')
{
 $template->pparse('add_edit');
}
else
{
 $template->pparse('metakeyword');
}
?>