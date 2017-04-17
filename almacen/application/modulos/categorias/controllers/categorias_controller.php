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
		$anexos['nivel']['options']['0']='Categoria';
		$anexos['nivel']['options']['1']='Sub-Categoria';
		$anexos['sk_padre']['join']['table']='categorias';
		$anexos['sk_padre']['join']['campo']='nombre';
		$anexos['sk_padre']['join']['cond']="(nivel='0')";
		if ($join!=0){
			$anexos['sk_padre']['options']=$this->actionGetListFor('sk_padre',$anexos);
			$anexos['sk_padre']['cargaAjax']=1;
		}

		return $anexos;
	}
}
?>