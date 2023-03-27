<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft             #**********
**********# Copyright (c) www.aynsoft.com 2004  #**********
**********************************************************/


if(isset($_GET['order_id']))
 define('HEADING_TITLE', 'Ordenes');
else
 define('HEADING_TITLE', 'Historial de Ordenes');

//////////////////////////
define('TABLE_HEADING_PLAN_TYPE_NAME', 'Nombre del tipo de plan');
define('TABLE_HEADING_PRICE', 'Precio');
define('TABLE_HEADING_PLAN_TYPE_TIME_PERIOD', 'Periodo de tiempo');
define('TABLE_HEADING_STATUS', 'Estado');
define('TABLE_HEADING_INSERTED', 'Fecha de inicio');
define('TABLE_HEADING_LAST_UPDATED', 'Fecha final');

define('MESSAGE_SUCCESS_DELETED','¡Listo! Pedido eliminado correctamente.');
define('MESSAGE_ORDER_ERROR','Lo siento, este pedido no existe. Si el problema persiste, comuníquese con el administrador.');

define('HEADING_TITLE_SEARCH', 'Solicitar ID:');
define('HEADING_TITLE_STATUS', 'Estado:');

define('TABLE_HEADING_COMMENTS', 'Comentarios del administrador : ');
define('TABLE_HEADING_MY_COMMENTS', 'Mis comentarios : ');
define('TABLE_HEADING_CUSTOMERS', 'Reclutadores');
define('TABLE_HEADING_ORDER_TOTAL', 'Total del pedido');
define('TABLE_HEADING_DATE_PURCHASED', 'Fecha de compra');
define('TABLE_HEADING_STATUS', 'Estado');
define('TABLE_HEADING_ACTION', 'Acción');
define('TABLE_HEADING_PRODUCTS', 'Productos : ');
define('TABLE_HEADING_TOTAL_PRICE', 'Precio total : ');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Cliente notificado');
define('TABLE_HEADING_DATE_ADDED', 'Fecha agregada');

define('ENTRY_CUSTOMER', 'Cliente:');
define('ENTRY_SOLD_TO', 'VENDIDO A:');
define('ENTRY_DELIVERY_TO', 'Entregar a:');
define('ENTRY_SHIP_TO', 'ENVIAR A:');
define('ENTRY_SHIPPING_ADDRESS', 'Dirección de envío:');
define('ENTRY_BILLING_ADDRESS', 'Dirección de envio::');
define('ENTRY_PAYMENT_METHOD', 'Método de pago:');
define('ENTRY_CREDIT_CARD_TYPE', 'Tipo de tarjeta de crédito:');
define('ENTRY_CREDIT_CARD_OWNER', 'Credit Card Owner:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Número de tarjeta de crédito:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Caducidad de la tarjeta de crédito:');
define('ENTRY_SUB_TOTAL', 'Total parcial:');
define('ENTRY_TAX', 'Impuesto:');
define('ENTRY_SHIPPING', 'Transporte:');
define('ENTRY_TOTAL', 'Total:');
define('ENTRY_DATE_PURCHASED', 'Fecha de compra:');
define('ENTRY_STATUS', 'Estado:');
define('ENTRY_DATE_LAST_UPDATED', 'Fecha de última actualización:');
define('ENTRY_NOTIFY_CUSTOMER', 'Notificar al cliente:');
define('ENTRY_NOTIFY_COMMENTS', 'Agregar comentarios:');
define('ENTRY_PRINTABLE', 'Imprimir factura');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Eliminar pedido');
define('TEXT_INFO_DELETE_INTRO', '¿Deseas eliminar este pedido?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Cantidad de producto de reabastecimiento');
define('TEXT_DATE_ORDER_CREATED', 'Fecha de creacion:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Última modificación:');
define('TEXT_INFO_PAYMENT_METHOD', 'Método de pago:');

define('TEXT_ALL_ORDERS', 'Todas las órdenes');
define('TEXT_NO_ORDER_HISTORY', 'No hay historial de pedidos disponible');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Order Update');
define('EMAIL_TEXT_ORDER_NUMBER', 'Número de orden:');
define('EMAIL_TEXT_INVOICE_URL', 'Factura detallada:');
define('EMAIL_TEXT_DATE_ORDERED', 'Fecha del pedido:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Tu pedido se ha actualizado al siguiente estado' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Los comentarios para tu pedido son' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', '¡Oops! El pedido no existe.');
define('SUCCESS_ORDER_UPDATED', '¡Listo! Pedido actualizado.');
define('WARNING_ORDER_NOT_UPDATED', '¡Oops! El pedido no se actualizó.');
define('SUCCESS_ORDER_DELETED', '¡Listo! El pedido se eliminó.');
define('WARNING_ORDER_ALREADY_COMPLETED', '¡Wao! Tu pedido está completo. Si deseas cambiar de cuenta, vaya a <b>Reclutadores</b> Sección.');

define('IMAGE_EDIT', 'Editar orden');
define('IMAGE_DELETE', 'Eliminar orden');
define('IMAGE_ORDERS_INVOICE', 'Factura');
define('TABLE_HEADING_PURCHASED','Comprado en');
?>