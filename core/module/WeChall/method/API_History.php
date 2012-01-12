<?php
final class WeChall_API_History extends GWF_Method
{
	const DEFAULT_LIMIT = 20;
	const MAX_LIMIT_ALL = 50;
	const MAX_LIMIT_SINGLE = 20;
	private static $masterKeys = array(
		'WeLikeWeChall', # gizmore
		'YashiraFTW!',   # Yashira
	);
	
	private $user = false;
	private $site = false;
	private $limit = 20;
	private $time = false;
	
//	public function getHTAccess()
//	{
//		return
////			'^api/history/([^/]+)$ index.php?mo=WeChall&me=API_History&username=$1&no_session=true'.PHP_EOL.
////			'^api/history/([^/]+)/([^/]+)$ index.php?mo=WeChall&me=API_History&username=$1&sitename=$2&no_session=true'.PHP_EOL.
////			'^api/history$ index.php?mo=WeChall&me=API_History&no_session=true'.PHP_EOL;
//	}

	public function execute()
	{
		$_GET['ajax'] = 1;
		GWF_Website::plaintext();
		
		if (false !== ($error = $this->sanitize())) {
			die ($error);
		}

		die($this->history());
	}
	
	private function sanitize()
	{
		if (false === Common::getGet('no_session')) {
			return 'The mandatory parameter \'no_session\' is not set. Try \'&no_session=1\'.';
		}
		
		# Validate Date
		if (false !== ($date = Common::getGet('datestamp')))
		{
			if (GWF_Time::isValidDate($date, false, GWF_Date::LEN_SECOND))
			{
				$this->time = GWF_Time::getTimestamp($date);
			}
		}
		
		# Validate username
		if (false !== ($username = Common::getGet('username')))
		{
			if (false === ($this->user = GWF_User::getByName($username))) {
				return GWF_HTML::err('ERR_UNKNOWN_USER');
			}
			if (false !== ($error = $this->_module->isExcludedFromAPI($this->user, Common::getGet('password')))) {
				return $error;
			}
		}
		
		# Validate sitename
		if (false !== ($sitename = Common::getGet('sitename')))
		{
			if ( (false === ($this->site = WC_Site::getByName($sitename))) && (false === ($this->site = WC_Site::getByClassName($sitename))) ) {
				return $this->_module->error('err_site');
			}
		}

		# Validate Limit
		if (in_array(Common::getGet('masterkey'), self::$masterKeys))
		{
			$max_limit = PHP_INT_MAX;
		}
		elseif ( ($this->user === false) && ($this->site === false) )
		{
			$max_limit = self::MAX_LIMIT_ALL;
		}
		else
		{
			$max_limit = self::MAX_LIMIT_SINGLE;
		}
		$this->limit = Common::clamp(Common::getGet('limit', self::DEFAULT_LIMIT), 1, $max_limit);
		
		
//		if (!isset($no_block))
//		{
//			require_once 'core/module/WeChall/WC_API_Block.php';
//			if (WC_API_Block::isBlocked())
//			{
//				return $this->_module->error('err_api_block');
//			}
//		}
		
		return false;
	}
	
	private function history()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_HistoryUser2.php';
		$conditions = array();
		if ($this->user !== false) {
			$conditions[] = 'userhist_uid='.$this->user->getVar('user_id');
		} else {
			$conditions[] = 'userhist_options&'.WC_HistoryUser2::NO_XSS.'=0'; 
		}
		if ($this->site !== false) {
			$conditions[] = 'userhist_sid='.$this->site->getVar('site_id');
		}
		if ($this->time !== false) {
			$conditions[] = "userhist_date>=$this->time";
		}
		
//		var_dump($conditions);
		
		$conditions = implode(' AND ', $conditions);
		$users = GWF_TABLE_PREFIX.'user';
		$sites = GWF_TABLE_PREFIX.'wc_site';
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$query =
			"SELECT userhist_date, userhist_type, user_name, site_name, ".
			"regat_onsitename, userhist_onsiterank, userhist_onsitescore, site_maxscore, userhist_percent, userhist_gain_perc, ".
			"userhist_totalscore, userhist_gain_score, userhist_options, regat_options ".
			"FROM ".GWF_TABLE_PREFIX.'wc_user_history2 '.
			"INNER JOIN $users ON user_id=userhist_uid ".
			"INNER JOIN $sites ON site_id=userhist_sid ".
			"INNER JOIN $regat ON regat_uid=userhist_uid AND regat_sid=userhist_sid ".
			"WHERE $conditions ".
			"ORDER BY userhist_date DESC ".
			"LIMIT ".$this->limit;
		$db = gdo_db();
		
		if (false === ($result = $db->queryRead($query))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		$back = '';
		while (false !== ($entry = $db->fetchRow($result)))
		{
			$back = $this->outputEntry($entry) . $back;
		}
		$db->free($result);
		
		return $back;
	}
	
	private function escapeCSV($string)
	{
		return str_replace(array(':', "\n"), array('\\:', "\\\n"), $string);
	}
	
	private function outputEntry(array $entry)
	{
		$priv_hist = ($entry[12] & 0x01) === 0x01;
		$hide_uname = ($entry[13] & 0x01) === 0x01;
		$unknown = GWF_HTML::lang('unknown');
//		'EventDatestamp::EventType::<br/>'.
//		'WeChallUsername::Sitename::<br/>'.
//		'OnSiteName::OnSiteRank::OnSiteScore::MaxOnSiteScore::OnSitePercent::GainOnsitePercent::<br/>'.
//		'Totalscore::GainTotalscore<br/>'.
		return
			($priv_hist ? $unknown : GWF_Time::getDate(GWF_Date::LEN_SECOND, $entry[0])) .'::'.
			$entry[1].'::'.
			$this->escapeCSV($entry[2]).'::'.
			$this->escapeCSV($entry[3]).'::'.
			($hide_uname ? $unknown : $this->escapeCSV($entry[4])).'::'.
			$entry[5].'::'.
			$entry[6].'::'.
			$entry[7].'::'.
			sprintf('%.02f%%', $entry[8]/100).'::'.
			sprintf('%.02f%%', $entry[9]/100).'::'.
			$entry[10].'::'.
			$entry[11]."\n";
	}
}
?>