<?php 
use Mk\Shared\CrudDb as CrudDb;
class Ingalm_controller extends CrudDb
{
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->_secure();
	}

	public function getAnexos($anexos=array(),$join=0){
		$anexos=parent::getAnexos($anexos);
		$anexos['listAction']="-1";
		$anexos['fk_almacenes']['join']['table']='almacenes';
		$anexos['fk_almacenes']['join']['campo']='nombre';
		$anexos['fk_almacenes']['cargaAjax']=1;
		$anexos['fk_prod']['join']['table']='prod';
		$anexos['fk_prod']['join']['campo']='nom';
		$anexos['fk_prod']['join']['tag']="fk_unidades, unidades.tipo";
		$anexos['fk_prod']['join']['join']="left join unidades on (fk_unidades=unidades.pk)";
		$anexos['fk_prod']['cargaAjax']=1;
		$anexos['fk_unidades']['join']['table']='unidades';
		$anexos['fk_unidades']['join']['campo']='nombre';
		$anexos['fk_unidades']['join']['cond']="(tipo='%s')";
		$anexos['fk_unidades']['cargaAjax']=1;
		$anexos['tipo']['defVal']='C';
		$anexos['tipo']['options']['C']='Compra';
		$anexos['tipo']['options']['I']='Inventario Inicial';
		$anexos['tipo']['options']['T']='Traspaso';
		$anexos['tipo']['options']['D']='Devolucion';
		$anexos['tipo']['options']['A']='Ajuste';
		$anexos['tipodoc']['defVal']='F';
		$anexos['tipodoc']['options']['F']='Factura';
		$anexos['tipodoc']['options']['R']='Recibo';
		$anexos['tipodoc']['options']['X']='Ninguno';
		$anexos['fk_resp']['join']['table']='resp';
		$anexos['fk_resp']['join']['campo']='nombre';
		$anexos['fk_resp']['cargaAjax']=1;
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['fk_almacenes']['options']=$this->actionGetListFor('fk_almacenes',$anexos);
			$anexos['fk_prod']['options']=$this->actionGetListFor('fk_prod',$anexos);
			$anexos['fk_unidades']['options']=$this->actionGetListFor('fk_unidades',$anexos);
			$anexos['fk_resp']['options']=$this->actionGetListFor('fk_resp',$anexos);
		}

		return $anexos;
	}
//* preserve code: *//

class Ingalm_controller extends CrudDb
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
		$anexos['listAction']="show";
		$anexos['fk_almacenes']['join']['table']='almacenes';
		$anexos['fk_almacenes']['join']['campo']='nombre';
		$anexos['fk_almacenes']['cargaAjax']=1;
		$anexos['fk_prod']['join']['table']='prod';
		$anexos['fk_prod']['join']['campo']='nom';
		$anexos['fk_prod']['join']['tag']="fk_unidades, unidades.tipo";
		$anexos['fk_prod']['join']['join']="left join unidades on (fk_unidades=unidades.pk)";
		$anexos['fk_prod']['cargaAjax']=1;
		$anexos['fk_unidades']['join']['table']='unidades';
		$anexos['fk_unidades']['join']['campo']='nombre';
		$anexos['fk_unidades']['join']['cond']="(tipo='%s')";
		$anexos['fk_unidades']['cargaAjax']=1;
		$anexos['tipo']['defVal']='C';
		$anexos['tipo']['options']['C']='Compra';
		$anexos['tipo']['options']['I']='Inventario Inicial';
		$anexos['tipo']['options']['T']='Traspaso';
		$anexos['tipo']['options']['D']='Devolucion';
		$anexos['tipo']['options']['A']='Ajuste';
		$anexos['tipodoc']['defVal']='F';
		$anexos['tipodoc']['options']['F']='Factura';
		$anexos['tipodoc']['options']['R']='Recibo';
		$anexos['tipodoc']['options']['X']='Ninguno';
		$anexos['fk_resp']['join']['table']='resp';
		$anexos['fk_resp']['join']['campo']='nombre';
		$anexos['fk_resp']['cargaAjax']=1;
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['fk_almacenes']['options']=$this->actionGetListFor('fk_almacenes',$anexos);
			$anexos['fk_prod']['options']=$this->actionGetListFor('fk_prod',$anexos);
			$anexos['fk_unidades']['options']=$this->actionGetListFor('fk_unidades',$anexos);
			$anexos['fk_resp']['options']=$this->actionGetListFor('fk_resp',$anexos);
		}

		retu

//* :preserve code *//

}
//version MK.CRUD 1.0 
?>