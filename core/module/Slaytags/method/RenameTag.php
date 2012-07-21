<?php
final class Slaytags_RenameTag extends GWF_Method
{
	/**
	 * @var Slay_Tag
	 */
	private $tag;
	
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute()
	{
		$this->module->includeClass('Slay_TagSelect');
		$back = '';
		
		if (isset($_POST['rename_tag']))
		{
			$back = $this->onRenameTag();
		}
		return $back.$this->templateRenameTag();
	}
	
	private function formRenameTag()
	{
		$data = array(
			'tag_old' => array(GWF_Form::SELECT, Slay_TagSelect::singleSelect('tag_old'), $this->module->lang('th_tag_old')),
			'tag_new' => array(GWF_Form::STRING, '', $this->module->lang('th_tag_new')),
			'rename_tag' => array(GWF_Form::SUBMIT, $this->module->lang('btn_rename_tag')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateRenameTag()
	{
		$form = $this->formRenameTag();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_rename_tag')),
		);
		return $this->module->template('rename_tag.tpl', $tVars);
	}
	
	private function onRenameTag()
	{
		$form = $this->formRenameTag();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		if (false === $this->tag->saveVars(array(
			'st_name' => $form->getVar('tag_new'),
		)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_renamed_tag');
	}
	
	public function validate_tag_old($m, $arg)
	{
		if (false === ($this->tag = Slay_Tag::getByID($arg)))
		{
			return $m->lang('err_unknown_tag');
		}
		
		return false;
	} 

	public function validate_tag_new($m, $arg)
	{
		if (false !== Slay_Tag::getByName($arg))
		{
			return $m->lang('err_tag_exists');
		}
		
		return false;
	}
}
?>