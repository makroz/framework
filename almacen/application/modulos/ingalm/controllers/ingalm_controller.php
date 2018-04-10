<?php 
use Mk\Shared\CrudDb as CrudDb;
class Ingalm_controller extends CrudDb
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
		$anexos['fk_prod']['join']['table']='prod';
		$anexos['fk_prod']['join']['campo']='nom';
		$anexos['fk_prod']['join']['tag']="fk_unidades";
		$anexos['fk_prod']['join']['join']="left join unidades on (fk_unidades=unidades.pk)";
		$anexos['fk_unidades']['join']['table']='unidades';
		$anexos['fk_unidades']['join']['campo']='nombre';
		$anexos['fk_unidades']['join']['cond']="(tipo='%s')";
		$anexos['fk_unidades']['join']['tag']="tipo";
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
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['fk_unidades']['options']=$this->actionGetListFor('fk_unidades',$anexos);
		}
		$anexos['fk_almacenes']['options']=$this->actionGetListFor('fk_almacenes',$anexos);

		return $anexos;
	}

	
	public function afterDelete($id,$i,$t){
		$database = \Mk\Registry::get("database");
		$datos=$database->query()->first("select pk,cant,fk_prod,fk_almacenes from ingalm where (pk={$id}) limit 1");
		$database->execute("update prodalm set cant=cant-{$datos['cant']} where (fk_prod={$datos['fk_prod']})and(fk_almacenes={$datos['fk_almacenes']})");
		$database->execute("update prod set cant=cant-{$datos['cant']} where (pk={$datos['fk_prod']})");
		return true;
	}

	public function beforeSave($action){
		if ($action=='edit'){
		  $database = \Mk\Registry::get("database");
		  $this->dataAnt=$database->query()->first("select pk, cant, fk_prod, fk_almacenes from ingalm where (pk={$this->_model->pk}) limit 1");
		}
		return true;
	}
	public function afterSave($action){
		$datos=$this->_model->loadToArray();
		$database = \Mk\Registry::get("database");
		$idProdAlm=$database->query()->first("select pk, cant from prodalm where (fk_prod={$datos['fk_prod']})and(fk_almacenes={$datos['fk_almacenes']}) limit 1");
		$data['pk']=$idProdAlm['pk'];
		$data['cant']=$idProdAlm['cant']+$datos['cant'];
		if ($action=='add'){
			$datap['cant']='cant+'.$datos['cant'];
		}
		if ($action=='edit'){
		  if (($datos['fk_prod']!=$this->dataAnt['fk_prod'])||($datos['fk_almacenes']!=$this->dataAnt['fk_almacenes'])){
		    $database->execute("update prodalm set cant=cant-{$this->dataAnt['cant']} where (fk_prod={$this->dataAnt['fk_prod']})and(fk_almacenes={$this->dataAnt['fk_almacenes']})");
		  }else{
		    $data['cant']=$idProdAlm['cant']+$datos['cant']-$this->dataAnt['cant'];
		  }
		  $datap['cant']='cant+'.($datos['cant']-$this->dataAnt['cant']);
		}
		if (!($idProdAlm['pk']>0)){
			$data=$datos;
			$data['pk']='';
		}
		$prodAlm=new ProdAlm();
		$prodAlm->saveFromArray($data);
		$prod=new Prod();
		$datap['pk']=$datos['fk_prod'];
		$prod->saveFromArray($datap);
		return true;
	}
	
//* preserve code: *//


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>