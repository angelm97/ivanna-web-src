<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/


if($_GET['action1']=='change_password')
 define('HEADING_TITLE', 'Cambiar la contraseña');
else
 define('HEADING_TITLE', 'Agregar / editar usuario');
define('HEADING_TITLE1', 'Lista de usuarios');
//////////////////////////
define('INFO_TEXT_FULL_NAME', 'Nombre completo: ');
define('FULL_NAME_ERROR','Tu nombre completo debe contener al menos un caracter.');

define('INFO_TEXT_EMAIL_ADDRESS','Dirección de correo electrónico:');
define('EMAIL_ADDRESS_ERROR','¡Oops! Tu dirección de correo electrónico ya existe.');
define('EMAIL_ADDRESS_INVALID_ERROR','¡Oops! Tu dirección de correo electrónico no es válida.');

define('INFO_TEXT_CONFIRM_EMAIL_ADDRESS','Confirmar correo:');
define('CONFIRM_EMAIL_ADDRESS_INVALID_ERROR','¡Oops! Tu dirección de correo electrónico confirmada no es válida.');

define('EMAIL_ADDRESS_MATCH_ERROR','¡Oops! Tu dirección de correo electrónico confirmada no es válida.');

define('INFO_TEXT_PASSWORD','Contraseña:');
define('MIN_PASSWORD_ERROR','Tu contraseña debe contener un mínimo de ' . MIN_PASSWORD_LENGTH . ' caracteres..');

define('INFO_TEXT_CONFIRM_PASSWORD','Confirmar contraseña:');
define('MIN_CONFIRM_PASSWORD_ERROR','Tu confirmación de contraseña debe contener un mínimo de ' . MIN_PASSWORD_LENGTH . ' caracteres..');

define('PASSWORD_MATCH_ERROR','¡Oops! Tu contraseña y tu confirmación de contraseña no coinciden.');
define('MESSAGE_ERROR_USER','¡Oops! Este usuario no existe.');

define('TABLE_HEADING_NAME','Nombre completo');
define('TABLE_HEADING_EMAIL_ADDRESS','Dirección de correo electrónico');
define('TABLE_HEADING_INSERTED','Insertado');
define('TABLE_HEADING_STATUS','Estado');
define('TABLE_HEADING_CHANGE_PASSWORD','Acción');
define('INFO_CHANGE_PASSWORD','Cambiar la contraseña');
define('INFO_DELETE_USER','Borrar usuario');
define('MESSAGE_SUCCESS_DELETED','¡Listo! Usuario eliminado correctamente');

define('STATUS_USER_INACTIVE','Inactivo');
define('STATUS_USER_ACTIVATE','¿Activar?');
define('STATUS_USER_INACTIVATE','¿Desactivar?');
define('STATUS_USER_ACTIVE','Activo');

define('INFO_TEXT_OLD_PASSWORD','Contraseña anterior:');
define('INFO_TEXT_NEW_PASSWORD','Nueva contraseña:');
define('INFO_TEXT_CONFIRM_PASSWORD','Confirmar Contraseña:');

define('MESSAGE_SUCCESS_INSERTED','¡Listo! Usuario ingresado.');
define('MESSAGE_SUCCESS_UPDATED','¡Listo! Usuario actualizado.');

define('IMAGE_NEW','Añadir nuevo usuario');
define('IMAGE_UPDATE','Actualizar usuario');
define('IMAGE_CONFIRM','Confirmar');
?>