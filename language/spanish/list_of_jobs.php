<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/

include_once("include_files.php");

if($_GET['action']=='add_screener' || $_GET['action']=='edit_screener')
{
 define('HEADING_TITLE', 'Agregar / Editar evaluador');
}
else
{
 define('HEADING_TITLE', 'Lista de Oportunidades');
}
//////////////////////////
define('HEADING_TITLE_READV', 'Volver a anunciar esta oportunidad laboral');
define('INFO_TEXT_READVERTISE', 'Volver a anunciar desde: ');
define('INFO_TEXT_ADVERTISE_WEEKS','¿Cuántas semanas te gustaría anunciar esta oportunidad laboral :');
////////////
define('TEXT_INFO_EDIT_JOB_INTRO', 'Realiza los cambios necesarios');
define('TEXT_DELETE_INTRO', '¿Quieres eliminar esta oportunidad laboral?');
define('TEXT_SCREENER_DELETE_INTRO', '¿Quieres eliminar este pregunta?');
if($_GET['j_status']=='deleted')
 define('TEXT_DELETE_WARNING', '<font color="red"><b>Ten en cuenta: </b></font> Con esta oportunidad también se eliminarán todos los datos del candidato.');
else
 define('TEXT_DELETE_WARNING', '<font color="red"><b>Ten en cuenta: </b></font>Esta oportunidad laboral no se eliminará por completo de la base de datos. Simplemente irá a <b>la categoría de eliminadas</b> Categoría.');

define('TEXT_DELETE_SCREENER_WARNING', '<font color="red"><b>Ten en cuenta: </b></font>Pantallazo se eliminará físicamente de la base de datos.');

define('TEXT_INFO_NEW_JOB_INTRO', 'No se agregó información del trabajo.');
define('TEXT_INFO_JOB_INSERTED', 'Oportunidad laboral agregada el:');
define('TEXT_INFO_JOB_UPDADED', 'Oportunidad laboral modificada en:');
define('TEXT_INFO_FULLNAME', 'Nombre:');
define('TEXT_INFO_EMAIL', 'Dirección de correo electrónico:');
define('TEXT_INFO_JOB_STARTS', 'El puesto comienza en:');
define('TEXT_INFO_JOB_ENDS', 'El puesto termina el:');
define('TEXT_INFO_JOB_JOB_STATUS', 'Estado de la oportunidad laboral:');
define('TEXT_INFO_JOB_NO_OF_JOBS', 'Número máximo de oportunidades laborales:');
define('TEXT_INFO_JOB_CV_STATUS', 'Estado de hoja de vida:');
define('TEXT_INFO_JOB_NO_OF_CVS', 'Número de días máximo para buscar hoja de vida:');



define('TABLE_HEADING_REFERENCE', 'Referencia');
define('TABLE_HEADING_TITLE', 'Puesto');
define('TABLE_HEADING_INSERTED', 'Publicación');
define('TABLE_HEADING_EXPIRED', 'Cierre');
define('TABLE_HEADING_STATUS', 'Estatus');
define('TABLE_HEADING_VIEWED', 'Perfiles alcanzados');
define('TABLE_HEADING_CLICKED', 'Visitas');
define('TABLE_HEADING_APPLICATIONS', 'Aplicaciones');
define('TABLE_HEADING_ACTION', 'Acción');

define('STATUS_JOB_INACTIVE', 'Inactivo');
define('STATUS_JOB_INACTIVATE', 'inactivar?');

define('STATUS_JOB_ACTIVE', 'Activo');
define('STATUS_JOB_ACTIVATE', '¿Activar?');


define('MESSAGE_SUCCESS_DELETED','Éxito: trabajo eliminado correctamente.');
define('MESSAGE_SUCCESS_UPDATED','Éxito: el trabajo se actualizó correctamente.');

define('MESSAGE_UNSUCCESS_SCREENER_DELETED','error: debido a algún problema, el examinador no se elimina.');
define('MESSAGE_SUCCESS_SCREENER_DELETED','¡Listo! Evaluador eliminado.');
define('MESSAGE_SUCCESS_JOB_UNDELETED','Success: Job is successfully Re-added.');

