<?php 
use Mk\Shared\CrudDb as CrudDb;
class Unidades_controller extends CrudDb
{
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->_secureKey='resp';
		$this->_secure();
	}

	public function getAnexos($anexos=array(),$join=0){
		$anexos=parent::getAnexos($anexos);
		$anexos['listAction']="-1";
		$anexos['tipo']['defVal']='X';
		$anexos['tipo']['options']['X']='Unico';
		$anexos['tipo']['options']['U']='Unidad';
		$anexos['tipo']['options']['P']='Peso';
		$anexos['tipo']['options']['D']='Distancia';
		$anexos['tipo']['options']['T']='Tiempo';
		$anexos['tipo']['options']['V']='Volumen';
		$anexos['base']['defVal']='0';
		$anexos['base']['dataon']='1';
		$anexos['base']['dataoff']='0';
		$anexos['base']['labelon']='Si';
		$anexos['base']['labeloff']='No';
		$anexos['relbase']['defVal']='0.00';
		$anexos['status']['defVal']='1';

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>