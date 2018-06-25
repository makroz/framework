<?php 
class Nodos extends Mk\Shared\Model
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
* @label Titulo
* @validate  required
*/
protected $_titulo;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Descrip
*/
protected $_descrip;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Boton
*/
protected $_boton;
/**
* @column
* @readwrite
* @type tinyint
* @uso A
* @funcion st
* @label Color
* @validate  numeric
*/
protected $_color='0';
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Link
*/
protected $_link;
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
public $_tSingular='Nodo';
public $_tPlural='Nodos';


public function __construct($options = array())
	{
		parent::__construct($options);



	}
}

//version MK.CRUD 1.0 
?>