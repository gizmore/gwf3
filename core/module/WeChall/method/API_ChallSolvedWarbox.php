<?php
/**
 * Output who solved a chall on a warbox recently.
 * @author gizmore
 */
final class WeChall_API_ChallSolvedWarbox extends GWF_Method
{
	const MAX_OUT = 10;
	
	/**
	 * @var WC_Site
	 */
	private $site;
	
	public function execute()
	{
		$_GET['ajax'] = 1;
		header('Content-Type: text/plain');
		
		if (false === ($this->site = WC_Site::getByID(Common::getGetString('siteid'))))
		{
			return 'Unknown site for siteid.';
		}
		
		if (false === ($date = Common::getGetString('datestamp', false)))
		{
			return 'Missing parameter: datestamp.';
		}
		
		if (!GWF_Time::isValidDate($date, false, GWF_Date::LEN_SECOND))
		{
			return 'Error in parameter: datestamp.';
		}

		$amt = Common::clamp(Common::getGetInt('amt', 5), 1, self::MAX_OUT);
		
		return $this->templateOutput($date, $amt);
	}
	
	public function templateOutput($date, $amt)
	{
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_Warflags');

		$table = GDO::table('WC_Warflags');
		$joins = array('flag', 'solvers', 'flagsite', 'flagbox');
		
		if (false === ($result = $table->selectAll('user_id, wf_id, wf_solved_at, wf_solved_at, wf_attempts, 0, 0, wf_attempts, user_name, wf_title, wf_solvers, IFNULL(wf_url, wb_weburl)' , "wb_sid={$this->site->getID()} AND wf_solved_at>='{$date}'", 'wf_solved_at DESC', $joins, $amt)))
		{
			return '';
		}
		
		$back = '';
		foreach ($result as $row)
		{
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
