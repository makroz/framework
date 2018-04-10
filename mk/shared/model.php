<?php 
namespace Mk\Shared
{
	class Model extends \Mk\Model
	{
		
		public function save($notColumns='')
		{
			$primary = $this-> getPrimaryColumn();
			$raw = $primary["raw"];
			if (empty($this-> $raw))
			{
				if (method_exists($this,'setCreated_')){
				$this-> setCreated(date("Y-m-d H:i:s"));
				}
				//$this-> setDeleted(false);
				//$this-> setLive(true);
			}
			if (method_exists($this,'setModified_')){
				$this-> setModified(date("Y-m-d H:i:s"));
			}
			parent::save($notColumns);
		}
	}
}

/*
		/**
		* @column
		* @readwrite
		* @type datetime
		protected $_created;
		/**
		* @column
		* @readwrite
		* @type datetime
		protected $_modified;
*/
?>