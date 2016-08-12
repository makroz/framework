<?php 
namespace Shared
{
	use Mk\Events as Events;
	use Mk\Router as Router;
	use Mk\Registry as Registry;
	class ControllerDb extends \Mk\Controller
	{
		private $_codeError=4000;
		/**
		* @readwrite
		*/
		protected $_user;

		public function __construct($options = array())
		{
			parent::__construct($options);
			$database = Registry::get("database");
			$database-> connect();

			$session = Registry::get("session");
			$user = unserialize($session-> get("user", null));
			$this->setUser($user);

// schedule: load user from session
			Events::add("mk.router.beforehooks.before", function($name, $parameters) {
				$session = Registry::get("session");
				$controller = Registry::get("controller");
				$user = $session-> get("user");
				if ($user)
				{
					$controller-> user = \User::first(array(
						"id = ?" => $user
						));
				}
			});
// schedule: save user to session
			Events::add("mk.router.afterhooks.after", function($name, $parameters) {
				$session = Registry::get("session");
				$controller = Registry::get("controller");
				if ($controller-> user)
				{
					$session-> set("user", $controller-> user-> id);
				}
			});
// schedule: disconnect from database
			Events::add("mk.controller.destruct.after", function($name) {
				$database = Registry::get("database");
				$database->disconnect();
			});
		}

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
			$this-> _user = $user;
			return $this;
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
			if ($this-> getUser())
			{
				if ($this-> getActionView())
				{
					$this->getActionView()
					->set("user", $this->getUser());
				}
				if ($this->getLayoutView())
				{
					$this->getLayoutView()
					->set("user", $this->getUser());
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


		/**
		* @protected
		*/
		public function _admin()
		{
			if (!$this-> user-> admin)
			{
				throw $this->_Execption("Not a valid admin user account",1);
			}
		}


	}
}
?>