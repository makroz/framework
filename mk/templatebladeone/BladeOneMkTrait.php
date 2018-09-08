<?php
namespace Mk\Templatebladeone;

/**
* trait BladeOneMk
* Copyright (c) 2018 Mario Guzman. Don't delete this comment, its part of the license.
* Extends the tags of the class BladeOne.  Its optional
* Adiciona todas las funcionalidades del Framework MK
* @package  BladeOneMk
* @version 1.0 2018-07-24
* @author   Mario Guzman <makroz@hotmail.com>
*/
trait BladeOneMkTrait
{
    protected function getFileComponente($name)
    {
        $raiz='';
        $f=explode('.', $name.'.');
        if ($f[1]!='') {
            $raiz=$f[0]. DIRECTORY_SEPARATOR;
            $name=$f[1];
        }
        $dir  = APP_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR .  'components' . DIRECTORY_SEPARATOR .$raiz. $name . DIRECTORY_SEPARATOR;
        $file = $dir . $name ;
        //\Mk\Debug::debug_to_console("buscando: ".$file.$this->fileExtension);
        if (!file_exists($file.$this->fileExtension)) {
            //echo "no se encontro  archivo ($file)";
            $dir  = CORE_PATH . DIRECTORY_SEPARATOR . 'mk' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'crud' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR .$raiz. $name . DIRECTORY_SEPARATOR;
            $file = $dir . $name ;
            //\Mk\Debug::debug_to_console("buscando2:".$file.$this->fileExtension);
            if (!file_exists($file.$this->fileExtension)) {
                //echo "no existe archivo ($file)";
                $file='';
            }
        }
        return $file;
    }
    protected function processComponente($name, $params='')
    {
        $file=$this->getFileComponente($name);
        if ($file!='') {
            $oldCompilePath=$this->compiledPath;
            $oldTemplatePath=$this->templatePath;
            $this->templatePath = dirname($file);
            $this->compiledPath = dirname($file).DIRECTORY_SEPARATOR.'cacheblade';
            if ($params!='') {
                $params=explode(',', $params);
            } else {
                $params=array();
            }
            $file=strtolower(basename($file));
            $funcionphp=null;
            if (@filesize($this->templatePath .DIRECTORY_SEPARATOR. $file . '.php') > 0) {
                $funcionphp = '\Components\\' . ucfirst($file) . '\\' . ucfirst($file);
                $funcionphp = new $funcionphp($this->variables, $params);
            }
            $params['_data']=$params;
            if ($funcionphp) {
                $params['_php']=$funcionphp;
            }
            $r=$this->runChild($file, $params);
            $this->templatePath = $oldTemplatePath;
            $this->compiledPath = $oldCompilePath;
            return $r;
        }
        return "(No Existe El Componente {$name})";
    }
    protected function compileComponente($expression)
    {
        $expression = $this->stripParentheses($expression);
        $c = $expression;
        $param=array();
        $p0 = strpos($ex, ',');
        if ($p0 == false) {
            $param=explode(',', $expression);
            $c=array_shift($param);
            $param=addslashes(implode(',', $param));
        }
        return $this->phpTag . "echo \$this->processComponente('{$c}','{$param}'); ?>";
    }
    /**
    * Compile the prependsection statements into valid PHP.
    *
    * @return string
    */
    public function compilePrependsection($expression)
    {
        return $this->phpTag . '$this->prependSection(); ?>';
    }
    /**
    * Stop injecting content into a section and prepend it.
    *
    * @return string
    * @throws \InvalidArgumentException
    */
    public function prependSection()
    {
        if (empty($this->sectionStack)) {
            throw new InvalidArgumentException('Cannot end a section without first starting one.');
        }
        $last = array_pop($this->sectionStack);
        $content=ob_get_clean();
        if (isset($this->sections[$last])) {
            if (strpos($this->sections[$last], $content)===false) {
                $this->sections[$last] = $content.$this->sections[$last];
            }
        } else {
            $this->sections[$last] = $content;
        }
        return $last;
    }
    public function appendSection()
    {
        if (empty($this->sectionStack)) {
            throw new InvalidArgumentException('Cannot end a section without first starting one.');
        }
        $last = array_pop($this->sectionStack);
        $content=ob_get_clean();
        if (isset($this->sections[$last])) {
            if (strpos($this->sections[$last], $content)===false) {
                $this->sections[$last] .= $content;
            }
        } else {
            $this->sections[$last] = $content;
        }
        return $last;
    }
    public function setSections($sections)
    {
        $this->sections=$sections;
        return true;
    }
    public function getSections()
    {
        return $this->sections;
    }
}
