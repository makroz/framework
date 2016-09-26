<?php  

namespace Mk\Tools
{
	class String
	{
		private function __construct()
		{
		}
		
		private function __clone()
		{
		}

		/* USO:
				getEtiquetas('Sample text, [/text to extract/] Rest of sample text [/WEB::http://google.com/] bla bla bla. ','[/','/]'));

			results:
			Array
			(
			    [0] => text to extract
			    [WEB] => Array
			        (
			            [0] => http://google.com
			        )

			) 
		*/
		public static function getEtiquetas($string,$start,$end){
			preg_match_all('/' . preg_quote($start, '/') . '(.*?)'. preg_quote($end, '/').'/i', $string, $m);
			$out = array();

			foreach($m[1] as $key => $value){
				$type = explode('::',$value);
				if(sizeof($type)>1){
					if(!is_array($out[$type[0]]))
						$out[$type[0]] = array();
					$out[$type[0]][] = $type[1];
				} else {
					$out[] = $value;
				}
			}
			return $out;
		}

		public static function stripos_array($haystack, $needles) {
    if ( is_array($needles) ) {
        foreach ($needles as $str) {
            if ( is_array($str) ) {
                $pos = strpos_array($haystack, $str);
            } else {
                $pos = strpos($haystack, $str);
            }
            if ($pos !== FALSE) {
                return $pos;
            }
        }
    } else {
        return strpos($haystack, $needles);
    }
}



	}
}

?>