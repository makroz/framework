<?php
namespace Mk
{
	use Mk\Base as Base;
	use Mk\View as View;
	use Mk\Event as Event;
	use Mk\Registry as Registry;
	use Mk\Template as Template;
	use Mk\Inputs as Inputs;
	use Mk\Session as Session;
	//use Mk\Controller\Exception as Exception;
	class Controller extends Base
	{
		/**
		* @readwrite
		*/
		protected $_sharedData=array();
		/**
		* @readwrite
		*/
		protected $_parameters;
		/**
		* @readwrite
		*/
		protected $_layoutView;
		/**
		* @readwrite
		*/
		protected $_actionView;
		/**
		* @readwrite
		*/
		protected $_willRenderLayoutView = true;
		/**
		* @readwrite
		*/
		protected $_willRenderActionView = true;
		/**
		* @readwrite
		*/
		protected $_defaultPath = "application/views";
		/**
		* @readwrite
		*/
		protected $_defaultModules = MODULE_PATH;
		/**
		* @readwrite
		*/
		protected $_pathModule = MODULE_PATH;
		/**
		* @readwrite
		*/
		protected $_defaultLayout = "standard";
		/**
		* @readwrite
		*/
		protected $_defaultExtension = "html";
		/**
		* @readwrite
		*/
		protected $_defaultContentType = "text/html";
		/**
		* @read
		*/
		protected $_name;
		/**
		* @readwrite
		*/
		protected $_renderAjaxDiv ='';


		public function getParam($name,$Default='',$controller=''){
		if ($controller==''){
			$controller=$this->getName();
		}		
		$llave=$controller.'_'.$name;
		$session = Registry::get("session");
		$valor = Inputs::get($name, $session->get($llave,$Default));
		$session->set($llave,$valor);
		return $valor;
	}

	public function setParam($name,$valor,$controller=''){
		if ($controller==''){
			$controller=$this->getName();
		}		
		$session = Registry::get("session");
		$session->set($controller.'_'.$name,$valor);
		return true;
	}


		public function setRenderView($t=true){
			$this->_willRenderActionView=$t;
			$this->_willRenderLayoutView=$t;
		}


		
		public function getFilenameLayout($file='',$theme=''){
			$router = Registry::get("router");
			$controller = $router->getController();
			$action = $router->getAction();

			$defaultPath = $this->getDefaultPath();
			$defaultLayout = $this->getDefaultLayout();
			$defaultExtension = $this->getDefaultExtension();
			$defaultModule=$this->getDefaultModules();
			
			if ($theme==''){
				$theme='layouts';
			}

			if ($file==''){
				$file="{$defaultLayout}.{$defaultExtension}";
			}

			$filed="{$defaultModule}/{$controller}/views/$theme/$file";
				if (!file_exists($filed))
				{
					$filed=APP_PATH."/{$defaultPath}/$theme/$file";
				}

			$filed=str_replace('\\',DIRECTORY_SEPARATOR,$filed);
			$filed=str_replace('/',DIRECTORY_SEPARATOR,$filed);

			return $filed;

		}


		public function getFilenameAction($file='',$theme=''){
			$router = Registry::get("router");
			$controller = $router->getController();
			$action = $router->getAction();

			$defaultPath = $this->getDefaultPath();
			$defaultLayout = $this->getDefaultLayout();
			$defaultExtension = $this->getDefaultExtension();
			$defaultModule=$this->getDefaultModules();

			if ($theme!=''){
				$theme=str_replace('\\','',$theme);
				$theme=str_replace('/','',$theme);
				$theme.= DIRECTORY_SEPARATOR;

			}
			$this->_pathModule ="{$defaultModule}/{$controller}/views/$theme";

			if ($file==''){
				$file="{$action}.{$defaultExtension}";
			}

			$filed=$this->_pathModule.$file;
				if (!file_exists($filed))
				{
					$this->_pathModule =APP_PATH."/{$defaultPath}/{$controller}/$theme";
					$filed=$this->_pathModule.$file;
				}


			return $filed;

		}

		public function changeViewAction($action)
		{

			if ($this->getWillRenderLayoutView())
			{
				$file=$this->getFilenameLayout();

				$view = new View(array(
					"file" => $file
					));
				$this->setLayoutView($view);
			}

			if ($this->getWillRenderActionView())
			{

				$file=$this->getFilenameAction($action);
				$view = new View(array(
					"file" => $file
					));
				$this->setActionView($view);
				//\MK\Debug::msg($this->getLayoutView()->getFile());
			}
		}



