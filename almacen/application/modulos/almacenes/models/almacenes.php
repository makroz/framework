<?php 
class Almacenes extends Mk\Shared\Model
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
* @label Nombre
* @validate  required
*/
protected $_nombre;
/**
* @column
* @readwrite
* @type varchar
* @uso A
* @funcion st
* @label Dirreccion
*/
protected $_dir;
/**
* @column
* @readwrite
* @type char
* @uso A
* @funcion st
* @label Estado
* @validate  required
*/
protected $_estado='1';
/**
* @column
* @readwrite
* @type int
* @uso A
* @funcion st
* @label Responsable
* @validate  required, numeric
*/
protected $_fk_resp;
/**
* @column
* @readwrite
* @type date
* @uso A
* @funcion date
* @label Ult.Inventario
* @labelf Fecha del Ultimo Inventario
*/
protected $_fecultinv;
/**
* @column
* @readwrite
* @type tinyint
* @uso A
* @funcion st
* @label Lapso
* @labelf Lapso entre Inventarios
* @validate  required, numeric
*/
protected $_lapso;
/**
* @column
* @readwrite
* @type tinytext
* @uso A
* @funcion st
* @label Ubicaciones del Almacen
*/
protected $_t_ubicaciones='{"R":{"t":"Recepcion"},"A":{"t":"Almacen"},"C":{"t":"Cuarentena"},"S":{"t":"Salida"}}';
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
public $_tSingular='Almacen';
public $_tPlural='Almacenes';


public function __construct($options = array())
	{
		parent::__construct($options);

		$this->setJoins('resp','(almacenes.fk_resp=j_resp.pk)',Array('j_resp.nombre' => 'join_fk_resp'),j_resp);

	}
}

//version MK.CRUD 1.0 
?>