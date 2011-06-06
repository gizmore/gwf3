<?php
/**
 * Get the main database object.
 * @return GDO_Database
 * @version 3.0
 */
function gdo_db()
{
	static $db;
	if (!isset($db))
	{
		$db = gdo_db_instance(GWF_DB_HOST, GWF_DB_USER, GWF_DB_PASSWORD, GWF_DB_DATABASE, GWF_DB_TYPE);
	}
	return $db;
}

/**
 * Create an instance of a database object.
 * @param string $host
 * @param string $user
 * @param string $pass
 * @param string $database
 * @param string $type
 * @param string $charset
 * @return GDO_Database
 */
function gdo_db_instance($host, $user, $pass, $database, $type='mysql', $charset='utf8')
{
	$classname = 'GDO_DB_'.$type;
	require_once 'inc/GDO/db/GDO_Database.php';
	require_once 'inc/GDO/db/'.$classname.'.php';
	$db = new $classname();
	if (false === $db->connect($host, $user, $pass, $database, $charset)) {
		return false;
	}
	if (false === $db->useDatabase($database)) {
		return false;
	}
	if (false === $db->setCharset($charset))  {
		return false;
	}
	return $db;
}

# --- GDO --- #

/**
 * A database table or row.
 * @author gizmore
 */
abstract class GDO
{
	#32 bit power :)
	# Sizes
	const TINY     = 0x00100000;
	const MEDIUM   = 0x00200000;
	const BIG      = 0x00400000;
//	const FREE_1   = 0x00800000;

	# Types
	const INT      = 0x01000000;  # No 3rd parameter.
	const DECIMAL  = 0x02000000;  # The 3rd paramater is array(DIGITS_BEFORE, DIGITS_AFTER) the comma.
	const TEXT     = 0x04000000;  # No 3rd parameter.
	const CHAR     = 0x08000000;  # The 3rd parameter is the length of the char field.

	const VARCHAR  = 0x10000000;  # The 3rd parameter is the length of the varchar field.
	const BLOB     = 0x20000000;  # No 3rd parameter.
	const ENUM     = 0x40000000;  # The 3rd parameter is an array of allowed options.
//	const MSB_BROKEN = 0x80000000;# This bit does not work on 32 bit systems. 
	
	const MESSAGE  = 0x04041001;
//	const RES_02   = 0x00000002;
//	const RES_04   = 0x00000004;
//	const RES_08   = 0x00000008;
	
	# Charsets
	const BINARY   = 0x00010000;
	const ASCII    = 0x00020000;
	const UTF8     = 0x00040000;
//	const FREE_2   = 0x00080000;
	
	const CASE_I         = 0x00001000;
	const CASE_S         = 0x00002000;
	const UNSIGNED       = 0x00004000;
	const AUTO_INCREMENT = 0x0100C400; #8
	
	# Flags
	const INDEX       = 0x00000100;
	const UNIQUE      = 0x00000200;
	const PRIMARY_KEY = 0x00000400;
//	const RES_0800    = 0x00000800;
	
	# Internal
	const JOIN      = 0x00000010;
	const OBJECT    = 0x01004020;
	const GDO_ARRAY = 0x00000040;
//	const RES_80    = 0x00000080;
	# End 32 bits
	
	
	# Combined
	const TIME = 0x01004000;
	const UINT = 0x01004000;
	const DATE = 0x08022000;
	const TOKEN = 0x08022000;
	const TINYINT = 0x01100000;
	const MEDIUMINT = 0x01200000;
	const BIGINT = 0x01400000;
	const URL = 0x04042000;
	
	# Default
	const NULL = true;
	const NOT_NULL = false;
	
	# Result Types
	const ARRAY_N = 1;
	const ARRAY_A = 2;
	const ARRAY_O = 3;
	
	# Lengths
	const URL_LENGTH = 255;
	
	protected $gdo_data;
	protected $auto_col;
	protected $primary_keys;
	
	public function __construct($data=false) { $this->gdo_data = $data; }
	public function getGDOData() { return $this->gdo_data; }
	public function setGDOData($data) { $this->gdo_data = $data; }
	public function hasVar($var) { return isset($this->gdo_data[$var]); }
	public function getVar($var) { return $this->gdo_data[$var]; }
	public function getInt($var) { return (int)$this->gdo_data[$var]; }
	public function getFloat($var) { return (double)$this->gdo_data[$var]; }
	public function setVar($var, $val) { $this->gdo_data[$var] = $val; }
	public function getEscaped($var) { return $this->escape($this->gdo_data[$var]); }
	public function display($var) { return htmlspecialchars($this->gdo_data[$var]); }
	public function urlencode($s) { return urlencode($this->getVar($s)); }
	public function urlencodeSEO($var) { return Common::urlencodeSEO($this->gdo_data[$var]); }
	
