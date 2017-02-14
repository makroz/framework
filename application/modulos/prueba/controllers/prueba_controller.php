<?php 
use Mk\Shared\ControllerDb as ControllerDb;
use Mk\Registry as Registry;
use Mk\Session as Session;
use Mk\Events as Events;
use Mk\Inputs as Inputs;
class Prueba_controller extends ControllerDb
{

		/**
		* @readwrite
		*/
		//protected $_secureKey='User';
		//
		private $_searchMsg='';
		


	public function __construct($options = array())
	{
		parent::__construct($options);

		//$this->_model =$this->_getLoged();



	}

			public function actionSetData(){
		$this->setRenderView(false);

		$pk =Inputs::get("pk",'');
		$campos = Inputs::get("campos",array());
		$campos=array_merge(array("pk"=>$pk),$campos);
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


	public function getParam($name,$Default='',$controller=''){
		if ($controller==''){
			$controller=$this->getName();
		}		
		$session = Registry::get("session");
		$valor = Inputs::get($name, $session->get($controller.'_'.$name,$Default));

		$session->set($controller.'_'.$name,$valor);
		return $valor;
	}

	public function setParam($name,$valor,$controller=''){
		if ($controller==''){
			$controller=$this->getName();
		}		
		$session = Registry::get("session");
		$session->set($controller.'_'.$name,$valor);
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
//				echo "<hr>el dato es:".$dd.'<br>';

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


	
	public function actionListar(){

		$view = $this-> getActionView();

		$order = $this->getParam("order",'pk');
		$direction = $this->getParam("direction",'desc');
		$page = $this->getParam("page",'1');
		$limit = $this->getParam("limit",'10');
		$where=$this->getSearchWhere();
		$items = false;
		$where = array(
		'?'=>$where
		);

		$fields = array(
		"pk", "nombre", "status"
		);
		$count = $this->_model->count($where);
		$items = $this->_model->all($where, $fields, $order, $direction, $limit, $page);

		$view
		-> set("query", $query)
		-> set("order", $order)
		-> set("direction", $direction)
		-> set("page", $page)
		-> set("limit", $limit)
		-> set("count", $count)
		-> set("searchMsg", $this->_searchMsg)
		-> set("modTitulo", "Listado de ".$this->_model->_tPlural)
		-> set("items", $items);


		



	}



/*
	public function actionRegister()
	{


		$view = $this-> getActionView();
		if (Inputs::post("register"))
		{

			$user = new User(array(
				"first" => Inputs::post("first"),
				"last" => Inputs::post("last"),
				"email" => Inputs::post("email"),
				"password" => Inputs::post("password")
				));
			if ($user-> validate())
			{
				$user->save();
				$view->set("success", true);
			}
			//\Mk\Shared\FormTools::debug($user->getErrors(),50000);
			$view->set("errors", $user->getErrors());
		}
		//$view->set("errors", '');
	}*/


/*	public function actionLogin()
	{

		if (Inputs::post("login"))
		{
			$email = Inputs::post("email");
			$password = Inputs::post("password");
			$view = $this-> getActionView();
			$error = false;
			if (empty($email))
			{
				$view-> set("email_error", "Email not provided");
				$error = true;
			}
			if (empty($password))
			{
				$view-> set("password_error", "Password not provided");
				$error = true;
			}

			if (!$error)
			{
				$session = Registry::get("session");
				$user = new $this->_modelName();
				$user = $user->first(array(
					"email = ?" => $email,
					"password = ?" => $password,
					"live = ?" => true,
					"deleted = ?" => false
					));
				//echo '<hr>Modelo '.$this->_modelName.' User:';print_r($user);
				if (!empty($user))
				{
					
					$this-> _setLoged($user->id);
					header("Location: index.php?url={$this->_secureKey}/profile");
					exit();
				}
				else
				{
					$this-> _setLoged(false);
					$view-> set("password_error", "Email address and/or password are incorrect");
				}
			}
		}
	}
*/
		/**
		* @before _secure
		*/	
/*	public function actionProfile()
	{
		$this-> getActionView()-> set("user", $this->getModel());
	}

	*/	

		/**
		* @before _secure
		*/
/*		public function actionSettings()
		{
			$view = $this->getActionView();
			$user = $this->_model;
			if (Inputs::post("update"))
			{
				$user = new User(array(
					"first" => Inputs::post("first", $user->first),
					"last" => Inputs::post("last", $user->last),
					"email" => Inputs::post("email", $user->email),
					"password" => Inputs::post("password", $user->password)
					));
				if ($user->validate())
				{
					$user->save();
					$view->set("success", true);
				}
				$view-> set("errors", $user->getErrors());
			}
		}
*/		
/*
		public function actionLogout()
		{
			$this-> _setLoged(false);
			header("Location: index.php?url=user/login");
			exit();
		}

		*/

	/*	public function _admin()
		{
			if (!$this-> _model-> admin)
			{
				throw $this->_Execption("Not a valid admin user account",1);
			}
		}*/



}


?>