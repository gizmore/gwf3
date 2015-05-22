<?php
/**
 * GDO MySQL Improved Extension connector. 
 * @author gizmore
 * @version 3.00
 * @since 18.Apr.2013
 * @see GDO_DB_mysqli_STRUCT
 */
final class GDO_DB_mysqli extends GDO_Database
{
	private $link;
	
	public function connect($host, $user, $pass)
	{
		return (false !== ($this->link = mysqli_connect($host, $user, $pass)));
	}
	
	public function disconnect()
	{
		return mysqli_close($this->link);
	}
	
	public function setCharset($charset)
	{
		return $this->queryWrite("SET NAMES '{$charset}'");
	}
	
	public function useDatabase($db)
	{
		return mysqli_select_db($this->link, $db);
	}
	
	public function transactionStart()
	{
		$this->queryWrite("SET AUTOCOMMIT=0");
		$this->queryWrite("START TRANSACTION");
	}
	
	public function transactionEnd()
	{
		$this->queryWrite("COMMIT");
	}
	
// 	public function transactionRollback()
// 	{
// 		# Micro rollbacks, seriously?
// 		$this->queryWrite("ROLLBACK");
// 	}
	
	public function queryRead($query)
	{
		$t = microtime(true);
		
		if (false === ($result = mysqli_query($this->link, $query)))
		{
			$this->error($query, mysqli_errno($this->link), mysqli_error($this->link));
			return false;
		}
		
		$time = microtime(true) - $t;
		$this->query_time += $time;
		$this->query_count++;
		$this->queries_opened++;
		
		if (GDO_Database::DEBUG)
		{
			GWF_Log::rawLog(self::DEBUG_PATH, sprintf('Q#%03d(%.03fs): %s', $this->query_count, $time, $query));
		}
		
		return $result;
	}
	
	public function queryWrite($query)
	{
		if (true === $this->queryRead($query))
		{
			$this->queries_closed++;
			$this->queries_writes++;
			return true;
		}
		return false;
	}
	
	public function free($result)
	{
		$this->queries_closed++;
		return mysqli_free_result($result);
	}
	
	public function fetchRow($result)
	{
		$back = mysqli_fetch_row($result);
		return $back === NULL ? false : $back;
	}
	
	public function fetchAssoc($result)
	{
		$back = mysqli_fetch_assoc($result);
		return $back === NULL ? false : $back;
	}
	
	public function fetchObject($result)
	{
		die('NOT IMPLEMENTED: '.__METHOD__);
	}
	
	public function numRows($result)
	{
		return mysqli_num_rows($result);
	}
	
	public function affectedRows()
	{
		return mysqli_affected_rows($this->link);
	}

	public function autoIncrement($tablename)
	{
		if (false === ($result = $this->queryFirst("SHOW TABLE STATUS LIKE '{$tablename}'")))
		{
			return false;
		}
		return (int)$result['Auto_increment'];
	}
	
	public function insertID()
	{
		return mysqli_insert_id($this->link);
	}
	
	public function escape($s)
	{
		return mysqli_real_escape_string($this->link, $s);
	}
	
	public function escapeIdentifier($s)
	{
		return str_replace('`', '', $s);
	}

	public function truncateTable($tablename)
	{
		return $this->queryWrite("TRUNCATE TABLE `{$tablename}`");
	}
	
	public function tableExists($tablename)
	{
		$tablename = $this->escape($tablename);
		return $this->queryFirst("SHOW TABLES LIKE '{$tablename}'") !== false;
	}
	
	public function dropTable($tablename)
	{
		return $this->queryWrite("DROP TABLE IF EXISTS `{$tablename}`");
	}

	public function dropColumn($tablename, $columnname)
	{
		return $this->queryWrite("ALTER TABLE `{$tablename}` DROP COLUMN `{$columnname}`");
	}
	
	public function createTable($tablename, array $defines)
	{
		require_once GWF_CORE_PATH.'inc/GDO/db/GDO_DB_mysqli_STRUCT.php';
		return GDO_DB_mysqli_STRUCT::createTable($tablename, $defines);
	}
	
	public function createColumn($tablename, $columnname, array $define)
	{
		require_once GWF_CORE_PATH.'inc/GDO/db/GDO_DB_mysqli_STRUCT.php';
		return GDO_DB_mysqli_STRUCT::createColumn($tablename, $columnname, $define);
	}
	
	public function renameTable($old_tablename, $new_tablename)
	{
		require_once GWF_CORE_PATH.'inc/GDO/db/GDO_DB_mysqli_STRUCT.php';
		return GDO_DB_mysqli_STRUCT::renameTable($old_tablename, $new_tablename);
	}
	
	public function changeColumn($tablename, $old_columnname, $new_columnname, array $define)
	{
		require_once GWF_CORE_PATH.'inc/GDO/db/GDO_DB_mysqli_STRUCT.php';
		return GDO_DB_mysqli_STRUCT::changeColumn($tablename, $old_columnname, $new_columnname, $define);
	}
	
	/**
	 * Try to get a database lock.
	 * (non-PHPdoc)
	 * @param $string Lock name
	 * @see GDO_Database::lock()
	 * @return true|false
	 */
	public function lock($string, $timeout=30)
	{
		$string = self::escape($string);
		$query = "SELECT GET_LOCK('{$string}', {$timeout}) as L";
		if (false === ($result = $this->queryFirst($query)))
		{
			return false;
		}
		return $result['L'] === '1';
	}
}
?>
