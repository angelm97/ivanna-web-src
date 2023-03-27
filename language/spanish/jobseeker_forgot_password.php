<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/


define('HEADING_TITLE','¿Olvidaste tu contraseña?');
define('HEADING_CONTENT','¿Olvidaste tu contraseña? Es fácil, ingresa tu correo electrónico a continuación y haz clic en confirmar. Si no tienes una <b><a href="'.tep_href_link(FILENAME_INDEX).'">'.tep_db_output(SITE_TITLE).'</a></b> cuenta, ¡Puedes crearla ahora! <b><a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">Haz clic aquí</a>.</b>');

define('JOBSEEKER_FORGOT_PASSWORD_SUBJECT','Tu contraseña para '.tep_db_output(SITE_TITLE));
define('JOBSEEKER_FORGOT_PASSWORD_TEXT','<font face="Verdana, Arial, Helvetica, sans-serif" size="1">¡Hola! <b>%s</b>,' . "\n\n" . 'Tu contraseña ha sido cambiada.  '. "\n\n" .'Tu nueva contraseña es : <b>%s</b>' . "\n\n" . '¡Gracias!' . "\n" . '%s' . "\n\n" . 'Esta respuesta es automática, ¡No te preocupes por responder!</font>'); 

define('IMAGE_CONFIRM','Confirmar');
?>