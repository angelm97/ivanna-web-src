<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/



define('HEADING_TITLE','¿Olvidaste tu contraseña?');
define('HEADING_CONTENT','Es súper fácil recuperarla: Ingresa tu dirección de correo electrónico en el siguiente cuadro, haz clic en confirmar y ¡Listo! La recibirás en tu correo. ¿No tienes  <b><a href="'.tep_href_link(FILENAME_INDEX).'">'.tep_db_output(SITE_TITLE).'</a></b> cuenta? ¡Puedes crearla aquí mismo! <b><a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">Haz clic aquí</a>.</b>');

define('RECRUITER_FORGOT_PASSWORD_SUBJECT','Tu contraseña para '.SITE_TITLE);
define('RECRUITER_FORGOT_PASSWORD_TEXT','<font face="Verdana, Arial, Helvetica, sans-serif" size="1">¡Hola! <b>%s</b>,' . "\n\n" . 'Tu contraseña ha sido cambiada.  '. "\n\n" .'Tu nueva contraseña es:<b>%s</b>' . "\n\n" . '¡Gracias!' . "\n" . '%s' . "\n\n" . 'Esta respuesta es automática, ¡No te preocupes por responder!</font>'); 

define('IMAGE_CONFIRM','Confirmar');
?>