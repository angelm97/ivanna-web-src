<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/


define('HEADING_TITLE','Registrarme como talento');

define('REQUIRED_INFO','* Información requerida');
define('SECTION_ACCOUNT_DETAILS','Detalles de tu cuenta');
define('SECTION_ACCOUNT_PRIVACY','Tu información de privacidad');
define('SECTION_CONTACT_DETAILS','Tu información personal');
define('SECTION_ACCOUNT_RESUME_NAME','Nombre de la hoja de vida');

define('INFO_TEXT_PRIVACY','Privacidad :');
define('INFO_TEXT_RESUME_SEARCHEABLE','Mi hoja de vida se puede buscar :');
define('PRIVACY_ERROR','Selecciona la privacidad.');
define('INFO_TEXT_PRIVACY_HIDE_ALL','Ocultar mi información de contacto a todas las empresas.');
define('INFO_TEXT_PRIVACY_HIDE_CONTACT','Muestra mi información de contacto a las empresas a las que he aplicado.');
define('INFO_TEXT_PRIVACY_HIDE_NOTHING','Muestra mi información de contacto a todas las empresas.');
define('INFO_TEXT_PRIVACY_HIDE_RESUME','Privado: Por ahora, no quiero que las empresas encuentren mi hoja de vida.');

define('INFO_TEXT_FIRST_NAME','Primer nombre :');
define('MIN_FIRST_NAME_ERROR','Tu nombre debe contener un mínimo de ' . MIN_FIRST_NAME_LENGTH . ' caracteres.');

define('INFO_TEXT_MIDDLE_NAME','Segundo nombre :');

define('INFO_TEXT_LAST_NAME','Apellido :');
define('MIN_LAST_NAME_ERROR','Tu apellido debe contener un mínimo de ' . MIN_LAST_NAME_LENGTH . ' caracteres.');

define('INFO_TEXT_EMAIL_ADDRESS','Dirección de correo electrónico :');
define('EMAIL_ADDRESS_ERROR','Email-Address already exists.');
define('EMAIL_ADDRESS_INVALID_ERROR','Tu dirección de correo electrónico no es válida.');

define('INFO_TEXT_CONFIRM_EMAIL_ADDRESS','Confirm E-Mail Address :');
define('CONFIRM_EMAIL_ADDRESS_INVALID_ERROR','Your confirm Email-Address is not valid.');

define('EMAIL_ADDRESS_MATCH_ERROR','Your Email-address & confirm Email-Address does not match.');




define('INFO_TEXT_ADDRESS1','Dirección de domicilio :');
define('MIN_ADDRESS_LINE1_ERROR','Address must contain a minimum of ' . MIN_ADDRESS_LINE1_LENGTH . ' caracteres.');

define('INFO_TEXT_ADDRESS2','Dirección de domicilio :');

define('INFO_TEXT_NATIONALITY', 'Nacionalidad :');
define('ENTRY_NATIONALITY_ERROR', 'Please select Nationality.');

define('INFO_TEXT_MARITAL_STATUS', 'Marital Status :');
define('MARITAL_ERROR','Your must select marital status.');

define('INFO_TEXT_COUNTRY','Country :');
define('ENTRY_COUNTRY_ERROR', 'Please select Country.');

define('PLEASE_SELECT','Por favor selecciona...');

define('INFO_TEXT_STATE','Provincia :');
define('ENTRY_STATE_ERROR_SELECT', 'Selecciona un estado.');
define('ENTRY_STATE_ERROR', 'Incluye tu estado o provincia');

define('INFO_TEXT_CITY','Ciudad :');
define('MIN_CITY_ERROR','Tu ciudad debe contener un mínimo de ' . MIN_CITY_LENGTH . ' caracteres.');

define('INFO_TEXT_ZIP','Código postal :');
define('MIN_ZIP_ERROR', 'Zip code must contain a minimum of ' . MIN_ZIP_LENGTH . ' caracteres.');

define('INFO_TEXT_HOME_PHONE','Número de teléfono : ');
define('ENTRY_HOME_PHONE_ERROR', 'Completa el número de teléfono principal.');
define('INFO_TEXT_MOBILE','Móvil / Celular : ');

define('INFO_TEXT_NEWS_LETTER','Boletin informativo : ');

define('INFO_TEXT_AGREEMENT','<br><b>Nota : </b>Cuando haces clic en el siguiente <b>botón</b>, significa que ha aceptado nuestros <a href="'.FILENAME_TERMS.'" target="terms">Términos y condiciones </a>y <a href="'.FILENAME_PRIVACY.'" target="terms">Política de privacidad</a>');

define('NEW_JOBSEEKER_SUBJECT','Gracias por registrarte en '.'Cuchumil');
define('NEW_JOBSEEKER_EMAIL_TEXT','Querido/a <b>%s</b>,'."\n\n".'Gracias por registrarte en '.'Cuchumil'."\n\n".'Tu nombre de usuario: <b>%s</b>'."\n\n".'Tu contraseña: <b>%s</b>'."\n\n".'Puedes acceder a nuestro sitio con este nombre de usuario / contraseña.'. "\n\n" .'¡Gracias!' . "\n" . '%s ( Admin )'."\n\n" . 'Esta respuesta es automática, ¡No te preocupes por responder!');

define('MESSAGE_SUCCESS_UPDATED','¡Listo! Cuenta actualizada.');
define('MESSAGE_SUCCESS_INSERTED','¡Listo! Cuenta ingresada.');

define('NEW_RECRUITER_SUBJECT','Registro exitoso en '.'Cuchumil');

define('IMAGE_INSERT','Insertar');
define('IMAGE_UPDATE','Actualizar');
define('IMAGE_NEXT','Siguiente >>');
define('INFO_TEXT_NEW_JOBSEEKER_REGISTER','Registro de nuevos talentos de jobsite_demo');
define('INFO_TEXT_JOBSEEKER_NAME','Nombre del talento');
define('INFO_TEXT_JOBSEEKER_EMAIL','correo electrónico del talento');
define('INFO_TEXT_YES','Si');
define('INFO_TEXT_NO','No');
define('INFO_TEXT_SUBSCRIBE','Suscribir');
define('INFO_TEXT_PLEASE_SELECT_COUNTRY','Selecciona un país');
?>