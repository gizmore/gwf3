<?php
/**
 * Banning; Timeout; BanMsg;
 * @author gizmore
 */
final class Module_Ban extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.00; }
	
	public function getDefaultAutoLoad() { return true; }
	
	public function getClasses() { return array('GWF_Ban'); }
	
	public function onLoadLanguage() { return $this->loadLanguage('lang/ban'); }
	
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'ban_ipp' => array('50', 'int', '1', '500'),
		));
	}
	
	public function cfgItemsPerPage() { return $this->getModuleVar('ban_ipp', 50); }
	
	###############
	### Startup ###
	###############
	public function onStartup()
	{
		if (false !== ($user = GWF_Session::getUser()))
		{
			$this->onInclude();
			$userid = $user->getID();
			
			# Check if we have unread messages.
			$msgs = GWF_Ban::getUnread($userid);
			if (count($msgs) > 0)
			{
				$this->onLoadLanguage();
				# Display Unread Bans/Warnings
				$this->onStartupMessages($msgs);
			}
		}
	}
	
	private function onStartupMessages(array $msgs)
	{
		$output = $this->lang('info').'<br/>';
		$disable = false;
		foreach ($msgs as $ban)
		{
			$ban instanceof GWF_Ban;
			$msg = $ban->display('ban_msg');
			
			if ($ban->isWarning()) {
				$href = GWF_WEB_ROOT.'index.php?mo=Ban&me=MarkRead&bid='.$ban->getID();
				$this->error('info_warning', array($msg, $href), true, true);
			}
			elseif ($ban->isPermanent()) {
				$disable = true;
				$this->error('info_permban', array($msg), true, true);
			} else {
				$disable = true;
				$this->error('info_tempban', array($ban->displayEndDate(), $msg), true, true);
			}
		}
		
		if ($disable)
		{
			$_GET['mo'] = GWF_DEFAULT_MODULE;
			$_GET['me'] = GWF_DEFAULT_METHOD;
		}
	}
}
?>