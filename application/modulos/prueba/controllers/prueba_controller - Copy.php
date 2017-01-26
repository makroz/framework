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


	public function __construct($options = array())
	{
		parent::__construct($options);

		//$this->_model =$this->_getLoged();



	}

	
	public function getParam($name,$Default=''){
		$session = Registry::get("session");
		$valor = Inputs::get($name, $session->get($name,$Default));
		$session->set($name,$valor);
		return $valor;
	}

	public function actionListar(){
		//$session = Registry::get("session");

		$view = $this-> getActionView();

		$order = $this->getParam("order",'pk');
		$direction = $this->getParam("direction",'desc');
		$page = $this->getParam("page",'1');
		$limit = $this->getParam("limit",'10');

		$items = false;
		$where = array(
		"status = ?" => 'E'
		);
		$fields = array(
		"pk", "nombre", "status"
		);
		$count = Prueba::count($where);
		$items = Prueba::all($where, $fields, $order, $direction, $limit, $page);

		$view
		-> set("query", $query)
		-> set("order", $order)
		-> set("direction", $direction)
		-> set("page", $page)
		-> set("limit", $limit)
		-> set("count", $count)
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