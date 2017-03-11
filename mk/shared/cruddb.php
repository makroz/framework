<?php 
namespace Mk\Shared
{
	use Mk\Events as Events;
	use Mk\Router as Router;
	use Mk\Registry as Registry;
	use Mk\Session as Session;
	use Mk\Inputs as Inputs;

	class CrudDb extends \Mk\Shared\ControllerDb
	{

		protected $_searchMsg='';

		protected $_defaultFields=array ("status"=>"STATUS");

		public  $_cond_search = array(
			"1" => "UPPER([1]) LIKE ('%[2]%')",
			"2" => "UPPER([1]) NOT LIKE ('%[2]%')",
			"3" => "[1]='[2]'",
			"4" => "[1]<>'[2]'",
			"5" => "[1]>'[2]'",
			"6" => "[1]<'[2]'",
			"7" => "[1]>='[2]'",
			"8" => "[1]<='[2]'",
			"9" => "UPPER([1]) LIKE ('[2]%')",
			"10" => "UPPER([1]) NOT LIKE ('[2]%')",
			"11" => "UPPER([1]) LIKE ('%[2]')",
			"12" => "UPPER([1]) NOT LIKE ('%[2]')"
			);

		public  $_cond_search_msg = array(
			"1" => "[1] contiene '[2]'",
			"2" => "[1) no contiene '[2]')",
			"3" => "[1] es igual a '[2]'",
			"4" => "[1] es diferente de '[2]'",
			"5" => "[1] es mayor que '[2]'",
			"6" => "[1] es menor que '[2]'",
			"7" => "[1] es mayor o igual que '[2]'",
			"8" => "[1] es menor o igual que '[2]'",
			"9" => "[1] empieza por'[2]'",
			"10" => "[1] no empieza por '[2]'",
			"11" => "[1] termina en '[2]'",
			"12" => "[1] no termina en '[2]'"
			);
		
		

		public function __construct($options = array())
		{
			parent::__construct($options);
		}

		public function getPrimary(){
			$primary = $this->_model->primaryColumn;
			$primary = $primary["name"];
			return $primary;

		}

	public function actionGetItem(){
		$this->setRenderView(false);
		$primary = $this->getPrimary();
		$pk =Inputs::request('cod','');
		$modelo = $this->_model;
		$modelo->$primary=$pk;
		$modelo->load();
		//echo "<pre>";print_r($modelo);echo "</pre>";
		$data=$modelo->loadToArray();

		if (\Mk\Tools\App::isAjax()==true){
			echo json_encode($data);
			return $pk;	
		}else{
			echo "<pre>";print_r($data);echo "</pre>";
			exit;
		}
		return -1;
	}

	public function actionSetData(){
		$this->setRenderView(false);
		$primary = $this->getPrimary();

		$pk =Inputs::get($primary,'');
		$campos = Inputs::get("campos",array());
		$campos=array_merge(array($primary=>$pk),$campos);
		$modelo = $this->_model;
		$modelo->saveFromArray($campos);
		$modelo->loadFromArray($campos);

		if (\Mk\Tools\App::isAjax()==true){
			echo $pk;
			return $pk;	
		}else{
			header("Location:". $_SERVER['HTTP_REFERER']);
			exit;
		}
		return -1;
	}

