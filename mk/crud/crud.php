<?php
namespace Mk\Crud {
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
			$options['defaultModules'] = CORE_PATH;
			\Mk\Core::addPaths("\mk\crud\crud", 2);
			parent::__construct($options);
			$this->_database = Registry::get("database");
			if (\Mk\Tools\App::isAjax() == true) {
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
			$tablas  = $session->get('tables');
			$view    = $this->getActionView();
			$this->addViewData('database', $this->database->getSchema());
			$table = Inputs::get('table', $table = $session->get('table', ''));
			if ($table == '') {
				$view->setFile($this->getFilenameLayout('error.html'));
				$view->set('error', "No se especidico un Tabla");
				return false;
			} else {
				$session->set('table', $table);
			}
			$this->addViewData('tableName', $table);
			$table                            = $this->database->getFields($table);
			$lfunc['st']                      = 'TextoSeguro()';
			$lfunc['bdf']                     = 'Decimal()';
			$lfunc['datetime']                = 'FechaHora()';
			$lfunc['date']                    = 'Fecha()';
			$lfunc['time']                    = 'Hora()';
			$lfunc['custom']                  = 'custom()';
			$lfunc['datetimesystem']          = 'FechaHoraServer()';
			$lfunc['datesystem']              = 'FechaServer()';
			$lfunc['timesystem']              = 'HoraServer()';
			$lfunc['check']                   = 'Check()';
			$lusof['alfa']                    = 'Alfanumerico';
			$lusof['area']                    = 'TextArea';
			$lusof['int']                     = 'Numerico';
			$lusof['float']                   = 'Decimal';
			$lusof['selec']                   = 'Lista';
			$lusof['check']                   = 'Check';
			$lusof['radio']                   = 'Radio';
			$lusof['date']                    = 'Fecha';
			$lusof['time']                    = 'Hora';
			$lusof['datetime']                = 'Fecha y Hora';
			$lusof['pass']                    = 'Password';
			$lusof['selecdb']                 = 'DB Lista';
			$lusof['tree'] = 'Lista Tree';
			$lusof['buscardb']                = 'DB Buscar';
			$lusof['multiple']                = 'Lista Multiple';
			$lusof['oculto']                  = 'Oculto';
			$lvalid['mail']                   = 'eMail';
			$lvalid['numerico']               = 'solo Numeros';
			$lvalid['tel']                    = 'Telefonos';
			$ltipolista['show']               = array(
				'text' => 'Mostrar',
				'tamsel' => 's8'
			);
			$ltipolista['check']              = 'Mostrar valor Check';
			$ltipolista['status']             = 'Mostrar como Status';
			$ltipolista['lista']              = 'Mostrar como Lista';
			$ltipolista['join']               = array(
				'text' => 'Mostrar de Otra Tabla',
				'tamsel' => 's8'
			);
			$ltipolista['get']                = 'Obtener pero no Mostrar';
			$ltipolista['-1']                 = 'No usar';
			$luso['A']                        = 'Ambos Grabar y Actualizar';
			$luso['M']                        = 'Solo Actualizar';
			$luso['G']                        = 'Solo Grabar';
			$lalign['D']                      = 'Derecha';
			$lalign['I']                      = 'Izquierda';
			$lalign['C']                      = 'Centrado';
			$pedir                            = array();
			$pedir['label']['text']           = 'Etiqueta en Listas';
			$pedir['label']['type']           = 'text';
			$pedir['label']['tam']           = 's6';
			$pedir['labelf']['text']           = 'Etiqueta en Formulario Si es Diferente';
			$pedir['labelf']['type']           = 'text';
			$pedir['labelf']['tam']           = 's6';

/*			$pedir['var']['text']             = 'Nombre de Variable';
			$pedir['var']['type']             = 'text';
*/			$pedir['uso']['text']             = 'Procesar al Grabar/Actualizar';
			$pedir['uso']['type']             = 'sel';
			$pedir['uso']['opt']              = Form::getOptions($luso,'', 'Ninguno');
			$pedir['usof']['text']            = 'Tipo de input en el formulario';
			$pedir['usof']['type']            = 'sel';
			$pedir['usof']['opt']             = Form::getOptions($lusof, '','No usar');
			$pedir['usof']['tam']             = 's8';
			$pedir['tam']['text']             = 'Tamano';
			$pedir['tam']['type']             = 'text';
			$pedir['tam']['tam']              = 's2';
			$pedir['posf']['text']             = 'Pos. Form.';
			$pedir['posf']['type']             = 'text';
			$pedir['posf']['tam']              = 's2';

			$pedir['funcion']['text']         = 'Funcion al Grabar/cargar';
			$pedir['funcion']['type']         = 'sel';
			$pedir['funcion']['opt']          = Form::getOptions($lfunc, '','Por Defecto');
			$pedir['fcustom']['text']         = 'Funcion/valor';
			$pedir['fcustom']['type']         = 'text';
			$pedir['fcustom']['tam']          = 's2';
			$pedir['dec']['text']             = 'Decimales';
			$pedir['dec']['type']             = 'range';
			$pedir['dec']['min']              = '0';
			$pedir['dec']['max']              = '8';
			$pedir['dec']['tam']              = 's2';
			$pedir['checkvalor']['text']      = 'Sel/No Sel';
			$pedir['checkvalor']['type']      = 'text';
			$pedir['checkvalor']['tam']       = 's2';
			$pedir['tipolista']['text']       = 'Se usara en Listado?';
			$pedir['tipolista']['type']       = 'sel';
			$pedir['tipolista']['opt']        = Form::getOptions($ltipolista,'', '');
			$pedir['tamlista']['text']        = 'Ancho Columna';
			$pedir['tamlista']['type']        = 'text';
			$pedir['tamlista']['tam']         = 's3';
			$pedir['checklista']['text']      = 'Ver Sel/No Sel';
			$pedir['checklista']['type']      = 'text';
			$pedir['checklista']['tam']       = 's3';
			$pedir['listalista']['text']      = 'Elementos';
			$pedir['listalista']['type']      = 'text';
			$pedir['listalista']['icon']      = 'view_list';
			$pedir['listalista']['icon-type'] = 'postfix';
			$pedir['listalista']['disabled']  = 'disabled';
			$pedir['listalista']['tam']       = 's3';
			$pedir['campojoin']['text']       = 'Tabla y Campo';
			$pedir['campojoin']['type']       = 'text';
			$pedir['campojoin']['icon']       = 'search';
			$pedir['campojoin']['icon-type']  = 'postfix';
			$pedir['campojoin']['disabled']   = 'disabled';
			$pedir['campojoin']['tam']        = 's3';
			$pedir['f1']['type']              = 'raw';
			$pedir['f1']['text']              = '<fieldset>';
			$pedir['search']['text']          = 'Se usara en Busquedas?';
			$pedir['search']['type']          = 'check';
			$pedir['search']['onval']         = '1';
			$pedir['search']['offval']        = '0';
			$pedir['search']['tam']           = 's6 m3';
			$pedir['required']['text']        = 'Es Obligatorio?';
			$pedir['required']['type']        = 'check';
			$pedir['required']['onval']       = '1';
			$pedir['required']['offval']      = '0';
			$pedir['required']['tam']         = 's6 m3';
			$pedir['ver']['text']             = 'Solo Lectura?';
			$pedir['ver']['type']             = 'check';
			$pedir['ver']['onval']            = '1';
			$pedir['ver']['offval']           = '0';
			$pedir['ver']['tam']              = 's6 m3';
			$pedir['unico']['text']             = 'Valor Unico?';
			$pedir['unico']['type']             = 'check';
			$pedir['unico']['onval']            = '1';
			$pedir['unico']['offval']           = '0';
			$pedir['unico']['tam']              = 's6 m3';

			$pedir['f2']['type']              = 'raw';
			$pedir['f2']['text']              = '</fieldset>';

			$pedir['listaeventos']['text']      = 'Eventos';
			$pedir['listaeventos']['type']      = 'text';
			$pedir['listaeventos']['icon']      = 'view_list';
			$pedir['listaeventos']['icon-type'] = 'postfix';
			$pedir['listaeventos']['tam']       = 's4';
			$pedir['listaeventos']['disabled']  = 'disabled';

			$pedir['validar']['text']       = 'Validacion';
			$pedir['validar']['type']       = 'sel';
			$pedir['validar']['opt']        = Form::getOptions($lvalid,'', 'Ninguna');
			



			$posf=0;
			foreach ($table as $key => $field) {
				$pedir['label']['val'][$key]    = ucfirst($key);
				$pedir['labelf']['val'][$key]    = '';
				$pedir['var']['val'][$key]      = '_' . lcfirst(ucwords($key));
				$pedir['funcion']['val'][$key]  = '-1';
				$pedir['dec']['val'][$key]      = '0';
				$pedir['uso']['val'][$key]      = 'A';
				$pedir['tam']['val'][$key]      = 's12';
				$pedir['tamlista']['val'][$key] = '';
				$pedir['search']['val'][$key]   = '1';
				$pedir['posf']['val'][$key]   = $posf;
				$posf++;
				// Valores por defecto segun tipo de datos de la BD
				if (in_array($field['type'], array(
					'text',
					'varchar',
					'char',
					'tinytext',
					'mediumtext',
					'largetext'
				), true)) {
					$pedir['funcion']['val'][$key]   = 'st';
					$pedir['usof']['val'][$key]      = 'alfa';
					$pedir['tipolista']['val'][$key] = 'show';
					if ($field['args'][0] > 0) {
						$pedir['tamlista']['val'][$key] = ($field['args'][0] * 5) + 20;
						if ($pedir['tamlista']['val'][$key] > 200) {
							$pedir['tamlista']['val'][$key] = '';
						}
					}
					//$pedir['tamlista']['val'][$key]=$pedir['tam']['val'][$key];
					if (in_array($field['type'], array(
						'tinytext',
						'mediumtext',
						'largetext'
					), true)) {
						$pedir['usof']['val'][$key]     = 'area';
						$pedir['tamlista']['val'][$key] = '';
						$pedir['tipolista']['val'][$key] = '-1';
						$pedir['search']['val'][$key]   = '0';
					}
					if ($field['args'][0] == 1) {
						$pedir['usof']['val'][$key]       = 'check';
						$pedir['tamlista']['val'][$key]   = '35';
						$pedir['funcion']['val'][$key]    = 'check';
						$pedir['checkvalor']['val'][$key] = '1/0';
						$pedir['tipolista']['val'][$key]  = 'check';
					}
					if (($field['args'][0] == 8) and (String::stripos_array($campos, array(
						'date',
						'fecha',
						'fec'
					), true,',') !== false)) {
						$pedir['usof']['val'][$key]     = 'date';
						$pedir['tamlista']['val'][$key] = '90';
						$pedir['funcion']['val'][$key]  = 'date';
					}
					if (($field['args'][0] == 14) and (String::stripos_array($campos, array(
						'date',
						'fecha',
						'fec'
					), true,',') !== false)) {
						$pedir['usof']['val'][$key]     = 'datetime';
						$pedir['tamlista']['val'][$key] = '120';
						$pedir['funcion']['val'][$key]  = 'datetime';
					}
					if (($field['args'][0] == 6) and (String::stripos_array($campos, array(
						'time',
						'hora'
					), true,',') !== false)) {
						$pedir['usof']['val'][$key]     = 'time';
						$pedir['tamlista']['val'][$key] = '50';
						$pedir['funcion']['val'][$key]  = 'time';
					}
					if (stripos($campos, 'fecha') !== false) {
						if ($field['args'][0] == 14) {
							$pedir['usof']['val'][$key]     = 'datetime';
							$pedir['tamlista']['val'][$key] = '120';
							$pedir['funcion']['val'][$key]  = 'datetimeserver';
						}
						if ($field['args'][0] == 8) {
							$pedir['usof']['val'][$key]     = 'date';
							$pedir['tamlista']['val'][$key] = '90';
							$pedir['funcion']['val'][$key]  = 'dateserver';
						}
						if ($field['args'][0] == 6) {
							$pedir['usof']['val'][$key]     = 'time';
							$pedir['tamlista']['val'][$key] = '50';
							$pedir['funcion']['val'][$key]  = 'timeserver';
						}
					}
				}
				if (in_array($field['type'], array(
					'decimal',
					'float',
					'double'
				), true)) {
					$pedir['funcion']['val'][$key]  = 'bdf';
					$pedir['usof']['val'][$key]     = 'float';
					$pedir['validar']['val'][$key]     = 'numerico';
					$pedir['tamlista']['val'][$key] = '80';
					if ($field['args'][1] > 0) {
						$pedir['dec']['val'][$key] = $field['args'][1];
						if ($field['args'][1] > $pedir['dec']['max']) {
							$pedir['dec']['max'] = $field['args'][1];
						}
					}
				}
				if (in_array($field['type'], array(
					'int',
					'tinyint',
					'smallint',
					'bigint',
					'mediumint'
				), true)) {
					$pedir['tamlista']['val'][$key] = '60';
					$pedir['usof']['val'][$key]     = 'int';
					$pedir['validar']['val'][$key]     = 'numerico';
				}
				if (in_array($field['type'], array(
					'datetime',
					'date',
					'time',
					'timestamp'
				), true)) {
					$pedir['tamlista']['val'][$key] = '90';
					$pedir['usof']['val'][$key]     = $field['type'];
					if ($field['type'] == 'timestamp') {
						$pedir['usof']['val'][$key]    = 'date';
						$pedir['funcion']['val'][$key] = 'date';
					}
					if ($field['type'] == 'datetime') {
						$pedir['tamlista']['val'][$key] = '120';
						$pedir['funcion']['val'][$key]  = 'datetime';
					}
					if ($field['type'] == 'time') {
						$pedir['tamlista']['val'][$key] = '60';
						$pedir['funcion']['val'][$key]  = 'time';
					}
				}

				if ($field['null']=='NO'){
					$pedir['required']['val'][$key]   = '1';	
				}
				/// Valores por defecto segun tipo de datos de la BD
				// Valores por defecto segun Nombre de Campo
				$Name = strtolower($key);

				if (in_array($Name, array(
					'email',
					'mail',
					'correo'
				), true)) {
					$pedir['validar']['val'][$key]   = 'mail';
				}

				if (in_array($Name, array(
					'pass',
					'password',
					'contrasena'
				), true)) {
					$pedir['funcion']['val'][$key]   = 'st';
					$pedir['usof']['val'][$key]      = 'pass';
					$pedir['search']['val'][$key]    = '0';
					$pedir['tipolista']['val'][$key] = '-1';
				}
				$pos = stripos($Name, 'fk_');
				if ($pos !== false) {
					$tablajoin                       = substr($Name, $pos + 3);
					$pedir['tipolista']['val'][$key] = 'join';
					$tablajoin                       = explode('_', $tablajoin . '_-1');
					if ($tablajoin[1] == '-1') {
						$pos = stripos($tablas, $tablajoin[0]);
						if ($pos !== false) {
							$tablajoin[0] = substr($tablas, $pos, strlen($tablajoin[0]));
							$campos       = $this->database->getColsOf($tablajoin[0]);
							$campos       = implode(',', $campos);
							$pos          = String::stripos_array($campos, array(
								'nom',
								'nombre',
								'name',
								'descrip',
								'descripcion',
								'description'
							), true,',');
							if ($pos !== FALSE) {
								$tablajoin[1] = substr($campos, $pos[0], strlen($pos[1]));
							}
						}
					}
					$pedir['campojoin']['val'][$key] = $tablajoin[0] . '|' . $tablajoin[1]. '||';
					$pedir['tamlista']['val'][$key]  = '150';
					$pedir['usof']['val'][$key]      = 'selecdb';
					$pedir['funcion']['val'][$key]   = '-1';
				}
				$pos = stripos($Name, 't_');
				if ($pos !== false) {
					$pedir['usof']['val'][$key]      = 'tree';
				}
				$pos = stripos($Name, 'sk_');
				if ($pos !== false) {
					$pedir['tipolista']['val'][$key] = 'join';
					$campos       = $this->database->getColsOf($session->get('table', ''));
					$campos       = implode(',', $campos);
					$pos          = String::stripos_array($campos, array(
						'nom',
						'nombre',
						'name',
						'descrip',
						'descripcion',
						'description'
					), true,',');
					if ($pos !== FALSE) {
						$campos = substr($campos, $pos[0], strlen($pos[1]));
					}else{
						$campos='';
					}

					$pedir['campojoin']['val'][$key] =$session->get('table', '') . '|' . $campos. '|1|';
					$pedir['tamlista']['val'][$key]  = '150';
					$pedir['usof']['val'][$key]      = 'selecdb';
					$pedir['funcion']['val'][$key]   = '-1';
				}
				if ($Name == 'created') {
					$pedir['tipolista']['val'][$key] = '-1';
					$pedir['usof']['val'][$key]      = '-1';
					$pedir['uso']['val'][$key]       = 'G';
					$pedir['funcion']['val'][$key]   = 'datetimesystem';
					$pedir['required']['val'][$key]   = '0';
				}
				if ($Name == 'modified') {
					$pedir['tipolista']['val'][$key] = '-1';
					$pedir['usof']['val'][$key]      = '-1';
					$pedir['uso']['val'][$key]       = 'A';
					$pedir['funcion']['val'][$key]   = 'datetimesystem';
					$pedir['required']['val'][$key]   = '0';
				}
				if (($Name == 'status') && ($field['args'][0] == 1)) {
					$pedir['tipolista']['val'][$key] = 'status';
					$pedir['usof']['val'][$key]      = '-1';
					$pedir['uso']['val'][$key]       = 'G';
					$pedir['funcion']['val'][$key]   = 'custom';
					$pedir['fcustom']['val'][$key]   = '1';
					$pedir['tamlista']['val'][$key]  = '45';
					$pedir['search']['val'][$key]    = '0';
					$pedir['label']['val'][$key]     = 'St';
					$pedir['required']['val'][$key]   = '0';
				}
				/// Valores por defecto segun Nombre de Campo
				if ($field['key'] == 'PRI') {
					$pedir['tipolista']['val'][$key] = '-1';
					$pedir['funcion']['val'][$key]   = 'st';
					$pedir['usof']['val'][$key]      = 'oculto';
					$pedir['uso']['val'][$key]       = '-1';
					//$pedir['ver']['val'][$key]='1';
					//$var='cod';
					if ($Name == 'pk') {
						$pedir['tipolista']['val'][$key] = 'show';
						$pedir['tamlista']['val'][$key]  = '60';
						$pedir['label']['val'][$key]     = 'Id';
					}
				}
			}
			$view->set('_tablas', $tablas);
			$view->set('_table', $table);
			$view->set('_pedir', $pedir);
		}

