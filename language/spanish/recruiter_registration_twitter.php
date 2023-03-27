<?
/*
***********************************************************
***********************************************************
**********#	Name				      : Shambhu Prasad Patnaik  		#****
**********#	Company			    : Aynsoft							     #***********
**********#	Copyright (c) www.aynsoft.com 2004	#***********
***********************************************************
***********************************************************
*/
define('HEADING_TITLE','Registro de empresa');

define('INFO_TEXT_FIRST_NAME','Nombre:');
define('MIN_FIRST_NAME_ERROR','El nombre debe contener un mínimo de ' . MIN_FIRST_NAME_LENGTH . ' caracteres.');

define('INFO_TEXT_LAST_NAME','Apellido:');
define('MIN_LAST_NAME_ERROR','Tu apellido debe contener un mínimo de ' . MIN_LAST_NAME_LENGTH . ' caracteres.');

define('SECTION_CONTACT_DETAILS','Tus detalles de contacto');
define('INFO_TEXT_EMAIL_ADDRESS','Dirección de correo electrónico:');
define('EMAIL_ADDRESS_ERROR','¡Oops! Tu dirección de correo electrónico ya existe.');
define('EMAIL_ADDRESS_INVALID_ERROR','¡Oops! Tu dirección de correo electrónico no es válida.');

define('INFO_TEXT_CONFIRM_EMAIL_ADDRESS','Confirm Dirección de correo electrónico:');
define('CONFIRM_EMAIL_ADDRESS_INVALID_ERROR','Your confirm Email-Address is not valid.');

define('EMAIL_ADDRESS_MATCH_ERROR','Your Email-address & confirm Email-Address does not match.');


##################################################
define('SECTION_COMPANY','Información de la empresa');

define('INFO_TEXT_POSITION','Tu cargo:');
define('POSITION_ERROR','Ingresa tu cargo.');
define('MIN_POSITION_ERROR','Tu título debe contener un mínimo de ' . MIN_POSITION_LENGTH . ' caracteres.');

define('INFO_TEXT_COMPANY_NAME','Nombre de empresa:');
define('MIN_COMPANY_NAME_ERROR','El nombre de tu empresa debe contener un mínimo de ' . MIN_COMPANY_NAME_LENGTH . ' caracteres.');

define('INFO_TEXT_ADDRESS1','Dirección de domicilio:');
define('MIN_ADDRESS_LINE1_ERROR','Tu dirección de domicilio debe contener un mínimo de ' . MIN_ADDRESS_LINE1_LENGTH . ' caracteres.');

define('INFO_TEXT_ADDRESS2','Dirección de domicilio:');
define('MIN_ADDRESS2_ERROR','');

define('INFO_TEXT_COUNTRY','País:');
define('ENTRY_COUNTRY_ERROR', 'Selecciona un país .');

define('INFO_TEXT_CITY','Ciudad:');

define('INFO_TEXT_STATE','Provincia:');
define('ENTRY_STATE_ERROR_SELECT', 'Selecciona una provincia.');
define('ENTRY_STATE_ERROR', 'Ingresa tu provincia');

define('INFO_TEXT_ZIP_CODE','Código postal:');
define('ZIP_CODE_ERROR','Ingresa el código postal.');

define('INFO_TEXT_TELEPHONE','Número de teléfono:');
define('TELEPHONE_ERROR','Ingresa el número de teléfono.');
define('INFO_TEXT_FAX','Fax:');

define('INFO_TEXT_PHOTO','Logotipo: ');

define('INFO_TEXT_URL','URL: ');

define('INFO_TEXT_NEWS_LETTER','Boletin informativo: ');
define('INFO_TEXT_AGREEMENT','<br><b>Nota: </b>Cuando haces clic en lo siguiente <b>button</b>, significa que has aceptado nuestros <a href="'.FILENAME_TERMS.'" target="terms">Términos y condiciones </a>y <a href="'.FILENAME_PRIVACY.'" target="terms">Política de privacidad</a>');

define('MESSAGE_SUCCESS_UPDATED','¡Listo! Cuenta actualizada.');
define('MESSAGE_SUCCESS_INSERTED','Cuenta ingresada.');

define('NEW_RECRUITER_SUBJECT','Gracias por registrarte en '.SITE_TITLE);

define('IMAGE_INSERT','Insertar');
define('IMAGE_UPDATE','Actualizar');
define('INFO_TEXT_NEW_USER_REGISTRATION_DEMO','Registro de nuevo reclutador de jobsite_demo');
define('INFO_TEXT_RECRUITER_NAME','Nombre del reclutador: ');
define('INFO_TEXT_RECRUITER_MAIL','Correo electrónico del reclutador: ');
define('LOGO_UPLOAD_ERROR','Sube un logo de tu empresa');
define('LOGO_UPLOAD_TYPE_ERROR','Sube un formato gif, jpeg, png');

?>