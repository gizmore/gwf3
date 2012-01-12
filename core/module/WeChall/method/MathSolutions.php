<?php
final class WeChall_MathSolutions extends GWF_Method
{
	const DEFAULT_BY = 'wmc_date';
	const DEFAULT_DIR = 'ASC';
	
	public function execute(GWF_Module $module)
	{
		if (false === ($chall = WC_Challenge::getByID(Common::getGetString('cid')))) {
			return $this->_module->error('err_chall');
		}
		$user = GWF_User::getStaticOrGuest();
		$token = Common::getGetString('token');
		$length = Common::clamp(Common::getGetInt('length'), 1);
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
		require_once GWF_CORE_PATH.'module/WeChall/WC_MathChall.php';
		if (!WC_ChallSolved::hasSolved($user->getID(), $chall->getID())) {
			if (!WC_MathChall::checkToken($chall, $length, $token)) {
				return $this->_module->error('err_token');
			}
		}
		
		return $this->templateSolutions($this->_module, $chall, $user, $length, $token);
	}
	
	private function templateSolutions(Module_WeChall $module, WC_Challenge $chall, GWF_User $user, $length, $token)
	{
		$tt = $this->_module->lang('pt_wmc_sol', array($chall->display('chall_title'), $length));
		GWF_Website::setPageTitle($tt);
		$ipp = 50;
		$cid = $chall->getID();
		$length = (int) $length;
		$whitelist = array('user_name', 'wmc_date', 'wmc_length', 'wmc_solution');
		$by = GDO::getWhitelistedByS(Common::getGetString('by'), self::DEFAULT_BY, $whitelist);
		$dir = GDO::getWhitelistedDirS(Common::getGetString('dir'), self::DEFAULT_DIR);
		$wmc = GWF_TABLE_PREFIX.'wc_math_chall';
		$users = GWF_TABLE_PREFIX.'user';
		$where = "wmc_cid=$cid AND wmc_length>=$length";
		$db = gdo_db();
		$result = $db->queryFirst("SELECT COUNT(*) FROM $wmc WHERE $where", false);
		$nRows = (int)$result[0];
		$nPages = GWF_PageMenu::getPagecount($ipp, $nRows);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$limit = GDO::getLimit($ipp, $from);
		$query = "SELECT user_name, wmc_date, wmc_length, wmc_solution FROM $wmc LEFT JOIN $users ON user_id=wmc_uid WHERE $where ORDER BY $by $dir $limit";
		$tVars = array(
			'sort_url' => GWF_WEB_ROOT."index.php?mo=WeChall&me=MathSolutions&cid=$cid&length=$length&token=$token&by=%BY%&dir=%DIR%",
			'data' => $db->queryAll($query),
			'page_menu' => GWF_PageMenu::display($page, $nPages, htmlspecialchars(GWF_WEB_ROOT.sprintf('index.php?mo=WeChall&me=MathSolutions&cid=%d&length=%d&token=%s&by=%s&dir=%s&page=%%PAGE%%', $cid, $length, $token, urlencode($by), urlencode($dir)))),
			'table_title' => $tt,
			'chall' => $chall,
		);
		return $this->_module->templatePHP('math_solutions.php', $tVars);
	}
}
?>