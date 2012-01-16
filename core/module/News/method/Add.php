<?php
/**
 * Add news
 * @author gizmore
 */
final class News_Add extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }

	public function getHTAccess()
	{
		return 'RewriteRule ^news/add$ index.php?mo=News&me=Add'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== (Common::getPost('add'))) {
			return $this->onAdd();
		}
		
		if (false !== (Common::getPost('preview'))) {
			return $this->onPreview();
		}
		
		return $this->templateAdd();
	}
	
	public function getForm()
	{
		$langid = Common::getPostString('langid', GWF_Language::getEnglish()->getID());
		
		require_once GWF_CORE_PATH.'module/Category/GWF_CategorySelect.php';
		
		//key => array(TYPE, default, text, classname)
//		GWF_Language::setShowSupported(true);
		$data = array(
//			'username' => array(GWF_Form::STRING, GWF_Session::getUser()->getVar('username'), GWF_HTML::lang('username')),
			'langid' => array(GWF_Form::SELECT, GWF_LangSelect::single(GWF_Language::SUPPORTED, 'langid', $langid), $this->_module->lang('th_langid')),
			'catid' => array(GWF_Form::SELECT, GWF_CategorySelect::single('catid', Common::getPostString('catid', '1'), 0), $this->_module->lang('th_category')),
			'title' => array(GWF_Form::STRING, '', $this->_module->lang('th_title')),
			'message' => array(GWF_Form::MESSAGE, '', $this->_module->lang('th_message')),
			'div1' => array(GWF_Form::DIVIDER),
//			'newsletter' => array(GWF_Form::CHECKBOX, Common::getPost('newsletter') !== false, $this->_module->lang('th_newsletter')),
			'div2' => array(GWF_Form::DIVIDER),
			'preview' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_preview'), ''),
//			'hidden' => array(GWF_Form::CHECKBOX, Common::getPost('hidden') !== false, $this->_module->lang('th_hidden')),
			'add' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateAdd()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_add')),
		);
		return $this->_module->templatePHP('add.php', $tVars);
	}
	
	public function validate_langid(Module_News $module, $langid)
	{
		if (!GWF_LangSelect::isValidLanguage($langid, false)) {
			return $this->_module->lang('err_langid');
		}
		return false;
	}
	
	public function validate_catid(Module_News $module, $catid)
	{
		$catid = (int) $catid;
		if ($catid === 0) {
			return false;
		}
		if (!GWF_Category::categoryExists($catid)) {
			return $this->_module->lang('err_cat');
		}
		return false;
	}
	
	public function validate_message(Module_News $module, $msg)
	{
		if (strlen($msg) < 16) {
			return $this->_module->lang('err_msg_too_short');
		}
		return false;
	}
	
	public function validate_title(Module_News $module, $title)
	{
		if (strlen($title) < 4) {
			return $this->_module->lang('err_title_too_short');
		}
		return false;
	}
	
	private function onAdd()
	{
		$form = $this->getForm();
		
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors.$this->templateAdd();
		}
		
		$langid = $form->getVar('langid');
		$title = $form->getVar('title');
		$message = $form->getVar('message');
		$options = GWF_News::HIDDEN;
		
		if (false === ($news = GWF_News::newNews(
			GWF_Time::getDate(GWF_NEWS_DATE_LEN), 
			$form->getVar('catid'),
			GWF_Session::getUserID(),
			$langid,
			$title,
			$message,
			false,
			$options
		))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if ($form->getVar('newsletter') !== false) {
			$this->onSendNewsletter($langid, $news); # TODO: gizmore fix it → method does not exist
		}
		
		return $this->_module->message('msg_news_added');
	}

	private function onPreview()
	{
		$form = $this->getForm();
		
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors.$this->templateAdd();
		}
		
		$news = GWF_News::preview(
			GWF_Time::getDate(GWF_Date::LEN_SECOND), 
			$form->getVar('catid'),
			GWF_Session::getUserID(),
			$form->getVar('langid'),
			$form->getVar('title'),
			$form->getVar('message')
		);
		
		$preview = Module_News::displayPreview($news);
		
//		if ($form->getVar('newsletter') !== false) {
			$preview = $this->previewNewsletter($news).$preview;
//		}
		
		return $preview.$this->templateAdd();
	}
	
//	private function getNewsletterMessage($message, $email)
//	{
//		if (false === ($user = GWF_User::getByEmail($email))) {
//			$username = $this->_module->lang('nl_anrede', array( $email));
//		}
//		else {
//			$username = $this->_module->lang('nl_anrede', array( $user->getName()));
//		}
//		
//		if (false === ($))
//		$lin
//		
//		return $this->_module->lang('newsletter_wrap', array( $msg));
//	}
	
	private function previewNewsletter(GWF_News $news)
	{
		Module_News::savePreview($news);
//		var_dump($news);
		$aTEXT = sprintf('<a href="%s">%s</a>', GWF_WEB_ROOT.'newsletter/preview/text', $this->_module->lang('btn_preview_text'));
		$aHTML = sprintf('<a href="%s">%s</a>', GWF_WEB_ROOT.'newsletter/preview/html', $this->_module->lang('btn_preview_html'));
		return $this->_module->lang('preview_info', array( $aTEXT, $aHTML));
	}

}

?>