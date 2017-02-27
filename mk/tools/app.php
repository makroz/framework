<?php  

namespace Mk\Tools
{
	class App
	{
		private function __construct()
		{
		}
		
		private function __clone()
		{
		}

		public static function isAjax(){
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    			return true;
			}else{
				return false;
			}

		}

		



	}
}

?>