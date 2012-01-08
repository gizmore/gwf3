<?php
require_once 'secret.php';

final class WC5Lamb_Solution extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'chall_shadowlamb_1'; }
	public function getColumnDefines()
	{
		return array(
			'csl_player' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
			'csl_cnum' => array(GDO::UINT, GDO::NOT_NULL),
			'csl_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
		);
	}
	public static function getSolution1($playername)
	{
		$hash = substr(md5(md5($playername).LAMB_PASSWORD2), 2, 16);
		return sprintf('%s!%s!wisdom', $playername, $hash);
	}
	
	/**
	 * Validate a code.
	 * Mark code as used ticket.
	 * Return 1 on success validated.
	 * Return 0 on wrong.
	 * Return -1 on format error.
	 * Return -2 on duplicate user.
	 * Return -3 on DB error.
	 * @param GWF_User $user
	 * @param string $code
	 * @return int
	 */
	public static function validateSolution1($code, $uid)
	{
		$code = strtolower($code);
		if (false === ($playername = Common::substrUntil($code, '!', false)))
		{
			return -1;
		}
		
		$solution = self::getSolution1($playername);
		if ($code !== $solution)
		{
			return 0;
		}
		
		$table = GDO::table(__CLASS__);
		
		$epname = GDO::escape($playername);
		if (false !== ($row = $table->selectFirst('1', "csl_player='$epname' AND csl_cnum=1")))
		{
			return -2;
		}
		
		if ($uid > 0)
		{
			if (false === $table->insertAssoc(array(
				'csl_player' => $playername,
				'csl_cnum' => 1,
				'csl_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			)))
			{
				return -3;
			}
		}
		
		return 1;
	}
	
	public static function getSolution2($playername)
	{
		$hash = substr(md5(md5(md5($playername).LAMB_PASSWORD2)), 3, 16);
		return $playername.':'.str_replace(array('0','1','2','3','4','5','6','7','8','9'),  array('g','h','i','j','k','l','m','n','o','p'), $hash);
	}
	public static function validateSolution2($code)
	{
		$code = strtolower($code);
		if (false === ($playername = Common::substrUntil($code, ':', false)))
		{
			return -1;
		}
		
		$solution = self::getSolution2($playername);
		if ($code !== $solution)
		{
			return 0;
		}
		
		$table = GDO::table(__CLASS__);
		
		$epname = GDO::escape($playername);
		if (false !== ($row = $table->selectFirst('1', "csl_player='$epname' AND csl_cnum=2")))
		{
			return -2;
		}
		
		if (false === $table->insertAssoc(array(
			'csl_player' => $playername,
			'csl_cnum' => 2,
			'csl_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		)))
		{
			return -3;
		}
		
		return 1;
	}
	
	

	public static function getSolution3($playername)
	{
		$hash = substr(md5(LAMB_PASSWORD2.md5($playername).LAMB_PASSWORD2), 2, 16);
		return sprintf('%s!%s!gunda', $playername, $hash);
	}
	public static function validateSolution3($code)
	{
		$code = strtolower($code);
		if (false === ($playername = Common::substrUntil($code, ':', false)))
		{
			return -1;
		}
		
		$solution = self::getSolution2($playername);
		if ($code !== $solution)
		{
			return 0;
		}
		
		$table = GDO::table(__CLASS__);
		
		$epname = GDO::escape($playername);
		if (false !== ($row = $table->selectFirst('1', "csl_player='$epname' AND csl_cnum=2")))
		{
			return -2;
		}
		
		if (false === $table->insertAssoc(array(
			'csl_player' => $playername,
			'csl_cnum' => 2,
			'csl_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		)))
		{
			return -3;
		}
		
		return 1;
	}
}
?>