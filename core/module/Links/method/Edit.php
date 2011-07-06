<?php

final class Links_Edit extends GWF_Method
{
	/**
	 * @var GWF_Links
	 */
	private $link;
	
	##############
	### Method ###
	##############
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit($module).$this->templateEdit($module);
		}
		
		if (false !== Common::getPost('delete')) {
			return $this->onDelete($module);
		}
		
		return $this->templateEdit($module);
	}
	
	### Sane
	private function sanitize(Module_Links $module)
	{
		if (false === ($this->link = GWF_Links::getByID(Common::getGet('lid')))) {
			return $module->error('err_link');
		}
		
		if (false === $this->link->mayEdit(GWF_Session::getUser())) {
			return $module->error('err_edit_perm');
		}
		
		return false;
	}
	
	### Form
	private function getForm(Module_Links $module)
	{
		$l = $this->link;
		$data = array(
			'link_score' => array(GWF_Form::STRING, $l->getVar('link_score'), $module->lang('th_link_score'), $module->lang('tt_link_score')),
			'link_gid' => array(GWF_Form::SELECT, GWF_GroupSelect::single('link_gid', $l->getGroupID(), true, true), $module->lang('th_link_gid'), $module->lang('tt_link_gid')),
			'tag_info' => array(GWF_Form::HEADLINE, '', $module->lang('info_tag')),
			'known_tags' => array(GWF_Form::HEADLINE, '', $this->collectTags($module)),
			'link_tags' => array(GWF_Form::STRING, $l->getVar('link_tags'), $module->lang('th_link_tags')),
			'div1' => array(GWF_Form::DIVIDER),
			'link_href' => array(GWF_Form::STRING, $l->getVar('link_href'), $module->lang('th_link_href'), $module->lang('tt_link_href')),
			'link_descr' => array(GWF_Form::STRING, $l->getVar('link_descr'), $module->lang('th_link_descr')),
		);
		if ($module->cfgLongDescription()) {
			$data['link_descr2'] = array(GWF_Form::MESSAGE, $l->display('link_descr2'), $module->lang('th_link_descr2'));
		}
		$data['link_options&'.GWF_Links::UNAFILIATE] = array(GWF_Form::CHECKBOX, $l->isUnafiliated(), $module->lang('th_link_options&'.GWF_Links::UNAFILIATE));
		$data['link_options&'.GWF_Links::MEMBER_LINK] = array(GWF_Form::CHECKBOX, $l->isMemberLink(), $module->lang('th_link_options&'.GWF_Links::MEMBER_LINK));
		$data['link_options&'.GWF_Links::ONLY_PRIVATE] = array(GWF_Form::CHECKBOX, $l->isPrivate(), $module->lang('th_link_options&'.GWF_Links::ONLY_PRIVATE));
		if (GWF_User::isStaffS())
		{
			$data['link_options&'.GWF_Links::STICKY] = array(GWF_Form::CHECKBOX, $l->isSticky(), $module->lang('th_link_options&'.GWF_Links::STICKY));
			$data['link_options&'.GWF_Links::IN_MODERATION] = array(GWF_Form::CHECKBOX, $l->isInModeration(), $module->lang('th_link_options&'.GWF_Links::IN_MODERATION));
		}
		$data['edit'] = array(GWF_Form::SUBMIT, $module->lang('btn_edit'), '');
		$data['delete'] = array(GWF_Form::SUBMIT, $module->lang('btn_delete'), '');
		return new GWF_Form($this, $data);
	}
	
	private function collectTags(Module_Links $module)
	{
		$back = array();
		$tags = GWF_LinksTag::getCloud();
		foreach ($tags as $tag)
		{
			$back[] = $tag->display('lt_name');
		}
		return implode(', ', $back);
	}
	
	### Template
	private function templateEdit(Module_Links $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit')),
		);
		return $module->templatePHP('edit.php', $tVars);
	}
	
	### Action
	private function onDelete(Module_Links $module)
	{
		if (false !== ($error = $this->link->deleteLink($module))) {
			return $error;
		}
		return $module->message('msg_deleted');
	}
	
	private function onEdit(Module_Links $module)
	{
		$form = $this->getForm($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
//		var_dump($_POST);
		
		$this->link->removeTags();

		$data = array(
			# Access
			'link_gid' => $form->getVar('link_gid'),
			'link_score' => $form->getVar('link_score'),
			'link_href' => $form->getVar('link_href'),
			'link_descr' => $form->getVar('link_descr'),
			'link_tags' => $form->getVar('link_tags'),
		);
		if (false !== ($descr2 = $form->getVar('link_descr2'))) {
			$data['link_descr2'] = $descr2;
		}

		if (false === $this->link->saveVars($data)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$this->link->insertTags($module);
		
		$this->link->saveOption(GWF_Links::UNAFILIATE, isset($_POST['link_options&'.GWF_Links::UNAFILIATE]));
		$this->link->saveOption(GWF_Links::MEMBER_LINK, isset($_POST['link_options&'.GWF_Links::MEMBER_LINK]));
		$this->link->saveOption(GWF_Links::ONLY_PRIVATE, isset($_POST['link_options&'.GWF_Links::ONLY_PRIVATE]));
		if (GWF_User::isStaffS())
		{
			$this->link->saveOption(GWF_Links::STICKY, isset($_POST['link_options&'.GWF_Links::STICKY]));
			
			if (false === $this->link->toggleModeration($module, isset($_POST['link_options&'.GWF_Links::IN_MODERATION]))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		
		return $module->message('msg_edited');
	}
	
	##################
	### Validators ###
	##################
	public function validate_link_gid(Module_Links $module, $arg) { return GWF_LinksValidator::validate_gid($module, $arg); }
	public function validate_link_score(Module_Links $module, $arg) { return GWF_LinksValidator::validate_score($module, $arg); }
	public function validate_link_tags(Module_Links $module, $arg) { return GWF_LinksValidator::validate_tags($module, $arg); }
	public function validate_link_href(Module_Links $module, $arg) { return GWF_LinksValidator::validate_href($module, $arg, false); }
	public function validate_link_descr(Module_Links $module, $arg) { return GWF_LinksValidator::validate_descr1($module, $arg); }
	public function validate_link_descr2(Module_Links $module, $arg) { return GWF_LinksValidator::validate_descr2($module, $arg); }
		
}

?>