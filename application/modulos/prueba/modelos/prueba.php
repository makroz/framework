<?php 
class Prueba extends Mk\Shared\Model
{

/**
* @column
* @readwrite
* @primary
* @type autonumber
* @label Pk
* @validate required
*/
protected $_pk;
/**
* @column
* @readwrite
* @index
* @type datetime
* @label Created
*/
protected $_created;
/**
* @column
* @readwrite
* @type char
* @label Status
* @validate required
*/
protected $_status;
/**
* @column
* @readwrite
* @type datetime
* @label Modified
*/
protected $_modified;
/**
* @column
* @readwrite
* @type varchar
* @label Nombre
*/
protected $_nombre;
public $_tSingular='prueba';
public $_tPlural='pruebas';


}


?>