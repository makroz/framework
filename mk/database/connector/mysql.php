<?php
namespace Mk\Database\Connector
{
	use Mk\Database as Database;
	//use Mk\Database\Exception as Exception;
	class Mysql extends Database\Connector
	{
		protected $_service;
		/**
		* @readwrite
		*/
		protected $_host;
		/**
		* @readwrite
		*/
		protected $_username;
		/**
		* @readwrite
		*/
		protected $_password;
		/**
		* @readwrite
		*/
		protected $_schema;
		/**
		* @readwrite
		*/
		protected $_port = "3306";
		/**
		* @readwrite
		*/
		protected $_charset = "utf8";
		/**
		* @readwrite
		*/
		protected $_engine = "InnoDB";
		/**
		* @readwrite
		*/
		protected $_isConnected = false;
		// checks if connected to the database
		protected function _isValidService()
		{
			$isEmpty = empty($this->_service);
			$isInstance = $this->_service instanceof \MySQLi;
			if ($this->isConnected && $isInstance && !$isEmpty)
			{
				return true;
			}
			return false;
		}
		// connects to the database
		public function connect()
		{
			if (!$this->_isValidService())
			{
				$this->_service = new \MySQLi(
					$this->_host,
					$this->_username,
					$this->_password,
					$this->_schema,
					$this->_port
					);
				if ($this->_service->connect_error)
				{
					throw $this->_Exception("Unable to connect to service");
				}
				$this->isConnected = true;
			}
			return $this;
		}
		// disconnects from the database
		public function disconnect()
		{
			if ($this->_isValidService())
			{
				$this->isConnected = false;
				$this->_service->close();
			}
			return $this;
		}
		// returns a corresponding query instance
		public function query()
		{
			return new Database\Query\Mysql(array(
				"connector" =>$this
				));
		}
		// executes the provided SQL statement
		public function execute($sql)
		{
			if (!$this->_isValidService())
			{
				throw$this->_Exception("Not connected to a valid service");
			}
			//$sql=str_replace("'", "`", $sql);
			\Mk\Events::fire("mk.query.sql.after",  array('type'=>$sql));
			return $this->_service->query($sql);
		}
		// escapes the provided value to make it safe for queries
		public function escape($value)
		{
			if (!$this->_isValidService())
			{
				throw $this->_Exception("Not connected to a valid service");
			}
			return $this->_service->real_escape_string($value);
		}
		// returns the ID of the last row
		// to be inserted
		public function getLastInsertId()
		{
			if (!$this->_isValidService())
			{
				throw $this->_Exception("Not connected to a valid service");
			}
			return $this->_service->insert_id;
		}
		// returns the number of rows affected
		// by the last SQL query executed
		public function getAffectedRows()
		{
			if (!$this->_isValidService())
			{
				throw $this->_Exception("Not connected to a valid service");
			}
			return $this->_service->affected_rows;
		}
		// returns the last error of occur
		public function getLastError()
		{
			if (!$this->_isValidService())
			{
				throw $this->_Exception("Not connected to a valid service");
			}
			return $this->_service->error;
		}

