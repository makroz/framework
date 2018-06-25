<?php
namespace  Components\Nodos
{
class Nodos extends \Mk\Component
    {
    	public function __construct($campos = array(),$variables=array(), $options=array())
        {
        	parent::__construct($campos, $variables,$options);
        }

        public function get($p=array()){
            $text='';
            $db=\Mk\Registry::get('database');
            $result=$db->query()->all("select pk,titulo,descrip,boton,color,link from nodos where status=1 order by pk");
            if ($result){
                $text=$this->setData($result,$p[0]);
            }
            return $text;
        }
    }
 }
?>