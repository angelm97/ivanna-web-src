<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/


define('HEADING_TITLE','Registrarse - Candidato');
if(check_login("Candidato"))
	define('INFO_TEXT_CREATE_ACCOUNT','Editar perfil');
else
	define('INFO_TEXT_CREATE_ACCOUNT','Crea tu cuenta');

define('INFO_TEXT_JOIN','Unirse usando');
define('SECTION_ACCOUNT_DETAILS','Información de tu cuenta');
define('SECTION_CONTACT_DETAILS','Información personal');
define('INFO_TEXT_UPLOAD_RESUME','Subir mi hoja de vida:');
define('INFO_TEXT_UPLOAD_RESUME_HELP','Subir formato txt / doc / docx / pdf');
define('INFO_TEXT_UPLOAD_PHOTO_HELP','Subir formato gif / png / jpg');
define('SECTION_ACCOUNT_PRIVACY','Configuración de privacidad');
define('INFO_TEXT_PRIVACY_HIDE_ALL','Ocultar mi información de contacto a todas las empresas.');
define('INFO_TEXT_PRIVACY_HIDE_CONTACT','Mostrar mi información de contacto a las empresas a las que he solicitado.');
define('INFO_TEXT_PRIVACY_HIDE_NOTHING','Mostrar mi información de contacto a todas las empresas.');
define('INFO_TEXT_PRIVACY_HIDE_RESUME','Privado: Por ahora no quiero que las empresas vean mi hoja de vida.');
define('INFO_TEXT_ALREADY_MEMBER','¿Ya eres usuario?');


define('SECTION_PASSWORD','Tu contraseña');
define('SECTION_ACCOUNT_RESUME_NAME','Nombre de la hoja de vida');

define('INFO_TEXT_PRIVACY','Privacidad :');
define('INFO_TEXT_RESUME_SEARCHEABLE','Mi hoja de vida se puede buscar :');
define('PRIVACY_ERROR','Por favor selecciona privacidad.');

define('MIN_FIRST_NAME_ERROR','El nombre debe contener un mínimo de ' . MIN_FIRST_NAME_LENGTH . ' characters.');
define('MIN_LAST_NAME_ERROR','El apellido debe contener un mínimo de ' . MIN_LAST_NAME_LENGTH . ' characters.');
define('EMAIL_ADDRESS_ERROR','¡Oops! La dirección de correo electrónico ya existe.');
define('EMAIL_ADDRESS_INVALID_ERROR','Ingresa una dirección de correo electrónico válida.');
define('CONFIRM_EMAIL_ADDRESS_INVALID_ERROR','¡Oops! Tu dirección de correo electrónico confirmada no es válida.');
define('EMAIL_ADDRESS_MATCH_ERROR','¡Oops! Tu dirección de correo electrónico y la confirmación de dirección de correo electrónico no coinciden.');
define('MIN_PASSWORD_ERROR','¡Oops! Tu contraseña debe contener un mínimo de ' . MIN_PASSWORD_LENGTH . ' characters.');
define('MIN_CONFIRM_PASSWORD_ERROR','¡Oops! Tu confirmación de contraseña debe contener un mínimo de ' . MIN_PASSWORD_LENGTH . ' characters.');
define('PASSWORD_MATCH_ERROR','¡Oops! Tu contraseña y la confirmación de contraseña no coinciden. Nuestro Equipo está para ayudarte, escríbenos AQUÍ.');
define('MIN_ADDRESS_LINE1_ERROR','Tu dirección postal debe contener un mínimo de ' . MIN_ADDRESS_LINE1_LENGTH . ' characters.');
define('ENTRY_COUNTRY_ERROR', 'Selecciona el país del menú desplegable.');

define('PLEASE_SELECT','Selecciona');
define('ENTRY_STATE_ERROR_SELECT', 'Selecciona la ciudad en el menú desplegable .');
define('ENTRY_STATE_ERROR', 'Debes incluir tu ciudad');
define('MIN_CITY_ERROR','La ciudad debe contener un mínimo de ' . MIN_CITY_LENGTH . ' characters.');
define('MIN_ZIP_ERROR', 'El código postal debe contener un mínimo de ' . MIN_ZIP_LENGTH . ' characters.');
define('ENTRY_HOME_PHONE_ERROR', 'Completa el número de teléfono principal.');

define('INFO_TEXT_NEWS_LETTER','¡Noticias Cuchumil!');
define('INFO_TEXT_AGREEMENT','Al continuar, aceptas nuestros <a href="'.FILENAME_TERMS.'">Términos y Condiciones </a> y <a href="'.FILENAME_PRIVACY.'">Política de privacidad</a>.');


define('NEW_JOBSEEKER_SUBJECT','Gracias por registrarte en '.SITE_TITLE);
define('NEW_JOBSEEKER_EMAIL_TEXT','Querido (a) <b>%s</b>,'."\n\n".'Gracias por registrarte en '.SITE_TITLE."\n\n".'Tu nombre de usuario: <b>%s</b>'."\n\n".'Tu contraseña: xxxxx'."\n\n".'Puedes acceder a nuestro sitio con este nombre de usuario / contraseña.'. "\n\n" .'¡Gracias!' . "\n" . '%s ( Admin )'."\n\n" . 'Esta respuesta es automática, ¡No te preocupes por responder!');

define('MESSAGE_SUCCESS_UPDATED','¡Listo! Cuenta actualizada.');
define('MESSAGE_SUCCESS_INSERTED','¡Listo! Cuenta ingresada.');

define('NEW_RECRUITER_SUBJECT','Registro exitoso en '.SITE_TITLE);
define('RESUME_SEARCHABLE','¿Quieres que tu perfil aparezca en la búsqueda de las empresas?');
define('CAPTCHA_ERROR','Captcha Error');

define('IMAGE_INSERT','Insertar');
define('IMAGE_UPDATE','Actualizar');
define('IMAGE_NEXT','Próximo >>');
define('INFO_TEXT_NEW_JOBSEEKER_REGISTER','Registro de nuevos candidatos de jobsite_demo');
define('INFO_TEXT_JOBSEEKER_NAME','Nombre del talento');
define('INFO_TEXT_JOBSEEKER_EMAIL','correo electrónico del talento');
define('INFO_TEXT_YES','Si');
define('INFO_TEXT_NO','No');
define('INFO_TEXT_SUBSCRIBE','Quiero suscribirme');
define('INFO_TEXT_PLEASE_SELECT_COUNTRY','Selecciona un país');
?>