		public function copiarDir($dir,$dirDest,$recursivo=true,$result=false){
			if (!file_exists($dir)){return false;}
			$iterator = new \DirectoryIterator($dir);
			foreach ($iterator as $item) {
				if (!$item->isDot() && $item->isFile()) {
					if ($item->getSize()>0){
						if (copy($item->getPathname(), $dirDest. DIRECTORY_SEPARATOR . $item->getFilename())) {
							if ($result){
								echo "<br>Se copia el archivo para el componente:" . $item->getFilename();
							}
						} else {
							if ($result){
								echo "<br>No se copiado el archivo correctamente" . $item->getFilename();
							}
						}
					}
				}
				if (!$item->isDot() && $item->isDir() && $recursivo===true) {
					@mkdir( $dirDest. DIRECTORY_SEPARATOR . $item->getFilename(), 0700, true);
					$this->copiarDir($item->getPathname(),$dirDest. DIRECTORY_SEPARATOR . $item->getFilename(),true,$result);
				}
			}
		}

		public function actionGetConfig(){
			$this->setRenderView(false);
			$session   = Registry::get("session");
			$table = Inputs::get('table', $session->get('table', ''));
			$fileconfig='';
			$dir = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR . 'configuration';
			if (file_exists($dir . DIRECTORY_SEPARATOR . 'config.crud')){
				$fileconfig=file_get_contents($dir . DIRECTORY_SEPARATOR . 'config.crud');
			}
			echo $fileconfig;
			return $fileconfig;

		}



