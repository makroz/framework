<?php 
use Mk\Shared\CrudDb as CrudDb;
class Prod_controller extends CrudDb
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
		$anexos['fk_unidades']['defVal']='-1';
		$anexos['fk_unidades']['join']['table']='unidades';
		$anexos['fk_unidades']['join']['campo']='nombre';
		$anexos['fk_unidades']['join']['alias']='j_unidades';
		$anexos['cant']['defVal']='0.00';
		$anexos['costo']['defVal']='0.00';
		$anexos['precio']['defVal']='0.00';
		$anexos['fk_categorias']['defVal']='-1';
		$anexos['fk_categorias']['join']['table']='categorias';
		$anexos['fk_categorias']['join']['campo']='nombre';
		$anexos['fk_categorias']['join']['alias']='j_categorias';
		$anexos['fk_categorias']['join']['tag']="sk_padre";
		$anexos['fk_categorias']['join']['grupo']=1;
		$anexos['fk_categorias']['cargaAjax']=1;
		$anexos['tserial']['defVal']='0';
		$anexos['tserial']['dataon']='1';
		$anexos['tserial']['dataoff']='0';
		$anexos['tserial']['labelon']='Si';
		$anexos['tserial']['labeloff']='No';
		$anexos['tvence']['defVal']='0';
		$anexos['tvence']['dataon']='1';
		$anexos['tvence']['dataoff']='0';
		$anexos['tvence']['labelon']='Si';
		$anexos['tvence']['labeloff']='No';
		$anexos['fk_proveedores']['defVal']='-1';
		$anexos['fk_proveedores']['join']['table']='proveedores';
		$anexos['fk_proveedores']['join']['campo']='nom';
		$anexos['fk_proveedores']['join']['alias']='j_proveedores';
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['fk_unidades']['options']=$this->actionGetListFor('fk_unidades',$anexos);
			$anexos['fk_proveedores']['options']=$this->actionGetListFor('fk_proveedores',$anexos);
		}
		$anexos['fk_categorias']['options']=$this->actionGetListFor('fk_categorias',$anexos);

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>