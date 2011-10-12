<?php
final class Usergroups_SearchAdv extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getGet('search')) {
			return $this->onSearchB($module);
		}
		if (false !== Common::getPost('search')) {
			return $this->onSearch($module);
		}
		return $this->templateForm($module);
	}
	
	private function templateForm(Module_Usergroups $module)
	{
		$form = $this->formSearch($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_search_adv'), $module->getMethodURL('SearchAdv')),
			'pagemenu' => '',
			'result' => array(),
			'sort_url' => '',
		);
		return $module->templatePHP('search_adv.php', $tVars);
	}
	
	private function formSearch(Module_Usergroups $module)
	{
		$data = array(
			'username' => array(GWF_Form::STRING, '', $module->lang('th_user_name')),
			'minlevel' => array(GWF_Form::INT, 0, $module->lang('th_user_level')),
			'email' => array(GWF_Form::STRING, '', $module->lang('th_user_email')),
			'country' => array(GWF_Form::SELECT, GWF_CountrySelect::single('country', Common::getPost('country')), $module->lang('th_country')),
			'language' => array(GWF_Form::SELECT, GWF_LangSelect::single(0, 'language', Common::getPost('language')), $module->lang('th_language')),
			'gender' => array(GWF_Form::SELECT, GWF_Gender::select('gender', Common::getPost('gender')), $module->lang('th_gender')),
			'hasmail' => array(GWF_Form::CHECKBOX, false, $module->lang('th_hasmail')),
			'haswww' => array(GWF_Form::CHECKBOX, false, $module->lang('th_haswww')),
			'icq' => array(GWF_Form::CHECKBOX, false, $module->lang('th_icq')),
			'msn' => array(GWF_Form::CHECKBOX, false, $module->lang('th_msn')),
			'jabber' => array(GWF_Form::CHECKBOX, false, $module->lang('th_jabber')),
			'skype' => array(GWF_Form::CHECKBOX, false, $module->lang('th_skype')),
			'yahoo' => array(GWF_Form::CHECKBOX, false, $module->lang('th_yahoo')),
			'aim' => array(GWF_Form::CHECKBOX, false, $module->lang('th_aim')),
			'search' => array(GWF_Form::SUBMIT, $module->lang('btn_search')),
		);
		return new GWF_Form($this, $data);
	}
	
	public static function validate_gender(Module_Usergroups $m, $v) { return GWF_Gender::isValidGender($v) ? false : $m->lang('err_gender'); }
	public static function validate_minlevel(Module_Usergroups $m, $v) { return GWF_Validator::validateInt($m, 'minlevel', $v, 0, PHP_INT_MAX, true); }
	public static function validate_username(Module_Usergroups $m, $v) { return false; }
	public static function validate_email(Module_Usergroups $m, $v) { return false; }
	public static function validate_country(Module_Usergroups $m, $v) { return GWF_CountrySelect::validate_countryid($v, true); }
	public static function validate_language(Module_Usergroups $m, $v) { return GWF_LangSelect::validate_langid($v, true); }
	
	private function onSearch(Module_Usergroups $module)
	{
		$form = $this->formSearch($module);
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->templateForm($module);
		}
		
		# Copy to get
		if ($_POST['username'] !== '') { $_GET['username'] = $_POST['username']; }
		if ($_POST['minlevel'] > 0) { $_GET['minlevel'] = (int)$_POST['minlevel']; }
		if ($_POST['email'] !== '') { $_GET['email'] = $_POST['email']; }
		if ($_POST['country'] !== '0') { $_GET['country'] = $_POST['country']; }
		if ($_POST['language'] !== '0') { $_GET['language'] = $_POST['language']; }
		$gender = $_POST['gender'];
		if ($gender === 'male' || $gender === 'female') { $_GET['gender'] = $_POST['gender']; }
		if (isset($_POST['icq'])) { $_GET['icq'] = 1; }
		if (isset($_POST['msn'])) { $_GET['msn'] = 1; }
		if (isset($_POST['jabber'])) { $_GET['jabber'] = 1; }
		if (isset($_POST['skype'])) { $_GET['skype'] = 1; }
		if (isset($_POST['yahoo'])) { $_GET['yahoo'] = 1; }
		if (isset($_POST['aim'])) { $_GET['aim'] = 1; }
		if (isset($_POST['hasmail'])) { $_GET['hasmail'] = 1; }
		if (isset($_POST['haswww'])) { $_GET['haswww'] = 1; }
		
		
		return $this->onSearchB($module);
	}

	private function onSearchB(Module_Usergroups $module)
	{
		$whitelist = array('user_name', 'user_countryid', 'prof_icq', 'prof_msn', 'prof_jabber', 'prof_skype', 'prof_yahoo', 'prof_aim');
		
		$ipp = 50;
		
		$db = gdo_db();
		
		if ('' === ($where = $this->getWhereQuery($module))) {
			$where = "'1'='0'";
		}
		
		$deleted = GWF_User::DELETED;
		$where .= " AND user_options&$deleted=0";
		
		$users = GWF_TABLE_PREFIX.'user';
		$profiles = GWF_TABLE_PREFIX.'profile';
		$query = "SELECT COUNT(*) AS c FROM $users LEFT JOIN $profiles ON prof_uid=user_id WHERE $where";
		if (false === ($result = $db->queryFirst($query, false))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		$nRows = (int)$result['c'];
		
		$nPages = GWF_PageMenu::getPagecount($ipp, $nRows);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$limit = GDO::getLimit($ipp, $from);
		
		$by = GDO::getWhitelistedByS(Common::getGetString('by'), $whitelist, 'user_name');
		$dir = GDO::getWhitelistedDirS(Common::getGetString('dir'), 'ASC');
		
		$_GET['search'] = 'yes';
		
		$query = "SELECT u.*, p.* FROM $users u LEFT JOIN $profiles p ON prof_uid=user_id WHERE $where ORDER BY $by $dir $limit";
		
		$form = $this->formSearch($module);
		$tVars = array(
			'result' => $db->queryAll($query, true),
			'form' => $form->templateY($module->lang('ft_search_adv'), $module->getMethodURL('SearchAdv')),
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $this->getPageMenuHREF()),
			'sort_url' => $this->getSortHREF(),
		);
		return $module->templatePHP('search_adv.php', $tVars);
	}
	
	private function getPageMenuHREF()
	{
		unset($_GET['page']);
		$back = '';
		foreach ($_GET as $k => $v)
		{
			$back .= sprintf('&%s=%s', urlencode($k), urlencode($v));
		}
		return GWF_WEB_ROOT.'index.php?'.substr($back, 1).'&page=%PAGE%';
	}
	
	private function getSortHREF()
	{
		$by = Common::getGetString('by');
		$dir = Common::getGetString('dir');
		unset($_GET['by']); unset($_GET['dir']);
		$back = '';
		foreach ($_GET as $k => $v)
		{
			$back .= sprintf('&%s=%s', urlencode($k), urlencode($v));
		}
		$back = GWF_WEB_ROOT.'index.php?'.substr($back, 1).'&by=%BY%&dir=%DIR%';
		$_GET['by'] = $by; $_GET['dir'] = $dir;
		return $back;
	}
	
	private function getWhereQuery(Module_Usergroups $module)
	{
		$where = '';
		
		if (isset($_GET['username'])) {
			$v = GDO::escape($_GET['username']);
			$where .= " AND user_name LIKE '%$v%'"; 
		}
		
		if (isset($_GET['email'])) {
			$v = GDO::escape($_GET['email']);
			$where .= " AND (user_options&0x40 AND user_email LIKE '%$v%')"; 
		}
		
		if (isset($_GET['country'])) {
			$v = (int) $_GET['country'];
			$where .= " AND user_countryid=$v"; 
		}
		
		if (isset($_GET['language'])) {
			$v = (int) $_GET['language'];
			$where .= " AND (user_langid=$v OR user_langid2=$v)"; 
		}
		
		if (isset($_GET['minlevel'])) {
			$v = (int) $_GET['minlevel'];
			$where .= " AND user_level>=$v";
		}
		
		if (isset($_GET['gender'])) {
			$v = GDO::escape($_GET['gender']);
			$where .= " AND user_gender='$v'";
		}

		# IM search
		$messi = '';
		if (isset($_GET['icq'])) { $messi .= " OR prof_icq!=''"; }
		if (isset($_GET['msn'])) { $messi .= " OR prof_msn!=''"; }
		if (isset($_GET['jabber'])) { $messi .= " OR prof_jabber!=''"; }
		if (isset($_GET['skype'])) { $messi .= " OR prof_skype!=''"; }
		if (isset($_GET['yahoo'])) { $messi .= " OR prof_yahoo!=''"; }
		if (isset($_GET['aim'])) { $messi .= " OR prof_aim!=''"; }
		if (isset($_GET['haswww'])) { $messi .= " OR prof_website!=''"; }
		if (isset($_GET['hasmail'])) { $messi .= " OR user_options&0x40"; }
		if ($messi !== '') { $where .= ' AND ('.substr($messi, 4).')'; }
		
		# Bail out
		if ($where === '') {
			return '';
		}
		
		# Permission
		$user = GWF_Session::getUser();
		if ($user === false) { $where .= ' AND prof_options&0x10=0'; }
		$level = $user === false ? '0' : $user->getVar('user_level');
		$where .= " AND prof_level_all<=$level";
		
		return $where === '' ? '' : substr($where, 5);
	}
}
?>