<?php
/**
 * A comment thread
 * @author gizmore
 */
final class GWF_Comments extends GDO
{
	const ENABLED = 0x01;
	const MODERATED = 0x02;
	const CAPTCHA_GUESTS = 0x04;
	const CAPTCHA_MEMBER = 0x08;
	const DEFAULT_OPTIONS = 5;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'comments'; }
	public function getOptionsName() { return 'cmts_options'; }
	public function getColumnDefines()
	{
		return array(
			'cmts_id' => array(GDO::AUTO_INCREMENT), # comments id
			'cmts_key' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::UNIQUE, GDO::NOT_NULL, 255), # the real id
			'cmts_uid' => array(GDO::UINT, GDO::NULL), # allow moderate by userid
			'cmts_gid' => array(GDO::UINT, GDO::NULL), # allow moderate by groupid
			'cmts_count' => array(GDO::UINT, 0),
			'cmts_thx' => array(GDO::UINT, 0),
			'cmts_up' => array(GDO::UINT, 0),
			'cmts_down' => array(GDO::UINT, 0),
			'cmts_options' => array(GDO::UINT, 0), # comments options
		);
	}
	public function getID() { return $this->getVar('cmts_id'); }
	public function isEnabled() { return $this->isOptionEnabled(self::ENABLED); }
	
	############
	### HREF ###
	############
	public function hrefMore($page=1)
	{
		$cid = $this->getID();
		return GWF_WEB_ROOT."comments-{$cid}_page-{$page}.html";
	}
	
	##############
	### Static ###
	##############
	/**
	 * Get a comments thread.
	 * @param string $key
	 * @param int $uid
	 * @param int $gid
	 * @param int $options
	 * @return GWF_Comments
	 */
	public static function getOrCreateComments($key, $uid=0, $gid=0, $options=self::DEFAULT_OPTIONS)
	{
		if (false !== ($c = self::getComments($key)))
		{
			return $c;
		}
		
		$c = new self(array(
			'cmts_id' => '0',
			'cmts_key' => $key,
			'cmts_uid' => $uid,
			'cmts_gid' => $gid,
			'cmts_count' => 0,
			'cmts_thx' => 0,
			'cmts_up' => 0,
			'cmts_down' => 0,
			'cmts_options' => $options,
		));
		
		if (false === $c->replace())
		{
			return false;
		}
		
		return $c;
	}
	
	public static function getComments($key)
	{
		return self::table(__CLASS__)->getBy('cmts_key', $key, GDO::ARRAY_O);
	}
	
	/**
	 * Get a comments thread by ID.
	 * @param int $id
	 * @return GWF_Comments
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}

	###############
	### Display ###
	###############
	public function displayMore($href=NULL)
	{
		$href = $href === NULL ? $this->hrefMore('1') : $href;
		$module = Module_Comments::instance();
		return $module->lang('info_comments', array(htmlspecialchars($href), $this->getVar('cmts_count')));
	}

	public function displayTopComments($href=NULL)
	{
		$cid = $this->getID();
		$top = GWF_Comment::TOP_COMMENT;
		$comments = GDO::table('GWF_Comment')->selectObjects('*', "cmt_cid={$cid} AND cmt_options&{$top}");
		$tVars = array(
			'comments' => $this->displayComments($comments, $href),
		);
//		$href = $href === NULL ? $this->hrefMore('1') : $href;
//		$module = Module_Comments::instance();
//		return $module->lang('info_comments', array(htmlspecialchars($href), $this->getVar('cmts_count')));
	}
	
	public function displayComments(array $comments, $href=NULL)
	{
		$module = Module_Comments::instance();
		$tVars = array(
			'href' => $href,
			'comments' => $comments,
			'can_mod' => $this->canModerate(GWF_Session::getUser()),
		);
		return $module->template('_comments.tpl', $tVars);
	}
	
	public function canModerate($user)
	{
		return $user === false ? false : $user->isStaff();
	}
	
	public function displayReplyForm($href=NULL)
	{
		$module = Module_Comments::instance();
		$reply = $module->getMethod('Reply');
		$reply instanceof Comments_Reply;
		$_POST['cmt_id'] = 0;
		$_POST['cmts_id'] = $this->getID();
		return $reply->templateReply($module, $href);
	}
}
?>