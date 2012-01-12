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
		if (false !== ($error = $this->sanitize($this->_module))) {
			return $error;
		}
		
		if (false !== Common::getPost('edit')) {
			return $this->onEdit($this->_module).$this->templateEdit($this->_module);
		}
		
		if (false !== Common::getPost('delete')) {
			return $this->onDelete($this->_module);
		}
		
		return $this->templateEdit($this->_module);
	}
	
	### Sane
	private function sanitize(Module_Links $module)
	{
		if (false === ($this->link = GWF_Links::getByID(Common::getGet('lid')))) {
			return $this->_module->error('err_link');
		}
		
		if (false === $this->link->mayEdit(GWF_Session::getUser())) {
			return $this->_module->error('err_edit_perm');
		}
		
		return false;
	}
	
	### Form
	private function getForm(Module_Links $module)
	{
		$l = $this->link;
		$data = array(
			'link_score' => array(GWF_Form::STRING, $l->getVar('link_score'), $this->_module->lang('th_link_score'), $this->_module->lang('tt_link_score')),
			'link_gid' => array(GWF_Form::SELECT, GWF_GroupSelect::single('link_gid', $l->getGroupID(), true, true), $this->_module->lang('th_link_gid'), $this->_module->lang('tt_link_gid')),
			'tag_info' => array(GWF_Form::HEADLINE, '', $this->_module->lang('info_tag')),
			'known_tags' => array(GWF_Form::HEADLINE, '', $this->collectTags($this->_module)),
			'link_tags' => array(GWF_Form::STRING, $l->getVar('link_tags'), $this->_module->lang('th_link_tags')),
			'div1' => array(GWF_Form::DIVIDER),
			'link_href' => array(GWF_Form::STRING, $l->getVar('link_href'), $this->_module->lang('th_link_href'), $this->_module->lang('tt_link_href')),
			'link_descr' => array(GWF_Form::STRING, $l->getVar('link_descr'), $this->_module->lang('th_link_descr')),
		);
		if ($this->_module->cfgLongDescription()) {
			$data['link_descr2'] = array(GWF_Form::MESSAGE, $l->display('link_descr2'), $this->_module->lang('th_link_descr2'));
		}
		$data['link_options&'.GWF_Links::UNAFILIATE] = array(GWF_Form::CHECKBOX, $l->isUnafiliated(), $this->_module->lang('th_link_options&'.GWF_Links::UNAFILIATE));
		$data['link_options&'.GWF_Links::MEMBER_LINK] = array(GWF_Form::CHECKBOX, $l->isMemberLink(), $this->_module->lang('th_link_options&'.GWF_Links::MEMBER_LINK));
		$data['link_options&'.GWF_Links::ONLY_PRIVATE] = array(GWF_Form::CHECKBOX, $l->isPrivate(), $this->_module->lang('th_link_options&'.GWF_Links::ONLY_PRIVATE));
		if (GWF_User::isStaffS())
		{
			$data['link_options&'.GWF_Links::STICKY] = array(GWF_Form::CHECKBOX, $l->isSticky(), $this->_module->lang('th_link_options&'.GWF_Links::STICKY));
			$data['link_options&'.GWF_Links::IN_MODERATION] = array(GWF_Form::CHECKBOX, $l->isInModeration(), $this->_module->lang('th_link_options&'.GWF_Links::IN_MODERATION));
		}
		$data['edit'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_edit'), '');
		$data['delete'] = array(GWF_Form::SUBMIT, $this->_module->lang('btn_delete'), '');
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
		$form = $this->getForm($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_edit')),
		);
		return $this->_module->templatePHP('edit.php', $tVars);
	}
	
	### Action
	private function onDelete(Module_Links $module)
	{
		if (false !== ($error = $this->link->deleteLink($this->_module))) {
			return $error;
		}
		return $this->_module->message('msg_deleted');
	}
	
	private function onEdit(Module_Links $module)
	{
		$form = $this->getForm($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
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
		
		$this->link->insertTags($this->_module);
		
		$this->link->saveOption(GWF_Links::UNAFILIATE, isset($_POST['link_options&'.GWF_Links::UNAFILIATE]));
		$this->link->saveOption(GWF_Links::MEMBER_LINK, isset($_POST['link_options&'.GWF_Links::MEMBER_LINK]));
		$this->link->saveOption(GWF_Links::ONLY_PRIVATE, isset($_POST['link_options&'.GWF_Links::ONLY_PRIVATE]));
		if (GWF_User::isStaffS())
		{
			$this->link->saveOption(GWF_Links::STICKY, isset($_POST['link_options&'.GWF_Links::STICKY]));
			
			if (false === $this->link->toggleModeration($this->_module, isset($_POST['link_options&'.GWF_Links::IN_MODERATION]))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		
		return $this->_module->message('msg_edited');
	}
	
	##################
	### Validators ###
	##################
	public function validate_link_gid(Module_Links $module, $arg) { return GWF_LinksValidator::validate_gid($this->_module, $arg); }
	public function validate_link_score(Module_Links $module, $arg) { return GWF_LinksValidator::validate_score($this->_module, $arg); }
	public function validate_link_tags(Module_Links $module, $arg) { return GWF_LinksValidator::validate_tags($this->_module, $arg); }
	public function validate_link_href(Module_Links $module, $arg) { return GWF_LinksValidator::validate_href($this->_module, $arg, false); }
	public function validate_link_descr(Module_Links $module, $arg) { return GWF_LinksValidator::validate_descr1($this->_module, $arg); }
	public function validate_link_descr2(Module_Links $module, $arg) { return GWF_LinksValidator::validate_descr2($this->_module, $arg); }
		
}

?>