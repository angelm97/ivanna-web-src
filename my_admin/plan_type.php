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
include_once(PATH_TO_MAIN_ADMIN_PHYSICAL_LANGUAGE.$language.'/'.FILENAME_ADMIN1_ADMIN_PLAN_TYPE);
$template->set_filenames(array('plan_type' => 'plan_type.htm'));
include_once(FILENAME_ADMIN_BODY);
$action = (isset($_GET['action']) ? $_GET['action'] : '');

if ($action!="")
{
 switch ($action)
	{
  case 'confirm_delete':
   $id = tep_db_prepare_input($_GET['id']);
   tep_db_query("delete from " . PLAN_TYPE_TABLE . " where id = '" . (int)$id . "'");
			$messageStack->add_session(MESSAGE_SUCCESS_DELETED, 'success');
   tep_redirect(tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'page=' . $_GET['page']));
  break;
  case 'insert':
  case 'save':
   $plan_type_name=tep_db_prepare_input($_POST['TR_plan_type_name']);
   $es_plan_type_name=tep_db_prepare_input($_POST['TR_es_plan_type_name']);
   $time_period=tep_db_prepare_input($_POST['IR_time_period']);
   $time_period1=tep_db_prepare_input($_POST['time_period1']);
   $fee=tep_db_prepare_input($_POST['MR_fee']);
   $featured_job=tep_db_prepare_input($_POST['featured_job']);
   $currency=tep_db_prepare_input(DEFAULT_CURRENCY);

   $priority = tep_db_prepare_input($_POST['IN_priority']);
   $sql_data_array = array('plan_type_name'    => $plan_type_name,
                       				'es_plan_type_name' => $es_plan_type_name,
                       				'time_period'       => $time_period,
                       				'time_period1'      => $time_period1,
                       				'fee'               => $fee,
                       				'currency'          => $currency,
                       				'priority'          => $priority,
                       				'featured_job'      => $featured_job,
				                   );
   $sql_data_array['job']=(tep_not_null($_POST['ch_no_of_jobs'])?'2147483647':tep_db_prepare_input($_POST['no_of_jobs']));
   $sql_data_array['cv']=(tep_not_null($_POST['ch_no_of_times'])?'2147483647':tep_db_prepare_input($_POST['no_of_days']));
   $sql_data_array['sms']=(tep_not_null($_POST['ch_no_of_sms'])?'2147483647':tep_db_prepare_input($_POST['no_of_sms']));

			if($action=='insert')
			{
				if($row_chek=getAnyTableWhereData(PLAN_TYPE_TABLE,"plan_type_name='".tep_db_input($plan_type_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
				}
				else if($row_chek=getAnyTableWhereData(PLAN_TYPE_TABLE,"es_plan_type_name='".tep_db_input($es_plan_type_name)."'",'id'))
				{
					$messageStack->add(MESSAGE_FR_NAME_ERROR, 'error');
				}
				else
				{
     tep_db_perform(PLAN_TYPE_TABLE, $sql_data_array);
  			$messageStack->add_session(MESSAGE_SUCCESS_INSERTED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_PLAN_TYPE);
				}
			}
			else
			{
    $id=(int)$_GET['id'];
				if($row_chek=getAnyTableWhereData(PLAN_TYPE_TABLE,"plan_type_name='".tep_db_input($plan_type_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_NAME_ERROR, 'error');
					$action='edit';
				}
				else if($row_chek=getAnyTableWhereData(PLAN_TYPE_TABLE,"es_plan_type_name='".tep_db_input($es_plan_type_name)."' and id!='$id'",'id'))
				{
					$messageStack->add(MESSAGE_FR_NAME_ERROR, 'error');
					$action='edit';
				}
				else
				{
     tep_db_perform(PLAN_TYPE_TABLE, $sql_data_array, 'update', "id = '" . (int)$id . "'");
  			$messageStack->add_session(MESSAGE_SUCCESS_UPDATED, 'success');
					tep_redirect(FILENAME_ADMIN1_ADMIN_PLAN_TYPE.'?page='.$_GET['page'].'&id='.$id);
				}
			}
  break;
 }
}
///////////// Middle Values
$plan_type_query_raw="select * from " . PLAN_TYPE_TABLE ." order by priority";
$plan_type_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $plan_type_query_raw, $plan_type_query_numrows);
$plan_type_query = tep_db_query($plan_type_query_raw);
if(tep_db_num_rows($plan_type_query) > 0)
{
 $alternate=1;
 while ($plan_type = tep_db_fetch_array($plan_type_query))
 {
  if ((!isset($_GET['id']) || (isset($_GET['id']) && ($_GET['id'] == $plan_type['id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new'))
  {
   $cInfo = new objectInfo($plan_type);
  }
  if ( (isset($cInfo) && is_object($cInfo)) && ($plan_type['id'] == $cInfo->id) )
  {
   $row_selected=' id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_ADMIN_PLAN_TYPE . '?page='.$_GET['page'].'&id=' . $cInfo->id . '&action=edit\'"';
  }
  else
  {
   $row_selected=' class="dataTableRow'.($alternate%2==1?'1':'2').'" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . FILENAME_ADMIN1_ADMIN_PLAN_TYPE . '?page='.$_GET['page'].'&id=' . $plan_type['id'] . '\'"';
  }
  $alternate++;
  if ( (isset($cInfo) && is_object($cInfo)) && ($plan_type['id'] == $cInfo->id) )
  {
   $action_image=tep_image(PATH_TO_IMAGE.'icon_arrow_right.gif',IMAGE_EDIT);
  }
  else
  {
   $action_image='<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'page='.$_GET['page'].'&id=' . $plan_type['id']) . '">'.tep_image(PATH_TO_IMAGE.'icon_info.gif',IMAGE_INFO).'</a>';
  }
  $template->assign_block_vars('plan_type', array( 'row_selected' => $row_selected,
   'action' => $action_image,
   'name' => tep_db_output($plan_type['plan_type_name']),
   'es_name' => tep_db_output($plan_type['es_plan_type_name']),
   'time_period' => tep_db_output($plan_type['time_period']).'&nbsp;'.($plan_type['time_period']>1?tep_db_output($plan_type['time_period1'])."s":tep_db_output($plan_type['time_period1'])),
   'fee' => tep_db_output($currencies->format($plan_type['fee'], ($plan_type['currency']!=DEFAULT_CURRENCY?true:false), DEFAULT_CURRENCY, ($plan_type['currency']==DEFAULT_CURRENCY?$currencies->get_value($plan_type['currency']):''))),
   'row_selected' => $row_selected
   ));
 }
}
//// for right side
$ADMIN_RIGHT_HTML="";
$m_y_array[]=array('id'=>'Month','text'=>'Month(s)');
$m_y_array[]=array('id'=>'Year','text'=>'Year(s)');
$heading = array();
$contents = array();
$unlimited_job=($cInfo->job=="2147483647"?true:false);
$unlimited_cv=($cInfo->cv=="2147483647"?true:false);
$unlimited_sms=($cInfo->sms=="2147483647"?true:false);
$featured_job_array   = array();
$featured_job_array[] = array('id'=>'No','text'=>'No');
$featured_job_array[] = array('id'=>'Yes','text'=>'Yes');

switch ($action)
{
 case 'new':
 case 'insert':
 case 'save':
		$heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_PLAN_TYPE.'</b>');
  $contents = array('form' => tep_draw_form('plan_type', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'action=insert','post',' onsubmit="return ValidateForm(this)"'));
		$contents[] = array('text' => TEXT_INFO_NEW_INTRO);
		$contents[] = array('text' => '<br>'.TEXT_INFO_PLAN_TYPE_NAME.'<br>'.tep_draw_input_field('TR_plan_type_name','', '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_FR_PLAN_TYPE_NAME.'<br>'.tep_draw_input_field('TR_es_plan_type_name','', '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_PLAN_TYPE_TIME.'<br>'.tep_draw_input_field('IR_time_period', '', 'size="3"' ).'&nbsp;'.tep_draw_pull_down_menu('time_period1', $m_y_array, $time_period1, '', false));
		$contents[] = array('text' => '<br>'.TEXT_INFO_PLAN_TYPE_FEE.' ('.$currencies->get_symbol_left(DEFAULT_CURRENCY).')<br>'.tep_draw_input_field('MR_fee','', 'size="10"' ));
  $contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_NO_OF_JOBS.'</b><br>&nbsp;' . tep_draw_input_field('no_of_jobs', '', 'size="5" maxlength="5"').'&nbsp;&nbsp;'.tep_draw_checkbox_field('ch_no_of_jobs', '',($unlimited_job?true:false),'','id="check_ch_no_of_jobs" onclick="unlimited();"').'&nbsp;<label for="check_ch_no_of_jobs">Unlimited</label>');
  $contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_FEATURED_JOBS.'</b><br>&nbsp;' . '&nbsp;&nbsp;'.tep_draw_pull_down_menu('featured_job', $featured_job_array, $featured_job,''));
  $contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_NO_OF_CVS.'</b><br>&nbsp;' . tep_draw_input_field('no_of_days', '', 'size="5" maxlength="5"').'&nbsp;&nbsp;'.tep_draw_checkbox_field('ch_no_of_times', '',($unlimited_cv?true:false),'','id="check_ch_no_of_times" onclick="unlimited();"').'&nbsp;<label for="check_ch_no_of_times">Unlimited</label>');
  //$contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_NO_OF_SMS.'</b><br>&nbsp;' . tep_draw_input_field('no_of_sms', '', 'size="5" maxlength="5"').'&nbsp;&nbsp;'.tep_draw_checkbox_field('ch_no_of_sms', '',($unlimited_sms?true:false),'','id="check_ch_no_of_sms" onclick="unlimited();"').'&nbsp;<label for="check_ch_no_of_sms">Unlimited</label>');
		$contents[] = array('text' => '<br>'.TEXT_INFO_PLAN_TYPE_PRIORITY.'<br>'.tep_draw_input_field('IN_priority', $_POST['IN_priority'], 'size="5"' ));
		$contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_insert.gif', IMAGE_INSERT).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE).'">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL).'</a>');
  break;
 case 'edit':
  $value_field=tep_draw_input_field('TR_plan_type_name', $cInfo->plan_type_name, '' );
  $heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_PLAN_TYPE.'</b>');
  $contents = array('form' => tep_draw_form('plan_type', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'id=' . $cInfo->id.'&page='.$_GET['page'].'&action=save','post',' onsubmit="return ValidateForm(this)"'));
		$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
		$contents[] = array('text' => '<br>'.TEXT_INFO_PLAN_TYPE_NAME.'<br>'.tep_draw_input_field('TR_plan_type_name', $cInfo->plan_type_name, '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_FR_PLAN_TYPE_NAME.'<br>'.tep_draw_input_field('TR_es_plan_type_name', $cInfo->es_plan_type_name, '' ));
		$contents[] = array('text' => '<br>'.TEXT_INFO_PLAN_TYPE_TIME.'<br>'.tep_draw_input_field('IR_time_period', $cInfo->time_period, 'size="3"' ).'&nbsp;'.tep_draw_pull_down_menu('time_period1', $m_y_array, $cInfo->time_period1, '', false));
		$contents[] = array('text' => '<br>'.TEXT_INFO_PLAN_TYPE_FEE.' ('.$currencies->get_symbol_left(DEFAULT_CURRENCY).')<br>'.tep_draw_input_field('MR_fee', $currencies->format_without_symbol($cInfo->fee, true, DEFAULT_CURRENCY, $currencies->get_value($cInfo->currency)), 'size="10"' ));
  $contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_NO_OF_JOBS.'</b><br>&nbsp;' . tep_draw_input_field('no_of_jobs', ($unlimited_job?'':$cInfo->job), 'size="5" maxlength="5"'.($unlimited_job?' disabled':'')).'&nbsp;&nbsp;'.tep_draw_checkbox_field('ch_no_of_jobs', '',($unlimited_job?true:false),'','id="check_ch_no_of_jobs" onclick="unlimited();"').'&nbsp;<label for="check_ch_no_of_jobs">Unlimited</label>');
  $contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_FEATURED_JOBS.'</b><br>&nbsp;' . '&nbsp;&nbsp;'.tep_draw_pull_down_menu('featured_job', $featured_job_array, $cInfo->featured_job,''));

  $contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_NO_OF_CVS.'</b><br>&nbsp;' . tep_draw_input_field('no_of_days', ($unlimited_cv?'':$cInfo->cv), 'size="5" maxlength="5"'.($unlimited_cv?' disabled':'')).'&nbsp;&nbsp;'.tep_draw_checkbox_field('ch_no_of_times', '',($unlimited_cv?true:false),'','id="check_ch_no_of_times" onclick="unlimited();"').'&nbsp;<label for="check_ch_no_of_times">Unlimited</label>');
  //$contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_NO_OF_SMS.'</b><br>&nbsp;' . tep_draw_input_field('no_of_sms', ($unlimited_sms?'':$cInfo->sms), 'size="5" maxlength="5"'.($unlimited_sms?' disabled':'')).'&nbsp;&nbsp;'.tep_draw_checkbox_field('ch_no_of_sms', '',($unlimited_sms?true:false),'','id="check_ch_no_of_sms" onclick="unlimited();"').'&nbsp;<label for="check_ch_no_of_sms">Unlimited</label>');
		$contents[] = array('text' => '<br>'.TEXT_INFO_PLAN_TYPE_PRIORITY.'<br>'.tep_draw_input_field('IN_priority', $cInfo->priority, 'size="5"' ));
  $contents[] = array('align' => 'center', 'text' => '<br>'.tep_image_submit(PATH_TO_BUTTON.'button_update.gif',IMAGE_UPDATE).'&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'gid=' . $_GET['gid'] . '&id=' . $cInfo->id ). '">'.tep_image_button(PATH_TO_BUTTON.'button_cancel.gif',IMAGE_CANCEL).'</a>');
  break;
 case 'delete':
  $heading[] = array('text' => '<b>' . $cInfo->plan_type_name . '</b>');
  $contents = array('form' => tep_draw_form('plan_type_delete', PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'page=' . $_GET['page'] . '&id=' . $nInfo->id . '&action=deleteconfirm'));
  $contents[] = array('text' => TEXT_DELETE_INTRO);
  $contents[] = array('text' => '<br><b>' . $cInfo->plan_type_name . '</b>');
  $contents[] = array('align' => 'center', 'text' => '
  <table>
   <tr>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'page=' . $_GET['page'] . '&id=' . $_GET['id'].'&action=confirm_delete') . '">'
   .tep_image_button(PATH_TO_BUTTON.'button_confirm.gif', IMAGE_CONFIRM).'</a>
   </td>
   <td>
   <a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'page=' . $_GET['page'] . '&id=' . $_GET['id']) . '">'
   . tep_image_button(PATH_TO_BUTTON.'button_cancel.gif', IMAGE_CANCEL) . '</a>
   </td>
   </tr>
   </table>
  ');
 break;
 default:
  if (isset($cInfo) && is_object($cInfo))
		{
   $heading[] = array('text' => '<b>'.TEXT_INFO_HEADING_PLAN_TYPE.'</b>');
   $contents[] = array('text' => tep_db_output($cInfo->plan_type_name));
   $contents[] = array('align' => 'center', 'text' => '<br><a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'page=' . $_GET['page'] .'&id=' . $cInfo->id . '&action=edit') . '">'.tep_image_button(PATH_TO_BUTTON.'button_edit.gif',IMAGE_EDIT).'</a>&nbsp;<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'page=' . $_GET['page'] .'&id=' . $cInfo->id . '&action=delete') . '">'.tep_image_button(PATH_TO_BUTTON.'button_delete.gif',IMAGE_DELETE).'</a>');
   $contents[] = array('text' => '<br>'.TEXT_INFO_ACTION);
   $contents[] = array('text' => '<br><b>'.TEXT_INFO_PLAN_TYPE_TIME.'</b><br>'.tep_db_output($cInfo->time_period).'&nbsp;'.($cInfo->time_period >1?tep_db_output($cInfo->time_period1)."s":tep_db_output($cInfo->time_period1)));
   $contents[] = array('text' => '<br><b>'.TEXT_INFO_PLAN_TYPE_FEE.'</b><br>'.tep_db_output($currencies->format($cInfo->fee, ($cInfo->currency!=DEFAULT_CURRENCY?true:false), DEFAULT_CURRENCY, ($cInfo->currency==DEFAULT_CURRENCY?$currencies->get_value($cInfo->currency):''))));
   $contents[] = array('text' => '<br><b>'.TEXT_INFO_PLAN_TYPE_NO_OF_JOBS.'</b><br>'.($unlimited_job?'Unlimited':tep_db_output($cInfo->job)));
   if($cInfo->job > 0)
   $contents[] = array('text' => '<b>&nbsp;'.TEXT_INFO_PLAN_TYPE_FEATURED_JOBS.'</b><br>&nbsp;' . '&nbsp;&nbsp;'.$cInfo->featured_job);
   $contents[] = array('text' => '<br><b>'.TEXT_INFO_PLAN_TYPE_NO_OF_CVS.'</b><br>'.($unlimited_cv?'Unlimited':tep_db_output($cInfo->cv)));
   //$contents[] = array('text' => '<br><b>'.TEXT_INFO_PLAN_TYPE_NO_OF_SMS.'</b><br>'.($unlimited_sms?'Unlimited':tep_db_output($cInfo->sms))."<br>&nbsp;");
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
 'TABLE_HEADING_PLAN_TYPE_NAME'=>TABLE_HEADING_PLAN_TYPE_NAME,
 'TABLE_HEADING_FR_PLAN_TYPE_NAME'=>TABLE_HEADING_FR_PLAN_TYPE_NAME,
 'TABLE_HEADING_PLAN_TYPE_TIME_PERIOD'=>TABLE_HEADING_PLAN_TYPE_TIME_PERIOD,
 'TABLE_HEADING_PLAN_TYPE_FEE'=>TABLE_HEADING_PLAN_TYPE_FEE.' ('.$currencies->get_symbol_left(DEFAULT_CURRENCY).')',
 'TABLE_HEADING_ACTION'=>TABLE_HEADING_ACTION,
 'count_rows'=>$plan_type_split->display_count($plan_type_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PLAN_TYPE),
 'no_of_pages'=>$plan_type_split->display_links($plan_type_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']),
 'new_button'=>'<a href="' . tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_ADMIN_PLAN_TYPE, 'page=' . $_GET['page'] .'&action=new') . '">'.tep_image_button(PATH_TO_BUTTON.'button_new.gif',IMAGE_NEW).'</a>&nbsp;&nbsp;',
 'HEADING_TITLE'=>HEADING_TITLE,
 'RIGHT_BOX_WIDTH'=>$RIGHT_BOX_WIDTH,
 'ADMIN_RIGHT_HTML'=>$ADMIN_RIGHT_HTML,
 'update_message'=>$messageStack->output()));
$template->pparse('plan_type');
?>