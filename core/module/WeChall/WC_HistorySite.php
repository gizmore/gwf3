<?php
/**
 * Site History Events.
 * @author gizmore
 */
final class WC_HistorySite extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_site_history'; }
	public function getColumnDefines()
	{
		return array(
			'sitehist_sid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'sitehist_date' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL), #, GWF_Date::LEN_SECOND),
			'sitehist_score' => array(GDO::UINT, GDO::NOT_NULL),
			'sitehist_usercount' => array(GDO::UINT, GDO::NOT_NULL),
			'sitehist_challcount' => array(GDO::UINT, GDO::NOT_NULL),
			'sitehist_comment' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		);
	}
	
	public static function insertEntry($siteid, $score, $usercount, $challcount, $comment='')
	{
		$entry = new self(array(
			'sitehist_sid' => $siteid,
			'sitehist_date' => time(), #GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'sitehist_score' => $score,
			'sitehist_usercount' => $usercount,
			'sitehist_challcount' => $challcount,
			'sitehist_comment' => $comment,
		));
		
		if (WECHALL_DEBUG_SCORING)
		{
			echo WC_HTML::message('Inserting Site History Item...');
		}
				
		return $entry->insert();
	}
	
}
?>