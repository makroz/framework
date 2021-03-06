<?php  

namespace Mk\Tools
{
	class Form
	{
		private function __construct()
		{
		}
		
		private function __clone()
		{
		}


		public static function getOptions($lista=null,$sel='',$msg="Seleccionar...",$grupo=false){
			$r='';

			if (trim($msg!='')){
				$r.="<option value='' ";
				if (trim($sel)==''){
					$r.=" selected='selected' ";
				}
				 $r.=" > {$msg} </option>";
			}

			//if ($msg!=''){$r.="<option value=''>$msg</option>";}
			if ($grupo==true){
				$l2=array();

				if (is_array($lista)){
					foreach ($lista as $key => $val){
						if (is_array($val)){
							if ($val['tag']==0){
								$l2[$key]['text']=$val['text'];
								$l2[$key]['tag']=$val['tag'];
							}else{
								$l2[$val['tag']]['opt'][$key]=$val;
							}
						}
					}
				$lista=$l2;
				}
			}

			if (is_array($lista)){
				foreach ($lista as $key => $val){
					$valor='';$datas='';
					if (is_array($val)){
						$valor=$val['text'];
						$datas=" data-tag='".$val['tag']."'";
						$l2=$val['opt'];
						$val=$valor;
					}
					//print_r($lista);
					if ($grupo==true){
						
						if ((is_array($l2))){
							$r.="<optgroup label='$val'>";
							foreach ($l2 as $key1 => $val1){
								$valor='';$datas='';
								if (is_array($val1)){
									$valor=$val1['text'];
									$datas=" data-tag='".$val1['tag']."'";
									$val1=$valor;
								}
								$r.="<option value='$key1' $datas >$val1</option>";
							}
							$r.="</optgroup>";
						}else{
							$r.="<option value='$key' $datas >$val</option>";	
						}
						

					}else{
						$r.="<option value='$key' $datas >$val</option>";	
					}
					
				}
			}
			if ($sel!='')
			{
				$r=str_replace("value='$sel'","value='$sel' selected",$r);
			}
			return $r;
		}

		public static function fbd($valor='0'){
			$valor=trim($valor);
			$valor=str_replace(',','.',$valor);
			return $valor;
		}

		public static function bdf($valor,$dec=8){
		$valor=trim($valor);
		$sepDec=\Mk\Tools\App::getConfig()->param->decimal->separador;
		if (empty($sepDec)){
			$sepDec='.';
		}
		if ($valor!=''){$valor=number_format($valor,$dec,$sepDec,'');}
		return $valor;
		}


		public static function tbd($valor=''){
			$database=\Mk\Registry::get('database');
			$valor=trim($valor);
			
			if (get_magic_quotes_gpc()){
				$valor=stripslashes($valor);
			}

			$valor=$database->escape($valor);
			return $valor;
		}

		public static function bdt($valor=''){
			$valor=trim($valor);
			$valor=stripslashes($valor);
			return $valor;
		}

		public static function dateToDbDate($fec='',$hora=false, $formato=''){
			$fec=trim($fec);
		if ($fec==''){
			return '';
		}else{

			if ($formato==''){

			$formato=\Mk\Tools\App::getConfig()->param->fecha->formato;
			if (empty($formato)){
				$formato='d/m/Y';
			}



			if ($hora==true){
				$formatoh=\Mk\Tools\App::getConfig()->param->hora->formato;
				if (empty($formatoh)){
					$formatoh='H:i:s';
				}
				$formato.=' '.$formatoh;
			}

			}
			$fecha = date_timestamp_get(date_create_from_format ($formato , $fec));
			//echo "Fechas: $fec | $formato |";print_r($fecha);

			if ($hora==true){
				return date('Y-m-d H:i:s',$fecha);
			}else{
				return date('Y-m-d',$fecha);
			}
		}
		}//function

		public static function timeToDbDate($hora='',$formato=''){
		if (trim($hora)==''){
			return '';
		}else{

			if ($formato==''){

			$formato=\Mk\Tools\App::getConfig()->param->hora->formato;
			if (empty($formato)){
				$formato='H:i:s';
			}

			}
			
			$fecha = date_timestamp_get(date_create_from_format ($formato , $hora));
			return date('H:i:s',$fecha);
		}
		}//function

		public static function dateToDb($fec='',$hora=false, $formato=''){
		
		$fec=trim($fec);
		if ($fec==''){
			return '';
		}else{

			if ($formato==''){

			$formato=\Mk\Tools\App::getConfig()->param->fecha->formato;
			if (empty($formato)){
				$formato='d/m/Y';
			}



			if ($hora==true){
				$formatoh=\Mk\Tools\App::getConfig()->param->hora->formato;
				if (empty($formatoh)){
					$formatoh='H:i:s';
				}
				$formato.=' '.$formatoh;
			}

			}
			
			$fecha = date_create_from_format ($formato , $fec);

			if ($hora==true){
				return date('YmdHis',$fecha);
			}else{
				return date('Ymd',$fecha);
			}
		}
		}//function

