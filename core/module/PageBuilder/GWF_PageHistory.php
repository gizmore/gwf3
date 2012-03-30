<?php
/**
 * Table of page edit history.
 * @author gizmore
 */
final class GWF_PageHistory extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'page_history'; }
	public function getColumnDefines()
	{
		return array(
			'ph_pid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'ph_editor' => array(GDO::UINT, GDO::NOT_NULL),
			'ph_edit_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'ph_content' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NULL),
			'ph_inline_css' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NULL),
			# Joins
// 			'users' => array(),
// 			'pages' => array(),
		);
	}
	
	/**
	 * Push a page on the history.
	 * @param GWF_Page $page
	 * @return boolean
	 */
	public static function push(GWF_Page $page)
	{
		return GDO::table(__CLASS__)->insertAssoc(array(
			'ph_pid' => $page->getID(),
			'ph_editor' => GWF_Session::getUserID(),
			'ph_edit_date' => GWF_Time::getDate(),
			'ph_content' => $page->getVar('page_content'),
			'ph_inline_css' => $page->getVar('page_inline_css'),
		));
	}
	
	/**
	 * Delete the complete history for a page.
	 * @param GWF_Page $page
	 * @return boolean
	 */
	public static function onDelete(GWF_Page $page)
	{
		return self::table(__CLASS__)->deleteWhere('ph_pid='.$page->getID());
	}
}
?>