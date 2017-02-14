<?php
error_reporting( E_ALL ^ E_NOTICE);
define("DEBUG", 1);
define("APP_PATH", dirname(__FILE__));
define("CORE_PATH", dirname(__FILE__));
try
{
require(CORE_PATH."/mk/core.php");
Mk\Core::initialize();
$path = APP_PATH . "/application/plugins";
$iterator = new DirectoryIterator($path);
foreach ($iterator as $item)
{
	if (!$item->isDot() && $item->isDir())
	{
		include($path . "/" . $item->getFilename() . "/initialize.php");
	}
}


$configuration = new Mk\Configuration(array("type" => "ini"));
Mk\Registry::set("configuration", $configuration-> initialize());
$database = new Mk\Database();
Mk\Registry::set("database", $database->initialize());
$cache = new Mk\Cache();
Mk\Registry::set("cache", $cache->initialize());
$session = new Mk\Session();
Mk\Registry::set("session", $session->initialize());

//$ppp=new User_Controller();
$router = new Mk\Router(array(
	"url" => isset($_GET["url"]) ? $_GET["url"] : "Home/Index",
	"extension" => isset($_GET["html"]) ? $_GET["html"] : "html"
	));
Mk\Registry::set("router", $router);
$router->dispatch();

unset($configuration);
unset($database);
unset($cache);
unset($session);	
unset($router);
}
catch(\Exception $e)
{

	ini_set('xdebug.var_display_max_depth', 8);
	//echo "<h3>Error ({$e->getCode()}): </h3><code>".str_replace("\n",'<br>',Mk\Debug::jdebug($e))."</code>";
	echo "<h3>Error ({$e->getCode()}): </h3>";
	echo "<table>";
	echo $e->xdebug_message;
	echo "</table>";
	if (DEBUG>2){
		\Mk\Debug::debug($e,true);
	}
	if (DEBUG>3){
		var_dump($e);
	}
	
}
?>