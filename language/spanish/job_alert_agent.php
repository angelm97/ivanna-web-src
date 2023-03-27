<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/


if($_POST['action']=='search')
{
 define('HEADING_TITLE','Resultados de la búsqueda');
 define('INFO_TEXT_JOB_CATEGORY','Categoría de Trabajo :');

}
else
{
 define('HEADING_TITLE','Crear alerta');
 define('INFO_TEXT_JOB_CATEGORY','Sector laboral');
}

define('INFO_TEXT_KEYWORD','Palabra clave : ');
define('INFO_TEXT_KEYWORD_EXAMPLE','<font size="1"><i>&nbsp;Ej: Ejecutivo de ventas</i></font>');
define('INFO_TEXT_KEYWORD_CRITERIA','Elije tu criterio de búsqueda :');
define('INFO_TEXT_KEYWORD_WORD1','Cualquiera de estas palabras');
define('INFO_TEXT_KEYWORD_WORD2','Todas estas palabras');

define('INFO_TEXT_LOCATION','Dirección');
define('INFO_TEXT_JOB_CATEGORY_TEXT','¿En qué área te gustaría trabajar?');
define('INFO_TEXT_EXPERIENCE','Experiencia');
define('INFO_TEXT_JOB_POSTED','Fecha de publicación : ');
define('INFO_TEXT_DEFAULT_JOB_POST_DAY','Todas');


define('INFO_TEXT_COMPANY_NAME','Empresa ');
define('INFO_TEXT_LOCATION_NAME','Ubicación');
define('INFO_TEXT_POSTED_ON','Publicado en:');
define('INFO_TEXT_SALARY','Salario');
define('INFO_TEXT_SALARY_DOT',':');
define('INFO_TEXT_APPLY_BEFORE','Aplicar antes :');

define('INFO_TEXT_TITLE_NAME','Nombre de búsqueda: ');
define('INFO_TEXT_ALERT_TEXT','Guardar búsqueda como alerta de empleo');

define('INFO_TEXT_APPLY_NOW','¡Quiero aplciar! ');
define('INFO_TEXT_APPLY_NOW1','Postula a varias oportunidades laborales seleccionando los trabajos de tu interés.');

define('ENTRY_STATE_ERROR_SELECT', 'Selecciona un estado.');

define('INFO_TEXT_COUNTRY','What country would you like to work in? : ');
define('INFO_TEXT_STATE','¿En qué provincia te gustaría trabajar? :');

define('MESSAGE_SUCCESS_INSERTED','Alerta guardada.');
define('MESSAGE_SUCCESS_UPDATED','¡Listo! Tu búsqueda guardada se actualizó.');

define('MESSAGE_ERROR_SAVED_SERCH_NOT_EXIST','¡Oops! No se encuentra esta búsqueda guardada.');
define('MESSAGE_ERROR_SAVED_SERCH_ALREADY_EXIST','¡Oops! Elije otro nombre de búsqueda, el guardado ya existe.');

define('INFO_TEXT_JOB_TYPE','Tipo de empleo :');

define('IMAGE_SEARCH','Buscar');
define('IMAGE_SAVE','Guardar búsqueda');
define('IMAGE_CANCEL','Cancelar');
define('IMAGE_BACK','Atrás');
define('IMAGE_APPLY','¡Quiero aplciar!');
define('INFO_TEXT_CLICK_HERE_SEE_DETAILS','Haz clic aquí para ver detalles');
define('INFO_TEXT_HAS_MATCHED','Ha coincidido');
define('INFO_TEXT_TO_YOUR_SEARCH_CRITERIA','Según tus criterios de búsqueda.');
define('INFO_TEXT_JOB','Oportunidad laboral');
define('INFO_TEXT_JOBS','Oportunidades laborales');
define('INFO_TEXT_HAS_NOT_MATCHED','No encontramos oportunidades con tus intereses.');
define('INFO_TEXT_ALL_JOB_CATEGORY','Todos los sectores laborales');
define('INFO_TEXT_ALL_COUNTRIES','Todos los países');
define('INFO_TEXT_REFINE_SEARCH','Personaliza tú búsqueda');
define('INFO_TEXT_JOB_ALERT_CRITERIA','Periodicidad');
define('INFO_TEXT_DAILY','Diario');
define('INFO_TEXT_WEEKLY','Semanal');
define('INFO_TEXT_MONTHLY','Mensual');
define('INFO_TEXT_SEARCH_US_ZIP','US Zip');
define('INFO_TEXT_ZIP_CODE','Código postal');
define('INFO_TEXT_RADIUS','Código postal');
define('INFO_TEXT_SEARCH_COUNTRY_STATE','Pais');
define('INFO_TEXT_EMAIL_THIS_JOB','Enviar esta oportunidad laboral por correo electrónico');
define('MORE_DETAILS','Conocer más ');
define('INFO_TEXT_APPLY_TO_THIS_JOB','Aplica a esta oportunidad laboral');
define('ENTER_AGENT_NAME_ERROR','Ingresa el nombre del agente');
?>
