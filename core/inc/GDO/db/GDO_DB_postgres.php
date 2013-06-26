<?php
final class GDO_DB_postgres extends GDO_Database
{
	public function connect($host, $user, $pass) {}
	public function setCharset($charset) {}
	public function useDatabase($db) {}
	
	public function queryRead($query) {}
	public function queryWrite($query) {}
	public function free($result) {}
	
	public function fetchRow($result) {}
	public function fetchAssoc($result) {}
	public function fetchObject($result) {}
	
	public function autoIncrement() {}
	public function insertID() {}
	public function numRows($result) {}
	public function affectedRows() {}

	public function escape($s) {}
	public function escapeIdentifier($s) {}
	
	public function tableExists($tablename) {}
	public function truncateTable($tablename) {}
	public function dropTable($tablename) {}
	public function dropColumn($tablename, $columnname) {}
	public function createTable($tablename, array $defines) {}
	public function createColumn($tablename, $columnname, array $define) {}
	public function renameTable($old_tablename, $new_tablename) {}
	public function changeColumn($tablename, $old_columnname, $new_columnname, array $define) {}
	public function lock($string, $timeout=30) { return true; }
}
?>