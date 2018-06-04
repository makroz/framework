<?php 
class Sociales extends Mk\Shared\Model
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
* @label Red Social
* @validate  required
*/
protected $_nom;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Link de enlace
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
public $_tSingular='Red Social';
public $_tPlural='Redes Sociales';


public function __construct($options = array())
	{
		parent::__construct($options);



	}
}

//version MK.CRUD 1.0 
?>