<?php
/**
 * Display usertable.
 * @author gizmore
 */
final class Usergroups_Users extends GWF_Method
{
	public function getHTAccess()
	{
		return 
			'RewriteRule ^users$ index.php?mo=Usergroups&me=Users'.PHP_EOL.
			'RewriteRule ^users/with/([A-Za-z]+)/page-(\d+)$ index.php?mo=Usergroups&me=Users&with=$1&page=$2'.PHP_EOL.
			'RewriteRule ^users/with/([A-Za-z]+)/by/page-(\d+)$ index.php?mo=Usergroups&me=Users&with=$1&page=$2'.PHP_EOL.
			'RewriteRule ^users/with/([A-Za-z]+)/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=Usergroups&me=Users&with=$1&by=$2&dir=$3&page=$4'.PHP_EOL;
//			'RewriteRule ^users/by/page-(\d+)$ index.php?mo=Usergroups&me=Users&page=$1'.PHP_EOL.
//			'RewriteRule ^users/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=Usergroups&me=Users&by=$1&dir=$2&page=$3'.PHP_EOL;
	}
	
	public function execute()
	{
		return $this->templateUsers();
	}
	
	public function templateUsers()
	{
		$letter = Common::getGet('with', 'All');
		$conditions = $this->getConditions($letter);
		$ipp = $this->module->cfgIPP();
		$users = GDO::table('GWF_User');
		$nUsers = $users->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nUsers);
		$page = Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);
		$by = Common::getGet('by', 'user_name');
		$dir = Common::getGet('dir', 'ASC');
		$orderby = $users->getMultiOrderby($by, $dir);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$tVars = array(
			'users' => $users->selectObjects('*', $conditions, $orderby, $ipp, $from),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'users/with/'.urlencode($letter).'/by/'.urlencode($by).'/'.urlencode($dir).'/page-%PAGE%'),
			'lettermenu' => GWF_PageMenu::displayLetterMenu($letter, GWF_WEB_ROOT.'users/with/%LETTER%/page-1'),
			'sort_url' => GWF_WEB_ROOT.'users/with/'.urlencode($letter).'/by/%BY%/%DIR%/page-1',
		);
		return $this->module->templatePHP('users.php', $tVars);
	}
	
	private function getConditions($letter)
	{
		$del = GWF_User::DELETED;
		if ($letter === 'Num') {
			return "SUBSTRING(user_name, 1, 1) BETWEEN '0' AND '9' AND user_options&$del=0";
		}
		elseif (preg_match('/^[A-Z]{1}$/D', $letter) === 1) {
			return "user_name LIKE '$letter%' AND user_options&$del=0";
		} else {
			return "user_options&$del=0";
		}
	}
}

?>
