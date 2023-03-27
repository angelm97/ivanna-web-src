<?
/*
************************************************************
**********#	Name				       Shambhu Prasad Patnaik #********
**********#	Company			     Aynsoft	Pvt. Ltd.   #***********
**********#	Copyright (c) www.aynsoft.com 2004	 #***********
************************************************************
*/
if($_GET['action']=='send_to_friend')
 define('HEADING_TITLE','Envía tu hoja de vida a tu amigo/a');
elseif($_GET['action']=='contact')
 define('HEADING_TITLE','Contacto con candidato');
else
 define('HEADING_TITLE','Reanudar');

define('INFO_TEXT_CURRENT_RATING','Valoración actual : ');
define('INFO_TEXT_CURRENT_RATE_IT','Puntúalo ');
define('INFO_TEXT_CURRENT_RATE_STRING','');
//define('INFO_TEXT_CURRENT_RATE_STRING',' ( <b>Nota  </b>Solo la empresa puede calificarte. ) ');
define('SECTION_RATE_RESUME','Calificar hoja de vida');
define('SECTION_PERSONAL_PROFILE','Perfil personal');
define('SECTION_OBJECTIVE','Objetivo');
define('SECTION_WORK_HISTORY_DETAIL','Experiencia laboral');
define('SECTION_EDUCATION_DETAILS','Detalles de educación');
define('SECTION_AFFILIATIONS','Afiliaciones');
define('SECTION_SKILLS','Habilidades');
define('SECTION_LANGUAGES','Idiomas');
define('SECTION_REFERENCES','Referencias');
define('SECTION_ADDITIONAL_INFO','Información Adicional');
define('SECTION_CAREER_INFORMATION','Información de carrera');
define('SECTION_TARGET_JOB','Trabajo ideal');
define('SECTION_TARGET_JOB_LOCATIONS','Ubicación del trabajo');
define('SECTION_TARGET_LOCATIONS','Ubicación del trabajo');

define('SECTION_DOCUMENT_UPLOAD','Reanudar');
define('SECTION_DOCUMENT_CUT_PASTE_RESUME','Cortar y pegar hoja de vida');
define('SECTION_SOCUMENT_UPLOAD_PR','Foto');
define('SECTION_ATTACHMENT','Adjunto hoja de vida');
define('SECTION_ATTACHMENT','Adjunto hoja de vida');
define('SECTION_DOCUMENT_VIDEO','Reanudar video');

define('INFO_TEXT_HOME_PHONE','Número de teléfono ');
define('INFO_TEXT_MOBILE','Número de móvil / celular');
define('INFO_TEXT_ADDRESS','Dirección ');

define('SECTION_POSITION','Detalle de posición');

define('INFO_TEXT_TARGET_JOB','Trabajo ideal');
define('INFO_TEXT_CATEGORY','Categoría de trabajo');

define('INFO_TEXT_DEFALUT',"Hola %s, \n\n\n\n %s (%s) han enviado un mensaje para ti. \n\n\n\n");
define('SECTION_PROFESSIONAL_DETAILS','Detalles Profesionales');
define('SECTION_EDUCATION_AND_TRAINING','Educación y entrenamiento');
define('SECTION_LICENSES_AND_CERTIFICATIONS','Licencias y certificaciones');
define('SECTION_BOARD_CERTIFICATION','Certificación de la junta (solo personal médico) ');
define('SECTION_MEMBERSHIPS','Membresías');
define('SECTION_NURSING_CERTIFICATIONS','Certificaciones de enfermería');

define('SECTION_EXPERINCE_SUMMARY','Resumen de la experiencia');

define('SECTION_WORK_HISTORY','Detalles de la experiencia');

define('SECTION_CERTIFICATION','Certificación');

define('INFO_TEXT_OBJECTIVE','Sobre mi');

define('INFO_TEXT_CAREER_LEVEL','Nivel de carrera');
define('INFO_TEXT_WORK_EXPERIENCE','Experiencia laboral total');
define('INFO_TEXT_DEGREE_LEVEL','Nivel de grado alcanzado');
define('INFO_TEXT_TARGET_JOB_TITLE','Título del trabajo');

