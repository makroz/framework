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

	/**
	 * Returns whether this is an Adobe Flash or Adobe Flex request.
	 * @return boolean whether this is an Adobe Flash or Adobe Flex request.
	 * @since 1.1.11
	 */
	public static function isFlash()
	{
		return isset($_SERVER['HTTP_USER_AGENT']) && (stripos($_SERVER['HTTP_USER_AGENT'],'Shockwave')!==false || stripos($_SERVER['HTTP_USER_AGENT'],'Flash')!==false);
	}


		public static function getConfig($file='param',$type=1){
			$parsed=array();
			$configuration = \Mk\Registry::get("configuration");
				if ($configuration)
				{
					$configuration = $configuration-> initialize();
					$parsed = $configuration-> parse("configuration/{$file}",$type);

				}
			return $parsed;
		}



	}
}

?>