		public function __construct($options = array())
		{
			parent::__construct($options);

			
			$router = Registry::get("router");
			$controller = $router->getController();
			$action = $router->getAction();
			
			// $defaultPath = $this->getDefaultPath();
			// $defaultLayout = $this->getDefaultLayout();
			// $defaultExtension = $this->getDefaultExtension();
			// $defaultModule=$this->getDefaultModules();
			$this->addViewData('_action',$action);
			$this->addViewData('_controller',$controller);


			if ($this->getWillRenderLayoutView())
			{
				$file=$this->getFilenameLayout();

				$view = new View(array(
					"file" => $file
					));
				$this->setLayoutView($view);
			}

			if ($this->getWillRenderActionView())
			{

				$file=$this->getFilenameAction();
				$view = new View(array(
					"file" => $file
					));
				$this->setActionView($view);
				//\MK\Debug::msg($this->getLayoutView()->getFile());
			}
		}

		public function getVarView(){
			$view = $this->getActionView();
			$default = $view->Template->Implementation->getDefaultKey();
			//echo "Mario:".$default;
			$data = Registry::get($default, array());
			//Debug::msg($data);
			if ((isset($data['varView']))and(is_array($data['varView'])))
			{
				$this->_sharedData=array_merge($this->_sharedData,$data['varView']);
			}

		}
		public function addViewData($key,$value){
			$this->_sharedData[$key]=$value;
		}

		public function delViewData($key){
			unset($this->_sharedData[$key]);
		}

		public function render()
		{
			$defaultContentType = $this->getDefaultContentType();
			$results = null;

			if (\Mk\Tools\App::isAjax()==true){
				$this->_renderAjaxDiv='ajax';

				$_willRenderLayoutView=false;
			}else{
				$this->_renderAjaxDiv='';
			}
			$this->addViewData('isAjax',\Mk\Tools\App::isAjax());
			setcookie('_config_',json_encode(\Mk\Tools\App::getConfig()->param));


			$doAction = $this->getWillRenderActionView() && $this->getActionView()->fileExist();
			$doLayout = $this->getWillRenderLayoutView() && $this->getLayoutView()->fileExist();
			
			//$this->getVarView();
			try
			{
				

				if ($doAction)
				{
					$view = $this->getActionView();
					foreach ($this->_sharedData as $key => $value) {
						$view->set($key,$value);
					}
					$data1=$view->_getData();
					$results = $view->render();
					
				}
				//\Mk\Shared\FormTools::debug($result,2);
				if ($doLayout)
				{
					$view = $this->getLayoutView();
					$view->set("template", $results);
					foreach ($this->_sharedData as $key => $value) {
						$view->set($key,$value);
					}

					$results = $view->render();
				}

				if ($results)
				{
					header("Content-type: {$defaultContentType}");
					$results=str_replace("\\'", "'", $results);


					if ($this->_renderAjaxDiv!=''){
						$runScript=Inputs::get("_runScriptLoad",'');
						//echo $runScript;
						$results=\Mk\Tools\String::getEtiquetas($results,'<!-- ajax: -->','<!-- :ajax -->',2,'root',' ');
						$x=\Mk\Tools\String::getEtiquetas($results,'<!-- notajax: -->','<!-- :notajax -->',2,'root',' ');
					
					}else{

						$x=\Mk\Tools\String::getEtiquetas($results,'<!-- onlyajax: -->','<!-- :onlyajax -->',2,'root',' ');
					}

					if ($this->getParam("_debug",'')=='1'){
						 //$data1=$view->_getData();
						unset($data1["template"]);
						$debug=print_r($data1,true);
						if ($this->_renderAjaxDiv==''){
						$results.='<div id="debug" class="modal bottom-sheet "><div class="modal-content"><h4>Datos de Debug</h4><p><pre id="debug_content">'.$debug.
								'</pre></p></div><div class="modal-footer"><a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">cerrar</a></div></div>';
						}else{
							$results.='<div id="debug_content1">'.$debug.
								'</div>'."<script type='text/javascript'>$('#debug_content').html($('#debug_content1').html());$('#debug_content1').remove(); </script>";
						}
								
					}

					echo $results;
					if ($runScript!=''){
							echo "<script type='text/javascript'> $runScript </script>";
						}
				}

				$this->setWillRenderLayoutView(false);
				$this->setWillRenderActionView(false);
			}
			catch (Exception $e)
			{
				throw $this->_Exception("Invalid layout/template syntax");
			}
		}

		protected function getName()
		{
			if (empty($this->_name))
			{
				$this->_name = get_class($this);
			}
			return $this->_name;
		}
		public function __destruct()
		{
			Events::fire("mk.controller.destruct.before", array($this->name));
			$this->render();
			Events::fire("mk.controller.destruct.after", array($this->name));
		}
	}
}	

?>