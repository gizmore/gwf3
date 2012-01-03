<?php
final class Slaytags_AddTag extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		$user = GWF_Session::getUser();
		if (!Slay_Tag::mayAddTag($user))
		{
			return $module->error('err_add_tag');
		}
		
		if (isset($_POST['add']))
		{
			return $this->onAddTag($module);
		}
		return $this->templateAddTag($module);
	}
	
	private function templateAddTag(Module_Slaytags $module)
	{
		$form = $this->formAddTag($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_add_tag')),
		);
		return $module->template('add_tag.tpl', $tVars);
	}
	
	private function formAddTag(Module_Slaytags $module)
	{
		$data = array(
			'tag' => array(GWF_Form::STRING, '', $module->lang('th_tag')),
			'add' => array(GWF_Form::SUBMIT, $module->lang('btn_add')),
		);
		return new GWF_Form($this, $data);
	}

	public function validate_tag($m, $arg)
	{
		if (Slay_Tag::getByName($arg) !== false)
		{
			return $m->lang('err_dup_tag');
		}
		return GWF_Validator::validateString($m, 'tag', $arg, 1, 63, true);
	}
	
	private function onAddTag(Module_Slaytags $module)
	{
		$form = $this->formAddTag($module);
		if (false !== ($error = $form->validate($module)))
		{
			return $error.$this->templateAddTag($module);
		}
		
		$user = GWF_Session::getUser();
		
		$uid = $user->isStaff() ? '0' : $user->getID();
		
		GDO::table('Slay_Tag')->insertAssoc(array(
			'st_id' => 0,
			'st_uid' => $uid,
			'st_name' => $form->getVar('tag'),
		), false);
		
		
		$href = $module->getMethodURL('Tag', '&stid='.Common::getGetInt('stid', '0'));
		return $module->message('msg_tag_added', array($href));
	}
	
}
?>