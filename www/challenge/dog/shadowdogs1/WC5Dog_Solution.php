<?php
require_once 'secret.php';

final class WC5Dog_Solution extends GDO
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

    public static function getSolutionBlackJack($playername)
    {
        $pname = strtolower($playername);
        $hash = substr(md5(DOG_PASSWORD.md5($pname).DOG_PASSWORD), 1, 16);
        return sprintf('%s!%s!rich', $pname, $hash);
    }

    public static function validateSolutionBJ($code)
    {
        $code = strtolower($code);
        if (false === ($playername = Common::substrUntil($code, '!', false)))
        {
            return -1;
        }
        $solution = self::getSolutionBlackJack($playername);
        if ($code !== $solution)
        {
            return 0;
        }
        $table = GDO::table(__CLASS__);
        $epname = GDO::escape($playername);
        if (false !== ($row = $table->selectFirst('1', "csl_player='$epname' AND csl_cnum=4")))
        {
            return -2;
        }
        if (false === $table->insertAssoc(array(
                'csl_player' => $playername,
                'csl_cnum' => 4,
                'csl_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
            )))
        {
            return -3;
        }
        return 1;
    }

    public static function getSolution4($playername)
	{
		$pname = strtolower($playername);
		$hash = substr(md5(DOG_PASSWORD.md5($pname).DOG_PASSWORD), 2, 16);
		return sprintf('%s!%s!magic', $pname, $hash);
	}
	
	public static function validateSolution4($code)
	{
		$code = strtolower($code);
		if (false === ($playername = Common::substrUntil($code, '!', false)))
		{
			return -1;
		}
		
		$solution = self::getSolution4($playername);
		if ($code !== $solution)
		{
			return 0;
		}
		
		$table = GDO::table(__CLASS__);
		
		$epname = GDO::escape($playername);
		if (false !== ($row = $table->selectFirst('1', "csl_player='$epname' AND csl_cnum=5")))
		{
			return -2;
		}
		
		if (false === $table->insertAssoc(array(
			'csl_player' => $playername,
			'csl_cnum' => 5,
			'csl_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		)))
		{
			return -3;
		}
		
		return 1;
	}
}
