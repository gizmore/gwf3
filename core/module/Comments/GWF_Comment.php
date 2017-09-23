<?php
/**
 * A comment.
 * @author gizmore
 */
final class GWF_Comment extends GDO
{
	const VISIBLE = 0x01;
	const TOP_COMMENT = 0x02;
	const SHOW_EMAIL = 0x04;
	const DELETED = 0x08;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'comment'; }
	public function getOptionsName() { return 'cmt_options'; }
	public function getColumnDefines()
	{
		return array(
			'cmt_id' => array(GDO::AUTO_INCREMENT), # comment id
			'cmt_pid' => array(GDO::UINT, GDO::NULL), # parent comment 
			'cmt_cid' => array(GDO::UINT, GDO::NOT_NULL), # comments id
		
			'cmt_uid' => array(GDO::OBJECT, GDO::NULL, array('GWF_User', 'cmt_uid', 'user_id')), # poster
			'cmt_username' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NULL),
			'cmt_www' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NULL), # poster www
			'cmt_mail' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NULL, array('GWF_User', 'cmt_uid', 'user_id')), # poster email
		
			'cmt_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND), # post date
			'cmt_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL), # message
			'cmt_options' => array(GDO::UINT, 0), # options
		
			'cmt_thx' => array(GDO::UINT, 0),
			'cmt_up' => array(GDO::UINT, 0),
			'cmt_down' => array(GDO::UINT, 0),
		);
	}
	public function getID() { return $this->getVar('cmt_id'); }
	public function isVisible() { return $this->isOptionEnabled(self::VISIBLE); }
	
	/**
	 * Get the comments thread for this comment.
	 * @return GWF_Comments
	 */
	public function getComments() { return GWF_Comments::getByID($this->getVar('cmt_cid')); }
	
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=Comments&me=Edit&cmt_id='.$this->getID(); }
	public function hrefDelete() { return GWF_WEB_ROOT.'index.php?mo=Comments&me=Delete&cmt_id='.$this->getID(); }
	public function hrefHide() { return GWF_WEB_ROOT.'index.php?mo=Comments&me=Hide&cmt_id='.$this->getID(); }
	public function hrefShow() { return GWF_WEB_ROOT.'index.php?mo=Comments&me=Visible&cmt_id='.$this->getID(); }
	
	public function displayDate() { return GWF_Time::displayDate($this->getVar('cmt_date')); }
	public function displayMessage() { return GWF_Message::display($this->getVar('cmt_message')); }
	
	public function displayUser()
	{
		if (NULL === ($user = $this->getVar('cmt_uid')))
		{
			return htmlspecialchars($this->getVar('cmt_username'));
		}
		else
		{
			return $user->displayProfileLink();
		}
	}
	
	public function displayEMail()
	{
		return GWF_User::displayEMailS($this->getVar('cmt_mail'));
	}
	
	public function displayWWW()
	{
		$url = $this->getVar('cmt_www');
		return GWF_HTML::anchor($url, $url, $url);
	}
	
	
	/**
	 * Get a comment by ID.
	 * @param int $id
	 * @return GWF_Comment
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	public function onVisible($bool)
	{
		if ($this->isOptionEnabled(self::VISIBLE) === $bool)
		{
			return true;
		}
		
		if (false === ($comments = $this->getComments()))
		{
			return false;
		}
		
		$by = $bool ? 1 : -1;
		if (false === $comments->increase('cmts_count', $by))
		{
			return false;
		}
		
		if (false === $this->saveOption(self::VISIBLE, $bool))
		{
			return false;
		}
		
		return true;
	}
	
	public function onDelete()
	{
		if (false === $this->onVisible(false))
		{
			return false;
		}
		
		if (false === $this->saveOption(self::DELETED, 1))
		{
			return false;
		}
		
		return true;
	}
}
?>
