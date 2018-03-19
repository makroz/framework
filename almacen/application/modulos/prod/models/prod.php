<?php 
class Prod extends Mk\Shared\Model
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
* @label Descripcion
* @validate  required
*/
protected $_nom;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Unidad
* @validate  required, numeric
*/
protected $_fk_unidades='-1';
/**
* @column
* @readwrite
* @type decimal
* @uso A
* @funcion bdf
* @label Cant
* @validate  numeric
*/
protected $_cant='0.00';
/**
* @column
* @readwrite
* @type decimal
* @uso A
* @funcion bdf
* @label Costo
* @validate  numeric
*/
protected $_costo='0.00';
/**
* @column
* @readwrite
* @type decimal
* @uso A
* @funcion bdf
* @label Precio
* @validate  numeric
*/
protected $_precio='0.00';
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Codbarra
* @labelf Codigo de Barras
*/
protected $_codbarra;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Categoria
* @validate  required, numeric
*/
protected $_fk_categorias='-1';
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion check
* @label Serial
* @labelf Tiene Serial
*/
protected $_tserial='0';
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion check
* @label Vence
* @labelf Fecha de Vencimiento
*/
protected $_tvence='0';
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Proveedor
* @validate  required, numeric
*/
protected $_fk_proveedores='-1';
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
public $_tSingular='Producto';
public $_tPlural='Productos';


public function __construct($options = array())
	{
		parent::__construct($options);

		$this->setJoins('unidades','(prod.fk_unidades=j_unidades.pk)',Array('j_unidades.nombre' => 'join_fk_unidades'));
		$this->setJoins('categorias','(prod.fk_categorias=j_categorias.pk)',Array('j_categorias.nombre' => 'join_fk_categorias'));
		$this->setJoins('proveedores','(prod.fk_proveedores=j_proveedores.pk)',Array('j_proveedores.nom' => 'join_fk_proveedores'));

	}
}

//version MK.CRUD 1.0 
?>