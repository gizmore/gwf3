<?php
final class Slaytags_AddTag extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		$user = GWF_Session::getUser();
		if (!Slay_Tag::mayAddTag($user))
		{
			return $this->_module->error('err_add_tag');
		}
		
		if (isset($_POST['add']))
		{
			return $this->onAddTag();
		}
		return $this->templateAddTag();
	}
	
	private function templateAddTag()
	{
		$form = $this->formAddTag();
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_add_tag')),
		);
		return $this->_module->template('add_tag.tpl', $tVars);
	}
	
	private function formAddTag()
	{
		$data = array(
			'tag' => array(GWF_Form::STRING, '', $this->_module->lang('th_tag')),
			'add' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add')),
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
	
	private function onAddTag()
	{
		$form = $this->formAddTag();
		if (false !== ($error = $form->validate($this->_module)))
		{
			return $error.$this->templateAddTag();
		}
		
		$user = GWF_Session::getUser();
		
		$uid = $user->isStaff() ? '0' : $user->getID();
		
		GDO::table('Slay_Tag')->insertAssoc(array(
			'st_id' => 0,
			'st_uid' => $uid,
			'st_name' => $form->getVar('tag'),
		), false);
		
		
		$href = $this->_module->getMethodURL('Tag', '&stid='.Common::getGetInt('stid', '0'));
		return $this->_module->message('msg_tag_added', array($href));
	}
	
}
?>