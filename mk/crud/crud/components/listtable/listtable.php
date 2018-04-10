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

    		$texto1='';
    		foreach ($this->campos as $key => $value) {
    			$texto='';
    			if (($value['tipolista']!='-1')&&($value['tipolista']!='get')){
    				$this->ncol++;
                    $ordkey='';
                    if ($value['tipolista']=='join'){
                        $ordkey='join_';
                    }

    				$texto.='<th data-field="'.$ordkey.$key.'" width="'.$value['tamlista'].'" class="sortable {% if ($order==\''.$ordkey.$key.'\') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos['.$key.'][label] %} </th>';
                    if ($value['listafilter']==1){
                        $texto='{% if ($_filter['.$key.']=="") %}'.$texto.'{% /if %}';
                    }

    			}
                $texto1.=$texto;
    		}

			//return '{% php print_r($_data); %}'.$texto;
			return $texto1;
    	}
    	public function filas(){

    		$texto1='';
    		foreach ($this->campos as $key => $value) {
    			/*if (($value['tipolista']!='-1')&&($value['tipolista']!='get')){
    				$texto.='<td > {% echo $row['.$key.'] %} </td>';
    			}*/
                $texto='';
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
                        $texto.="[[component:]]listtable_col::tipo={$tipo}{$key1}&tipolista={$value['tipolista']}[[:component]]";  
    					
    					break;
    			}

                switch ($value['tipolista']) {
                    case '-1':
                        //nada
                        break;
                    case 'get':
                        //nada
                        break;
                    
                    default:
                        if ($value['listafilter']==1){
                            $texto='{% if ($_filter['.$key.']=="") %}'.$texto.'{% /if %}';
                        }
                        break;
                }

             $texto1.=$texto;
      		}
			return $texto1;
    	}

    	public function filasvacias(){
    		$texto1='';
    		foreach ($this->campos as $key => $value) {
                $texto='';
    			if (($value['tipolista']!='-1')&&($value['tipolista']!='get')){
    				$texto.='<td > </td>';
                    if ($value['listafilter']==1){
                        $texto='{% if ($_filter['.$key.']=="") %}'.$texto.'{% /if %}';
                    }

    			}
                $texto1.=$texto;
    		}
			return $texto1;
    	}
   	}
 }
?>