	public function _verificarDatos($action){
			$model=$this->_model;
			if ($action=='add'){
				$action='G';
			}else{
				$action='M';
			}

			foreach ($model->columns as $key => $campo) {
				$prop = $campo["name"];

				if (($campo['uso']=='A')||($campo['uso']==$action)){

					switch ($campo['funcion']) {
						case 'st':
							$model->$prop=\Mk\Tools\Form::tbd($model->$prop);
							break;
						case 'bdf':
							$model->$prop=\Mk\Tools\Form::fbd($model->$prop);
							break;
						case 'datetime':
							if ($campo['type']=='char'){
								$model->$prop=\Mk\Tools\Form::dateToDb($model->$prop,true);
							}else{
								$model->$prop=\Mk\Tools\Form::dateToDbDate($model->$prop,true);
							}
							break;
						case 'date':
							if ($campo['type']=='char'){
								$model->$prop=\Mk\Tools\Form::dateToDb($model->$prop);
							}else{
								$model->$prop=\Mk\Tools\Form::dateToDbDate($model->$prop);
							}
							break;
						case 'time':
							if ($campo['type']=='char'){
								$model->$prop=\Mk\Tools\Form::timeToDb($model->$prop);
							}else{
								$model->$prop=\Mk\Tools\Form::timeToDbDate($model->$prop);
							}
							break;
						case 'custom':
							if (stripos($campo['fcustom'],'(')===false){
								$model->$prop=$campo['fcustom'];	
							}else{
								$func=str_replace('()','',$campo['fcustom']);
								$model->$prop=$func($model->$prop);
							}
							break;
						case 'datetimesystem':
							if ($campo['type']=='char')
							{
								$model->$prop=date('YmdHis');
							}else{
								$model->$prop=date("Y-m-d H:i:s");
							}
							break;
						case 'datesystem':
							if ($campo['type']=='char')
							{
								$model->$prop=date('Ymd');
							}else{
								$model->$prop=date("Y-m-d");
							}
							break;
						case 'timesystem':
							if ($campo['type']=='char')
							{
								$model->$prop=date('His');
							}else{
								$model->$prop=date("H:i:s");
							}
							break;
						case 'check':
							$checkvalor=explode('/',$campo['checkvalor'].'/0');
							if (is_null($model->$prop)){
								$model->$prop=$checkvalor[1];
							}else{
								if ($model->$prop!=$checkvalor[0]){
									$model->$prop=$checkvalor[1];
								}
							}
							break;

						default:
							# code...
							break;
					}

				}else{
					//print_r($model->$prop+':'+$pro);
					if ($this->getPrimary()!=$prop){
						$model->$prop='';	
					}
				}
			}

	$this->_model=$model;
	return true;
	}


		public function getSearchWhere(){

		$vacio='(pk>0)';
		
		if (Inputs::get("no_search",'')==1){
			$this->_searchMsg='';
			$this->setParam('search_where','');
			$this->setParam('search_msg','');
			return $vacio;

		}

		$campos = Inputs::get("search_campo",array());

		if (sizeof($campos)>0){
			$cond = Inputs::get("search_cond",array());
			$search['_sc4'] = Inputs::get("search_search_date",array());
			$search['_sc1'] = Inputs::get("search_search_text",array());
			$search['_sc2'] = $search['_sc1'];
			$join = Inputs::get("search_join",array());
			$isjoin = Inputs::get("search_isjoin",array());

			$columns=$this->_model->getColumns();
			$joiner='';
			$where='';
			$this->_searchMsg='';

			foreach ($campos as $key => $value){
				$dd=\Mk\Tools\Bd::getTypes($columns[$value]['type']);

				$dato=$this->_model->escape($search[$dd][$key]);

				if (($cond[$key]<3)||($cond[$key]>8)){ $dato=strtoupper($dato);}
				if ($dato!=''){
					$texto=$this->_cond_search[$cond[$key]];
					$texto= str_replace("[1]", $value, $texto);
					$texto= str_replace("[2]", $dato, $texto);

					$msg=$this->_cond_search_msg[$cond[$key]];
					$msg= str_replace("[1]", $columns[$value]['label'], $msg);
					$msg= str_replace("[2]", $dato, $msg);
					


					$where.=$joiner."($texto)";
					$this->_searchMsg.=($joiner=='AND')?' Y ':($joiner=='OR')?' O ':'';
					$this->_searchMsg.="($msg)";
					$joiner=($join[$key]==1)?'AND':'OR';
				}
			}

			$this->setParam('search_where',stripslashes($where));
			$this->setParam('search_msg',stripslashes($this->_searchMsg));
			if ($where==''){
				$where=$vacio;
			}
		}else{
			$where=$this->getParam("search_where",'');
			$this->_searchMsg=$this->getParam("search_msg",'');
			if ($where==''){
				$where=$vacio;
			}

		}
		return $where;
	}

	public function getAnexos($anexos=array()){
		return $anexos;
	}

		public function delete($id){
		if ($id==''){
			return 0;
		}
		$primary = $this->getPrimary();	
		$where="$primary in ($id)";
		$where = array(
		'?'=>$where
		);
		return $this->_model->deleteAll($where);
		}

