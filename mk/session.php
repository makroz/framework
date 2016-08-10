<?php 
namespace Mk
{
	use Mk\Base as Base;
	use Mk\Registry as Registry;
	use Mk\Session as Session;
//use Mk\Session\Exception as Exception;
	class Session extends Base
	{
		/**
		* @readwrite
		*/
		protected $_type='server';
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
					$parsed = $configuration-> parse("configuration/session");
					if (!empty($parsed-> session-> default) && 
						!empty($parsed-> session-> default-> type))
					{
						$type = $parsed-> session-> default-> type;
						unset($parsed-> session-> default-> type);
						$this-> __construct(array(
							"type" => $type,
							"options" => (array) $parsed-> session-> default
							));
					}
				}
			}
			if (empty($type))
			{
				throw $this->_Exception("Invalid type");
			}
			switch ($type)
			{
				case "server":
				{
					return new Session\Driver\Server($this-> getOptions());
					break;
				}
				default:
				{
					throw $this->_Exception("Invalid type");
					break;
				}
			}
		}
	}
}
?>