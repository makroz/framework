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
		header("Location: index.php?url=home/debug");
		exit();
	}
	if ($_REQUEST['DATADEBUG']){
		if ($_SESSION['DATADEBUG']==1){
			$_SESSION['DATADEBUG']=0;
		}else{
			$_SESSION['DATADEBUG']=1;
		}
		header("Location: index.php?url=home/debug");
		exit();
	}
	$this->setRenderView(true);
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