define('INFO_TEXT_TARGET_JOB_TITLES','Trabajo ideal');
define('INFO_TEXT_JOB_TYPE','Tipo de contrato');
define('INFO_TEXT_JOB_STATUS','Estado del trabajo');
define('INFO_TEXT_DESIRED_SALARY','Aspiración salarial');
define('INFO_TEXT_INDUSTRY','Sector laboral');

define('INFO_TEXT_TARGET_JOB_LOCATIONS','Ubicaciones de trabajo de destino');
define('INFO_TEXT_RELOCATE','Dispuesto a cambiar de ciudad');
define('INFO_TEXT_WORK_STATUS','Situación laboral');

define('INFO_TEXT_UPON_RECEIVING','Al recibir una oferta de trabajo, ¿cuándo puede empezar? (Seleccione uno) ');
define('INFO_TEXT_CAN_START','Al recibir una oferta de trabajo puedo empezar');
define('INFO_TEXT_ON_THIS_DATE','Puedo empezar en esta fecha');


define('INFO_TEXT_DEGREE','Nivel de grado');
define('INFO_TEXT_INSTITUTION_NAME','Instituto ');

define('INFO_TEXT_CITY','Ciudad/pueblo');
define('INFO_TEXT_STATE','Provincia');
define('INFO_TEXT_COUNTRY','País');
define('INFO_TEXT_LOCATION','Dirección');
define('INFO_TEXT_COURSE_DURATION','Duración del curso');
define('INFO_TEXT_JOB_PERIOD','Periodo de trabajo');
define('INFO_TEXT_CONTACT_DETAILS','Detalles de contacto');
define('INFO_TEXT_START_DATE','Fecha de inicio');
define('INFO_TEXT_END_DATE','Fecha final');
define('INFO_TEXT_RELATED_INFO','Descripción ');

define('INFO_TEXT_ORGANIZATION','Nombre de la organización');
define('INFO_TEXT_AFFILIATION_ROLE','Afiliación / Rol');
define('INFO_TEXT_AF_START_DATE','Fecha de inicio');
define('INFO_TEXT_AF_END_DATE','Fecha final');

define('INFO_TEXT_SKILL','Habilidad');
define('INFO_TEXT_SKILL_LEVEL','Nivel de habilidad');
define('INFO_TEXT_LAST_USED','Utilizado por última vez');
define('INFO_TEXT_YEARS_OF_EXP','Años de experiencia');

define('INFO_TEXT_LANGUAGE','Idioma ');
define('INFO_TEXT_PROFICIENCY','Competencia ');

define('INFO_TEXT_WORK_STATUS','Situación laboral');
define('INFO_TEXT_WORK_STATUS_COUNTRY','País');
define('INFO_TEXT_LANGUAGE','Idioma ');

define('INFO_TEXT_NAME','Nombre ');
define('INFO_TEXT_NATIONALITY','Nacionalidad ');
define('INFO_TEXT_TITLE','Título ');
define('INFO_TEXT_COMPANY','Empresa ');
define('INFO_TEXT_PHONE','Teléfono ');
define('INFO_TEXT_EMAIL','Correo electrónico ');
define('INFO_TEXT_TYPE','Tipo ');

define('INFO_TEXT_ADDITIONAL_INFO','Información adicional ');
define('INFO_TEXT_AVAILABILITY','<strong>Disponibilidad </strong>');

define('INFO_TEXT_FROM_NAME','Tu nombre completo  ');
define('INFO_TEXT_FROM_EMAIL_ADDRESS','Tu dirección de correo electrónico  ');
define('INFO_TEXT_TO_NAME','El nombre completo de tu amigo/a ');
define('INFO_TEXT_TO_EMAIL_ADDRESS','La dirección de correo electrónico de tu amigo/a ');
define('INFO_TEXT_SUBJECT','Sujeto  ');
define('INFO_TEXT_MESSAGE','Mensaje  ');
define('IMAGE_SEND','Enviar');

////////////////////
define('INFO_TEXT_JOB','Título profesional');
define('MESSAGE_ERROR_JOB_NOT_EXIST','Error no existe trabajo.');
define('MESSAGE_ERROR_ALREADY_BOOKMARKED','Error ya marcado.');
define('MESSAGE_SUCCESS_BOOKMARK','Marcar correctamente este currículum.');
define('IMAGE_BOOKMARK_TO_JOB','Marcar como trabajo.');

