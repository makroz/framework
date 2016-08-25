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
		protected $_databse;

		/**
		* @readwrite
		*/
		protected $_table;

		/**
		* @readwrite
		*/
		protected $_modelName;



		public function __construct($options = array())
		{
			parent::__construct($options);
			//$this->database = Registry::get("database");
		}

		public function init()
		{
			echo "Buscar Tablas";
		}

		



	}
}
?>