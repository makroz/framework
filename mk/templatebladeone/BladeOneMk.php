<?php
namespace Mk\Templatebladeone
{
	class BladeOneMk extends  BladeOne {
    use BladeOneMkTrait;
    public function templateExiste($template){
      return file_exists($this->getTemplateFile(basename($template)));
    }
  }
}
?>
