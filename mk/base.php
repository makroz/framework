<?php
namespace Mk
{
    use Mk\Inspector as Inspector;
    use Mk\ArrayMethods as ArrayMethods;
    use Mk\StringMethods as StringMethods;
    use Exception as Exception;
    class Base
    {
        private $_codeError=1000;
        private $_inspector;
        public function __construct($options = array())
        {
            $this->_inspector = new Inspector($this);
            //echo "Se creo Constructor de la clase: ".get_class($this)." <br>";
            if (is_array($options) || is_object($options))
            {
                foreach ($options as $key => $value)
                {
                    $key = ucfirst($key);
                    $method = "set{$key}";
                    $this->$method($value);
                }
            }
        }

        public function __call($name, $arguments)
        {
            if (empty($this->_inspector))
            {
                throw $this->_Exception("Call parent::__construct!");
            }
            $getMatches = StringMethods::match($name, "^get([a-zA-Z0-9_]+)$");
            if (sizeof($getMatches) > 0)
            {
                $normalized = lcfirst($getMatches[0]);
                $property = "_{$normalized}";
                if (property_exists($this, $property))
                {
                    $meta = $this->_inspector->getPropertyMeta($property);
                    if (empty($meta["@readwrite"]) && empty($meta["@read"]))
                    {
                        throw $this->_getExceptionForWriteonly($normalized);
                    }
                    if (isset($this->$property))
                    {
                        return $this->$property;
                    }
                    return null;
                }
            }
            $setMatches = StringMethods::match($name, "^set([a-zA-Z0-9_]+)$");
            if (sizeof($setMatches) > 0)
            {
                $normalized = lcfirst($setMatches[0]);
                $property = "_{$normalized}";
                if (property_exists($this, $property))
                {
                    $meta = $this->_inspector->getPropertyMeta($property);
                    if (empty($meta["@readwrite"]) && empty($meta["@write"]))
                    {
                        throw $this->_getExceptionForReadonly($normalized);
                    }
                    $this->$property = $arguments[0];
                    return $this;
                }
            }
            throw $this->_getExceptionForImplementation($name);
        }
        public function __get($name)
        {
            $function = "get".ucfirst($name);
            return $this->$function();
        }
        public function __set($name, $value)
        {
            $function = "set".ucfirst($name);
            return $this->$function($value);
        }
        protected function _getExceptionForReadonly($property)
        {
            return $this->_Exception("La Propiedad {$property} es read-only");
        }
        protected function _getExceptionForWriteonly($property)
        {
            return $this->_Exception("La Propiedad {$property} es write-only");
        }
        protected function _getExceptionForProperty()
        {
            return $this->_Exception("Propiedad Invalida");
        }

        protected function getBacktrace($code=3)
        {
            $deb=debug_backtrace();
            foreach ($deb as $k => $v) {
                \Mk\Debug::msg($v,$code,5);
            }
            
        }

        protected function _Exception($msg='...', $code=0,$prev=null)
        {
            $code=$this->_codeError+$code;
            $this->getBacktrace($code);
            if (DEBUG>0){$msg='('.get_class($this).')'.$msg;}
            return new Exception($msg,$code,$prev);
        }

        protected function _getExceptionForImplementation($method, $code=0,$prev=null)
        {
            return $this->_Exception("Metodo ({$method}) NO Implementado!!!.",$code,$prev);
        }
    }
}
?>