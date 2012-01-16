<?php
/**
* PHP MySQL Script by Hse.Su Team
* S Gazanchyan, A Mishenin
*/
class db
{
	var $db_host;
	var $db_username;
	var $db_password;
	var $db_name;
	var $table_prefix = "";
	var $connected;

	/**
	 * Constructor defines main variables
	 * @param	string database host
	 * @param	string database username
	 * @param	string database user password
	 * @param	string database name
	 * @param	string table name prefix
	 * @return	void
	 */
	function db($db_host, $db_username = "", $db_password = "", $db_name = "", $table_prefix = "")
	{
		$this->db_host			= $db_host;
		$this->db_username		= $db_username;
		$this->db_password		= $db_password;
		$this->db_name			= $db_name;
		$this->table_prefix		= $table_prefix;
		$this->connected		= false;
	}
	
	/**
	 * Function to connect to the database.
	 * @param	string encoding
	 * @return	boolean
	 */
	function connect($encoding = false)
	{
		if (!mysql_connect($this->db_host, $this->db_username, $this->db_password)) return false;
		if (!mysql_select_db($this->db_name)) return false;
		$this->connected = true;
		if ($encoding) {
			$this->query("set names " + $encoding);
		}
		return true;
	}
	
	/**
	 * Function to disconnect to the database.
	 */
	function disconnect()
	{
		return mysql_close();
	}
	
	/**
	 * Function to free the memory associated with the result.
	 * @param	object result
	 */
	function free($result)
	{
		return mysql_free_result($result);
	}
	
	/**
	 * Sends query to database
	 * @param	string sql
	 * @return	mysql answer
	 */
	function query($sql)
	{
		if (!$this->connected)
		{
			 return false;
		}
		if (strpos($sql, "{#}") !== false)
		{
			$sql = preg_replace('/{#}/u', $this->table_prefix, $sql);
		}
		$result = mysql_query($sql);
		return $result;
	}
	
	/**
	 * Sends query to database and returns array of first row of the results
	 * @param	string sql
	 * @return	array results
	 */
	function read($sql)
	{
		$handle = $this->query($sql);
		if (!$handle) return false;
		$result = mysql_fetch_array($handle);
		if ($row = mysql_fetch_array($handle)) return false;
		return $result;
	}
	
	/**
	 * Sends query to database and returns value of single field
	 * @param	string sql
	 * @return	string result
	 */
	function read_single($sql)
	{
		$handle = $this->query($sql);
		if (!$handle) return false;
		$result = mysql_fetch_array($handle);
		if ($row = mysql_fetch_array($handle)) return false;
		return $result[0];
	}

	
	/**
	 * Sends query to database and returns arrays of all rows of the results
	 * @param	string sql
	 * @return	array results
	 */
	function read_all($sql)
	{
		$handle = $this->query($sql);
		if (!$handle) return false;
		$result = array();
		while ($row = mysql_fetch_array($handle))
		{
			$result[] = $row;
		}
		return $result;
	}
	
	/**
	 * Checking database table existence
	 * @param	string database name
	 * @param	string table name
	 * @return	boolean
	 */
	function table_exists($db_name, $table_name)
	{
		if (!$this->connected)
		{
			$this->error("Not connected");
			return false;
		}
		$tables = $this->read_all("show tables from `{$db_name}`");
		foreach ($tables as $table)
			if ($table[0] == $table_name) return true;
		return false;

	}
	
	/**
	 * Counts rows in the table
	 * @param	string count sql
	 * @return	int
	 */
	function count($table, $where = null)
	{
		if($where === null)
		{
			$handle = $this->query($table);
			if (!$handle) return false;
		}
		else
		{
			$handle = $this->query($this->sql_count($table, $where));
			if (!$handle) return false;
		}
		$row = @mysql_fetch_array($handle);
		if (!$row) return false;
		return $row[0];
	}
	
	/**
	 * Generates sql request to count rows in the table
	 * @param	string table name
	 * @param	array selector
	 * @return	string sql
	 */
	function sql_count($table, $where)
	{
		$sql = "select count(*) from {$this->table_prefix}{$table} where " . $this->sql_where($where);
		return $sql;
	}
	
	/**
	 * Run multiquery sql requests
	 * @param	string sql
	 * @param	boolean reporting system activation
	 */
	function run($sql, $report = false)
	{
		$temp = explode(";", $sql);
		foreach ($temp as $val)
		{
			$val = trim($val);
			if (strlen($val) < 4) continue;
			$result = $this->query($val);
			if ($report)
			{
				echo $val;
				if (!$result)
				{
					echo "<br><font color=\"#ff0000\"><b>" . mysql_error() . "</b></font>";
				}
				else
				{
					echo "<br><font color=\"#00FF00\"><b>Done</b></font>";
				}

				echo "<hr>";
			}
		}
	}
	