define('MESSAGE_SUCCESS_SCREENER_INSERTED','¡Listo! Preguntas Ingresadas.');
define('MESSAGE_SUCCESS_SCREENER_UPDATED','¡Listo! Preguntas Actualizadas.');
define('MESSAGE_JOB_SUCCESS_READVERTISED','¡Listo! La oportunidad laboral se volvió a publicar.');
define('MESSAGE_JOB_UNSUCCESS_READVERTISED','¡Oops¡No pudimos publicar nuevamente la oportunidad laboral.');
define('MESSAGE_JOB_UNSUCCESS_READVERTISED1','¡Oops! Te quedan % s puntos de trabajo, reduce las semanas de la oportunidad laboral');
define('MESSAGE_JOB_UNSUCCESS_READVERTISED2','¡Oops! Te quedan % s punto de trabajo, comunícate con nosotros AQUÍ, estamos para ayudarte.');

define('MESSAGE_JOB_ERROR','¡Oops¡No pudimos publicar nuevamente la oportunidad laboral. El Equipo WaoJobs está para ayudarte, escríbenos AQUÍ.');

define('MESSAGE_SUCCESS_STATUS_UPDATED','¡Lsito! Oportunidad laboral actualizada.');


define('INFO_TEXT_RESUME_WEIGHT','Asignar puntaje');

define('IMAGE_NEW','Agregar nueva oportunidad laboral');
define('IMAGE_BACK','Atrás');
define('IMAGE_NEXT','Próximo');
define('IMAGE_CANCEL','Cancelar');
define('IMAGE_INSERT','Insertar');
define('IMAGE_EDIT','Editar oportunidad laboral');
define('IMAGE_UPDATE','Actualizar');
define('IMAGE_DELETE','Eliminar oportunidad laboral');
define('IMAGE_CONFIRM','Confirmar eliminación');
define('IMAGE_PREVIEW','Vista previa de la oportunidad laboral');
define('IMAGE_UPDATE','Actualizar');
define('IMAGE_EDIT_JOB','Editar Oportunidad');
define('IMAGE_DELETE_JOB','Eliminar Oportunidad');
define('IMAGE_UNDELETE_JOB','Un-delete job');
define('IMAGE_READVERTISE','Volver a anunciar oportunidad laboral');
define('IMAGE_APPLICATIONS','Ver Aplicaciones');
define('IMAGE_ADD_SCREENER','Preguntas para Candidatos');
define('IMAGE_EDIT_SCREENER','Editar Preguntas');
define('IMAGE_DELETE_SCREENER','Eliminar Preguntas');
define('IMAGE_REPORT','Ver informes');
define('IMAGE_SELECTED_APPLICATIONS','Candidatos Seleccionados');

define('ERROR_QUESTION','Completa la pregunta no. <b>%s</b> primero.');
define('IMAGE_VIEW_JOB','Ver Oportunidad Laboral');
define('INFO_TEXT_QUESTION','Pregunta-');
define('INFO_TEXT_ACTIVE_JOBS','Activas');
define('INFO_TEXT_EXPIRED_JOBS','Inactivas');
define('INFO_TEXT_DELETED_JOBS','Eliminadas');
define('INFO_TEXT_OTHER_JOBS','Otras ');
define('INFO_TEXT_SPECIFY_VACANCY_PERIOD','Especifique el período de la oportunidades laboral');
define('INFO_TEXT_ONE_WEEK','Una semana');
define('INFO_TEXT_TWO_WEEKS','Dos semanas');
define('INFO_TEXT_THREE_WEEKS','Tres semanas');
define('INFO_TEXT_ONE_MONTH','Un mes');
define('INFO_TEXT_YES','Si');
define('INFO_TEXT_NO','No');
define('INFO_TEXT_SCREENER_QUESTION','¡Esta sección la hicimos pensando en tí! Aquí puedes agregar hasta 10 preguntas de selección para que los candidatos que apliquen, las respondan. Estas preguntas te ayudarán a filtrar los candidatos ideales ;).<br>
             <em>Esta es una característica opcional, no es necesaria para publicar en este cargo. </em>');
define('INFO_TEXT_ADD_UPTO_FIVE','Aquí puedes agregar hasta '.NO_OF_SCREENERS.' preguntas abiertas.<br>
¡Esta sección la hicimos pensando en tí! Aquí puedes agregar hasta '.NO_OF_SCREENERS.'  preguntas abiertas, las cuales te ayudarán a ver cómo responden los candidatos en sus propias palabras.

Ejemplos: <br>¿Cuál sería tu trabajo ideal? <br>¿Qué nos diría tu anterior jefe sobre tí? <br>¿Que es lo que más admiras de ti y lo que quisieras mejorar?')
?>
