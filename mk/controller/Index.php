<?php
class Index extends Mk\Controller
{
	/**
	* @once
	* @protected
	*/
	public function init()
	{
		echo "init";
	}
	/**
	* @protected
	*/
	public function authenticate()
	{
		echo "authenticate";
	}
	/**
	* @before init, authenticate, init
	* @after notify
	*/
	public function home()
	{
		echo "hello world!";
	}
	/**
	* @protected
	*/
	public function notify()
	{
		echo "notify";
	}
}

$router = new Mk\Router();
$router->addRoute(
	new Mk\Router\Route\Simple(array(
		"pattern" => ":name/profile",
		"controller" => "home",
		"action" => "index"
		))
	);
$router->url = "chris/profile";
$router->dispatch();

?>