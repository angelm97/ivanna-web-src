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
include_once(PATH_TO_MAIN_ADMIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES);
$template->set_filenames(array('article_category' => 'article_category.htm'));
include_once(FILENAME_ADMIN_BODY);

define('TEXT_LANGUAGE','');
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$is_sub_cat_id=false;
$cat_id = (isset($_GET['id']) ? $_GET['id'] : '');
if($cat_id!="")
{
 if(!$row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"id='".tep_db_input($cat_id)."'",'id,sub_cat_id'))
 {
  $messageStack->add_session(MESSAGE_ERROR_CATEGORY, 'error');
  tep_redirect(FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES.'?page='.$_GET['page']);
 }
 if(tep_not_null($row_chek['sub_cat_id']))
 {
  $is_sub_cat_id=true;
  $sub_category_id=$row_chek['sub_cat_id'];
 }
}
if($action!="")
{
 switch ($action)
	{
  case 'confirm_delete':
   $id = tep_db_prepare_input($_GET['id']);
   if($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"sub_cat_id='".tep_db_input($id)."' limit 0,1",'sub_cat_id'))
   {
    $messageStack->add_session(MESSAGE_UN_SUCCESS_DELETED, 'error');
    tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES));
   }
   tep_db_query("delete from " . ARTICLE_CATEGORY_TABLE . " where id = '" . (int)$id . "'");
			$messageStack->add_session(MESSAGE_SUCCESS_DELETED, 'success');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'page=' . $_GET['page']));
  break;
  case 'insert':
  case 'save':
  case 'insert1':
  case 'save1':
   $category_name=tep_db_prepare_input($_POST['TR_article_category_name']);
   $sub_category_name=tep_db_prepare_input($_POST['TR_article_sub_category_name']);
   $es_category_name=tep_db_prepare_input($_POST['TR_es_article_category_name']);
   $es_sub_category_name=tep_db_prepare_input($_POST['TR_es_article_sub_category_name']);
   $sql_data_array['category_name'] = $category_name;
			$sql_data_array['es_category_name'] = $es_category_name;
			if($action=='insert')
			{
				if($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"category_name='".tep_db_input($category_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				elseif($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"es_category_name='".tep_db_input($es_category_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				else
				{
     tep_db_perform(ARTICLE_CATEGORY_TABLE, $sql_data_array);
  			$messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES);
				}
			}
			else if($action=='insert1')
			{
				if($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"category_name='".tep_db_input($sub_category_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				else if($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"es_category_name='".tep_db_input($es_sub_category_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				else
				{
     $sql_data_array['sub_cat_id'] = $category_name;
     $sql_data_array['category_name'] = $sub_category_name;
					$sql_data_array['es_category_name'] = $es_sub_category_name;
     tep_db_perform(ARTICLE_CATEGORY_TABLE, $sql_data_array);
  			$messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES);
				}
			}
			else if($action=='save')
			{
    $id=(int)$_GET['id'];
				if($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"category_name='".tep_db_input($category_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
					$action='edit';
				}
				else if($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"es_category_name='".tep_db_input($es_category_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
					$action='edit';
				}
				else
				{
     tep_db_perform(ARTICLE_CATEGORY_TABLE, $sql_data_array, 'update', "id = '" . (int)$id . "'");
  			$messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES);
				}
			}
			else if($action=='save1')
			{
    $id=(int)$_GET['id'];
				if($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"category_name='".tep_db_input($sub_category_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
					$action='edit';
				}
				else if($row_chek=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"es_category_name='".tep_db_input($es_sub_category_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
					$action='edit';
				}
				else
				{
     $sql_data_array['sub_cat_id'] = $category_name;
     $sql_data_array['category_name'] = $sub_category_name;
     $sql_data_array['es_category_name'] = $es_sub_category_name;
     tep_db_perform(ARTICLE_CATEGORY_TABLE, $sql_data_array, 'update', "id = '" . (int)$id . "'");
  			$messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES);
				}
			}
  break;
 }
}

///////////// Middle Values
$article_category_query_raw="select id, sub_cat_id, category_name,es_category_name from " . ARTICLE_CATEGORY_TABLE ." order by category_name asc";
$article_category_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $article_category_query_raw, $article_category_query_numrows);
$article_category_query = tep_db_query($article_category_query_raw);

if(tep_db_num_rows($article_category_query) > 0)
{
 $alternate=1;
 while ($article_category = tep_db_fetch_array($article_category_query))
 {
  if ((!isset($_GET['id']) || (isset($_GET['id']) && ($_GET['id'] == $article_category['id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new'))
  {
   $cInfo = new objectInfo($article_category);
   //print_r($cInfo);
  }
  if ( (isset($cInfo) && is_object($cInfo)) && ($article_category['id'] == $cInfo->id) )
  {
   $row_selected=' id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES . '?page='.$_GET['page'].'&id=' . $cInfo->id . '&action=edit\'"';
  }
  else
  {
   $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES . '?page='.$_GET['page'].'&id=' . $article_category['id'] . '\'"';
  }
  $alternate++;
  if ( (isset($cInfo) && is_object($cInfo)) && ($article_category['id'] == $cInfo->id))
  {
   $action_image=tep_image(PATH_TO_IMAGE.'icon_arrow_right.gif',IMAGE_EDIT);
  }
  else
  {
   $action_image='<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'page='.$_GET['page'].'&id=' . $article_category['id']) . '">'.tep_image(PATH_TO_IMAGE.'icon_info.gif',IMAGE_INFO).'</a>';
  }
  if($article_category['sub_cat_id']!='')
  {
   $sub_cat_id=$article_category['sub_cat_id'];
   $sub_category_name_array=array();
   while($sub_cat_id!="")
   {
    $row_sub_cat=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"id='".$sub_cat_id."'","category_name,sub_cat_id");
    $sub_cat_id=$row_sub_cat['sub_cat_id'];
    $sub_category_name_array[]=stripslashes($row_sub_cat['category_name']);
   }
   if(count($sub_category_name_array)>0)
   {
    $sub_category_name_array=array_reverse($sub_category_name_array);
    $category_name=implode(" -> ",$sub_category_name_array);
   }
   $category_name=$category_name." -> ".$article_category['category_name'];
  }
  else
  {
   $category_name=$article_category['category_name'];
  }
		///french//
		if($article_category['sub_cat_id']!='')
  {
   $sub_cat_id=$article_category['sub_cat_id'];
   $sub_category_name_array=array();
   while($sub_cat_id!="")
   {
    $row_sub_cat=getAnyTableWhereData(ARTICLE_CATEGORY_TABLE,"id='".$sub_cat_id."'","es_category_name,sub_cat_id");
    $sub_cat_id=$row_sub_cat['sub_cat_id'];
    $sub_category_name_array[]=stripslashes($row_sub_cat['es_category_name']);
   }
   if(count($sub_category_name_array)>0)
   {
    $sub_category_name_array=array_reverse($sub_category_name_array);
    $es_category_name=implode(" -> ",$sub_category_name_array);
   }
   $es_category_name=$es_category_name." -> ".$article_category['es_category_name'];
  }
  else
  {
   $es_category_name=$article_category['es_category_name'];
  }


  $template->assign_block_vars('article_category', array( 'row_selected' => $row_selected,
   'action' => $action_image,
   'name' => tep_db_output($category_name),
   'es_name' => tep_db_output($es_category_name),
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
 case 'insert1':
	$heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_ARTICLE_CATEGORY.'</b>');
  $contents = array('form' => tep_draw_form('article_category', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'action=insert','post',' onsubmit="return ValidateForm(this)"'));
		$contents[] = array('text' => TEXT_INFO_NEW_INTRO);
		$contents[] = array('text' => '<br>'.TEXT_INFO_ARTICLE_CATEGORY_NAME.'<br>'.tep_draw_input_field('TR_article_category_name', ($action=='insert'?$_POST['TR_article_category_name']:''), '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_FR_ARTICLE_CATEGORY_NAME.'<br>'.tep_draw_input_field('TR_es_article_category_name', ($action=='insert'?$_POST['TR_es_article_category_name']:''), '' ));
		$contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_insert.gif', IMAGE_INSERT).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL).'</a></form>');
  $contents[] = array('text' => tep_draw_form('article_category', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'action=insert1','post',' onsubmit="return ValidateForm(this)"'));
		$contents[] = array('text' => TEXT_INFO_NEW_INTRO1);
		$contents[] = array('text' => '<br>'.TEXT_INFO_ARTICLE_CATEGORY_NAME.'<br>'.get_drop_down_list1(ARTICLE_CATEGORY_TABLE,"name='TR_article_category_name'","","",($action=='insert1'?$_POST['TR_article_category_name']:'')));
		$contents[] = array('text' => '<br>'.TEXT_INFO_ARTICLE_SUB_CATEGORY_NAME.'<br>'.tep_draw_input_field('TR_article_sub_category_name', $_POST['TR_article_sub_category_name'], '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_FR_ARTICLE_SUB_CATEGORY_NAME.'<br>'.tep_draw_input_field('TR_es_article_sub_category_name', $_POST['TR_es_article_sub_category_name'], '' ));
		$contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_insert.gif', IMAGE_INSERT).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL).'</a>');

  break;
 case 'edit':
 case 'save':
 case 'save1':
  $heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_ARTICLE_CATEGORY.'</b>');
  if($is_sub_cat_id)
  {
   $contents = array('form' => tep_draw_form('article_category', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'id='.$_GET['id'].'&action=save1','post',' onsubmit="return ValidateForm(this)"'));
   $contents[] = array('text' => TEXT_INFO_NEW_INTRO);
   $contents[] = array('text' => '<br>'.TEXT_INFO_ARTICLE_CATEGORY_NAME.'<br>'.get_drop_down_list1(ARTICLE_CATEGORY_TABLE,"name='TR_article_category_name'","","",$sub_category_id));
   $contents[] = array('text' => '<br>'.TEXT_INFO_ARTICLE_SUB_CATEGORY_NAME.'<br>'.tep_draw_input_field('TR_article_sub_category_name', ($action=='save1'?$_POST['TR_article_sub_category_name']:$cInfo->category_name), '' ));
   $contents[] = array('text' => '<br>'.TEXT_INFO_FR_ARTICLE_SUB_CATEGORY_NAME.'<br>'.tep_draw_input_field('TR_es_article_sub_category_name', ($action=='save1'?$_POST['TR_es_article_sub_category_name']:$cInfo->es_category_name), '' ));
   $contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_update.gif',IMAGE_UPDATE).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'gid=' . $_GET['gid'] . '&id=' . $cInfo->id ). '">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif',IMAGE_CANCEL).'</a>');
  }
  else
  {
   $contents = array('form' => tep_draw_form('article_category', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'id='.$_GET['id'].'&action=save','post',' onsubmit="return ValidateForm(this)"'));
   $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
   $contents[] = array('text' => '<br>'.TEXT_INFO_ARTICLE_CATEGORY_NAME.'<br>'.tep_draw_input_field('TR_article_category_name', ($action=='save'?$_POST['TR_article_category_name']:$cInfo->category_name), '' ));
			$contents[] = array('text' => '<br>'.TEXT_INFO_FR_ARTICLE_CATEGORY_NAME.'<br>'.tep_draw_input_field('TR_es_article_category_name', ($action=='save'?$_POST['TR_es_article_category_name']:$cInfo->es_category_name), '' ));
   $contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_update.gif', IMAGE_UPDATE).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL).'</a>');
  }
  break;
 case 'delete':
  $heading[] = array('text' => '<b>' . $cInfo->category_name . '</b>');
  $contents = array('form' => tep_draw_form('article_category_delete', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'page=' . $_GET['page'] . '&id=' . $cInfo->id . '&action=deleteconfirm'));
  $contents[] = array('text' => TEXT_DELETE_INTRO);
  $contents[] = array('text' => '<br><b>' . $cInfo->category_name . '</b>');
  $contents[] = array('align' => 'center', 'text' => '
  <table>
   <tr>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'page=' . $_GET['page'] . '&id=' . $_GET['id'].'&action=confirm_delete') . '">'
   .tep_image_button(PATH_TO_BUTTON.'button_confirm.gif', IMAGE_CONFIRM).'</a>&nbsp;
   </td>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'page=' . $_GET['page'] . '&id=' . $_GET['id']) . '">'
   . tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL) . '</a>
   </td>
   </tr>
   </table>
  ');
 break;
 default:
  if (isset($cInfo) && is_object($cInfo))
		{
   $heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_ARTICLE_CATEGORY.'</b>');
   $contents[] = array('text' => tep_db_output($cInfo->category_name));
   $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'page=' . $_GET['page'] .'&id=' . $cInfo->id . '&action=edit') . '">'.tep_image_button(PATH_TO_BUTTON.'button_edit.gif',IMAGE_EDIT).'</a>&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'page=' . $_GET['page'] .'&id=' . $cInfo->id . '&action=delete') . '">'.tep_image_button(PATH_TO_BUTTON.'button_delete.gif',IMAGE_DELETE).'</a>');
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
 'TABLE_HEADING_FR_ARTICLE_CATEGORY_NAME'=>TABLE_HEADING_FR_ARTICLE_CATEGORY_NAME,
 'TABLE_HEADING_ARTICLE_CATEGORY_NAME'=>TABLE_HEADING_ARTICLE_CATEGORY_NAME,
 'TABLE_HEADING_ACTION'=>TABLE_HEADING_ACTION,
 'count_rows'=>$article_category_split->display_count($article_category_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ARTICLE_CATEGORIES),
 'no_of_pages'=>$article_category_split->display_links($article_category_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']),
 'new_button'=>'<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_ARTICLE_CATEGORIES, 'page=' . $_GET['page'] .'&action=new') . '">'.tep_image_button(PATH_TO_BUTTON.'button_new.gif',IMAGE_NEW).'</a>&nbsp;&nbsp;',
 'HEADING_TITLE'=>HEADING_TITLE,
 'RIGHT_BOX_WIDTH'=>RIGHT_BOX_WIDTH,
 'ADMIN_RIGHT_HTML'=>$ADMIN_RIGHT_HTML,
 'update_message'=>$messageStack->output()));
$template->pparse('article_category');
?>