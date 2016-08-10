<?php
namespace Mk
{
class Core
{
	public  static $_paths=array();

	public static function initialize()
	{
		define("MODULE_PATH",APP_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'modulos');
		self::addPaths(CORE_PATH);
		self::addPaths("\application\libraries",1);
		self::addPaths("\application\controllers",1);
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
		if ($system>0)
		{
			$url=str_replace("\\", DIRECTORY_SEPARATOR, trim($url, "\\"));
			if ($system==1) {$url=APP_PATH.DIRECTORY_SEPARATOR.$url;}
			if ($system==2) {$url=CORE_PATH.DIRECTORY_SEPARATOR.$url;}
		}
		self::$_paths[]=$url;
	}

public static function autoload($class)
{

	//$paths = explode(PATH_SEPARATOR, get_include_path());

	$paths = self::getPaths();

	$flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
	$file = strtolower(str_replace("\\", DIRECTORY_SEPARATOR, trim($class, "\\"))).".php";
	//echo "$file<br>(".strpos("mk\\",$file).')';
	
	if ((strpos($file,"mk\\")===false)and(strpos($file,"shared\\")===false))
	{	
		if (strpos($file,'_controller')>0)
		{
			$classFile=basename($file,'_controller.php');
			\Mk\Debug::smsg("$classFile",'_controlller');
			$combined=MODULE_PATH.DIRECTORY_SEPARATOR.$classFile.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$file;
			\Mk\Debug::smsg("1Se Busco  $combined ($class)",'',3);	
			if (file_exists($combined))
			{
				include($combined);
				\Mk\Debug::smsg("Se encontro la clase $combined",'',3);	
				return;
			}
		}

		$classFile=basename($file,'.php');
		\Mk\Debug::smsg("$classFile",'models');
		$combined=MODULE_PATH.DIRECTORY_SEPARATOR.$classFile.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$file;
		\Mk\Debug::smsg("2Se Busco  $combined ($class)",'',3);	
		if (file_exists($combined))
		{
			include($combined);
			\Mk\Debug::smsg("Se encontro la clase $combined",'',3);	
			return;
		}

		$session = Registry::get("session");
		$classFile=$session-> get("cur_model_path");
		if ($classFile!='')
		{
			
			\Mk\Debug::smsg("$classFile",'cur_model_path');
			$combined=MODULE_PATH.DIRECTORY_SEPARATOR.$classFile.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$file;
			\Mk\Debug::smsg("3Se Busco  $combined ($class)",'',3);	
			if (file_exists($combined))
			{
				include($combined);
				\Mk\Debug::smsg("Se encontro la clase $combined",'',3);	
				return;
			}
		}


	}

	foreach ($paths as $path)
	{
		$combined = $path.DIRECTORY_SEPARATOR.$file;
		
		if (file_exists($combined))
		{
			include($combined);
			\Mk\Debug::smsg("Se encontro la clase $combined",'',4);	
			return;
		}
		\Mk\Debug::smsg("Se busco y no se encontro en  $combined/ (( $class )) (".APP_PATH.'**'.getcwd().")",'',4);	
    }
            $deb=debug_backtrace();
            foreach ($deb as $k => $v) {
                \Mk\Debug::msg($v,3,3);
            }
    throw new \Exception(" La clase ({$class}) No se encuentra!!!.");
}

}
}




?>