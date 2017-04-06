<?php 
class Resp extends Mk\Shared\Model
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
* @type char
* @uso G
* @funcion custom
* @fcustom 1
* @label St
*/
protected $_status;
public $_tSingular='Responsable';
public $_tPlural='Responsables';


}


?>