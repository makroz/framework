<?php
namespace Mk\Crud {
    use Mk\Inputs as Inputs;
    use Mk\Registry as Registry;
    use Mk\Shared\ControllerDb as ControllerDb;
    use Mk\Tools\Form as Form;
    use Mk\Tools\Strings as Strings;

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
            $lfunc['useract']                  = 'UsuarioAct()';

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
            $lusof['selecdbgrupo']            = 'DB Lista Grupo';
            $lusof['join']            			= 'De Otra Tabla';
            $lusof['tree']					  = 'Lista Tree';
            $lusof['buscardb']                = 'DB Buscar';
            $lusof['editor']                = 'Editor Html';
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
            */            $pedir['uso']['text']             = 'Procesar al Grabar/Actualizar';
            $pedir['uso']['type']             = 'sel';
            $pedir['uso']['opt']              = Form::getOptions($luso, '', 'Ninguno');
            $pedir['usof']['text']            = 'Tipo de input en el formulario';
            $pedir['usof']['type']            = 'sel';
            $pedir['usof']['opt']             = Form::getOptions($lusof, '', 'No usar');
            $pedir['usof']['tam']             = 's8';
            $pedir['tam']['text']             = 'Tamano';
            $pedir['tam']['type']             = 'text';
            $pedir['tam']['tam']              = 's2';
            $pedir['posf']['text']             = 'Pos. Form.';
            $pedir['posf']['type']             = 'text';
            $pedir['posf']['tam']              = 's2';
            $pedir['posl']['text']             = 'Pos. Lista';
            $pedir['posl']['type']             = 'hidden';
            $pedir['posl']['tam']              = 's2';

            $pedir['funcion']['text']         = 'Funcion al Grabar/cargar';
            $pedir['funcion']['type']         = 'sel';
            $pedir['funcion']['opt']          = Form::getOptions($lfunc, '', 'Por Defecto');
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
            $pedir['tipolista']['opt']        = Form::getOptions($ltipolista, '', 'show');
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
            $pedir['listalista']['icon-click'] = 'openLista(modalistalista);';

            $pedir['listalista']['disabled']  = 'disabled';
            $pedir['listalista']['tam']       = 's3';
            $pedir['campojoin']['text']       = 'Tabla y Campo';
            $pedir['campojoin']['type']       = 'text';
            $pedir['campojoin']['icon']       = 'search';
            $pedir['campojoin']['icon-type']  = 'postfix';
            $pedir['campojoin']['icon-click'] = "openJoin('campojoin');";
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
            $pedir['readonly']['text']             = 'Solo Lectura?';
            $pedir['readonly']['type']             = 'check';
            $pedir['readonly']['onval']            = '1';
            $pedir['readonly']['offval']           = '0';
            $pedir['readonly']['tam']              = 's6 m3';
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
            $pedir['listaeventos']['icon-click'] = 'openLista(modalistaeventos);';
            $pedir['listaeventos']['tam']       = 's4';
            $pedir['listaeventos']['disabled']  = 'disabled';

            $pedir['validar']['text']       = 'Validacion';
            $pedir['validar']['type']       = 'sel';
            $pedir['validar']['opt']        = Form::getOptions($lvalid, '', 'Ninguna');

            $pedir['defVal']['text']           = 'valor por Defecto';
            $pedir['defVal']['type']           = 'text';
            $pedir['defVal']['tam']           = 's12';

            $pedir['classForm']['text']           = 'Clase en Formulario';
            $pedir['classForm']['type']           = 'text';
            $pedir['classForm']['tam']           = 's6';

            $pedir['classLista']['text']           = 'Clase en Listado';
            $pedir['classLista']['type']           = 'text';
            $pedir['classLista']['tam']           = 's6';

            $pedir['codejs']['text']           = 'Codigo JS en Formulario';
            $pedir['codejs']['type']           = 'codeeditor';
            $pedir['codejsopenform']['text']           = 'Codigo JS al abrir en Formulario';
            $pedir['codejsopenform']['type']           = 'codeeditor';
            $pedir['codecontroler']['text']           = 'Codigo PHP Controlador Preservado';
            $pedir['codecontroler']['type']           = 'codeeditor';

            $pedir['codeaftersave']['text']           = 'Codigo PHP afterSave <br> <strong style="color:red">function afterSave($action){</strong><br>';
            $pedir['codeaftersave']['type']           = 'codeeditor';
            $pedir['codeaftersave']['unique']	= 1;

            $pedir['codebeforesave']['text']           = 'Codigo PHP beforeSave <br> <strong style="color:red">function beforeSave($action){</strong><br>';
            $pedir['codebeforesave']['type']           = 'codeeditor';
            $pedir['codebeforesave']['unique']	= 1;

