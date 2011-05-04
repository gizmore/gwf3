<?php
final class PageBuilder_Edit extends GWF_Method
{
	public function getUserGroups() { return array('admin'); }
	
	public function execute(Module_PageBuilder $module)
	{
		if (false === ($page = GWF_Page::getByID(Common::getGetString('pageid')))) {
			return $module->lang('err_page');
		}
		
		$back = '';
		if (isset($_POST['edit'])) {
			$back .= $this->onEdit($module, $page);
		}
		elseif (isset($_POST['translate'])) {
			GWF_Website::redirect($module->getMethodURL('Translate', '&pageid='.$page->getID()));
			die();
		}
		
		return $back.$this->templateEdit($module, $page);
	}
	
	private function templateEdit(Module_PageBuilder $module, GWF_Page $page)
	{
		$form = $this->formEdit($module, $page);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit')),
		);
		return $module->template('edit.tpl', $tVars);
	}

	private function formEdit(Module_PageBuilder $module, GWF_Page $page)
	{
		$data = array();
		$data['url'] = array(GWF_Form::STRING, $page->getVar('page_url'), $module->lang('th_url'));
		$data['groups'] = array(GWF_Form::SELECT_A, GWF_GroupSelect::multi('groups', $this->getSelectedGroups($module, $page), true, true), $module->lang('th_groups'));
		$data['noguests'] = array(GWF_Form::CHECKBOX, $page->isLoginRequired(), $module->lang('th_noguests'));
//		'lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'lang', $page->getVar('page_lang')), $module->lang('th_lang')),
		$data['enabled'] = array(GWF_Form::CHECKBOX, $page->isEnabled(), $module->lang('th_enabled'));
		$data['title'] = array(GWF_Form::STRING, $page->getVar('page_title'), $module->lang('th_title'));
		$data['descr'] = array(GWF_Form::STRING, $page->getVar('page_meta_desc'), $module->lang('th_descr'));
		$data['tags'] = array(GWF_Form::STRING, trim($page->getVar('page_meta_tags'),','), $module->lang('th_tags'));
		$data['show_author'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_author'));
		$data['show_similar'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_similar'));
		$data['show_modified'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_modified'));
		$data['show_translations'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_trans'));
		$data['content'] = array(GWF_Form::MESSAGE_NOBB, $page->getVar('page_content'), $module->lang('th_content'));
 		$data['buttons'] = array(GWF_Form::SUBMITS, array('edit'=>$module->lang('btn_edit'),'translate'=>$module->lang('btn_translate')));
 		return new GWF_Form($this, $data);
	}
	
	private function onEdit(Module_PageBuilder $module, GWF_Page $page)
	{
		$form = $this->formEdit($module, $page);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
//		$options = 0;
//		$options |= isset($_POST['enabled']) ? GWF_Page::ENABLED : 0;
//		$options |= isset($_POST['noguests']) ? GWF_Page::LOGIN_REQUIRED : 0;
		
		$gstring = $this->buildGroupString($module);
		$tags = ','.trim($form->getVar('tags'), ' ,').',';
		
		$data = array(
//			'page_lang' => $form->getVar('lang'),
			'page_author' => GWF_Session::getUserID(),
			'page_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			'page_time' => time(),
			'page_url' => $form->getVar('url'),
			'page_title' => $form->getVar('title'),
			'page_meta_tags' => $tags,
			'page_meta_desc' => $form->getVar('descr'),
			'page_content' => $form->getVar('content'),
//			'page_groups' => $gstring,
//			'page_options' => $options,
		);
//		if ($page->isRoot()) {
//			$data['page_groups'] = $this->buildGroupString($module);
//		}
//		$data['page_options'] = $options;
		
		if (false === ($page->saveVars($data))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
//		if ($page->isRoot())
		if (false === $this->permTranslations($page->getOtherID(), isset($_POST['noguests']), $gstring)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === GWF_PageGID::updateGIDs($page, $gstring)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === GWF_PageTags::updateTags($page, $tags)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === $module->writeHTA()) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__,__LINE__));
		}
		
		return $module->message('msg_edited');
	}
	
	public function validate_title($m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, 4, 255, false); }
	public function validate_descr($m, $arg) { return GWF_Validator::validateString($m, 'descr', $arg, 4, 255, false); }
	public function validate_tags($m, $arg) { return GWF_Validator::validateString($m, 'tags', $arg, 4, 255, false); }
	public function validate_content($m, $arg) { return GWF_Validator::validateString($m, 'content', $arg, 4, 65536, false); }
	public function validate_url($m, $arg) { return GWF_Validator::validateString($m, 'url', $arg, 4, 255, false); }
//	public function validate_lang($m, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	public function validate_groups($m, $arg)
	{
		if ($arg === false) {
			return false;
		}
		if (!is_array($arg)) {
			return $m->lang('err_groups');
		}
		$user = GWF_Session::getUser();
		foreach ($arg as $gid)
		{
			if (!$user->isInGroupID($gid))
			{
				return $m->lang('err_groups');
			}
		}
		return false;
	}
	
	private function buildGroupString(Module_PageBuilder $module)
	{
		if (!isset($_POST['groups'])) {
			return '';
		}
		$back = '';
		foreach ($_POST['groups'] as $gid)
		{
			if ($gid > 0)
			{
				$back .= ','.$gid;
			}
		}
		return $back === '' ? $back : substr($back, 1);
	}
	
	private function getSelectedGroups(Module_PageBuilder $module, GWF_Page $page)
	{
		return explode(',', $page->getVar('page_groups'));
	}
	
	private function permTranslations($otherid, $noguests, $gstring)
	{
		$bit = GWF_Page::LOGIN_REQUIRED;
		$gstring = GDO::escape($gstring);
		if ($noguests)
		{
			return GDO::table('GWF_Page')->update("page_groups='{$gstring}', page_options=page_options|{$bit}", "page_otherid={$otherid}");
		}
		else
		{
			return GDO::table('GWF_Page')->update("page_groups='{$gstring}', page_options=page_options-{$bit}", "page_otherid={$otherid} AND page_options&{$bit}");
		}
	}
}
?>
