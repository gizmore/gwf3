<?php
/**
 * Mibbit chat page. Fullscreen possible.
 * @author gizmore
 */
final class Chat_Mibbit extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^irc_chat/?$ index.php?mo=Chat&me=Mibbit'.PHP_EOL.
			'RewriteRule ^irc_chat_fullscreen/?$ index.php?mo=Chat&me=Mibbit&fullscreen=yes'.PHP_EOL;
	}

	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'irc_chat',
						'page_title' => 'IRC Chat',
						'page_meta_desc' => 'IRC Chat of '.GWF_SITENAME,
				),
				array(
						'page_url' => 'irc_chat_fullscreen',
						'page_title' => 'Fullscreen IRC Chat',
						'page_meta_desc' => 'Fullscreen IRC Chat of '.GWF_SITENAME,
				),
		);
	}
		
	public function execute()
	{
		return $this->templateMibbit();
	}
	
	private function templateMibbit()
	{
		if (!$this->module->cfgMibbit()) {
			return GWF_HTML::err('ERR_MODULE_DISABLED', array( 'Chat_Mibbit'));
		}
		
		GWF_Website::setPageTitle($this->module->lang('pt_irc_chat'));
		GWF_Website::setMetaTags($this->module->lang('mt_irc_chat'));
		GWF_Website::setMetaDescr($this->module->lang('md_irc_chat'));
		
		$tVars = array(
			'href_webchat' => GWF_WEB_ROOT.'chat',
			'href_ircchat' => GWF_WEB_ROOT.'irc_chat',
			'href_ircchat_full' => GWF_WEB_ROOT.'irc_chat_fullscreen',
			'mibbit_url' => $this->module->cfgMibbitURL(),
			'mibbit' => $this->module->cfgMibbit(),
			'gwf_chat' => $this->module->cfgGWFChat(),
		);
		return $this->module->templatePHP('mibbit.php', $tVars);
	}	
}
?>