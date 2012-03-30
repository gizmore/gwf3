<?php
final class PageBuilder_Moderate extends GWF_Method
{
	public function execute()
	{
		if (false === ($page = GWF_Page::getByID(Common::getGetString('pageid'))))
		{
			return $this->module->error('err_page');
		}
		
		if ($page->getHashcode() !== Common::getGetString('token'))
		{
			return $this->module->error('err_token');
		}
		
		switch (Common::getGetString('action'))
		{
			case 'unlock':
				return $this->onEnable($page);
// 			case 'accept':
// 				return $this->onAccept($page);
			case 'delete':
				return $this->onDelete($page);
			default:
				return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'action'));
		}
	}
	
	##############
	### Enable ###
	##############
	public function onEnable(GWF_Page $page)
	{
		# Already enabled
		if (!$page->isLocked())
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		
		# Push to history
		if (false === GWF_PageHistory::push($page))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# Save flag
		if (false === $page->saveOption(GWF_Page::LOCKED, false))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# Yay!
		return $this->module->message('msg_enabled', htmlspecialchars($page->hrefShow()));
	}
	
	##############
	### Delete ###
	##############
	public function onDeleteAll(GWF_Page $page)
	{
		$oid = $page->getOtherID();
		if (false === ($pages = $page->selectAll('*', "page_otherid={$oid}", '', NULL, -1, -1, GDO::ARRAY_O)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		foreach ($pages as $page)
		{
			if (false === $this->onDelete($page, false))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		if (false === $this->onDeleteCleanup())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_deleted_all');
	}
	
	public function onDelete(GWF_Page $page, $do_cleanup=true)
	{
		# History is per page basis, and can be deleted easily.
		if (false === GWF_PageHistory::onDelete($page))
		{
			return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# 
		if (false === GWF_PageTagMap::onDelete($page))
		{
			return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		# Last of them?
		$num_trans = $page->selectVar('COUNT(*)', "page_otherid={$oid}");
		if ($num_trans === 1)
		{
			if (false === GWF_PageGID::onDelete($page))
			{
				return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		# Root page?
		elseif ($page->isRoot())
		{
			if (!$this->newRoot($page))
			{
				return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		if (false === $page->delete())
		{
			return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if ($do_cleanup)
		{
			if (false === $this->onDeleteCleanup())
			{
				return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		GWF_Website::addDefaultOutput($this->module->message('msg_deleted'));
		return true;
	}
	
	private function onDeleteCleanup()
	{
		return GWF_PageTags::cleanupTags();
	}

	/**
	 * Assign the next possible root via cycle.
	 * @param GWF_Page $page
	 */
	private function newRoot(GWF_Page $page)
	{
		$oid = $page->getOtherID();
		$tablename = $page->getTableName();
		if (false === ($nextid = $page->selectVar('page_id', "page_otherid={$oid} AND page_id!={$oid}", 'page_create_date ASC')))
		{
			return false;
		}
		return $page->update("page_otherid=$nextid", "page_otherid={$oid}");
	}
	
	# Accept an edit
// 	public function onAccept(GWF_Page $page)
// 	{
		
// 	}

	#######################
	### ModerationMails ###
	#######################
	public function sendModMails(GWF_Page $page)
	{
		foreach ($this->getAuthorIDs() as $userid)
		{
			$this->sendModMail($userid, $page);
		}
	}
	
	private function sendModMail($userid, GWF_Page $page)
	{
		if (false === ($user = GWF_User::getByID($userid)))
		{
			return false;
		}
		
		if ('' === ($email = $user->getValidMail()))
		{
			return false;
		}
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver($email);
		$mail->setSubject($this->module->lang('subj_mod'));
		
		# Collect data
		$token = $page->getHashcode();
		$pid = $page->getID();
		$href_enable = Common::getAbsoluteURL(sprintf('index.php?mo=PageBuilder&me=Moderate&token=%s&pageid=%s&action=unlock', $token, $pid));
		$href_delete = Common::getAbsoluteURL(sprintf('index.php?mo=PageBuilder&me=Moderate&token=%s&pageid=%s&action=delete', $token, $pid));
		$mail->setBody($this->module->lang('body_mod', array(
			$user->displayUsername(),
			$page->display('page_author_name'),
			$page->display('page_url'),
			$page->display('page_title'),
			$page->display('page_meta_tags'),
			$page->display('page_meta_desc'),
			$page->display('page_inline_css'),
			$page->display('page_content'),
			GWF_HTML::anchor($href_enable, $href_enable),
			GWF_HTML::anchor($href_delete, $href_delete)
		)));
		return $mail->sendToUser($user);
	}
	
	private function getAuthorIDs()
	{
		$back = array();
		if ('' !== ($authors = trim($this->module->cfgAuthors())))
		{
			$groups = preg_split('/[,;]+/', $authors);
		}
		else
		{
			$groups = array('admin');
		}
		
		foreach ($groups as $group)
		{
			$group = GDO::escape($group);
			if (false === ($uids = GDO::table('GWF_UserGroup')->selectColumn('ug_userid', "group_name='$group'", '', array('group'))))
			{
				return false;
			}
			$back = array_merge($back, $uids);
		}
		return array_unique($back);
	}
}
?>