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
    public function templateExiste($template){
      return $this->templateExist($template);
    }


}
