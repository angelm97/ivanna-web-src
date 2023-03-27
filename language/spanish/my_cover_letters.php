<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/

$action = (isset($_GET['action']) ? $_GET['action'] : '');
if($action=='add_new')
 define('HEADING_TITLE', 'Agregar carta de presentación');
else if(tep_not_null($_GET['cID']))
{
 define('HEADING_TITLE', 'Editar carta de presentación');
}
else
 define('HEADING_TITLE', 'Lista de cartas de presentación');
//////////////////////////
define('TABLE_HEADING_COVER_LETTER_NAME', 'Nombre carta');
define('TABLE_HEADING_COVER_LETTER_VALUE', 'Valor');
define('TABLE_HEADING_INSERTED', 'Fecha creación');
define('TABLE_HEADING_UPDATED', 'Fecha actualización');
define('TABLE_HEADING_EDIT', 'Editar');
define('TABLE_HEADING_DELETE', 'Borrar');
define('TABLE_HEADING_VIEW', 'Ver');
define('TABLE_HEADING_DUPLICATE', 'Duplicar');

define('INFO_TEXT_COVER_LETTER_NAME', 'Nombre carta : ');
define('INFO_TEXT_COVER_LETTER_NAME_ERROR', 'Ingresa el nombre de la carta de presentación.');

define('INFO_TEXT_COVER_LETTER_DESCRIPTION', 'Descripción : ');
define('INFO_TEXT_COVER_LETTER_DESCRIPTION_ERROR', 'Ingresa la descripción de la carta de presentación.');
define('SAME_COVER_LETTER_NAME_ERROR', '¡Oops! Este nombre ya existe.');

define('INFO_TEXT_MAX_COVERLETTER', 'La carta de presentación es el mensaje que envías a las empresas cuando aplicas a alguna vacante ¡Puedes crear las que necesites!');
define('ERROR_EXCEED_MAX_NO_COVERLETTER','¡Oops! Ya lo has creado <b>%d</b> Este es el número máximo de cartas de presentación que un candidato puede crear.');

define('MESSAGE_SUCCESS_SAVED','Tu carta de presentación se ha guardado.');
define('MESSAGE_SUCCESS_UPDATED','Tu carta de presentación se ha actualizado.');
define('MESSAGE_SUCCESS_DELETED','¡Listo! La carta de presentación se ha eliminado correctamente.');
define('MESSAGE_SUCCESS_DUPLICATED','Tu carta de presentación se ha duplicado.');

define('MESSAGE_COVER_LETTER_ERROR','¡Oops! Esta carta de presentación no existe. Si el problema persiste, comunícate con el Equipo WaoJobs AQUÍ.');
define('IMAGE_UPDATE','Actualizar');
define('IMAGE_SAVE','Ahorrar');
define('IMAGE_CANCEL','Cancelar');
define('INFO_TEXT_ADD_COVER_LETTER','Agregar');
?>