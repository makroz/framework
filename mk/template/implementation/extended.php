<?php 

namespace Mk\Template\Implementation
{
	use Mk\Request as Request;
	use Mk\Registry as Registry;
	use Mk\Template as Template;
	use Mk\StringMethods as StringMethods;
	use Mk\Inputs as Inputs;
	class Extended extends Standard
	{
		/**
		* @readwrite
		*/
		protected $_defaultPath = "application/views";
		/**
		* @readwrite
		*/
		protected $_defaultKey = "_data";
		/**
		* @readwrite
		*/
		protected $_index = 0;
		public function __construct($options = array())
		{
			parent::__construct($options);
			$this-> _map = array(
				"var" => array(
					"opener" => "{% var",
					"closer" => "%}",
					"handler" => "_var"
					),
				"partial" => array(
					"opener" => "{% partial",
					"closer" => "%}",
					"handler" => "_partial"
					),
				"include" => array(
					"opener" => "{% include",
					"closer" => "%}",
					"handler" => "_include"
					),
				"yield" => array(
					"opener" => "{% yield",
					"closer" => "%}",
					"handler" => "yield"
					)
				) + $this-> _map;
			$this-> _map["statement"]["tags"] = array(
				"set" => array(
					"isolated" => false,
					"arguments" => "{key}",
					"handler" => "set"
					),
				"append" => array(
					"isolated" => false,
					"arguments" => "{key}",
					"handler" => "append"
					),
				"prepend" => array(
					"isolated" => false,
					"arguments" => "{key}",
					"handler" => "prepend"
					)
				) + $this-> _map["statement"]["tags"];
		}

		protected function _include($tree, $content)
		{
			$template = new Template(array(
				"implementation" => new self()
				));

			$file = trim($tree["raw"]);
			$path = $this-> getDefaultPath();
			$content = file_get_contents("{$path}/{$file}");
			$template-> parse($content);
			//$this-> _index++;
			$index =substr(basename($file), 0,strpos( basename($file),'.')) .$this-> _index++;
			return "function anon_{$index}(\$_data){
				".$template-> getCode()."
			};\$_text[] = anon_{$index}(\$_data);";
		}

		protected function _partial($tree, $content)
		{
			$address = trim($tree["raw"], " /");
			if (StringMethods::indexOf($address, "http") != 0)
			{
				$host = Inputs::server("HTTP_HOST");
				$address = "http://{$host}/{$address}";
			}
			$request = new Request();
			$response = addslashes(trim($request-> get($address)));
			return "\$_text[] = \"{$response}\";";
		}

		protected function _getKey($tree)
		{
			if (empty($tree["arguments"]["key"]))
			{
				return null;
			}
			return trim($tree["arguments"]["key"]);
		}

		protected function _var($tree, $content)
		{
			$var = trim($tree["raw"]);
			//\Mk\Debug::msg($tree);
			$var=explode('=', $var);
			if (!isset($var[1])){
				$var[1]='1';
			}
			$default = $this-> getDefaultKey();
			//echo "Mario5:".$default;
			$data = Registry::get($default, array());
			$var[0]=str_replace(' ','',$var[0]);
			$var[1]=trim($var[1]);
			$data['varView'][$var[0]] = $var[1];
			Registry::set($default, $data);
			//\Mk\Debug::msg($data,4);
			//$this->_header = '\$'.$var.'="{$'.$var.''}"') && sizeof(\$_data))
			//extract(\$_data); \$_text = array();".$this->_header;
			//echo "Mario:((($var)))";
			/*if (!empty($key))
			{
				$default = $this-> getDefaultKey();
				$data = Registry::get($default, array());
				$data[$key] = $value;
				Registry::set($default, $data);
			}*/
		}

		protected function _setValue($key, $value)
		{
			if (!empty($key))
			{
				$default = $this-> getDefaultKey();
				$data = Registry::get($default, array());
				$data[$key] = $value;
				Registry::set($default, $data);
			}
		}
		protected function _getValue($key)
		{
			$data = Registry::get($this->getDefaultKey());
			if (isset($data[$key]))
			{
				return $data[$key];
			}
			return "";
		}

		public function set($key, $value)
		{

			//\Mk\Debug::msg(": $value");
			//$value1=$value;
			if (StringMethods::indexOf($value, "\$_text") >= 0)
			{
				$first = StringMethods::indexOf($value, "\"");
				$last = StringMethods::lastIndexOf($value, "\"");
				$value = stripslashes(substr($value, $first + 1, ($last - $first) - 1));
			}
			if (is_array($key))
			{
				$key = $this-> _getKey($key);
			}
			//\Mk\Debug::msg(print_r($key,true).": $value");
			$this->_setValue($key, $value);
		}

		public function append($key, $value)
		{
			if (is_array($key))
			{
				$key = $this->_getKey($key);
			}
			$previous = $this->_getValue($key);
			$this->set($key, $previous.$value);
		}
		public function prepend($key, $value)
		{
			if (is_array($key))
			{
				$key = $this->_getKey($key);
			}
			$previous = $this->_getValue($key);
			$this->set($key, $value.$previous);
		}
		public function yield($tree, $content)
		{
			$key = trim($tree["raw"]);
			if (StringMethods::indexOf($this-> _getValue($key), "\$_text") >= 0)
			{
				return $this-> _getValue($key);
			}
			else
			{
				
				$value = addslashes($this-> _getValue($key));
				return "\$_text[] = \"{$value}\";";

			}
		}




	}
}

?>