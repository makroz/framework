<?php
namespace  Components\Botonera
{
class Botonera
    {
    	public $variables=array();
        public $campos=array();
        public function __construct($campos = array(),$variables=array())
        {
            $this->campos=$campos;
            $this->variables=$variables;
        }

    	public function filtros(){

    		$texto='';
    		foreach ($this->campos as $key => $value) {
    			//
    			if ($value['listafilter']=='1'){
    				$texto.='[[component:]]listtable_filter::id='.$key.'[[:component]]';
    			}
    		}

            if ($texto==''){
                return $texto;
            }
			return '<div class="botonera-panel z-depth-1 left "  >'.
            '<form id="frmFilter" action="#"  method="post" style="margin:0;"  ><ul class="pagination" style="margin:0; height:40px;">'.
            $texto
            .'</ul></form></div>';
    	}


   	}
 }
?>