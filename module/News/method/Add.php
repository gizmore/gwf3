<?php
/**
 * Add news
 * @author gizmore
 */
final class News_Add extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }

	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^news/add$ index.php?mo=News&me=Add'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== (Common::getPost('add'))) {
			return $this->onAdd($module);
		}
		
		if (false !== (Common::getPost('preview'))) {
			return $this->onPreview($module);
		}
		
		return $this->templateAdd($module);
	}
	
	public function getForm(Module_News $module)
	{
		$langid = Common::getPostString('langid', GWF_Language::getEnglish()->getID());
		
		require_once 'core/module/Category/GWF_CategorySelect.php';
		
		//key => array(TYPE, default, text, classname)
//		GWF_Language::setShowSupported(true);
		$data = array(
//			'username' => array(GWF_Form::STRING, GWF_Session::getUser()->getVar('username'), GWF_HTML::lang('username')),
			'langid' => array(GWF_Form::SELECT, GWF_LangSelect::single(GWF_Language::SUPPORTED, 'langid', $langid), $module->lang('th_langid')),
			'catid' => array(GWF_Form::SELECT, GWF_CategorySelect::single('catid', Common::getPostString('catid', '1'), 0), $module->lang('th_category')),
			'title' => array(GWF_Form::STRING, '', $module->lang('th_title')),
			'message' => array(GWF_Form::MESSAGE, '', $module->lang('th_message')),
			'div1' => array(GWF_Form::DIVIDER),
//			'newsletter' => array(GWF_Form::CHECKBOX, Common::getPost('newsletter') !== false, $module->lang('th_newsletter')),
			'div2' => array(GWF_Form::DIVIDER),
			'preview' => array(GWF_Form::SUBMIT, $module->lang('btn_preview'), ''),
//			'hidden' => array(GWF_Form::CHECKBOX, Common::getPost('hidden') !== false, $module->lang('th_hidden')),
			'add' => array(GWF_Form::SUBMIT, $module->lang('btn_add'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateAdd(Module_News $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_add')),
		);
		return $module->templatePHP('add.php', $tVars);
	}
	
	public function validate_langid(Module_News $module, $langid)
	{
		if (!GWF_LangSelect::isValidLanguage($langid, false)) {
			return $module->lang('err_langid');
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
			return $module->lang('err_cat');
		}
		return false;
	}
	
	public function validate_message(Module_News $module, $msg)
	{
		if (strlen($msg) < 16) {
			return $module->lang('err_msg_too_short');
		}
		return false;
	}
	
	public function validate_title(Module_News $module, $title)
	{
		if (strlen($title) < 4) {
			return $module->lang('err_title_too_short');
		}
		return false;
	}
	
	private function onAdd(Module_News $module)
	{
		$form = $this->getForm($module);
		
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->templateAdd($module);
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
			$this->onSendNewsletter($module, $langid, $news);
		}
		
		return $module->message('msg_news_added');
	}

	private function onPreview(Module_News $module)
	{
		$form = $this->getForm($module);
		
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->templateAdd($module);
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
			$preview = $this->previewNewsletter($module, $news).$preview;
//		}
		
		return $preview.$this->templateAdd($module);
	}
	
//	private function getNewsletterMessage(Module_News $module, $message, $email)
//	{
//		if (false === ($user = GWF_User::getByEmail($email))) {
//			$username = $module->lang('nl_anrede', array( $email));
//		}
//		else {
//			$username = $module->lang('nl_anrede', array( $user->getName()));
//		}
//		
//		if (false === ($))
//		$lin
//		
//		return $module->lang('newsletter_wrap', array( $msg));
//	}
	
	private function previewNewsletter(Module_News $module, GWF_News $news)
	{
		Module_News::savePreview($news);
//		var_dump($news);
		$aTEXT = sprintf('<a href="%s">%s</a>', GWF_WEB_ROOT.'newsletter/preview/text', $module->lang('btn_preview_text'));
		$aHTML = sprintf('<a href="%s">%s</a>', GWF_WEB_ROOT.'newsletter/preview/html', $module->lang('btn_preview_html'));
		return $module->lang('preview_info', array( $aTEXT, $aHTML));
	}

}

?>