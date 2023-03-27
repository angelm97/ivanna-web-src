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
$admin_control_panel='';
$show_page_parse_time='';
if(check_login("admin"))
{
 $admin_control_panel="\n".
 '      <table border="0" cellspacing="0" cellpadding="0">'."\n".
 '       <tr>'."\n".
 '        <td align="middle" class="small"><span style="margin:0 15px 0 0;"><a href="'.tep_href_link(PATH_TO_ADMIN.FILENAME_ADMIN1_CONTROL_PANEL).'"><b>'.FOOTER_TITLE_CONTROL_PANEL.'</a>&nbsp;|&nbsp;<a href="'.tep_href_link(PATH_TO_ADMIN.FILENAME_LOGOUT).'"><b>'.FOOTER_TITLE_LOGOUT.'</a></span></td>'."\n".
 '       '."\n".
 '     <td>Powered by <a href="http://ejobsitesoftware.com/">Job Board Software</a></td></tr>
 </table>';
	if (DISPLAY_PAGE_PARSE_TIME == 'true')
	{
		if (!is_object($logger))
			$logger = new logger;
		$show_page_parse_time=$logger->timer_stop(DISPLAY_PAGE_PARSE_TIME);
	}
}
$ADMIN_FOOTER_HTML=
'     </td>'."\n".
'    </tr>'."\n".
'   </table>'."\n".
'  </td>'."\n".
' </tr>'."\n".
'</table>'."\n".
'<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" style="padding:10px 25px;">'."\n".
' <tr>'."\n".
'  <td class="small">'.$show_page_parse_time. '</td>'."\n".
'  <td align="right">'.$admin_control_panel.'</td>'."\n".
' </tr>'."\n".
'</table>'."\n".
'</body>'."\n".
'</html>' ;
?>