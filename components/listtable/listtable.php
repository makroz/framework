<?php
namespace  Components\Listtable
{
class Listtable
    {
    	public $ncol=0;
    	public $campos=array();
    	public function __construct($campos = array())
        {
        	$this->campos=$campos;
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
/*                        $dataon='';
                        $aux=explode('/',$value['checkvalor'].'/');
                        if ($aux[0]==''){
                            $aux[0]='1';
                        }
                        if ($aux[1]==''){
                            $aux[1]='0';
                        }
                        $dataon='&dataon='.$aux[0];

                        $labelon='';
                        $labeloff='';

                        $aux=explode('/',$value['checklista'].'/');
                        if ($aux[0]==''){
                            $aux[0]='Si';
                        }
                        if ($aux[1]==''){
                            $aux[1]='No';
                        }
                        $labelon='&labelon='.$aux[0];
                        $labeloff='&labeloff='.$aux[1];
                        $texto.="[[component:]]listtable_col::tipo={$value['tipolista']}{$dataon}{$labelon}{$labeloff}{$key1}[[:component]]";  
*/
                        $texto.="[[component:]]listtable_col::tipo={$value['tipolista']}{$key1}[[:component]]";  
                        break;

                     case 'lista':
                         $texto.="[[component:]]listtable_col::tipo={$value['tipolista']}{$key1}[[:component]]";  
                        break;
    				
    				default:

                        $texto.="[[component:]]listtable_col::tipo=default{$key1}[[:component]]";  
    					
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