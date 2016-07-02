<?php
/**
 * Get the main database object.
 * @return GDO_Database
 * @version 3.0
 */

global $SINGLE_GDO_DB;
$SINGLE_GDO_DB = null;

function gdo_db()
{
	global $SINGLE_GDO_DB;
	if ($SINGLE_GDO_DB === null)
	{
		if (false !== ($SINGLE_GDO_DB = gdo_db_instance(GWF_DB_HOST, GWF_DB_USER, GWF_DB_PASSWORD, GWF_DB_DATABASE, GWF_DB_TYPE)))
		{
			GDO::setCurrentDB($SINGLE_GDO_DB);
		}
	}
	return $SINGLE_GDO_DB;
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
	require_once GWF_CORE_PATH.'inc/GDO/db/GDO_Database.php';
	require_once GWF_CORE_PATH.'inc/GDO/db/'.$classname.'.php';
	
	$db = new $classname();
	
	if (false === $db->connect($host, $user, $pass, $database, $charset))
	{
		return false;
	}
	
	if (false === $db->useDatabase($database))
	{
		return false;
	}
	
	if (false === $db->setCharset($charset))
	{
		return false;
	}
	
	return $db;
}

# --- GDO --- #

/**
 * A GDO object is both, a table and a row. Values are treated as string by default.
 * @author gizmore
 */
abstract class GDO
{
	###################
	### 32 GDO Bits ###
	###################
	const TINY     = 0x00100000;
	const MEDIUM   = 0x00200000;
	const BIG      = 0x00400000;
//	const NOT_NULL = 0x00800000;  # Added in GWF4

	const INT      = 0x01000000;  # No 3rd parameter.
	const DECIMAL  = 0x02000000;  # 3rd parameter is array(DIGITS_BEFORE, DIGITS_AFTER) the comma.
	const TEXT     = 0x04000000;  # No 3rd parameter.
	const CHAR     = 0x08000000;  # 3rd parameter is number of chars.

	const VARCHAR  = 0x10000000;  # 3rd parameter is number of chars.
	const BLOB     = 0x20000000;  # No 3rd parameter.
	const ENUM     = 0x40000000;  # 3rd parameter is an array of options.
//	const MSB_BROKEN = 0x80000000;# This bit does not work on 32 bit systems. 

	const MESSAGE  = 0x04041001;
//	const RES_02   = 0x00000002;  # Reserved for GWF5
//	const RES_04   = 0x00000004;  # Reserved for GWF5
//	const RES_08   = 0x00000008;  # Reserved for GWF5

	
	const BINARY   = 0x00010000;
	const ASCII    = 0x00020000; # TODO: should be obsolete/default and Free3
	const UTF8     = 0x00040000; # TODO: means to use GDO charset
//	const FREE_2   = 0x00080000; # Free1

	const CASE_I         = 0x00001000;
	const CASE_S         = 0x00002000;
	const UNSIGNED       = 0x00004000;
	const AUTO_INCREMENT = 0x0100C400;
	
	const INDEX       = 0x00000100;
	const UNIQUE      = 0x00000200;
	const PRIMARY_KEY = 0x00000400;
//	const RES_0800    = 0x00000800; # Free2

	const JOIN      = 0x00000010;
	const OBJECT    = 0x01004020;
	const GDO_ARRAY = 0x00000040;
//	const RES_80    = 0x00000080; # Reserved

	#####################
	### Combined Bits ###
	#####################
	const TIME = 0x01004000;
	const UINT = 0x01004000;
	const DATE = 0x08022000;
	const TOKEN = 0x08022000;
	const TINYINT = 0x01100000;
	const MEDIUMINT = 0x01200000;
	const BIGINT = 0x01400000;
	const UTINYINT = 0x01104000;
	const UMEDIUMINT = 0x01204000;
	const UBIGINT = 0x01404000;
	const URL = 0x04042000;
	
	#########################
	### GDO default value ###
	#########################
	const NULL = true; 
	const NOT_NULL = false;

	####################
	### Result Types ###
	####################
	const ARRAY_N = 1; # numeric 
	const ARRAY_A = 2; # associative
	const ARRAY_O = 3; # object
	
	# Lengths
	const URL_LENGTH = 255;
	
	protected $gdo_data;
// 	protected $auto_col;
// 	protected $primary_keys;
	
