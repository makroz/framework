<?php 

namespace Mk
{
	use Mk\Base as Base;
	use Mk\Registry as Registry;
	use Mk\Inspector as Inspector;
	use Mk\StringMethods as StringMethods;
	//use Mk\Model\Exception as Exception;
	class Model extends Base
	{
		/**
		* @readwrite
		*/
		protected $_table;
		/**
		* @readwrite
		*/
		protected $_connector;
		/**
		* @read
		*/
		protected $_types = array(
			"autonumber",
			"text",
			"tinytext",
			"integer",
			"int",
			"decimal",
			"boolean",
			"datetime",
			"varchar",
			"char",
			"tinyint",
			"float",
			"date"
			);
		/**
		* @read
		*/
		protected $_validators = array(
		"required" => array(
		"handler" => "_validateRequired",
		"message" => "The {0} field is required"
		),
		"alpha" => array(
		"handler" => "_validateAlpha",
		"message" => "The {0} field can only contain letters"
		),
		"numeric" => array(
		"handler" => "_validateNumeric",
		"message" => "The {0} field can only contain numbers"
		),
		"mail" => array(
		"handler" => "_validateEmail",
		"message" => "The {0} field can only contain valid email"
		),
		"alphanumeric" => array(
		"handler" => "_validateAlphaNumeric",
		"message" => "The {0} field can only contain letters and numbers"
		),
		"max" => array(
		"handler" => "_validateMax",
		"message" => "The {0} field must contain less than {2} characters"
		),
		"min" => array(
		"handler" => "_validateMin",
		"message" => "The {0} field must contain more than {2} characters"
		)
		);
		/**
		* @read
		*/
		protected $_errors = array();
		protected $_columns;
		protected $_primary;
		public function __construct($options = array())
		{
			parent::__construct($options);
			//$this->connector->Sync($this);
			$this->load();
		}

		public function escape($dato){
			return $this->connector->escape($dato);
		}

		public function loadFromArray($previous){
			foreach ($previous as $key => $value)
				{
					
					$prop = "_{$key}";
					if (!empty($previous[$key]) && property_exists($this, $prop))
					{
						$this->$prop = stripslashes($previous[$key]);
					}


				}
			return true;
		}

		public function loadToArray(){
			$data=array();
			foreach ($this->columns as $key => $column)
			{
				if (!$column["read"])
				{
					$prop = "_{$key}";
					$data[$key] = $this->$prop;
					continue;
				}
				//if ($column != $this->primaryColumn && $column)
				//{
					$method = "get".ucfirst($key);
					$data[$key] = $this->$method();
					continue;
				//}
			}
			return $data;
		}

		public function load()
		{
			$primary = $this->primaryColumn;
			$raw = $primary["raw"];
			$name = $primary["name"];
			if (!empty($this->$raw))
			{
				$previous = $this->connector
				->query()
				->from($this->table)
				->where("{$name} = ?", $this->$raw)
				->first();
				if ($previous == null)
				{
					throw $this->_Exception("Primary key value invalid");
				}
				foreach ($previous as $key => $value)
				{
					//$prop = "_{$key}";
					if (!isset($this->$key))
					{

						$this->$key = stripslashes($value);
					}
				}
			}
		}
		public function delete()
		{
			$primary = $this->primaryColumn;
			$raw = $primary["raw"];
			$name = $primary["name"];
			if (!empty($this->$raw))
			{
				return $this->connector
				->query()
				->from($this->table)
				->where("{$name} = ?", $this->$raw)
				->delete();
			}
		}
		public static function deleteAll($where = array())
		{
			$instance = new static();
			$query = $instance->connector
			->query()
			->from($instance->table);
			foreach ($where as $clause => $value)
			{
				$query->where($clause, $value);
			}
			return $query->delete();
		}

		public function save($notColumns='')
		{

			$primary = $this->primaryColumn;
			$raw = $primary["raw"];
			$name = $primary["name"];
			$query = $this->connector
			->query()
			->from($this->table);
			if (!empty($this->$raw))
			{
				$query->where("{$name} = ?", $this->$raw);
			}
			$data = array();
			//print_r($notColumns);
			foreach ($this->columns as $key => $column)
			{

				if (is_array($notColumns)&&($notColumns[$key]==1)){
					continue;
				}
				if (!$column["read"])
				{
					$prop = $column["raw"];
					$data[$key] = $this->$prop;
					continue;
				}
				if ($column != $this->primaryColumn && $column)
				{
					$method = "get".ucfirst($key);
					$data[$key] = $this->$method();
					continue;
				}
			}
			$result = $query->save($data);
			if ($result > 0)
			{
				$this->$raw = $result;
			}
			return $result;
		}