	/**
	 * Inserts data to the database table
	 * @param	string table name
	 * @param	array data
	 * @return	boolean
	 */
	function insert($table, $data)
	{
		return $this->query($this->sql_insert($table, $data));
	}
	
	/**
	 * Generates sql request to insert data to the table
	 * @param	string table name
	 * @param	array data
	 * @return	string sql
	 */
	function sql_insert($table, $data)
	{
		$keys = array();
		foreach ($data as $key => $value) $keys[] = "`" . $key . "`";
		foreach ($data as $key => $value) if (!in_array($value, array('now()', 'null')) && !is_numeric($value)) $data[$key] = "'" . $value . "'";
		$sql = "insert into {$this->table_prefix}{$table} (" . implode(", ", $keys) . ") values (" . implode(", ", $data) . ")";
		return $sql;
	}
	
	/**
	 * Deletes data from the database table
	 * @param	string table name
	 * @param	array selector
	 * @return	boolean
	 */
	function delete($table, $where)
	{
		return $this->query($this->sql_delete($table, $where));
	}
	
	/**
	 * Generates sql request to delete data from the database table
	 * @param	string table name
	 * @param	array selector
	 * @return	string sql
	 */
	function sql_delete($table, $where)
	{
		return "delete from {$this->table_prefix}{$table} where " . $this->sql_where($where);
	}
	
	/**
	 * Updates data in the database table
	 * @param	string table name
	 * @param	array data
	 * @param	array selector
	 * @return	boolean
	 */
	function update($table, $data, $where)
	{
		return $this->query($this->sql_update($table, $data, $where));
	}
	
	/**
	 * Generates sql request to update data in the database table
	 * @param	string table name
	 * @param	array data
	 * @param	selector
	 * @return	string sql
	 */
	function sql_update($table, $data, $where)
	{
		$temp = array();
		foreach ($data as $key => $value)
		{
			if (($value != 'now()') && ($value != 'null'))
				$temp[] = "`{$key}` = '{$value}'";
			else
				$temp[] = "`{$key}` = {$value}";
		}
		$sql = "update {$this->table_prefix}{$table} set " . implode(", ", $temp) . " where " . $this->sql_where($where);
		return $sql;
	}
	
	/**
	 * Process and generates selector part of sql request to the database table
	 * @param	array selector
	 * @return	string sql
	 */
	function sql_where($where)
	{
		$sql = "1";
		foreach ($where as $key => $value)
		{
			if (strpos($value, "%") !== false)
			{
				$operator_type = "like";
				$value = "'{$value}'";
			}
			elseif(is_bool($value))
			{
				$operator_type = "= ";
			}
			elseif($value == "null" || $value == 'not null')
			{
				$operator_type = "is";
			}
			else
			{
				$operator_type = "=";
				$value = "'{$value}'";
			}
			$sql .= " and `{$key}` {$operator_type} {$value}";
		}
		return $sql;
	}
	
	/**
	 * Selects data in the database and returns array of a row of the results
	 * @param	string table name
	 * @param	array selector
	 * @param	string what to return
	 * @return	array results
	 */
	function select($table, $where, $what = '*')
	{
		return $this->read($this->sql_select($table, $where, $what));
	}
	
	/**
	 * Selects data in the database and returns the value of selected field
	 * @param	string table name
	 * @param	array selector
	 * @param	string what to return
	 * @return	array results
	 */
	function select_single($table, $where, $what = '*', $orderby = null)
	{
		return $this->read_single($this->sql_select($table, $where, $what));
	}
	
	/**
	 * Selects data in the database and returns arrays of all rows of the results
	 * @param	string table name
	 * @param	array selector
	 * @param	string order field
	 * @param	string what to return
	 * @return	array results
	 */
	function select_all($table, $where, $what = '*', $orderby = null)
	{
		return $this->read_all($this->sql_select($table, $where, $what, $orderby));
	}
	
	/**
	 * Generates sql request to select data from the database table
	 * @param	string table name
	 * @param	array selector
	 * @param	stringwhat fields to return
	 * @param	string order field
	 * @return	string sql
	 */
	function sql_select($table, $where, $what = '*', $orderby = null)
	{
		$sql = "select {$what} from {$this->table_prefix}{$table} where " . $this->sql_where($where);
		if ($orderby != null)
			$sql .= " order by ".$orderby;
		return $sql;
	}
	
	/**
	 * Gives value of next row id to insert
	 * @return	int id
	 */
	function last_id()
	{
		return mysql_insert_id();
	}
}