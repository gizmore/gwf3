<?php
final class Admin_GroupAdd extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=Admin&me=GroupAdd',
						'page_title' => 'Add Group',
						'page_meta_desc' => 'Add a new group',
				),
		);
	}
	
	public function execute()
	{
		if (false !== Common::getPost('add')) {
			return $this->onAdd();
		}
		return $this->templateAdd();
	}
	
	private function templateAdd()
	{
		$form = $this->getForm();
		
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_add_group')),
		);
		return $this->module->template('group_add.tpl', $tVars);
	}
	
	private function getForm()
	{
		$data = array(
			'groupname' => array(GWF_Form::STRING, '', $this->module->lang('th_group_name')),
			'add' => array(GWF_Form::SUBMIT, $this->module->lang('btn_add_group')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_groupname(Module_Admin $m, $arg) { return GWF_Validator::validateClassname($m, 'groupname', $arg, 1, 24, true); }
	private function onAdd()
	{
		$form = $this->getForm();
		if (false !== ($err = $form->validate($this->module))) {
			return $err.$this->templateAdd();
		}
		
		$group = new GWF_Group(array(
			'group_id' => 0,
			'group_name' => $form->getVar('groupname'),
			'group_options' => GWF_Group::FULL|GWF_Group::SCRIPT,
			'group_lang' => 0,
			'group_country' => 0,
			'group_founder' => 0,
			'group_memberc' => 0,
			'group_bid' => 0,
			'group_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));
		
		if (false === ($group->insert()))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateAdd();
		}
		
		return $this->module->message('msg_group_added');
	}
}
?>
