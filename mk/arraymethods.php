<?php
namespace Mk
{
	class ArrayMethods
	{
		private function __construct()
		{
// do nothing
		}
		private function __clone()
		{
// do nothing
		}
		public static function clean($array)
		{
			return array_filter($array, function($item) {
				return !empty($item);
			});
		}
		public static function trim($array)
		{
			//print_r($array);
			return array_map(function($item) {
				return trim($item);
			}, $array);
		}
		public static function toObject($array)
		{
			$result = new \stdClass();
			foreach ($array as $key => $value)
			{
				if (is_array($value))
				{
					$result->{$key} = self::toObject($value);
				}
				else
				{
					$result->{$key} = $value;
				}
			}
			return $result;
		}
		public static function flatten($array, $return = array())
		{
			foreach ($array as $key => $value)
			{
				if (is_array($value) || is_object($value))
				{
					$return = self::flatten($value, $return);
				}
				else
				{
					$return[] = $value;
				}
			}
			return $return;
		}

		public static function last($array)
		{
			if (count($array)>0)
				return $array[count($array)-1];
			else
				return false;
		}

		public static function first($array)
		{
			if (count($array)>0)
			return $array[0];
			else
			return false;
		}


	}
}
?>
