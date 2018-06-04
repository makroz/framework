<?php
namespace  Components\Hua
{
class Hua extends \Mk\Component
    {
    	public function __construct($campos = array(),$variables=array(), $options=array())
        {
        	parent::__construct($campos, $variables,$options);
        }

        public function prueba($p=array()){
            return "{$p[0]}:({$p[1]})";
        }
    }
 }
?>