		public static function timeToDb($hora='',$formato=''){
		if (trim($hora)==''){
			return '';
		}else{

			if ($formato==''){

			$formato=\Mk\Tools\App::getConfig()->param->hora->formato;
			if (empty($formato)){
				$formato='H:i:s';
			}

			}
			
			$fecha = date_create_from_format ($formato , $hora);
			return date('His',$fecha);
		}
		}//function



		public static function dbToDate($fec='',$hora=false,  $formato=''){

/*		$bus=array('-',':',' ');
		$fec1=str_replace($bus,'',$fec);
		echo "Fecha es: $fec1";
*/		
		$fec=trim($fec);
		if (($fec=='')or($fec*1==0)){
			return '';
		}else{

			$formhora='';
			if (stripos($fec,'-')!==false){
				if ($hora==true){
					$formhora=' H:i:s';
				}else{
					if (stripos($fec,' ')!==false){
						$fec=substr($fec,0,stripos($fec,' '));
					}
				}
				//\Mk\Debug::msg(array($fec,$hora,'Y-m-d'.$formhora,\Mk\Debug::quienLlamo()));
				$fecha = date_timestamp_get(date_create_from_format ('Y-m-d'.$formhora , $fec));
			}else{
				if ($hora==true){
					$formhora='His';
				}else{
					$fec=substr($fec,0,8);
				}
				$fecha = date_timestamp_get(date_create_from_format ('Ymd'.$formhora, $fec));
			}

			if ($formato==''){
				$formato=\Mk\Tools\App::getConfig()->param->fecha->formato;
				if (empty($formato)){
					$formato='d/m/Y';
				}



				if ($hora==true){
					$formatoh=\Mk\Tools\App::getConfig()->param->hora->formato;
					if (empty($formatoh)){
						$formatoh='H:i:s';
					}
					$formato.=' '.$formatoh;
				}
			}
			return trim(date($formato,$fecha));
		}
		}//function

		public static function dbToTime($hora='',  $formato=''){
		if ((trim($hora)=='')or(parseInt($hora)==0)){return '';
		}else{
			if ($formato==''){
				$formato=\Mk\Tools\App::getConfig()->param->hora->formato;
				if (empty($formato)){
					$formato='H:i:s';
				}
			}

			$hora = date_timestamp_get(date_create_from_format ('His' , $hora));
			return date($formato,$hora);
		}
		}//function

		public static function dbDateToDate($fec='',$hora=false,  $formato=''){
		$fec=trim($fec);
		if (($fec=='')or(parseInt($fec)==0)){return '';
		}else{
			if ($formato==''){
					$formato='Ymd';

				if ($hora==true){
						$formatoh='His';
					}
					$formato.=$formatoh;
				}
			}

			$fecha = date_timestamp_get(date_create_from_format ('Y-m-d H:i:s' , $fec));
			return date($formato,$fecha);
		}//function

		public static function dbDateToTime($hora='',  $formato=''){
		if ((trim($hora)=='')or(parseInt($hora)==0)){return '';
		}else{
			if ($formato==''){
					$formato='His';
			}

			$hora = date_timestamp_get(date_create_from_format ('H:i:s' , $hora));
			return date($formato,$hora);
		}
		}//function



		public static function ISOToDate($fec){
			$fec=trim($fec);
			$fec=dbtoDate($fec,true,true,'Y-m-d H:i:s');
			$date = new DateTime($fec);
			return  $date;
		}

		public static function getNodesHtml($nodes,$parent=''){
			$r='';
			if ($parent==''){
				$nodes='{"R":{"t":"Recepcion"},"A":{"t":"Almacen"},"C":{"t":"Cuarentena"},"S":{"t":"Salida"}}';
				$nodes=json_decode($nodes);
			}


			if (count($nodes)==0){return $r;}

			foreach ($nodes as $key => $value) {
			$parent='';
			if ($value->p!=''){
				$parent="treegrid-parent-{$value->p}";
			}

			
				$r.="<tr id='node-{$key}' class='treegrid-{$key} {$parent} '><td>".$value->t."</td><td><a class='btn-floating  waves-effect waves-light green' title='Adicionar'><i class='material-icons'>add</i></a><a class='btn-floating  waves-effect waves-light red' title='Borrar'><i class='material-icons'>delete</i></a><a class='btn-floating  waves-effect waves-light yellow' title='Editar'><i class='material-icons'>edit</i></a></td></tr>";
			}
			return  $r;
		}
		/*public static function getOptions($items=array(),$sel='',$msg='Selecione...'){
			$r='';
			if (trim($msg!='')){
				$r.="<option value='' disabled ";
				if (trim($sel)==''){
					$r.=" selected='selected' ";
				}
				 $r.=" > {$msg} </option>";
			}
			if (is_array($items)){
				foreach ($items as $key => $value) {
					$r.="<option value='{$key}' ";
					if (trim($sel)==$key){
						$r.=" selected='selected' ";
					}
					 $r.=" > {$value} </option>";
				}

			}
			return $r;
		}*/



	}
}

?>