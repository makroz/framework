<?php

namespace Mk
{
	use Mk\Base as Base;
	use Mk\Events as Events;
	use Mk\Registry as Registry;
	use Mk\Inspector as Inspector;
	//use Mk\Router\Exception as Exception;
	class Router extends Base
	{
		 private $_codeError=3000;
		/**
		* @readwrite
		*/
		protected $_url;
		/**
		* @readwrite
		*/
		protected $_extension;
		/**
		* @read
		*/
		protected $_controller;
		/**
		* @read
		*/
		protected $_action;
		protected $_routes = array();

		public function addRoute($route)
		{
			$this->_routes[] = $route;
			return $this;
		}
		public function removeRoute($route)
		{
			foreach ($this->_routes as $i => $stored)
			{
				if ($stored == $route)
				{
					unset($this->_routes[$i]);
				}
			}
			return $this;
		}
		public function getRoutes()
		{
			$list = array();
			foreach ($this->_routes as $route)
			{
				$list[$route->pattern] = get_class($route);
			}
			return $list;
		}
		protected function _pass($controller, $action, $parameters = array(),$crud=false)
		{
			
			$this->_action = $action;
			

			$action='action'.ucfirst($action);
			if ($crud==false){
				$name = ucfirst($controller).'_controller';
			}else{
				$name = ucfirst($controller);	
			}
			
			$this->_controller = $controller;
			
			Events::fire("mk.router.controller.before", array($controller, $parameters));
			try
			{
				//echo "<hr><hr><hr><hr>$name";
				$instance = new $name(array(
					"parameters" => $parameters
					));
				Registry::set("controller", $instance);
			}
			catch (\Exception $e)
			{
				
				throw $this->_Exception("Controller {$name} not found",1,$e);
			}

			Events::fire("mk.router.controller.after", array($controller, $parameters));
			
			if (!method_exists($instance, $action))
			{
					$instance->willRenderLayoutView = false;
					$instance->willRenderActionView = false;
					throw $this->_Exception("Action {$action} not found in {$name}",2);
			}
			$inspector = new Inspector($instance);
			$methodMeta = $inspector->getMethodMeta($action);
			if (!empty($methodMeta["@protected"]) || !empty($methodMeta["@private"]))
			{
				throw $this->_Exception("Action {$action} not found",3);
			}
			$hooks = function($meta, $type) use ($inspector, $instance)
			{
				if (isset($meta[$type]))
				{
					$run = array();
					foreach ($meta[$type] as $method)
					{
						$hookMeta = $inspector->getMethodMeta($method);
						if (in_array($method, $run) && !empty($hookMeta["@once"]))
						{
							continue;
						}
						$instance->$method();
						$run[] = $method;
					}
				}
			};
			Events::fire("mk.router.beforehooks.before", array($action, $parameters));
			$hooks($methodMeta, "@before");
			Events::fire("framework.router.beforehooks.after", array($action, $parameters));

			Events::fire("mk.router.action.before", array($action, $parameters));
			call_user_func_array(array(
				$instance,
				$action
				), is_array($parameters) ? $parameters : array());
			Events::fire("mk.router.action.after", array($action, $parameters));

			Events::fire("mk.router.afterhooks.before", array($action, $parameters));
			$hooks($methodMeta, "@after");
			Events::fire("mk.router.afterhooks.after", array($action, $parameters));
		// unset controller
			Registry::erase("controller");
		}
		public function dispatch()
		{
			if ($_GET['crud'])
			{
				$controller = 'Mk\Crud\Crud';
				$action = ($_GET["crud"]!='') ? $_GET["crud"] : "init";
				$parameters = $route->parameters;
				$this->_pass($controller, $action, $parameters,true);
				return;

			}
			$url = $this->url;
			$parameters = array();
			$controller = "index";
			$action = "index";
			foreach ($this->_routes as $route)
			{
				$matches = $route->matches($url);
				if ($matches)
				{
					$controller = $route->controller;
					$action = $route->action;
					$parameters = $route->parameters;
					$this->_pass($controller, $action, $parameters);
					return;
				}
			}
			$parts = explode("/", trim($url, "/"));
			if (sizeof($parts) > 0)
			{
				$controller = $parts[0];
				if (sizeof($parts) >= 2)
				{
					$action = $parts[1];
					$parameters = array_slice($parts, 2);
				}
			}
			$this->_pass($controller, $action, $parameters);
		}
	}
}

?>