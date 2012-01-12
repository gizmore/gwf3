<?php

final class WeChall_WeChallSettings extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^wechall_settings$ index.php?mo=WeChall&me=WeChallSettings'.PHP_EOL.
			'RewriteRule ^favorite_sites/remove/(\d+)$ index.php?mo=WeChall&me=WeChallSettings&remove=$1'.PHP_EOL;
	}
	
//	public function getHTAccess()
//	{
//		return
//			'RewriteRule ^favorite_sites/remove/(\d+)$ index.php?mo=WeChall&me=FavoriteSites&remove=$1'.PHP_EOL.
//			'RewriteRule ^favorite_sites$ index.php?mo=WeChall&me=FavoriteSites'.PHP_EOL.
//			'RewriteRule ^favorite_sites/by/([^/]+)/([DEASC,]+)$ index.php?mo=WeChall&me=FavoriteSites&by=$1&dir=$2'.PHP_EOL;
//	}

	public function execute()
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteFavorites.php';
		require_once GWF_CORE_PATH.'module/WeChall/WC_FavCats.php';
		
		if (false !== (Common::getPost('add_fav'))) {
			return $this->onMarkFavorite().$this->templateFavSites($this->_module);
		}
		
		if (false !== Common::getPost('add_favcat')) {
			return $this->onAddFavCat().$this->templateFavSites($this->_module);
		}
		
		if (false !== ($sid = Common::getPost('quickjump'))) {
			return $this->onQuickjump($this->_module, $sid);
		}
		
		if (false !== Common::getPost('set_settings')) {
			return $this->onSetSettings();
		}
		
		if (false !== ($cat = Common::getGetString('remcat', false))) {
			return $this->onRemFavCat($this->_module, $cat).$this->templateFavSites();
		}
		
		if (false !== ($sid = Common::getGet('remove'))) {
			return $this->onRemoveFavorite($this->_module, $sid).$this->templateFavSites();
		}
		
		return
			$this->templateFavSites();
	}

	#################
	### Fav Sites ###
	#################
	private function templateFavSites()
	{
		$userid = GWF_Session::getUserID();
		$form = $this->getForm($this->_module, $userid);
		$form_favcat = $this->getFormFavcat($this->_module, $userid);
		$tVars = array(
			'form' => $form->templateX($this->_module->lang('ft_favsites')),
			'favsites' => WC_SiteFavorites::getFavoriteSites($userid),
			'form_cat' => $form_favcat->templateX($this->_module->lang('ft_favcats')),
			'favcats' => WC_FavCats::getFavCats($userid),
//			'sort_url' => GWF_WEB_ROOT.'favorite_sites/by/%BY%/%DIR%',
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=WeChall&me=WeChallSettings',
		);
		return $this->_module->templatePHP('site_favorites.php', $tVars).$this->templateWeChallSettings();
	}

	private function getForm(Module_WeChall $module, $userid)
	{
		$data = array(
			'favsite' => array(GWF_Form::SELECT, $this->getSelect($this->_module, $userid), $this->_module->lang('th_sel_favsite')), 
			'add_fav' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add_favsite')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getFormFavcat(Module_WeChall $module, $userid)
	{
		$data = array(
			'favcat' => array(GWF_Form::SELECT, $this->getFavcatSelect($this->_module, $userid), $this->_module->lang('th_cat')),
			'add_favcat' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add_favcat')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getFavcatSelect(Module_WeChall $module, $userid)
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteCats.php';
		if (false === ($cats = WC_SiteCats::getAllCats())) {
			return '';
		}
		$data = array(array('0', $this->_module->lang('th_sel_favcat')));
		foreach ($cats as $cat)
		{
			$cat = htmlspecialchars($cat);
			$data[] = array($cat, $cat);
		}
		return GWF_Select::display('favcat', $data, '0');
	}
	
	private function getSelect(Module_WeChall $module, $userid)
	{
		$data = array(array('0', $this->_module->lang('th_sel_favsite')));
		$sites = WC_SiteFavorites::getNonFavoriteSites($userid);
		foreach ($sites as $site)
		{
			$data[] = array($site->getID(), $site->getVar('site_name'));
		}
		return GWF_Select::display('favsite', $data, '0');
	}
	
	private $site;
	public function validate_favsite(Module_WeChall $module, $arg)
	{
		if (false === ($this->site = WC_Site::getByID($arg))) {
			return $this->_module->lang('err_site');
		}
		return false;
	}
	
	private function onMarkFavorite()
	{
		$userid = GWF_Session::getUserID();
		$form = $this->getForm($this->_module, $userid);
		if (false !== ($err = $form->validate($this->_module))) {
			return $err;
		}
		
		WC_SiteFavorites::setFavorite($userid, $this->site->getID(), true);

		return $this->_module->message('msg_marked_fav', array($this->site->displayName()));
	}

	private function onRemoveFavorite(Module_WeChall $module, $sid)
	{
		if (false === ($site = WC_Site::getByID($sid))) {
			return $this->_module->error('err_site');
		}
		
		$userid = GWF_Session::getUserID();
		
		WC_SiteFavorites::setFavorite($userid, $site->getID(), false);
		
		return $this->_module->message('msg_unmarked_fav', array($site->displayName()));
	}
	
	private function onQuickjump(Module_WeChall $module, $sid)
	{
		if (false === ($url = Common::getPost('favsites'))) {
			return $this->_module->error('err_site');
		}
		header('Location: '.$url);
		die();
	}
	
	########################
	### WeChall Settings ###
	########################
	private function formWCSettings()
	{
		$user = GWF_Session::getUser();
		$data = $user->getUserData();
		$old_pass = isset($data['WC_NO_XSS_PASS']) ? $data['WC_NO_XSS_PASS'] : '';
		
		$data = array(
			'priv_history' => array(GWF_Form::CHECKBOX, isset($data['WC_PRIV_HIST']), $this->_module->lang('th_priv_history'), $this->_module->lang('tt_priv_history')),
			'cross_site' => array(GWF_Form::CHECKBOX, isset($data['WC_NO_XSS']), $this->_module->lang('th_no_xss'), $this->_module->lang('tt_no_xss')),
			'cross_pass' => array(GWF_Form::STRING, $old_pass, $this->_module->lang('th_xss_pass'), $this->_module->lang('tt_xss_pass'), false),
			'div1' => array(GWF_Form::DIVIDER),
			'hide_rank' => array(GWF_Form::CHECKBOX, isset($data['WC_HIDE_RANK']), $this->_module->lang('th_hide_rank'), $this->_module->lang('tt_hide_rank')),
			'hide_score' => array(GWF_Form::CHECKBOX, isset($data['WC_HIDE_SCORE']), $this->_module->lang('th_hide_score'), $this->_module->lang('tt_hide_score')),
			'set_settings' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_set_settings')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateWeChallSettings()
	{
		$form = $this->formWCSettings();
		return $form->templateY($this->_module->lang('ft_settings'));
	}

	public function validate_cross_pass(Module_WeChall $module, $pass)
	{
		return false;
	}
	
	private function onSetSettings()
	{
		$form = $this->formWCSettings();
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateFavSites();
		}
		
		$back = '';
		$changed = 0;
		$user = GWF_Session::getUser();
		$uid = $user->getVar('user_id');
		$data = $user->getUserData();

		# Private History
		$new_priv = isset($_POST['priv_history']);
		$old_priv = isset($data['WC_PRIV_HIST']);
		if ($new_priv !== $old_priv) {
			if ($new_priv === false) {
				unset($data['WC_PRIV_HIST']);
				$back .= $this->_module->message('msg_priv_hist_0');
			} else {
				$data['WC_PRIV_HIST'] = 1;
				$back .= $this->_module->message('msg_priv_hist_1');
			}
			$changed = 1;
		}
		
		# Cross Site Scripts
		$new_xss = isset($_POST['cross_site']);
		$old_xss = isset($data['WC_NO_XSS']);
		if ($new_xss !== $old_xss)
		{
			require_once GWF_CORE_PATH.'module/WeChall/WC_HistoryUser2.php';
			$noxss = WC_HistoryUser2::NO_XSS;
			if ($new_xss === false) {
				unset($data['WC_NO_XSS']);
				$back .= $this->_module->message('msg_no_xss_0');
				$set = "userhist_options=userhist_options-$noxss";
				$where = "userhist_options&$noxss AND ";
				
			} else {
				$data['WC_NO_XSS'] = 1;
				$back .= $this->_module->message('msg_no_xss_1');
				$set = "userhist_options=userhist_options|$noxss";
				$where = "";
			}
			$changed = 1;
			if (false === GDO::table('WC_HistoryUser2')->update($set, $where."userhist_uid=$uid")) {
				$back .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		# XSS Pass
		$old_pass = isset($data['WC_NO_XSS_PASS']) ? $data['WC_NO_XSS_PASS'] : '';
		$new_pass = $form->getVar('cross_pass', '');
		if ($old_pass !== $new_pass)
		{
			if ($new_pass === '')
			{
				unset($data['WC_NO_XSS_PASS']);
				$back .= $this->_module->message('msg_xss_pass_0');
			}
			else
			{
				$data['WC_NO_XSS_PASS'] = $new_pass;
				$back .= $this->_module->message('msg_xss_pass_1');
			}
			$changed = 1;
		}

		# Hide Ranking
		$old_hide_rank = isset($data['WC_HIDE_RANK']);
		$new_hide_rank = isset($_POST['hide_rank']);
		if ($old_hide_rank !== $new_hide_rank)
		{
			require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
			if ($new_hide_rank === false) {
				unset($data['WC_HIDE_RANK']);
				$user->saveOption(0x10000000, false);
				$back .= $this->_module->message('msg_hide_rank_0');
				GDO::table('WC_RegAt')->update('regat_options=regat_options-4', "regat_uid=$uid AND regat_options&4");
			} else {
				$data['WC_HIDE_RANK'] = 1;
				$user->saveOption(0x10000000, true);
				GDO::table('WC_RegAt')->update('regat_options=regat_options|4', "regat_uid=$uid");
				$back .= $this->_module->message('msg_hide_rank_1');
				
			}
			$changed = 1;
		}
		
		# Hide Scores
		$old_hide_score = isset($data['WC_HIDE_SCORE']);
		$new_hide_score = isset($_POST['hide_score']);
		if ($old_hide_score !== $new_hide_score)
		{
			if ($new_hide_score === false) {
				unset($data['WC_HIDE_SCORE']);
				$back .= $this->_module->message('msg_hide_score_0');
			} else {
				$data['WC_HIDE_SCORE'] = 1;
				$back .= $this->_module->message('msg_hide_score_1');
			}
			$changed = 1;
		}
		
		
		# Save Changes
		if ($changed === 1)
		{
			if (false === $user->saveUserData($data)) {
				$back .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		return $back.$this->templateFavSites();
	}
	
	public function validate_favcat($m, $v) { return WC_SiteCats::isValidCatName($v) ? false : $m->lang('err_cat'); }
	private function onAddFavCat()
	{
		$userid = GWF_Session::getUserID();
		$form = $this->getFormFavcat($this->_module, $userid);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}
		
		$cat = $form->getVar('favcat');
		if (false === WC_FavCats::insertFavCat($userid, $cat)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_add_favcat', array(htmlspecialchars($cat)));
	}
	
	private function onRemFavCat(Module_WeChall $module, $cat)
	{
		$userid = GWF_Session::getUserID();
		if (false === (WC_FavCats::removeFavCat($userid, $cat))) {
			return '';
		}
		return $this->_module->message('msg_rem_favcat', array(htmlspecialchars($cat)));
	}
}

?>