	public function __construct($data=NULL) { $this->gdo_data = $data; }
	public function getGDOData() { return $this->gdo_data; }
	public function setGDOData($data) { $this->gdo_data = $data; }
	public function hasVar($var) { return isset($this->gdo_data[$var]); }
	public function getVar($var) { return $this->gdo_data[$var]; }
	public function getInt($var) { return (int)$this->gdo_data[$var]; }
	public function getFloat($var) { return (double)$this->gdo_data[$var]; }
	public function setVar($var, $val) { $this->gdo_data[$var] = $val; }
	public function unsetVar($var) { unset($this->gdo_data[$var]); }
	public function setVars(array $data) { $this->gdo_data = array_merge($this->gdo_data, $data); }
	public function getEscaped($var) { return $this->escape($this->gdo_data[$var]); }
	public function display($var) { return htmlspecialchars($this->gdo_data[$var]); }
	public function urlencode($s) { return urlencode($this->getVar($s)); }
	public function urlencode2($s) { return urlencode(urlencode($this->getVar($s))); }
	public function urlencodeSEO($var) { return Common::urlencodeSEO($this->gdo_data[$var]); }
	public function getVarDefault($var, $default) { return isset($this->gdo_data[$var]) ? $this->gdo_data[$var] : $default; }
	
	#############
	### Magic ###
	#############
	public function __toString() { return $this->getID(); }
	
	################
	### Abstract ###
	################
	public function getID() { return $this->getVar($this->getAutoColName()); }
	public function getClassName() { return __CLASS__; }
	public function getTableName() { die('Please override GDO::getTableName() for '.$this->getClassName().PHP_EOL); }
	public function getOptionsName() { return 'options'; } 
	public function getColumnDefines() { return array(); }
	
	#######################
	### Default Defines ###
	#######################
	public static function getURLDefine($null=self::NULL) { return array(self::URL, $null, self::URL_LENGTH); }
	
	################
	### Escaping ###
	################
	public static function escape($s) { return self::$CURRENT_DB->escape($s); }
	public static function escapeIdentifier($s) { return self::$CURRENT_DB->escapeIdentifier($s); }
	
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

	############################
	### Multi DB connections ###
	############################
	/**
	 * @var GDO_DB_mysql
	 */
	private static $CURRENT_DB = NULL;
	public static function setCurrentDB(GDO_Database $db)
	{
		self::$CURRENT_DB = $db;
		self::$GDO_TABLES = array();
	}
	public static function getCurrentDB()
	{
		return self::$CURRENT_DB;
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
// 		if (!isset($this->auto_col))
// 		{
// 			$this->auto_col = false;
			foreach ($this->getColumnDefcache() as $c => $d)
			{
				if ( ($d[0]&self::AUTO_INCREMENT) === self::AUTO_INCREMENT)
				{
					return $c; #$this->auto_col = $c;
// 					break;
				}
			}
			return false;
// 		}
// 		return $this->auto_col;
	}
	
	public function getPrimaryKeys()
	{
// 		if (!isset($this->primary_keys))
// 		{
// 			$this->primary_keys = array();
			$back = array();
			foreach ($this->getColumnDefcache() as $c => $d)
			{
				if ( ($d[0]&self::PRIMARY_KEY) === self::PRIMARY_KEY)
				{
// 					$this->primary_keys[] = $c;
					$back[] = $c;
				}
			}
			return $back;
// 		}
// 		return $this->primary_keys;
	}
	
	#######################
	### Column Creation ###
	#######################
	public function createColumn($key)
	{
		$d = $this->getColumnDefines();
		return gdo_db()->createColumn($this->getTableName(), $key, $d[$key]);
	}
	
	public function changeColumn($old_columnname, $new_columnname, $define)
	{
		return gdo_db()->changeColumn($this->getTableName(), $old_columnname, $new_columnname, $define);
	}
	
	public function dropColumn($columnname)
	{
		return gdo_db()->dropColumn($this->getTableName(), $columnname);
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
		$db = self::$CURRENT_DB;
		$tablename = $this->getTableName();
		if ( ($drop) && (false === $db->dropTable($tablename)) )
		{
			return false;
		}
		return $db->createTable($tablename, $this->getColumnDefcache());
	}
	
	public function dropTable()
	{
		return self::$CURRENT_DB->dropTable($this->getTableName());
	}
	
	public function tableExists()
	{
		return self::$CURRENT_DB->tableExists($this->getTableName());
	}
	
