<?php
namespace Mk
{
    class Component
    {

        protected $variables=array();
        protected $campos=array();

        public function __construct($campos = array(),$variables=array(), $options=array())
        {
            $this->campos=$campos;
            $this->variables=$variables;

        }

        public function setData($datos,$var='cdata'){
            $datos=json_encode($datos);
            return '{% php $'.$var.'=json_decode(\''.$datos.'\',true); %}';

        }

    }
}
?>