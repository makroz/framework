<?php 
namespace Mk\Shared
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
		protected $_modelName;


		public function __construct($options = array())
		{
			parent::__construct($options);
			$database = Registry::get("database");
			$database-> connect();
			

			if ((!$this->_modelName)or($this->_modelName==''))
			{
				$this->_modelName=str_replace('_controller','',get_class($this));	
			}

			if (get_class($this)!=$this->_modelName)
			{
				$this->_model= new $this->_modelName();	
			} 
			
			Events::add("mk.controller.destruct.after", function($name) {
				$database = Registry::get("database");
				$database->disconnect();
			});
		}

		public function StartTransaction(){
			$database = Registry::get("database");
			$database->startTransaction();
			return true;
		}

		public function commitTransaction(){
			$database = Registry::get("database");
			$database->commitTransaction();
			return true;
		}

		public function rollbacktTransaction(){
			$database = Registry::get("database");
			$database->rollbackTransaction();
			return true;
		}
				
		public function render()
		{
			

			if ($this-> _model)
			{
				$this->addViewData('_table',$this->_model->getTable());
			}

			$this->addViewData('_param',\Mk\Tools\App::getConfig()->param);

			parent::render();
		}



		public function getPrimary($mod=null){
			if (!$mod){
				$mod=$this->_model;
			}
			$primary = $mod->primaryColumn;
			$primary = $primary["name"];
			return $primary;
		}

		public function getPrimaryValue($mod=null){
			if (!$mod){
				$mod=$this->_model;
			}
			$primary = $mod->primaryColumn;
			$raw = $primary["raw"];
			return $mod->$raw;
		}


	}
}
?>