<?php
/**
 * Output who solved a chall recently
 * @author gizmore
 */
final class WeChall_API_ChallSolved extends GWF_Method
{
	const MAX_OUT = 10;
	
	public function execute()
	{
		$_GET['ajax'] = 1;
		header('Content-Type: text/plain');
		
		if (false === ($date = Common::getGetString('datestamp', false)))
		{
			return 'Missing parameter: datestamp.';
		}
		
		if (!GWF_Time::isValidDate($date, false, GWF_Date::LEN_SECOND))
		{
			return 'Error in parameter: datestamp.';
		}

		$amt = Common::clamp(Common::getGetInt('amt', 5), 1, self::MAX_OUT);
		
		return $this->templateOutput($this->_module, $date, $amt);
	}
	
	public function templateOutput(Module_WeChall $module, $date, $amt)
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
		$table = GDO::table('WC_ChallSolved');
		
		if (false === ($result = $table->selectAll('*', "csolve_date>='{$date}'", 'csolve_date DESC', NULL, $amt)))
		{
			return '';
		}
		
		$back = '';
		foreach ($result as $row)
		{
			if (false === ($user = GWF_User::getByID($row['csolve_uid'])))
			{
				continue;
			}
			if (false === ($chall = WC_Challenge::getByID($row['csolve_cid'])))
			{
				continue;
			}
			$row['username'] = $user->getVar('user_name');
			$row['challname'] = $chall->getVar('chall_title');
			$row['solvecount'] = $chall->getVar('chall_solvecount');
			$row['curl'] = $chall->getVar('chall_url');
			$row = array_map(array(__CLASS__, 'escapeCSV'), $row);
			$back .= implode('::', $row).PHP_EOL;
		}
		return $back;
	}
	
	public static function escapeCSV($s)
	{
		return str_replace(array(':',"\n"), array('\\:', "\\\n"), $s);
	}
}
?>