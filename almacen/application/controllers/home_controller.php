<?php
class Home_controller extends Mk\Controller
{
/**
* @once
* @protected
*/
public function init()
{
//echo "init";
}
/**
* @protected
*/
public function authenticate()
{
//echo "authenticate";
}
/**
* @before init, authenticate, init
* @after notify
*/
public function actionIndex()
{
	$this->init();
//echo "hello world!";
}
/**
* @protected
*/
public function notify()
{
//echo "notify";
}
}


?>