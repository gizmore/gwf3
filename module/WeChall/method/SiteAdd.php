<?php
/**
 * Add a new site.
 * @author gizmore
 */
final class WeChall_SiteAdd extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^site/add$ index.php?mo=WeChall&me=SiteAdd'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('add_site')) {
			return $this->onAddSite($module);
		}
		return $this->templateSiteAdd($module);
	}

	public function templateSiteAdd(Module_WeChall $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_add_site')),
		);
		return $module->template('site_add.php', array(), $tVars);
	}

	public function getForm(Module_WeChall $module)
	{
		$data = array(
			'site_name' => array(GWF_Form::STRING, '', $module->lang('th_site_name'), 24),
			'site_classname' => array(GWF_Form::STRING, '', $module->lang('th_site_classname'), 16),
			'add_site' => array(GWF_Form::SUBMIT, $module->lang('btn_add_site')),
		);
		return new GWF_Form($this, $data);
	}

	public function onAddSite(Module_WeChall $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateSiteAdd($module);
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
			'site_authkey' => Common::randomKey(32),
			'site_xauthkey' => Common::randomKey(32),
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
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		Module_WeChall::includeVotes();
		if (false === $site->onCreateVotes()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		Module_WeChall::includeForums();
		if (false === $site->onCreateBoard()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		if (false === $site->onCreateThread($module)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		require_once 'module/WeChall/WC_SiteDescr.php';
		if (false === WC_SiteDescr::insertDescr($site->getID(), 1, 'Please edit me :)')) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $module->message('msg_site_added');
	}
	
	##################
	### Validators ###
	##################
	public function validate_site_name(Module_WeChall $m, $arg)
	{
		if (false !== WC_Site::getByName($arg)) {
			return $m->lang('err_site_dup');
		}
		$len = Common::strlen($arg);
		$max = $m->cfgMaxSitenameLen();
		if ($len < 1 || $len > $max) {
			return $m->lang('err_site_name', 1, $max);
		}
		return false;
	}
	
	public function validate_site_classname(Module_WeChall $m, $arg)
	{
		if (false !== WC_Site::getByClassName($arg)) {
			return $m->lang('err_classname_dup');
		}
		
		$max = $m->cfgMaxSitenameLen();
		
		if (1 !== preg_match('/^[a-z][a-z0-9_]+$/i', $arg)) {
			return $m->lang('err_site_cname', 1, $max);
		}
		
		$len = Common::strlen($arg);
		if ($len < 1 || $len > $max) {
			return $m->lang('err_site_cname', 1, $max);
		}
		return false;
		
	}  
}


?>
