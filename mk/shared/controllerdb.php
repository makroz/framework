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
			
			Events::add("mk.controller.destruct.after", function($name) {
				$database = Registry::get("database");
				$database->disconnect();
			});
		}

		public function render()
		{
			

			if ($this-> _model)
			{
				$this->addViewData('_table',$this->_model->getTable());
			}

			$loged=$this-> _isLoged();
			if ($loged)
			{
				$this->addViewData('_loged',$loged);
			}


			$this->addViewData('_param',\Mk\Tools\App::getConfig()->param);


			parent::render();
		}


		protected function processUser($user,$key=false)
		{
			$dato=$user->getData();
			unset($dato['user']['pass']);
			return $dato;
		}
	
		protected function getKey($key=false)
		{
			if (($key)and($key!='')){
				$secureKey = $key; 	
			}
			else
			{
				$secureKey = $this->_secureKey;	
			}
			$secureKey=ucfirst($secureKey);
			return $secureKey;
		}

		public function _secure($key=false)
		{
			$session = Registry::get("session");
			$secureKey = $this->getKey($key);
			$user = $session-> get('Secure_'.$secureKey, null);
			if (!$user)
			{
				$session-> set('Secure_page_'.$secureKey,$_SERVER['QUERY_STRING']);
				header("Location: index.php?url={$secureKey}/login");
				exit();
			}
		}

		public function _isLoged($key=false)
		{

			$session = Registry::get("session");
			$secureKey = $this->getKey($key);
			
			return $session-> get('Secure_'.$secureKey, false);
		}
	
			public function _getLoged($key=false)
		{
			$session = Registry::get("session");
			$secureKey = $this->getKey($key);

			$user = $session-> get('Secure_'.$secureKey, null);
			if ($user)
			{
				/* TODO: revsar non esta bien */
				return processUser($this->_model->first(array(
					"id = ?" => $user
					))
				);
			}else{
				return false;
			}
		}
		
		public function actionLogout($key)
		{
			$this->_setLoged('',null,$key,true);
			$secureKey = $this->getKey($key);
			header("Location: index.php?url={$secureKey}/login");
			exit();

		}

		public function _setLoged($id,$user,$key=false,$logout=false)
		{
			$session = Registry::get("session");
			$secureKey = $this->getKey($key);
			\Mk\Debug::debug_to_console($user);
			if (($id)and($id!='')and($user))
			{
				$dato['id']=$id;
				$dato['time']=date('YmdHis');
				$dato['user']=$this->processUser($user);
				$session->set('Secure_'.$secureKey, $dato);

				return  true;
			}
			else
			{
				if ($logout){
					$session->erase('Secure_page_'.$secureKey);	
				}
				return  $session->erase('Secure_'.$secureKey);
			}
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