<?php 
use Mk\Shared\CrudDb as CrudDb;
class Submenus_controller extends CrudDb
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
		$anexos['tipo']['defVal']='P';
		$anexos['tipo']['options']['P']='Pagina';
		$anexos['tipo']['options']['L']='Link';
		$anexos['fk_menus']['join']['table']='menus';
		$anexos['fk_menus']['join']['campo']='nom';
		$anexos['fk_menus']['join']['alias']='j_menus';
		$anexos['fk_menus']['join']['cond']="(menus.tipo='M')";
		$anexos['posi']['defVal']='1';
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['fk_menus']['options']=$this->actionGetListFor('fk_menus',$anexos);
		}

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>