<?php
final class GDO_DB_mysql extends GDO_Database
{
	private $link;
	
	public function connect($host, $user, $pass)
	{
		if (false === ($this->link = mysql_connect($host, $user, $pass))) {
			return false;
		}
		return true;
	}
	
	public function useDatabase($db)
	{
		if (false === mysql_select_db($db, $this->link)) {
			return false;
		}
		return true;
	}
	
	public function setCharset($charset)
	{
		if (false === $this->queryWrite("SET NAMES '$charset'")) {
			return false;
		}
		return true;
		
	}
	
	public function queryRead($query)
	{
		$t = microtime(true);
		
		if (false === ($result = mysql_query($query, $this->link))) {
			$this->error($query, mysql_errno($this->link), mysql_error($this->link));
			return false;
		}
		
		$time = microtime(true) - $t;
		$this->query_time += $time;
		$this->query_count++;
		$this->queries_opened++;

		if (GDO_Database::DEBUG) {
			GWF_Log::log(self::DEBUG_PATH, sprintf('Q#%03d(%.03fs): %s', $this->query_count, $time, $query), true);
		}
		
		return $result;
	}
	
	public function queryWrite($query)
	{
		if (true === $this->queryRead($query)) {
			$this->queries_closed++;
			return true;
		}
		return false;
	}
	
	public function free($result)
	{
		$this->queries_closed++;
		return mysql_free_result($result);
	}
	
	public function fetchRow($result)
	{
		return mysql_fetch_row($result);
	}
	
	public function fetchAssoc($result)
	{
		return mysql_fetch_assoc($result);
	}
	
	public function fetchObject($result)
	{
		die('NOT IMPLEMENTED: '.__METHOD__);
	}
	
	public function numRows($result)
	{
		return mysql_num_rows($result);
	}
	
	public function affectedRows()
	{
		return mysql_affected_rows($this->link);
	}

	public function insertID()
	{
		return mysql_insert_id($this->link);
	}
	
	public function escape($s)
	{
		return mysql_real_escape_string($s, $this->link);
	}
	
	public function escapeIdentifier($s)
	{
		return str_replace('`', '', $s);
	}

	public function truncateTable($tablename)
	{
		return $this->queryWrite("TRUNCATE TABLE `$tablename`");
	}
	
	public function tableExists($tablename)
	{
		$tablename = $this->escape($tablename);
		return $this->queryFirst("SHOW TABLES LIKE '$tablename'") !== false;
	}
	
	public function dropTable($tablename)
	{
		return $this->queryWrite("DROP TABLE IF EXISTS `$tablename`");
	}

	public function dropColumn($tablename, $columnname)
	{
		return $this->queryWrite("ALTER TABLE `$tablename` DROP COLUMN `$columnname`");
	}
	
	public function createTable($tablename, array $defines)
	{
		require_once GWF_CORE_PATH.'inc/GDO/db/GDO_DB_mysql_STRUCT.php';
		return GDO_DB_mysql_STRUCT::createTable($tablename, $defines);
	}
	
	public function createColumn($tablename, $columnname, array $define)
	{
		require_once GWF_CORE_PATH.'inc/GDO/db/GDO_DB_mysql_STRUCT.php';
		return GDO_DB_mysql_STRUCT::createColumn($tablename, $columnname, $define);
	}
	
	public function renameTable($old_tablename, $new_tablename)
	{
		require_once GWF_CORE_PATH.'inc/GDO/db/GDO_DB_mysql_STRUCT.php';
		return GDO_DB_mysql_STRUCT::renameTable($old_tablename, $new_tablename);
	}
	
	public function changeColumn($tablename, $old_columnname, $new_columnname, array $define)
	{
		require_once GWF_CORE_PATH.'inc/GDO/db/GDO_DB_mysql_STRUCT.php';
		return GDO_DB_mysql_STRUCT::changeColumn($tablename, $old_columnname, $new_columnname, $define);
	}
	
	/**
	 * Try to get a lock.
	 * @return boolean true or false
	 * */
	public function lock($string)
	{
		$string = self::escape($string);
		$timeout = 30;
		$query = "SELECT GET_LOCK('$string', $timeout) as L";
		if (false === ($result = $this->queryFirst($query)))
		{
			return false;
		}
		return $result['L'] === '1';
	}
}
?>