<?php 
class Proveedores extends Mk\Shared\Model
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
protected $_nom;
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
* @type varchar
* @uso A
* @funcion st
* @label Telefono
* @validate  required
*/
protected $_tel;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label eMail
* @validate  mail
*/
protected $_mail;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Contacto
* @validate  required
*/
protected $_contacto;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Celular
*/
protected $_cel;
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
public $_tSingular='Proveedor';
public $_tPlural='Proveedores';


public function __construct($options = array())
	{
		parent::__construct($options);



	}
}

//version MK.CRUD 1.0 
?>