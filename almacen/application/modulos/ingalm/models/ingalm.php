<?php 
class Ingalm extends Mk\Shared\Model
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
protected $_fecha;
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
* @validate  required, numeric
*/
protected $_cant;
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
* @labelf Tipo de Ingreso
*/
protected $_tipo='C';
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion st
* @label Tipo Doc.
* @labelf Tipo de Documento
*/
protected $_tipodoc='F';
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Doc
* @labelf No. de Factura/Recibo
*/
protected $_nfac;
/**
* @column
* @readwrite
* @type date
* @uso A
* @funcion date
* @label Vence
* @labelf Fecha de Vencimiento
*/
protected $_fecven;
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
public $_tSingular='Ingreso a Almacen';
public $_tPlural='Ingresos a Almacen';


public function __construct($options = array())
	{
		parent::__construct($options);

		$this->setJoins('almacenes','(ingalm.fk_almacenes=j_almacenes.pk)',Array('j_almacenes.nombre' => 'join_fk_almacenes'));
		$this->setJoins('prod','(ingalm.fk_prod=j_prod.pk)',Array('j_prod.nom' => 'join_fk_prod'));
		$this->setJoins('unidades','(ingalm.fk_unidades=j_unidades.pk)',Array('j_unidades.nombre' => 'join_fk_unidades'));
		$this->setJoins('resp','(ingalm.fk_resp=j_resp.pk)',Array('j_resp.nombre' => 'join_fk_resp'));

	}
}

//version MK.CRUD 1.0 
?>