define('MESSAGE_SUCCESS_RATED','Calificó con éxito esta hoja de vida.');
define('MESSAGE_SUCCESS_SAVED','Se guardó correctamente esta hoja de vida.');
define('MESSAGE_SUCCESS_SEND_LINK','¡Hoja de vida compartida!.');
define('SUCCESS_EMAIL_SENT','Envíe con éxito tu mensaje a la persona que busca empleo.');

define('ERROR_JOBSEEKER_NOT_EXIST','¡Oops! El candidato no se encuentra.');
define('ERROR_SEARCH_RESUME_FIRST','¡Oops! Primero debes buscar la hoja de vida.');
define('ERROR_MESSAGE_JOBSEEKER_NOT_ALLOWED','¡Oops! El reclutador no puede calificar el currículum.');

define('YOUR_NAME_ERROR','Escribe tu nombre.');
define('YOUR_FRIEND_NAME_ERROR','Ingresa el nombre de tu amigo/a.');
define('YOUR_FRIEND_EMAIL_ERROR','Introduce la dirección de correo electrónico de su amigo.');
define('EMAIL_SUBJECT_ERROR','Ingresa el asunto del correo electrónico.');
define('EMAIL_MESSAGE_ERROR','Ingresa el mensaje de correo electrónico.');

define('IMAGE_RATE','Velocidad');
define('IMAGE_ADD','Agregar');
define('IMAGE_BACK','atrás');
define('IMAGE_PRINT','Impresión');
define('IMAGE_SEND_TO_FRIEND','Enviar hoja de vida a un amigo');
define('IMAGE_SAVE_RESUME','Guardar hoja de vida');
define('IMAGE_CONTACT_ME','Contáctame');
define('IMAGE_DOWNLOAD','Descargar');

define('SECTION_SOCIAL_ACCOUNT','Cuenta social');
define('INFO_TEXT_FACEBOOK_URL','Facebook URL');
define('INFO_TEXT_GOOGLE_URL','URL de Google +');
define('INFO_TEXT_LINKEDIN_URL','URL de LinkedIn');
define('INFO_TEXT_TWITTER_URL','URL de Twitter');

define('SECTION_REFERENCE_DETAILS','Referencias personales');
define('INFO_TEXT_REFERENCE_NAME','Nombre ');
define('INFO_TEXT_COMPANY_NAME','Nombre de empresa ');
define('INFO_TEXT_COUNTRY','País ');
define('INFO_TEXT_POSITION_TITLE','Posición ');
define('INFO_TEXT_CONTACT_NO','Número de contacto');
define('INFO_TEXT_EMAIL_ADDRESS','Dirección de correo electrónico');
define('INFO_TEXT_RELATIONSHIP','Relación ');
define('INFO_TEXT_BOOKMARK_RESUME','Esto se agregará en la hoja de vida del candidato');
define('INFO_TEXT_PRINT_RESUME','Imprimir hoja de vida');
define('INFO_TEXT_HI','Hola');
define('INFO_TEXT_YOUR_FRIEND','tu amigo/a');
define('INFO_TEXT_HAS_SENT','te ha enviado un mensaje.');
define('INFO_TEXT_EMAIL_ADDRESS_IS','Tu dirección de correo electrónico es');
define('INFO_TEXT_MESSAGE_HIS_HER','Tu mensaje es el siguiente ...');
define('INFO_TEXT_RESUME_LINK','Reanudar enlace');
define('INFO_TEXT_PRIVATE_NOTES','Notas privadas');
define('INFO_TEXT_ANY_TYPE','Cualquier tipo');
define('INFO_TEXT_YEARS','Años');
define('INFO_TEXT_YEAR','Año');
define('INFO_TEXT_MONTHS','Meses');
define('INFO_TEXT_MONTH','Mes');
define('INFO_TEXT_JOB_TITLE','Título profesional');
define('INFO_TEXT_SALARY','Salario  ');
define('INFO_TEXT_CITY','Ciudad ');
define('INFO_TEXT_STATE1','Expresar  ');
define('INFO_TEXT_FROM','De ');
define('INFO_TEXT_TO','Para  ');
define('INFO_TEXT_NOT_RATED','no calificado');
define('INFO_TEXT_DOENLOAD_RESUME','descargar hoja de vida');


?>
