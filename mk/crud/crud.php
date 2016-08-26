<?php 
namespace Mk\Crud
{
	use Mk\Events as Events;
	use Mk\Router as Router;
	use Mk\Registry as Registry;
	use Shared\ControllerDb as ControllerDb;

	class Crud extends ControllerDb
	{
		
		/**
		* @readwrite
		*/
		protected $_database;

		/**
		* @readwrite
		*/
		protected $_table;

		


		public function __construct($options = array())
		{
			parent::__construct($options);
			$this->_database = Registry::get("database");
			$this->setWillRenderActionView(false);
			$this->setWillRenderLayoutView(false);
		}

		public function actionInit()
		{
			echo "Base de datos:".$this->database->getSchema()."<hr>";
			$result=$this->database->execute("SHOW TABLES FROM ".$this->database->getSchema());
			while ($row =$result->fetch_array()) {
				echo "Tabla:".$row[0]."</br>";
				echo "<pre>";print_r($this->database->getFields($row[0]));"</pre>";
			}
			
		}

		



	}
}
?>