		public function saveFromArray($onlyColumns)
		{
			$primary = $this->primaryColumn;
			$raw = $primary["raw"];
			$name = $primary["name"];
			$query = $this->connector
			->query()
			->from($this->table);
			if (!empty($onlyColumns[$name]))
			{
				$query->where("{$name} = ?", $onlyColumns[$name]);
			}
			$data = array();
			foreach ($onlyColumns as $key => $column)
			{
					$data[$key] = $onlyColumns[$key];
			}
			$result = $query->save($data);
			if ($result > 0)
			{
				$this->$raw = $result;
			}
			return $result;
		}

		public function getTable()
		{
			if (empty($this->_table))
			{
				$this->_table = strtolower(get_class($this));
			}
			return $this->_table;
		}
		public function getConnector()
		{
			if (empty($this->_connector))
			{
				$database = Registry::get("database");
				if (!$database)
				{
					throw $this->_Exception("No connector availible");
				}
				$this->_connector = $database->initialize();
			}
			return $this->_connector;
		}
		public function getColumns()
		{
			if (empty($_columns))
			{
				$primaries = 0;
				$columns = array();
				$class = get_class($this);
				$types = $this->types;
				$inspector = new Inspector($this);
				$properties = $inspector->getClassProperties();
				$first = function($array, $key)
				{
					if (!empty($array[$key]) && sizeof($array[$key]) == 1)
					{
						return $array[$key][0];
					}
					return null;
				};
				foreach ($properties as $property)
				{
					$propertyMeta = $inspector->getPropertyMeta($property);
					if (!empty($propertyMeta["@column"]))
					{
						$name = preg_replace("#^_#", "", $property);
						$primary = !empty($propertyMeta["@primary"]);
						$type = $first($propertyMeta, "@type");
						$length = $first($propertyMeta, "@length");
						$index = !empty($propertyMeta["@index"]);
						$readwrite = !empty($propertyMeta["@readwrite"]);
						$read = !empty($propertyMeta["@read"]) || $readwrite;
						$write = !empty($propertyMeta["@write"]) || $readwrite;
						$validate = !empty($propertyMeta["@validate"])? $propertyMeta["@validate"] : false;
						$label = $first($propertyMeta, "@label");
						$labelf = !empty($propertyMeta["@labelf"])? $first($propertyMeta, "@labelf") : $first($propertyMeta, "@label");


						if (!in_array($type, $types))
						{
							throw $this->_Exception("{$type} is not a valid type for $name");
						}
						if ($primary)
						{
							$primaries++;
						}
						$columns[$name] = array(
							"raw" => $property,
							"name" => $name,
							"primary" => $primary,
							"type" => $type,
							"length" => $length,
							"index" => $index,
							"read" => $read,
							"write" => $write,
							"validate" => $validate,
							"label" => $label,
							"labelf" => $labelf
							);

						if (!empty($propertyMeta["@uso"])){
							$columns[$name]['uso']=$first($propertyMeta, "@uso");	
						}
						 
						if (!empty($propertyMeta["@funcion"])){
							$columns[$name]['funcion']=$first($propertyMeta, "@funcion");
						}
						if (!empty($propertyMeta["@fcustom"])){
							$columns[$name]['fcustom']=$first($propertyMeta, "@fcustom");
						}
						 
						if (!empty($propertyMeta["@checkvalor"])){
							$columns[$name]['checkvalor']=$first($propertyMeta, "@checkvalor");
						}

					}
				}
				if ($primaries !== 1)
				{
					throw $this->_Exception("{$class} must have exactly one @primary column");
				}
				$this->_columns = $columns;
			}
			return $this->_columns;
		}
		public function getColumn($name)
		{
			if (!empty($this->_columns[$name]))
			{
				return $this->_columns[$name];
			}
			return null;
		}
		public function getPrimaryColumn()
		{
			if (!isset($this->_primary))
			{
				//$primary;
				foreach ($this->columns as $column)
				{
					if ($column["primary"])
					{
						$primary = $column;
						break;
					}
				}
				$this->_primary = $primary;
			}
			return $this->_primary;
		}
		public static function first($where = array(), $fields = array("*"),$order = null, $direction = null)
		{
			$model = new static();
			return $model->_first($where, $fields, $order, $direction);
		}
		protected function _first($where = array(), $fields = array("*"),$order = null, $direction = null)
		{
			$query = $this
			->connector
			->query()
			->from($this->table, $fields);
			foreach ($where as $clause => $value)
			{
				$query->where($clause, $value);
			}
			if ($order != null)
			{
				$query->order($order, $direction);
			}
			$first = $query->first();
			$class = get_class($this);
			if ($first)
			{
				return new $class(
					$query->first()
					);
			}
			return null;
		}
		public static function all($where = array(), $fields = array("*"),$order = null, $direction = null, $limit = null, $page = null)
		{
			$model = new static();
			return $model->_all($where, $fields, $order, $direction, $limit, $page);
		}
		protected function _all($where = array(), $fields = array("*"),$order = null, $direction = null, $limit = null, $page = null)
		{
			$query = $this
			->connector
			->query()
			->from($this->table, $fields);
			foreach ($where as $clause => $value)
			{
				$query->where($clause, $value);
			}
			if ($order != null)
			{
				$query->order($order, $direction);
			}
			if ($limit != null)
			{
				$query->limit($limit, $page);
			}

			return $query->all();
			
			// $rows = array();
			// $class = get_class($this);
			// foreach ($query->all() as $row)
			// {
			// 	$rows[] = new $class(
			// 		$row
			// 		);
			// }
			// return $rows;
		}
		public static function count($where = array())
		{
			$model = new static();
			return $model->_count($where);
		}
		protected function _count($where = array())
		{
			$query = $this
			->connector
			->query()
			->from($this->table);
			foreach ($where as $clause => $value)
			{
				$query->where($clause, $value);
			}
			return $query->count();
		}

