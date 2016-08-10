<?php
namespace Mk
{
	use Mk\Base as Base;
	use Mk\Database as Database;
	//use Exception as Exception;
	class Database extends Base
	{
		/**
		* @readwrite
		*/
		protected $_type;
		/**
		* @readwrite
		*/
		protected $_options;

		public function initialize()
		{
			$type = $this-> getType();
			if (empty($type))
			{
				$configuration = Registry::get("configuration");
				if ($configuration)
				{
					$configuration = $configuration-> initialize();
					$parsed = $configuration->parse("configuration/database");
					if (!empty($parsed-> database-> default) && 
						!empty($parsed-> database-> default-> type))
					{
						$type = $parsed-> database-> default-> type;
						unset($parsed-> database-> default-> type);
						$this-> __construct(array(
							"type" => $type,
							"options" => (array) $parsed->database->default
							));
					}
				}
			}

			if (!$type)
			{
				throw $this->_Exception("El Argumento (type) NO se especifico.");
			}
			switch ($type)
			{
				case "mysql":
				{
					return new Database\Connector\Mysql($this->options);
					break;
				}
				default:
				{
					throw $this->_Exception("El Argumento (type='$type') NO es Valido");
					break;
				}
			}
		}
	}
}
?>