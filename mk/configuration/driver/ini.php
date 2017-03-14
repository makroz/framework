<?php

namespace Mk\Configuration\Driver
{
	use Mk\ArrayMethods as ArrayMethods;
	use Mk\Configuration as Configuration;
	//use Mk\Configuration\Exception as Exception;
	class Ini extends Configuration\Driver
	{
		protected function _pair($config, $key, $value)
		{
			if (strstr($key, "."))
			{
				$parts = explode(".", $key, 2);
				if (empty($config[$parts[0]]))
				{
					$config[$parts[0]] = array();
				}
				$config[$parts[0]] = $this->_pair($config[$parts[0]], $parts[1], $value);
			}
			else
			{
				$config[$key] = $value;
			}
			return $config;
		}


		public function parse($path,$type=1)
		{
			if (empty($path))
			{
				throw $this->_Exception("(path) No fue definida");
			}

			if (!isset($this->_parsed[$path]))
			{
				if (!file_exists(APP_PATH."/{$path}.ini")){
					throw $this->_Exception("el Archivo (".APP_PATH."/{$path}.ini) NO existe");	
				}
				$config = array();
				ob_start();
				include(APP_PATH."/{$path}.ini");
				$string = ob_get_contents();
				ob_end_clean();
				//print_r($string );
				//print_r(parse_ini_string($string));
				
				$pairs = parse_ini_string($string);
				if ($pairs == false)
				{
					throw $this->_Exception("Could not parse configuration file");
				}
				foreach ($pairs as $key => $value)
				{
					$config = $this->_pair($config, $key, $value);
				}

				$this->_parsed[$path] = $config;
			}
			if ($type==1){
				return ArrayMethods::toObject($this->_parsed[$path]);
			}else{
				return $this->_parsed[$path];
			}
		}
	}
}

?>