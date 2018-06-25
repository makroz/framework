<?php 
use Mk\Shared\CrudDb as CrudDb;
class Subculturas_controller extends CrudDb
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
		$anexos['fk_culturas']['join']['table']='culturas';
		$anexos['fk_culturas']['join']['campo']='nom';
		$anexos['fk_culturas']['join']['alias']='j_culturas';
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['fk_culturas']['options']=$this->actionGetListFor('fk_culturas',$anexos);
		}

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//

//* :preserve code *//

}
//version MK.CRUD 1.0 
?>