		public function sync($model)
		{
			$lines = array();
			$indices = array();
			$columns = $model->columns;
			$template = "CREATE TABLE IF NOT EXISTS `%s` (\n%s,\n%s\n) ENGINE=%s DEFAULT CHARSET=%s;";
			foreach ($columns as $column)
			{
				$raw = $column["raw"];
				$name = $column["name"];
				$type = $column["type"];
				$length = $column["length"];
				if ($column["primary"])
				{
					$indices[] = "PRIMARY KEY (`{$name}`)";
				}
				if ($column["index"])
				{
					$indices[] = "KEY `{$name}` (`{$name}`)";
				}
				switch ($type)
				{
					case "autonumber":
					{
						$lines[] = "`{$name}` int(11) NOT NULL AUTO_INCREMENT";
						break;
					}
					case "text":
					{
						if ($length !== null && $length <= 255)
						{
							$lines[] = "`{$name}` varchar({$length}) DEFAULT NULL";
						}
						else
						{
							$lines[] = "`{$name}` text";
						}
						break;
					}
					case "varchar":
					{
						if ($length !== null && $length <= 255)
						{
							$lines[] = "`{$name}` varchar({$length}) DEFAULT NULL";
						}
						else
						{
							$lines[] = "`{$name}` text";
						}
						break;
					}
					case "char":
					{
						if ($length !== null && $length <= 255)
						{
							$lines[] = "`{$name}` char({$length}) DEFAULT NULL";
						}
						else
						{
							$lines[] = "`{$name}` char(1) DEFAULT NULL";
						}
						break;
					}
					case "integer":
					{
						$lines[] = "`{$name}` int(11) DEFAULT NULL";
						break;
					}
					case "int":
					{
						$lines[] = "`{$name}` int(11) DEFAULT NULL";
						break;
					}

					case "decimal":
					{

						if ($length !== null && $length <= 255)
						{
							$lines[] = "`{$name}` decimal({$length}) DEFAULT NULL";
						}
						else
						{
							$lines[] = "`{$name}` float DEFAULT NULL";
						}

					}

					case "float":
					{

						if ($length !== null && $length <= 255)
						{
							$lines[] = "`{$name}` float({$length}) DEFAULT NULL";
						}
						else
						{
							$lines[] = "`{$name}` float DEFAULT NULL";
						}

					}
					case "boolean":
					{
						$lines[] = "`{$name}` tinyint(4) DEFAULT NULL";
						break;
					}
					case "datetime":
					{
						$lines[] = "`{$name}` datetime DEFAULT NULL";
						break;
					}
				}
			}
			$table = $model->table;
			$sql = sprintf(
				$template,
				$table,
				join(",\n", $lines),
				join(",\n", $indices),
				$this->_engine,
				$this->_charset
				);
			/*$result = $this->execute("DROP TABLE IF EXISTS {$table};");
			if ($result === false)
			{
				$error = $this->lastError;
				throw $this->_Exception("There was an error in the query: {$error}");
			}*/
			$result = $this->execute($sql);
			if ($result === false)
			{
				$error = $this->lastError;
				throw $this->_Exception("There was an error in the query:($sql) {$error}");
			}
			return $this;
		}


		public function  getFields($tablename) 
		{

			$fields = array();
			$fullmatch         = "/^([^(]+)(\([^)]+\))?(\s(.+))?$/";
			$charlistmatch     = "/,?'([^']*)'/";
			$numlistmatch     = "/,?(\d+)/";

			$fieldsquery .= "DESCRIBE $tablename";
        //echo "Mario:{$fieldsquery}";
			$result_fieldsquery =$this->execute($fieldsquery);
			while ($row_fieldsquery =$result_fieldsquery->fetch_assoc()) {

           		//print_r($row_fieldsquery);
				$name     = $row_fieldsquery['Field'];
				$fields[$name] = array();
				$fields[$name]["type"]         = "";
				$fields[$name]["args"]         = array();
				$fields[$name]["add"]          = "";
				$fields[$name]["null"]        = $row_fieldsquery['Null'];
				$fields[$name]["key"]        = $row_fieldsquery['Key'];
				$fields[$name]["default"]    = $row_fieldsquery['Default'];
				$fields[$name]["extra"]        = $row_fieldsquery['Extra'];

				$fulltype     = $row_fieldsquery['Type'];
				$typeregs = array();

				if (preg_match($fullmatch, $fulltype, $typeregs)) {
					$fields[$name]["type"] = $typeregs[1];
					if ($typeregs[4]) $fields[$name]["add"] = $typeregs[4];
					$fullargs = $typeregs[2];
					$argsreg = array();
					if (preg_match_all($charlistmatch, $fullargs, $argsreg)) {
						$fields[$name]["args"] = $argsreg[1];
					} else {
						$argsreg = array();
						if (preg_match_all($numlistmatch, $fullargs, $argsreg)) {
							$fields[$name]["args"] = $argsreg[1];
                    } //else die("cant parse type args: $fullargs");
                }
            } else die("cant parse type: $fulltype");

        }

        return $fields;

    }

public function getPrimaryKeyOf($table) {
  $keys = Array();

  $query = sprintf("SHOW KEYS FROM `%s`", $table);
  $result = $this->execute($query);

  while ($row = $result->fetch_assoc()) {
    if ( $row['Key_name'] == 'PRIMARY' )
      $keys[$row['Seq_in_index'] - 1] = $row['Column_name'];
  }

  return $keys;
}

public   function getTableInformationOf($table) {
    	$information = array(
    		"auto"    => "",
    		"primary" => array(),
    		"fields"  => array()
    		);

    	$information['primary'] = $this->getPrimaryKeyOf($table);

    	$result = $this->execute("DESC `$table`");
    	while ( $field = $result->fetch_assoc() ) {
    		$information['fields'][] = $field;
    		if ( $field['Extra'] == "auto_increment" )
    			$information['auto'] = $field['Field'];
    	}

    	return $information;
    }


