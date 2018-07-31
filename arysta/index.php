<?php
error_reporting( E_ALL ^ E_NOTICE);
define("DEBUG", 4);
define("APP_PATH", dirname(__FILE__));
define("CORE_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR.'..');
ini_set( 'date.timezone', 'America/La_Paz' );
//include(CORE_PATH."/mk/exception.php");
include(CORE_PATH."/mk/core.php");
Mk\Core::initialize();
Mk\Debug::initTime($_GET["url"]);
//session_start();
$path = APP_PATH . "/application/plugins";
$iterator = new DirectoryIterator($path);
foreach ($iterator as $item)
{
	if (!$item->isDot() && $item->isDir())
	{
		include($path . "/" . $item->getFilename() . "/initialize.php");
	}
}

$configuration = new \Mk\Configuration(array("type" => "ini"));
Mk\Registry::set("configuration", $configuration-> initialize());
$database = new Mk\Database();
Mk\Registry::set("database", $database->initialize());
$cache = new Mk\Cache();
Mk\Registry::set("cache", $cache->initialize());
$session = new Mk\Session();
//Mk\Debug::debug_to_console("Probando 1",20,1);die();
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