	#############
	### Magic ###
	#############
	public function __toString() { return $this->getID(); }
	
	################
	### Abstract ###
	################
	public function getID() { return $this->getVar($this->getAutoColName()); }
	public function getClassName() { return __CLASS__; }
	public function getTableName() { die('Please override GDO::getTableName() for '.$this->getClassName()); }
	public function getOptionsName() { return false; } 
	public function getColumnDefines() { return array(); }
	
	#######################
	### Default Defines ###
	#######################
	public static function getURLDefine($null=self::NULL) { return array(self::URL, $null, self::URL_LENGTH); }
	
	################
	### Escaping ###
	################
	public static function escape($s) { return gdo_db()->escape($s); }
	public static function escapeIdentifier($s) { return gdo_db()->escapeIdentifier($s); }
	
	###############
	### Options ###
	###############
	public function getOptions() { return $this->getInt($this->getOptionsName()); }
	public function isOptionEnabled($bits) { return ($this->getOptions() & $bits) === $bits; }
	public function setOption($bits, $enabled=true) { $this->setVar($this->getOptionsName(), $this->calcNewOption($bits, $enabled)); }
	public function saveOption($bits, $enabled=true) { return $this->saveVar($this->getOptionsName(), $this->calcNewOption($bits, $enabled)); }
	private function calcNewOption($bits, $enabled=true)
	{
		$bits = (int)$bits;
		$old = $this->getOptions();
		return $enabled ? $old|$bits : $old&(~$bits);
	}
	
	###################
	### Table Cache ###
	###################
	private static $GDO_TABLES = array();
	/**
	 * @param string $classname
	 * @return GDO
	 */
	public static function &table($classname)
	{
//		return new $classname(false);
		if (!isset(self::$GDO_TABLES[$classname]))
		{
			self::$GDO_TABLES[$classname] = new $classname();
		}
		return self::$GDO_TABLES[$classname];
	}
	
	public function getColumnDefcache()
	{
		return $this->getColumnDefines();
	}
	
	public function getAutoColName()
	{
		if (!isset($this->auto_col))
		{
			$this->auto_col = false;
			foreach ($this->getColumnDefcache() as $c => $d)
			{
				if ( ($d[0]&GDO::AUTO_INCREMENT) === GDO::AUTO_INCREMENT)
				{
					$this->auto_col = $c;
					break;
				}
			}
		}
		return $this->auto_col;
	}
	
	public function getPrimaryKeys()
	{
		if (!isset($this->primary_keys))
		{
			$this->primary_keys = array();
			foreach ($this->getColumnDefcache() as $c => $d)
			{
				if ( ($d[0]&GDO::PRIMARY_KEY) === GDO::PRIMARY_KEY)
				{
					$this->primary_keys[] = $c;
				}
			}
		}
		return $this->primary_keys;
	}
	
	######################
	### Table Creation ###
	######################
	/**
	 * Create this gdo table, and even drop it.
	 * @param boolean $drop
	 */
	public function createTable($drop=false)
	{
		$db = gdo_db();
		$tablename = $this->getTableName();
		if ($drop) {
			if (false === $db->dropTable($tablename)) {
				return false;
			}
		}
		return $db->createTable($tablename, $this->getColumnDefcache());
	}
	
	public function tableExists()
	{
		return gdo_db()->tableExists($this->getTableName());
	}
	
	public function truncate()
	{
		return gdo_db()->truncateTable($this->getTableName());
	}
	
	#############
	### Limit ###
	#############
	public static function getLimit($limit=-1, $from=-1)
	{
		if ($from === -1) {
			if ($limit === -1) {
				return '';
			} else {
				return " LIMIT $limit";
			}
		}
		else if ($limit === -1) {
			return " LIMIT $from,";
		}
		else {
			return " LIMIT $from,$limit";
		}
	}
	
	#################
	### Whitelist ###
	#################
	/**
	 * Filter Order direction parameter.
	 * Return a default value when failed.
	 * @param $dir string
	 * @param $default mixed
	 * @return mixed string or $default
	 */
	public static function getWhitelistedDirS($dir, $default=false)
	{
		$dir = strtoupper($dir);
		switch ($dir)
		{
			case 'ASC':
			case 'DESC': return $dir;
			default: return $default;
		}
	}
	
