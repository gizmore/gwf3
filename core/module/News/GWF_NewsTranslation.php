<?php
final class GWF_NewsTranslation extends GDO
{
	# Options
	const MAILED = 0x01;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'newstrans'; }
	public function getOptionsName() { return 'newst_options'; }
	public function getColumnDefines()
	{
		return array(
			'newst_langid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'newst_newsid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'newst_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, true),
			'newst_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, true),
			'newst_options' => array(GDO::UINT, 0),
			'newst_threadid' => array(GDO::UINT, 0),
			'news' => array(GDO::JOIN, 0, array('GWF_News', 'newst_newsid', 'news_id')),
			'user' => array(GDO::JOIN, 0, array('GWF_User', 'user_id', 'news_userid')),
		);
	}
}

?>