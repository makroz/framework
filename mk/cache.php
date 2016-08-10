<?php
namespace Mk
{
	use Mk\Base as Base;
	use Mk\Cache as Cache;
	//use Mk\Cache\Exception as Exception;
	class Cache extends Base
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
					$parsed = $configuration-> parse("configuration/cache");
					if (!empty($parsed-> cache-> default) && !empty($parsed-> cache-> default-> type))
					{
						$type = $parsed-> cache-> default-> type;
						unset($parsed-> cache-> default-> type);
						$this-> __construct(array(
							"type" => $type,
							"options" => (array) $parsed-> cache-> default
							));
					}
				}
			}

			if (!$type)
			{
				throw $this->_Exception("(type) NO fue definido");
			}
			switch ($type)
			{
				case "memcached":
				{
					return new Cache\Driver\Memcached($this->options);
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