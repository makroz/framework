<?php
namespace Mk
{
	use Mk\Base as Base;
	use Mk\Configuration as Configuration;
	//use Mk\Configuration\Exception as Exception;
	class Configuration extends Base
	{
		private $_codeError=2000;
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
			if (!$this->type)
			{
				throw $this->_Exception("Invalid type");
			}
			switch ($this->type)
			{
				case "ini":
				{
					return new Configuration\Driver\Ini($this->options);
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