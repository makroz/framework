<?php 

namespace Mk
{
	use Mk\Base as Base;
	use Mk\Template as Template;
	//use Mk\View\Exception as Exception;
	class View extends Base
	{
		/**
		* @readwrite
		*/
		protected $_file;
		/**
		* @read
		*/
		protected $_template;
		protected $_data = array();

		public function __construct($options = array())
		{
			parent::__construct($options);
			$this-> _template = new Template(array(
				"implementation" => new Template\Implementation\Extended(array("defaultPath"=>dirname($this->_file)
					)
					)
				));
			//\Mk\Debug::msg($this-> _template);
			//$this-> _template->_implementation->_defaultPath=dirname($this->getFile());
		}

		public function fileexist()
		{

			
			$this->setFile(strtolower(str_replace("/", DIRECTORY_SEPARATOR, trim($this-> getFile() )) ));
			//echo "File:".$this-> getFile();
			if (!file_exists($this-> getFile()))
			{

				return false;
			}
			return true;
		}

		public function getVarView(){
			
			$default = $this->Template->Implementation->getDefaultKey();
			//echo "Mario:".$default;
			$data = Registry::get($default, array());
			//Debug::msg($data);
			if ((isset($data['varView']))and(is_array($data['varView'])))
			{
				$this-> _data=array_merge($this-> _data,$data['varView']);
			}

		}


		public function render()
		{

			
			if (!$this->fileexist())
			{

				return '';
			}
			$content = file_get_contents($this-> getFile());
			$this-> _template-> parse($content);
			//\Mk\Shared\FormTools::debug($this-> _template-> process($this-> _data),551);

			 $this->getVarView();
			return $this-> _template-> process($this-> _data);
		}
		public function get($key, $default = "")
		{
			if (isset($this-> _data[$key]))
			{
				return $this-> _data[$key];
			}
			return $default;
		}
		protected function _set($key, $value)
		{
			if (!is_string($key) && !is_numeric($key))
			{
				throw $this->_Exception("Key must be a string or a number");
			}
			$this-> _data[$key] = $value;
			//\Mk\Shared\FormTools::debug($this->_data,50);
		}
		public function set($key, $value = null)
		{
			//\Mk\Shared\FormTools::debug($key,51);
			//\Mk\Shared\FormTools::debug($value,10);
			if (is_array($key))
			{
				foreach ($key as $_key => $value)
				{
					$this-> _set($_key, $value);
				}
				return $this;
			}
			$this-> _set($key, $value);
			return $this;
		}
		public function erase($key)
		{
			unset($this-> _data[$key]);
			return $this;
		}
	}
}

?>