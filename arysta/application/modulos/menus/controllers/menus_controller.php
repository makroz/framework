<?php 
use Mk\Shared\CrudDb as CrudDb;
class Menus_controller extends CrudDb
{
	public function __construct($options = array())
	{
		parent::__construct($options);
		//$this$_secureKey='menus';
		//$this->_secure();
	}

	public function getAnexos($anexos=array(),$join=0){
		$anexos=parent::getAnexos($anexos);
		$anexos['listAction']="-1";
		$anexos['tipo']['defVal']='M';
		$anexos['tipo']['options']['M']='Menu';
		$anexos['tipo']['options']['L']='Link';
		$anexos['status']['defVal']='1';

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>