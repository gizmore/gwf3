<?php
final class WeChall_Admin extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute()
	{
		if (Common::getGet('recalc') === 'all') {
			return $this->onRecalcEverything();
		}
		
		if (false !== Common::getGet('fix_challs')) {
			return $this->onFixChalls();
		}
		if (false !== Common::getGet('fix_irc')) {
			return $this->onFixIRC();
		}
		
		if (false !== Common::getGet('chall_cache')) {
			return $this->onCacheChallTags();
		}
		
		if (false !== Common::getGet('sitetags')) {
			return $this->onCacheSiteTags();
		}
		
		if (false !== Common::getGet('remote_update')) {
			return $this->templateRemoteUpdate();
		}
		
		if (false !== Common::getPost('remote_update')) {
			return $this->onRemoteUpdate();
		}
		
		if (false !== Common::getPost('hardlink')) {
			return $this->onHardlink().$this->templateAdmin();
		}
		
		return $this->templateAdmin();
	}
	
	private function templateAdmin()
	{
		$formHardlink = $this->formHardlink();
		$tVars = array(
			'href_ddos' => $this->module->getMethodURL('SiteDDOS'),
			'href_convert' => $this->module->getMethodURL('Convert'),
			'href_update' => $this->module->getMethodURL('Admin', '&remote_update=yes'),
			'href_chall_cache' => $this->module->getMethodURL('Admin', '&chall_cache=yes'),
			'href_recalc_all' => $this->module->getMethodURL('Admin', '&recalc=all'),
			'href_sitetags' => $this->module->getMethodURL('Admin', '&sitetags=yes'),
			'href_freeze' => $this->module->getMethodURL('Freeze'),
			'href_fix_challs' => $this->module->getMethodURL('Admin', '&fix_challs=yes'),
			'href_fix_irc' => $this->module->getMethodURL('Admin', '&fix_irc=yes'),
			'form_hardlink' => $formHardlink->templateY($this->module->lang('ft_hardlink')),
			'href_siteminmail' => $this->module->getMethodURL('Admin', '&siteminmail=yes'),
		);
		return $this->module->templatePHP('admin.php', $tVars);
	}
	
	private function onCacheChallTags()
	{
		$this->module->cacheChallTags();
		return $this->module->message('msg_cached_ctags').
		$this->templateAdmin();
	}
	
	private function onCacheSiteTags()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteCats.php';
		WC_SiteCats::fixCatBits();
		$this->fixFavCats();
		return $this->templateAdmin();
	}
	
	private function fixFavCats()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_FavCats.php';
		$cats = GWF_TABLE_PREFIX.'wc_sitecat';
		$table = GDO::table('WC_FavCats');
		if (false === $table->deleteWhere("IF((SELECT 1 FROM $cats WHERE sitecat_name=wcfc_cat LIMIT 1), 0, 1)")) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$num_deleted = $table->affectedRows();
		echo GWF_HTML::message('WC', sprintf('Deleted %d invalid favcat links!', $num_deleted));
	}
	
	private function onRecalcEverything()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		
		$wc = Module_WeChall::instance();
		$wc->includeClass('WC_Warflag');
		$wc->includeClass('WC_Warflags');
		
		foreach (WC_Warbox::getAllBoxes() as $box)
		{
			$box instanceof WC_Warbox;
			$box->recalcPlayersAndScore();
			$box->recalcChallcounts();
		}
		
		WC_Site::recalcAllSites();
		WC_RegAt::calcTotalscores();
		
		return $this->templateAdmin();
	}

	private function onFixChalls()
	{
		$table = GDO::table('WC_Challenge');
		$solved = GWF_TABLE_PREFIX.'wc_chall_solved';
		
		if (false === ($challs = $table->selectObjects('*')))
//		if (false === ($challs = $table->selectAll()))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateAdmin();
		}
		
		foreach ($challs as $chall)
		{
			$chall instanceof WC_Challenge;
			if (false === $chall->saveVars(array(
				'chall_creator' => $this->fixComma($chall->getVar('chall_creator')),
				'chall_creator_name' => $this->fixComma($chall->getVar('chall_creator_name')),
				'chall_tags' => $this->fixComma($chall->getVar('chall_tags')),
			))) {
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateAdmin();
			}
		}
		
		if (false === $table->update("chall_solvecount=(SELECT COUNT(*) FROM $solved WHERE csolve_cid=chall_id AND csolve_date!='')")) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateAdmin();
		}
		
		return $this->templateAdmin();
	}
	
	private function fixComma($s)
	{
		$s = preg_replace('/[: ]/', ',', $s);
		$s = trim($s, ', ');
		$s = preg_replace('/[,]{2,}/', ',', $s);
		return ",$s,";
	}
	
	private function onFixIRC()
	{
		if (false === ($sites = GDO::table('WC_Site')->selectObjects())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateAdmin();
		}
		foreach ($sites as $site)
		{
			$site instanceof WC_Site;
			$site->saveVar('site_irc', $this->fixIRC($site->getVar('site_irc')));
		}
		return $this->templateAdmin();
	}
	
	private function fixIRC($url)
	{
		if ($url === '') {
			return '';
		}
		if (1 === preg_match('#^ircs?://#', $url)) {
			return $url;
		}
		return 'irc://'.$url;
	}
	
	################
	### Hardlink ###
	################
	private $user;
	private $site;
	public function validate_username(Module_WeChall $module, $arg)
	{
		if (false === ($this->user = GWF_User::getByName($arg))) {
			return GWF_HTML::lang('ERR_UNKNOWN_USER');
		}
		return false;
	}
	public function validate_onsitename(Module_WeChall $m, $arg)
	{
		if ($arg === '') {
			if ($this->site === false) {
				return $m->lang('err_onsitename', array('Site'));
			}
			else {
				return $m->lang('err_onsitename', array($this->site->displayName()));
			}
		}
		return false;
	}
	public function validate_percent(Module_WeChall $module, $arg)
	{
		if ( (!Common::isNumeric($arg, true)) || ($arg < 0) || ($arg > 100) ) 
		{
			return $module->lang('err_percent');
		}
		return false;
	}
	
	public function validate_site(Module_WeChall $module, $arg)
	{
		if (false === ($this->site = WC_Site::getByID($arg)))
		{
			return $this->module->lang('err_site');
		}
		return false;
	}
	private function formHardlink()
	{
		$data = array(
			'site' => array(GWF_Form::SELECT, $this->getSiteSelect(), $this->module->lang('th_site_name')),
			'username' => array(GWF_Form::STRING, '', $this->module->lang('th_user_name')),
			'onsitename' => array(GWF_Form::STRING, '', $this->module->lang('th_onsitename')),
			'percent' => array(GWF_Form::FLOAT, '0.00', $this->module->lang('th_percent')),
			'hardlink' => array(GWF_Form::SUBMIT, $this->module->lang('btn_hardlink')),
		);
		return new GWF_Form($this, $data);
	}
	private function getSiteSelect()
	{
		$data = array();
		foreach (WC_Site::getSitesRanked('site_name ASC') as $site)
		{
			$data[] = array($site->getID(), $site->getVar('site_name'));
		}
		return GWF_Select::display('site', $data, Common::getPostString('site', '0'));
	}
	private function onHardlink()
	{
		$form = $this->formHardlink();
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		$onsitename = Common::getPost('onsitename');
		
		$site = $this->site;
		$user = $this->user;
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		require_once GWF_CORE_PATH.'module/WeChall/WC_Freeze.php';
		
		if (false !== WC_RegAt::getRegatRow($user->getID(), $site->getID())) {
			return $this->module->error('err_already_linked', array($site->displayName()));
		}
		if (WC_Freeze::isUserFrozenOnSite($user->getID(), $site->getID())) {
			return $this->module->error('err_site_ban', array($site->displayName()));
		}
		if (false !== ($regat = WC_RegAt::getByOnsitename($site->getID(), $onsitename))) {
			if (false === ($user = $regat->getUser())) {
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			else {
				return $this->module->error('err_onsitename_taken', array(htmlspecialchars($onsitename), $site->displayName(), $user->displayUsername()));
			}
		}
		
		$entry = new WC_RegAt(array(
			'regat_uid' => $user->getID(),
			'regat_sid' => $site->getID(),
			'regat_onsitename' => $onsitename,
			'regat_onsitescore' => 0,
			'regat_challcount' => 0,
			'regat_options' => 0,
			'regat_lastdate' => '',
			'regat_linkdate' => GWF_Time::getDate(GWF_Date::LEN_DAY),
			'regat_solved' => 0.0,
			'regat_score' => 0,
			'regat_langid' => 0,
			'regat_tagbits' => 0,
			'regat_onsiterank' => 0,
			'regat_challsolved' => 0,
		));
		
		if (false === $entry->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (0 < ($percent = $form->getVar('percent')))
		{
			$new_score = round($site->getOnsiteScore() * $percent / 100);
			$site->onUpdateUserB($user, $entry, $new_score, true, true);
		}
		
		return $this->module->message('msg_hardlinked', array($user->displayUsername(), $site->displayName(), GWF_HTML::display($onsitename)));
	}
}

?>