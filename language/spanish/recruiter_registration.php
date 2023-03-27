<?
/*
***********************************************************
***********************************************************
**********#	Name				      : Shambhu Prasad Patnaik  		#***********
**********#	Company			    : Aynsoft							     #***********
**********#	Copyright (c) www.aynsoft.com 2004	#***********
***********************************************************
***********************************************************
*/
if(check_login("recruiter"))
	define('HEADING_TITLE','Editar perfil');
else
	define('HEADING_TITLE','Registra tu empresa');

define('MIN_FIRST_NAME_ERROR','Tu nombre debe contener un mínimo de ' . MIN_FIRST_NAME_LENGTH . ' characters.');

define('MIN_LAST_NAME_ERROR','Tu nombre debe contener un mínimo de ' . MIN_LAST_NAME_LENGTH . ' characters.');

define('SECTION_CONTACT_DETAILS','Tus detalles de contacto');
define('EMAIL_ADDRESS_ERROR','¡Oops! Tu dirección de correo electrónico ya existe.');
define('EMAIL_ADDRESS_INVALID_ERROR','¡Oops! Tu dirección de correo electrónico no es válida.');

define('CONFIRM_EMAIL_ADDRESS_INVALID_ERROR','¡Oops! Tu dirección de correo electrónico confirmada no es válida.');

define('EMAIL_ADDRESS_MATCH_ERROR','¡Oops! Tu confirmación de correo electrónico no coincide.');

define('SECTION_PASSWORD_DETAILS','Tu contraseña');
define('INFO_TEXT_PASSWORD','Contraseña :');
define('MIN_PASSWORD_ERROR','Tu contraseña debe contener un mínimo de ' . MIN_PASSWORD_LENGTH . ' characters.');

define('INFO_TEXT_CONFIRM_PASSWORD','Confirmar contraseña :');
define('MIN_CONFIRM_PASSWORD_ERROR','Tu contraseña debe contener un mínimo de ' . MIN_PASSWORD_LENGTH . ' characters.');

define('PASSWORD_MATCH_ERROR','Tu confirmación de contraseña y contraseña no coinciden.');

##################################################
define('SECTION_COMPANY','Información de la empresa');

define('POSITION_ERROR','Por favor ingresa su posición.');
define('MIN_POSITION_ERROR','Tu título debe contener un mínimo de ' . MIN_POSITION_LENGTH . ' characters.');

define('MIN_COMPANY_NAME_ERROR','El nombre de tu empresa debe contener un mínimo de ' . MIN_COMPANY_NAME_LENGTH . ' characters.');

define('MIN_ADDRESS_LINE1_ERROR','Tu dirección debe contener un mínimo de ' . MIN_ADDRESS_LINE1_LENGTH . ' characters.');

define('MIN_ADDRESS2_ERROR','');

define('ENTRY_COUNTRY_ERROR', 'Debes seleccionar un país del menú desplegable.');

define('ENTRY_STATE_ERROR_SELECT', 'Selecciona una ciudad del menú desplegable.');
define('ENTRY_STATE_ERROR', 'Debes incluir tu ciudad');

define('ZIP_CODE_ERROR','Ingresa tu código postal.');

define('TELEPHONE_ERROR','Ingresa tu número de teléfono.');

define('INFO_TEXT_PHOTO','Logo : ');


define('INFO_TEXT_AGREEMENT','<br>Ten en cuenta que cuando haces clic en el siguiente botón, significa que has aceptado nuestros <a href="'.FILENAME_TERMS.'" target="terms">Términos y condiciones </a>y <a href="'.FILENAME_PRIVACY.'" target="privacy">Política de privacidad</a>');

define('MESSAGE_SUCCESS_UPDATED','¡Cuenta actualizada con éxito!.');
define('MESSAGE_SUCCESS_INSERTED','¡Cuenta insertada correctamente!.');

define('NEW_RECRUITER_SUBJECT','Gracias por registrarte en '.SITE_TITLE);

define('IMAGE_INSERT','Insertar');
define('IMAGE_UPDATE','Actualizar');
define('INFO_TEXT_NEW_USER_REGISTRATION_DEMO','Registro de nueva empresa de jobsite_demo');
define('INFO_TEXT_RECRUITER_NAME','Nombre de la empresa : ');
define('INFO_TEXT_RECRUITER_MAIL','Correo electrónico de la empresa : ');
define('LOGO_UPLOAD_ERROR','Sube un logo de tu empresa');
define('LOGO_UPLOAD_TYPE_ERROR','Sube un formato gif, jpeg, png');
define('CAPTCHA_ERROR','Error de CAPTCHA');
define('INFO_PERSONAL_DETAILS','Información de tu cuenta');
define('INFO_COMPANY_DETAILS','Información de la empresa');
define('INFO_UPLOAD_GIF','Aún no has seleccionado ningún archivo formato gif / jpg / jpeg / png');
define('INFO_TEXT_NEWSLETTER','¡Noticias Wao!');
define('INFO_TEXT_CONTINUE','Al continuar, aceptas nuestros ');
define('INFO_AND','y ');
define('INFO_PREVIEW','Logo actual');
define('INFO_JOIN_USING','Unirse usando');
define('INFO_SUBSCRIBE','Quiero suscribirme');
define('INFO_ALREADY_MEMBER','¿Ya eres usuario?');
define('INFO_SIGN_IN','Iniciar sesión');
define('INFO_SIGN_UP','Siguiente');
?>