<?php

final class GWF_ForumPostHistory extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumposthistory'; }
	public function getColumnDefines()
	{
		return array(
			'fph_id' => array(GDO::AUTO_INCREMENT),
			'fph_pid' => array(GDO::UINT|GDO::INDEX, true),
			'fph_euid' => array(GDO::UINT, true),
			'fph_gid' => array(GDO::UINT, true),
			'fph_date' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, true, GWF_Date::LEN_SECOND),
			'fph_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'fph_options' => array(GDO::UINT, 0),
		);
	}
	
	############################
	### Push Post to History ###
	############################
	public static function pushPost(GWF_ForumPost $post)
	{
		$history = new self(array(
			'fph_pid' => $post->getID(),
			'fph_euid' => $post->getUserID(),
			'fph_gid' => $post->getGroupID(),
			'fph_date' => $post->getDate(),
			'fph_message' => $post->getVar('post_message'),
			'fph_options' => $post->getOptions(),
		));
		return $history->insert();
	}
	
}

?>