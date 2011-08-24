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
	
	const LOGIN_REQUIRED = 0x08;
	
	const SHOW_AUTHOR = 0x10;
	const SHOW_TRANS = 0x20;
	const SHOW_MODIFIED = 0x40;
	const SHOW_SIMILAR = 0x80;
	
	const PERMBITS = 0xF8;
	
	const SMARTY = 0x100;
	const HTML = 0x200;
	const BBCODE = 0x400;
	const MODES = 0x700;
	
	const COMMENTS = 0x800;
	
	const INDEX = 0x1000;
	const FOLLOW = 0x2000;
	
	const IN_SITEMAP = 0x4000;

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
			'page_groups' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
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
			'page_menu_pos' => array(GDO::INT|GDO::INDEX, -1),
		);
	}
	
	/**
	 * Get a page by ID.
	 * @param int $id
	 * @return GWF_Page
	 */
	public static function getByID($id) { return self::table(__CLASS__)->getBy('page_id', $id); }

	public function getID() { return $this->getVar('page_id'); }
	public function getOtherID() { return $this->getVar('page_otherid'); }
	
	public function isRoot() { return $this->getID() === $this->getOtherID(); }
	public function isEnabled() { return $this->isOptionEnabled(self::ENABLED); }
	public function isLoginRequired() { return $this->isOptionEnabled(self::LOGIN_REQUIRED); }
	public function getMode() { return $this->getOptions() & self::MODES; }
	public function wantComments() { return $this->isOptionEnabled(self::COMMENTS); }
	
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
	
	public function displayLang()
	{
		if (false === ($lang = GWF_Language::getByID($this->getVar('page_lang')))) {
			return GWF_Module::getModule('PageBuilder')->lang('lang_all');
		}
		return $lang->displayName();
	}
}
?>
