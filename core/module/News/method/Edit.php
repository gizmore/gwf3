<?php

final class News_Edit extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^news/edit$ index.php?mo=News&me=Edit'.PHP_EOL.
			'RewriteRule ^news/edit/([0-9]+)-[^/]+/langid-([0-9]+) index.php?mo=News&me=Edit&newsid=$1&langid=$2'.PHP_EOL;
	}

	/**
	 * @var GWF_News
	 */
	private $news;
	/**
	 * @var GWF_Language
	 */
	private $lang;
	
	public function execute()
	{
		if (false !== ($mod_forum = GWF_Module::getModule('Forum', true))) {
			$mod_forum->onInclude();
			GWF_ForumBoard::init(false);
		}
		
		if (false !== (Common::getPost('quicktranslate'))) {
			return $this->onQuickTranslate();
		}
		
		$newsid = (int) Common::getGet('newsid', '0');
		$langid = (int) Common::getGet('langid', '0');
		if (false === ($news = GWF_News::getNewsItem($newsid))) {
			return $this->_module->error('err_news');
		}
//		if (false === ($news->loadTranslations())) {
//			return GWF_HTML::err('ERR_UNKNOWN_LANGUAGE');
//		}
		
		if (false === ($lang = GWF_Language::getByID($langid))) {
			return GWF_HTML::err('ERR_UNKNOWN_LANGUAGE');
		}
		if (!GWF_Language::isSupported($langid)) {
			return GWF_HTML::err('ERR_UNKNOWN_LANGUAGE');
		}
		
		$this->news = $news;
		$this->lang = $lang;
		
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit().$this->templateEdit();
		}
		if (false !== (Common::getPost('translate'))) {
			return $this->onTranslate();
		}
		if (false !== (Common::getPost('preview'))) {
			return $this->onPreview();
		}
		return $this->templateEdit();
	}
	
	private function getForm()
	{
		$langid = $this->lang->getID();
		$t = $this->news->getTranslationB($langid);
		$title = $t['newst_title'];
		$message = $t['newst_message'];
//		GWF_Language::setShowSupported(true);
		$data = array(
			'langid' => array(GWF_Form::HIDDEN, $langid),
			'title' => array(GWF_Form::STRING, $title, $this->_module->lang('th_title')),
			'message' => array(GWF_Form::MESSAGE, $message, $this->_module->lang('th_message')),
			'hidden' => array(GWF_Form::CHECKBOX, $this->news->isHidden(), $this->_module->lang('th_hidden')),
			'mailme' => array(GWF_Form::CHECKBOX, $this->news->isToBeMailed(), $this->_module->lang('th_mail_me')),
			'preview' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_preview'), ''),
			'edit' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_edit'), ''),
//			'transid' => array(GWF_Form::GDO, Common::getPost('transid', 0), $this->_module->lang('th_transid'), 20, 'GWF_Language'),
			'transid' => array(GWF_Form::SELECT, GWF_LangSelect::single(GWF_Language::SUPPORTED, 'transid'), $this->_module->lang('th_transid')),
			'translate' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_translate'), ''),
		);
		return new GWF_Form($this, $data);
	}
		
	private function templateEdit()
	{
		$form = $this->getForm();
		$form_title = $this->_module->lang('ft_edit', array( $this->lang->displayName()));
		$action = $this->news->hrefEdit($this->lang);
		$tVars = array(
			'form' => $form->templateY($form_title, $action),
		);
		return $this->_module->templatePHP('edit.php', $tVars);
	}
	
	##################
	### Validators ###
	##################
	public function validate_title(GWF_Module $module, $arg)
	{
		return strlen($arg) < 3 ? $this->_module->error('err_title') : false;
	}
	
	public function validate_message(GWF_Module $module, $arg)
	{
		return strlen($arg) < 3 ? $this->_module->error('err_message') : false;
	}
	
	public function validate_langid(GWF_Module $module, $arg)
	{
		return false;
		$langid = (int) $arg;
		return GWF_Language::isLangIDSupported($langid) ? false : $this->_module->error('err_lang_src');
	}
	
	public function validate_transid(GWF_Module $module, $arg)
	{
		return false;
//		$langid = (int) $arg;
//		return GWF_Language::isLangIDSupported($arg) ? false : $this->_module->lang('err_langtrans');
	}
	
	###############
	### Preview ###
	###############
	private function onPreview()
	{
		$form = $this->getForm();
		
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors.$this->templateEdit();
		}
		
		$news = GWF_News::preview(
			GWF_Time::getDate(GWF_Date::LEN_SECOND), 
			$form->getVar('catid'),
			GWF_Session::getUserID(),
			$form->getVar('langid'),
			$form->getVar('title'),
			$form->getVar('message')
		);
		
		$preview = $this->previewNewsletter($news).Module_News::displayPreview($news);
		
		return $preview.$this->templateEdit();
	}
	
	private function previewNewsletter(GWF_News $news)
	{
		Module_News::savePreview($news);
		$aTEXT = sprintf('<a href="%s">%s</a>', GWF_WEB_ROOT.'newsletter/preview/text', $this->_module->lang('btn_preview_text'));
		$aHTML = sprintf('<a href="%s">%s</a>', GWF_WEB_ROOT.'newsletter/preview/html', $this->_module->lang('btn_preview_html'));
		return $this->_module->lang('preview_info', array( $aTEXT, $aHTML));
	}
	
	############
	### Edit ###
	############
	private function onEdit()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->_module))) { #, array('langid', 'title', 'message')))) {
			return $error;
		}
		
		$langid = $this->lang->getID();
		if (false === ($this->news->saveTranslation($langid, $form->getVar('title'), $form->getVar('message')))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$options = 0;
		
		$back = '';
		
		$oldhidden = $this->news->isHidden();
		$newhidden = isset($_POST['hidden']);
		$options |= $newhidden ? GWF_News::HIDDEN : 0;
		if ($newhidden !== $oldhidden) {
			$back .= $this->_module->message('msg_hidden_'.($newhidden?1:0));
		}
		
		$oldmail = $this->news->isToBeMailed();
		$newmail = isset($_POST['mailme']);
		$options |= $newmail ? GWF_News::MAIL_ME : 0;
		if ($newmail !== $oldmail) {
			$back .= $this->_module->message('msg_mailme_'.($newmail?1:0));
		}
		
		if (false === $this->news->saveVar('news_options', $options)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

//		if ($this->_module->cfgNewsInForum())
//		{
//			$back .= $this->newsToForum($this->news, !$newhidden);
//		}
		
		return $back.$this->_module->message('msg_edited', array($this->news->displayTitle(), $this->lang->displayName()));
	}

	#################
	### Translate ###
	#################
	private function onQuickTranslate()
	{
		$newsid = (int) Common::getPost('newsid', 0);
		if (false === ($news = GWF_News::getByID($newsid))) {
			return $this->_module->error('err_news');
		}
		
		$translateID = (int) Common::getPost('translate', 0);
		if (false === ($lang = GWF_Language::getByID($translateID))) {
			return $this->_module->error('err_lang_dest');
		}
		
		$trans = $news->getFirstTranslation();
		$title = Common::urlencodeSEO($trans['newst_title']);
		$location = GWF_WEB_ROOT.'news/edit/'.$newsid.'-'.$title.'/langid-1'; #.$translateID;
		header('Location: '.$location);
		die();
	}
	
	private function onTranslate()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->_module))) { #, array('transid', 'langid', 'title', 'message')))) {
			return $error.$this->templateEdit();
		}
		
		$transid = $form->getVar('transid');
		if (false === ($lang = GWF_Language::getByID($transid))) {
			return $this->_module->error('err_lang_dest').$this->templateEdit();
		}
		
		if ($form->getVar('langid') === $transid) {
			return $this->_module->error('err_equal_translang', array($this->lang->displayName())).$this->templateEdit();
		}
		
		if (false === ($this->news->saveTranslation($transid, $form->getVar('title'), $form->getVar('message')))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateEdit();
		}
		
		$this->lang = $lang;
		
		$back = '';
