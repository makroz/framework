<?php
error_reporting( E_ALL ^ E_NOTICE);
define("DEBUG", 4);
define("APP_PATH", dirname(__FILE__));
define("CORE_PATH", dirname(__FILE__).'/..');
ini_set( 'date.timezone', 'America/La_Paz' );
//echo "2";

//echo CORE_PATH."/mk/core.php";
include(CORE_PATH."/mk/core.php");
//echo "b";
Mk\Core::initialize();
//echo "c";
\Mk\Debug::initTime($_GET["url"]);
//echo "d";
$path = APP_PATH . "/application/plugins";
//echo "3";
$iterator = new DirectoryIterator($path);
foreach ($iterator as $item)
{
	if (!$item->isDot() && $item->isDir())
	{
		include($path . "/" . $item->getFilename() . "/initialize.php");
	}
}
//echo "4";
$configuration = new \Mk\Configuration(array("type" => "ini"));
//echo "5";

Mk\Registry::set("configuration", $configuration-> initialize());
$database = new Mk\Database();
Mk\Registry::set("database", $database->initialize());
$cache = new Mk\Cache();
Mk\Registry::set("cache", $cache->initialize());
$session = new Mk\Session();
//echo "5";
Mk\Registry::set("session", $session->initialize());
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
\MK\Debug::endTime($_GET["url"]);
?>