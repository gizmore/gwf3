<?php
final class PageBuilder_Edit extends GWF_Method
{
	public function getUserGroups() { return array('admin'); }
	
	public function execute()
	{
		if (false === ($page = GWF_Page::getByID(Common::getGetString('pageid')))) {
			return $this->module->lang('err_page');
		}
		
		$back = '';
		if (isset($_POST['edit'])) {
			$back .= $this->onEdit($page);
		}
		elseif (isset($_POST['translate'])) {
			GWF_Website::redirect($this->module->getMethodURL('Translate', '&pageid='.$page->getID()));
			die();
		}
		elseif (isset($_POST['upload'])) {
			require_once GWF_CORE_PATH.'module/PageBuilder/PB_Uploader.php';
			$back .= PB_Uploader::onUpload($this->module);
		}
		
		return $back.$this->templateEdit($page);
	}
	
	private function templateEdit(GWF_Page $page)
	{
		$form = $this->formEdit($page);
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit')),
		);
		return $this->module->template('edit.tpl', $tVars);
	}

	private function formEdit(GWF_Page $page)
	{
		$mod_cat = GWF_Module::loadModuleDB('Category', true, true);
		
		$data = array();
		$data['url'] = array(GWF_Form::STRING, $page->getVar('page_url'), $this->module->lang('th_url'));
		$data['type'] = array(GWF_Form::SELECT, GWF_PageType::select($this->module, $page->getMode()), $this->module->lang('th_type'));
		$data['groups'] = array(GWF_Form::SELECT_A, GWF_GroupSelect::multi('groups', $this->getSelectedGroups($page), true, true), $this->module->lang('th_groups'));
		$data['noguests'] = array(GWF_Form::CHECKBOX, $page->isLoginRequired(), $this->module->lang('th_noguests'));
		$data['index'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::INDEX), $this->module->lang('th_index'));
		$data['follow'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::FOLLOW), $this->module->lang('th_follow'));
		$data['sitemap'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::IN_SITEMAP), $this->module->lang('th_in_sitemap'));
//		'lang' => array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'lang', $page->getVar('page_lang')), $this->module->lang('th_lang')),
		$data['enabled'] = array(GWF_Form::CHECKBOX, $page->isEnabled(), $this->module->lang('th_enabled'));
		$data['title'] = array(GWF_Form::STRING, $page->getVar('page_title'), $this->module->lang('th_title'));
		if ($mod_cat !== false)
		{
			$data['cat'] = array(GWF_Form::SELECT, GWF_CategorySelect::single('cat', Common::getPostString('cat')), $this->module->lang('th_cat'));
		}
		$data['descr'] = array(GWF_Form::STRING, $page->getVar('page_meta_desc'), $this->module->lang('th_descr'));
		$data['tags'] = array(GWF_Form::STRING, trim($page->getVar('page_meta_tags'),','), $this->module->lang('th_tags'));
		$data['show_author'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::SHOW_AUTHOR), $this->module->lang('th_show_author'));
		$data['show_similar'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::SHOW_SIMILAR), $this->module->lang('th_show_similar'));
		$data['show_modified'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::SHOW_MODIFIED), $this->module->lang('th_show_modified'));
		$data['show_trans'] = array(GWF_Form::CHECKBOX, $page->isOptionEnabled(GWF_Page::SHOW_TRANS), $this->module->lang('th_show_trans'));
		$data['show_comments'] = array(GWF_Form::CHECKBOX, $page->wantComments(), $this->module->lang('th_show_comments'));
		$data['home_page'] = array(GWF_Form::CHECKBOX, ($this->module->cfgHomePage() === $page->getID()), $this->module->lang('th_home_page'));
		$data['file'] = array(GWF_Form::FILE_OPT, '', $this->module->lang('th_file'));
		$data['upload'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_upload'));
		$data['inline_css'] = array(GWF_Form::MESSAGE_NOBB, $page->getVar('page_inline_css'), $this->module->lang('th_inline_css'));
		if($page->getMode() === GWF_Page::BBCODE)
		{
			$data['content'] = array(GWF_Form::MESSAGE, $page->getVar('page_content'), $this->module->lang('th_content'));
		}
		else
		{
			$data['content'] = array(GWF_Form::MESSAGE_NOBB, $page->getVar('page_content'), $this->module->lang('th_content'));
 		}
		$data['buttons'] = array(GWF_Form::SUBMITS, array('edit'=>$this->module->lang('btn_edit'),'translate'=>$this->module->lang('btn_translate')));
 		return new GWF_Form($this, $data);
	}
	
	private function onEdit(GWF_Page $page)
	{
		$form = $this->formEdit($page);
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
//		$options = 0;
//		$options |= isset($_POST['enabled']) ? GWF_Page::ENABLED : 0;
//		$options |= isset($_POST['noguests']) ? GWF_Page::LOGIN_REQUIRED : 0;
		
		$gstring = $this->buildGroupString();
		$tags = ','.trim($form->getVar('tags'), ' ,').',';
		
		$data = array(
//			'page_lang' => $form->getVar('lang'),
//			'page_author' => GWF_Session::getUserID(),
			'page_date' => GWF_Time::getDate(GWF_Time::LEN_SECOND),
			'page_time' => time(),
//			'page_type' => $form->getVar('type'),
			'page_url' => $form->getVar('url'),
			'page_title' => $form->getVar('title'),
			'page_meta_tags' => $tags,
			'page_meta_desc' => $form->getVar('descr'),
			'page_inline_css' => $form->getVar('inline_css'),
			'page_content' => $form->getVar('content'),
//			'page_groups' => $gstring,
//			'page_options' => $options,
		);
//		if ($page->isRoot()) {
//			$data['page_groups'] = $this->buildGroupString();
//		}
//		$data['page_options'] = $options;

		if (true === isset($_POST['home_page']))
		{
			$this->module->setHomePage($page->getID());
		}
		
		if (false === ($page->saveVars($data))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
//		if ($page->isRoot())
		if (false === $this->permTranslations($page, $gstring)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === GWF_PageGID::updateGIDs($page, $gstring)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === GWF_PageTags::updateTags($page, $tags)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__,__LINE__));
		}
		
		if (false === $this->module->writeHTA()) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__,__LINE__));
		}
		
		return $this->module->message('msg_edited', array(GWF_WEB_ROOT.$page->getVar('page_url'), $page->getVar('page_title')));
	}
	
	public function validate_title($m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, 4, 255, false); }
	public function validate_descr($m, $arg) { return GWF_Validator::validateString($m, 'descr', $arg, 4, 255, false); }
	public function validate_tags($m, $arg) { return GWF_Validator::validateString($m, 'tags', $arg, 4, 255, false); }
	public function validate_content($m, $arg) { return GWF_Validator::validateString($m, 'content', $arg, 4, 65536, false); }
	public function validate_inline_css($m, $arg) { return false; }
	public function validate_url($m, $arg) { return GWF_Validator::validateString($m, 'url', $arg, 4, 255, false); }
