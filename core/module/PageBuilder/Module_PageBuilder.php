<?php
/**
 * Create pages with static content.
 * You can put groups in a role we call "authors". These are 100% trusted and may do anything.
 * Unpriveledged users can send in pages for moderation.
 * @author gizmore
 * @author spaceone
 * @todo Restricted CSS Whitelist + W3C mode
 * @todo PageLinks could crawl the content, so it's searchable by DB. 
 * @version 1.05
 * @since 3.0
 */
final class Module_PageBuilder extends GWF_Module
{
	public function getVersion() { return '1.05'; }
	public function getClasses() { return array('GWF_Page', 'GWF_PageGID', 'GWF_PageHistory', 'GWF_PageTagMap', 'GWF_PageTags', 'GWF_PageType', 'GWF_PageLinks'); }
	public function onInstall($dropTable) { require_once 'GWF_PB_Install.php'; return GWF_PB_Install::onInstall($this, $dropTable); }
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/pagebuilder'); }
	public function getDefaultPriority() { return 60; }
	
	public function cfgCommentsPerPage() { return $this->getModuleVarInt('ipp', '10'); }
	public function cfgHomePage() { return $this->getModuleVarInt('home_page', '0'); }
	public function cfgAuthors() { return $this->getModuleVarString('authors', 'admin,moderator,publisher'); }
	public function cfgAuthorLevel() { return $this->getModuleVarInt('author_level', 0); }
	public function cfgLockedPosting() { return $this->getModuleVarBool('locked_posting', '0'); }
	
	public function setHomePage($pageid) { return $this->saveModuleVar('home_page', $pageid); }
	
	public function writeHTA() { return GWF_ModuleLoader::reinstallHTAccess(); }
	public function getContentPath() { return GWF_WWW_PATH.'dbimg/content'; }
	
	#############
	### Hooks ###
	#############
	public function onAddHooks()
	{
		GWF_Hook::add(GWF_Hook::DELETE_USER, array(__CLASS__, 'hookDeleteUser'));
		GWF_Hook::add(GWF_Hook::CHANGE_UNAME, array(__CLASS__, 'hookRenameUser'));
	}
	
	public function hookDeleteUser(GWF_User $user, array $args)
	{
		$this->onInclude();
		return GWF_Page::hookDeleteUser($user);
	}
	
	public function hookRenameUser(GWF_User $user, array $args)
	{
		$this->onInclude();
		return GWF_Page::hookRenameUser($user, $args[0]);
	}
	
	
	/**
	 * Check if user is an author.
	 * @param GWF_User $user
	 * @return boolean
	 */
	public function isAuthor(GWF_User $user)
	{
		# Field is empty so everyone can add.
		if ('' === ($authors = trim($this->cfgAuthors())))
		{
			return true;
		}
		
		# Check author level
		if ($this->cfgAuthorLevel() > $user->getLevel())
		{
			return false; # Nope
		}
		
		# Check author groupnames
		foreach (preg_split('/[,;]+/', $authors) as $groupname)
		{
			if ($user->isInGroupName($groupname))
			{
				return true;
			}
		}
		
		# Nope
		return false;
	}
	
	
	/**
	 * Check if an URL is valid for a page. Optionally check for duplicate URLs too.
	 * @param string $url
	 * @param boolean $allow_dups
	 * @return false|string
	 */
	public function validateURL($url, $allow_dups=false, $key='url')
	{
		# Dup checker
		if (!$allow_dups)
		{
			if (false !== GWF_Page::getByURL($url))
			{
				return $this->lang('err_dup_url');
			}
		}

		# Sanitize URL
		$_POST[$key] = $url = ltrim(trim($url), '/');
		
		# Just some length check
		return GWF_Validator::validateString($this, $key, $url, 4, 255, false);
	}
	
	
	/**
	 * Send moderation mail for a fresh page.
	 * @param GWF_Page $page
	 */
	public function sendModMails(GWF_Page $page)
	{
		if (false === ($method = $this->getMethod('Moderate')))
		{
			GWF_Error::err('ERR_METHOD_MISSING', array('Moderate', 'PageBuilder'));
		}
		$method instanceof PageBuilder_Moderate;
		$method->sendModMails($page);
	}
}
?>
