<?
if($_POST['action']=='search')
{
 define('HEADING_TITLE', 'Lista de oportunidades laborales');
}
else
 define('HEADING_TITLE', 'Buscar oportunidades laborales por empresa');

define('INFO_TEXT_COMPANY_NAME','Nombre de empresa: ');

define('TABLE_HEADING_JOB_TITLE', 'Título profesional');
define('TABLE_HEADING_COMPANY_NAME', 'Nombre de empresa');
define('TABLE_HEADING_JOB_CATEGORY', 'Categoría de trabajo');
define('TABLE_HEADING_ADVERTISED', 'Anunciado en');
define('TABLE_HEADING_EXPIRED', 'Expirado el');
define('TABLE_HEADING_APPLY', 'Aplica');

define('MESSAGE_JOB_ERROR','¡Oops! Esta oportunidad laboral ya no se encuentra. El Equipo WaoJobs está para ayudarte, escríbenos AQUÍ.');
define('ERROR_NO_COMPANIES_EXISTS','¡Oops! No hay empresas. El Equipo WaoJobs está para ayudarte, escríbenos AQUÍ.');

define('IMAGE_BACK','Atrás');
define('INFO_TEXT_APPLY_NOW','¡Quiero aplicar!');
define('INFO_TEXT_JOB','Oportunidad laboral');
define('INFO_TEXT_JOBS','Oportunidades laborales');
define('INFO_TEXT_HAS_MATCHED',' Ha coincidido');
define('INFO_TEXT_TO_YOUR_SEARCH_CRITERIA','según tus criterios de búsqueda.');
define('INFO_TEXT_HAS_NOT_MATCHED','no ha coincidido ninguna oportunidad laboral con tus criterios de búsqueda.');
define('INFO_TEXT_HAVE','has');
define('INFO_TEXT_COMPANY_IN_DIRECTORY','Encontramos % empresa brindando oportunidades laborales.');
define('INFO_TEXT_NO_COMPANY_DIRECTORY','Ninguna empresa en el directorio de la empresa.');

//*********************************************************************//
define('INFO_TEXT_CURRENT_RATING','Valoración actual: ');
define('INFO_TEXT_CURRENT_RATE_IT','Puntúalo');
define('INFO_TEXT_CURRENT_RATE_STRING','');
define('SECTION_RATE_COMPANY','Tasa de empresa');
define('INFO_TEXT_NOT_RATED','No clasificado');
define('MESSAGE_SUCCESS_RATED','Reclutador calificado con éxito.');

?>