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
* @funcion st
* @label Tipo
* @validate  required
*/
protected $_tipo='X';
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
* @type float
* @uso A
* @funcion bdf
* @label Relbase
* @validate  required, numeric
*/
protected $_relbase='0.00';
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
* @label Created_
*/
protected $_created_;
/**
* @column
* @readwrite
* @type datetime
* @uso A
* @funcion datetimesystem
* @label Modified_
*/
protected $_modified_;
public $_tSingular='Unidad';
public $_tPlural='Unidades';


public function __construct($options = array())
	{
		parent::__construct($options);



	}
}

//version MK.CRUD 1.0 
?>