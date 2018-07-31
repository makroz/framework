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

		public static function routeLink($link){
			return dirname($_SERVER['SCRIPT_NAME']).'/'.$link;
		}		

		public static function routeImage($img,$dir='/img',$mod=''){
			$link=dirname($_SERVER['SCRIPT_NAME']).'/'.$mod.'/'.$dir.'/'.$img;
			$link=str_replace('//','/',$link);
			return $link;
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

	public static function getDirComponent($name,$ext='.html'){

		$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR;
		
		$file = $dir . $component . $ext;
		if (!file_exists($file)) {
			return $file;
		}

		$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR;
		
		$file = $dir . $component . $ext;
		if (!file_exists($file)) {
			return $file;
		}
		return false;

	}


public static function jsComponentes(){
	$lc=array();
	$lch=array();
	//$ext='.js';

	$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR ;
	$iterator = new \DirectoryIterator($dir);
	foreach ($iterator as $item)
	{
		if (!$item->isDot() && $item->isDir())
		{
			$component=$item->getFilename();
			$file = $dir . $component . DIRECTORY_SEPARATOR. $component;
			if (@filesize($file.'.js') > 0) {
			$lc[$component]=str_replace( CORE_PATH . DIRECTORY_SEPARATOR . 'mk' , '..'. DIRECTORY_SEPARATOR.'mk', $file).'.js';
			$lch[$component]='';
				if (@filesize($file.'.html') > 0) {
					$lch[$component]= $file.'.html';
				}

			}
		}
	}


	$dir  = APP_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR ;
		//echo "3";
	$iterator = new \DirectoryIterator($dir);
	foreach ($iterator as $item)
	{
		if (!$item->isDot() && $item->isDir())
		{
			$component=$item->getFilename();
			$file = $dir . $component . DIRECTORY_SEPARATOR. $component;
			if (@filesize($file.'.js') > 0) {
				$file=str_replace(APP_PATH . DIRECTORY_SEPARATOR , '', $file);
				$lc[$component]=str_replace(APP_PATH . DIRECTORY_SEPARATOR , '', $file).'.js';
				$lch[$component]='';
				if (@filesize($file.'.html') > 0) {
					$lch[$component]= $file.'.html';
				}
			}
			//include($path . "/" . $item->getFilename() . "/initialize.php");
		}
	}


	$r='';$r2='';
	foreach ($lc as $key => $value) {
		$r.="<script src='{$value}'></script>".PHP_EOL;
		if ($lch[$key]!=''){
			$gestor = fopen($lch[$key], "r");
			$html   = trim(fread($gestor, filesize($lch[$key])),PHP_EOL);
			fclose($gestor);
			$html=str_replace(['{%','%}','$'], ['(%','%)','[[]]'], $html);
			$html=str_replace(PHP_EOL, '\n', addslashes($html));
			$r2.=PHP_EOL."Mk_Componentes.setHtml('c-{$key}','{$html}');".PHP_EOL;
			$_code_ = \Mk\Tools\Strings::getEtiquetas($html, '[[var:]]', '[[:var]]', '1');
			//\MK\Debug::msg(implode(',', $_code_),2);
			if (count($_code_)>0){
				$r3=array();
				foreach ($_code_ as $key2 => $value2) {
					$r3[]="'$key2'";
				}
				$r3=implode(',', $r3);
				$r2.=PHP_EOL."Mk_Componentes.setParametros('c-{$key}',[{$r3}]);".PHP_EOL;

			}

		}
		
	}
	if ($r2!=''){
		$r2=PHP_EOL.'<script>'.PHP_EOL.$r2.PHP_EOL.'</script>'.PHP_EOL;
	}
	return addslashes($r.$r2);

	}


	}
}

?>