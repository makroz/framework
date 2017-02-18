<?php
namespace  Components\Formulario
{
class Formulario
    {
    	public $ncol=0;
    	public $campos=array();
    	public function __construct($campos = array())
        {
        	$this->campos=$campos;
        }

    	public function inputs(){

    		$texto='';
    		foreach ($this->campos as $key => $value) {
    			$class='';
                $tam='';
    			if ($value['usof']!='-1'){
    				$this->ncol++;
                    if ($value['tam']==''){
                        $class='s12';
                    }
                    if (\Mk\Tools\String::stripos_array($value['tam'],array('s','m','l'))!==false){
                        $class=$value['tam'];
                    }else{
                        $tam=$value['tam'];
                    }

    				$texto.="[[component:]]form_input::id={$key}&label={$value['label']}&tipo={$value['usof']}&tam={$tam}&clase={$class}[[:component]] ";
    			}
    		}
			//return '{% php print_r($_data); %}'.$texto;
			return $texto;
    	}
    	public function filas(){
    		$texto='';
    		foreach ($this->campos as $key => $value) {
    			/*if (($value['tipolista']!='-1')&&($value['tipolista']!='get')){
    				$texto.='<td > {% echo $row['.$key.'] %} </td>';
    			}*/
    			switch ($value['tipolista']) {
    				case '-1':
    					//nada
    					break;
    				case 'get':
    					//nada
    					break;
    				case 'status':
    					//print_r($value);
    					$texto.='<td >[[component:]]listtable_status::status='.$value['fcustom'].'[[:component]]</td>';	
    					break;
    				
    				default:
    					$texto.='<td > {% echo $row['.$key.'] %} </td>';
    					break;
    			}

    		}
			return $texto;
    	}
    	public function filasvacias(){
    		$texto='';
    		foreach ($this->campos as $key => $value) {
    			if (($value['tipolista']!='-1')&&($value['tipolista']!='get')){
    				$texto.='<td > </td>';
    			}
    		}
			return $texto;
    	}
   	}
 }
?>