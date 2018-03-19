<?php 
class Unidades extends Mk\Shared\Model
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
*/
protected $_nombre;
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion check
* @label Base
* @labelf Es Unidad Base?
*/
protected $_base='0';
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion st
* @label Tipo
* @validate  required
*/
protected $_tipo='X';
/**
* @column
* @readwrite
* @type float
* @uso A
* @funcion bdf
* @label RelBase
* @labelf Relacion con la Base
* @validate  numeric
*/
protected $_relBase='0.00';
/**
* @column
* @readwrite
* @type char
* @uso G
* @funcion custom
* @fcustom 1
* @label St
*/
protected $_status='1';
/**
* @column
* @readwrite
* @type datetime
* @uso G
* @funcion datetimesystem
* @label Created
*/
protected $_created;
/**
* @column
* @readwrite
* @type datetime
* @uso A
* @funcion datetimesystem
* @label Modified
*/
protected $_modified;
public $_tSingular='Unidad';
public $_tPlural='Unidades';


}


?>