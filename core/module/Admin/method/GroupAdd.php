<?php
final class Admin_GroupAdd extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('add')) {
			return $this->onAdd($module);
		}
		return $this->templateAdd($module);
	}
	
	private function templateAdd(Module_Admin $module)
	{
		$form = $this->getForm($module);
		
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_add_group')),
		);
		return $module->templatePHP('group_add.php', $tVars);
	}
	
	private function getForm(Module_Admin $module)
	{
		$data = array(
			'groupname' => array(GWF_Form::STRING, '', $module->lang('th_group_name')),
			'add' => array(GWF_Form::SUBMIT, $module->lang('btn_add_group')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_groupname(Module_Admin $m, $arg) { return GWF_Validator::validateClassname($m, 'groupname', $arg, 3, 24, true); }
	private function onAdd(Module_Admin $module)
	{
		$form = $this->getForm($module);
		if (false !== ($err = $form->validate($module))) {
			return $err.$this->templateAdd($module);
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
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateAdd($module);
		}
		
		return $module->message('msg_group_added');
	}
}
?>