<?php 
class Menus extends Mk\Shared\Model
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
* @type char
* @uso A
* @funcion st
* @label Tipo
*/
protected $_tipo='M';
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
public $_tSingular='Menu';
public $_tPlural='Menus';


public function __construct($options = array())
	{
		parent::__construct($options);



	}
}

//version MK.CRUD 1.0 
?>