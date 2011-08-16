<?php
/**
 * Abstract GDO Database Object.
 * Can send EMail on error.
 * A working Database Object has to implement all abstract methods.
 * A good implementation of the Database object adds timing information.
 * @see GDO_DB_mysql as an example
 * @see GDO_DB_mysql_STRUCT as an example
 * @see GWF_DEBUG_EMAIL in protected/config.php
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
	
	protected $queries_opened = 1;
	protected $queries_closed = 1;
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
	public abstract function setCharset($charset);
	public abstract function useDatabase($db);
	
	public abstract function queryRead($query);
	public abstract function queryWrite($query);
	public abstract function free($result);
	
	public abstract function fetchRow($result);
	public abstract function fetchAssoc($result);
	public abstract function fetchObject($result);
	
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
	
	##############
	### Errors ###
	##############
	public function error($query, $errno, $error)
	{
		$message = sprintf("SQL Error(%s): %s<br/>\n%s<br/>\n", $errno, $error, htmlspecialchars($query));
		echo GWF_HTML::error('GDO', $message, $this->isLogging());
		if ($this->verbose)
		{
			echo GWF_Debug::backtrace($message, true);
		}
		$this->emailOnError($message);
//		die(1);
	}
	
	private function emailOnError($message)
	{
		if ( (GWF_DEBUG_EMAIL & 1) && ($this->email) )
		{
			$message = GWF_HTML::br2nl($message).PHP_EOL.PHP_EOL;
			$mail = new GWF_Mail();
			$mail->setSender(GWF_BOT_EMAIL);
			$mail->setReceiver(GWF_ADMIN_EMAIL);
			$mail->setSubject(GWF_SITENAME.': Database Error!');
			$mail->setBody(GWF_Debug::backtrace($message, false));
			$mail->sendAsText();
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