	public function truncate()
	{
		return self::$CURRENT_DB->truncateTable($this->getTableName());
	}
	
	public function enumExists($field, $enum)
	{
		$data = $this->getColumnDefines();
		return isset($data[$field]) ? in_array($enum, $data[$field][2]) : false;
	}
	
	#############
	### Limit ###
	#############
	public static function getLimit($limit=-1, $from=-1)
	{
		$limit = (int)$limit;
		$from = (int)$from;
		if ($from === -1)
		{
			if ($limit === -1)
			{
				return '';
			}
			else
			{
				return " LIMIT {$limit}";
			}
		}
		else if ($limit === -1)
		{
			return " LIMIT {$from},";
		}
		else
		{
			return " LIMIT {$from},{$limit}";
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
	
	public function getWhitelistedBy($by, $default=false, $nested=true, array &$whitelist=NULL)
	{
		if ( ($whitelist !== NULL) && (self::getWhitelistedByS($by, $whitelist, 0) !== 0) )
		{
			return $by;
		}
		
		$byp = $this->getWhitelistedByPrefix($by);
		
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			if ($c === $byp)
			{
				return $by;
			}
			elseif ( ($nested === true) && ( (($d[0] & self::OBJECT) === self::OBJECT) || (($d[0] & self::JOIN) === self::JOIN) ) )
			{
				if (false !== self::table($d[2][0])->getWhitelistedBy($byp))
				{
					return $by;
				}
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
		if (true === isset($cd[$pre]))
		{
			return Common::substrFrom($by, '.');
		}
		return $by;
	}
	
	public function getMultiOrderby($by, $dir, $nested=true, array &$whitelist=NULL)
	{
		# Fix Information Disclosure (thx dloser)
		# Admins cannot sort by emails anymore in some modules, but meh. Security first (thx dloser)
		if (in_array($by, array('user_email', 'user_password', 'user_birthdate')))
		{
			return '';
		}
		
		$back = '';
		$by = explode(',', $by);
		$dir = explode(',', $dir);
		foreach ($by as $i => $b)
		{
			if (false !== ($b = $this->getWhitelistedBy($b, false, $nested, $whitelist)))
			{
				$back .= sprintf(',%s %s', $b, self::getWhitelistedDirS($dir[$i], 'ASC'));
			}
		}
		return $back === '' ? '' : substr($back, 1);
	}
	
	##############
	### Select ###
	##############
	public function select($columns='*', $where='', $orderby='', $joins=NULL, $limit=-1, $from=-1, $groupby='')
	{
		$table = $this->getTableName();
		$join = $this->getJoins($joins);
		$where = $this->getWhere($where);
		$groupby = $this->getGroupBy($groupby);
		$orderby = $this->getOrderBy($orderby);
		$limit = self::getLimit($limit, $from);
		$query = "SELECT {$columns} FROM `{$table}` t ".$join.$where.$groupby.$orderby.$limit;
// 		echo "$query<br/>\n";
// 		GWF_Website::addDefaultOutput("$query<br/>\n");
		return self::$CURRENT_DB->queryRead($query);
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
		if (false === ($result = $this->select($columns, $where, $orderby, $joins, $limit, $from, $groupby)))
		{
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
		if (false === ($result = $this->select($columns, $where, $orderby, $joins, '1', $from, $groupby)))
		{
			return false;
		}
		$row = $this->fetch($result, $r_type);
		$this->free($result);
		return $row;
	}
	
	public function selectFirstObject($columns='*', $where='', $orderby='', $groupby='', $joins=true)
	{
		if ($joins === true)
		{
			$joins = $this->getAutoJoins();
		}
		return $this->selectFirst($columns, $where, $orderby, $joins, self::ARRAY_O, -1, $groupby);
	}
	
	/**
	 * Fetch a row from a result set with a specified type. Type can be a GDO classname too.
	 * @param resource $result
	 * @param enum $r_type
	 * @return GDO|array|false
	 */
	public function fetch($result, $r_type=self::ARRAY_A)
	{
		$db = self::$CURRENT_DB;
		switch($r_type)
		{
			case self::ARRAY_A: return $db->fetchAssoc($result);
			case self::ARRAY_N: return $db->fetchRow($result);
			case self::ARRAY_O: return (false === ($row = $db->fetchAssoc($result))) ? false : $this->createObject($row);
			default: return (false === ($row = $db->fetchAssoc($result))) ? false : $this->createObject($row, $r_type);
		}
	}
	
	/**
	 * Select a single var, the first column, from a result set.
	 * @param string $column
	 * @param string $where
	 * @param string $orderby
	 * @param NULL|array $joins
	 * @param string $groupby
	 */
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
		$db = self::$CURRENT_DB;
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
		$db = self::$CURRENT_DB;
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
		return self::$CURRENT_DB->free($result);
	}
	
	###############
	### Private ###
	###############
	private function getJoins($joins=NULL, $type='LEFT JOIN')
	{
		$back = '';
		if ($joins !== NULL)
		{
			// TODO: Merge the loops
			foreach ($this->getColumnDefcache() as $c => $d)
			{
				if (in_array($c, $joins, true))
				{
					$back .= $this->getJoin($c, $d[2], $type);
				}
			}
			
			// TODO: Merge the loops
			foreach ($joins as $i => $join)
			{
				if (is_array($join))
				{
					$back .= $this->getJoin('join_'.$i, $join, $type);
				}
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
	
	private function getJoin($c, $valid, $type='LEFT JOIN')
	{
		if (is_array($valid))
		{
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
		return " {$type} `{$tablename}` AS `{$c}` ON {$cond}";
	}
	
	public function createObject($row, $classname=true)
	{
		$classname = is_string($classname) ? $classname : $this->getClassName();
		$class = new $classname($row);
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			$gdo = $d[0];
			if (($gdo&self::OBJECT) === self::OBJECT)
			{
				$class->setVar($c, new $d[2][0]($row));
			}
			elseif (($gdo&self::GDO_ARRAY) === self::GDO_ARRAY)
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
		if (count($a) === 0)
		{
			return '';
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
		return $where === '' ? '' : ' WHERE '.$where;
	}
	
	private function getOrderBy($orderby)
	{
		return $orderby === '' ? '' : ' ORDER BY '.$orderby;
	}
	
	private function getGroupBy($groupby)
	{
		return $groupby === '' ? '' : ' GROUP BY '.$groupby;
	}
	
	/**
	 * Get a where condition for this object via primary keys and object cache. 
	 */
	private function getPKWhere()
	{
		$con = array();
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			if (($d[0]&self::PRIMARY_KEY) === self::PRIMARY_KEY)
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
	 * @param boolean $replace
	 */
	public function replace($replace=true)
	{
		if (false === $this->insertAssoc($this->gdo_data, $replace))
		{
			return false;
		}
		if (false !== ($col = $this->getAutoColName()))
		{
			$this->setVar($col, (string)self::$CURRENT_DB->insertID());
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
		$db = self::$CURRENT_DB;
		$tablename = $this->getTableName();
		$keys = $vals = '';
		foreach ($data as $k => $v)
		{
			$keys .= ',`'.$k.'`';
			$vals .= $v === NULL ? ',NULL' : ',\''.$db->escape($v).'\'';
		}
		$type = $replace ? 'REPLACE' : 'INSERT';
		$query = sprintf("%s INTO `{$tablename}` (%s) VALUES (%s)", $type, substr($keys,1), substr($vals,1));
//		echo $query."<br/>\n";
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
		$db = self::$CURRENT_DB;
		$tablename = $this->getTableName();
		$join = $this->getJoins($joins, 'INNER JOIN');
		$where = $this->getWhere($where);
		$groupby = $this->getGroupBy($groupby);
		$orderby = $this->getOrderBy($orderby);
		$limit = self::getLimit($limit, $from);
		$query = "DELETE t.* FROM `{$tablename}` t".$join.$where.$groupby.$orderby.$limit;
		return $db->queryWrite($query);
	}
	
	############
	### Save ###
	############
	/**
	 * Update this row with a custom SET clause.
	 * @param string $set
	 * @return boolean
	 */
	public function updateRow($set)
	{
		$table = $this->getTableName();
		$where = $this->getPKWhere();
		$query = "UPDATE `{$table}` SET {$set} WHERE {$where} LIMIT 1";
		return self::$CURRENT_DB->queryWrite($query);
	}
	
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
				$this->gdo_data[$k] = $v;
				$v = $v === NULL ? 'NULL' : '\''.$this->escape($v).'\'';
				$set .= sprintf(",`%s`=%s", $k, $v);
			}
		}
		return $set === '' ? true : $this->update(substr($set, 1), $this->getPKWhere(), NULL);
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
			$tablename = $this->getTableName();
			$joins = $this->getJoins($joins);
			$limit = $this->getLimit($limit, $from);
			$where = $this->getWhere($where);
			$groupby = $this->getGroupBy($groupby);
			$query = "UPDATE `{$tablename}`{$joins} SET ".$set.$where.$groupby.$limit;
			return self::$CURRENT_DB->queryWrite($query);
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
		$field = $groupby === '' ? '1' : 'DISTINCT(`'.self::escapeIdentifier($groupby).'`)'; 
		if (false === ($result = $this->selectFirst("COUNT($field)", $where, '', $joins, self::ARRAY_N)))
		{
			return false;
		}
		return (int)$result[0];
	}
	
	public function affectedRows()
	{
		return self::$CURRENT_DB->affectedRows();
	}
	
	public function numRows($result)
	{
		return self::$CURRENT_DB->numRows($result);
	}
	
	public function autoIncrement()
	{
		return self::$CURRENT_DB->autoIncrement($this->getTableName());
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
		if ( (count($keys) !== count($values)) || (count($keys) < 1) )
		{
			return false;
		}
		
		$where = '';
		foreach ($keys as $i => $key)
		{
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
	public function getBy($key, $value, $r_type=self::ARRAY_O, $joins=NULL, $orderby='')
	{
		$key = self::escapeIdentifier($key);
		$value = self::escape($value);
		return self::selectFirst('*', "`{$key}`='{$value}'", $orderby, $joins, $r_type);
	}
	
	private function getAutoJoins()
	{
		$joins = array();
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			if ( ($d[0]&self::OBJECT) === self::OBJECT )
			{
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
		$o = $inc >= 0 ? '+' : '';
		if (false === $this->update("`{$var}`=`{$var}`{$o}{$inc}", $this->getPKWhere(), NULL))
		{
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
	 * @see GDO::selectMatrix2D
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
		if (false === ($result = $this->select($columns, $where, $orderby, $joins, $limit, $from, $groupby)))
		{
			return false;
		}
		
		$back = array();
		
		$r_type2 = $r_type === self::ARRAY_N ? self::ARRAY_N : self::ARRAY_A;
		
		while (false !== ($row = $this->fetch($result, $r_type2)))
		{
			$key = $keyname === NULL ? $row[key($row)] : $row[$keyname];
			$back[$key] = $r_type === self::ARRAY_O ? $this->createObject($row) : $row;
		}
		
		$this->free($result);
		
		return $back;
	}
	
	/**
	 * Get an associatve array $col1 => $col2.
	 * @see GDO::selectArrayMap
	 * @param string $col1
	 * @param string $col2
	 * @param string $where
	 * @param string $orderby
	 * @param array|NULL $joins
	 * @param int $limit
	 * @param int $from
	 * @param string $groupby
	 */
	public function selectMatrix2D($col1, $col2, $where='', $orderby='', $joins=NULL, $limit=-1, $from=-1, $groupby='')
	{
		if (false === ($result = $this->select("{$col1}, {$col2}", $where, $orderby, $joins, $limit, $from, $groupby)))
		{
			return false;
		}
		$back = array();
		while (false !== ($row = $this->fetch($result, self::ARRAY_N)))
		{
			$back[$row[0]] = $row[1];
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
//			if (($flags & self::PRIMARY_KEY) === self::PRIMARY_KEY)
// 			{
//				continue;
//			}
			if (($flags & self::OBJECT) === self::OBJECT)
			{
				continue;
			}
			if (($flags & self::JOIN) === self::JOIN)
			{
				continue;
			}
//			echo "$c is ".$this->gdo_data[$c].'<br/>'.PHP_EOL;
			$hash .= '::'.$c.'::'.$this->gdo_data[$c];
		}
//		var_dump($hash);
		return substr(md5($hash.GWF_SECRET_SALT), 0, 12);
	}
	
	public function lock($string)
	{
		return self::$CURRENT_DB->lock($string);
	}

	/**
	 * Return all column names but exclude those in the params.
	 * @deprecated
	 * @param array $exclusive
	 * @return array
	 */
	public function getColumnNamesExclusive(array $exclusive)
	{
		$back = array();
		foreach ($this->getColumnDefcache() as $c => $d)
		{
			if (false === in_array($c, $exclusive, true))
			{
				$back[] = $c;
			}
		}
		return $back;
	}
}
?>
