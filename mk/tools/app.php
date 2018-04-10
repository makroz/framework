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

		public static function isBuscar(){
			if (\Mk\Inputs::request("_buscar_")) {
    			return \Mk\Inputs::request("_buscar_");
			}else{
				return false;
			}

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

	public static function getDirComponent($name,$dir=''){

		$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR;
		
		$file = $dir . $component . '.html';
		if (!file_exists($file)) {
			return $file;
		}

		$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR;
		
		$file = $dir . $component . '.html';
		if (!file_exists($file)) {
			return $file;
		}

	}



	}
}

?>