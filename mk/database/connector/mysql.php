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
					case "integer":
					{
						$lines[] = "`{$name}` int(11) DEFAULT NULL";
						break;
					}
					case "decimal":
					{
						$lines[] = "`{$name}` float DEFAULT NULL";
						break;
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

*/
	}
}

?>