<?php
namespace Mk
{
    use Mk\Base as Base;
    use Mk\Templatebladeone as Templatebladeone;

    class View extends Base
    {
        /**
        * @readwrite
        */
        protected $_defaultKey = "_data";
        /**
        * @readwrite
        */
        protected $_file;
        public $_template;
        protected $_bladeext='.blade.php';
        protected $_data = array();
        public $sections=array();
        public function _getData()
        {
            return $this->_data;
        }
        public function __construct($options = array())
        {
            parent::__construct($options);
            $views = dirname($this->_file);
            $cache = dirname($this->_file).DIRECTORY_SEPARATOR.'cacheblade';
            define("BLADEONE_MODE", 0); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
            $this->_template=new Templatebladeone\BladeOneMk($views, $cache);
            //if (!$this->_template->templateExiste($this->_file)) {
            //Debug::debug_to_console("No Existe {$this->_file}", 20, 1);
            //} //else {
            //Debug::debug_to_console("Si Existe {$this->_file}", 20, 1);
            //}
            //echo $blade->run(strtolower(basename($this->_file)));
        }
        public function fileExist()
        {
            return $this->_template->templateExiste($this->_file);
        }
        public function getVarView()
        {
            $default = $this->getDefaultKey();
            $data = Registry::get($default, array());
            if ((isset($data['varView']))and(is_array($data['varView']))) {
                $this-> _data=array_merge($this-> _data, $data['varView']);
            }
        }
        public function render($content='', $msg=0)
        {
            $this->getVarView();
            if ($content=='') {
                if (!$this->fileExist()) {
                    return '';
                }
                $content = $this->_template->run(strtolower(basename($this->_file)), $this-> _data);
            } else {
                $content = $this->_template->runString($content, $this-> _data);
            }
            return $content;
        }
        public function get($key, $default = "")
        {
            if (isset($this-> _data[$key])) {
                return $this-> _data[$key];
            }
            return $default;
        }
        protected function _set($key, $value)
        {
            if (!is_string($key) && !is_numeric($key)) {
                throw $this->_Exception("Key must be a string or a number");
            }
            $this-> _data[$key] = $value;
        }
        public function set($key, $value = null)
        {
            if (is_array($key)) {
                $this-> _data = array_merge($this-> _data, $key);
                return $this;
            }
            if ($key!='') {
                $this-> _set($key, $value);
            }
            return $this;
        }
        public function erase($key)
        {
            unset($this-> _data[$key]);
            return $this;
        }
    }
}