            $pedir['codeafterdelete']['text']           = 'Codigo PHP afterDelete <br> <strong style="color:red">function afterDelete($id,$i,$t){</strong><br>';
            $pedir['codeafterdelete']['type']           = 'codeeditor';
            $pedir['codeafterdelete']['unique']	= 1;

            $pedir['codebeforedelete']['text']           = 'Codigo PHP beforeDelete <br> <strong style="color:red">function beforeDelete($id){</strong><br>';
            $pedir['codebeforedelete']['type']           = 'codeeditor';
            $pedir['codebeforedelete']['unique']	= 1;

            $pedir['listafilter']['text']           = 'filter';
            $pedir['listafilter']['type']           = 'hidden';



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
                $pedir['tipolista']['val'][$key]   = 'show';
                $pedir['posf']['val'][$key]   = $posf;
                $pedir['posl']['val'][$key]   = $posf;
                $pedir['defVal']['val'][$key]   = $field['default'];
                $posf++;
                // Valores por defecto segun tipo de datos de la BD

                if ($field['null']=='NO') {
                    $pedir['required']['val'][$key]   = '1';
                }

                if (in_array($field['type'], array(
                    'text',
                    'varchar',
                    'char',
                    'tinytext',
                    'mediumtext',
                    'longtext'
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
                        'longtext',
                    ), true)) {
                        $pedir['usof']['val'][$key]     = 'area';
                        if ($field['type']=='longtext') {
                            $pedir['usof']['val'][$key]      = 'editor';
                        }

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
                        $pedir['required']['val'][$key]   = '0';
                    }
                    if (($field['args'][0] == 8) and (Strings::stripos_array($campos, array(
                        'date',
                        'fecha',
                        'fec'
                    ), true, ',') !== false)) {
                        $pedir['usof']['val'][$key]     = 'date';
                        $pedir['tamlista']['val'][$key] = '90';
                        $pedir['funcion']['val'][$key]  = 'date';
                    }
                    if (($field['args'][0] == 14) and (Strings::stripos_array($campos, array(
                        'date',
                        'fecha',
                        'fec'
                    ), true, ',') !== false)) {
                        $pedir['usof']['val'][$key]     = 'datetime';
                        $pedir['tamlista']['val'][$key] = '120';
                        $pedir['funcion']['val'][$key]  = 'datetime';
                    }
                    if (($field['args'][0] == 6) and (Strings::stripos_array($campos, array(
                        'time',
                        'hora'
                    ), true, ',') !== false)) {
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
                            if ($campos===false) {
                                $tablajoin[0]=\Mk\Tools\Strings::pluralize($tablajoin[0]);
                                $campos       = $this->database->getColsOf($tablajoin[0]);
                            }
                            \Mk\Debug::msg($campos);
                            $campos       = implode(',', $campos);
                            $pos          = Strings::stripos_array($campos, array(
                                'nom',
                                'nombre',
                                'name',
                                'descrip',
                                'descripcion',
                                'description'
                            ), true, ',');
                            if ($pos !== false) {
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
                    $pos          = Strings::stripos_array($campos, array(
                        'nom',
                        'nombre',
                        'name',
                        'descrip',
                        'descripcion',
                        'description'
                    ), true, ',');
                    if ($pos !== false) {
                        $campos = substr($campos, $pos[0], strlen($pos[1]));
                    } else {
                        $campos='';
                    }

                    $pedir['campojoin']['val'][$key] =$session->get('table', '') . '|' . $campos. '|1|';
                    $pedir['tamlista']['val'][$key]  = '150';
                    $pedir['usof']['val'][$key]      = 'selecdb';
                    $pedir['funcion']['val'][$key]   = '-1';
                }
                if ($Name == 'created_') {
                    $pedir['tipolista']['val'][$key] = '-1';
                    $pedir['usof']['val'][$key]      = '-1';
                    $pedir['uso']['val'][$key]       = 'G';
                    $pedir['funcion']['val'][$key]   = 'datetimesystem';
                    $pedir['required']['val'][$key]   = '0';
                }
                if ($Name == 'modified_') {
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
                    //$pedir['onlyread']['val'][$key]='1';
                    //$var='cod';
                    if ($Name == 'pk') {
                        $pedir['tipolista']['val'][$key] = 'show';
                        $pedir['tamlista']['val'][$key]  = '60';
                        $pedir['label']['val'][$key]     = 'Id';
                        $pedir['required']['val'][$key]   = '0';
                    }
                }
            }
            $view->set('_tablas', $tablas);
            $view->set('_table', $table);
            $view->set('_pedir', $pedir);
        }

        public function copiarDir($dir, $dirDest, $recursivo=true, $result=false)
        {
            if (!file_exists($dir)) {
                return false;
            }
            $iterator = new \DirectoryIterator($dir);
            foreach ($iterator as $item) {
                if (!$item->isDot() && $item->isFile()) {
                    if ($item->getSize()>0) {
                        if (copy($item->getPathname(), $dirDest. DIRECTORY_SEPARATOR . $item->getFilename())) {
                            if ($result) {
                                echo "<br>Se copia el archivo para el componente:" . $item->getFilename();
                            }
                        } else {
                            if ($result) {
                                echo "<br>No se copiado el archivo correctamente" . $item->getFilename();
                            }
                        }
                    }
                }
                if (!$item->isDot() && $item->isDir() && $recursivo===true) {
                    @mkdir($dirDest. DIRECTORY_SEPARATOR . $item->getFilename(), 0700, true);
                    $this->copiarDir($item->getPathname(), $dirDest. DIRECTORY_SEPARATOR . $item->getFilename(), true, $result);
                }
            }
        }

        public function actionGetConfig()
        {
            $this->setRenderView(false);
            $session   = Registry::get("session");
            $table = Inputs::get('table', $session->get('table', ''));
            $fileconfig='';
            $dir = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR . 'configuration';
            if (file_exists($dir . DIRECTORY_SEPARATOR . 'config.crud')) {
                $fileconfig=file_get_contents($dir . DIRECTORY_SEPARATOR . 'config.crud');
            }
            $dir = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR . 'controllers';
            if (file_exists($dir . DIRECTORY_SEPARATOR . $table.'_controller.php')) {
                $filecontroller=file_get_contents($dir . DIRECTORY_SEPARATOR . $table.'_controller.php');
            }

            if (stripos($filecontroller, '//* preserve code: *//')!==false) {
                $aux1=stripos($filecontroller, '//* preserve code: *//')+strlen('//* preserve code: *//');
                $aux2=stripos($filecontroller, '//* :preserve code *//', $aux1);
                $filecontroller=substr($filecontroller, $aux1, $aux2-$aux1);
                $filecontroller=\Mk\Tools\Strings::quitarSaltosDobles($filecontroller);
            } else {
                $filecontroller='';
            }

            $aux=json_decode($fileconfig);
            $aux->codecontroler=$filecontroller;
            $fileconfig=json_encode($aux);
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
            //\Mk\Debug::msg($campos,2);
            $fields    = $this->database->getFields($table);
            $anexos    = array();
            $selecdb    = array();
            $selecdbelse    = array();

            $joins=array();
            $txtCampos = '';
            $cargaAjaxForm=0;
            //$selectdb=0;
            //echo "<hr>campos:<hr>";print_r($campos);
            $view->set('campos', $campos);
            $view->set('variables', $variables);

            $anexos[] = '$anexos' . "['listAction']=".'"'. Inputs::post('listAction').'";';

            $lalias=array();
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
                if ($field['defVal']=='') {
                    $lines[]                  = 'protected $_' . $key . ';';
                } else {
                    $lines[]                  = 'protected $_' . $key . "='".$field['defVal']."';";
                    $anexos[] = '$anexos' . "['{$key}']['defVal']='".addslashes($field['defVal'])."';";
                }

                if ($field['usof'] == 'check') {
                    $aux = explode('/', $field['checkvalor'] . '/');
                    if ($aux[0] == '') {
                        $aux[0] = '1';
                    }
                    if ($aux[1] == '') {
                        $aux[1] = '0';
                    }
                    $anexos[] = '$anexos' . "['{$key}']['dataon']='{$aux[0]}';";
                    $anexos[] = '$anexos' . "['{$key}']['dataoff']='{$aux[1]}';";
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


                if ($field['tipolista'] == 'join') {
                    $aux = explode('|', $field['campojoin'] . '||||');
                    if (($aux[0]!='')&&($aux[1]!='')) {
                        $aux[3]=str_replace('"', "'", $aux[3]);
                        $aux[4]=str_replace('"', "'", $aux[4]);
                        //$prifk='pk';
                        $prifk=$this->database->getPrimaryKeyOf($aux[0]);
                        $alias="j_{$aux[0]}";
                        if ($lalias[$alias]>0) {
                            $lalias[$alias]=$lalias[$alias]+1;
                            $alias=$alias.'_'.($lalias[$alias]-1);
                        } else {
                            $lalias[$alias]=1;
                        }
                        $joins[] ="\t\t".'$this->setJoins('."'{$aux[0]}','({$table}.{$key}={$alias}.{$prifk[0]})',Array('{$alias}.{$aux[1]}' => 'join_{$key}'),$alias);";
                    }
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

                if (($field['usof'] == 'selecdb')||($field['usof'] == 'selecdbgrupo')||($field['usof'] == 'buscardb')) {
                    echo "<hr> usof selec DB:" . $field['campojoin'] . '<hr>';
                    $aux = explode('|', $field['campojoin'] . '||||||');
                    if (($aux[0]!='')&&($aux[1]!='')) {
                        $aux[3]=str_replace('"', "'", $aux[3]);
                        $aux[4]=str_replace('"', "'", $aux[4]);
                        //$selecdb[] = '$anexos' . "['{$key}']['options']=".'$this->'."getArrayFromTable('{$aux[0]}', '{$aux[1]}',".'"'.$aux[4].'","'.$aux[3].'");';
                        if ($field['usof'] != 'buscardb') {
                            if ($field['listafilter']==1) {
                                $selecdbelse[] = '$anexos' . "['{$key}']['options']=".'$this->'."actionGetListFor('{$key}',".'$anexos);';
                            } else {
                                $selecdb[] = '$anexos' . "['{$key}']['options']=".'$this->'."actionGetListFor('{$key}',".'$anexos);';
                            }
                        }
                        $anexos[] = '$anexos' . "['{$key}']['join']['table']='{$aux[0]}';";
                        $anexos[] = '$anexos' . "['{$key}']['join']['campo']='{$aux[1]}';";
                        $anexos[] = '$anexos' . "['{$key}']['join']['alias']='{$alias}';";
                        if ($aux[3]!='') {
                            $anexos[] = '$anexos' . "['{$key}']['join']['cond']=".'"'.$aux[3].'";';
                        }
                        if ($aux[4]!='') {
                            $anexos[] = '$anexos' . "['{$key}']['join']['tag']=".'"'.$aux[4].'";';
                        }

                        if ($aux[5]!='') {
                            $anexos[] = '$anexos' . "['{$key}']['join']['join']=".'"'.$aux[5].'";';
                        }
                        if ($aux[6]!='') {
                            $anexos[] = '$anexos' . "['{$key}']['join']['cb']=".'"'.$aux[6].'";';
                        }

                        if ($field['usof'] == 'selecdbgrupo') {
                            $anexos[] = '$anexos' . "['{$key}']['join']['grupo']=1;";
                        }
                    }
                    //if (($aux[2]=='1')||($field['tipolista'] == 'join')){
                    if ($aux[2]=='1') {
                        //$cargaAjaxForm++;
                        //$selecdb[] = '$anexos' . "['{$key}']['cargaAjax']=1;";
                        $anexos[] = '$anexos' . "['{$key}']['cargaAjax']=1;";
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

            $keyseguridad=Inputs::post('seguridad', '');
            $txtCampos .= "public \$_tSingular='" . Inputs::post('singular') . "';\n";
            $txtCampos .= "public \$_tPlural='" . Inputs::post('plural') . "';\n";
            $variables['_modSingular_'] = Inputs::post('singular');
            $variables['codejs']=Inputs::post('codejs', '');
            $variables['codejsopenform']=Inputs::post('codejsopenform', '');
            $view                       = $this->getActionView();
            $crudConfig                 = json_encode($_REQUEST);
            $dir                        = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR . 'configuration';
            @mkdir($dir, 0700, true);

            /*			$files = array_slice(scandir($dir), 2);
                        if (count($files)>0){
                            print_r($files);
                        }
            */
            if (file_exists($dir . DIRECTORY_SEPARATOR . 'config.crud')) {
                $fileconfig=file_get_contents($dir . DIRECTORY_SEPARATOR . 'config.crud');
                if ($fileconfig!=$crudConfig) {
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
            $plantilla = str_replace('//<<[JOINS]>>//', implode($joins, PHP_EOL) . PHP_EOL, $plantilla);


            $dir       = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR;
            @mkdir($dir . 'models', 0700, true);
            $gestor = fopen($dir . 'models' . DIRECTORY_SEPARATOR . strtolower($table) . '.php', "w+");
            fwrite($gestor, $plantilla, strlen($plantilla));
            fclose($gestor);
            $mensaje=$plantilla;

            if ($cargaAjaxForm>0) {
                //$selecdb[] = '$anexos' . "['cargaAjaxForm']=1;";
            }

            if ($cargaDateForm>0) {
                //$anexos[] = '$anexos' . "['cargaDateForm']=1;";
            }

            $anexos    = implode($anexos, PHP_EOL . "\t\t") . PHP_EOL;
            if (count($selecdb)>0) {
                $anexos    .="\t\t".'if ($join!=0){'.PHP_EOL;
                $anexos    .= "\t\t\t".implode($selecdb, PHP_EOL . "\t\t\t") . PHP_EOL;
                $anexos    .="\t\t".'}'.PHP_EOL;
            }

            if (count($selecdbelse)>0) {
                $anexos    .= "\t\t".implode($selecdbelse, PHP_EOL . "\t\t") . PHP_EOL;
            }

            $file      = strtolower($this->getFilenameLayout('controller.php', 'plantillas'));
            $gestor    = fopen($file, "r");
            $plantilla = fread($gestor, filesize($file));
            fclose($gestor);
            $plantilla = str_replace('//<<[CLASS]>>//', ucfirst($table) . '_controller', $plantilla);

            $aux1='//$this$_secureKey'."='$table';".PHP_EOL;
            $aux1.="\t\t".'//$this->_secure();';
            if (trim($keyseguridad)!='') {
                $aux1='$this->_secureKey'."='{$keyseguridad}';".PHP_EOL;
                $aux1.="\t\t".'$this->_secure();';
            }
            $plantilla = str_replace('//<<[SECURE]>>//', $aux1, $plantilla);

            $plantilla = str_replace('//<<[PRESERVECODE]>>//', Inputs::post('codecontroler', ''), $plantilla);

            $afterSave= trim(\Mk\Tools\Strings::quitarSaltosDobles(Inputs::post('codeaftersave', '')));
            if ($afterSave!='') {
                $afterSave = str_replace(PHP_EOL, PHP_EOL."\t\t", "\t\t".$afterSave);
                $afterSave='public function afterSave($action){'.PHP_EOL.
                    $afterSave.PHP_EOL.
                    "\t".'}';
            }
            $plantilla = str_replace('//<<[AFTERSAVE]>>//', $afterSave, $plantilla);
            $beforeSave= trim(\Mk\Tools\Strings::quitarSaltosDobles(Inputs::post('codebeforesave', '')));
            if ($beforeSave!='') {
                $beforeSave = str_replace(PHP_EOL, PHP_EOL."\t\t", "\t\t".$beforeSave);
                $beforeSave='public function beforeSave($action){'.PHP_EOL.
                    $beforeSave.PHP_EOL.
                    "\t".'}';
            }
            $plantilla = str_replace('//<<[BEFORESAVE]>>//', $beforeSave, $plantilla);


            $afterDelete= trim(\Mk\Tools\Strings::quitarSaltosDobles(Inputs::post('codeafterdelete', '')));
            if ($afterDelete!='') {
                $afterDelete = str_replace(PHP_EOL, PHP_EOL."\t\t", "\t\t".$afterDelete);
                $afterDelete='public function afterDelete($id,$i,$t){'.PHP_EOL.
                    $afterDelete.PHP_EOL.
                    "\t".'}';
            }
            $plantilla = str_replace('//<<[AFTERDELETE]>>//', $afterDelete, $plantilla);
            $beforeDelete= trim(\Mk\Tools\Strings::quitarSaltosDobles(Inputs::post('codebeforedelete', '')));
            if ($beforeDelete!='') {
                $beforeDelete = str_replace(PHP_EOL, PHP_EOL."\t\t", "\t\t".$beforeDelete);
                $beforeDelete='public function beforeDelete($id){'.PHP_EOL.
                    $beforeDelete.PHP_EOL.
                    "\t".'}';
            }
            $plantilla = str_replace('//<<[BEFOREDELETE]>>//', $beforeDelete, $plantilla);


            $plantilla = str_replace('//<<[ANEXOS]>>//', $anexos, $plantilla);
            $dir       = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR;

            @mkdir($dir . 'controllers', 0700, true);
            $gestor = fopen($dir . 'controllers' . DIRECTORY_SEPARATOR . strtolower($table) . '_controller.php', "w+");
            fwrite($gestor, $plantilla, strlen($plantilla));
            fclose($gestor);
            //$plantilla=str_replace(PHP_EOL,'<br />',$plantilla);
            //$campos,$variables
            $view->set('variables', $variables);
            $view->set('mensaje', '<br>//Aqui empieza el Modelo<br>'.nl2br($mensaje).PHP_EOL.'//Aqui empieza el Controlador<br>'.nl2br($plantilla));
            //$view->set('campos', $campos);
            //generar vista listar
            $file = strtolower($this->getFilenameLayout('view_listar.html', 'plantillas'));
            if ($this->procesaPlantillaView($file, $campos, $table)!==true) {
                die("Error al procesar la vista $file");
            }


            /*			$dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'jslibrary';
                        $fileconfig=file_get_contents($dir . DIRECTORY_SEPARATOR . 'library.js');
                        $jsl  = \Mk\Tools\Strings::getEtiquetas($fileconfig, '[[js:]]', '[[:js]]', '1');
                        echo "<hr>Library Js: <hr>";
                        print_r($jsl);
                        echo "<hr>Library Js Fin <hr>";
            */
            $file = strtolower($this->getFilenameLayout('view_formulario.html', 'plantillas'));
            if ($this->procesaPlantillaView($file, $campos, $table)!==true) {
                die("Error al procesar la vista $file");
            }
        }
        private function procesaPlantillaView($filePl, $campos, $table)
        {
            global $variables;
            $crep=0;
            echo "<h1>Inicia proceso de Vista:</h1><h2>" . basename($filePl) . "</h2>";
            $gestor    = fopen($filePl, "r");
            $plantilla = fread($gestor, filesize($filePl));
            fclose($gestor);
            $componentes                        = \Mk\Tools\Strings::getEtiquetas($plantilla, '[[component:]]', '[[:component]]', '1');

            echo '<hr>nuevos componentes primera vez<hr><pre>'.print_r($componentes, true).'</pre>';
            \Mk\Debug::msg($componentes, 4, 'primera');
            /*			$codeUnique['jsinline']['index']    = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append js.inline %}', '{% /append %}', 2, 'index', ' ');
                        $codeUnique['jsonready']['index']   = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append js.onready %}', '{% /append %}', 2, 'index', ' ');
                        $codeUnique['jsfiles']['index']     = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append js.files %}', '{% /append %}', 2, 'index', ' ');
                        $codeUnique['styleinline']['index'] = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append style.inline %}', '{% /append %}', 2, 'index', ' ');
                        $codeUnique['stylefiles']['index']  = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append style.files %}', '{% /append %}', 2, 'index', ' ');
            */
            $ult_parametros=array();
            while (sizeof($componentes) > 0) {
                foreach ($componentes as $component => $parametros) {
                    $raiz='';
                    $f=explode('.', $component.'.');
                    if ($f[1]!='') {
                        $raiz=$f[0]. DIRECTORY_SEPARATOR;
                        $component=$f[1];
                    }
                    \Mk\Debug::msg($f);
                    $dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR .$raiz. $component . DIRECTORY_SEPARATOR;
                    $file = $dir . $component . '.html';
                    if (!file_exists($file)) {
                        echo "<h1>NO se encontro el archivo de componente: $component ($file)</h1>";
                        return false;
                    }
                    $gestor = fopen($file, "r");
                    $html   = fread($gestor, filesize($file));
                    fclose($gestor);

                    $this->copiarDir($dir . 'img', APP_PATH . DIRECTORY_SEPARATOR . 'img', true, true);
                    $this->copiarDir($dir . 'js', APP_PATH . DIRECTORY_SEPARATOR . 'js', true, true);

                    /*					$codeUnique['jsinline'][$component]    = \Mk\Tools\Strings::getEtiquetas($html, '{% append js.inline %}', '{% /append %}', 2, $component, ' ');
                                        $codeUnique['jsonready'][$component]   = \Mk\Tools\Strings::getEtiquetas($html, '{% append js.onready %}', '{% /append %}', 2, $component, ' ');
                                        $codeUnique['jsfiles'][$component]     = \Mk\Tools\Strings::getEtiquetas($html, '{% append js.files %}', '{% /append %}', 2, $component, ' ');
                                        $codeUnique['styleinline'][$component] = \Mk\Tools\Strings::getEtiquetas($html, '{% append style.inline %}', '{% /append %}', 2, $component, ' ');
                                        $codeUnique['stylefiles'][$component]  = \Mk\Tools\Strings::getEtiquetas($html, '{% append style.files %}', '{% /append %}', 2, $component, ' ');
                    */                    if (!$codeUnique['codeunique'][$component]) {
                        $codeUnique['codeunique'][$component] = \Mk\Tools\Strings::getEtiquetas($html, '[[unique:]]', '[[:unique]]', 2, $component, ' ');
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
                        $funcionphp = new $funcionphp($campos, $variables);
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
                        if ($raiz!='') {
                            $tag=str_replace(DIRECTORY_SEPARATOR, '.', $raiz).$component;
                        }





                        if ($param != '') {
                            $tag      = $tag . '::' . $param;
                            $paramvar = explode('&', $param . '&');
                            foreach ($paramvar as $key1 => $var1) {
                                if ($var1 != '') {
                                    $var1 = explode('=', $var1 . '=');
                                    if ($var1[0] != '') {
                                        $html  = str_replace('[[var:]]' . $var1[0] . '[[:var]]', rtrim(implode(array_slice($var1, 1), '='), '='), $html);
                                        $codeUnique['jsinline'][$component] = str_replace('[[var:]]' . $var1[0] . '[[:var]]', rtrim(implode(array_slice($var1, 1), '='), '='), $codeUnique['jsinline'][$component]);
                                        $tag  = str_replace('[[var:]]' . $var1[0] . '[[:var]]', rtrim(implode(array_slice($var1, 1), '='), '='), $tag);
                                    }
                                    //$html = str_replace('[[var:]]'.$var1[0].'[[:var]]',rtrim(implode(array_slice($var1,1),'='),'='),$html);
                                }
                                $html = $this->procesaPhpHtml($html, $funcionphp);
                            }
                        } else {
                            $html = $this->procesaPhpHtml($html, $funcionphp);
                        }




                        $compile = \Mk\Tools\Strings::getEtiquetas($html, '[[compile:]]', '[[:compile]]', 3, $component, '[[compilando]] ');
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

                            //$compile  = str_replace('[[component:]]', '[[component1:]]', $compile);

                            $vcompile = new \Mk\View();
                            $vcompile->set('campos', $campos);
                            $vcompile->set('variables', $variables);

                            echo '<strong style="color:red"><hr>Copilacion de: <hr>'.$compile.'<hr><hr></strong>';
                            $compile  = $vcompile->render($compile);
                            echo '<strong style="color:blue"><hr>Copilacion de: <hr>'.$compile.'<hr><hr></strong>';
                            $compile  = str_replace('[% ', '{% ', $compile);
                            $compile  = str_replace(' %]', ' %}', $compile);
                            $compile  = str_replace('[[]]', '$', $compile);

                            //$compile  = str_replace('[[c:]]', '[[component:]]', $compile);
                            //$compile  = str_replace('[[:c]]', '[[:component]]', $compile);
                            //$compile = str_replace('[[**]]','\\',$compile);
                            echo "<br><span style='color:red;'><code>$compile</code> Compilado </span>";
                            $html = str_replace('[[compilando]]', stripslashes($compile), $html);

                            /*							$codeUnique['jsinline'][$component]    .= \Mk\Tools\Strings::getEtiquetas($html, '{% append js.inline %}', '{% /append %}', 2, $component, ' ');
                                                        $codeUnique['jsonready'][$component]   .= \Mk\Tools\Strings::getEtiquetas($html, '{% append js.onready %}', '{% /append %}', 2, $component, ' ');
                                                        $codeUnique['jsfiles'][$component]     .= \Mk\Tools\Strings::getEtiquetas($html, '{% append js.files %}', '{% /append %}', 2, $component, ' ');
                                                        $codeUnique['styleinline'][$component] .= \Mk\Tools\Strings::getEtiquetas($html, '{% append style.inline %}', '{% /append %}', 2, $component, ' ');
                                                        $codeUnique['stylefiles'][$component]  .= \Mk\Tools\Strings::getEtiquetas($html, '{% append style.files %}', '{% /append %}', 2, $component, ' ');
                            */
                        }



                        if ($param != '') {
                            //$tag      = $tag . '::' . $param;
                            $paramvar = explode('&', $param . '&');
                            foreach ($paramvar as $key1 => $var1) {
                                if ($var1 != '') {
                                    $var1 = explode('=', $var1 . '=');
                                    if ($var1[0] != '') {
                                        $html  = str_replace('[[var:]]' . $var1[0] . '[[:var]]', rtrim(implode(array_slice($var1, 1), '='), '='), $html);
                                        $codeUnique['jsinline'][$component] = str_replace('[[var:]]' . $var1[0] . '[[:var]]', rtrim(implode(array_slice($var1, 1), '='), '='), $codeUnique['jsinline'][$component]);
                                    }
                                    //$html = str_replace('[[var:]]'.$var1[0].'[[:var]]',rtrim(implode(array_slice($var1,1),'='),'='),$html);
                                }
                                $html = $this->procesaPhpHtml($html, $funcionphp);
                            }
                        } else {
                            $html = $this->procesaPhpHtml($html, $funcionphp);
                        }


                        $crep++;

                        echo "<br>---Renderizado Componente: $tag";
                        $cc=0;
                        $plantilla = str_replace('[[component:]]' . $tag . '[[:component]]', $html, $plantilla, $cc);
                        /*						$ct=103;
                                                $ct1=substr('[[component:]]' . $tag . '[[:component]]',0,$ct);
                                                $ccc=strpos($plantilla, $ct1);
                                                $tt='';
                                                if ($ccc!==false){
                                                    $tt=substr($plantilla,$ccc,$ct);
                                                }
                                                echo "<hr>$crep:NUevo Html333:($ccc:$tt:$ct:".strlen('[[component:]]' . $tag . '[[:component]]')."::$ct1)".$cc.'::('.'[[component:]]' . $tag . '[[:component]]'.')<br>'.$html."<hr>***<br>".$plantilla."<hr>";

                                                if ($crep>20){
                                                    //die('Error mas de 60');
                                                }
                        */
                    }
                    if ($funcionphp) {
                        unset($funcionphp);
                    }
                }
                $componentes = \Mk\Tools\Strings::getEtiquetas($plantilla, '[[component:]]', '[[:component]]', '1');
                echo '<hr>nuevos componentes<hr><pre>'.print_r($componentes, true).'</pre>';
                \Mk\Debug::msg($componentes, 4);
            } //while

            $codeUnique['jsinline']['index']    = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append js.inline %}', '{% /append %}', 2, 'index', ' ');
            $codeUnique['jsonready']['index']   = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append js.onready %}', '{% /append %}', 2, 'index', ' ');
            $codeUnique['jsfiles']['index']     = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append js.files %}', '{% /append %}', 2, 'index', ' ');
            $codeUnique['styleinline']['index'] = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append style.inline %}', '{% /append %}', 2, 'index', ' ');
            $codeUnique['stylefiles']['index']  = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append style.files %}', '{% /append %}', 2, 'index', ' ');
            $codeUnique['jsopenform']['index']  = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append js.openform %}', '{% /append %}', 2, 'index', ' ');


            $js  = implode($codeUnique['jsfiles'], " ");
            $js  = \Mk\Tools\Strings::quitarSaltosDobles($js);
            $js  = str_replace("'", '"', $js);
            $aux = \Mk\Tools\Strings::getEtiquetas($js, 'src="', '"', 1, 'index', ' ');
            $js  = '';
            foreach ($aux as $key => $value) {
                $js .= "<script type='text/javascript' src='{$key}'></script>" . PHP_EOL;
            }
            $css = implode($codeUnique['jsfiles'], " ");
            $css .= implode($codeUnique['stylefiles'], " ");
            $css = \Mk\Tools\Strings::quitarSaltosDobles($css);
            $css = str_replace("'", '"', $css);
            $aux = \Mk\Tools\Strings::getEtiquetas($css, 'href="', '"', 1, 'index', ' ');
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
            $plantilla = \Mk\Tools\Strings::quitarSaltosDobles($plantilla);
            $dir       = MODULE_PATH . DIRECTORY_SEPARATOR . strtolower($table) . DIRECTORY_SEPARATOR;
            $filePl    = explode('_', $filePl);
            if (count($filePl) > 0) {
                $filePl = $filePl[count($filePl) - 1];
            }
            @mkdir($dir . 'views', 0700, true);
            echo "<br>Grabado Vista:" . $dir . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $filePl;
            $gestor = fopen($dir . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $filePl, "w+");
            fwrite($gestor, $plantilla, strlen($plantilla));
            fclose($gestor);
            return true;
        }
        private function procesaPhpHtml($html, $funcionphp)
        {
            if ($funcionphp) {
                $php = \Mk\Tools\Strings::getEtiquetas($html, '[[php:]]', '[[:php]]', '1');
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
            $jsinline                             = \Mk\Tools\Strings::getEtiquetas($plantilla, '{% append js.inline %}', '{% /append %}', 2, $idComponent, ' ');
            $codeUnique['jsinline'][$idComponent] = $jsinline[$idComponent];
            $componentes                          = \Mk\Tools\Strings::getEtiquetas($plantilla, '[[component:]]', '[[:component]]', '1');
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
                $jsinline                           = \Mk\Tools\Strings::getEtiquetas($html, '{% append js.inline %}', '{% /append %}', 2, $component, ' ');
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
            $tables = array();
            while ($row = $result->fetch_array()) {
                //echo "Tabla:".$row[0]."</br>";
                //echo "<pre>";print_r($this->database->getFields($row[0]));"</pre>";
                $tables[$row[0]] = $this->database->getFields($row[0]);
                //$tables[$row[0]]=$this->database->getTableInformationOf($row[0]);
                $tabla[$row[0]]  = $row[0];
                $view->set('tables', $tables);
            }
            $session = Registry::get("session");
            $session->set('tables', Form::getOptions($tabla, '', '...'));
            //echo $this->getFilenameAction();
        }
        public function actionGetCampos()
        {
            $campos = array();
            $valor  = Inputs::request('valor');
            if ($valor != '') {
                $campos = $this->database->getColsOf($valor);
            }
            echo Form::getOptions($campos, '', '...');
        }
    }
}
