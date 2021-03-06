<?php

namespace Mk\Tools
{
	class Strings
	{
		private function __construct()
		{
		}

		private function __clone()
		{
		}


		public static function pluralize($t){

			$t=trim($t);
			if ($t==''){return '';}
			$out='';
			$last=strtolower(substr($t,-1));
			if (self::stripos_array($last,array('a','e','i','o','u'))!==false){
				$out=$t.'s';
			}else{
				$out=$t.'es';
			}
			if (self::stripos_array($last,array('z'))!==false){
				$out=substr($t,0,-1).'ces';
			}

			return $out;
		}

		public static function singularize($t){
			$t=rtrim($t,'es');
			$t=rtrim($t,'s');
			return $t;
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

			public static function getComponentes(&$string,$start='[[componente:',$end='[[:componente]]',$_reemplazo='componente',$startend=']]',$out=array()){
				$ini=stripos($string,$start);
					$i=0;
				while ($ini!==false){
					$ini1=$ini;$nappend='';
					if ($startend!=''){
						$ini=stripos($string,$startend,$ini);
						$nappend=substr($string,$ini1+strlen($start),$ini-($ini1+strlen($start)));
					}
					if ($ini!==false){
						if ($startend!=''){
							$ini=$ini+strlen($startend);
						}else{
							$ini=$ini+strlen($start);
						}
						$fin=stripos($string,$end,$ini);
						if ($fin!==false){
							$value=substr($string,$ini,$fin-$ini);
							//if (stripos($value,'{%')!==false){
								$i++;
								if ($_reemplazo!==false){
									if ($_reemplazo!=''){
										$code="[[code:{$_reemplazo}:".trim($nappend)."{$i}]]";
										//$previus='';
										//$nappend=$nappend.$i;
										if (is_array($out[trim($nappend)])==false){
											$out[trim($nappend)]=array();
										}
										if (in_array($value,$out[trim($nappend)])===false){
											//echo "SIIII ENTROOOOOO";
											$out[trim($nappend)][$i]=$value;
										}
										$string=str_replace($start.$nappend.$startend.$value.$end, $code, $string);
										$fin=$ini+strlen($code);
										//echo "<hr>:".($fin+strlen($end)).":".strlen($string)."<hr>";
										if ($fin+strlen($end)>strlen($string)){
											$ini=stripos($string,$start,$ini);
										}else{
											$ini=stripos($string,$start,$ini);
										}

									}else{
										$code='';
										if (in_array($value,$out[trim($nappend)])===false){
											$out[trim($nappend)][$i]=$value;
										}
										$string=str_replace($start.$nappend.$startend.$value.$end, $code, $string);
										$fin=$ini1;
										$ini=stripos($string,$start,$fin);
									}
								}else{
									if (in_array($value,$out[trim($nappend)])===false){
											$out[trim($nappend)][$i]=$value;
									}
									$ini=stripos($string,$start,$fin+strlen($end));
								}
							//}
							//$ini=stripos($string,$start,$fin+strlen($end));
						}else{
							$ini=false;
						}
					}
				}
				return $out;
			}

			public static function getCodes(&$string,$start,$end,$_reemplazo='',$startend='',$type='a',$out=array()){
				//$out = array();
				$ini=stripos($string,$start);
					$i=0;
				while ($ini!==false){
					$ini1=$ini;$nappend='';
					if ($startend!=''){

						$ini=stripos($string,$startend,$ini);
						$nappend=trim(substr($string,$ini1+strlen($start),$ini-($ini1+strlen($start))));
					}
					if ($ini!==false){
						if ($startend!=''){
							$ini=$ini+strlen($startend);
						}else{
							$ini=$ini+strlen($start);
						}
						$fin=stripos($string,$end,$ini);
						if ($fin!==false){
							$value=substr($string,$ini,$fin-$ini);
							//if (stripos($value,'{%')!==false){
								$i++;
								if ($_reemplazo!==false){
									if ($_reemplazo!=''){
										$code="[[code:{$_reemplazo}:{$nappend}{$i}]]";
										//$previus='';
										$nappend=$nappend.$i;
										if (stripos($out[$nappend],$value)===false){
											if ($type=='a'){
												$value=$out[$nappend].$value;
											}
											if ($type=='p'){
												$value=$value.$out[$nappend];
											}
											$out[$nappend]=$value;
										}
										$string=substr_replace($string, $code, $ini,$fin-$ini);
										$fin=$ini+strlen($code);
										$ini=stripos($string,$start,$fin+strlen($end));
									}else{
										$code='';
										if (stripos($out[$nappend],$value)===false){
											if ($type=='a'){
												$value=$out[$nappend].$value;
											}
											if ($type=='p'){
												$value=$value.$out[$nappend];
											}

											$out[$nappend]=$value;
										}
										$string=substr_replace($string, $code, $ini1,($fin+strlen($end))-$ini1);
										$fin=$ini1;
										$ini=stripos($string,$start,$fin);
									}
								}else{
									if (stripos($out[$nappend],$value)===false){
										if ($type=='a'){
												$value=$out[$nappend].$value;
										}
										if ($type=='p'){
											$value=$value.$out[$nappend];
										}
										$out[$nappend]=$value;
									}
									$ini=stripos($string,$start,$fin+strlen($end));
								}
							//}
							//$ini=stripos($string,$start,$fin+strlen($end));
						}else{
							$ini=false;
						}
					}
				}
				return $out;
			}

			public static function getEtiquetas(&$string,$start,$end,$_type='',$_key='root',$_delete=false){
				$string = str_replace("\n",'[[ln]]',$string);
				preg_match_all('/' . preg_quote($start, '/') . '(.*?)'. preg_quote($end, '/').'/i', $string, $m);
				$string = str_replace('[[ln]]',"\n",$string);
				$out = array();

				foreach($m[1] as $key => $value){
					$value=str_replace('[[ln]]',"\n",$value);
					if ($_type==1){
						if ((stripos($value,' ')!==true)and(stripos($value,'::')!==true)){
							$value=$value.'::';
						}
					}


					$type = explode('::',$value);
					if((sizeof($type)>1)&&($_type!=3)){
						$type[0] = trim(str_replace("\n",'',$type[0]));
						if(!is_array($out[$type[0]]))
							$out[$type[0]] = array();
						$key1=$type[0];
						unset($type[0]);
						$value1=rtrim(implode('::',$type),'::');
						if ($_type==2){
							if (stripos($out[$key1][$_key],$value)===false){
								$out[$key1][$_key]="\n". $value1;
							}
						}else{
							$out[$key1][] = $value1;
						}
						if ($_delete!==false){
							$string = str_replace($start.$value1.$end,$_delete,$string);
						}

					} else {
						if ($_type!=1){
							if (stripos($out[$_key],$value)===false){
								$out[$_key] .="\n".$value;
							}

						}else{
							$out[] =$value;
						}
						if ($_delete!==false){
							$string = str_replace($start.$value.$end,$_delete,$string);
						}

					}
				}

				if ($_type!=1){
					$out= $out[$_key];
				}
				return $out;
			}


			public static function getEtiquetas1(&$string,$start,$end,$_type='',$_key='root',$_delete=false){
				$string = str_replace("\n",'[[ln]]',$string);
				preg_match_all('/' . preg_quote($start, '/') . '(.*?)'. preg_quote($end, '/').'/i', $string, $m);
				$string = str_replace('[[ln]]',"\n",$string);
				$out = array();

				foreach($m[1] as $key => $value){
					$value=str_replace('[[ln]]',"\n",$value);
					if ($_type==1){
						if ((stripos($value,' ')!==true)and(stripos($value,'::')!==true)){
							$value=$value.'::';
						}
					}


					$type = explode('::',$value);
					if((sizeof($type)>1)&&($_type!=3)){
						$type[0] = trim(str_replace("\n",'',$type[0]));
						if(!is_array($out[$type[0]]))
							$out[$type[0]] = array();
						$key1=$type[0];
						unset($type[0]);
						$value1=rtrim(implode(',',$type),',');
						if ($_type==2){
							if (stripos($out[$key1][$_key],$value)===false){
								$out[$key1][$_key]="\n". $value1;
							}
						}else{
							$value1=explode(',',$value1);
							$out[$key1] = $value1;
						}
						if ($_delete!==false){
							$string = str_replace($start.$value1.$end,$_delete,$string);
						}

					} else {
						if ($_type!=1){
							if (stripos($out[$_key],$value)===false){
								$out[$_key] .="\n".$value;
							}

						}else{
							$out[] =$value;
						}
						if ($_delete!==false){
							$string = str_replace($start.$value.$end,$_delete,$string);
						}

					}
				}

				if ($_type!=1){
					$out= $out[$_key];
				}
				return $out;
			}

			public static function quitarSaltosDobles($text){

			while (stripos($text,"\t".PHP_EOL)!==false){
				$text = str_replace("\t".PHP_EOL,PHP_EOL,$text);
			}

			while (stripos($text,'  '.PHP_EOL)!==false){
				$text = str_replace('  '.PHP_EOL,PHP_EOL,$text);
			}

			while (stripos($text,' '.PHP_EOL)!==false){
				$text = str_replace(' '.PHP_EOL,PHP_EOL,$text);
			}

			while (stripos($text,'	'.PHP_EOL)!==false){
				$text = str_replace('	'.PHP_EOL,PHP_EOL,$text);
			}

			while (stripos($text,PHP_EOL.PHP_EOL.PHP_EOL)!==false){
				$text = str_replace(PHP_EOL.PHP_EOL.PHP_EOL,PHP_EOL,$text);
			}

			while (stripos($text,PHP_EOL.PHP_EOL)!==false){
				$text = str_replace(PHP_EOL.PHP_EOL,PHP_EOL,$text);
			}
			return $text;

			}


			public static function stripos_array($haystack, $needles,$what=false,$sep='') {
				if ( is_array($needles) ) {
					foreach ($needles as $str) {
						//echo "buscando {$str} en {$haystack}";
						$pos = stripos($haystack.$sep, $str.$sep);
						if ($pos !== FALSE) {
							//echo " Si se encontro en la pos: {$pos}";
							if ($what){
								$pos=array($pos,$str);
							}
							return $pos;
						}

					}
				} else {
					$pos=stripos($haystack, $needles);
				}

				if ($pos !== FALSE) {
						if ($what){
							$pos=array($pos,$str);
						}
				}
				return $pos;

			}



		}
	}

	?>
