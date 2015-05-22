<?php
/**
 * Abstract GDO Database Object.
 * Can send EMail on error.
 * A working Database Object has to implement all abstract methods.
 * A good implementation of the Database object adds timing information.
 * @see GDO_DB_mysql as an example
 * @see GDO_DB_mysql_STRUCT as an example
 * @author gizmore
 * @version 3.0
 */
abstract class GDO_Database
{
	#############
	### Debug ###
	#############
	const DEBUG = 0; # very verbose log 
	const DEBUG_PATH = 'db_query';
	
	protected $queries_writes = 0;
	protected $queries_opened = 1;
	protected $queries_closed = 1;
	
	public function getQueryWriteCount() { return $this->queries_writes; }
	public function getQueriesOpened() { return $this->queries_opened; }
	public function getQueriesClosed() { return $this->queries_closed; }
	
	private $logging = true;
	public function isLogging() { return $this->logging; }
	public function setLogging($bool) { $this->logging = $bool; }
	
	private $email = true;
	public function setEMailOnError($bool) { $this->email = $bool; }
	
	private $verbose = GWF_USER_STACKTRACE;
	public function isVerbose() { return $this->verbose === true; }
	public function setVerbose($bool) { $this->verbose = $bool; }
	
	private $die = true;
	public function setDieOnError($bool) { $this->die = $bool; }
	
	##############
	### Timing ###
	##############
	protected $query_count = 0;
	protected $query_time = 0.0;
	public function getQueryCount() { return $this->query_count; }
	public function getQueryTime() { return $this->query_time; }
	
	####################
	### DB_Connector ###
	####################
	public abstract function connect($host, $user, $pass);
	public abstract function disconnect();
	public abstract function setCharset($charset);
	public abstract function useDatabase($db);
	
	public abstract function transactionStart();
	public abstract function transactionEnd();
// 	public abstract function transactionRollback();
	
	public abstract function queryRead($query);
	public abstract function queryWrite($query);
	public abstract function free($result);
	
	public abstract function fetchRow($result);
	public abstract function fetchAssoc($result);
	public abstract function fetchObject($result);
	
	public abstract function autoIncrement($tablename);
	public abstract function insertID();
	public abstract function numRows($result);
	public abstract function affectedRows();

	public abstract function escape($s);
	public abstract function escapeIdentifier($s);
	
	public abstract function tableExists($tablename);
	public abstract function truncateTable($tablename);
	public abstract function dropTable($tablename);
	public abstract function dropColumn($tablename, $columnname);
	public abstract function createTable($tablename, array $defines);
	public abstract function createColumn($tablename, $columnname, array $define);
	public abstract function renameTable($old_tablename, $new_tablename);
	public abstract function changeColumn($tablename, $old_columnname, $new_columnname, array $define);
	
	public abstract function lock($string, $timeout=30);
	
	##############
	### Errors ###
	##############
	private function getErrorMessage($query, $errno, $error, $html=true)
	{
		$br = $html ? '<br/>' : PHP_EOL;
		$query = $html ? htmlspecialchars($query) : $query;
		return sprintf("GDO Error(%s): %s{$br}%s", $errno, $error, $query);
	}
	
	/**
	 * A database error occured.
	 * @param string $query
	 * @param int $errno
	 * @param string $error
	 */
	public function error($query, $errno, $error)
	{
		$message_html = $this->getErrorMessage($query, $errno, $error, true);
		$message_ajax = $this->getErrorMessage($query, $errno, $error, false);
		
		# Log the error.
		if ($this->isLogging() && class_exists('GWF_Log'))
		{
			GWF_Log::logCritical($message_ajax);
		}
		
		# Output error
		if (PHP_SAPI === 'cli')
		{
			file_put_contents('php://stderr', GWF_Debug::backtrace($message_ajax, false));
		}
		elseif ($this->verbose)
		{
			$message = isset($_GET['ajax']) ? $message_ajax : $message_html;
			$message = GWF_Debug::backtrace($message, !isset($_GET['ajax']));
			echo GWF_HTML::error('GDO', $message, false);
		}
		else
		{
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		# Send mail
		if ($this->email)
		{
			$this->emailOnError($message_ajax);
		}
		
		# Quit
		if ($this->die)
		{
			die(1);
		}
	}
	
	private function emailOnError($message)
	{
		if (GWF_DEBUG_EMAIL & 1)
		{
			$message = GWF_HTML::br2nl($message).PHP_EOL.PHP_EOL;
			GWF_Mail::sendDebugMail(GWF_SITENAME.': Database Error!', GWF_Debug::backtrace($message, false));
		}
	}
	
	###################
	### Convinience ###
	###################
	/**
	 * STUPID Lamb!
	 * @deprecated
	 * @param string $query
	 * @return array|false
	 */
	public function queryFirst($query)
	{
		if (false === ($result = $this->queryRead($query)))
		{
			return false;
		}
		if (false === ($row = $this->fetchAssoc($result)))
		{
			return false;
		}
		$this->free($result); 
		return $row;
	}
	
	/**
	 * STUPID WeChall!
	 * @deprecated
	 * @param string $query
	 * @return array|false
	 */
	public function queryAll($query)
	{
		if (false === ($result = $this->queryRead($query)))
		{
			return false;
		}
		$back = array();
		while (false !== ($row = $this->fetchAssoc($result)))
		{
			$back[] = $row;
		}
		$this->free($result);
		return $back;
	}
}
?>