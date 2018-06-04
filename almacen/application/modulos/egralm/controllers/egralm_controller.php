<?php 
use Mk\Shared\CrudDb as CrudDb;
use Mk\Inputs as Inputs;
class Egralm_controller extends CrudDb
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
		$anexos['fecha']['defVal']='hoy';
		$anexos['fk_almacenes']['join']['table']='almacenes';
		$anexos['fk_almacenes']['join']['campo']='nombre';
		$anexos['fk_almacenes']['join']['alias']='j_almacenes';
		$anexos['fk_almacenes_2']['join']['table']='almacenes';
		$anexos['fk_almacenes_2']['join']['campo']='nombre';
		$anexos['fk_almacenes_2']['join']['alias']='j_almacenes_1';
		$anexos['fk_prod']['join']['table']='prod';
		$anexos['fk_prod']['join']['campo']='nom';
		$anexos['fk_prod']['join']['alias']='j_prod';
		$anexos['fk_prod']['join']['tag']="fk_unidades";
		$anexos['fk_prod']['join']['join']="left join unidades on (fk_unidades=unidades.pk)";
		$anexos['fk_prod']['join']['cb']="prod.codbarra:1:e,prod.nom:1:like";
		$anexos['fk_unidades']['join']['table']='unidades';
		$anexos['fk_unidades']['join']['campo']='nombre';
		$anexos['fk_unidades']['join']['alias']='j_unidades';
		$anexos['fk_unidades']['join']['cond']="(tipo='%s')";
		$anexos['fk_unidades']['join']['tag']="tipo";
		$anexos['tipo']['options']['T']='Traspaso';
		$anexos['tipo']['options']['V']='Venta';
		$anexos['tipo']['options']['D']='Devolucion';
		$anexos['tipo']['options']['A']='Ajuste';
		$anexos['tipo']['options']['X']='Danado';
		$anexos['tipo']['options']['C']='Vencido';
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['fk_unidades']['options']=$this->actionGetListFor('fk_unidades',$anexos);
		}
		$anexos['fk_almacenes']['options']=$this->actionGetListFor('fk_almacenes',$anexos);
		$anexos['fk_almacenes_2']['options']=$this->actionGetListFor('fk_almacenes_2',$anexos);

		return $anexos;
	}

	public function beforeDelete($id){
		$this->dataAnt=$this->getDatosDb($id,'pk,cant,fk_prod,fk_almacenes,fk_unidades');
		return true;
	}
	public function afterDelete($id,$i,$t){
		$database = \Mk\Registry::get("database");
		$datos=$this->dataAnt;
		$unidad=$database->query()->first("select prod.pk, fk_unidades, unidades.relbase, uni2.relbase as relbase2 from prod left join unidades on (unidades.pk=fk_unidades) left join unidades as uni2 on (uni2.pk={$datos['fk_unidades']}) where (prod.pk={$datos['fk_prod']}) limit 1");
		$datos['cant']=($datos['cant']*$unidad['relbase2'])/$unidad['relbase'];
		$database->execute("update prodalm set cant=cant+{$datos['cant']} where (fk_prod={$datos['fk_prod']})and(fk_almacenes={$datos['fk_almacenes']})");
		$database->execute("update prod set cant=cant+{$datos['cant']} where (pk={$datos['fk_prod']})");
		return true;
	}

	public function beforeSave($action){
		if ($action=='edit'){
		  $this->dataAnt=$this->getDatosDb($this->_model->pk,'pk,cant,fk_prod,fk_almacenes,fk_unidades');
		}
		return true;
	}
	public function afterSave($action){
		$datos=$this->_model->loadToArray();
		$database = \Mk\Registry::get("database");
		$unidad=$database->query()->first("select prod.pk, fk_unidades, unidades.relbase, uni2.relbase as relbase2 from prod left join unidades on (unidades.pk=fk_unidades) left join unidades as uni2 on (uni2.pk={$datos['fk_unidades']}) where (prod.pk={$datos['fk_prod']}) limit 1");
		$datos['cant']=($datos['cant']*$unidad['relbase2'])/$unidad['relbase'];
		$idProdAlm=$database->query()->first("select pk, cant from prodalm where (fk_prod={$datos['fk_prod']})and(fk_almacenes={$datos['fk_almacenes']}) limit 1");
		$data['pk']=$idProdAlm['pk'];
		$data['cant']=$idProdAlm['cant']-$datos['cant'];
		if ($action=='add'){
		  $datap['cant']='cant-'.$datos['cant'];
		}
		if ($action=='edit'){
		  if (($datos['fk_prod']!=$this->dataAnt['fk_prod'])||($datos['fk_almacenes']!=$this->dataAnt['fk_almacenes'])){
		    $database->execute("update prodalm set cant=cant+{$this->dataAnt['cant']} where (fk_prod={$this->dataAnt['fk_prod']})and(fk_almacenes={$this->dataAnt['fk_almacenes']})");
		  }else{
		    $data['cant']=$idProdAlm['cant']-$datos['cant']+$this->dataAnt['cant'];
		  }
		  $datap['cant']='cant-'.($datos['cant']+$this->dataAnt['cant']);
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

	public function actionPrint(){
		//$this->changeViewAction('listar.html');
		
		$view = $this-> getActionView();
		$primary = $this->getPrimary();
		$order = $this->getParam("order",$primary);
		$direction = $this->getParam("direction",'desc');
		$page =1;
		$limit =null;
		$filter = $this->getParam("_filter",array());
		//\Mk\Debug::msg($filter,3,'Filtros');
		$_sele_ =\Mk\Tools\App::isBuscar();


		$ini =$this->getParam("ini",date('d/m/Y'));
		$fin =$this->getParam("fin",'');

		$where=$this->getSearchWhere();
		$_searchMsg="Fecha: $ini";
		if (($fin=='')||($fin==$ini)){
			$where .="and(".$this->_model->getTable().".fecha='".\Mk\Tools\Form::dateToDbDate($ini)."')";
			$fin='';
		}else{
			$where .="and(".$this->_model->getTable().".fecha>='".\Mk\Tools\Form::dateToDbDate($ini)."')and(".$this->_model->getTable().".fecha<='".\Mk\Tools\Form::dateToDbDate($fin)."')";
				$_searchMsg="Fecha: $ini - $fin";
		}
		
		
		$anexos=$this->getAnexos($this->_model->getColumns());

		$items = false;

		$where = array(
		'?'=>$where
		);

		$fields = array(
		$this->_model->getTable().".*"
		);

		$join=$this->_model->getJoins();

		//$count = $this->_model->count($where, $join);
		$items = $this->_model->all($where, $fields, $order, $direction, $limit, $page,$join);
		//\Mk\Debug::msg($items,1);
		$view
		-> set("order", $order)
		-> set("direction", $direction)
		-> set("page", $page)
		-> set("limit", $limit)
		-> set("ini", $ini)
		-> set("fin", $fin)
		-> set("count", $count)
		-> set("_filter", $filter)
		-> set("searchMsg", $_searchMsg)
		-> set("filterMsg", $this->_filterMsg)
		-> set("modTitulo", "Impresion de ".$this->_model->_tPlural)
		-> set("modSingular",$this->_model->_tSingular)
		-> set("anexos", $anexos)
		-> set("item", $this->_model->loadToArray())
		-> set("items", $items);
		$this->afterListar($view);
	}


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>