<?php 
use Mk\Shared\CrudDb as CrudDb;
class Resp_controller extends CrudDb
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
		

		return $anexos;
	}
}
?>