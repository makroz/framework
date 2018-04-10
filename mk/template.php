<?php

namespace Mk
{
	use Mk\Base as Base;
	use Mk\ArrayMethods as ArrayMethods;
	use Mk\StringMethods as StringMethods;
	//use Mk\Template\Exception as Exception;
	class Template extends Base
	{
		/**
		* @readwrite
		*/
		protected $_implementation;
		/**
		* @readwrite
		*/
		protected $_header = "if (is_array(\$_data) && sizeof(\$_data))
		extract(\$_data); \$_text = array();";
		/**
		* @readwrite
		*/
		protected $_footer = "return implode(\$_text);";
		/**
		* @read
		*/
		protected $_code;
		/**
		* @read
		*/
		protected $_function;
		protected function _arguments($source, $expression)
		{

			$args = $this->_array($expression, array(
				$expression=>array(
					"opener"=>"{",
					"closer"=>"}"
					)
				));
			$tags = $args["tags"];
			//echo "Mario4:($source)($expression)";print_r($args);echo "<br>Tags:".print_r($tags);echo "<hr>";
			$arguments = array();
			$sanitized = StringMethods::sanitize($expression, "()[],.<>*$@");
			//echo "Mario5: $expression ($sanitized)";echo "<hr>";
			foreach ($tags as $i=>$tag)
			{
				$sanitized = str_replace($tag, "(.*)", $sanitized);
				$tags[$i] = str_replace(array("{", "}"), "", $tag);
			}
			if (preg_match("#{$sanitized}#", $source, $matches))
			{
				foreach ($tags as $i=>$tag)
				{
					$arguments[$tag] = $matches[$i + 1];
				}
			}
			//echo "<hr>(Mario 8: $source)<br>".print_r($arguments)."<hr>";
			return $arguments;
		}
		protected function _tag($source)
		{
			//echo "<script>alert('$source');</script>";
			$tag = null;
			$arguments = array();
			$match = $this->_implementation->match($source);
			if ($match == null)
			{
				return false;
			}
			$delimiter = $match["delimiter"];
			$type = $match["type"];
			$start = strlen($type["opener"]);
			$end = strpos($source, $type["closer"]);
			$extract = substr($source, $start, $end - $start);

			if (isset($type["tags"]))
			{
				$tags = implode("|", array_keys($type["tags"]));

				$regex = "#^(/){0,1}({$tags})\s*(.*)$#";
				if (!preg_match($regex, $extract, $matches))
				{
					return false;
				}
				
				$tag = $matches[2];
				$extract = $matches[3];
				$closer = !!$matches[1];
			}

			if ($tag && $closer)
			{
				return array(
					"tag"=>$tag,
					"delimiter"=>$delimiter,
					"closer"=>true,
					"source"=>false,
					"arguments"=>false,
					"isolated"=>$type["tags"][$tag]["isolated"]
					);
			}

			if (isset($type["arguments"]))
			{

				$arguments = $this->_arguments($extract, $type["arguments"]);
			}
			else if ($tag && isset($type["tags"][$tag]["arguments"]))
			{
							//echo "<hr>mario2:";print_r($type["tags"][$tag]["arguments"]);echo "($extract)<hr>";

				$arguments = $this->_arguments($extract, $type["tags"][$tag]["arguments"]);
			}
			//echo "Mario($tag)(".$type["arguments"].")(($extract))($source):****";print_r($arguments);echo '****';
			return array(
				"tag"=>$tag,
				"delimiter"=>$delimiter,
				"closer"=>false,
				"source"=>$extract,
				"arguments"=>$arguments,
				"isolated"=>(!empty($type["tags"]) ? $type["tags"][$tag]["isolated"]: false)
				);
		}
		protected function _array($source,$map=null)
		{
				$parts = array();
			$tags = array();
			$all = array();
			$type = null;
			$delimiter = null;
			while ($source)
			{
				$match = $this->_implementation->match($source,$map);
				$type = $match["type"];
				$delimiter = $match["delimiter"];
				$opener = strpos($source, $type["opener"]);
				$closer = strpos($source, $type["closer"]) + strlen($type["closer"]);
				if ($opener !== false)
				{

					$closer1=$closer;
					$opener1=$opener;
					$c=0;
					while ($opener1!==false){
						$opener1 = strpos($source, $type["opener"],$opener1+strlen($type["opener"]) );
						if (($opener1 !== false)and($opener1 < $closer1-strlen($type["closer"])))
						{

							$c++;
						}
					}
					while ($c>0){
						$c--;
						$closer1 = strpos($source, $type["closer"],$closer1) + strlen($type["closer"]);
					}


					$closer=$closer1;
					
					$parts[] = substr($source, 0, $opener);
					$tags[] = substr($source, $opener, $closer - $opener);
					$source = substr($source, $closer);
				}
				else
				{
					$parts[] = $source;
					$source = "";
				}
			}
			foreach ($parts as $i=>$part)
			{
				$all[] = $part;
				if (isset($tags[$i]))
				{
					$all[] = $tags[$i];
				}
			}
			return array(
				"text"=>ArrayMethods::clean($parts),
				"tags"=>ArrayMethods::clean($tags),
				"all"=>ArrayMethods::clean($all)
				);
		}
		protected function _tree($array)
		{
			$root = array(
				"children"=>array()
				);
			$current = & $root;
			foreach ($array as $i=>$node)
			{
				$result = $this->_tag($node);
				if ($result)
				{
					$tag = isset($result["tag"]) ? $result["tag"] : "";
					$arguments = isset($result["arguments"]) ? $result["arguments"] : "";
					if ($tag)
					{
						if (!$result["closer"])
						{
							$last = ArrayMethods::last($current["children"]);
							if ($result["isolated"] && is_string($last))
							{
								array_pop($current["children"]);
							}
							$current["children"][] = array(
								"index"=>$i,
								"parent"=>&$current,
								"children"=>array(),
								"raw"=>$result["source"],
								"tag"=>$tag,
								"arguments"=>$arguments,
								"delimiter"=>$result["delimiter"],
								"number"=>sizeof($current["children"])
								);
							$current = & $current["children"][sizeof($current["children"]) - 1];
						}
						else if (isset($current["tag"]) && $result["tag"] == $current["tag"])
						{
							$start = $current["index"] + 1;
							$length = $i - $start;
							$current["source"] = implode(array_slice($array,$start, $length));
							$current = & $current["parent"];
						}
					}
					else
					{
						$current["children"][] = array(
							"index"=>$i,
							"parent"=>&$current,
							"children"=>array(),
							"raw"=>$result["source"],
							"tag"=>$tag,
							"arguments"=>$arguments,
							"delimiter"=>$result["delimiter"],
							"number"=>sizeof($current["children"])
							);
					}
				}
				else
				{
					$current["children"][] = $node;
				}
			}
			return $root;
		}
		protected function _script($tree)
		{
			$content = array();
			if (is_string($tree))
			{
				$tree = addslashes($tree);
				return "\$_text[] = \"{$tree}\";";
			}
			if (sizeof($tree["children"]) > 0)
			{
				foreach ($tree["children"] as $child)
				{
					$content[] = $this->_script($child);
				}
			}
			if (isset($tree["parent"]))
			{
				return $this->_implementation->handle($tree, implode($content));
			}
			return implode($content);
		}
		public function parse($template,$_data='',$msg=0)
		{
			if (!is_a($this->_implementation, "Mk\Template\Implementation"))
			{
				throw $this->_Exception();
			}

				$_code_ = \Mk\Tools\String::getCodes($template,'{% append', '{% /append %}', 'compile',' %}');
				//\Mk\Debug::msg(htmlentities(print_r($_code_,true)),1);
				foreach ($_code_ as $key2 => $html) {
					//echo "<hr>Append: $key2 <br> $html<hr>";
					$vcompile = new Template(array(
						"implementation" => new Template\Implementation\Extended()
					));
					$vcompile->parse($html,$_data,$msg+1);
					//echo "<hr>Append: $key2 <br> "$html"<hr>";print_r($_data);
					$html1=stripslashes($vcompile->process($_data));

					if (trim($html1)==''){
						$html1=$html;
					}
					//$html1='{% append '.$key2.' %}'.$html1. '{% /append %}';
					//\Mk\Debug::msg(htmlentities(print_r($html,true)),1);
					
					//$template = str_replace("[[code:compile:{$key2}]]",$html,$template);
					$template = str_replace("[[code:compile:{$key2}]]",$html1,$template);
				}

			$array = $this->_array($template);
			$tree = $this->_tree($array["all"]);
			$this->_code = $this->header.$this->_script($tree).$this->footer;
			try
			{	
				//\Mk\Debug::msg(htmlentities($this->code));
				//	echo "<hr>tenplate:<br> <pre>".htmlentities(print_r($this->code,true)).'</pre>';
				$this->_function = create_function("\$_data", $this->code);
			}
			catch(\Exception $e)
			{
				echo "<hr>error tenplate:<br> ";print_r($this->code);
				throw $this->_Exception($e);
				die();
			}

			

			return $this;
		}
		public function process($data = array())
		{
			//\Mk\Debug::msg($data);
			if ($this->_function == null)
			{
				throw $this->_Exception();
			}
			try
			{
				$function = $this->_function;
				return $function($data);
			}
			catch (Exception $e)
			{
				throw $this->_Exception($e);
			}
		}
	}
}

?>