//	public function validate_lang($m, $arg) { return GWF_LangSelect::validate_langid($arg, true); }
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
	
	private function buildGroupString()
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
	
	private function getSelectedGroups(GWF_Page $page)
	{
		return explode(',', $page->getVar('page_groups'));
	}
	
	/**
	 * Set the same options for all translations of a page
	 * @param GWF_Page $page
	 * @param string $gstring group string
	 * @return boolean
	 */
	private function permTranslations(GWF_Page $page, $gstring)
	{
		$pages = GDO::table('GWF_Page');
		$bits = GWF_Page::PERMBITS;
		$page->setOption($bits, false);
		$otherid = $page->getOtherID();
		
		# Kill all bits.
		$bits = ~$bits;
		if (false === $pages->update("page_options=page_options&$bits","page_otherid={$otherid}")) {
			return false;
		}
		
		# Set the new bits.
		$gstring = GDO::escape($gstring);
		$bits = 0;
		$bits |= isset($_POST['noguests']) ? GWF_Page::LOGIN_REQUIRED : 0;
		$bits |= isset($_POST['show_author']) ? GWF_Page::SHOW_AUTHOR : 0;
		$bits |= isset($_POST['show_similar']) ? GWF_Page::SHOW_SIMILAR : 0;
		$bits |= isset($_POST['show_modified']) ? GWF_Page::SHOW_MODIFIED : 0;
		$bits |= isset($_POST['show_trans']) ? GWF_Page::SHOW_TRANS : 0;
		$bits |= isset($_POST['show_comments']) ? GWF_Page::COMMENTS : 0;
		$bits |= isset($_POST['index']) ? GWF_Page::INDEX : 0;
		$bits |= isset($_POST['follow']) ? GWF_Page::FOLLOW : 0;
		$bits |= isset($_POST['sitemap']) ? GWF_Page::IN_SITEMAP : 0;
		$bits |= $_POST['type'];
		$page->setOption($bits, true);
		$page->setVar('page_groups', $gstring);
		
		# Trigger a recache for all translations.
		$time = time();
		
		# Fire the sql
		return GDO::table('GWF_Page')->update("page_groups='{$gstring}', page_options=page_options|{$bits}, page_time={$time}", "page_otherid={$otherid}");
	}
}
?>
