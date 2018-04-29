<?php 
use Mk\Shared\CrudDb as CrudDb;
class Categorias_controller extends CrudDb
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
		$anexos['nivel']['defVal']='0';
		$anexos['nivel']['options']['0']='Categoria';
		$anexos['nivel']['options']['1']='Sub-Categoria';
		$anexos['sk_padre']['join']['table']='categorias';
		$anexos['sk_padre']['join']['campo']='nombre';
		$anexos['sk_padre']['join']['alias']='j_categorias';
		$anexos['sk_padre']['join']['cond']="(nivel='0')";
		$anexos['sk_padre']['cargaAjax']=1;
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['sk_padre']['options']=$this->actionGetListFor('sk_padre',$anexos);
		}

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>