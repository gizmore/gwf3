<?php
final class GDO_DB_mysql_STRUCT
{
	public static function createTable($tablename, array $defines)
	{
		$db = GDO::getCurrentDB();
		$col_def = self::getColumnDefines($tablename, $defines);
		$query = "CREATE TABLE IF NOT EXISTS `$tablename` ($col_def) ENGINE=".GWF_DB_ENGINE;
		return $db->queryWrite($query);
	}
	
	public static function createColumn($tablename, $columname, array $define)
	{
		$col_def = self::getColumnDefine($tablename, $columname, $define);
		$query = "ALTER TABLE `$tablename` ADD COLUMN $col_def";
		return GDO::getCurrentDB()->queryWrite($query);
	}
	
	public static function renameTable($old_tablename, $new_tablename)
	{
		$query = "RENAME TABLE `$old_tablename` TO `$new_tablename`";
		return GDO::getCurrentDB()->queryWrite($query);
	}
	
	public static function changeColumn($tablename, $old_columnname, $new_columnname, array $define)
	{
		$col_def = self::getColumnDefineB($tablename, $old_columnname, $define);
#		print ("ALTER TABLE `$tablename` CHANGE COLUMN `$old_columnname` `$new_columnname` $col_def");
		return GDO::getCurrentDB()->queryWrite("ALTER TABLE `$tablename` CHANGE COLUMN `$old_columnname` `$new_columnname` $col_def");
	}
	
	private static function getColumnDefines($tablename, array $defines)
	{
		$back = array();
		foreach ($defines as $c => $d)
		{
			if (false !== ($def = self::getColumnDefine($tablename, $c, $d)))
			{
				$back[] = $def;
			}
		}
		
		# Indexes
		$pks = array();
		$have_auto = false;
		foreach ($defines as $c => $d)
		{
			if ($d[0] & GDO::INDEX)
			{
				$back[] = "INDEX(`{$c}`)";
			}
			elseif ($d[0] & GDO::PRIMARY_KEY)
			{
				$pks[] = "`{$c}`";
			}
			elseif ( ($d[0] & GDO::AUTO_INCREMENT) === GDO::AUTO_INCREMENT )
			{
				$have_auto = true;
				$pks[] = "`{$c}`";
			}
		}
		
		# PK
		if ($have_auto && count($pks) !== 1)
		{
			die(sprintf(__FILE__.' : table `%s` has an auto_increment column but more primary keys!', $tablename).PHP_EOL);
		}
		
		if (count($pks) > 0)
		{
			$back[] = 'PRIMARY KEY('.implode(',',$pks).')';
		}
		
		return implode(', ', $back);
	}
	
	private static function getColumnDefine($tablename, $columname, array $define)
	{
		if (false === ($define = self::getColumnDefineB($tablename, $columname, $define)))
		{
			return false;
		}
		return "`$columname` $define";
	}
	
