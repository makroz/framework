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
		protected $_filterMsg='';

		protected $dataAnt;
		
		public $defaultAction='listar';

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

		public function getArrayFromTable($table,$campo,$tag='',$where="", $join=''){
			$database=\Mk\Registry::get('database');
			$pk = ($database->getPrimaryKeyOf($table));
			$pk=$pk[0];
			if ($tag!=''){
				$tag=", $tag";
			}
			if ($where!=''){
				$where="({$where})and($table.status<>'0')";
			}else{
				$where="($table.status<>'0')";
			}
			$sql="select $table.$pk, $table.$campo $tag from $table $join where $where";
			$result=$database->execute($sql);
			//$result = $this->connector->execute($sql);
			if ($result === false)
			{
				$error = $database->lastError;
				if (DEBUG>0){$error.= "($sql)";}
				throw $this->_Exception("There was an error with your SQL query: {$error} ($sql)");
			}
			$lista = array();
			while ($row=$result->fetch_row())
			{
				$lista[$row[0]]['text']=stripslashes($row[1]);
				if ($tag!=''){
					$row1=$row;
					$row1=array_slice($row1, 2);
					$lista[$row[0]]['tag']=stripslashes(implode($row1,','));
				}
			}
			return $lista;
			//return \Mk\Tools\Form::getListaSel($lista,$msg,$sel);
		}

		public function actionGetListFor($campo='',$anexos=false){
			if (($campo!='')&&($anexos!==false)){
				if (isset($anexos[$campo]['options'])){
					return $anexos[$campo]['options'];	
				}
				if (isset($anexos[$campo]['join'])){
					return $this->getArrayFromTable($anexos[$campo]['join']['table'], $anexos[$campo]['join']['campo'],$anexos[$campo]['join']['tag'],$anexos[$campo]['join']['cond'],$anexos[$campo]['join']['join']);
				}
				
				return array();

			}else{
				$this->setRenderView(false);
				$primary = $this->getPrimary();
				$campo = $this->_model->escape(Inputs::request("campo",''));
				$sel = $this->_model->escape(Inputs::request("sel",''));

				$anexos=$this->getAnexos($this->_model->getColumns());
				$msg = $this->_model->escape(Inputs::request("msg",'Seleccione '.$anexos[$campo]['labelf']));
				
				$table=$anexos[$campo]['join']['table'];
				$grupo=false;
				if (isset($anexos[$campo]['join']['grupo'])){
		
				$anexos=$this->getAnexos($this->_model->getColumns());
					$grupo=true;
				}
				if (isset($anexos[$campo]['options'])){

					echo \Mk\Tools\Form::getOptions($anexos[$campo]['options'],$sel, $msg,$grupo);	
				}
				\Mk\Debug::msg($anexos[$campo],2);
				if (isset($anexos[$campo]['join'])){
					$cond='';

					if (isset($anexos[$campo]['join']['cond'])){
						$cond=$anexos[$campo]['join']['cond'];
						$arg = Inputs::request("arg",'');
						$arg1=Inputs::request("arg1",'');
						//\Mk\Debug::msg($arg1,3,'Arg1:');
						if ($arg1!=''){
							$database=\Mk\Registry::get('database');
							$pk = ($database->getPrimaryKeyOf($table));
							$pk=$pk[0];
							$sql="select $table.$arg1 as dato from $table where $pk='$sel'";
							//\Mk\Debug::msg($sql,3,'Sql1:');
								$result=$database->execute($sql);
								//\Mk\Debug::msg($result,3,'Sql1:');
								if ($result !== false)
								{
									while ($row=$result->fetch_row())
									{
										$arg[]=$row[0];
									}
								}

						}
						//\Mk\Debug::msg($arg,3,'Sql1:');
						
						@$cond=call_user_func_array('sprintf', array_merge((array)$cond, $arg)); 
						//\Mk\Debug::msg($cond,3,'cond:');
					}
					echo \Mk\Tools\Form::getOptions( $this->getArrayFromTable($anexos[$campo]['join']['table'], $anexos[$campo]['join']['campo'],$anexos[$campo]['join']['tag'],$cond,$anexos[$campo]['join']['join']),$sel, $msg,$grupo);
				}

				return "<option value=''>Sin Datos...</option>";
			}

		}

	public function actionDataExist(){
		$this->setRenderView(false);
		$primary = $this->getPrimary();

		$existe=0;
		$campo = $this->_model->escape(Inputs::get("campo",''));
		$valor =$this->_model->escape( Inputs::get("valor",''));
		$pk =$this->_model->escape( Inputs::get("pk",'0'));
		//echo "Datos: {$campo}:{$valor}:{$pk}";
		if (($campo!='')&&($valor!='')){

			$where="({$primary}<>'{$pk}')and({$campo}='{$valor}')";
			//echo $where;
			//$where=$this->getSearchWhere();
			$where = array(
			'?'=>$where
			);
			$count = $this->_model->count($where);
			if ($count>0){
				$existe=1;
			}
		}

		if (\Mk\Tools\App::isAjax()==true){
			echo $existe;
			return $pk;	
		}else{
			echo "<pre>";print_r($existe);echo "</pre>";
			exit;
		}
		return -1;
	}

	public function actionGetItem(){
		$this->setRenderView(false);
		$primary = $this->getPrimary();
		$pk =Inputs::request('cod','');
		$campos =Inputs::request('campos','');
		$join =Inputs::request('join','');
		$cb =Inputs::request('cbuscar','');
		$where=array();
		if ($cb!=''){
			$c=explode(',', $cb.',');
			foreach ($c as $key => $value) {
				if ($value!=''){
					$c1=explode(':',$value.'::');

					if ($c1[0]!=''){
/*						if ($c1[1]=='1'){
							$where.="OR";
						}else{
							$where.="AND";
						}
*/
						switch ($c1[2]) {
							case 'like':
								$where[]="({$c1[0]} LIKE  ('%{$pk}%'))";
								break;
							
							default:
								$where[]="({$c1[0]}='{$pk}')";
								break;
						}
					}
				}
			}
		}

		$campos = $primary.','.$campos; 
		$modelo = new $this->_model;
		$modelo->$primary=$pk;
		$modelo->load(true);
		//echo "<pre>";print_r($where);echo "</pre>";
		if ($modelo->$primary==''){
			foreach ($where as $key => $wer) {
				$modelo->$primary='X';
				$modelo->load(true,$wer);
				if ($modelo->$primary!=''){
					$data=$modelo->loadToArray($campos);
					if (\Mk\Tools\App::isAjax()==true){
						echo json_encode($data);
						return $pk;	
					}else{
						echo "<pre>";print_r($data);echo "</pre>";
						exit;
					}

				}
			}
		}
		//echo "<pre>";print_r($modelo);echo "</pre>";
		$data=$modelo->loadToArray($campos);

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

	public function _FechatoBd($fecha,$campo){
		$model=$this->_model;
		$i= strpos($campo, '.');
		if ($i!==false){
			$i=$i+1;
			$campo=substr($campo,$i);
		}
		$campo=$model->columns[$campo];
		switch ($campo['funcion']) {
		case 'datetime':
		case 'datetimesystem':
			if ($campo['type']=='char'){
				$fecha=\Mk\Tools\Form::dateToDb($fecha,true);
			}else{
				$fecha=\Mk\Tools\Form::dateToDbDate($fecha,true);
			}
			break;
		case 'date':
		case 'datesystem':
			if ($campo['type']=='char'){
				$fecha=\Mk\Tools\Form::dateToDb($fecha);
			}else{

				$fecha=\Mk\Tools\Form::dateToDbDate($fecha);
			}
			break;
		case 'time':
		case 'timesystem':
			if ($campo['type']=='char'){
				$fecha=\Mk\Tools\Form::timeToDb($fecha);
			}else{
				$fecha=\Mk\Tools\Form::timeToDbDate($fecha);
			}
			break;
		default:
			# code...
			break;
	}

	return $fecha;	

	}

	public function _verificarDatos($action){
			$model=$this->_model;
			if ($action=='add'){
				$action='G';
			}else{
				$action='M';
			}

			$notColumns='';
			foreach ($model->columns as $key => $campo) {
				$prop = $campo["name"];

				if (($campo['uso']=='A')||($campo['uso']==$action)){
					//\Mk\Debug::msg($campo['funcion'] . ':' . $model->$prop,1);
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
						case 'pass':
							$model->$prop=\Mk\Tools\Form::tbd($model->$prop);
							break;							
						case 'useract':
							$userAct=$this->_isLoged();
							$model->$prop=$userAct['id'];
							break;							

						case 'check':
							$anexos=$this->getAnexos();
							//$checkvalor=explode('/',$anexos['checkvalor'].'/0');
							if (is_null($model->$prop)){
								$model->$prop=$anexos[$prop]['dataoff'];
							}else{
								if ($model->$prop!=$anexos[$prop]['dataon']){
									$model->$prop=$anexos[$prop]['dataoff'];
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
						//echo "No se Grabara=".$campo['raw'];
						$notColumns[$key]=1;
					}

				}
			}
	$this->_model=$model;
	return $notColumns;
	}


		public function getSearchWhere(){

		$vacio='('.$this->_model->getTable().'.pk>0)';
		
		if (Inputs::get("no_search",'')==1){
			$this->_searchMsg='';
			$this->setParam('search_where','');
			$this->setParam('search_msg','');
			return $vacio;

		}

		$campos = Inputs::get("search_campo",array());
		//echo "capos es:";print_r($campos);
		if (sizeof($campos)>0){
			$cond = Inputs::get("search_cond",array());
			$search['_sc4'] = Inputs::get("search_search_date",array());
			$search['_sc1'] = Inputs::get("search_search_text",array());
			$search['_sc2'] = $search['_sc1'];
			$join = Inputs::get("search_join",array());
			$isjoin = Inputs::get("search_isjoin",array());

			//$columns=$this->_model->getColumns();
			$columns=$this->getAnexos($this->_model->getColumns());
			//echo "columns es:<pre>".print_r($columns,true).'</pre>';
			$joiner='';
			$where='';
			$this->_searchMsg='';

			foreach ($campos as $key => $value){
				//echo "Value es: $value";
				$dd=\Mk\Tools\Bd::getTypes($columns[$value]['type']);
				if ($dd==''){
					$dd='_sc1';
				}

				$dato=$this->_model->escape($search[$dd][$key]);
				if ($dd=='_sc4'){
					$dato=$this->_FechatoBd($dato,$value);
				}
				
				if ((stripos($value, '.')===false)&&($columns[$value]['join']['alias']=='')){
					$value=$this->_model->getTable().'.'.$value;

				}

				if ($columns[$value]['join']['alias']!=''){	
					$value=	$columns[$value]['join']['alias'].'.'.$columns[$value]['join']['campo'];
				}

				if (($cond[$key]<3)||($cond[$key]>8)){ $dato=strtoupper($dato);}
				if ($dato!=''){
					$texto=$this->_cond_search[$cond[$key]];
					$texto= str_replace("[1]", $value, $texto);
					$texto= str_replace("[2]", $dato, $texto);

					$msg=$this->_cond_search_msg[$cond[$key]];
					$msg= str_replace("[1]", $columns[$campos[$key]]['label'], $msg);
					if ($dd=='_sc4'){
						$dato=\Mk\Tools\Form::dbToDate($dato);
					}
					$msg= str_replace("[2]", $dato, $msg);
					


					$where.=$joiner."($texto)";
					$this->_searchMsg.=($joiner=='AND')?' Y ':($joiner=='OR')?' O ':'';
					$this->_searchMsg.="($msg)";
					$joiner=($join[$key]==1)?'AND':'OR';
				}
			}

			if (Inputs::get("search_type",'')!='1'){
				$this->setParam('search_where',stripslashes($where));
				$this->setParam('search_msg',stripslashes($this->_searchMsg));
			}
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
		$columns=$this->getAnexos($this->_model->getColumns());
		$this->_filterMsg='';
		$filter = $this->getParam("_filter",array());
		foreach ($filter as $key => $value) {
			if ($value!=''){
				if (is_array($columns[$key]['options'][$value])){
					$this->_filterMsg.=$columns[$key]['labelf'].':'.$columns[$key]['options'][$value]['text'].'<br>';
				}else{
					$this->_filterMsg.=$columns[$key]['labelf'].':'.$columns[$key]['options'][$value].'<br>';
				}
				
				$where.="and(".$this->_model->getTable().".{$key}='{$value}')";
			}
		}
		//$this->setParam('_filterMsg',stripslashes($this->_filterMsg));

		return $where;
	}

	public function getAnexos($anexos=array(),$join=false){
		return $anexos;
	}

	public function beforeDelete($id){
		return true;
	}

	public function afterDelete($id,$i,$t){
		return true;
	}


	public  function getDatosDb($id,$campos='*', $table=''){
		$id=$this->_model->escape($id);
		$primary = $this->getPrimary();	
		$database = \Mk\Registry::get("database");
		if ($table==''){
			$table=$this->_model->getTable();	
		}
		
		return $database->query()->first("select {$campos} from {$table} where ({$primary}={$id}) limit 1");
	}

	public function delete($id){

		$database = \Mk\Registry::get("database");
		$table=$this->_model->getTable();
		$primary = $this->getPrimary();	
		$ids=explode(',',$id.',');
		$id=array();
		$r=0;
		try {
		$this->StartTransaction();
		foreach ($ids as $key => $value) {
			if (trim($value)!=''){
				$value=$this->_model->escape($value);
				if ($this->beforeDelete($value)){
					$database->execute("delete from $table where ($primary='$value')");
					$r1=$database->affectedRows;
					if ($r1>0){
						$r=$r+$r1;
						$this->afterDelete($value,$key,$r);	
					}
					

				}
				
			}
		}
		$this->commitTransaction();
		} catch (Exception $e) {
			//echo "delete from $table where ($primary='$value')";
			$this->rollbackTransaction();
			$this->_model->setError('ERROR',$e->getMessage());
			$view->set("success", false);
			return $e->getMessage();
		}
		return $r;
	}

	public function beforeSave($action){
		return true;
	}

	public function afterSave($action){
		return true;
	}

	public function actionSave($action='',$data=array()){
		$incode=false;
		if (($action=='')||(empty($data))){
			$action=Inputs::request("_save_",'');
			$data=$_REQUEST;
		}else{
			$incode=true;
		}
		if ($action!='')
		{
			$view = $this-> getActionView();

			//echo "<hr>this1:<hr>";print_r($this->_model);echo "<hr>";
			$this->_model->loadFromArray($data);
			//echo "<hr>this2:<hr>";print_r($this->_model->loadToArray());echo "<hr>";
			$notColumns=$this->_verificarDatos($action);
			//echo "<hr>this3:<hr>";print_r($this->_model->loadToArray());echo "<hr>";
			//\Mk\Debug::msg($_REQUEST,3);
			//echo "<hr>this2:<hr>";print_r($this->_model);echo "<hr>";
			//echo "<hr>Notcolumn:<hr>";print_r($notColumns);echo "<hr>";
			if ($this->_model-> validate())
			{
				try {
				$this->StartTransaction();
				$this->beforeSave($action);
				//print_r($notColumns);
				$this->_model->save($notColumns);
				$this->afterSave($action);
				$this->commitTransaction();
				$view->set("success", true);
				} catch (Exception $e) {
					$this->rollbackTransaction();
					$this->_model->setError('ERROR',$e->getMessage());
					$view->set("success", false);
				}

			}
			$view->set("errors", $this->_model->getErrors());

			if ($incode==true){
				if ($view->get('success')==true){
					$this->setRenderView(false);
					return "ok";
				}else{
					$this->setRenderView(false);
					return json_encode($this->_model->getErrors());
				}

			}

				if ($view->get('success')==true){

					/*componentes */
					if ($_FILES){
						foreach ($_FILES as $file => $fdatos) {
							$foo = new \Mk\Uploadfile($fdatos); 
							if ($foo->uploaded) {
	   						// save uploaded image with no changes
	   							$primary = $this->getPrimary();
	   							$primary=$this->_model->$primary;
	   							$foo->file_new_name_body=$this->_model->getTable()."_{$file}_{$primary}";
	   							$foo->file_new_name_ext='png';
	   							$foo->Process(APP_PATH.'\upload');
	   							if ($foo->processed) {
	     							//echo 'original image copied '.$foo->file_dst_pathname;
	   							} else {
	     							//echo 'error : ' . $foo->error;
	     							$this->_model->setError($file,$foo->error);
	     							$view->set("errors", $this->_model->getErrors());
	     							echo json_encode($_error);
	   							}
	   						}
												
						}
					}
					/*componentes */
				}
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
					$router = Registry::get("router");
					$controller = $router->getController();
					header("Location: index.php?url={$controller}/listar");
				exit();
					//$this->changeViewAction('listar.html');
					//$this->actionListar();
				}else{
					$this->changeViewAction('formulario.html');
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
		-> set("anexos", $this->getAnexos($this->_model->getColumns(),1))
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
		-> set("anexos", $this->getAnexos($this->_model->getColumns(),1))
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
		-> set("anexos", $this->getAnexos($this->_model->getColumns(),1))
		-> set("modTitulo", "Adicionar ".$this->_model->_tSingular);
		$this->afterAdd();
	}

	public function beforeLIstar(&$where, &$fields, &$order, &$direction, &$limit, &$page,&$join){
		return true;
	}

	public function afterListar(&$view){
		return true;
	}

	public function actionIndex(){
		$this->changeViewAction('listar.html');
		$this->actionListar();
	}
	public function actionListar(){

		$view = $this-> getActionView();
		$primary = $this->getPrimary();
		$order = $this->getParam("order",$primary);
		$direction = $this->getParam("direction",'desc');
		$page = $this->getParam("page",'1');
		$limit = $this->getParam("limit",'10');
		$filter = $this->getParam("_filter",array());
		//\Mk\Debug::msg($filter,3,'Filtros');
		$_sele_ =\Mk\Tools\App::isBuscar();

		// if (stripos($order, 'join_')===false){
		// 			$order=$this->_model->getTable().'.'.$order;

		// }
		
		$where=$this->getSearchWhere();
		//echo $where;
		
		if ((Inputs::get("_del",'')=='del')&&(Inputs::get("cod",'')!='')){
			$delete=$this->delete(Inputs::get("cod",''));
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

		$count = $this->_model->count($where, $join);
		if ($page>ceil($count/$limit)){
			$page=1;
		}

		

		$this->beforeListar($where, $fields, $order, $direction, $limit, $page,$join);
		$items = $this->_model->all($where, $fields, $order, $direction, $limit, $page,$join);
		//\Mk\Debug::msg($items,1);
		$view
		-> set("order", $order)
		-> set("direction", $direction)
		-> set("page", $page)
		-> set("limit", $limit)
		-> set("count", $count)
		-> set("_filter", $filter)
		-> set("searchMsg", $this->_searchMsg)
		-> set("filterMsg", $this->_filterMsg)
		-> set("modTitulo", "Listado de ".$this->_model->_tPlural)
		-> set("modSingular",$this->_model->_tSingular)
		-> set("anexos", $anexos)
		-> set("item", $this->_model->loadToArray())
		-> set("items", $items);
		$this->afterListar($view);
	}



	}
}
?>