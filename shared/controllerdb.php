<?php 
namespace Shared
{
	use Mk\Events as Events;
	use Mk\Router as Router;
	use Mk\Registry as Registry;
	class ControllerDb extends \Mk\Controller
	{
		
		/**
		* @readwrite
		*/
		protected $_model;

		/**
		* @readwrite
		*/
		protected $_secureKey;

		/**
		* @readwrite
		*/
		protected $_modelName;



		public function __construct($options = array())
		{
			parent::__construct($options);
			$database = Registry::get("database");
			$database-> connect();
			if ((!$this->_secureKey)or($this->_secureKey==''))
			{
				$this->_secureKey=str_replace('_controller','',get_class($this));	
			}

			if ((!$this->_modelName)or($this->_modelName==''))
			{
				$this->_modelName=str_replace('_controller','',get_class($this));	
			}
			if (get_class($this)!=$this->_modelName)
			{
				$this->_model= new $this->_modelName();	
			} 
			

			/*$session = Registry::get("session");
			$user = unserialize($session-> get("user", null));
			$this->setUser($user);*/


// schedule: disconnect from database
			Events::add("mk.controller.destruct.after", function($name) {
				$database = Registry::get("database");
				$database->disconnect();
			});
		}

		

/*		public function __destruct()
		{
			$database = \Mk\Registry::get("database");
			$database-> disconnect();
			parent::__destruct();
		}
*/	

		public function render()
		{
			
			if ($this-> _model)
			{
				if ($this-> getActionView())
				{
					$this->getActionView()
					->set($this->_model->getTable(), $this->_model);
				}
				if ($this->getLayoutView())
				{
					$this->getLayoutView()
					->set($this->_model->getTable(), $this->_model);
				}
			}
			parent::render();
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

		
		public function _secure($key=false)
		{


			$session = Registry::get("session");
			if (($key)and($key!='')){
				$secureKey = $key; 	
			}
			else
			{
				$secureKey = $this->_secureKey;	
			}
			


			$user = $session-> get('Secure_'.$secureKey, null);
			//echo '<hr>Secure_'.$secureKey.' User:';print_r($user);
			if (!$user)
			{
				header("Location: index.php?url={$secureKey}/login");
				exit();
			}
		}

		public function _isLoged($key=false)
		{

			$session = Registry::get("session");
			if (($key)and($key!='')){
				$secureKey = $key; 	
			}
			else
			{
				$secureKey = $this->_secureKey;	
			}
			
			return $session-> get('Secure_'.$secureKey, false);
		}
	
			public function _getLoged($key=false)
		{
			$session = Registry::get("session");
			if (($key)and($key!='')){
				$secureKey = $key; 	
			}
			else
			{
				$secureKey = $this->_secureKey;	
			}

			$user = $session-> get('Secure_'.$secureKey, null);
			if ($user)
			{
				return $this->_model->first(array(
					"id = ?" => $user
					));
			}else{
				return false;
			}
		}
		
		public function _setLoged($id,$key=false)
		{
			$session = Registry::get("session");
			if (($key)and($key!='')){
				$secureKey = $key; 	
			}
			else
			{
				$secureKey = $this->_secureKey;	
			}

			if (($id)and($id!=''))
			{
				return  $session->set('Secure_'.$secureKey, $id);
			}
			else
			{
				return  $session->erase('Secure_'.$secureKey);
			}
		}


	}
}
?>