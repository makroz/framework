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
protected $_nivel='0';
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
*/
protected $_status='1';
public $_tSingular='Categoria';
public $_tPlural='Categorias';


public function __construct($options = array())
	{
		parent::__construct($options);

		$this->setJoins('categorias','(categorias.sk_padre=j_categorias.pk)',Array('j_categorias.nombre' => 'join_sk_padre'));

	}
}


?>