<?php
namespace  Components\Formulario
{
class Formulario
    {
    	public $variables=array();
    	public $campos=array();
    	public function __construct($campos = array(),$variables=array())
        {
        	$this->campos=$campos;
            $this->variables=$variables;
        }

public function array_sort_by(&$arrIni, $col, $order = SORT_ASC) 
{
    $arrAux = array();
    foreach ($arrIni as $key=> $row) 
    {
        $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
        $arrAux[$key] = strtolower($arrAux[$key]);
    }
    array_multisort($arrAux, $order, $arrIni);
}


        public function codejs(){
            return $this->variables['codejs'];
        }
    	public function inputs(){
            //echo "<hr><pre>";print_r($this->campos);echo "</pre>";
            $this->array_sort_by($this->campos,'posf');
    		$texto='';

    		foreach ($this->campos as $key => $value) {
    			$class='';
                $tam='';
                $onkeypress='';
                $onfocus='';
                $onblur='';
                $onchange='';
                $onclick='';

                if ($value['listaeventos']!=''){

                      $aux=explode('*',$value['listaeventos'].'*');
                      foreach ($aux as $k => $v){
                        if ($v!=''){
                          $eventos=explode('|',$v.'|');
                          if ($eventos[1]!=''){
                                $eventos[1]=trim($eventos[1],';').';';
                                $eventos[1]=str_replace("'",'"', $eventos[1]);
                            switch ($eventos[0]) {
                                case 'onclick':
                                    $onclick.=$eventos[1];
                                    break;
                                case 'onblur':
                                    $onblur.=$eventos[1];
                                    break;
                                case 'onchange':
                                    $onchange.$eventos[1];
                                    break;
                                case 'onfocus':
                                    $onfocus.=$eventos[1];
                                    break;
                                case 'onkeypress':
                                    $onkeypress.=$eventos[1];
                                    break;
                                default:
                                    # code...
                                    break;
                            }

                          }

                         
                        }
                      }
                }


                $unico='';
                if ($value['unico']=='1'){
                    $unico="&unico=1";
                    $onblur.="isUnique_{$key}();";
                }

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

                    $dataon='';
                    if($value['usof']=='check'){
                        $dataon=explode('/',$value['checkvalor'].'/');
                        if ($dataon[0]!=''){
                            $dataon=$dataon[0];
                        }else{
                            $dataon='1';
                        }
                        $dataon='&dataon='.$dataon;
                    }

                    $dec='';
                    if($value['usof']=='float'){
                        if ($value['dec']>0){
                            $dec=$value['dec'];
                        }else{
                            $dec='0';
                        }
                        $dec='&decimal='.$dec;
                        $onkeypress.=" return soloNum(event,this);";
                        $onblur.=" _refreshFloat(this);";


                    }

                    $options='';
                    if($value['usof']=='selec'){
                        /*if ($value['listalista']!=''){
                            $opt=explode('*',$value['listalista'].'*');
                            $options.="<option value='' disabled {% if \$item[{$key}]=='' %}selected='selected' {% /if %} > Seleccione {$value['label']}...";
                            foreach ($opt as $key1 => $value1){
                                if ($value1!=''){
                                    $opt1=explode('|',$value1.'||');
                                    if ($opt1[0]!=''){
                                        if ($opt1[1]==''){
                                            $opt1[1]=$opt1[0];
                                        }

                                        $options.="<option value='{$opt1[0]}' {% if \$item[{$key}]=='{$opt1[0]}' %}selected='selected' {% /if %} ";
                                        if ($opt1[2]!=''){
                                            $options.=" data-tag='{$opt1[2]}' ";
                                        }
                                        $options.=">{$opt1[1]}</option>";
                                    }
                                }
                            }
                            $options='&options='.$options;
                        }*/
                        //$options='&options='.$options;
                    }


                    $validate='';
                    if ($value['validate']!=''){
                        if (stripos($value['validate'],'required')!==false){
                            $validate.=" required ";
                        }
                        $validate.="data-validate='".$value['validate']."'";
                        

                    }
                    $validate='&validate='.$validate;

                    $eventos='';
                    if ($onkeypress!=''){
                        $eventos.=" onkeypress='{$onkeypress}' ";
                    }
                    if ($onblur!=''){
                        $eventos.=" onblur='{$onblur}' ";
                    }
                    if ($onclick!=''){
                        $eventos.=" onclick='{$onclick}' ";
                    }
                    if ($onchange!=''){
                        $eventos.=" onchange='{$onchange}' ";
                    }
                    if ($onfocus!=''){
                        $eventos.=" onfocus='{$onfocus}' ";
                    }



                    if ($eventos!=''){
                        $eventos="&eventos={$eventos}";
                    }
    				$texto.="[[component:]]form_input::id={$key}&label={$value['label']}&tipo={$value['usof']}&tam={$tam}&clase={$class}{$unico}{$dataon}{$dec}{$options}{$validate}{$eventos}[[:component]] ";
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