	public static function getWhitelistedByS($by, array $whitelist, $default)
	{
		return in_array($by, $whitelist, true) ? $by : $default;
	}
	
	public function getWhitelistedBy($by, $default=false, $nested=true)
	{
		$byp = $this->getWhitelistedByPrefix($by);
		
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			if ( ($nested) && ( (($d[0] & self::OBJECT) === self::OBJECT) || (($d[0] & self::JOIN) === self::JOIN) ) )
			{
				if (false !== self::table($d[2][0])->getWhitelistedBy($byp)) {
					return $by;
				}
			}
			elseif ($c === $byp) {
				return $by;
			}
		}
		return $default;
	}
	
	private function getWhitelistedByPrefix($by)
	{
		if (false === ($pre = Common::substrUntil($by, '.', false)))
		{
			return $by;
		}
		$cd = $this->getColumnDefcache();
		if (isset($cd[$pre])) {
			return Common::substrFrom($by, '.');
		}
		return $by;
	}
	
	public function getMultiOrderby($by, $dir, $nested=true)
	{
		$back = '';
		$by = explode(',', $by);
		$dir = explode(',', $dir);
		foreach ($by as $i => $b)
		{
			if (false === ($b = $this->getWhitelistedBy($b, false, $nested))) {
				continue;
			}
			$back .= sprintf(',%s %s', $b, self::getWhitelistedDirS($dir[$i], 'ASC'));
		}
		return $back === '' ? '' : substr($back, 1);
	}
	
	##############
	### Select ###
	##############
	public function select($columns='*', $where='', $orderby='', $joins=NULL, $limit=-1, $from=-1, $groupby='')
	{
		$db = gdo_db();
		$table = $this->getTableName();
		$join = $this->getJoins($joins);
		$where = $this->getWhere($where);
		$groupby = $this->getGroupBy($groupby);
		$orderby = $this->getOrderBy($orderby);
		$limit = self::getLimit($limit, $from);
		$query = "SELECT {$columns} FROM `{$table}` t ".$join.$where.$groupby.$orderby.$limit;
		return $db->queryRead($query);
	}

	/**
	 * Select all results from a result set.
	 * @param string $columns
	 * @param string $where
	 * @param string $orderby
	 * @param NULL|array $joins
	 * @param int $limit
	 * @param int $from
	 * @param enum $r_type
	 * @param string $groupby
	 * @return array($r_types)
	 */
	public function selectAll($columns='*', $where='', $orderby='', $joins=NULL, $limit=-1, $from=-1, $r_type=self::ARRAY_A, $groupby='')
	{
		if (false === ($result = $this->select($columns, $where, $orderby, $joins, $limit, $from, $groupby))) {
			return false;
		}
		$back = array();
		while (false !== ($row = $this->fetch($result, $r_type)))
		{
			$back[] = $row;
		}
		$this->free($result);
		return $back;
	}
	
	public function selectFirst($columns='*', $where='', $orderby='', $joins=NULL, $r_type=self::ARRAY_A, $from=-1, $groupby='')
	{
		if (false === ($result = $this->select($columns, $where, $orderby, $joins, '1', $from, $groupby))) {
			return false;
		}
		$row = $this->fetch($result, $r_type);
		$this->free($result);
		return $row;
	}
	
	public function selectFirstObject($columns='*', $where='', $orderby='', $groupby='')
	{
		return $this->selectFirst($columns, $where, $orderby, $this->getAutoJoins(), self::ARRAY_O, -1, $groupby);
	}
	
	public function fetch($result, $r_type=self::ARRAY_A)
	{
		$db = gdo_db();
		switch($r_type)
		{
			case self::ARRAY_A: return $db->fetchAssoc($result);
			case self::ARRAY_N: return $db->fetchRow($result);
			case self::ARRAY_O: return (false === ($row = $db->fetchAssoc($result))) ? false : $this->createObject($row);
			default: die("Unknown fetch() r_type: $r_type in ".__METHOD__.' line '.__LINE__);				
		}
	}
	
	public function selectVar($column, $where='', $orderby='', $joins=NULL, $groupby='')
	{
		if (false === ($result = $this->selectFirst($column, $where, $orderby, $joins, self::ARRAY_N, -1, $groupby)))
		{
			return false;
		}
		return $result[0];
	}
	
	public function selectColumn($column, $where='', $orderby='', $joins=NULL, $limit=-1, $from=-1, $groupby='')
	{
		$db = gdo_db();
		if (false === ($result = $this->select($column, $where, $orderby, $joins, $limit, $from, $groupby)))
		{
			return false;
		}
		$back = array();
		while (false !== ($row = $db->fetchRow($result)))
		{
			$back[] = $row[0];
		}
		$db->free($result);
		return $back;
	}
	
	public function selectObjects($columns='*', $where='', $orderby='', $limit=-1, $from=-1, $groupby='')
	{
		if (false === ($result = $this->select($columns, $where, $orderby, $this->getAutoJoins(), $limit, $from, $groupby)))
		{
			return false;
		}
		return $this->createObjects($result);
	}
	
	private function createObjects($result)
	{
		$db = gdo_db();
		$back = array();
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			$back[] = $this->createObject($row);
		}
		$db->free($result);
		return $back;
	}
	
	############
	### Free ###
	############
	public function free($result)
	{
		return gdo_db()->free($result);
	}
	
	###############
	### Private ###
	###############
	private function getJoins($joins)
	{
		if ($joins === NULL)
		{
			return '';
		}
		$back = '';
		foreach ($this->getColumnDefcache() as $c => $d)
		{
//			if ( ($d[0] & GDO::OBJECT) === GDO::OBJECT ) {
//				$back .= $this->getJoin($this->object2join($d[2]));
//			}
			if (in_array($c, $joins, true))
			{
				$back .= $this->getJoin($c, $d[2]);
			}
		}
		return $back;
	}
	
	private function object2join(array $valid)
	{
		$classname = array_shift($valid);
		$new_valid = array($classname);
		$otherclass = new $classname(false);
		$otherclass instanceof GDO;
		$keys = $otherclass->getPrimaryKeys();
		foreach ($keys as $i => $key)
		{
			$new_valid[] = $key;
			$new_valid[] = array_shift($valid);
		}
		return $new_valid;
	}
	
	private function getJoin($c, $valid)
	{
//		var_dump($c,$valid);
		if (is_array($valid))
		{
//			var_dump('ADDJOIN!');
			$class = self::table(array_shift($valid));
			$tablename = $class->getTableName();
			$cond = '';
			$len = count($valid);
			$i = 0;
			while ($i < $len)
			{
//				$cond .= sprintf(' AND `%s`.`%s`=`%s`.`%s`', $this->getTableName(), );
				$cond .= ' AND '.$valid[$i++].'='.$valid[$i++];
//				$cond .= ' AND '.$valid[$i++].'='.$c.'.'.$valid[$i++];
			}
			$cond = substr($cond, 5);
		}
		return " LEFT JOIN `$tablename` AS `$c` ON $cond";
	}
	
	public function createObject($row)
	{
		$classname = $this->getClassName();
		$class = new $classname($row);
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			$gdo = $d[0];
			if (($gdo&GDO::OBJECT) === GDO::OBJECT)
			{
				$class->setVar($c, new $d[2][0]($row));
			}
			elseif (($gdo&GDO::GDO_ARRAY) === GDO::GDO_ARRAY)
			{
				$class->loadGDOArray($c, $d[2], $d[3]);
			}
		}
		return $class;
	}
	
	private function loadGDOArray($c, array $map, array $joins)
	{
		$class = self::table(array_shift($map));
		$key = array_shift($map);
		$where = $this->getWhereFromArray($map);
		$gdo_map = $class->selectArrayMap('*', $where, "`{$key}` ASC", $joins, self::ARRAY_A, -1,-1, $key);
		$this->setVar($c, $gdo_map);
	}
	
	private function getWhereFromArray(array $a)
	{
		if (count($a) === 0) {
			return'';
		}
		$back = '';
		$len = count($a);
		for ($i = 0; $i < $len;)
		{
			$back .= sprintf(' AND `%s`=`%s`', $a[$i++], $a[$i++]);
		}
		return substr($back, 5);
	}
	
	private function getWhere($where)
	{
		return $where === '' ? '' : " WHERE {$where}";
	}
	
	private function getOrderBy($orderby)
	{
		return $orderby === '' ? '' : " ORDER BY {$orderby}";
	}
	
	private function getGroupBy($groupby='')
	{
		return $groupby === '' ? '' : " GROUP BY {$groupby}";
	}
	
	/**
	 * Get a where condition for this object via primary keys and object cache. 
	 */
	private function getPKWhere()
	{
		$con = array();
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			if (($d[0]&GDO::PRIMARY_KEY) === GDO::PRIMARY_KEY)
			{
				$con[] = sprintf("`%s`='%s'", $c, self::escape($this->getVar($c)));
			}
		}
		return implode(' AND ', $con);
	}
	
	##############
	### Insert ###
	##############
	/**
	 * Insert this object from it's GDO data. Auto assign INSERT ID to object cache.
	 * @see replace()
	 */
	public function insert()
	{
		return $this->replace(false);
	}
	
	/**
	 * Replace this object. Auto assign INSERT ID to object cache.
	 * Enter description here ...
	 * @param unknown_type $replace
	 */
	public function replace($replace=true)
	{
		if (false === $this->insertAssoc($this->gdo_data, $replace))
		{
			return false;
		}
		if (false !== ($col = $this->getAutoColName()))
		{
			$this->setVar($col, gdo_db()->insertID());
		}
		return true;
	}
	
	/**
	 * Insert a row.
	 * @param array $data
	 * @param boolean $replace
	 * @return boolean
	 */
	public function insertAssoc(array $data, $replace=true)
	{
		$db = gdo_db();
		$tablename = $this->getTableName();
		$keys = $vals = '';
		foreach ($data as $k => $v)
		{
			$keys .= ',`'.$k.'`';
			
			if ($v === NULL) {
				$vals .= ',NULL';
			} else {
				$vals .= ',\''.$db->escape($v).'\'';
			}
		}
		$type = $replace ? 'REPLACE' : 'INSERT';
		$query = sprintf("%s INTO `$tablename` (%s) VALUES (%s)", $type, substr($keys,1), substr($vals,1));
		return $db->queryWrite($query);
	}
	
	##############
	### Delete ###
	##############
	/**
	 * Delete this object.
	 * @return boolean
	 */
	public function delete()
	{
		return $this->deleteWhere($this->getPKWhere());
	}
	
	/**
	 * Delete from this table.
	 * @param string $where
	 * @param string $orderby
	 * @param NULL|array $joins
	 * @param int $limit
	 * @param int $from
	 * @param string $groupby
	 * @return boolean
	 */
	public function deleteWhere($where='', $orderby='', $joins=NULL, $limit=-1, $from=-1, $groupby='')
	{
		$db = gdo_db();
		$tablename = $this->getTableName();
		$join = $this->getJoins($joins);
		$where = $this->getWhere($where);
		$groupby = $this->getGroupBy($groupby);
		$orderby = $this->getOrderBy($orderby);
		$limit = self::getLimit($limit, $from);
		$query = "DELETE FROM `{$tablename}`".$join.$where.$groupby.$orderby.$limit;
		return $db->queryWrite($query);
	}
	
	############
	### Save ###
	############
	/**
	 * Save a single var and update object cache.
	 * @param string $var
	 * @param string $value
	 * @return boolean
	 */
	public function saveVar($var, $value)
	{
		return $this->saveVars(array($var => $value));
	}
	
	
	/**
	 * Save multiple vars and update object cache.
	 * @param string $var
	 * @param string $value
	 * @return boolean
	 */
	public function saveVars(array $data)
	{
		$set = '';
		foreach ($data as $k => $v)
		{
			if ($this->gdo_data[$k] !== $v)
			{
				$set .= sprintf(",`%s`='%s'", $k, $this->escape($v));
				$this->gdo_data[$k] = $v;
			}
		}
		
		return $set === '' ? true : $this->update(substr($set, 1), $this->getPKWhere(), NULL, 1);
	}

	##############
	### Update ###
	##############
	/**
	 * Table wide update.
	 * @param string $set
	 * @param string $where
	 * @param NULL|array $joins
	 * @param int $limit
	 * @param int $from
	 * @param string $groupby
	 * @return boolean
	 */
	public function update($set='', $where='', $joins=NULL, $limit=-1, $from=-1, $groupby='')
	{
		if ($set !== '')
		{
			$db = gdo_db();
			$tablename = $this->getTableName();
			$joins = $this->getJoins($joins);
			$limit = $this->getLimit($limit, $from);
			$where = $this->getWhere($where);
			$groupby = $this->getGroupBy($groupby);
			$query = "UPDATE `{$tablename}`{$joins} SET ".$set.$where.$groupby.$limit;
			return $db->queryWrite($query);
		}
		return true;
	}
	
	#############
	### Count ###
	#############
	/**
	 * A typical count rows query.
	 * @param string $where
	 * @param null|array $joins
	 * @param string $groupby
	 * @return int
	 */
	public function countRows($where='', $joins=NULL, $groupby='')
	{
		if (false === ($result = $this->selectFirst('COUNT(*)', $where, '', $joins, self::ARRAY_N, -1, $groupby))) {
			return false;
		}
		return (int)$result[0];
	}
	
	public function affectedRows()
	{
		return gdo_db()->affectedRows();
	}
	
	public function numRows($result)
	{
		return gdo_db()->numRows($result);
	}
	
	##############
	### GetRow ###
	##############
	/**
	 * Get a row by primary key(s)
	 * @param ... $pks
	 * @return GDO|false
	 */
	public function getRow()
	{
		$values = func_get_args();
		$keys = $this->getPrimaryKeys();
		if (count($keys) !== count($values) || count($keys) < 1)
		{
			return false;
		}
		$where = '';
		foreach ($keys as $i => $key) {
			$where .= sprintf(' AND `%s`=\'%s\'', $key, $this->escape($values[$i]));
		}
		$where = substr($where, 5);
		return $this->selectFirstObject('*', $where);
	}
	
	/**
	 * Get a row by single key=>value.
	 * @param string $key
	 * @param string $value
	 * @param enum $r_type
	 * @param array|null $joins
	 * @return false|array|GDO
	 */
	public function getBy($key, $value, $r_type=self::ARRAY_O, $joins=NULL)
	{
		$key = self::escapeIdentifier($key);
		$value = self::escape($value);
		return self::selectFirst('*', "`$key`='$value'", '', $joins, $r_type);
	}
	
	private function getAutoJoins()
	{
		$joins = array();
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			if ( ($d[0] & GDO::OBJECT) === GDO::OBJECT ) {
				$joins[] = $c;
			}
		}
		return count($joins) === 0 ? NULL : $joins;
	}
	
	################
	### Increase ###
	################
	public function increase($var, $inc=1)
	{
		$o = $inc >= '0' ? '+' : '';
		if (false === $this->update("`$var`=`$var`$o$inc", $this->getPKWhere(), NULL)) {
			return false;
		}
		$this->setVar($var, $this->getVar($var)+$inc);
		return true;
	}
	
	#################
	### Array Map ###
	#################
	/**
	 * Get all rows mapped to key => value pairs. The key is col0, the values are r_types.
	 * @param string $columns
	 * @param string $where
	 * @param string $orderby
	 * @param NULL|array $joins
	 * @param int $r_type
	 * @param int $limit
	 * @param int $from
	 */
	public function selectArrayMap($columns, $where='', $orderby='', $joins=NULL, $r_type=self::ARRAY_A, $limit=-1, $from=-1, $keyname=NULL, $groupby='')
	{
		if (false === ($result = $this->select($columns, $where, $orderby, $joins, $limit, $from, $groupby))) {
			return false;
		}
		$back = array();
		while (false !== ($row = $this->fetch($result, self::ARRAY_A)))
		{
			if ($keyname === NULL) {
				$key = $row[key($row)];
			} else {
				$key = $row[$keyname];
			}
			
			if ($r_type === self::ARRAY_O) {
				$back[$key] = $this->createObject($row);
			}
			else {
				$back[$key] = $row;
			}
		}
		
		$this->free($result);
		
		return $back;
	}
	
	##############
	### Random ###
	##############
	public function selectRandom($columns, $where='', $amount=1, $joins=NULL, $r_type=self::ARRAY_O, $groupby='')
	{
		return $this->selectAll($columns, $where, "RAND()", $joins, $amount, '0', $r_type, $groupby);
	}
	
	/**
	 * Get a hashcode for this row.
	 * We just append every column that is not a primary key, and calculate the hash from it.
	 * @return int
	 */
	public function getHashcode()
	{
		$hash = '';
		$cd = $this->getColumnDefcache();
		foreach ($cd as $c => $d)
		{
			$flags = (int)$d[0];
//			if (($flags & self::PRIMARY_KEY) === self::PRIMARY_KEY) {
//				continue;
//			}
			if (($flags & self::OBJECT) === self::OBJECT) {
				continue;
			}
			if (($flags & self::JOIN) === self::JOIN) {
				continue;
			}
			$hash .= '::'.$this->gdo_data[$c];
		}
//		var_dump($hash);
		return substr(md5($hash), 0, 12);
	}
	
}
?>