	private static function getColumnDefineB($tablename, $columname, array $define)
	{
		$type = $define[0];
		$autoinc = (($type & GDO::AUTO_INCREMENT)===GDO::AUTO_INCREMENT) ? ' AUTO_INCREMENT' : '';
		$unique = $type & GDO::UNIQUE ? ' UNIQUE' : '';
		$unsigned = '';
		$charset = '';
		$default = self::getDefaultDefine( (isset($define[1]) ? $define[1] : true) );
		
// 		if (($type & GDO::INDEX) === GDO::INDEX)
// 		{
// 			return false;
// 		}
		
		if ($type & GDO::INT)
		{
			$def = self::getIntDefine($type);
			$unsigned = self::getUnsigned($type);
		}
		elseif ($type & GDO::DECIMAL)
		{
			if (!isset($define[2]) || !is_array($define[2]) || count($define[2]) !== 2)
			{
				die(sprintf(__FILE__.' : Table `%s` has an invalid 3rd parameter for decimal column `%s`. Try array(digits,digits).', $tablename, $columname));
			}
			$def = self::getDecimalDefine($define[2]);
		}
		elseif ( ($type & GDO::CHAR) || ($type & GDO::VARCHAR) )
		{
			if (!isset($define[2]) || $define[2] < 1)
			{
				die(sprintf(__FILE__.' : Table `%s` is missing 3rd parameter in column `%s`', $tablename, $columname).PHP_EOL);
			}
			
			if (false === ($charset = self::getCharsetDefine($type)))
			{
				die(sprintf(__FILE__.' : Table `%s` has no charset for column `%s`', $tablename, $columname).PHP_EOL);
			}
			
			if ($type & GDO::CHAR)
			{
				$def = "CHAR($define[2])";
			}
			else
			{
				$def = "VARCHAR($define[2])";
			}
		}
		elseif ($type&GDO::TEXT)
		{
			if ( (false === ($charset = self::getCharsetDefine($type))) )
			{
				die(sprintf(__FILE__.' : Table `%s` has no charset for column `%s`', $tablename, $columname).PHP_EOL);
			}
			$def = self::getTextDefine($type);
		}
		elseif ($type&GDO::ENUM)
		{
			if (!isset($define[2]) || !is_array($define[2]) || count($define[2])===0)
			{
				die(sprintf(__FILE__.' : Table `%s` has no valid enums in column `%s`', $tablename, $columname).PHP_EOL);
			}
			$def = self::getEnumDefine($type, $define[2]);
		}
		elseif ($type&GDO::BLOB)
		{
			$def = self::getBlobDefine($type);
		}
		elseif ($type&GDO::JOIN)
		{
			return false;
		}
		elseif ($type&GDO::GDO_ARRAY)
		{
			return false;
		}
		else
		{
			die(sprintf(__FILE__.' : Table `%s` column `%s` has an unknown type: %08x', $tablename, $columname, $type).PHP_EOL);
		}
		
		return " $def$unsigned$charset$default$autoinc$unique";
	}
	
	private static function getEnumDefine($type, array $enums)
	{
		$e = "'".implode("','", $enums)."'";
		return "ENUM($e)";
	}

	private static function getUnsigned($type)
	{
		return $type & GDO::UNSIGNED ? ' UNSIGNED' : '';
	}
	
	private static function getIntDefine($type)
	{
		if ($type & GDO::TINY) { return 'TINYINT(3)'; }
		elseif ($type & GDO::MEDIUM) { return 'MEDIUMINT(5)'; }
		elseif ($type & GDO::BIG) { return 'BIGINT(20)'; }
		else { return 'INT(10)'; }
	}
	
	private static function getDecimalDefine($valid)
	{
		$a = $valid[0]+$valid[1];
		$b = $valid[1];
		return "DECIMAL($a,$b)";
	}
	
	private static function getBlobDefine($type)
	{
		return self::getTextBlobSizedDefine($type, 'BLOB');
	}

	private static function getTextDefine($type)
	{
		return self::getTextBlobSizedDefine($type, 'TEXT');
	}
	
	private static function getTextBlobSizedDefine($type, $t)
	{
		if ($type & GDO::TINY) { return 'TINY'.$t; }
		elseif ($type & GDO::MEDIUM) { return 'MEDIUM'.$t; }
		elseif ($type & GDO::BIG) { return 'LONG'.$t; }
		else { return $t; }
	}

	private static function getDefaultDefine($default)
	{
		if ($default === true) { return ''; }
		elseif ($default === false) { return ' NOT NULL'; }
		else { return " NOT NULL DEFAULT '$default'"; }
	}
	
	private static function getCharsetDefine($type)
	{
		if ($type & GDO::BINARY)
		{
			return ' CHARACTER SET binary';
		}
		elseif ($type & GDO::ASCII)
		{
			if ($type & GDO::CASE_I) { return ' CHARACTER SET ascii COLLATE ascii_general_ci'; }
			elseif ($type & GDO::CASE_S) { return ' CHARACTER SET ascii COLLATE ascii_bin'; }
			else { return false; }
		}
		elseif ($type & GDO::UTF8)
		{
			if ($type & GDO::CASE_I) { return ' CHARACTER SET utf8 COLLATE utf8_general_ci'; }
			elseif ($type & GDO::CASE_S) { return ' CHARACTER SET utf8 COLLATE utf8_bin'; }
			else { return false; }
		}
		else
		{
			return false;
		}
	}
}
?>
