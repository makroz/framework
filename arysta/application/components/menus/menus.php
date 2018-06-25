<?php
namespace  Components\Menus
{
class Menus extends \Mk\Component
    {
    	public function __construct($campos = array(),$variables=array(), $options=array())
        {
        	parent::__construct($campos, $variables,$options);
        }

        public function get($p=array()){
            $text='';
            $db=\Mk\Registry::get('database');
            $result=$db->query()->all("select pk,nom, link,tipo from menus where status=1");
            if ($result){
                $text=$this->setData($result,$p[0]);
            }
            return $text;
        }
        public function gets($p=array()){
            $text='';
            $db=\Mk\Registry::get('database');
            $result=$db->query()->all("select pk,nom, link,tipo,contenido from submenus where (fk_menus='{$p[0]}')and(status=1)");
            if ($result){
                $text=$this->setData($result,$p[1]);
            }
            return $text;
        }

    }
 }
?>