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
    				$texto.='<th data-field="'.$key.'" width="'.$value['tamlista'].'" class="sortable {% if ($order==\''.$key.'\') %} sort_{% echo $direction; %} {% /if %}" >'.$value['label'].'</th>';
    			}
    		}
			//return '{% php print_r($_data); %}'.$texto;
			return $texto;
    	}
    	public function filas(){


        $anexos['base']['labelon']='Si';
        $anexos['base']['labeloff']='No';
        $anexos['base']['dataon']=1;

        $anexos['tipo']['optionsl']="<option value='X' >Unico</option><option value='U' >Unidad</option><option value='P' >Peso</option><option value='D' >Distancia</option><option value='V' >Volumen</option><option value='T' >Tiempo</option>";
        $anexos['tipo']['options']['X']='Unico';
        $anexos['tipo']['options']['U']='Unidad';
        $anexos['tipo']['options']['P']='Peso';
        $anexos['tipo']['options']['D']='Distancia';
        $anexos['tipo']['options']['V']='Volumen';
        $anexos['tipo']['options']['T']='Tiempo';


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
                        $dataon='';
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