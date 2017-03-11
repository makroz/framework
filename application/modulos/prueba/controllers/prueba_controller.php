<?php 
use Mk\Shared\CrudDb as CrudDb;
class Prueba_controller extends CrudDb
{
	/**
	* @readwrite
	*/
	//protected $_secureKey='User';
		
	public function __construct($options = array())
	{
		parent::__construct($options);
		//$this->_model =$this->_getLoged();
	}

	public function getAnexos($anexos=array()){
		$anexos=parent::getAnexos($anexos);
		$anexos['base']['dataon']='1';
		$anexos['base']['labelon']='Si';
		$anexos['base']['labeloff']='No';
		$anexos['tipo']['options']['X']='Unico';
		$anexos['tipo']['options']['U']='Unidad';
		$anexos['tipo']['options']['P']='Peso';
		$anexos['tipo']['options']['D']='Distancia';
		$anexos['tipo']['options']['T']='Tiempo';
		$anexos['tipo']['options']['V']='Volumen';

		return $anexos;
	}
}
?>