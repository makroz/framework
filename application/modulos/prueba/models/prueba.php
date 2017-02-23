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
* @label Nombre
* @validate  required
*/
protected $_nombre;
/**
* @column
* @readwrite
* @type char
* @label Base
*/
protected $_base;
/**
* @column
* @readwrite
* @type char
* @label Tipo
* @validate  required
*/
protected $_tipo;
/**
* @column
* @readwrite
* @type float
* @label RelBase
* @validate  required, numeric
*/
protected $_relBase;
/**
* @column
* @readwrite
* @type char
* @label St
*/
protected $_status;
/**
* @column
* @readwrite
* @type datetime
* @label Created
*/
protected $_created;
/**
* @column
* @readwrite
* @type datetime
* @label Modified
*/
protected $_modified;
public $_tSingular='unidad';
public $_tPlural='Uniades';


}


?>