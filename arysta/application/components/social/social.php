<?php
namespace  Components\Social
{
class Social extends \Mk\Component
    {
    	public function __construct($campos = array(),$variables=array(), $options=array())
        {
        	parent::__construct($campos, $variables,$options);
        }

        public function get($p=array()){
            $text='';
            $db=\Mk\Registry::get('database');
            $result=$db->query()->all("select pk,nom, link from sociales where status=1");
            if ($result){
                $text=$this->setData($result,$p[0]);
            }
            return $text;
        }
    }
 }
?>