	public function beforeSave(){

		return true;
	}

	public function afterSave(){
		return true;
	}

	public function actionSave(){
		if (Inputs::request("_save_"))
		{
			$view = $this-> getActionView();

			$this->_model->loadFromArray($_REQUEST);
			$this->_verificarDatos(Inputs::request("_save_"));


			if ($this->_model-> validate())
			{
				$this->beforeSave();
				$this->_model->save();
				$this->afterSave();
				$view->set("success", true);
			}
			$view->set("errors", $this->_model->getErrors());

			if (\Mk\Tools\App::isAjax()==true){
				if ($view->get('success')==true){
					$this->setRenderView(false);
					echo "ok";
				}else{
					$this->setRenderView(false);
					echo json_encode($this->_model->getErrors());
				}
			}else{
				if ($view->get('success')==true){
					$this->changeViewAction('listar.html');
					actionListar();
				}
			}
		}

	}


	public function beforeVer(){
		return true;
	}

	public function afterVer(){
		return true;
	}

	public function actionVer()
	{
		$this->beforeVer();
		$this->actionEdit();
		$view = $this-> getActionView();
		$view
		-> set("item", $this->_model->loadToArray())
		-> set("anexos", $this->getAnexos($this->_model->getColumns()))
		-> set("modTitulo", "Ver ".$this->_model->_tSingular);
		$this->afterVer();
	}


	public function beforeEdit(){
		return true;
	}

	public function afterEdit(){
		return true;
	}

	public function actionEdit()
	{

		$this->changeViewAction('formulario.html');
		$this->beforeEdit();
		$view = $this-> getActionView();
		$this->actionSave();

		$primary = $this->getPrimary();
		$pk =Inputs::request('cod','');
		$modelo = $this->_model;
		$modelo->$primary=$pk;
		$modelo->load();


		$view
		-> set("item", $this->_model->loadToArray())
		-> set("anexos", $this->getAnexos($this->_model->getColumns()))
		-> set("modTitulo", "Editar ".$this->_model->_tSingular);
		$this->afterEdit();
	}
	
	public function beforeAdd(){
		return true;
	}

	public function afterAdd(){
		return true;
	}

	public function actionAdd()
	{

		$this->changeViewAction('formulario.html');
		$this->beforeAdd();
		$view = $this-> getActionView();
		$this->actionSave();
		$view
		-> set("item", $this->_model->loadToArray())
		-> set("anexos", $this->getAnexos($this->_model->getColumns()))
		-> set("modTitulo", "Adicionar ".$this->_model->_tSingular);
		$this->afterAdd();
	}

	public function beforeLIstar(&$where, &$fields, &$order, &$direction, &$limit, &$page){
		return true;
	}

	public function afterListar(&$view){
		return true;
	}

	public function actionListar(){

		$view = $this-> getActionView();
		$primary = $this->getPrimary();
		$order = $this->getParam("order",$primary);
		$direction = $this->getParam("direction",'desc');
		$page = $this->getParam("page",'1');
		$limit = $this->getParam("limit",'10');
		
		$where=$this->getSearchWhere();
		
		if ((Inputs::get("_del",'')=='del')&&(Inputs::get("cod",'')!='')){
			$delete=$this->delete(Inputs::get("cod",''));
		}
		
		$items = false;


		$anexos=$this->getAnexos($this->_model->getColumns());

		$where = array(
		'?'=>$where
		);

		$fields = array(
		"*"
		);
		$count = $this->_model->count($where);
		if ($page>($count/$limit)){
			$page=1;
		}

		$this->beforeListar($where, $fields, $order, $direction, $limit, $page);
		$items = $this->_model->all($where, $fields, $order, $direction, $limit, $page);
		$view
		-> set("order", $order)
		-> set("direction", $direction)
		-> set("page", $page)
		-> set("limit", $limit)
		-> set("count", $count)
		-> set("searchMsg", $this->_searchMsg)
		-> set("modTitulo", "Listado de ".$this->_model->_tPlural)
		-> set("modSingular",$this->_model->_tSingular)
		-> set("anexos", $anexos)
		-> set("items", $items);
		$this->afterListar($view);
	}



	}
}
?>