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