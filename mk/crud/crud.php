<?php 
namespace Mk\Crud
{
	use Mk\Inputs as Inputs;
	use Mk\Router as Router;
	use Mk\Registry as Registry;
	use Mk\Shared\ControllerDb as ControllerDb;
	use Mk\Tools\Form as Form;
	use Mk\Tools\String as String;


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
			if (Inputs::getIsAjaxRequest()){
				$this->setWillRenderActionView(false);
				$this->setWillRenderLayoutView(false);
			}
			//$this->setWillRenderActionView(false);
			//$this->setWillRenderLayoutView(false);
			//$this->setDefaultModules(APP_PATH.DIRECTORY_SEPARATOR.'mk'); 

			
		}

		public function actionTable()
		{

			$session = Registry::get("session");
			$tablas=$session->get('tables');


			$view = $this-> getActionView();
			$this->addViewData('database',$this->database->getSchema());

			$table=Inputs::get('table',$table=$session->get('table',''));
			if ($table==''){
				$view->setFile($this->getFilenameLayout('error.html'));
				$view->set('error',"No se especidico un Tabla");
				return false;
			}else{
				$session->set('table',$table);		
			}
			

			$this->addViewData('tableName',$table);
			$table=$this->database->getFields($table);

			$lfunc['st']='TextoSeguro()';
			$lfunc['bdf']='Decimal()';
			$lfunc['datetime']='FechaHora()';
			$lfunc['date']='Fecha()';
			$lfunc['time']='Hora()';
			$lfunc['custom']='custom()';
			$lfunc['datetimesystem']='FechaHoraServer()';
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
			$lusof['selec']='Lista';
			$lusof['check']='Check';
			$lusof['radio']='Radio';
			$lusof['date']='Fecha';
			$lusof['time']='Hora';
			$lusof['datetime']='Fecha y Hora';
			$lusof['pass']='Password';
			$lusof['selecdb']='DB Lista';
			$lusof['buscardb']='DB Buscar';
			$lusof['multiple']='Lista Multiple';
			$lusof['oculto']='Oculto';

			$ltipolista['list']=array('text'=>'Mostrar','tamsel'=>'s8');
			$ltipolista['check']='Mostrar valor Check';
			$ltipolista['status']='Mostrar como Status';
			$ltipolista['lista']='Mostrar como Lista';
			$ltipolista['join']=array('text'=>'Mostrar de Otra Tabla','tamsel'=>'s8');
			$ltipolista['get']='Obtener pero no Mostrar';
			$ltipolista['-1']='No usar';


			$luso['A']='Ambos Grabar y Actualizar';
			$luso['M']='Solo Actualizar';
			$luso['G']='Solo Grabar';

			$lalign['D']='Derecha';
			$lalign['I']='Izquierda';
			$lalign['C']='Centrado';


			$pedir=array();

			$pedir['label']['text']='Etiqueta en Listas';
			$pedir['label']['type']='text';

			$pedir['var']['text']='Nombre de Variable';
			$pedir['var']['type']='text';

			

			$pedir['uso']['text']='Procesar al Grabar/Actualizar';
			$pedir['uso']['type']='sel';
			$pedir['uso']['opt']=Form::getListaSel($luso,'Ninguno');

			$pedir['usof']['text']='Tipo de input en el formulario';
			$pedir['usof']['type']='sel';
			$pedir['usof']['opt']=Form::getListaSel($lusof,'No usar');
			$pedir['usof']['tam']='s12';

			$pedir['tam']['text']='Tamano';
			$pedir['tam']['type']='text';
			$pedir['tam']['tam']='s2';


			$pedir['funcion']['text']='Funcion al Grabar/cargar';
			$pedir['funcion']['type']='sel';
			$pedir['funcion']['opt']=Form::getListaSel($lfunc,'Por Defecto');

			$pedir['fcustom']['text']='Funcion/valor';
			$pedir['fcustom']['type']='text';
			$pedir['fcustom']['tam']='s2';

			$pedir['dec']['text']='Decimales';
			$pedir['dec']['type']='range';
			$pedir['dec']['min']='0';
			$pedir['dec']['max']='8';
			$pedir['dec']['tam']='s2';

			$pedir['checkvalor']['text']='Sel/No Sel';
			$pedir['checkvalor']['type']='text';
			$pedir['checkvalor']['tam']='s2';

			$pedir['tipolista']['text']='Se usara en Listado?';
			$pedir['tipolista']['type']='sel';
			$pedir['tipolista']['opt']=Form::getListaSel($ltipolista,'');

			$pedir['tamlista']['text']='Ancho Columna';
			$pedir['tamlista']['type']='text';
			$pedir['tamlista']['tam']='s3';	

			$pedir['checklista']['text']='Ver Sel/No Sel';
			$pedir['checklista']['type']='text';
			$pedir['checklista']['tam']='s3';

			$pedir['listalista']['text']='Elementos';
			$pedir['listalista']['type']='text';
			$pedir['listalista']['icon']='view_list';
			$pedir['listalista']['icon-type']='postfix';
			$pedir['listalista']['disabled']='disabled';
			$pedir['listalista']['tam']='s3';

			$pedir['campojoin']['text']='Tabla y Campo';
			$pedir['campojoin']['type']='text';
			$pedir['campojoin']['icon']='search';
			$pedir['campojoin']['icon-type']='postfix';
			$pedir['campojoin']['disabled']='disabled';
			$pedir['campojoin']['tam']='s3';


			$pedir['f1']['type']='raw';
			$pedir['f1']['text']='<fieldset>';

			$pedir['search']['text']='Se usara en Busquedas?';
			$pedir['search']['type']='check';
			$pedir['search']['onval']='1';
			$pedir['search']['offval']='0';
			$pedir['search']['tam']='s6 m4';

			$pedir['required']['text']='Es Obligatorio?';
			$pedir['required']['type']='check';
			$pedir['required']['onval']='1';
			$pedir['required']['offval']='0';
			$pedir['required']['tam']='s6 m4';

			
			$pedir['ver']['text']='Solo Lectura?';
			$pedir['ver']['type']='check';
			$pedir['ver']['onval']='1';
			$pedir['ver']['offval']='0';
			$pedir['ver']['tam']='s6 m4';
			
			$pedir['f2']['type']='raw';
			$pedir['f2']['text']='</fieldset>';



			foreach ($table as $key => $field) {
				$pedir['label']['val'][$key]=ucfirst($key);
				$pedir['var']['val'][$key]='_'.lcfirst(ucwords($key));
				$pedir['funcion']['val'][$key]='-1';
				$pedir['dec']['val'][$key]='0';
				$pedir['uso']['val'][$key]='A';
				$pedir['tam']['val'][$key]='100%';
				$pedir['tamlista']['val'][$key]='';
				$pedir['search']['val'][$key]='1';


				
				// Valores por defecto segun tipo de datos de la BD
				if (in_array($field['type'], array('text','varchar','char','mediumtext','largetext'),true)){
					$pedir['funcion']['val'][$key]='st';
					$pedir['usof']['val'][$key]='alfa';
					$pedir['tipolista']['val'][$key]='list';
					
					

					if ($field['args'][0]>0){
						$pedir['tam']['val'][$key]=($field['args'][0]*5)+20;
						if ($pedir['tam']['val'][$key]>300){$pedir['tam']['val'][$key]=300;}
					}

					//$pedir['tamlista']['val'][$key]=$pedir['tam']['val'][$key];

					if (in_array($field['type'], array('mediumtext','largetext'),true)){
						$pedir['usof']['val'][$key]='area';
						$pedir['tamlista']['val'][$key]='0';
					}


					if ($field['args'][0]==1){
						$pedir['usof']['val'][$key]='check';
						$pedir['tamlista']['val'][$key]='35';
						$pedir['funcion']['val'][$key]='check';	
						$pedir['checkvalor']['val'][$key]='1/0';
						$pedir['tipolista']['val'][$key]='check';
						
					}

					if (($field['args'][0]==8)and(String::stripos_array($campos,array('date','fecha','fec'),true)!==false)){
						$pedir['usof']['val'][$key]='date';
						$pedir['tamlista']['val'][$key]='90';
						$pedir['funcion']['val'][$key]='date';

					}

					if (($field['args'][0]==12)and(String::stripos_array($campos,array('date','fecha','fec'),true)!==false)){
						$pedir['usof']['val'][$key]='datetime';
						$pedir['tamlista']['val'][$key]='120';
						$pedir['funcion']['val'][$key]='datetime';	
					}

					if (($field['args'][0]==4)and(String::stripos_array($campos,array('time','hora'),true)!==false)){
						$pedir['usof']['val'][$key]='time';
						$pedir['tamlista']['val'][$key]='50';
						$pedir['funcion']['val'][$key]='time';	
					}

					if (stripos($campos,'fecha')!==false){
						if ($field['args'][0]==12){
							$pedir['usof']['val'][$key]='datetime';
							$pedir['tamlista']['val'][$key]='120';
							$pedir['funcion']['val'][$key]='datetimeserver';	
						}
						if ($field['args'][0]==8){
							$pedir['usof']['val'][$key]='date';
							$pedir['tamlista']['val'][$key]='90';
							$pedir['funcion']['val'][$key]='dateserver';	
						}
						if ($field['args'][0]==12){
							$pedir['usof']['val'][$key]='time';
							$pedir['tamlista']['val'][$key]='50';
							$pedir['funcion']['val'][$key]='timeserver';	
						}

					}					


				}

				if (in_array($field['type'], array('decimal','float','double'),true)){ 
					$pedir['funcion']['val'][$key]='bdf';
					$pedir['usof']['val'][$key]='float';
					$pedir['tamlista']['val'][$key]='80';

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
					$pedir['tamlista']['val'][$key]='60';
					$pedir['usof']['val'][$key]='int';
				}

				if (in_array($field['type'], array('datetime','date','time','timestamp'),true)){ 
					$pedir['tamlista']['val'][$key]='90';
					$pedir['usof']['val'][$key]=$field['type'];
					if ($field['type']=='timestamp'){
						$pedir['usof']['val'][$key]='date';
					}
					if ($field['type']=='datetime'){
						$pedir['tamlista']['val'][$key]='120';
					}
				}
				/// Valores por defecto segun tipo de datos de la BD

				// Valores por defecto segun Nombre de Campo
				$Name=strtolower($key);

				if (in_array($Name, array('pass','password','contrasena'),true)){ 
					$func='cd';$usof='pass';$tamlista='';$tam='100';$clase='obligatorio';$err='X';$search='X';$lista='-1';$listan--;
					$pedir['funcion']['val'][$key]='st';
					$pedir['usof']['val'][$key]='pass';
					$pedir['search']['val'][$key]='0';
					$pedir['tipolista']['val'][$key]='-1';



				}

				$pos=stripos($Name, 'fk_');
				if ($pos!==false){ 
					$tablajoin=substr($name,$pos+3);
					$pedir['tipolista']['val'][$key]='join';
					$tablajoin=explode('_', $tablajoin.'_-1');
					if ($tablajoin[1]=='-1'){
						$pos=stripos($tablas,$tablajoin[0]);
						if ($pos!==false){
							$tablajoin[0]=substr($tablas, $pos,strlen($tablajoin));
							$campos=$this->database->getColsOf($tablajoin[0]);
							$campos=implode(',', $campos);
							$pos=String::stripos_array($campos,array('nom','nombre','name','descrip','descripcion','description'),true);
							if ($pos !== FALSE) {
								$tablajoin[1]=substr($campos, $pos[0],strlen($pos[1]));
							}
						}
					}

					$pedir['campojoin']['val'][$key]=$tablajoin[0].'.'.$tablajoin[1];
					$pedir['tamlista']['val'][$key]='150';
					$pedir['usof']['val'][$key]='selecdb';
					$pedir['funcion']['val'][$key]='-1';

				}

				if (($Name=='created')||($Name=='modified')){
					$pedir['tipolista']['val'][$key]='-1';
					$pedir['usof']['val'][$key]='-1';

				}				
				

				if (($Name=='status')&&($field['args'][0]==1)){
					$pedir['tipolista']['val'][$key]='status';
					$pedir['usof']['val'][$key]='-1';
					$pedir['uso']['val'][$key]='G';
					$pedir['funcion']['val'][$key]='custom';
					$pedir['fcustom']['val'][$key]='1';
					$pedir['tamlista']['val'][$key]='45';
					$pedir['search']['val'][$key]='0';
					$pedir['label']['val'][$key]='St';

				}				

				/// Valores por defecto segun Nombre de Campo


				if ($field['key']=='PRI'){
					$pedir['tipolista']['val'][$key]='-1';
					$pedir['funcion']['val'][$key]='st';
					$pedir['usof']['val'][$key]='oculto';
					$pedir['uso']['val'][$key]='-1';
					//$pedir['ver']['val'][$key]='1';
					//$var='cod';
					if ($Name=='pk'){
						$pedir['tipolista']['val'][$key]='list';
						$pedir['tamlista']['val'][$key]='60';
						$pedir['label']['val'][$key]='Id';

					}
				}


			}

			$view->set('_tablas',$tablas);
			$view->set('_table',$table);
			$view->set('_pedir',$pedir);

		}

		public function actionGenerar(){

			$session = Registry::get("session");
			$tablas=$session->get('tables');

			$view = $this-> getActionView();
			$this->addViewData('database',$this->database->getSchema());

			$table=Inputs::get('table',$table=$session->get('table',''));
			if ($table==''){
				$view->setFile($this->getFilenameLayout('error.html'));
				$view->set('error',"No se especifico un Tabla");
				return false;
			}else{
				$session->set('table',$table);		
			}

			$this->addViewData('tableName',$table);
			$campos=Inputs::post('field');
			
			$fields=$this->database->getFields($table);
			//print_r($fields);
			$txtCampos='';
			foreach ($campos as $key => $field){
				
				$key=str_replace("'","",$key);
				//echo "<br> $key: <br>";print_r($field);echo "<hr>";
				$lines[]='/**';
				$lines[]='* @column';
				$lines[]='* @readwrite';
				if ($fields[$key]['key']=='PRI'){
				$lines[]='* @primary';
				}
				if ($fields[$key]['key']=='MUL'){
				$lines[]='* @index';
				}
				if ($fields[$key]['extra']=='auto_increment'){
				$lines[]='* @type autonumber';
				$campos[$key]['type']='autonumber';

				}else{

					$lines[]='* @type '.$fields[$key]['type'];
					$campos[$key]['type']=$fields[$key]['type'];					

					if ($fields[$key]['arg'][0]!=''){
				
						
						$len=$fields[$key]['arg'][0];
						if ($fields[$key]['arg'][1]!=''){
							$len.=' , '. $fields[$key]['arg'][1];
						}	

						$lines[]='* @length '.$len;

					}

				}

				$lines[]='* @label '.$field['label'];

				$validate='';
				if ($field['required']==1){
					$validate.= "required";
				}

				if ($validate!=''){
					$lines[]='* @validate '.$validate;	
				}
				
				
				
				$lines[]='*/';
				$lines[]='protected $_'.$key.';';
				$txtCampos.=implode($lines,"\n")."\n";
				//print_r($field);
				//echo "<hr>";
				unset($lines);
			}

			$txtCampos.="public \$_tSingular='".Inputs::post('singular')."';\n";
			$txtCampos.="public \$_tPlural='".Inputs::post('plural')."';\n";

			$view = $this-> getActionView();
			

 			$file=strtolower($this->getFilenameLayout('model.pl','plantillas'));
 			//echo "plantilla:".$file;
			$gestor = fopen($file,"r");
			$plantilla = fread($gestor,filesize($file));
			fclose($gestor);
			$plantilla = str_replace('//<<[CLASS]>>//',ucfirst($table),$plantilla);
			$plantilla = str_replace('//<<[CLASS_EXTENDS]>>//','Mk\Shared\Model',$plantilla);
			$plantilla = str_replace('//<<[CAMPOS]>>//',$txtCampos,$plantilla);

			$dir=MODULE_PATH.DIRECTORY_SEPARATOR.strtolower($table).DIRECTORY_SEPARATOR;
 			@mkdir ($dir.'modelos', 0700,true); 
 			@mkdir ($dir.'views', 0700,true); 


			$gestor = fopen($dir.'modelos'.DIRECTORY_SEPARATOR.strtolower($table).'.php',"w+");
			fwrite($gestor,$plantilla, strlen($plantilla));
			fclose($gestor);
			//$plantilla=str_replace("\n",'<br />',$plantilla);
			$view->set('mensaje',nl2br($plantilla));

			//generar vista listar

 			$file=strtolower($this->getFilenameLayout('view_listar.pl','plantillas'));
 			//echo "plantilla:".$file;
			$gestor = fopen($file,"r");
			$plantilla = fread($gestor,filesize($file));
			fclose($gestor);

			//$plantilla = str_replace('{% /append %}','[[ /append ]]',$plantilla);
			//$plantilla = str_replace('{% append js.inline %}','[[ append js.inline ]]',$plantilla);
			//$plantilla = str_replace('{% append js.inline %}','[[ append js.onready ]]',$plantilla);
			
			//print_r($plantilla);

			$componentes=\Mk\Tools\String::getEtiquetas($plantilla,'[[component:]]','[[:component]]','1');

			$codeUnique['jsinline']['index']=\Mk\Tools\String::getEtiquetas($plantilla,'{% append js.inline %}','{% /append %}',2,'index',' ');
			$codeUnique['jsonready']['index']=\Mk\Tools\String::getEtiquetas($plantilla,'{% append js.onready %}','{% /append %}',2,'index',' ');
			$codeUnique['jsfiles']['index']=\Mk\Tools\String::getEtiquetas($plantilla,'{% append js.files %}','{% /append %}',2,'index',' ');
			$codeUnique['styleinline']['index']=\Mk\Tools\String::getEtiquetas($plantilla,'{% append style.inline %}','{% /append %}',2,'index',' ');
			$codeUnique['stylefiles']['index']=\Mk\Tools\String::getEtiquetas($plantilla,'{% append style.files %}','{% /append %}',2,'index',' ');

			while(sizeof($componentes)>0){


			
			//print_r($componentes);

			foreach($componentes as $component => $parametros){
				//TODO: revisar s existe el componente
				$file=CORE_PATH.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.$component.DIRECTORY_SEPARATOR.$component.'.html';
				$gestor = fopen($file,"r");
				$html = fread($gestor,filesize($file));
				fclose($gestor);

				$codeUnique['jsinline'][$component]=\Mk\Tools\String::getEtiquetas($html,'{% append js.inline %}','{% /append %}',2,$component,' ');
				$codeUnique['jsonready'][$component]=\Mk\Tools\String::getEtiquetas($html,'{% append js.onready %}','{% /append %}',2,$component,' ');
				$codeUnique['jsfiles'][$component]=\Mk\Tools\String::getEtiquetas($html,'{% append js.files %}','{% /append %}',2,$component,' ');
				$codeUnique['styleinline'][$component]=\Mk\Tools\String::getEtiquetas($html,'{% append style.inline %}','{% /append %}',2,$component,' ');
				$codeUnique['stylefiles'][$component]=\Mk\Tools\String::getEtiquetas($html,'{% append style.files %}','{% /append %}',2,$component,' ');
				if (!$codeUnique['codeunique'][$component]){
					$codeUnique['codeunique'][$component]=\Mk\Tools\String::getEtiquetas($html,'[[unique:]]','[[:unique]]',2,$component,' ');
					if (trim($codeUnique['codeunique'][$component])!=''){
						
						$posi=strpos($plantilla,"[[component:]]$component");
						echo "<br>code unique".$codeUnique['codeunique'][$component]." POsicion: $posi";
						if ($posi!==false){
							$plantilla=substr($plantilla,0,$posi).$codeUnique['codeunique'][$component].substr($plantilla,$posi);	
						}
						
						$codeUnique['codeunique'][$component]='';
					}
				}


				
				if (@filesize(CORE_PATH.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.$component.DIRECTORY_SEPARATOR.$component.'.php')>0){
					$funcionphp='\Components\\'.ucfirst($component).'\\'.ucfirst($component);
					$funcionphp=new $funcionphp($campos);
				}else{
					$funcionphp=null;
				}
					


				$parametros=array_unique($parametros);
				echo "<br>Procesado el Componente: $component";
				$html1=$html;
				//print_r($parametros);
				foreach($parametros as $key => $param){
					$html=$html1;
					$tag=$component;
					if ($param!=''){
						$tag=$tag.'::'.$param;
						$paramvar=explode('&',$param.'&');
						foreach($paramvar as $key1 => $var1){
							if ($var1!=''){
								$var1=explode('=',$var1.'=');
								if ($var1[0]!=''){
									$html = str_replace('[[var:]]'.$var1[0].'[[:var]]',rtrim(implode(array_slice($var1,1),'='),'='),$html);
									$codeUnique['jsinline'][$component] = str_replace('[[var:]]'.$var1[0].'[[:var]]',rtrim(implode(array_slice($var1,1),'='),'='),$codeUnique['jsinline'][$component]);

								}
								//$html = str_replace('[[var:]]'.$var1[0].'[[:var]]',rtrim(implode(array_slice($var1,1),'='),'='),$html);
							}

							$html=$this->procesaPhpHtml($html,$funcionphp);
						}

					}else{
						$html=$this->procesaPhpHtml($html,$funcionphp);
					}

					echo "<br>---Rendenizado Componente: $tag";
					
					$plantilla = str_replace('[[component:]]'.$tag.'[[:component]]',$html,$plantilla);
				}
				if ($funcionphp){
					unset($funcionphp);
				}

			}
			$componentes=\Mk\Tools\String::getEtiquetas($plantilla,'[[component:]]','[[:component]]','1');
		}//while


			$plantilla = "\n".'{% append js.files %}'.implode($codeUnique['jsfiles']," ")."\n".'{% /append %}'."\n".$plantilla;
			$plantilla = "\n".'{% append js.inline %}'.implode($codeUnique['jsinline']," ")."\n".'{% /append %}'."\n".$plantilla;
			$plantilla = "\n".'{% append js.onready %}'.implode($codeUnique['jsonready']," ")."\n".'{% /append %}'."\n".$plantilla;
			$plantilla = "\n".'{% append style.inline %}'.implode($codeUnique['styleinline']," ")."\n".'{% /append %}'."\n".$plantilla;
			$plantilla = "\n".'{% append style.files %}'.implode($codeUnique['stylefiles']," ")."\n".'{% /append %}'."\n".$plantilla;


			$gestor = fopen($dir.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'listar.html',"w+");
			fwrite($gestor,$plantilla, strlen($plantilla));
			fclose($gestor);

		}

		private function procesaPhpHtml($html,$funcionphp){
			if ($funcionphp){
			$php=\Mk\Tools\String::getEtiquetas($html,'[[php:]]','[[:php]]','1');
			//print_r($php);
			//$php=array_unique($php);
			foreach($php as $key2 => $param2){
				$param=trim(implode(',',$param2),',');
				$texto=$funcionphp->$key2($param);
				echo "<br>EL php es: $texto";
				if ($param==''){
					$html = str_replace('[[php:]]'.$key2.'[[:php]]',$texto,$html);
				}else{
					$html = str_replace('[[php:]]'.$key2.'::'.$param.'[[:php]]',$texto,$html);

				}
				
			}
			}
			return $html;
		}

		private function renderComponente($idComponent,$plantilla,&$codeUnique,&$codeExist){
			//print_r($plantilla);
			$jsinline=\Mk\Tools\String::getEtiquetas($plantilla,'{% append js.inline %}','{% /append %}',2,$idComponent,' ');
			$codeUnique['jsinline'][$idComponent]=$jsinline[$idComponent];
			
			$componentes=\Mk\Tools\String::getEtiquetas($plantilla,'[[component:]]','[[:component]]','1');
			//print_r($componentes);

			foreach($componentes as $component => $parametros){
				//TODO: revisar s existe el componente
				$file=CORE_PATH.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.$component.DIRECTORY_SEPARATOR.$component.'.html';
				$gestor = fopen($file,"r");
				$html = fread($gestor,filesize($file));
				fclose($gestor);

				$jsinline=\Mk\Tools\String::getEtiquetas($html,'{% append js.inline %}','{% /append %}',2,$component,' ');
				$codeUnique['jsinline'][$component]=$jsinline[$component];
				
				$parametros=array_unique($parametros);
				//print_r($parametros);
				foreach($parametros as $key => $param){
					$tag=$component;
					if ($param!=''){
						$tag=$tag.'::'.$param;
					}
					echo "<br>Incluye Componente: $tag";
					$plantilla = str_replace('[[component:]]'.$tag.'[[:component]]',$html,$plantilla);
				}

			}

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
				$tabla[$row[0]]=$row[0];

				$view->set('tables',$tables);

			}
			$session = Registry::get("session");
			$session->set('tables',Form::getListaSel($tabla,'...'));


		}

		public function actionGetCampos()
		{
			$campos=array();
			$valor=Inputs::request('valor');
			if ($valor!=''){
				$campos=$this->database->getColsOf($valor);
			}
			echo Form::getListaSel($campos,'...');
		}


	}
}
?>