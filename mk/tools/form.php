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

		public static function getListaSel($lista=null,$msg="Selecconar...",$sel=''){
			$r='';
			if ($msg!=''){$r.="<option value='-1'>$msg</option>";}
			if (is_array($lista)){
				foreach ($lista as $key => $val){
					$r.="<option value='$key'>$val</option>";
				}
			}
			if ($sel!='')
			{
				$r=str_replace("value='$sel'","value='$sel' selected",$r);
			}
			return $r;
		}



	}
}

?>