<?php 
class Prueba extends Mk\Shared\Model
{

/**
* @column
* @readwrite
* @primary
* @type autonumber
* @label Pk
*/
protected $_pk;
/**
* @column
* @readwrite
* @type varchar
* @label Nombre
*/
protected $_nombre;
/**
* @column
* @readwrite
* @type char
* @label Status
*/
protected $_status;
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
* @type datetime
* @label Modified
*/
protected $_modified;
public $_tSingular='prueba';
public $_tPlural='pruebas';


}


?>