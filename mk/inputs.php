<?php 

namespace Mk
{
	class Inputs
	{
		private function __construct()
		{

			_escape_request();
		}		

		private function __clone()
		{
// do nothing
		}

		public static function _escape_request()
		{

			// Strip magic quotes from request data.
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    // Create lamba style unescaping function (for portability)
    $quotes_sybase = strtolower(ini_get('magic_quotes_sybase'));
    $unescape_function = (empty($quotes_sybase) || $quotes_sybase === 'off') ? 'stripslashes($value)' : 'str_replace("\'\'","\'",$value)';
    $stripslashes_deep = create_function('&$value, $fn', '
        if (is_string($value)) {
            $value = ' . $unescape_function . ';
        } else if (is_array($value)) {
            foreach ($value as &$v) $fn($v, $fn);
        }
    ');
   
    // Unescape data
    $stripslashes_deep($_POST, $stripslashes_deep);
    $stripslashes_deep($_GET, $stripslashes_deep);

    $stripslashes_deep($_COOKIE, $stripslashes_deep);
    $stripslashes_deep($_REQUEST, $stripslashes_deep);

		}

		}


		public static function request($key, $default = "")
		{
			if (!empty($_REQUEST[$key]))
			{
				return $_REQUEST[$key];
			}
			return $default;
		}

		public static function get($key, $default = "")
		{
			if (!empty($_GET[$key]))
			{
				return $_GET[$key];
			}
			return $default;
		}
		public static function post($key, $default = "")
		{
			if (!empty($_POST[$key]))
			{
				return $_POST[$key];
			}
			return $default;
		}
		public static function server($key, $default = "")
		{
			if (!empty($_SERVER[$key]))
			{
				return $_SERVER[$key];
			}
			return $default;
		}

/**
	 * Returns whether this is an AJAX (XMLHttpRequest) request.
	 * @return boolean whether this is an AJAX (XMLHttpRequest) request.
	 */
	public static function getIsAjaxRequest()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
	}

	/**
	 * Returns whether this is an Adobe Flash or Adobe Flex request.
	 * @return boolean whether this is an Adobe Flash or Adobe Flex request.
	 * @since 1.1.11
	 */
	public static function getIsFlashRequest()
	{
		return isset($_SERVER['HTTP_USER_AGENT']) && (stripos($_SERVER['HTTP_USER_AGENT'],'Shockwave')!==false || stripos($_SERVER['HTTP_USER_AGENT'],'Flash')!==false);
	}



	}
}
?>