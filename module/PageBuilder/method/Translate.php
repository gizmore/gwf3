<?php
/**
 * Translate a page
 * @author gizmore
 */
final class PageBuilder_Translate extends GWF_Method
{
	private $page;
	
	public function getUserGroups() { return array('admin'); }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($this->page = GWF_Page::getByID(Common::getGetString('pageid')))) {
			return $module->lang('err_page');
		}
		
		$back = '';
		
		if (isset($_POST['translate'])) {
			$back .= $this->onTranslate($module, $this->page);
		}
		
		return $back.$this->templateTranslate($module, $this->page);
	}
	
	private function templateTranslate(Module_PageBuilder $module, GWF_Page $page)
	{
		$form = $this->formTranslate($module, $page);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_translate')),
		);
		return $module->template('translate.tpl', $tVars);
	}
	
	private function formTranslate(Module_PageBuilder $module, GWF_Page $page)
	{
		$data = array(
			'url' => array(GWF_Form::STRING, $page->getVar('page_url'), $module->lang('th_url')),
			'lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'lang'), $module->lang('th_lang')),
//			'groups' => array(GWF_Form::SELECT_A, GWF_GroupSelect::multi('groups', $this->getSelectedGroups($module, $page), true, true), $module->lang('th_groups')),
//			'noguests' => array(GWF_Form::CHECKBOX, $page->isLoginRequired(), $module->lang('th_noguests')),
//			'enabled' => array(GWF_Form::CHECKBOX, $page->isEnabled(), $module->lang('th_enabled')),
			'title' => array(GWF_Form::STRING, $page->getVar('page_title'), $module->lang('th_title')),
			'descr' => array(GWF_Form::STRING, $page->getVar('page_meta_desc'), $module->lang('th_descr')),
			'tags' => array(GWF_Form::STRING, trim($page->getVar('page_meta_tags'),','), $module->lang('th_tags')),
			'file' => array(GWF_Form::FILE_OPT, '', $module->lang('th_file')),
			'upload' => array(GWF_Form::SUBMIT, $module->lang('btn_upload')),
			'content' => array(GWF_Form::MESSAGE_NOBB, $page->getVar('page_content'), $module->lang('th_content')),
			'translate' => array(GWF_Form::SUBMIT, $module->lang('btn_translate')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_title($m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, 4, 255, false); }
	public function validate_descr($m, $arg) { return GWF_Validator::validateString($m, 'descr', $arg, 4, 255, false); }
	public function validate_tags($m, $arg) { return GWF_Validator::validateString($m, 'tags', $arg, 4, 255, false); }
	public function validate_content($m, $arg) { return GWF_Validator::validateString($m, 'content', $arg, 4, 65536, false); }
	public function validate_url($m, $arg) { return GWF_Validator::validateString($m, 'url', $arg, 4, 255, false); }
	public function validate_lang($m, $arg)
	{
		if (false !== ($error = GWF_LangSelect::validate_langid($arg, true))) {
			return $error;
		}
		
		$lid = (int)$arg;
		$oid = $this->page->getOtherID();
		if (false === GDO::table('GWF_Page')->selectVar('1', "page_otherid=$oid AND page_lang=$lid")) {
			return false;
		}
		
		return $m->lang('err_dup_lid');
	}
	
	private function onTranslate(Module_PageBuilder $module, GWF_Page $page)
	{
		$form = $this->formTranslate($module, $page);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		$options = 0;
		$options |= GWF_Page::ENABLED;
		$options |= GWF_Page::TRANSLATION;
		$options |= $page->isLoginRequired() ? GWF_Page::LOGIN_REQUIRED : 0;
		
		$gstring = $page->getVar('page_groups');
		$tags = ','.trim($form->getVar('tags'), ' ,').',';
		
		$newpage = new GWF_Page(array(
			'page_id' => 0,
			'page_otherid' => $page->getID(),
			'page_lang' => $form->getVar('lang'),
			'page_author' => GWF_Session::getUserID(),
			'page_groups' => $gstring,
			'page_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			'page_time' => time(),
			'page_url' => $form->getVar('url'),
			'page_title' => $form->getVar('title'),
			'page_meta_tags' => $tags,
			'page_meta_desc' => $form->getVar('descr'),
			'page_content' => $form->getVar('content'),
			'page_options' => $options,
		));
		if (false === $newpage->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === GWF_PageGID::updateGIDs($newpage, $gstring)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === GWF_PageTags::updateTags($newpage, $tags)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === $module->writeHTA()) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__,__LINE__));
		}
		
		return $module->message('msg_trans');
	}
}
?>