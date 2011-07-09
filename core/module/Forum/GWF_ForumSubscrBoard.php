<?php
/**
 * Subscribe a whole forum board.
 * @author gizmore
 * @since GWF3
 */
final class GWF_ForumSubscrBoard extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumsubscrboard'; }
	
	public function getColumnDefines()
	{
		return array(
			'subscr_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'subscr_bid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'boards' => array(GDO::JOIN, GDO::NULL, array('GWF_ForumBoard', 'subscr_bid', 'board_bid')),
		);
	}

	public static function subscribe($userid, $boardid)
	{
		if (!self::hasSubscribed($userid, $boardid))
		{
			return self::table(__CLASS__)->insertAssoc(array('subscr_uid' => $userid,'subscr_bid' => $boardid));
		}
		return true;
	}
	
	public static function unsubscribe($userid, $boardid)
	{
		return self::table(__CLASS__)->deleteWhere(sprintf('subscr_uid=%d AND subscr_bid=%d', $userid, $boardid));
	}
	
	private static function hasSubscribedB($userid, $boardid)
	{
		return self::table(__CLASS__)->selectVar('1', sprintf('subscr_uid=%d AND subscr_bid=%d', $userid, $boardid)) === '1';
	}
	
	public static function hasSubscribed($userid, $boardid)
	{
		$curr = GWF_ForumBoard::getBoard($boardid);
		while ($curr !== false)
		{
			if (self::hasSubscribedB($userid, $curr->getID()))
			{
				return true;
			}
			$curr = $curr->getParent();
		}
		return false;
	}
	
}
?>