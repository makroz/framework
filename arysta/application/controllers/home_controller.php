<?php
class Home_controller extends Mk\Controller
{

	public function __construct($options = array())
	{
		parent::__construct($options);
/*		$this->_secureKey='resp';
		$this->_secure();
*/
		$database = \Mk\Registry::get("database");
		$database-> connect();

		\Mk\Events::add("mk.controller.destruct.after", function($name) {
			$database = \Mk\Registry::get("database");
			$database->disconnect();
		});
	}

public function actionIndex()
{

}

public function actionPage()
{
	$texto='';
	$prod=array();
	$id=$_REQUEST['id'];
	$prodalm=array();
	$database = \Mk\Registry::get("database");
	$result=$database->query()->all("select contenido from submenus where pk=$id");
	foreach ($result as $key => $ing) {
		$texto.=$ing['contenido'];
	}
	$view = $this-> getActionView();
	$view-> set("contenido", $texto);
	//$this->setRenderView(false);
	//$this->changeViewAction('index.html');
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


}

?>
