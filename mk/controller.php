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
		protected $_sharedData=array();
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
		protected $_defaultModules = MODULE_PATH;
		/**
		* @readwrite
		*/
		protected $_pathModule = MODULE_PATH;
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

			
			$router = Registry::get("router");
			$controller = $router->getController();
			$action = $router->getAction();
			
			$defaultPath = $this->getDefaultPath();
			$defaultLayout = $this->getDefaultLayout();
			$defaultExtension = $this->getDefaultExtension();
			$defaultModule=$this->getDefaultModules();
			$this->addViewData('_action',$action);
			$this->addViewData('_controller',$controller);


			if ($this->getWillRenderLayoutView())
			{
				$file="{$defaultModule}/{$controller}/views/{$defaultLayout}.{$defaultExtension}";
				if (!file_exists($file))
				{
					$file=APP_PATH."/{$defaultPath}/{$defaultLayout}.{$defaultExtension}";
				}

				$view = new View(array(
					"file" => $file
					));
				$this->setLayoutView($view);
			}

			if ($this->getWillRenderActionView())
			{
				$this->_pathModule ="{$defaultModule}/{$controller}/views/";
				$file=$this->_pathModule."{$action}.{$defaultExtension}";
				
				if (!file_exists($file))
				{
					$this->_pathModule =APP_PATH."/{$defaultPath}/{$controller}/";
					$file=$this->_pathModule."{$action}.{$defaultExtension}";
				}
				$view = new View(array(
					"file" => $file
					));
				$this->setActionView($view);
				//\MK\Debug::msg($this->getLayoutView()->getFile());
			}
		}

		public function getVarView(){
			$view = $this->getActionView();
			$default = $view->Template->Implementation->getDefaultKey();
			//echo "Mario:".$default;
			$data = Registry::get($default, array());
			Debug::msg($data);
			if ((isset($data['varView']))and(is_array($data['varView'])))
			{
				$this->_sharedData=array_merge($this->_sharedData,$data['varView']);
			}

		}
		public function addViewData($key,$value){
			$this->_sharedData[$key]=$value;
		}

		public function delViewData($key){
			unset($this->_sharedData[$key]);
		}

		public function render()
		{
			$defaultContentType = $this->getDefaultContentType();
			$results = null;
			$doAction = $this->getWillRenderActionView() && $this->getActionView()->fileExist();
			$doLayout = $this->getWillRenderLayoutView() && $this->getLayoutView()->fileExist();
			
			//$this->getVarView();
			try
			{
				

				if ($doAction)
				{
					$view = $this->getActionView();
					foreach ($this->_sharedData as $key => $value) {
						$view->set($key,$value);
					}

					$results = $view->render();
				}
				//\Mk\Shared\FormTools::debug($result,2);
				if ($doLayout)
				{
					$view = $this->getLayoutView();
					$view->set("template", $results);
					foreach ($this->_sharedData as $key => $value) {
						$view->set($key,$value);
					}

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