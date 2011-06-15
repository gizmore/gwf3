<?php
final class WeChall_Stats extends GWF_Method
{
	private $user1;
	private $user2;
	private $sel;
	private $months = 0;
	
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^stats$ index.php?mo=WeChall&me=Stats'.PHP_EOL.
			'RewriteRule ^stats/([^/]+)$ index.php?mo=WeChall&me=Stats&user1=$1'.PHP_EOL.
			'RewriteRule ^stats/([^/]+)/vs/([^/]+)$ index.php?mo=WeChall&me=Stats&user1=$1&user2=$2'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
//		GWF_Website::addJavascript($module->getJSPath('wc.js'));
		require_once 'module/WeChall/WC_RegAt.php';
		
		if (false !== Common::getPost('clear')) {
			return $this->onClear($module);
		}
		if (false !== Common::getPost('display')) {
			return $this->onDisplay($module);
		}
		if (false !== Common::getPost('displayall')) {
			return $this->onDisplayAll($module, true);
		}
		if (false !== Common::getPost('displaynone')) {
			return $this->onDisplayAll($module, false);
		}
		
		return $this->templateStats($module);
	}
	
	private function setPageTitles(Module_WeChall $module)
	{
		if ($this->user1 === false) {
			GWF_Website::setPageTitle($module->lang('pt_stats', array('Unknown')));
			GWF_Website::setMetaTags($module->lang('mt_stats', array('Unknown')));
			GWF_Website::setMetaDescr($module->lang('md_stats', array('Unknown')));
			return;
		}
		
		
		$name1 = $this->user1->displayUsername();
		$name2 = $this->user2 === false ? '' : $this->user2->displayUsername();
		if ($name2 === '')
		{
			$args = array($name1);
			GWF_Website::setPageTitle($module->lang('pt_stats', $args));
			GWF_Website::setMetaTags($module->lang('mt_stats', $args));
			GWF_Website::setMetaDescr($module->lang('md_stats', $args));
		}
		else
		{
			$args = array($name1, $name2);
			GWF_Website::setPageTitle($module->lang('pt_stats2', $args));
			GWF_Website::setMetaTags($module->lang('mt_stats2', $args));
			GWF_Website::setMetaDescr($module->lang('md_stats2', $args));
		}
	}

	private function validate(Module_WeChall $module)
	{
		if (false !== ($this->user1 = GWF_User::getByName(Common::getPost('wc_stat_user1')))) {
			#nice
		}
		elseif (false === Common::getGet('user1')) {
			$this->user1 = false;
			$score1 = 0;
		}
		elseif (false === ($this->user1 = GWF_User::getByName(Common::getGet('user1', 0)))) {
			if (false === ($this->user1 = GWF_Session::getUser())) {
				GWF_Website::addDefaultOutput(GWF_HTML::err('ERR_UNKNOWN_USER'));
			}
		}
		
		if (false === ($this->user2 = GWF_User::getByName(Common::getGet('user2', 0)))) {
			if (false === ($this->user2 = GWF_User::getByName(Common::getPost('wc_stat_user2', 0)))) {
				$score2 = 0;
			}
		}
		
		if ($this->user2 !== false) {
			$score2 = $this->user2->getLevel();
		}
		
		if ($this->user1 !== false) {
			$score1 = $this->user1->getLevel();
		}

//		if ($score1 <= 0 && $score2 <= 0) {
//			return $module->error('err_graph_empty');
//		}
		
		$sel = Common::getRequest('site', false);
		if (is_array($sel) && count($sel)===0) {
			$sel = false;
		}
//		var_dump($sel);
		
		if ($sel === false) {
			$sel = $this->getSelDefault($module, false);
		}
		elseif ($sel === 'all') {
			$sel = $this->getSelDefault($module, true);
		}
		if (!is_array($sel)) {
			$sel = trim($sel);
			if ($sel !== '') {
				$sel = array(intval($sel)=>'yes');
			} else {
				$sel = array();
			}
		}
		else {
			$sel2 = array();
			foreach ($sel as $sid => $on) {
				$sel2[intval($sid)] = 'on';
			}
			$sel = $sel2;
		}
		
		$this->sel = $sel;
		
//		var_dump($sel);
		
		return false;
	}
	
	private function getSelDefault(Module_WeChall $module, $all=false)
	{
		$back = array();
		if ($this->user1 === false) {
			return $back;
		}
		
		$uid = $this->user1->getVar('user_id');
		$limit = $all === false ? 5 : -1;
		$sites = WC_Site::table('WC_RegAt')->selectColumn('regat_sid', "regat_uid=$uid", 'regat_solved DESC', NULL, $limit);
		foreach ($sites as $siteid)
		{
			$back[intval($siteid)] = 'on';
		}
		return $back;
	}
	
	private function templateStats(Module_WeChall $module)
	{
		if (false !== ($errors = $this->validate($module))) {
			return $errors;
		}
		$this->setPageTitles($module);
		
		GWF_Website::addJavascriptInline("$(document).ready(function() { wcjsStatsJQuery(); } );");
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jquery-ui-1.8.5.custom.min.js');
		GWF_Website::addCSS(GWF_WEB_ROOT.'tpl/wc4/css/ui-lightness/jquery-ui-1.8.5.custom.css');
		
		if ($this->user1 === false) {
			$form_action = GWF_WEB_ROOT.'stats';
		} else {
			$form_action = GWF_WEB_ROOT.'stats/'.$this->user1->urlencode('user_name');
		}
		
		
		$tVars = array(
			'user1' => $this->user1,
			'user2' => $this->user2,
			'form_action' => $form_action,
			'sites' => $this->getSites($module),
			'img_src' => $this->getImgSrc($module),
			'img_alt' => $this->getImgTitle($module),
			'icons' => isset($_POST['icons']),
			'values' => isset($_POST['values']),
			'zoom' => isset($_POST['zoom']),
			'months' => $this->months===0?'':$this->months,
		);
		
		return $module->templatePHP('stats.php', $tVars);
	}
	
	private function getSites(Module_WeChall $module)
	{
		$sitesLow = $sitesMed = $sitesHigh = $sitesNull = $sitesVersus = $sitesHave = array();

		if ($this->user1 !== false)
		{
			if (false === ($regats1 = WC_RegAt::getRegats($this->user1->getID()))) {
				return false;
			}
			
			foreach ($regats1 as $r)
			{
				$r instanceof WC_RegAt;
				$solved = $r->getFloat('regat_solved') * 100;
				$site = $r->getSite();
				$siteid = $site->getID(); //Var('site_id');
				if (isset($this->sel[$siteid])) {
					$site->setVar('sel', true);
				}
				if ($solved <= 0.0) { $sitesNull[] =  $site; }
				elseif ($solved < 33.3) { $sitesLow[] = $site; }
				elseif ($solved < 66.6) { $sitesMed[] = $site; }
				else { $sitesHigh[] = $site; }
				$sitesHave[] = $siteid; ##->getVar('regat_sid');
			}
		}
		
		if ($this->user2 !== false)
		{
			if (false !== ($regats2 = WC_RegAt::getRegats($this->user2->getID())))
			{
				foreach ($regats2 as $r)
				{
					$siteid = $r->getVar('regat_sid');
					$site = $r->getSite();
					if (!in_array($siteid, $sitesHave, true))
					{
						$sitesVersus[] = $r->getSite();
						$sitesHave[] = $siteid;
					}
					if (isset($this->sel[$siteid])) {
						$site->setVar('sel', true);
					}
				}
			}
		}
		
		return array(
			'high' => $sitesHigh,
			'med' => $sitesMed,
			'low' => $sitesLow,
			'null' => $sitesNull,
			'vs' => $sitesVersus,
		);
	}
	
	private function getImgSrc(Module_WeChall $module)
	{
		if ($this->user1 === false) {
			return '#';
		}
		
		$y = date('Y');
		$m = date('m');
		$d = date('d');
		$site_encode = $this->getSiteEncode();
		$months = $this->months === 0 ? '' : sprintf('.%d.month', $this->months);
		$options = array();
		if (false !== Common::getPost('icons')) {
			$options[] = 'icons';
		}
		if (false !== Common::getPost('values')) {
			$options[] = 'nums';
		}
		if (false !== Common::getPost('zoom')) {
			$options[] = 'zoom';
		}
		$options = implode(',', $options);
		$vs = $this->getVsEncode();
		$res = '.800.600';
		return GWF_WEB_ROOT.sprintf('wechall.stats%s.%04d.%02d.%02d.%s.%s%s.%s%s.jpg', $months, $y, $m, $d, $options, $site_encode, $res, $this->user1->urlencode('user_name'), $vs);
		return sprintf('#'); #wechall.stats.%04d.%02d.%02d.'');
	}
	
	private function getVsEncode()
	{
		if (false === ($this->user2)) {
			return '';
		}
		else {
			return sprintf('.vs.%s', $this->user2->urlencode('user_name'));
		}
	}
	
	private function getSiteEncode()
	{
		return implode(',', array_keys($this->sel));
//		var_dump('SITE_ENCODE');
//		var_dump($_POST);
	}
	
	private function getImgTitle(Module_WeChall $module)
	{
		return 'STUB TITLE';
	}
	

	private function getVersus()
	{
		if ('' === ($username = trim(Common::getPost('username', '')))) {
			return false;
		}
		
		if (false === ($user = GWF_User::getByName($username))) {
			return false;
		}
		
		return $user;
	}
	
	private function getMonths()
	{
		return Common::clamp(intval(Common::getPost('months', 0)), 0, 1024);
	}
	
	private function onDisplay(Module_WeChall $module)
	{
//		var_dump($_POST);

		if (!(isset($_REQUEST['site']))) {
			$_REQUEST['site'] = array();
		}
		
		$this->months = $this->getMonths();
		
		return $this->templateStats($module);
	}
	
	private function onClear(Module_WeChall $module)
	{
		$_REQUEST['site'] = array();
		return $this->onDisplay($module);
	}
	
	private function onDisplayAll(Module_WeChall $module, $bool)
	{
		if ($bool === true) {
			$_REQUEST['site'] = 'all';
		} else {
			$_REQUEST['site'] = 0;
		}
		return $this->onDisplay($module);
	}
	
}

?>