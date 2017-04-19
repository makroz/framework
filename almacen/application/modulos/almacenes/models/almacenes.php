<?php 
class Almacenes extends Mk\Shared\Model
{

/**
* @column
* @readwrite
* @primary
* @type autonumber
* @label Id
* @validate  required, numeric
*/
protected $_pk;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Nombre
* @validate  required
*/
protected $_nombre;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Dirreccion
*/
protected $_dir;
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion st
* @label Estado
* @validate  required
*/
protected $_estado;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Responsable
* @validate  required, numeric
*/
protected $_fk_resp;
/**
* @column
* @readwrite
* @type date
* @uso A
* @funcion 
* @label Ult.Inventario
* @labelf Fecha del Ultimo Inventario
*/
protected $_fecultinv;
/**
* @column
* @readwrite
* @type tinyint
* @uso A
* @funcion st
* @label Lapso
* @labelf Lapso entre Inventarios
* @validate  required, numeric
*/
protected $_lapso;
/**
* @column
* @readwrite
* @type char
* @uso G
* @funcion custom
* @fcustom 1
* @label St
*/
protected $_status;
public $_tSingular='Almacen';
public $_tPlural='Almacenes';


}


?>