//		if ($this->_module->cfgNewsInForum() && (!$this->news->isHidden()))
//		{
//			$back = $this->newsToForum($this->news);
//		}
		
		return $back.$this->_module->message('msg_translated', array($this->news->displayTitle(), $lang->displayName())).$this->templateEdit();
	}
	
	##################
	### News2Forum ###
	##################
	/**
	 * Rebuild all threads. return error message or empty string.
	 * @param Module_News $module
	 * @param boolean $visible
	 * @return string
	 */
	public function rebuildAllThreads($visible)
	{
		$back = '';
		$news_table = GDO::table('GWF_News');
		$result = $news_table->select('*');
		while (false !== ($news = $news_table->fetch($result, GDO::ARRAY_O)))
		{
			$back .= $this->newsToForum($news, $visible);
		}
		$news_table->free($result);
		return $back;
	}
	
	public  function newsToForum(GWF_News $news, $visible=true)
	{
		if (false === ($poster = $news->getUser())) {
			return GWF_HTML::error('News_Edit', 'News_Edit::newsToForum(): Nobody as Poster');
		}
		
		// Get News root.
		if (false === ($news_root = $this->getNewsForumRoot())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		$root_id = $news_root->getID();
		
		$lang_roots = array();
		foreach ($news->getTranslations() as $t)
		{
			if (false === ($lang = GWF_Language::getByID($t['newst_langid']))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			
			if (false === ($lang_board = $this->getNewsForumLangCached($lang, $root_id))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			
			$iso = $lang->getISO();
			$tid = (int)$t['newst_threadid'];
			$lang_roots[$iso] = $lang_board;
			$bid = $lang_board->getID();
			$thread = GWF_ForumThread::getByID($tid);
			
			$title = $t['newst_title'];
			$message = $t['newst_message'];
			$gid = 0;
			$options = GWF_ForumThread::GUEST_VIEW;
			$options |= $visible ? 0 : GWF_ForumThread::INVISIBLE;
			
			if (!$visible)
			{
				if ($thread !== false)
				{
					$thread->setVisible($visible);
				}
			}
			else
			{
				if ($thread === false)
				{
					if (false === ($thread = GWF_ForumThread::newThread($poster, $title, $message, $options, $bid, $gid))) {
						return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
					}
				}
				else
				{
					if (false === ($post = $thread->getFirstPost())) {
						return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
					}
					if (false === $post->saveVar('post_message', $message)) {
						return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
					}
				}
				
				$thread->setVisible($visible);
				
			}

			$tid = $thread === false ? 0 : $thread->getID();
			
			$langid = $lang->getID();
			$newsid = $news->getID();
			
			// Save threadid
			if (false === GDO::table('GWF_NewsTranslation')->update("newst_threadid=$tid", "newst_langid=$langid AND newst_newsid=$newsid")) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}

		
		// Set Boards Visible
		
		$news_root->setVisible($visible);
		foreach ($lang_roots as $iso => $board)
		{
			$board->setVisible($visible);
		}

		return '';
	}
	
	/** Get the news forum root.
	 * @param Module_News $module
	 * @return GWF_ForumBoard
	 */
	public function getNewsForumRoot()
	{
		$title = "News";
		if (false !== ($board = GWF_ForumBoard::getByTitle($title))) {
			return $board;
		}
		
		$options = GWF_ForumBoard::GUEST_VIEW|GWF_ForumBoard::SCRIPT_LOCK;
		return GWF_ForumBoard::createBoard($title, 'on '.GWF_SITENAME, 1, $options, 0);
	}
	
	/**
	 * Get a news lang board cached.
	 * @param Module_News $module
	 * @param GWF_Language $lang
	 * @param unknown_type $pid
	 * @return unknown_type
	 */
	private function getNewsForumLangCached(GWF_Language $lang, $pid)
	{
		static $cache = array();
		
		$iso = $lang->getISO();
		
		if (!isset($cache[$iso]))
		{
			$cache[$iso] = $this->getNewsForumLang($lang, $pid);
		}
		return $cache[$iso];
	}
	
	/**
	 * Get a newsboard for a language.
	 * @param Module_News $module
	 * @param GWF_Language $lang
	 * @param int $pid rootid
	 * @return GWF_ForumBoard
	 */
	private function getNewsForumLang(GWF_Language $lang, $pid)
	{
		
		$pid = (int) $pid;
		$title = $lang->escaped('lang_nativename');
		// found old board
		if (false !== ($board = GDO::table('GWF_ForumBoard')->selectFirst("board_pid=$pid AND board_title='$title'"))) {
			return $board;
		}

		/// Create new board
		$options = GWF_ForumBoard::GUEST_VIEW;
		$descr = $this->_module->langISO($lang->getISO(), 'board_lang_descr', array($lang->displayName()));
		$board = GWF_ForumBoard::createBoard($title, $descr, $pid, $options);
		
		return $board;
	}
	
	
}

?>