<?php

final class GWF_ForumVisitors extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumwatch'; }
	public function getColumnDefines()
	{
		return array(
			'fowa_sess' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, true, GWF_Session::SESS_ENTROPY),
			'fowa_time' => array(GDO::UINT|GDO::INDEX, true),
			'fowa_tid' => array(GDO::UINT, true),
		);
	}
	
	####################
	### Set Watching ###
	####################
	public static function setWatching(GWF_ForumThread $thread, $cut)
	{
		$tid = $thread->getID();

		# Insert current spectator
//		GDO::table(__CLASS__);
		$row = new self(array(
			'fowa_sess' => substr(GWF_Session::getSessID(), 0, GWF_Session::SESS_ENTROPY),
			'fowa_time' => time(),
			'fowa_tid' => $tid,
		));
		if (false === $row->replace()) {
			return false;
		}
		
		# Delete old
		$cut = time() - $cut;
		if (false === $row->deleteWhere("fowa_time<$cut")) {
			return false;
		}
		
		# Set new amount
		if (false === $thread->saveVar('thread_watchers', $row->countRows("fowa_tid=$tid"))) {
			return false;
		}
		
		return true;
	}
	
}

?>