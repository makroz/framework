<?php

namespace Mk\Router
{
	use Mk\Base as Base;
	//use Mk\Router\Exception as Exception;
	class Route extends Base
	{
		/**
		* @readwrite
		*/
		protected $_pattern;
		/**
		* @readwrite
		*/
		protected $_controller;
		/**
		* @readwrite
		*/
		protected $_action;
		/**
		* @readwrite
		*/
		protected $_parameters = array();
	}
}

?>