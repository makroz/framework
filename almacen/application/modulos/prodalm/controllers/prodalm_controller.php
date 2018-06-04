<?php 
use Mk\Shared\CrudDb as CrudDb;
class Prodalm_controller extends CrudDb
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
		$anexos['fk_almacenes']['join']['table']='almacenes';
		$anexos['fk_almacenes']['join']['campo']='nombre';
		$anexos['fk_almacenes']['join']['alias']='j_almacenes';
		$anexos['fk_prod']['join']['table']='prod';
		$anexos['fk_prod']['join']['campo']='nom';
		$anexos['fk_prod']['join']['alias']='j_prod';
		$anexos['fk_prod']['join']['cb']="prod.codbarra:1:e,prod.nom:1:like";
		$anexos['cant']['defVal']='0';
		$anexos['status']['defVal']='1';
		$anexos['fk_almacenes']['options']=$this->actionGetListFor('fk_almacenes',$anexos);

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>