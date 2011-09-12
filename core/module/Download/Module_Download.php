<?php
/**
 * Restricted Download Module.
 * @author gizmore
 */
final class Module_Download extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.01; }
	public function getPrice() { return 19.95; }
	public function getClasses() { return array('GWF_Download', 'GWF_DownloadToken'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/dl'); }
	public function onInstall($dropTable) { require_once 'GWF_DownloadInstall.php'; return GWF_DownloadInstall::install($this, $dropTable); }
	
	public function execute($methodname)
	{
		if (false !== ($mod = GWF_Module::loadModuleDB('Votes')))
		{
			$mod->onInclude();
		}
		if (false !== ($mod = GWF_Module::loadModuleDB('Payment')))
		{
			$mod->onInclude();
		}
		return parent::execute($methodname);
	}
	
	public function onInclude()
	{
		if (false !== ($mod = GWF_Module::loadModuleDB('Votes')))
		{
			$mod->onInclude();
		}
		return parent::onInclude();
	}
	
	##############
	### Config ###
	##############
	public function cfgAnonUp() { return $this->getModuleVar('anon_upload', '0') === '1'; }
	public function cfgAnonDown() { return $this->getModuleVar('anon_downld', '1') === '1'; }
	public function cfgUserUp() { return $this->getModuleVar('user_upload', '1') === '1'; }
	public function cfgMinDescrLen() { return $this->getModuleVar('dl_descr_minlen', 0); }
	public function cfgMaxDescrLen() { return $this->getModuleVar('dl_descr_maxlen', 1024); }
	public function cfgIPP() { return $this->getModuleVar('dl_ipp', 50); }
	public function cfgMinVote() { return $this->getModuleVar('dl_minvote', 1); }
	public function cfgMaxVote() { return $this->getModuleVar('dl_maxvote', 5); }
	public function cfgGuestVote() { return $this->getModuleVar('dl_gvotes', '0') === '1'; }
	public function cfgGuestCaptcha() { return $this->getModuleVar('dl_gcaptcha', '1') === '1'; }
	public function cfgModerated() { return $this->getModuleVar('dl_moderated', '1') === '1'; }
	public function cfgModerators() { return $this->getModuleVar('dl_moderators', 'moderator'); }
	public function cfgMinLevel() { return (int)$this->getModuleVar('dl_min_level', 0); }
	
	public function saveModuleVar($key, $value)
	{
		if (false === parent::saveModuleVar($key, $value)) {
			return false;
		}
		if ($key === 'dl_gvotes')
		{
			if (false === ($mod_vote = GWF_Module::getModule('Votes'))) {
				return true;
			}
			$mod_vote->onInclude();
			$guest_votes = GWF_VoteScore::GUEST_VOTES;
			switch ($value)
			{
				case 'YES':
					if (false === (GDO::table('GWF_VoteScore')->update("vs_options=vs_options|$guest_votes", "vs_name LIKE 'dl_%' "))) {
						return false;
					}
					break;
				case 'NO':
					if (false === (GDO::table('GWF_VoteScore')->update("vs_options=vs_options-$guest_votes", "vs_options&$guest_votes AND vs_name LIKE 'dl_%' "))) {
						return false;
					}
					break;
				default: 
					var_dump(sprintf('Error: Module_Download::saveModuleVar(%s, %s): ', $key, $value));
					break;
			}
		}
		return true;
	}
	
	##################
	### Convinient ###
	##################
	public function hrefAdd()
	{
		return GWF_WEB_ROOT.'index.php?mo=Download&me=Add';
	}
	
	public function mayDownload($user, GWF_Download $download)
	{
		if ($user === false)
		{
			# Guest
			if (!$download->isEnabled())
			{
				return $this->error('err_disabled');
			}
			if ($download->isAdult())
			{
				return $this->error('err_adult');
			}
			if (!$download->isOptionEnabled(GWF_Download::GUEST_DOWNLOAD))
			{
				return $this->error('err_guest');
			}
			if (!$this->cfgAnonDown())
			{
				return $this->error('err_guest');
			}
			return false;
		}
		else
		{
			$user instanceof GWF_User;
			
			# Admin
			if ($user->isAdmin())
			{
				return false;
			}
			
			if (!$download->isEnabled())
			{
				return $this->error('err_disabled');
			}
			
			if ($download->isAdult() && !$user->wantsAdult())
			{
				return $this->error('err_adult');
			}
			
			# Level
			if ($download->getVar('dl_level')>$user->getVar('user_level')) {
				return $this->error('err_level', $download->getVar('dl_level'));
			}
			
			# Group
			$gid = $download->getVar('dl_gid');
			if (false === ($group = GWF_Group::getByID($gid))) {
			}
			elseif ($gid > 0 && (!$user->isInGroupID($download->getVar('dl_gid')))) {
				return $this->error('err_group', $group->display('group_name'));
			}
			
			return false;
		}
	}
	
	public function mayUpload($user)
	{
		$level = $this->cfgMinLevel();
		
		if ($user === false)
		{
			return $level <= 0 ? $this->cfgAnonUp() : false;
		}
		else
		{
			$user instanceof GWF_User;
			if ($user->isAdmin())
			{
				return true;
			}
			else
			{
				if ($user->getLevel() < $level)
				{
					return false;
				}
				return $this->cfgUserUp();
			}
		}
	}
	
	public function isModerated()
	{
		if (!$this->cfgModerated())
		{
			return false;
		}
		
		$user = GWF_Session::getUser();
		if ($user->isAdmin())
		{
			return false;
		}
		
		if ($user->isInGroupName($this->cfgModerators()))
		{
			return false;
		}
		
		return true;
	}
}
?>
