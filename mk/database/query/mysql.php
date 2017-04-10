<?php
namespace Mk\Database\Query
{
	use Mk\Database as Database;
	//use Mk\Database\Exception as Exception;
	class Mysql extends Database\Query
	{
		public function all($sql='')
		{
			if ($sql==''){
				$sql = $this->_buildSelect();
			}
			
			$result = $this->connector->execute($sql);
			if ($result === false)
			{
				$error = $this->connector->lastError;
				if (DEBUG>0){$error.= "($sql)";}
				throw $this->_Exception("There was an error with your SQL query: {$error}");
			}
			$rows = array();
			for ($i = 0; $i < $result->num_rows; $i++)
			{
				$rows[] = $result->fetch_array(MYSQLI_ASSOC);
			}
			//var_dump($rows);echo "<hr>";
			return $rows;

		}

	}
}

?>