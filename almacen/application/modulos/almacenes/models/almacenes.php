<?php 
class Almacenes extends Mk\Shared\Model
{

/**
* @column
* @readwrite
* @primary
* @type autonumber
* @label Id
* @validate  numeric
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
* @label Direccion
*/
protected $_dir;
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion 
* @label Estado
* @validate  required
*/
protected $_estado;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion 
* @label Resp
* @labelf Responsable del Almacen
* @validate  required
*/
protected $_fk_resp;
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