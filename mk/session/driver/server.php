<?php
namespace Mk\Session\Driver
{
	use Mk\Session as Session;
	class Server extends Session\Driver
	{
		/**
		* @readwrite
		*/
		protected $_prefix = APP_PATH;
		public function __construct($options = array())
		{
			parent::__construct($options);
			session_start();
			//echo $_SESSION;
		}
		public function get($key, $default = null)
		{
			$prefix = $this-> getPrefix();
			//\Mk\Debug::msg($_SESSION,1,"Get:".$prefix.$key);
			if (isset($_SESSION[$prefix.$key]))
			{
				return $_SESSION[$prefix.$key];
			}
			return $default;
		}
		public function set($key, $value)
		{
			//\Mk\Debug::msg($_SESSION,1,"Set:".$prefix.$key);
			$prefix = $this-> getPrefix();
			$_SESSION[$prefix.$key] = $value;
			return $this;
		}
		public function erase($key)
		{
			$prefix = $this-> getPrefix();
			unset($_SESSION[$prefix.$key]);
			return $this;
		}
		public function __destruct()
		{
			//echo "finalizando session";
			//session_commit();
		}
	}
}
?>
