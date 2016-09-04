<?php 
namespace Mk\Crud
{
	use Mk\Inputs as Inputs;
	use Mk\Router as Router;
	use Mk\Registry as Registry;
	use Mk\Shared\ControllerDb as ControllerDb;

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
			//$options['willRenderLayoutView']=false;
			$options['defaultModules']=APP_PATH;

			parent::__construct($options);
			$this->_database = Registry::get("database");
			//$this->setWillRenderActionView(false);
			//$this->setWillRenderLayoutView(false);
			//$this->setDefaultModules(APP_PATH.DIRECTORY_SEPARATOR.'mk');

			
		}

		public function actionTable()
		{
			$view = $this-> getActionView();
			$this->addViewData('database',$this->database->getSchema());
			$table=Inputs::get('table');
			$this->addViewData('tableName',$table);
			$table=$this->database->getFields($table);
			$view->set('table',$table);

			
		}

		public function actionInit()
		{




			$view = $this-> getActionView();
			$this->addViewData('database',$this->database->getSchema());
			//echo "Base de datos:".$this->database->getSchema()."<hr>";
			$result=$this->database->execute("SHOW TABLES FROM ".$this->database->getSchema());
			$tables=Array();
			while ($row =$result->fetch_array()) {
				//echo "Tabla:".$row[0]."</br>";
				//echo "<pre>";print_r($this->database->getFields($row[0]));"</pre>";
				$tables[$row[0]]=$this->database->getFields($row[0]);
				//$tables[$row[0]]=$this->database->getTableInformationOf($row[0]);
				
				$view->set('tables',$tables);

			}
			
		}


	}
}
?>