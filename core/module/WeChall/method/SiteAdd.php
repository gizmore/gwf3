<?php
/**
 * Add a new site.
 * @author gizmore
 */
final class WeChall_SiteAdd extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^site/add$ index.php?mo=WeChall&me=SiteAdd'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== Common::getPost('add_site')) {
			return $this->onAddSite();
		}
		return $this->templateSiteAdd();
	}

	public function templateSiteAdd()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_add_site')),
		);
		return $this->_module->templatePHP('site_add.php', $tVars);
	}

	public function getForm()
	{
		$data = array(
			'site_name' => array(GWF_Form::STRING, '', $this->_module->lang('th_site_name')),
			'site_classname' => array(GWF_Form::STRING, '', $this->_module->lang('th_site_classname')),
			'add_site' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add_site')),
		);
		return new GWF_Form($this, $data);
	}

	public function onAddSite()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateSiteAdd();
		}
		
		$site = new WC_Site(array(
			'site_status' => 'wanted',
			'site_name' => $form->getVar('site_name'),
			'site_classname' => $form->getVar('site_classname'),
//			'site_description' => '',
			'site_country' => 0,
			'site_language' => 0,
			'site_joindate' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'site_launchdate' => '',
			'site_authkey' => GWF_Random::randomKey(32),
			'site_xauthkey' => GWF_Random::randomKey(32),
			'site_irc' => '',
			'site_url' => '',
			'site_url_mail' => '',
			'site_url_score' => '',
			'site_url_profile' => '',
			'site_score' => 0,
			'site_basescore' => 0,
			'site_avg' => 0,
			'site_vote_dif' => 0,
			'site_vote_fun' => 0,
			'site_challcount' => 0,
			'site_usercount' => 0,
			'site_visit_in' => 0, 
			'site_visit_out' => 0,
			'site_options' => 0,
			'site_boardid' => 0,
			'site_threadid' => 0,
			'site_tags' => '',
		));
		if (false === ($site->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		Module_WeChall::includeVotes();
		if (false === $site->onCreateVotes()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		Module_WeChall::includeForums();
		if (false === $site->onCreateBoard()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		if (false === $site->onCreateThread($this->_module)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteDescr.php';
		if (false === WC_SiteDescr::insertDescr($site->getID(), 1, 'Please edit me :)')) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_site_added');
	}
	
	##################
	### Validators ###
	##################
	public function validate_site_name(Module_WeChall $m, $arg)
	{
		if (false !== WC_Site::getByName($arg)) {
			return $m->lang('err_site_dup');
		}
		$len = GWF_String::strlen($arg);
		$max = $m->cfgMaxSitenameLen();
		if ($len < 1 || $len > $max) {
			return $m->lang('err_site_name', array(1, $max));
		}
		return false;
	}
	
	public function validate_site_classname(Module_WeChall $m, $arg)
	{
		if (false !== WC_Site::getByClassName($arg)) {
			return $m->lang('err_classname_dup');
		}
		
		$max = $m->cfgMaxSitenameLen();
		
		if (1 !== preg_match('/^[a-z][a-z0-9_]+$/iD', $arg)) {
			return $m->lang('err_site_classname', array(1, $max));
		}
		
		$len = GWF_String::strlen($arg);
		if ($len < 1 || $len > $max) {
			return $m->lang('err_site_classname', array(1, $max));
		}
		return false;
		
	}  
}


?>
