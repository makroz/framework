<?php

namespace Mk
{
	use Mk\Base as Base;
	use Mk\View as View;
	use Mk\Event as Event;
	use Mk\Registry as Registry;
	use Mk\Template as Template;
	//use Mk\Controller\Exception as Exception;
	class Controller extends Base
	{
		/**
		* @readwrite
		*/
		protected $_parameters;
		/**
		* @readwrite
		*/
		protected $_layoutView;
		/**
		* @readwrite
		*/
		protected $_actionView;
		/**
		* @readwrite
		*/
		protected $_willRenderLayoutView = true;
		/**
		* @readwrite
		*/
		protected $_willRenderActionView = true;
		/**
		* @readwrite
		*/
		protected $_defaultPath = "application/views";
		/**
		* @readwrite
		*/
		protected $_defaultLayout = "layouts/standard";
		/**
		* @readwrite
		*/
		protected $_defaultExtension = "html";
		/**
		* @readwrite
		*/
		protected $_defaultContentType = "text/html";
		/**
		* @read
		*/
		protected $_name;

		public function __construct($options = array())
		{
			parent::__construct($options);
			if ($this->getWillRenderLayoutView())
			{
				$defaultPath = $this->getDefaultPath();
				$defaultLayout = $this->getDefaultLayout();
				$defaultExtension = $this->getDefaultExtension();
				$view = new View(array(
					"file" => APP_PATH."/{$defaultPath}/{$defaultLayout}.{$defaultExtension}"
					));
				$this->setLayoutView($view);
			}

			if ($this->getWillRenderActionView())
			{
				$router = Registry::get("router");
				$controller = $router->getController();
				$action = $router->getAction();
				$file=MODULE_PATH. 
					"/{$controller}/views/{$action}.{$defaultExtension}";
				if (!file_exists($file))
				{
					$file=PP_PATH."/{$defaultPath}/{$controller}/{$action}.{$defaultExtension}";
				}
				$view = new View(array(
					"file" => $file
					));
				$this->setActionView($view);
			}
		}
		public function render()
		{
			$defaultContentType = $this->getDefaultContentType();
			$results = null;
			$doAction = $this->getWillRenderActionView() && $this->getActionView()->fileExist();
			$doLayout = $this->getWillRenderLayoutView() && $this->getLayoutView()->fileExist();
			try
			{
				

				if ($doAction)
				{
					$view = $this->getActionView();
					$results = $view->render();
				}
				//\Shared\Markup::debug($result,2);
				if ($doLayout)
				{
					$view = $this->getLayoutView();
					$view->set("template", $results);
					$results = $view->render();
					header("Content-type: {$defaultContentType}");
					echo $results;
				}
				else if ($doAction)
				{
					header("Content-type: {$defaultContentType}");
					echo $results;
				}
				$this->setWillRenderLayoutView(false);
				$this->setWillRenderActionView(false);
			}
			catch (Exception $e)
			{
				throw $this->_Exception("Invalid layout/template syntax");
			}
		}

		protected function getName()
		{
			if (empty($this->_name))
			{
				$this->_name = get_class($this);
			}
			return $this->_name;
		}
		public function __destruct()
		{
			Events::fire("mk.controller.destruct.before", array($this->name));
			$this->render();
			Events::fire("mk.controller.destruct.after", array($this->name));
		}
	}
}	

?>