<?php
/**
 * A forum post attachment.
 * @author gizmore
 */
final class GWF_ForumAttachment extends GDO
{
	###############
	### Options ###
	###############
	const GUEST_VISIBLE = 0x01;
	const GUEST_DOWNLOAD = 0x02;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'forumattach'; }
	public function getOptionsName() { return 'fatt_options'; }
	public function getColumnDefines()
	{
		return array(
			'fatt_aid' => array(GDO::AUTO_INCREMENT),
			'fatt_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'fatt_pid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'fatt_mime' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 255),
			'fatt_size' => array(GDO::UINT, GDO::NOT_NULL),
			'fatt_downloads' => array(GDO::UINT, 0),
			'fatt_filename' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'fatt_options' => array(GDO::UINT, 0),
			'fatt_date' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
		);
	}
	
	#############
	### HREFs ###
	#############
	public function dbimgPath() { return 'dbimg/forum_attach/'.$this->getVar('fatt_aid'); }
	public function hrefDownload() { return GWF_WEB_ROOT.'forum/attachment/'.$this->getVar('fatt_aid'); }
	public function hrefDownloadSEO() { $this->hrefDownload().'/'.$this->urlencodeSEO('fatt_filename'); }
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=Forum&me=EditAttach&aid='.$this->getVar('fatt_aid'); }
	##############
	### Static ###
	##############
	/**
	 * @param int $attach_id
	 * @return GWF_ForumAttachment
	 */
	public static function getByID($attach_id)
	{
		return self::table(__CLASS__)->getRow($attach_id);
	}
	
	public static function getAttachments($post_id)
	{
		return self::table(__CLASS__)->selectObjects('*', 'fatt_pid='.(int)$post_id, 'fatt_date ASC');
	}
	
	###################
	### Convinience ###
	###################
	public function isGuestView() { return $this->isOptionEnabled(self::GUEST_VISIBLE); }
	public function isGuestDown() { return $this->isOptionEnabled(self::GUEST_DOWNLOAD); }
	public function isImage() { return GWF_Upload::isImageMime($this->getVar('fatt_mime')); }
	/**
	 * Get the forum post associated with this attachment.
	 * @return GWF_ForumPost
	 */
	public function getPost() { return GWF_ForumPost::getPost($this->getVar('fatt_pid')); }
	
	##################
	### Permission ###
	##################
	public function canSee($user)
	{
		if ($user === false) {
			return $this->isGuestView();
		}
		return true;
	}
	
	public function canDownload($user)
	{
		if ($user === false) {
			return $this->isGuestDown();
		}
		return true;
	}
}
?>