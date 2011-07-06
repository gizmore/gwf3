<?php
/**
 * An faq entry.
 * Can have a ticket_id for abusing the helpdesk tickets.
 * @author gizmore
 *
 */
final class GWF_HelpdeskFAQ extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'helpdesk_faq'; }
	public function getColumnDefines()
	{
		return array(
			'hdf_id' => array(GDO::AUTO_INCREMENT),
			'hdf_tid' => array(GDO::UINT|GDO::INDEX, 0),
			'hdf_question' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'hdf_answer' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'hdf_langid' => array(GDO::UINT|GDO::INDEX, 0),
		);
	}
	
	public static function getByID($id) { return self::table(__CLASS__)->getRow($id); }
	public static function getByTID($tid) { return self::table(__CLASS__)->getBy('hdf_tid', $tid); }
}
?>