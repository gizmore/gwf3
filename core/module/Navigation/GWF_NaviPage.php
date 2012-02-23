<?php

final class GWF_NaviPage extends GDO
{
	const ENABLED = 0x01;
	const REMOVEABLE = 0x02;
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'navi_page'; }
	public function getOptionsName() { return 'page_options'; }
	public function getColumnDefines()
	{
		return array(
			'page_id' => array(GDO::AUTO_INCREMENT),
			'page_otherid' => array(GDO::UINT|GDO::INDEX, 0),
			'page_lang' => array(GDO::UINT|GDO::INDEX, 0),
//			'page_author' => array(GDO::UINT, 0),
//			'page_author_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
			'page_groups' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
//			'page_create_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
//			'page_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
//			'page_time' => array(GDO::UINT, GDO::NOT_NULL),
			'page_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_cat' => array(GDO::UINT, 0),
//			'page_meta_tags' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_meta_desc' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
//			'page_content' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_views' => array(GDO::UINT, 0), // activated for statistics
			'page_options' => array(GDO::UINT|GDO::INDEX, 0),
//			'page_menu_pos' => array(GDO::INT|GDO::INDEX, -1),
		);
	}
	
	public static function onDelete($id)
	{
		die('TODO');
	}
	
//	/**
//	 * Get a page by ID.
//	 * @param int $id
//	 * @return GWF_Page
//	 */
//	public static function getByID($id) { return self::table(__CLASS__)->getBy('page_id', $id); }

	public function getID() { return $this->getVar('page_id'); }
	public function getOtherID() { return '0';}//$this->getVar('page_otherid'); }
	
	public function isRoot() { return $this->getID() === $this->getOtherID(); }
	public function isEnabled() { return $this->isOptionEnabled(GWF_Page::ENABLED); }
	public function isLoginRequired() { return $this->isOptionEnabled(GWF_Page::LOGIN_REQUIRED); }
	public function getMode() { return $this->getOptions() & GWF_Page::MODES; }
	public function wantComments() { return $this->isOptionEnabled(GWF_Page::COMMENTS); }
	
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=PageBuilder&me=Edit&pageid='.$this->getID(); }
	public function hrefShow() { return GWF_WEB_ROOT.$this->getVar('page_url'); }
	
	public function displayLang()
	{
		# FIXME: page_lang not assigned
		//if (false === ($lang = GWF_Language::getByID($this->getVar('page_lang')))) {
		if (false === ($lang = GWF_Language::getByID(1))) {
			return GWF_Module::getModule('PageBuilder')->lang('lang_all');
		}
		return $lang->displayName();
	}
}
?>
