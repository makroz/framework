<?php 
class Prodalm extends Mk\Shared\Model
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
* @uso G
* @funcion st
* @label Almacen
* @validate  required, numeric
*/
protected $_fk_almacenes;
/**
* @column
* @readwrite
* @type int
* @uso G
* @funcion st
* @label Producto
* @validate  required, numeric
*/
protected $_fk_prod;
/**
* @column
* @readwrite
* @type decimal
* @uso G
* @funcion bdf
* @label Cantidad
* @validate  numeric
*/
protected $_cant='0';
/**
* @column
* @readwrite
* @type decimal
* @uso A
* @funcion bdf
* @label Stock Minimo
* @validate  required, numeric
*/
protected $_minstock;
/**
* @column
* @readwrite
* @type decimal
* @uso A
* @funcion bdf
* @label Recompra
* @labelf Cant  de Recompra
* @validate  required, numeric
*/
protected $_recompra;
/**
* @column
* @readwrite
* @type decimal
* @uso A
* @funcion bdf
* @label Costo
* @validate  required, numeric
*/
protected $_costo;
/**
* @column
* @readwrite
* @type decimal
* @uso A
* @funcion bdf
* @label Precio
* @validate  numeric
*/
protected $_precio;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Ubicacion
*/
protected $_ubicacion;
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
public $_tSingular='Producto en Almacen';
public $_tPlural='Productos en Almacenes';


public function __construct($options = array())
	{
		parent::__construct($options);

		$this->setJoins('almacenes','(prodalm.fk_almacenes=j_almacenes.pk)',Array('j_almacenes.nombre' => 'join_fk_almacenes'),j_almacenes);
		$this->setJoins('prod','(prodalm.fk_prod=j_prod.pk)',Array('j_prod.nom' => 'join_fk_prod'),j_prod);

	}
}

//version MK.CRUD 1.0 
?>