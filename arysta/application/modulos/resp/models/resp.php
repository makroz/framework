<?php 
class Resp extends Mk\Shared\Model
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
* @index
* @type varchar
* @uso A
* @funcion st
* @label Doc
* @labelf Documento de Identidad
* @validate  required
*/
protected $_doc;
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
* @label Iniciales
*/
protected $_iniciales;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Tel
* @labelf Telefonos
*/
protected $_tel;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Cel
* @labelf Celular
*/
protected $_cel;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Mail
* @validate  mail
*/
protected $_mail;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Dir
* @labelf Direccion
*/
protected $_dir;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Password
* @validate  required
*/
protected $_pass;
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
public $_tSingular='Responsable';
public $_tPlural='Responsables';


public function __construct($options = array())
	{
		parent::__construct($options);



	}
}

//version MK.CRUD 1.0 
?>