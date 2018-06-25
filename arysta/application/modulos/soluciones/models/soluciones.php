<?php 
class Soluciones extends Mk\Shared\Model
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
* @label Nom
* @validate  required
*/
protected $_nom;
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
* @type tinyint
* @uso A
* @funcion 
* @label Posi
* @labelf Posicion
* @validate  required, numeric
*/
protected $_posi;
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
public $_tSingular='Solucion';
public $_tPlural='Soluciones';


public function __construct($options = array())
	{
		parent::__construct($options);



	}
}

//version MK.CRUD 1.0 
?>