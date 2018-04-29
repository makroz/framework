<?php 
use Mk\Shared\CrudDb as CrudDb;
class Almacenes_controller extends CrudDb
{
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this->_secureKey='resp';
		$this->_secure();
	}

	public function getAnexos($anexos=array(),$join=0){
		$anexos=parent::getAnexos($anexos);
		$anexos['listAction']="-1";
		$anexos['tipo']['options']['P']='Principal';
		$anexos['tipo']['options']['S']='Secundario';
		$anexos['tipo']['options']['T']='Temporal';
		$anexos['estado']['defVal']='1';
		$anexos['estado']['options']['A']='En Apertura';
		$anexos['estado']['options']['F']='En Funcionamiento';
		$anexos['estado']['options']['I']='Inventario en Curso';
		$anexos['fk_resp']['join']['table']='resp';
		$anexos['fk_resp']['join']['campo']='nombre';
		$anexos['fk_resp']['join']['alias']='j_resp';
		$anexos['lapso']['options']['1']='Diario';
		$anexos['lapso']['options']['2']='Semanal';
		$anexos['lapso']['options']['3']='Quincenal';
		$anexos['lapso']['options']['4']='Mensual';
		$anexos['lapso']['options']['5']='Bimestral';
		$anexos['lapso']['options']['6']='Trimestral';
		$anexos['lapso']['options']['7']='Semestral';
		$anexos['lapso']['options']['8']='Anual';
		$anexos['t_ubicaciones']['defVal']='{\"R\":{\"t\":\"Recepcion\"},\"A\":{\"t\":\"Almacen\"},\"C\":{\"t\":\"Cuarentena\"},\"S\":{\"t\":\"Salida\"}}';
		$anexos['status']['defVal']='1';
		if ($join!=0){
			$anexos['fk_resp']['options']=$this->actionGetListFor('fk_resp',$anexos);
		}

		return $anexos;
	}

	
	

	
	
	
//* preserve code: *//


//* :preserve code *//

}
//version MK.CRUD 1.0 
?>