<?php  

namespace Mk\Tools
{
	class Bd
	{

		private  $_types = array(
            "autonumber"=>'_sc2',
            "text"=>'_sc1',
            "integer"=>'_sc2',
            "decimal"=>'_sc2',
            "boolean"=>'_sc2',
            "datetime"=>'_sc4',
            "varchar"=>'_sc1',
            "char"=>'_sc1',
            "tinyint"=>'_sc2',
            "float"=>'_sc2'
            );

		private function __construct()
		{
		}
		
		private function __clone()
		{
		}

		public static function getTypes($i){
			$tipos= array(
            "autonumber"=>'_sc2',
            "text"=>'_sc1',
            "integer"=>'_sc2',
            "decimal"=>'_sc2',
            "boolean"=>'_sc2',
            "datetime"=>'_sc4',
            "varchar"=>'_sc1',
            "char"=>'_sc1',
            "tinyint"=>'_sc2',
            "float"=>'_sc2'
            );
            return $tipos[$i];

		}



	}
}

?>