		public function actionGenerar()
		{
			global $variables;
			$variables = array();
			$session   = Registry::get("session");
			$tablas    = $session->get('tables');
			$view      = $this->getActionView();
			$this->addViewData('database', $this->database->getSchema());
			$table = Inputs::get('table', $session->get('table', ''));
			if ($table == '') {
				$view->setFile($this->getFilenameLayout('error.html'));
				$view->set('error', "No se especifico un Tabla");
				return false;
			} else {
				$session->set('table', $table);
			}
			$this->addViewData('tableName', $table);
			$campos    = Inputs::post('field');
			$fields    = $this->database->getFields($table);
			$anexos    = array();
			$selecdb    = array();
			$txtCampos = '';
			$cargaAjaxForm=0;
			//$selectdb=0;
			//echo "<hr>campos:<hr>";print_r($campos);
			$view->set('campos',$campos);
			$view->set('variables',$variables);

			foreach ($campos as $key => $field) {
				$key     = str_replace("'", "", $key);
				//echo "<br> $key: <br>";print_r($field);echo "<hr>";
				$lines[] = '/**';
				$lines[] = '* @column';
				$lines[] = '* @readwrite';
				if ($fields[$key]['key'] == 'PRI') {
					$variables['_primary_']=$key;
					$lines[] = '* @primary';
				}
				if ($fields[$key]['key'] == 'MUL') {
					$lines[] = '* @index';
				}
				if ($fields[$key]['extra'] == 'auto_increment') {
					$lines[]              = '* @type autonumber';
					$campos[$key]['type'] = 'autonumber';
				} else {
					$lines[]              = '* @type ' . $fields[$key]['type'];
					$campos[$key]['type'] = $fields[$key]['type'];
					if ($fields[$key]['arg'][0] != '') {
						$len = $fields[$key]['arg'][0];
						if ($fields[$key]['arg'][1] != '') {
							$len .= ' , ' . $fields[$key]['arg'][1];
						}
						$lines[] = '* @length ' . $len;
					}
				}
				if ((trim($field['uso']) != '-1') && (trim($field['uso']) != '')) {
					$lines[] = '* @uso ' . $field['uso'];
					$lines[] = '* @funcion ' . $field['funcion'];
					/*
					if ($field['funcion']=='check'){
					$lines[]='* @checkvalor '.$field['checkvalor'];
					}*/
					if ($field['funcion'] == 'custom') {
						$lines[] = '* @fcustom ' . $field['fcustom'];
					}
				}
				$lines[]  = '* @label ' . $field['label'];
				if (($field['labelf'] != '')&&($field['labelf'] != $field['label'])) {
					$lines[]  = '* @labelf ' . $field['labelf'];
				}
				$validate = '';
				if ($field['required'] == 1) {
					$validate .= " required";
				}
				if (($field['usof'] == 'int') || ($field['usof'] == 'float')|| ($field['validar'] == 'numerico')) {
					if ($validate != '') {
						$validate .= ',';
					}
					$validate .= " numeric";
				}
				if ($field['validar'] == 'mail') {
					if ($validate != '') {
						$validate .= ',';
					}
					$validate .= " mail";
				}
				if ($validate != '') {
					$lines[] = '* @validate ' . $validate;
				}
				$campos[$key]['validate'] = $validate;
				$lines[]                  = '*/';
				$lines[]                  = 'protected $_' . $key . ';';
				if ($field['usof'] == 'check') {
					$aux = explode('/', $field['checkvalor'] . '/');
					if ($aux[0] == '') {
						$aux[0] = '1';
					}
					if ($aux[1] == '') {
						$aux[1] = '0';
					}
					$anexos[] = '$anexos' . "['{$key}']['dataon']='{$aux[0]}';";
					$labelon  = '';
					$labeloff = '';
					$aux      = explode('/', $field['checklista'] . '/');
					if ($aux[0] == '') {
						$aux[0] = 'Si';
					}
					if ($aux[1] == '') {
						$aux[1] = 'No';
					}
					$anexos[] = '$anexos' . "['{$key}']['labelon']='{$aux[0]}';";
					$anexos[] = '$anexos' . "['{$key}']['labeloff']='{$aux[1]}';";
				}
				if ($field['usof'] == 'selec') {
					echo "<hr>" . $field['listalista'] . '<hr>';
					$aux = explode('*', $field['listalista'] . '*');
					foreach ($aux as $key2 => $value2) {
						if (trim($value2) != '') {
							$aux1 = explode('|', $value2 . '||');
							if ($aux1[0] == '') {
								$aux1[0] = $aux1[1];
							}
							if ($aux1[1] == '') {
								$aux1[1] = $aux1[0];
							}
							if (trim($aux1[0]) != '') {
								$anexos[] = '$anexos' . "['{$key}']['options']['{$aux1[0]}']='{$aux1[1]}';";
								if (trim($aux1[2]) != '') {
									$anexos[] = '$anexos' . "['{$key}']['optionsTag']['{$aux1[0]}']='{$aux1[2]};'";
								}
							}
						}
					}
				}

				if ($field['usof'] == 'selecdb') {
					echo "<hr> usof selec DB:" . $field['campojoin'] . '<hr>';
					$aux = explode('|', $field['campojoin'] . '||||');
					if (($aux[0]!='')&&($aux[1]!='')){
						$aux[3]=str_replace('"',"'",$aux[3]);
						$aux[4]=str_replace('"',"'",$aux[4]);
						//$selecdb[] = '$anexos' . "['{$key}']['options']=".'$this->'."getArrayFromTable('{$aux[0]}', '{$aux[1]}',".'"'.$aux[4].'","'.$aux[3].'");';
						$selecdb[] = '$anexos' . "['{$key}']['options']=".'$this->'."actionGetListFor('{$key}',".'$anexos);';
						$anexos[] = '$anexos' . "['{$key}']['join']['table']='{$aux[0]}';";
						$anexos[] = '$anexos' . "['{$key}']['join']['campo']='{$aux[1]}';";
						if ($aux[3]!=''){
							$anexos[] = '$anexos' . "['{$key}']['join']['cond']=".'"'.$aux[3].'";';
						}
						if ($aux[4]!=''){
							$anexos[] = '$anexos' . "['{$key}']['join']['tag']=".'"'.$aux[4].'";';
						}
					}
					if ($aux[2]=='1'){
						//$cargaAjaxForm++;
						$selecdb[] = '$anexos' . "['{$key}']['cargaAjax']=1;";
					}
				}
				
				if ($field['usof'] == 'date') {
					//$cargaDateForm++;
				}
				$txtCampos .= implode($lines, PHP_EOL) . PHP_EOL;
				//print_r($field);
				//echo "<hr>";
				unset($lines);
			}
			$txtCampos .= "public \$_tSingular='" . Inputs::post('singular') . "';\n";
			$txtCampos .= "public \$_tPlural='" . Inputs::post('plural') . "';\n";
			$variables['_modSingular_'] = Inputs::post('singular');
			$variables['codejs']=Inputs::post('codejs','');
			$variables['codejsopenform']=Inputs::post('codejsopenform','');
			$view                       = $this->getActionView();
			$crudConfig                 = json_encode($_REQUEST);
			$dir                        = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR . 'configuration';
			@mkdir($dir, 0700, true);

/*			$files = array_slice(scandir($dir), 2);
			if (count($files)>0){
				print_r($files);
			}
*/
			if (file_exists($dir . DIRECTORY_SEPARATOR . 'config.crud')){
				$fileconfig=file_get_contents($dir . DIRECTORY_SEPARATOR . 'config.crud');
				if ($fileconfig!=$crudConfig){
					$gestor = fopen($dir . DIRECTORY_SEPARATOR . 'config-' . date('Ymd-His') . '.crud', "w+");
					fwrite($gestor, $fileconfig, strlen($fileconfig));
					fclose($gestor);
				}

			}


			$gestor = fopen($dir . DIRECTORY_SEPARATOR . 'config.crud', "w+");
			fwrite($gestor, $crudConfig, strlen($crudConfig));
			fclose($gestor);
			//print_r($crudConfig);
			$file      = strtolower($this->getFilenameLayout('model.php', 'plantillas'));
			//echo "plantilla:".$file;
			$gestor    = fopen($file, "r");
			$plantilla = fread($gestor, filesize($file));
			fclose($gestor);
			$plantilla = str_replace('//<<[CLASS]>>//', ucfirst($table), $plantilla);
			$plantilla = str_replace('//<<[CLASS_EXTENDS]>>//', 'Mk\Shared\Model', $plantilla);
			$plantilla = str_replace('//<<[CAMPOS]>>//', $txtCampos, $plantilla);
			$dir       = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR;
			@mkdir($dir . 'models', 0700, true);
			$gestor = fopen($dir . 'models' . DIRECTORY_SEPARATOR . strtolower($table) . '.php', "w+");
			fwrite($gestor, $plantilla, strlen($plantilla));
			fclose($gestor);
			$mensaje=$plantilla;

			if ($cargaAjaxForm>0){
				//$selecdb[] = '$anexos' . "['cargaAjaxForm']=1;";
			}

			if ($cargaDateForm>0){
				//$anexos[] = '$anexos' . "['cargaDateForm']=1;";
			}

			$anexos    = implode($anexos, PHP_EOL . "\t\t") . PHP_EOL;
			if (count($selecdb)>0){
				$anexos    .="\t\t".'if ($join!=0){'.PHP_EOL;
				$anexos    .= "\t\t\t".implode($selecdb, PHP_EOL . "\t\t\t") . PHP_EOL;
				$anexos    .="\t\t".'}'.PHP_EOL;
			}


			$file      = strtolower($this->getFilenameLayout('controller.php', 'plantillas'));
			$gestor    = fopen($file, "r");
			$plantilla = fread($gestor, filesize($file));
			fclose($gestor);
			$plantilla = str_replace('//<<[CLASS]>>//', ucfirst($table) . '_controller', $plantilla);
			$plantilla = str_replace('//<<[ANEXOS]>>//', $anexos, $plantilla);
			$dir       = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR;
			
			@mkdir($dir . 'controllers', 0700, true);
			$gestor = fopen($dir . 'controllers' . DIRECTORY_SEPARATOR . strtolower($table) . '_controller.php', "w+");
			fwrite($gestor, $plantilla, strlen($plantilla));
			fclose($gestor);
			//$plantilla=str_replace(PHP_EOL,'<br />',$plantilla);
			//$campos,$variables
			$view->set('variables',$variables);
			$view->set('mensaje','<br>//Aqui empieza el Modelo<br>'.nl2br($mensaje).PHP_EOL.'//Aqui empieza el Controlador<br>'.nl2br($plantilla));
			//$view->set('campos', $campos);
			//generar vista listar
			$file = strtolower($this->getFilenameLayout('view_listar.html', 'plantillas'));
			$this->procesaPlantillaView($file, $campos, $table);


/*			$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'jslibrary';
			$fileconfig=file_get_contents($dir . DIRECTORY_SEPARATOR . 'library.js');
			$jsl  = \Mk\Tools\String::getEtiquetas($fileconfig, '[[js:]]', '[[:js]]', '1');
			echo "<hr>Library Js: <hr>";
			print_r($jsl);
			echo "<hr>Library Js Fin <hr>";
*/
			$file = strtolower($this->getFilenameLayout('view_formulario.html', 'plantillas'));
			$this->procesaPlantillaView($file, $campos, $table);
		}
		private function procesaPlantillaView($filePl, $campos, $table)
		{
			global $variables;
			echo "<h1>Inicia proceso de Vista:</h1><h2>" . basename($filePl) . "</h2>";
			$gestor    = fopen($filePl, "r");
			$plantilla = fread($gestor, filesize($filePl));
			fclose($gestor);
			$componentes                        = \Mk\Tools\String::getEtiquetas($plantilla, '[[component:]]', '[[:component]]', '1');
/*			$codeUnique['jsinline']['index']    = \Mk\Tools\String::getEtiquetas($plantilla, '{% append js.inline %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['jsonready']['index']   = \Mk\Tools\String::getEtiquetas($plantilla, '{% append js.onready %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['jsfiles']['index']     = \Mk\Tools\String::getEtiquetas($plantilla, '{% append js.files %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['styleinline']['index'] = \Mk\Tools\String::getEtiquetas($plantilla, '{% append style.inline %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['stylefiles']['index']  = \Mk\Tools\String::getEtiquetas($plantilla, '{% append style.files %}', '{% /append %}', 2, 'index', ' ');
*/			while (sizeof($componentes) > 0) {
				foreach ($componentes as $component => $parametros) {
					$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR;
					$file = $dir . $component . '.html';
					if (!file_exists($file)) {
						return exit;
					}
					$gestor = fopen($file, "r");
					$html   = fread($gestor, filesize($file));
					fclose($gestor);

					$this->copiarDir($dir . 'img',APP_PATH . DIRECTORY_SEPARATOR . 'img',true,true);
					$this->copiarDir($dir . 'js',APP_PATH . DIRECTORY_SEPARATOR . 'js',true,true);

/*					$codeUnique['jsinline'][$component]    = \Mk\Tools\String::getEtiquetas($html, '{% append js.inline %}', '{% /append %}', 2, $component, ' ');
					$codeUnique['jsonready'][$component]   = \Mk\Tools\String::getEtiquetas($html, '{% append js.onready %}', '{% /append %}', 2, $component, ' ');
					$codeUnique['jsfiles'][$component]     = \Mk\Tools\String::getEtiquetas($html, '{% append js.files %}', '{% /append %}', 2, $component, ' ');
					$codeUnique['styleinline'][$component] = \Mk\Tools\String::getEtiquetas($html, '{% append style.inline %}', '{% /append %}', 2, $component, ' ');
					$codeUnique['stylefiles'][$component]  = \Mk\Tools\String::getEtiquetas($html, '{% append style.files %}', '{% /append %}', 2, $component, ' ');
*/					if (!$codeUnique['codeunique'][$component]) {
						$codeUnique['codeunique'][$component] = \Mk\Tools\String::getEtiquetas($html, '[[unique:]]', '[[:unique]]', 2, $component, ' ');
						if (trim($codeUnique['codeunique'][$component]) != '') {
							$posi = strpos($plantilla, "[[component:]]$component");
							echo "<br>code unique" . $codeUnique['codeunique'][$component] . " POsicion: $posi";
							if ($posi !== false) {
								$plantilla = substr($plantilla, 0, $posi) . $codeUnique['codeunique'][$component] . substr($plantilla, $posi);
							}
							$codeUnique['codeunique'][$component] = '';
						}
					}
					if (@filesize($dir . $component . '.php') > 0) {
						$funcionphp = '\Components\\' . ucfirst($component) . '\\' . ucfirst($component);
						$funcionphp = new $funcionphp($campos,$variables);
					} else {
						$funcionphp = null;
					}
					$parametros = array_unique($parametros);
					echo "<br>Procesado el Componente: $component";
					$html1 = $html;
					//print_r($parametros);
					foreach ($parametros as $key => $param) {
						$html = $html1;
						$tag  = $component;
						if ($param != '') {
							$tag      = $tag . '::' . $param;
							$paramvar = explode('&', $param . '&');
							foreach ($paramvar as $key1 => $var1) {
								if ($var1 != '') {
									$var1 = explode('=', $var1 . '=');
									if ($var1[0] != '') {
										$html                               = str_replace('[[var:]]' . $var1[0] . '[[:var]]', rtrim(implode(array_slice($var1, 1), '='), '='), $html);
										$codeUnique['jsinline'][$component] = str_replace('[[var:]]' . $var1[0] . '[[:var]]', rtrim(implode(array_slice($var1, 1), '='), '='), $codeUnique['jsinline'][$component]);
									}
									//$html = str_replace('[[var:]]'.$var1[0].'[[:var]]',rtrim(implode(array_slice($var1,1),'='),'='),$html);
								}
								$html = $this->procesaPhpHtml($html, $funcionphp);
							}
						} else {
							$html = $this->procesaPhpHtml($html, $funcionphp);
						}

						$compile = \Mk\Tools\String::getEtiquetas($html, '[[compile:]]', '[[:compile]]', 3, $component, '[[compilando]] ');
						//$compile=$compile[0];
						/*if ($component=='form_input'){
						echo "<hr><div style='color:blue;'>Comienza input form</div><hr>".print_r($compile,true)."<hr>";
						}
						*/
						if (trim($compile) != '') {
							$compile  = str_replace('$$', '[[*]]', $compile);
							$compile  = str_replace('{% ', '[% ', $compile);
							$compile  = str_replace(' %}', ' %]', $compile);
							$compile  = str_replace('$', '[[]]', $compile);
							$compile  = str_replace('[[*]]', '$', $compile);
							//$compile = str_replace('\\','[[**]]',$compile);
							$compile  = str_replace('[* ', '{% ', $compile);
							$compile  = str_replace(' *]', ' %}', $compile);
							$vcompile = new \Mk\View();
							$vcompile->set('campos', $campos);
							$vcompile->set('variables', $variables);

							$compile  = $vcompile->render($compile);
							$compile  = str_replace('[% ', '{% ', $compile);
							$compile  = str_replace(' %]', ' %}', $compile);
							$compile  = str_replace('[[]]', '$', $compile);
							//$compile = str_replace('[[**]]','\\',$compile);
							echo "<br><span style='color:red;'><code>$compile</code> Compilado </span>";
							$html = str_replace('[[compilando]]', stripslashes($compile), $html);

/*							$codeUnique['jsinline'][$component]    .= \Mk\Tools\String::getEtiquetas($html, '{% append js.inline %}', '{% /append %}', 2, $component, ' ');
							$codeUnique['jsonready'][$component]   .= \Mk\Tools\String::getEtiquetas($html, '{% append js.onready %}', '{% /append %}', 2, $component, ' ');
							$codeUnique['jsfiles'][$component]     .= \Mk\Tools\String::getEtiquetas($html, '{% append js.files %}', '{% /append %}', 2, $component, ' ');
							$codeUnique['styleinline'][$component] .= \Mk\Tools\String::getEtiquetas($html, '{% append style.inline %}', '{% /append %}', 2, $component, ' ');
							$codeUnique['stylefiles'][$component]  .= \Mk\Tools\String::getEtiquetas($html, '{% append style.files %}', '{% /append %}', 2, $component, ' ');
*/

						}
						echo "<br>---Renderizado Componente: $tag";
						$plantilla = str_replace('[[component:]]' . $tag . '[[:component]]', $html, $plantilla);
					}
					if ($funcionphp) {
						unset($funcionphp);
					}
				}
				$componentes = \Mk\Tools\String::getEtiquetas($plantilla, '[[component:]]', '[[:component]]', '1');
			} //while

			$codeUnique['jsinline']['index']    = \Mk\Tools\String::getEtiquetas($plantilla, '{% append js.inline %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['jsonready']['index']   = \Mk\Tools\String::getEtiquetas($plantilla, '{% append js.onready %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['jsfiles']['index']     = \Mk\Tools\String::getEtiquetas($plantilla, '{% append js.files %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['styleinline']['index'] = \Mk\Tools\String::getEtiquetas($plantilla, '{% append style.inline %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['stylefiles']['index']  = \Mk\Tools\String::getEtiquetas($plantilla, '{% append style.files %}', '{% /append %}', 2, 'index', ' ');
			$codeUnique['jsopenform']['index']  = \Mk\Tools\String::getEtiquetas($plantilla, '{% append js.openform %}', '{% /append %}', 2, 'index', ' ');


			$js  = implode($codeUnique['jsfiles'], " ");
			$js  = \Mk\Tools\String::quitarSaltosDobles($js);
			$js  = str_replace("'", '"', $js);
			$aux = \Mk\Tools\String::getEtiquetas($js, 'src="', '"', 1, 'index', ' ');
			$js  = '';
			foreach ($aux as $key => $value) {
				$js .= "<script type='text/javascript' src='{$key}'></script>" . PHP_EOL;
			}
			$css = implode($codeUnique['jsfiles'], " ");
			$css .= implode($codeUnique['stylefiles'], " ");
			$css = \Mk\Tools\String::quitarSaltosDobles($css);
			$css = str_replace("'", '"', $css);
			$aux = \Mk\Tools\String::getEtiquetas($css, 'href="', '"', 1, 'index', ' ');
			$css = '';
			foreach ($aux as $key => $value) {
				$css .= "<link type='text/css' rel='stylesheet' href='{$key}'/>" . PHP_EOL;
			}
			//echo "Aqui esta <div>{$css}</div>";
			$js        = $css . $js;
			$plantilla = PHP_EOL . '{% append js.files %}' . $js . '{% /append %}' . PHP_EOL . $plantilla;
			//$plantilla = PHP_EOL.'{% append js.files %}'.implode($codeUnique['jsfiles']," ").PHP_EOL.'{% /append %}'.PHP_EOL.$plantilla;
			$plantilla = PHP_EOL . '{% append js.openform %}' . implode($codeUnique['jsopenform'], " ") . PHP_EOL . '{% /append %}' . PHP_EOL . $plantilla;
			$plantilla = PHP_EOL . '{% append js.inline %}' . implode($codeUnique['jsinline'], " ") . PHP_EOL . '{% /append %}' . PHP_EOL . $plantilla;
			$plantilla = PHP_EOL . '{% append js.onready %}' . implode($codeUnique['jsonready'], " ") . PHP_EOL . '{% /append %}' . PHP_EOL . $plantilla;
			$plantilla = PHP_EOL . '{% append style.inline %}' . implode($codeUnique['styleinline'], " ") . PHP_EOL . '{% /append %}' . PHP_EOL . $plantilla;
			//$plantilla = PHP_EOL.'{% append style.files %}'.$css.'{% /append %}'.PHP_EOL.$plantilla;
			$plantilla = PHP_EOL . '{% append style.files %}' . implode($codeUnique['stylefiles'], " ") . PHP_EOL . '{% /append %}' . PHP_EOL . $plantilla;
			foreach ($variables as $key => $value) {
				$plantilla = str_replace('[[var:]]' . $key . '[[:var]]', $value, $plantilla);
			}
			$plantilla = \Mk\Tools\String::quitarSaltosDobles($plantilla);
			$dir       = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR;
			$filePl    = explode('_', $filePl);
			if (sizeOf($filePl) > 0) {
				$filePl = $filePl[sizeOf($filePl) - 1];
			}
			@mkdir($dir . 'views', 0700, true);
			echo "<br>Grabado Vista:" . $dir . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $filePl;
			$gestor = fopen($dir . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $filePl, "w+");
			fwrite($gestor, $plantilla, strlen($plantilla));
			fclose($gestor);
		}
		private function procesaPhpHtml($html, $funcionphp)
		{
			if ($funcionphp) {
				$php = \Mk\Tools\String::getEtiquetas($html, '[[php:]]', '[[:php]]', '1');
				//print_r($php);
				//$php=array_unique($php);
				foreach ($php as $key2 => $param2) {
					$param = trim(implode(',', $param2), ',');
					$texto = $funcionphp->$key2($param);
					echo "<br>EL php {$key2} es: $texto";
					if ($param == '') {
						$html = str_replace('[[php:]]' . $key2 . '[[:php]]', $texto, $html);
					} else {
						$html = str_replace('[[php:]]' . $key2 . '::' . $param . '[[:php]]', $texto, $html);
					}
				}
			}
			return $html;
		}
		private function renderComponente($idComponent, $plantilla, &$codeUnique, &$codeExist)
		{
			//print_r($plantilla);
			$jsinline                             = \Mk\Tools\String::getEtiquetas($plantilla, '{% append js.inline %}', '{% /append %}', 2, $idComponent, ' ');
			$codeUnique['jsinline'][$idComponent] = $jsinline[$idComponent];
			$componentes                          = \Mk\Tools\String::getEtiquetas($plantilla, '[[component:]]', '[[:component]]', '1');
			//print_r($componentes);
			foreach ($componentes as $component => $parametros) {
				//TODO: revisar s existe el componente
				$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR;
				$file = $dir . $component . '.html';
				if (!file_exists($file)) {
					return exit;
				}
				//$file=CORE_PATH.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.$component.DIRECTORY_SEPARATOR.$component.'.html';
				$gestor = fopen($file, "r");
				$html   = fread($gestor, filesize($file));
				fclose($gestor);
				$jsinline                           = \Mk\Tools\String::getEtiquetas($html, '{% append js.inline %}', '{% /append %}', 2, $component, ' ');
				$codeUnique['jsinline'][$component] = $jsinline[$component];
				$parametros                         = array_unique($parametros);
				//print_r($parametros);
				foreach ($parametros as $key => $param) {
					$tag = $component;
					if ($param != '') {
						$tag = $tag . '::' . $param;
					}
					echo "<br>Incluye Componente: $tag";
					$plantilla = str_replace('[[component:]]' . $tag . '[[:component]]', $html, $plantilla);
				}
			}
		}
		public function actionInit()
		{
			$view = $this->getActionView();
			$this->addViewData('database', $this->database->getSchema());
			//echo "Base de datos:".$this->database->getSchema()."<hr>";
			$result = $this->database->execute("SHOW TABLES FROM " . $this->database->getSchema());
			$tables = Array();
			while ($row = $result->fetch_array()) {
				//echo "Tabla:".$row[0]."</br>";
				//echo "<pre>";print_r($this->database->getFields($row[0]));"</pre>";
				$tables[$row[0]] = $this->database->getFields($row[0]);
				//$tables[$row[0]]=$this->database->getTableInformationOf($row[0]);
				$tabla[$row[0]]  = $row[0];
				$view->set('tables', $tables);
			}
			$session = Registry::get("session");
			$session->set('tables', Form::getOptions($tabla, '','...'));
			//echo $this->getFilenameAction();
		}
		public function actionGetCampos()
		{
			$campos = array();
			$valor  = Inputs::request('valor');
			if ($valor != '') {
				$campos = $this->database->getColsOf($valor);
			}
			echo Form::getOptions($campos, '','...');
		}
	}
}
?>