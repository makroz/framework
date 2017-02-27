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

		public static function getListaSel($lista=null,$msg="Selecconar...",$sel='',$datas=''){
			$r='';
			if ($msg!=''){$r.="<option value=''>$msg</option>";}
			if (is_array($lista)){
				foreach ($lista as $key => $val){
					if (is_array($val)){
						$valor='';
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

		public static function st($valor=''){
			$valor=trim($valor);
			$valor=mysql_real_escape_string($valor);
			return $valor;
		}




	}
}

?>