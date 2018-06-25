<?php 
use Mk\Shared\CrudDb as CrudDb;
class Nodos_controller extends CrudDb
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
		$anexos['color']['defVal']='0';
		$anexos['color']['options']['1']='Azul';
		$anexos['color']['options']['2']='Verde';
		$anexos['color']['options']['3']='Amarillo';
		$anexos['color']['options']['4']='Rojo';
		$anexos['status']['defVal']='1';

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//

//* :preserve code *//

}
//version MK.CRUD 1.0 
?>