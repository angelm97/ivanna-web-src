<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/


define('HEADING_TITLE','Forgot password ?');
define('HEADING_CONTENT','If you have forgotten your password, please enter your email address in the box below and click on confirm to have your password emailed to you. Alternatively, if you do not have a <b><a href="'.tep_href_link(FILENAME_INDEX).'">'.tep_db_output(SITE_TITLE).'</a></b> account you can set one up now <b><a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">Click here</a>.</b>');

define('JOBSEEKER_FORGOT_PASSWORD_SUBJECT','Your password for '.tep_db_output(SITE_TITLE));
define('JOBSEEKER_FORGOT_PASSWORD_TEXT','<font face="Verdana, Arial, Helvetica, sans-serif" size="1">Hi <b>%s</b>,' . "\n\n" . 'Your password, has been changed.  '. "\n\n" .'Yor new password is : <b>%s</b>' . "\n\n" . 'Thanks!' . "\n" . '%s' . "\n\n" . 'This is an automated response, please do not reply!</font>'); 

define('IMAGE_CONFIRM','Confirm');
?>