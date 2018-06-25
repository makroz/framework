<?php 
class Subculturas extends Mk\Shared\Model
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
* @type int
* @uso A
* @funcion st
* @label Cultura
* @validate  required, numeric
*/
protected $_fk_culturas;
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
* @label Posicion
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
public $_tSingular='Subcultura';
public $_tPlural='Subculturas';


public function __construct($options = array())
	{
		parent::__construct($options);

		$this->setJoins('culturas','(subculturas.fk_culturas=j_culturas.pk)',Array('j_culturas.nom' => 'join_fk_culturas'),j_culturas);

	}
}

//version MK.CRUD 1.0 
?>