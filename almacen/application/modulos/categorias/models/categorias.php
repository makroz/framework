<?php 
class Categorias extends Mk\Shared\Model
{

/**
* @column
* @readwrite
* @primary
* @type autonumber
* @label Id
* @validate  required, numeric
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
* @type tinyint
* @uso A
* @funcion st
* @label Nivel
* @validate  required, numeric
*/
protected $_nivel;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Categ.Superior
* @labelf Categoria Superior
* @validate  required, numeric
*/
protected $_sk_padre;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Descripcion
*/
protected $_descrip;
/**
* @column
* @readwrite
* @type char
* @uso G
* @funcion custom
* @fcustom 1
* @label St
* @validate  required
*/
protected $_status;
public $_tSingular='Categoria';
public $_tPlural='Categorias';


}


?>