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
			
/*			if ($this-> _model)
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
*/			
			if ($this-> _model)
			{
				if ($this-> getActionView())
				{
					$this->getActionView()
					->set('_table',$this->_model->getTable());
				}
				if ($this->getLayoutView())
				{
					$this->getLayoutView()
					->set('_table',$this->_model->getTable());
				}
			}

			parent::render();
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