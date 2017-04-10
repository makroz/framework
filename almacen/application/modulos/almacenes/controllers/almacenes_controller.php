<?php 
use Mk\Shared\CrudDb as CrudDb;
class Almacenes_controller extends CrudDb
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

	public function getAnexos($anexos=array(),$join=0){
		$anexos=parent::getAnexos($anexos);
		$anexos['estado']['options']['E']='Abierto';
		$anexos['estado']['options']['N']='Inventario Inicial Nuevo';
		$anexos['estado']['options']['C']='Cerrado';
		$anexos['estado']['options']['I']='Inventariando';
		if ($join!=0){
			$anexos['fk_resp']['options']=$this->getArrayFromTable('resp', 'nombre');
		}

		return $anexos;
	}
}
?>