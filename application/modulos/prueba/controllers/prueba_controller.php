<?php 
use Mk\Shared\CrudDb as CrudDb;
class Prueba_controller extends CrudDb
{

	/**
	* @readwrite
	*/
	//protected $_secureKey='User';
	//
	
		
	public function __construct($options = array())
	{
		parent::__construct($options);
		//$this->_model =$this->_getLoged();
	}

	
	public function getAnexos($anexos=array()){

		$anexos=parent::getAnexos($anexos);
	/*[[anexos:]]*/
		$anexos['base']['labelon']='Si';
		$anexos['base']['labeloff']='No';
		$anexos['base']['dataon']=1;

		$anexos['tipo']['optionsl']="<option value='X' >Unico</option>".PHP_EOL."<option value='U' >Unidad</option>".PHP_EOL."<option value='P' >Peso</option>".PHP_EOL."<option value='D' >Distancia</option>".PHP_EOL."<option value='V' >Volumen</option>".PHP_EOL."<option value='T' >Tiempo</option>";
		$anexos['tipo']['options']['X']='Unico';
		$anexos['tipo']['options']['U']='Unidad';
		$anexos['tipo']['options']['P']='Peso';
		$anexos['tipo']['options']['D']='Distancia';
		$anexos['tipo']['options']['V']='Volumen';
		$anexos['tipo']['options']['T']='Tiempo';
	/*[[:anexos]]*/

		return $anexos;

	}


}
?>