<?php
/**
 * A page with more or less static content. 
 * @author gizmore
 */
final class GWF_Page extends GDO
{
	const ENABLED = 0x01;
	const REVISION = 0x02;
	const TRANSLATION = 0x04;
	
	const LOGIN_REQUIRED = 0x08; # S
	
	const SHOW_AUTHOR = 0x10;
	const SHOW_TRANS = 0x20; # S
	const SHOW_MODIFIED = 0x40; # S
	const SHOW_SIMILAR = 0x80; # S
	const SHOW_FLAGS = 0xF0;
	
	const STICKYBITS = 0x70E8; # Copied to all translations
	
	const SMARTY = 0x100;
	const HTML = 0x200;
	const BBCODE = 0x400;
	const MODES = 0x700;
	
	const COMMENTS = 0x800;
	
	const INDEXED = 0x1000; # S
	const FOLLOW = 0x2000; # S
	const IN_SITEMAP = 0x4000; # S
	
	const LOCKED = 0x8000; # Not published and in review

	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'page'; }
	public function getOptionsName() { return 'page_options'; }
	public function getColumnDefines()
	{
		return array(
			'page_id' => array(GDO::AUTO_INCREMENT),
			'page_otherid' => array(GDO::UINT|GDO::INDEX, 0),
			'page_lang' => array(GDO::UINT|GDO::INDEX, 0),
			'page_author' => array(GDO::UINT, 0),
			'page_author_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
			'page_groups' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S), # Is relational table now
			'page_create_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'page_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'page_time' => array(GDO::UINT, GDO::NOT_NULL),
			'page_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_cat' => array(GDO::UINT, 0),
			'page_meta_tags' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_meta_desc' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_content' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_views' => array(GDO::UINT, 0),
			'page_options' => array(GDO::UINT|GDO::INDEX, 0),
			'page_inline_css' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NULL),
			# Join cats	
// 			'cats' => array(GDO::JOIN, GDO::NULL, array('GWF_Category', 'page_cat, 'cat_id')),
			# Join groupids
			'gids' => array(GDO::JOIN, GDO::NULL, array('GWF_PageGID', 'page_otherid', 'pgid_oid')),
			# Join tags
			'tags' => array(GDO::JOIN, GDO::NULL, array('GWF_PageTagMap', 'page_otherid', 'ptm_pid')),
		);
	}
	
	/**
	 * Get a page by ID.
	 * @param int $id
	 * @return GWF_Page|false
	 */
	public static function getByID($id) { return self::table(__CLASS__)->getBy('page_id', $id); }

	/**
	 * Get a page by URL.
	 * @param string $url
	 * @return GWF_Page|false
	 */
	public static function getByURL($url) { return self::table(__CLASS__)->getBy('page_url', $url); }
	
	/**
	 * Get the root page for this page.
	 * @return GWF_Page|false
	 */
	public function getOtherPage()
	{
		return self::getByID($this->getOtherID());
	}
	
	public function getID() { return $this->getVar('page_id'); }
	public function getOtherID() { return $this->getVar('page_otherid'); }
	
	public function isRoot() { return $this->getID() === $this->getOtherID(); }
	public function isLocked() { return $this->isOptionEnabled(self::LOCKED); }
	public function isEnabled() { return $this->isOptionEnabled(self::ENABLED); }
	public function isLoginRequired() { return $this->isOptionEnabled(self::LOGIN_REQUIRED); }
	public function getMode() { return $this->getOptions() & self::MODES; }
	public function wantComments() { return $this->isOptionEnabled(self::COMMENTS); }
	public function getShowFlags() { return $this->getOptions() & self::SHOW_FLAGS; }
	
	/**
	 * Get the comments thread.
	 * @return GWF_Comments
	 */
	public function getComments()
	{
		if (false === ($mod_c = GWF_Module::loadModuleDB('Comments', true, true)))
		{
			return false;
		}
		return GWF_Comments::getOrCreateComments('_GWF_PBC_'.$this->getID(), $this->getVar('page_author'));
	}
	
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Edit&pageid='.$this->getID(); }
	public function hrefShow() { return GWF_WEB_ROOT.$this->getVar('page_url'); }
	
// 	public function displayLang()
// 	{
// 		if (false === ($lang = GWF_Language::getByID($this->getVar('page_lang'))))
// 		{
// 			return GWF_Module::getModule('PageBuilder')->lang('lang_all');
// 		}
// 		return $lang->displayName();
// 	}
	
	/**
	 * This checks if a user is page owner.
	 * @param GWF_User $user
	 * @return boolean
	 */
	public function isOwner(GWF_User $user)
	{
		return $user->isUser() ? $user->getID() === $this->getVar('page_author') : false;
	}
	
	#############
	### Hooks ###
	#############
	public static function hookDeleteUser(GWF_User $user)
	{
		return GDO::table(__CLASS__)->update('page_author=0, page_author_name=""', 'page_author='.$user->getID());
	}

	public static function hookRenameUser(GWF_User $user, $newname)
	{
		$newname = GDO::escape($newname);
		$oldname = $user->getEscaped('user_name');
		return GDO::table(__CLASS__)->update("page_author_name='{$newname}'", "page_author_name='{$oldname}'");
	}
}
?>
