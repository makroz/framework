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

public function actionDebug()
{
	if ($_REQUEST['DELDEBUG']){
		$_SESSION['DEBUGMSG']='';
	}
	$this->setRenderView(true);
	//echo $this->getfilenameAction().'<br>';
	//echo $this->getfilenameLayout();

/*	echo "proibando";
	echo "<pre>";
	echo $_SESION['DEBUGMSG'];
	echo "<pre>";
*/	

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