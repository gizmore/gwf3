<?php
/**
 * Show all groups a particular user is in. 
 * @author gizmore
 */
final class Admin_UserGroup extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute()
	{
		if (false === ($user = GWF_User::getByID(intval(Common::getGet('uid', '0'))))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		$user->loadGroups();
		
		if (false !== Common::getPost('add_to_group')) {
			return $this->onAddToGroup($user).$this->showGroups($user);
		}
		
		return $this->showGroups($user);
	}

	public function validate_groups(Module_Admin $module, $arg) { return false; }
	public function onAddToGroup(GWF_User $user)
	{
		$form = $this->getFormAdd($user);
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}
		
		$user->loadGroups();
		
		if (false === ($group = GWF_Group::getByID($form->getVar('groups'))))
		{
			return $this->module->error('err_group');
		}
		
		if ($user->isInGroupName($group->getName()))
		{
			return $this->module->error('err_in_group');
		}
		
		if (false === GWF_UserGroup::addToGroup($user->getID(), $group->getID()))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->module->message('msg_added_to_grp', array($user->displayUsername(), $group->display('group_name')));
	}
	
	public function showGroups(GWF_User $user)
	{
		
		$form = $this->getFormAdd($user);
		
		$tVars = array(
			'form_action' => $this->getMethodHref('&uid='.$user->getID()),
			'form_add' => $form->templateX($this->module->lang('ft_add_to_group')),
			'user' => $user,
			'groups' => $user->getGroups(), 
		);
		return $this->module->templatePHP('usergroup.php', $tVars);
	}
	
	private function getFormAdd(GWF_User $user)
	{
		$data = array(
			'groups' => array(GWF_Form::SELECT, $this->getGroupSelect($user), $this->module->lang('th_group_name')),
			'add_to_group' => array(GWF_Form::SUBMIT, $this->module->lang('btn_add_to_grp')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function getGroupSelect(GWF_User $user)
	{
		$groups = GDO::table('GWF_Group')->selectAll('group_id, group_name');
		$data = array();
		$data[] = array('0', $this->module->lang('sel_group'));
		foreach ($groups as $group)
		{
			if (!$user->isInGroupID($group['group_id']))
			{
				$data[] = array($group['group_id'], $group['group_name']);
			}
		}
		
		return GWF_Select::display('groups', $data, intval(Common::getPost('groups')));
	}
}

?>