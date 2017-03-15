<?php
class Index2 extends Mk\Controller
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
	$this->init();
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


?>