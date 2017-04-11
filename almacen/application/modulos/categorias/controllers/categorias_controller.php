<?php 
use Mk\Shared\CrudDb as CrudDb;
class Categorias_controller extends CrudDb
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
		
		if ($join!=0){
			$anexos['sk_padre']['options']=$this->getArrayFromTable('categorias', 'nombre');
		}

		return $anexos;
	}
}
?>