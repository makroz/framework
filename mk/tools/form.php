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


		public static function getOptions($lista=null,$sel='',$msg="Seleccionar..."){
			$r='';

			if (trim($msg!='')){
				$r.="<option value='' disabled ";
				if (trim($sel)==''){
					$r.=" selected='selected' ";
				}
				 $r.=" > {$msg} </option>";
			}

			//if ($msg!=''){$r.="<option value=''>$msg</option>";}
			if (is_array($lista)){
				foreach ($lista as $key => $val){
					if (is_array($val)){
						$valor='';$datas='';
						foreach ($val as $key1 => $val1){
							if ($key1=='text'){
								$valor=$val1;
							}else{
								$datas.=' data-'.$key1."='$val1'";
							}
						}
						$val=$valor;

					}

					$r.="<option value='$key' $datas >$val</option>";
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
			$valor=trim($valor);
			
			if (get_magic_quotes_gpc()){
				$valor=stripslashes($valor);
			}

			$valor=mysql_real_escape_string($valor);
			return $valor;
		}

		public static function bdt($valor=''){
			$valor=trim($valor);
			$valor=stripslashes($valor);
			return $valor;
		}

		public static function dateToDbDate($fec='',$hora=false, $formato=''){
		if (trim($fec)==''){
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
			
			$fecha = date_create_from_format ($formato , $hora);
			return date('H:i:s',$fecha);
		}
		}//function

		public static function dateToDb($fec='',$hora=false, $formato=''){
		if (trim($fec)==''){
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
		if ((trim($fec)=='')or(parseInt($fec)==0)){return '';
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

			$fecha = date_create_from_format ('YmdHis' , $fec);
			return date($formato,$fecha);
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

			$hora = date_create_from_format ('His' , $hora);
			return date($formato,$hora);
		}
		}//function

		public static function dbDateToDate($fec='',$hora=false,  $formato=''){
		if ((trim($fec)=='')or(parseInt($fec)==0)){return '';
		}else{
			if ($formato==''){
					$formato='Ymd';

				if ($hora==true){
						$formatoh='His';
					}
					$formato.=$formatoh;
				}
			}

			$fecha = date_create_from_format ('Y-m-d H:i:s' , $fec);
			return date($formato,$fecha);
		}//function

		public static function dbDateToTime($hora='',  $formato=''){
		if ((trim($hora)=='')or(parseInt($hora)==0)){return '';
		}else{
			if ($formato==''){
					$formato='His';
			}

			$hora = date_create_from_format ('H:i:s' , $hora);
			return date($formato,$hora);
		}
		}//function



		public static function ISOToDate($fec){
			$fec=dbtoDate($fec,true,true,'Y-m-d H:i:s');
			$date = new DateTime($fec);
			return  $date;
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