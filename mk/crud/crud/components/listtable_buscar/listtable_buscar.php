<?php
namespace  Components\Listtable_buscar
{
class Listtable_buscar
    {
    	public $ncol=0;
    	public $campos=array();
        
    	public function __construct($campos = array())
        {
        	$this->campos=$campos;
        }

    	public function opciones(){
    		$texto='';
    		foreach ($this->campos as $key => $value) {
    			//
    			if ($value['search']=='1'){
                    $texto.='<option value="'.$key.'" class="'.\Mk\Tools\Bd::getTypes($value['type']).'">'.$value['label'].'</option>'; 
                    $this->ncol++;

    			}
    		}
			return $texto;
    	}
    	
   	}
 }
?>