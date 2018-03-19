<?php 
use Mk\Shared\CrudDb as CrudDb;
class Resp_controller extends CrudDb
{
	/**
	* @readwrite
	*/
	//protected $_secureKey='User';
		
	public function __construct($options = array())
	{
		parent::__construct($options);
		//$$this->_secure();
	}

	public function getAnexos($anexos=array(),$join=0){
		$anexos=parent::getAnexos($anexos);
		$anexos['listAction']="-1";
		$anexos['status']['defVal']='1';

		return $anexos;
	}

//* preserve code: *//

	public function actionLogin()
	{

		if (\Mk\Inputs::post("login"))
		{
			$email = \Mk\Inputs::post("doc");
			$password = \Mk\Inputs::post("pass");
			$view = $this-> getActionView();
			$error = false;
			if (empty($email))
			{
				$view-> set("doc_error", "debe Indicar Doc");
				$error = true;
			}
			if (empty($password))
			{
				$view-> set("pass_error", "Debe indicar Password");
				$error = true;
			}

			if (!$error)
			{
				$session = \Mk\Registry::get("session");
				$user = new $this->_modelName();
				$user = $user->first(array(
					"doc = ?" => $email,
					"pass = ?" => $password,
					"status = ?" => 1
					));

				//echo '<hr>Modelo '.$this->_modelName.' User:';print_r($user);
				if (!empty($user))
				{
					//unset($user->pass);
					$id=$user->getPrimaryColumn(2);
					$this-> _setLoged($id,$user);
					$secureKey=$this->getKey();
					header("Location: index.php?".$session-> get('Secure_page_'.$secureKey,''));
					exit();
				}
				else
				{
					$this-> _setLoged('',false);
					$view-> set("password_error", "Email address and/or password are incorrect");
				}
			}
		}
	}


//* :preserve code *//
}
//version MK.CRUD 1.0 
?>