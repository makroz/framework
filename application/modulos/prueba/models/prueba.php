<?php 
class Prueba extends Mk\Shared\Model
{

/**
* @column
* @readwrite
* @primary
* @type autonumber
* @label Id
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
* @type char
* @uso A
* @funcion check
* @checkvalor 1/0
* @label Base
*/
protected $_base;
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion st
* @label Tipo
* @validate  required
*/
protected $_tipo;
/**
* @column
* @readwrite
* @type float
* @uso A
* @funcion bdf
* @label RelBase
* @validate  required, numeric
*/
protected $_relBase;
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
public $_tSingular='unidad';
public $_tPlural='Uniades';


}


?>