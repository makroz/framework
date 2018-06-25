<?php 
class Submenus extends Mk\Shared\Model
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
protected $_tipo='P';
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
* @type longtext
* @uso A
* @funcion st
* @label Contenido
*/
protected $_contenido;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Menu
* @validate  required, numeric
*/
protected $_fk_menus;
/**
* @column
* @readwrite
* @type tinyint
* @uso A
* @funcion 
* @label Posicion
* @labelf Posicion en Menu
* @validate  required, numeric
*/
protected $_posi='1';
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
public $_tSingular='Submenu';
public $_tPlural='Submenus';


public function __construct($options = array())
	{
		parent::__construct($options);

		$this->setJoins('menus','(submenus.fk_menus=j_menus.pk)',Array('j_menus.nom' => 'join_fk_menus'),j_menus);

	}
}

//version MK.CRUD 1.0 
?>