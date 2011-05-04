<?php
final class WC_MathChall extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_math_chall'; }
	public function getColumnDefines()
	{
		return array(
			'wmc_id' => array(GDO::AUTO_INCREMENT),
			'wmc_cid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'wmc_uid' => array(GDO::OBJECT, 0, array('GWF_User', 'wmc_uid', 'user_id')),
			'wmc_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'wmc_length' => array(GDO::UINT, GDO::NOT_NULL),
			'wmc_solution' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
		);
	}
	
	public static function insertSolution($cid, $uid, $solution)
	{
		$table = self::table(__CLASS__);
		
		$cid = (int)$cid;
		$uid = (int)$uid;
		$esol = $table->escape($solution);
		if (false !== ($table->selectFirst("wmc_cid=$cid AND wmc_uid=$uid AND wmc_solution='$esol'"))) {
			return true;
		}
		return $table->insertAssoc(array(
			'wmc_id' => 0,
			'wmc_cid' => $cid,
			'wmc_uid' => $uid,
			'wmc_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'wmc_length' => strlen($solution),
			'wmc_solution' => $solution,
		));
	}
	
	public static function calcToken(WC_Challenge $chall, $length)
	{
		$rand = $chall->getVar('chall_token');
		$challid = $chall->getVar('chall_title');
		return md5($rand.$challid.$rand.$length.$rand.$challid.$rand);
	}
	
	public static function checkToken(WC_Challenge $chall, $length, $token)
	{
		return self::calcToken($chall, $length) === $token;
	}
	
	public static function getLimitedHREF(WC_Challenge $chall, $length)
	{
		$challid = $chall->getVar('chall_id');
		$token = self::calcToken($chall, $length);
		return GWF_WEB_ROOT.'index.php?mo=WeChall&me=MathSolutions&cid='.$challid.'&length='.$length.'&token='.$token;
	}
}
?>