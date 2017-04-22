<?php
namespace  Components\Listtable
{
class Listtable
    {
    	public $variables=array();
        public $campos=array();
        public function __construct($campos = array(),$variables=array())
        {
            $this->campos=$campos;
            $this->variables=$variables;
        }


    	public function encabezados(){

    		$texto='';
    		foreach ($this->campos as $key => $value) {
    			//
    			if (($value['tipolista']!='-1')&&($value['tipolista']!='get')){
    				$this->ncol++;
    				$texto.='<th data-field="'.$key.'" width="'.$value['tamlista'].'" class="sortable {% if ($order==\''.$key.'\') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos['.$key.'][label] %} </th>';
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
                $key1="&key={$key}";
    			switch ($value['tipolista']) {
    				case '-1':
    					//nada
    					break;
    				case 'get':
    					//nada
    					break;
    				case 'status':
                        $status="&status={$value['fcustom']}";
                        $texto.="[[component:]]listtable_col::tipo={$value['tipolista']}{$status}{$key1}[[:component]]";  
    					break;

                    case 'check':
                    case 'lista':
                    case 'join':
                         $texto.="[[component:]]listtable_col::tipo={$value['tipolista']}{$key1}[[:component]]";  
                        break;
    				
    				default:
                        $tipo='default';
                        if ($value['type']=='date'){
                            $tipo='date';

                        }
                        $texto.="[[component:]]listtable_col::tipo={$tipo}{$key1}[[:component]]";  
    					
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