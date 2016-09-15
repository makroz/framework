<?php 
namespace Mk\Crud
{
	use Mk\Inputs as Inputs;
	use Mk\Router as Router;
	use Mk\Registry as Registry;
	use Mk\Shared\ControllerDb as ControllerDb;
	use Mk\Tools\Form as Form;


	class Crud extends ControllerDb
	{
		
		/**
		* @readwrite
		*/
		protected $_database;

		/**
		* @readwrite
		*/
		protected $_table;

		


		public function __construct($options = array())
		{
			//$options['willRenderLayoutView']=false;
			$options['defaultModules']=APP_PATH;

			parent::__construct($options);
			$this->_database = Registry::get("database");
			//$this->setWillRenderActionView(false);
			//$this->setWillRenderLayoutView(false);
			//$this->setDefaultModules(APP_PATH.DIRECTORY_SEPARATOR.'mk');

			
		}

		public function actionTable()
		{


$lfunc['st']='TextoSeguro()';
$lfunc['bdf']='Decimal()';
$lfunc['datetime']='FechaHora()';
$lfunc['date']='Fecha()';
$lfunc['time']='Hora()';
$lfunc['custom']='custom()';
$lfunc['timesystem']='FechaHoraServer()';
$lfunc['datesystem']='FechaServer()';
$lfunc['timesystem']='HoraServer()';
$lfunc['check']='Check()';



$luso['A']='Ambos Grabar y Actualizar';
$luso['U']='Solo Actualizar';
$luso['I']='Solo Grabar';

$lusof['alfa']='Alfanumerico';
$lusof['area']='TextArea';
$lusof['int']='Numerico';
$lusof['float']='Decimal';
$lusof['select']='Lista';
$lusof['check']='Check';
$lusof['radio']='Radio';
$lusof['date']='Fecha';
$lusof['time']='Hora';
$lusof['datetime']='Fecha y Hora';
$lusof['pass']='Password';
$lusof['selectdb']='DB Lista';
$lusof['buscardb']='DB Buscar';
$lusof['multiple']='Lista Multiple';
$lusof['oculto']='Oculto';

$lsearch['Y']='Si';
$lsearch['N']='No';

/*$lerr['A']='Ambos';
$lerr['E']='Error';
$lerr['H']='Hint';
*/

$ltipolista['defecto']='Defecto';
$ltipolista['status']='Status';
$ltipolista['join']='Join';


$lclase['normal']='Normal';
$lclase['obligatorio']='Obligatorio';

$lver['X']='Normal';
$lver['1']='Solo Ver';


			$view = $this-> getActionView();
			$this->addViewData('database',$this->database->getSchema());
			$table=Inputs::get('table');
			$this->addViewData('tableName',$table);
			$table=$this->database->getFields($table);



			$pedir=array();
			
			$pedir['label']['text']='Etiqueta en Listas';
			$pedir['label']['type']='text';

			$pedir['var']['text']='Nombre de Variable';
			$pedir['var']['type']='text';
			
			$pedir['funcion']['text']='Funcion al Grabar/cargar';
			$pedir['funcion']['type']='sel';
			$pedir['funcion']['opt']=Form::getListaSel($lfunc,'Por Defecto');

			$pedir['fcustom']['text']='Funcion/valor';
			$pedir['fcustom']['type']='text';
			
			$pedir['dec']['text']='Decimales';
			$pedir['dec']['type']='range';
			$pedir['dec']['min']='0';
			$pedir['dec']['max']='8';

			$pedir['uso']['text']='Procesar al Grabar/Actualizar';
			$pedir['uso']['type']='sel';
			$pedir['uso']['opt']=Form::getListaSel($luso,'Ninguno');

			$pedir['usof']['text']='Tipo de input en el formulario';
			$pedir['usof']['type']='sel';
			$pedir['usof']['opt']=Form::getListaSel($lusof,'No usar');

			$pedir['search']['text']='Se usara en Busquedas?';
			$pedir['search']['type']='check';
			$pedir['search']['off']='No';
			$pedir['search']['on']='Si';
			$pedir['search']['onval']='1';
			$pedir['search']['offval']='0';



			


			foreach ($table as $key => $field) {
				$pedir['label']['val'][$key]=ucfirst($key);
				$pedir['var']['val'][$key]='_'.lcfirst(ucwords($key));
				$pedir['funcion']['val'][$key]='-1';
				$pedir['dec']['val'][$key]='0';
				$pedir['uso']['val'][$key]='A';

				// Valores por defecto segun tipo de datos de la BD
				if (in_array($field['type'], array('text','varchar','char','mediumtext','largetext'),true)){
					$pedir['funcion']['val'][$key]='st';
					$pedir['usof']['val'][$key]='alfa';

					if (in_array($field['type'], array('mediumtext','largetext'),true)){
						$pedir['usof']['val'][$key]='area';
					}
				}

				if (in_array($field['type'], array('decimal','float','double'),true)){ 
					$pedir['funcion']['val'][$key]='bdf';
					$pedir['usof']['val'][$key]='float';
					if ($field['args'][1]>0)
					{
						$pedir['dec']['val'][$key]=$field['args'][1];
						if ($field['args'][1]>$pedir['dec']['max'])
						{
							$pedir['dec']['max']=$field['args'][1];				
						}
					}
				}

				if (in_array($field['type'], array('int','tinyint','smallint','bigint','mediumint'),true)){ 
					//$pedir['funcion']['val'][$key]='bdf';
					$pedir['usof']['val'][$key]='int';
				}

				if (in_array($field['type'], array('datetime','date','time','timestamp'),true)){ 
					//$pedir['funcion']['val'][$key]='bdf';
					$pedir['usof']['val'][$key]=$field['type'];
					if ($field['type']=='timestamp'){
						$pedir['usof']['val'][$key]='date';
					}
				}
				/// Valores por defecto segun tipo de datos de la BD



				
			}

			$view->set('_table',$table);
			$view->set('_pedir',$pedir);

			
		}

		public function actionInit()
		{




			$view = $this-> getActionView();
			$this->addViewData('database',$this->database->getSchema());
			//echo "Base de datos:".$this->database->getSchema()."<hr>";
			$result=$this->database->execute("SHOW TABLES FROM ".$this->database->getSchema());
			$tables=Array();
			while ($row =$result->fetch_array()) {
				//echo "Tabla:".$row[0]."</br>";
				//echo "<pre>";print_r($this->database->getFields($row[0]));"</pre>";
				$tables[$row[0]]=$this->database->getFields($row[0]);
				//$tables[$row[0]]=$this->database->getTableInformationOf($row[0]);
				
				$view->set('tables',$tables);

			}
			
		}


	}
}
?>