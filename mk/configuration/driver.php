<?php
namespace Mk\Configuration
{
	use Mk\Base as Base;
	//use Mk\Configuration\Exception as Exception;
	class Driver extends Base
	{
		protected $_parsed = array();
		public function initialize()
		{
			return $this;
		}
	}
}
?>