		protected function _validateRequired($value)
		{
			return !empty($value);
		}
		protected function _validateAlpha($value)
		{
			return StringMethods::match($value, "#^([a-zA-Z]+)$#");
		}
		protected function _validateNumeric($value)
		{
			return StringMethods::match($value, "^(\d|-)?(\d|,)*\.?\d*$");
		}

		protected function _validateEmail($value)
		{
			if ($value==''){
				return true;
			}

			return StringMethods::match($value, "^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$");
		}

		protected function _validateAlphaNumeric($value)
		{
			return StringMethods::match($value, "#^([a-zA-Z0-9]+)$#");
		}
		protected function _validateMax($value, $number)
		{
			return strlen($value) <= (int) $number;
		}
		protected function _validateMin($value, $number)
		{
			return strlen($value) >= (int) $number;
		}

		public function validate()
		{
			$this->_errors = array();
			$columns = $this-> getColumns();
			foreach ($columns as $column)
			{
				if ($column["validate"])
				{
					$error = false;
					$pattern = "#[a-z]+\(([a-zA-Z0-9,]+)\)#";
					$raw = $column["raw"];
					$name = $column["name"];
					$validators = $column["validate"];
					$label = $column["label"];
					$defined = $this-> getValidators();

					foreach ($validators as $validator)
					{

						$function = $validator;
						$arguments = array(
							$this-> $raw
							);
						$match = StringMethods::match($validator, $pattern);
						//\Mk\Shared\FormTools::debug($match,1050);
						if (count($match) > 0)
						{
							$matches = StringMethods::split($match[0], ",\s*");
							$arguments = array_merge($arguments, $matches);
							$offset = StringMethods::indexOf($validator, "(");
							$function = substr($validator, 0, $offset);

						}

						if (!isset($defined[$function]))
						{
							throw $this->_Exception("The ({$function}) validator is not defined");
						}
						$template = $defined[$function];
						if (!call_user_func_array(array($this, $template["handler"]), $arguments))
						{
							$replacements = array_merge(array(
								$label ? $label : $raw
								), $arguments);
							$message = $template["message"];
							foreach ($replacements as $i => $replacement)
							{
								$message = str_replace("{{$i}}", $replacement, $message);
							}
							if (!isset($this->_errors[$name]))
							{
								$this->_errors[$name] = array();
							}
							$this->_errors[$name][] = $message;
							$error = true;
						}
					}
				}
			}
			return !$error;
		}


	}
}

?>