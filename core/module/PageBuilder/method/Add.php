<?php
final class PageBuilder_Add extends GWF_Method
{
	public function getUserGroups() { return array('admin'); }
	
	public function execute(Module_PageBuilder $module)
	{
		if (isset($_POST['add'])) {
			return $this->onAdd($module);
		}
		
		if (isset($_POST['upload'])) {
			return $this->onUpload($module).$this->templateAdd($module);
		}
		
		return $this->templateAdd($module);
	}
	
	private function formAdd(Module_PageBuilder $module)
	{
		$mod_cat = GWF_Module::loadModuleDB('Category', true, true);
		
		$data = array();
		$data['url'] = array(GWF_Form::STRING, '', $module->lang('th_url'));
		$data['type'] = array(GWF_Form::SELECT, GWF_PageType::select($module), $module->lang('th_type'));
		$data['lang'] = array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'lang'), $module->lang('th_lang'));
		$data['groups'] = array(GWF_Form::SELECT_A, GWF_GroupSelect::multi('groups', true, true, true), $module->lang('th_groups'));
		$data['noguests'] = array(GWF_Form::CHECKBOX, false, $module->lang('th_noguests'));
		$data['index'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_index'));
		$data['follow'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_follow'));
		$data['title'] = array(GWF_Form::STRING, '', $module->lang('th_title'));
		if ($mod_cat !== false)
		{
			$data['cat'] = array(GWF_Form::SELECT, GWF_CategorySelect::single('cat', Common::getPostString('cat')), $module->lang('th_cat'));
		}
		$data['descr'] = array(GWF_Form::STRING, '', $module->lang('th_descr'));
		$data['tags'] = array(GWF_Form::STRING, '', $module->lang('th_tags'));
		$data['show_author'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_author'));
		$data['show_similar'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_similar'));
		$data['show_modified'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_modified'));
		$data['show_trans'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_trans'));
		$data['show_comments'] = array(GWF_Form::CHECKBOX, true, $module->lang('th_show_comments'));
		$data['file'] = array(GWF_Form::FILE_OPT, '', $module->lang('th_file'));
		$data['upload'] = array(GWF_Form::SUBMIT, $module->lang('btn_upload'));
		$data['content'] = array(GWF_Form::MESSAGE_NOBB, '', $module->lang('th_content'));
		$data['add'] = array(GWF_Form::SUBMIT, $module->lang('btn_add'));
		return new GWF_Form($this, $data);
	}
	
	private function templateAdd(Module_PageBuilder $module)
	{
		$form = $this->formAdd($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_add')),
		);
		return $module->template('add.tpl', $tVars);
	}
	
	public function validate_title($m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, 4, 255, false); }
	public function validate_descr($m, $arg) { return GWF_Validator::validateString($m, 'descr', $arg, 4, 255, false); }
	public function validate_tags($m, $arg) { return GWF_Validator::validateString($m, 'tags', $arg, 4, 255, false); }
	public function validate_content($m, $arg) { return GWF_Validator::validateString($m, 'content', $arg, 4, 65536, false); }
	public function validate_url($m, $arg) { return GWF_Validator::validateString($m, 'url', $arg, 4, 255, false); }
	public function validate_lang($m, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
	public function validate_type($m, $arg) { return GWF_PageType::validateType($m, $arg); }
	public function validate_cat($m, $arg) { return GWF_CategorySelect::validateCat($arg, true); }
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
	
	private function onAdd(Module_PageBuilder $module)
	{
		$form = $this->formAdd($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateAdd($module);
		}
		
		$options = 0;
		$options |= GWF_Page::ENABLED;
		$options |= isset($_POST['noguests']) ? GWF_Page::LOGIN_REQUIRED : 0;
		$options |= isset($_POST['show_author']) ? GWF_Page::SHOW_AUTHOR : 0;
		$options |= isset($_POST['show_similar']) ? GWF_Page::SHOW_SIMILAR : 0;
		$options |= isset($_POST['show_modified']) ? GWF_Page::SHOW_MODIFIED : 0;
		$options |= isset($_POST['show_trans']) ? GWF_Page::SHOW_TRANS : 0;
		$options |= isset($_POST['show_comments']) ? GWF_Page::COMMENTS : 0;
		$options |= isset($_POST['index']) ? GWF_Page::INDEX : 0;
		$options |= isset($_POST['follow']) ? GWF_Page::FOLLOW : 0;
		$options |= $form->getVar('type');
		
		$gstring = $this->buildGroupString($module);
		$tags = ','.trim($form->getVar('tags'), ' ,').',';
		
		$page = new GWF_Page(array(
			'page_id' => 0,
			'page_otherid' => 0,
			'page_lang' => $form->getVar('lang'),
			'page_author' => GWF_Session::getUserID(),
			'page_author_name' => GWF_User::getStaticOrGuest()->getVar('user_name'),
			'page_groups' => $gstring,
			'page_create_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			'page_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			'page_time' => time(),
			'page_url' => $form->getVar('url'),
			'page_title' => $form->getVar('title'),
			'page_meta_tags' => $tags,
			'page_meta_desc' => $form->getVar('descr'),
			'page_content' => $form->getVar('content'),
			'page_views' => 0,
			'page_options' => $options,
			'page_menu_pos' => -1,
		));
		
		if (false === $page->insert()) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === $page->saveVars(array('page_otherid'=>$page->getID()))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
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
		
		return $module->message('msg_added');
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
	
	####################
	### File uploads ###
	####################
	private function onUpload(Module_PageBuilder $module)
	{
		require_once 'core/module/PageBuilder/PB_Uploader.php';
		return PB_Uploader::onUpload($module);
	}
}
?>