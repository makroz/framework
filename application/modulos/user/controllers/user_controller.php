<?php 
use Shared\ControllerDb as ControllerDb;
use Mk\Registry as Registry;
use Mk\Session as Session;
use Mk\Events as Events;
use Mk\RequestMethods as RequestMethods;
class User_controller extends ControllerDb
{

		/**
		* @readwrite
		*/
		protected $_secureKey='User';


	public function __construct($options = array())
	{
		parent::__construct($options);

		$this->_model =$this->_getLoged();



	}
/*		$session = Registry::get("session");
			$controller = Registry::get("controller");
			$user = $session-> get("user",false);
			if ($user)
			{
				$this->_model = \User::first(array(
					"id = ?" => $user
					));
			}
*/


	public function setUser($user)
	{
		$session = Registry::get("session");
		if ($user)
		{
			$session-> set("user", $user-> id);
		}
		else
		{
			$session-> erase("user");
		}
		$this-> _model = $user;
		return $this;
	}

	
	public function register()
	{


		\Shared\FormTools::init();
		$view = $this-> getActionView();
		if (RequestMethods::post("register"))
		{

			$user = new User(array(
				"first" => RequestMethods::post("first"),
				"last" => RequestMethods::post("last"),
				"email" => RequestMethods::post("email"),
				"password" => RequestMethods::post("password")
				));
			if ($user-> validate())
			{
				$user->save();
				$view->set("success", true);
			}
			//\Shared\FormTools::debug($user->getErrors(),50000);
			$view->set("errors", $user->getErrors());
		}
		//$view->set("errors", '');
	}


	public function login()
	{

				$database = Registry::get("database");
				$database->getFields('user');
		if (RequestMethods::post("login"))
		{
			$email = RequestMethods::post("email");
			$password = RequestMethods::post("password");
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

		/**
		* @before _secure
		*/	
	public function profile()
	{
		$this-> getActionView()-> set("user", $this->getModel());
	}

		public function search()
		{
		$view = $this-> getActionView();
		$query = RequestMethods::post("query");
		$order = RequestMethods::post("order", "modified");
		$direction = RequestMethods::post("direction", "desc");
		$page = RequestMethods::post("page", 1);
		$limit = RequestMethods::post("limit", 10);
		$count = 0;
		$users = false;
		if (RequestMethods::post("search"))
		{
		$where = array(
		"SOUNDEX(first) = SOUNDEX(?)" => $query,
		"live = ?" => true,
		"deleted = ?" => false
		);
		$fields = array(
		"id", "first", "last"
		);
		$count = User::count($where);
		$users = User::all($where, $fields, $order, $direction, $limit, $page);
		}
		$view
		-> set("query", $query)
		-> set("order", $order)
		-> set("direction", $direction)
		-> set("page", $page)
		-> set("limit", $limit)
		-> set("count", $count)
		-> set("users", $users);
		}

		/**
		* @before _secure
		*/
		public function settings()
		{
			$view = $this->getActionView();
			$user = $this->_model;
			if (RequestMethods::post("update"))
			{
				$user = new User(array(
					"first" => RequestMethods::post("first", $user->first),
					"last" => RequestMethods::post("last", $user->last),
					"email" => RequestMethods::post("email", $user->email),
					"password" => RequestMethods::post("password", $user->password)
					));
				if ($user->validate())
				{
					$user->save();
					$view->set("success", true);
				}
				$view-> set("errors", $user->getErrors());
			}
		}

		public function logout()
		{
			$this-> _setLoged(false);
			header("Location: index.php?url=user/login");
			exit();
		}

		

		public function _admin()
		{
			if (!$this-> _model-> admin)
			{
				throw $this->_Execption("Not a valid admin user account",1);
			}
		}



}


?>