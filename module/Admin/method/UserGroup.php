<?php
/**
 * Show all groups a particular user is in. 
 * @author gizmore
 */
final class Admin_UserGroup extends GWF_Method
{
	public function isLoginRequired() { return true; }
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($user = GWF_User::getByID(intval(Common::getGet('uid', '0'))))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		$user->loadGroups();
		
		if (false !== Common::getPost('add_to_group')) {
			return $this->onAddToGroup($module, $user).$this->showGroups($module, $user);
		}
		
		return $this->showGroups($module, $user);
	}

	public function validate_groups(Module_Admin $module, $arg) { return false; }
	public function onAddToGroup(Module_Admin $module, GWF_User $user)
	{
		$form = $this->getFormAdd($module, $user);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}
		
		if (false === ($group = GWF_Group::getByID($form->getVar('groups')))) {
			return $module->error('err_group');
		}
		
		if ($user->isInGroupID($group->getID())) {
			return $module->error('err_in_group');
		}
		
		if (!$user->addToGroup($group->getVar('group_name'), false)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$user->loadGroups();
		
		return $module->message('msg_added_to_grp', array($user->displayUsername(), $group->displayName()));
	}
	
	public function showGroups(Module_Admin $module, GWF_User $user)
	{
		
		$form = $this->getFormAdd($module, $user);
		
		$tVars = array(
			'form_action' => $this->getMethodHref('&uid='.$user->getID()),
			'form_add' => $form->templateX($module->lang('ft_add_to_group')),
			'user' => $user,
			'groups' => $user->getGroups(), 
		);
		return $module->templatePHP('usergroup.php', $tVars);
	}
	
	private function getFormAdd(Module_Admin $module, GWF_User $user)
	{
		$data = array(
			'groups' => array(GWF_Form::SELECT, $this->getGroupSelect($module, $user), $module->lang('th_group_name')),
			'add_to_group' => array(GWF_Form::SUBMIT, $module->lang('btn_add_to_grp')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getGroupSelect(Module_Admin $module, GWF_User $user)
	{
		$groups = GDO::table('GWF_Group')->selectAll('group_id, group_name');
		$data = array();
		$data[] = array($module->lang('sel_group'), 0);
		foreach ($groups as $group)
		{
			if (!$user->isInGroupID($group['group_id']))
			{
				$data[] = array($group['group_name'], $group['group_id']);
			}
		}
		
		return GWF_Select::display('groups', $data, intval(Common::getPost('groups')));
	}
}

?>