<?php 
use Mk\Shared\CrudDb as CrudDb;
class //<<[CLASS]>>// extends CrudDb
{
	public function __construct($options = array())
	{
		parent::__construct($options);
		//<<[SECURE]>>//
	}

	public function getAnexos($anexos=array(),$join=0){
		$anexos=parent::getAnexos($anexos);
		//<<[ANEXOS]>>//
		return $anexos;
	}
//* preserve code: *//
//<<[PRESERVECODE]>>//
//* :preserve code *//

}
//version MK.CRUD 1.0 
?>