 public   function getColsOf($table) {
    	$information = array();
    	$result = $this->execute("DESC `$table`");
    	
    	while ( $field = $result->fetch_assoc() ) {
    		$name=$field['Field'];
    		$information[$name] = $name;
    	}

    	return $information;
    }


/*
$resultado->fetch_field_direct(1);

name 	El nombre de la columna
orgname 	El nombre original de la columna si se especificó un alias
table 	El nombre de la tabla al que pertenece el campo (si no es calculado)
orgtable 	El nombre original de la tabla si se especificó un alias
def 	El valor predeterminado de este campo, representado como una cadena
max_length 	El ancho máximo del campo del conjunto de resultados.
length 	El ancho del campo, como fue especificado en la definición de la tabla.
charsetnr 	El número del conjunto de caracteres del campo.
flags 	Un entero que representa las banderas de bits del campo.
type 	El tipo de datos usado por el campo
decimals 	El número de decimales empleados (para campos numéricos)
$mysql_data_type_hash = array(
    1=>'tinyint',
    2=>'smallint',
    3=>'int',
    4=>'float',
    5=>'double',
    7=>'timestamp',
    8=>'bigint',
    9=>'mediumint',
    10=>'date',
    11=>'time',
    12=>'datetime',
    13=>'year',
    16=>'bit',
    //252 is currently mapped to all text and blob types (MySQL 5.0.51a)
    253=>'varchar',
    254=>'char',
    246=>'decimal'
);

Data type values are:

DECIMAL           0       ENUM           247
TINY              1       SET            248
SHORT             2       TINY_BLOB      249
LONG              3       MEDIUM_BLOB    250
FLOAT             4       LONG_BLOB      251
DOUBLE            5       BLOB           252
NULL              6       VAR_STRING     253
TIMESTAMP         7       STRING         254
LONGLONG          8       GEOMETRY       255
INT24             9
DATE             10
TIME             11
DATETIME         12
YEAR             13
NEWDATE          14

the flag bits are:

NOT_NULL_FLAG          1         * Field can't be NULL 
PRI_KEY_FLAG           2         * Field is part of a primary key 
UNIQUE_KEY_FLAG        4         * Field is part of a unique key 
MULTIPLE_KEY_FLAG      8         * Field is part of a key 
BLOB_FLAG             16         * Field is a blob 
UNSIGNED_FLAG         32         * Field is unsigned 
ZEROFILL_FLAG         64         * Field is zerofill
ENUM_FLAG            256         * field is an enum 
AUTO_INCREMENT_FLAG  512         * field is a autoincrement field 
TIMESTAMP_FLAG      1024         * Field is a timestamp 


Consulta SQL: SHOW DATABASES
SQL Query: SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA
SHOW TABLES FROM nombre_bd
SHOW COLUMNS FROM alguna_tabla

 * determinar el número de campos del resultset *
    $field_cnt = $result->field_count;


function getPrimaryKeyOf($table) {
  $keys = Array();

  $query = sprintf("SHOW KEYS FROM `%s`", $table);
  $result = mysql_query($query) or die(mysql_error());

  while ($row = mysql_fetch_assoc($result)) {
    if ( $row['Key_name'] == 'PRIMARY' )
      $keys[$row['Seq_in_index'] - 1] = $row['Column_name'];
  }

  return $keys;
}

// Returns a bunch of information about a table...
// The name of the auto-increment field, if any, fields in the
// primary key (using the function above), and all information
// about all fields.
function getTableInformationOf($table) {
  $information = array(
      "auto"    => "",
      "primary" => array(),
      "fields"  => array()
    );

  $information['primary'] = $this->getPrimaryKeyOf($table);

  $result = mysql_query("DESC `$table`");
  while ( $field = mysql_fetch_assoc($result) ) {
    $information['fields'][] = $field;
    if ( $field['Extra'] == "auto_increment" )
      $information['auto'] = $field['Field'];
  }

  return $information;
}

function mysql_table_exists($dbLink, $database, $tableName)
{
   $tables = array();
   $tablesResult = mysql_query("SHOW TABLES FROM $database;", $dbLink);
   while ($row = mysql_fetch_row($tablesResult)) $tables[] = $row[0];
    if (!$result) {
    }
   return(in_array($tableName, $tables));
}

function mysql_table_exists($table, $link)
{
     $exists = mysql_query("SELECT 1 FROM `$table` LIMIT 0", $link);
      if ($exists) return true;
     return false;
}


 function getdbsize($tdb) {
    $db_host='localhost';
    $db_usr='USER';
    $db_pwd='XXXXXXXX';
    $db = mysql_connect($db_host, $db_usr, $db_pwd) or die ("Error connecting to MySQL Server!\n");
    mysql_select_db($tdb, $db);

    $sql_result = "SHOW TABLE STATUS FROM " .$tdb;
    $result = mysql_query($sql_result);
    mysql_close($db);

    if($result) {
        $size = 0;
        while ($data = mysql_fetch_array($result)) {
             $size = $size + $data["Data_length"] + $data["Index_length"];
        }
        return $size;
    }
    else {
        return FALSE;
    }
  }
$tmp = getdbsize("DATABASE_NAME");
  if (!$tmp) { echo "ERROR!"; }
  else { echo $tmp; }



  // Si las comillas mágicas están habilitadas
echo $_POST['apellido'];             // O\'reilly
echo addslashes($_POST['apellido']); // O\\\'reilly

// Uso en todas las versiones de PHP
if (!get_magic_quotes_gpc()) {
    $apellido = addslashes($_POST['apellido']);
}
else {
    $apellido = $_POST['apellido'];
}

// Si se está usando MySQL
$apellido = mysql_real_escape_string($apellido);

echo $apellido; // O\'reilly
$sql = "INSERT INTO apellidos (apellido) VALUES ('$apellido')";






// Strip magic quotes from request data.
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    // Create lamba style unescaping function (for portability)
    $quotes_sybase = strtolower(ini_get('magic_quotes_sybase'));
    $unescape_function = (empty($quotes_sybase) || $quotes_sybase === 'off') ? 'stripslashes($value)' : 'str_replace("\'\'","\'",$value)';
    $stripslashes_deep = create_function('&$value, $fn', '
        if (is_string($value)) {
            $value = ' . $unescape_function . ';
        } else if (is_array($value)) {
            foreach ($value as &$v) $fn($v, $fn);
        }
    ');
   
    // Unescape data
    $stripslashes_deep($_POST, $stripslashes_deep);
    $stripslashes_deep($_GET, $stripslashes_deep);

    $stripslashes_deep($_COOKIE, $stripslashes_deep);
    $stripslashes_deep($_REQUEST, $stripslashes_deep);
***

if(  
            (  function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()  )
             || (  ini_get('magic_quotes_sybase') && ( strtolower(ini_get('magic_quotes_sybase')) != "off" )  )
           ){
            foreach($_GET as $k => $v) $_GET[$k] = stripslashes($v);
            foreach($_POST as $k => $v) $_POST[$k] = stripslashes($v);
            foreach($_COOKIE as $k => $v) $_COOKIE[$k] = stripslashes($v);
        }

        ****
        When you work with forms and databases you should use this concept:

1.When inserting the user input in DB escape $_POST/$_GET with add_slashes() or similar (to match the speciffic database escape rules)

$query='INSERT INTO users SET fullname="'.add_slashes($_POST['fullname']).'"';
insert_into_db($query);

2.When reading a previously submitted input from DB use html_special_chars to display an escaped result!

read_db_row('SELECT fullname FROM users');
echo '<input type="text" name="fullname" value="'.html_special_chars($db_row['fullname']).'" />

this way you safely store and work with the original(unescaped) data.

*****

$pp='o\'hara\ab\n\a\"asas"{aa}///';	
echo "Prueba 1: $pp";
$user = new \User(array(
				"first" => $pp,
				"last" => $pp,
				"email" => '1',
				"password" => $pp
				));
				$user->save();
$pp=$this->database->escape($pp);
$this->database->execute("insert into user (first,last,email,password) values ('$pp','$pp','11','$pp')");
//echo "insert into `user` (`first`,`last`,`email`,`password`) values (`$pp`,`$pp`,`11`,`$pp`)";
//echo "insert into `user` (`first`,`last`,`email`,`password`) values (`$pp`,`$pp`,`11`,`$pp`)";
$pp=$_GET['name'];
echo "<br>Prueba 2: $pp";
$user = new \User(array(
				"first" => $pp,
				"last" => $pp,
				"email" => '2',
				"password" => $pp
				));
				$user->save();
				$pp=$this->database->escape($pp);
$this->database->execute("insert into user (first,last,email,password) values ('$pp','$pp','22','$pp')");
Inputs::_escape_request();
$pp=$_GET['name'];
echo "<br>Prueba 3: $pp";
$user = new \User(array(
				"first" => $pp,
				"last" => $pp,
				"email" => '3',
				"password" => $pp
				));
				$user->save();
				$pp=$this->database->escape($pp);
$this->database->execute("insert into user (first,last,email,password) values ('$pp','$pp','33','$pp')");



*/



}
}

?>