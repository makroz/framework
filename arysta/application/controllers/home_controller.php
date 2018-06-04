<?php
class Home_controller extends Mk\Controller
{

	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->_secureKey='resp';
		$this->_secure();
		parent::__construct($options);

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

public function actionRecalcular()
{
	$prod=array();
	$prodalm=array();
	$database = \Mk\Registry::get("database");
	$result=$database->query()->all("select ingalm.fk_almacenes,ingalm.fk_almacenes_2,ingalm.fk_prod, unidades.relbase, uni2.relbase as relbase2, ingalm.cant, ingalm.fk_unidades from ingalm left join prod on (prod.pk=ingalm.fk_prod) left join unidades on (unidades.pk=ingalm.fk_unidades) left join unidades as uni2 on (uni2.pk=prod.fk_unidades) where ingalm.status='1'");
	foreach ($result as $key => $ing) {
		$cant=(($ing['cant']*$ing['relbase'])/$ing['relbase2']);
		$prod[$ing['fk_prod']]+=$cant;
		$prodalm[$ing['fk_almacenes']][$ing['fk_prod']]+=$cant;

	}

	$result=$database->query()->all("select egralm.fk_almacenes,egralm.fk_almacenes_2,egralm.fk_prod, unidades.relbase, uni2.relbase as relbase2, egralm.cant, egralm.fk_unidades from egralm left join prod on (prod.pk=egralm.fk_prod) left join unidades on (unidades.pk=egralm.fk_unidades) left join unidades as uni2 on (uni2.pk=prod.fk_unidades) where egralm.status='1'");
	foreach ($result as $key => $egr) {
		$cant=(($egr['cant']*$egr['relbase'])/$egr['relbase2']);
		$prod[$egr['fk_prod']]-=$cant;
		$prodalm[$egr['fk_almacenes']][$egr['fk_prod']]-=$cant;
	}

	foreach ($prod as $key => $value) {
		$database->execute("update prod set cant={$value} where pk={$key}");
	}

	foreach ($prodalm as $alm => $prod) {
		foreach ($prod as $key => $value) {
			$database->execute("update prodalm set cant={$value} where (fk_prod={$key})and(fk_almacenes={$alm})");
		}
	}

	//\Mk\Debug::debug($prodalm);
	$this->changeViewAction('index.html');
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