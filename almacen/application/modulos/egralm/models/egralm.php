<?php 
class Egralm extends Mk\Shared\Model
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
* @type date
* @uso A
* @funcion date
* @label Fecha
* @validate  required
*/
protected $_fecha='hoy';
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Almacen
* @validate  required, numeric
*/
protected $_fk_almacenes;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Alm Destino
* @labelf Almacen Destino
* @validate  numeric
*/
protected $_fk_almacenes_2;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Producto
* @validate  required, numeric
*/
protected $_fk_prod;
/**
* @column
* @readwrite
* @type decimal
* @uso A
* @funcion bdf
* @label Cant
* @labelf Cantidad
* @validate  required, numeric
*/
protected $_cant;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Unidad
* @validate  required, numeric
*/
protected $_fk_unidades;
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion st
* @label Tipo
* @validate  required
*/
protected $_tipo;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Serial
*/
protected $_serial;
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion useract
* @label Resp
* @labelf Responsable
* @validate  required, numeric
*/
protected $_fk_resp;
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
public $_tSingular='Egreso de Almacen';
public $_tPlural='Egresos de Almacen';


public function __construct($options = array())
	{
		parent::__construct($options);

		$this->setJoins('almacenes','(egralm.fk_almacenes=j_almacenes.pk)',Array('j_almacenes.nombre' => 'join_fk_almacenes'),j_almacenes);
		$this->setJoins('almacenes','(egralm.fk_almacenes_2=j_almacenes_1.pk)',Array('j_almacenes_1.nombre' => 'join_fk_almacenes_2'),j_almacenes_1);
		$this->setJoins('prod','(egralm.fk_prod=j_prod.pk)',Array('j_prod.nom' => 'join_fk_prod'),j_prod);
		$this->setJoins('unidades','(egralm.fk_unidades=j_unidades.pk)',Array('j_unidades.nombre' => 'join_fk_unidades'),j_unidades);
		$this->setJoins('resp','(egralm.fk_resp=j_resp.pk)',Array('j_resp.nombre' => 'join_fk_resp'),j_resp);

	}
}

//version MK.CRUD 1.0 
?>