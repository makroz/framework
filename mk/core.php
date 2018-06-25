<?php
namespace Mk
{
class Core
{

	public  static $_debug=false;
	public  static $_paths=array();

	public static function debug($msg,$color='#000'){
		if (self::$_debug==true){
			echo "<div style='color:{$color};'>".$msg."</div>";	
		}
	}

	public static function initialize()
	{
		if (!defined(MODULE_PATH))
		{
			define("MODULE_PATH",APP_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'modulos');
		}
		//self::addPaths(CORE_PATH);
//		self::addPaths("\application\libraries",1);
//		self::addPaths("\application\controllers",1);
		self::addPaths("\application",1);
		self::addPaths("\application\models",1);
		spl_autoload_register(array('MK\Core', 'autoload'));

	}

	public static function getPaths()
	{
		return self::$_paths;
	}

	public static function addPaths($url,$system='0')
	{
		$url=str_replace('/', "\\", $url);	
		$url=str_replace("\\", DIRECTORY_SEPARATOR, trim($url, "\\"));

		if ($system>0)
		{
			if ($system==1) {$url=APP_PATH.DIRECTORY_SEPARATOR.$url;}
			if ($system==2) {$url=CORE_PATH.DIRECTORY_SEPARATOR.$url;}
		}
		self::$_paths[]=$url;
	}

public static function autoload($class)
{

	//$paths = explode(PATH_SEPARATOR, get_include_path());
	self::debug("Buscando clase: $class",'red');
	$paths = self::getPaths();

	$flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;

	$file=str_replace('/', "\\", $class);	
	$file=str_replace("\\", DIRECTORY_SEPARATOR, trim($file, "\\")).'.php';
	self::debug("File: $file");

	if (strpos($file,"Mk".DIRECTORY_SEPARATOR)===false)
	{	
		self::debug("Entro en no MK: $class",'blue');
		if (strpos($file,'_controller')>0)
		{
			$classFile=basename($file,'_controller.php');
			$combined=MODULE_PATH.DIRECTORY_SEPARATOR.$classFile.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$file;
			self::debug("Buscando file controller: $combined");
			if (file_exists($combined))
			{
				include($combined);
				self::debug("Se encontro clase controller: ($classFile) $combined",'green');
				return;
			}

			$combined=APP_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$file;
			self::debug("Buscando file controller2: $combined");
			if (file_exists($combined))
			{
				include($combined);
				self::debug("Se encontro clase controller2: ($classFile) $combined",'green');
				return;
			}
		}

		$classFile=basename($file,'.php');
		$combined=MODULE_PATH.DIRECTORY_SEPARATOR.$classFile.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$file;
		self::debug("Buscando file models: $combined");
		if (file_exists($combined))
		{
			include($combined);
			self::debug("Se encontro clase models: ($classFile) $combined",'green');
			return;
		}

		//$session = \Mk\Registry::get("session");
		//$classFile=$session-> get("cur_model_path");
/*		if ($classFile!='')
		{
			
			//\Mk\Debug::smsg("$classFile",'cur_model_path');
			$combined=MODULE_PATH.DIRECTORY_SEPARATOR.$classFile.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$file;
			//echo "<br>3Se Busco  $combined ($class)";	
			if (file_exists($combined))
			{
				include($combined);
				//\Mk\Debug::smsg("Se encontro la clase $combined",'',3);	
				return;
			}
		}
*/

		foreach ($paths as $path)
		{
			$combined = str_replace("\\", DIRECTORY_SEPARATOR, $path.DIRECTORY_SEPARATOR.$file);
			self::debug("Buscando file: $combined");
			if (file_exists($combined))
			{
				include($combined);
				self::debug("Se encontro clase: ($classFile) $combined",'green');
				return;
			}
			//echo "<hr>Se busco y no se encontro en  $combined/ (( $class )) (".APP_PATH.'**'.getcwd().")";	
	    }

	}else{

		$classFile=basename($file,'.php');
		$combined=CORE_PATH.DIRECTORY_SEPARATOR.$file;
		self::debug("Buscando file MK: $combined");
		if (file_exists($combined))
		{
			include($combined);
			self::debug("Se encontro clase MK: ($classFile) $combined",'green');
			return;
		}

	}

	
            self::debug("<hr><span style='color:red'>Se busco y no se encontro en  $combined/ (( $class )) (".APP_PATH.'**'.getcwd().")</span>");	
            $deb=debug_backtrace();
            foreach ($deb as $k => $v) {
                self::debug('<pre>'.print_r($v,true).'</pre>');
            }
    //throw new \Exception(" La clase ({$class}) No se encuentra!!!.");
}

}
}




?>