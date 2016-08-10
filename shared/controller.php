<?php 
namespace Shared
{
	class Controller extends \Mk\Controller
	{
		/**
		* @readwrite
		*/
		protected $_user;

		public function __construct($options = array())
		{
			parent::__construct($options);
			$database = \Mk\Registry::get("database");
			$database-> connect();

			$session = \Mk\Registry::get("session");
			$user = unserialize($session-> get("user", null));
			$this->setUser($user);
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


	}
}
?>