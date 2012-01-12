<?php
final class Slaytags_EditLyrics extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($lyrics = Slay_Lyrics::getByIDs(Common::getGetString(''), Common::getGetString(''))))
		{
			return $this->_module->error('err_lyrics_unk');
		}
		
		return $this->templateEditLyrics($this->_module, $lyrics);
	}
	
	private function templateEditLyrics(Module_Slaytags $module, Slay_Lyrics $lyrics)
	{
		$form = $this->formEditLyrics($this->_module, $lyrics);
		
		$tVars = array(
		);
		
		return $this->_module->template('edit_lyrics', $tVars);
	}
	
	private function formEditLyrics(Module_Slaytags $module, Slay_Lyrics $lyrics)
	{
		$data = array(
			'lyrics' => array(GWF_Form::MESSAGE_NOBB, $lyrics->getVar('ssl_lyrics'), $this->_module->lang('th_lyrics')),
			'enabled' => array(GWF_Form::CHECKBOX, $lyrics->isEnabled(), $this->_module->lang('th_enabled')),
			'add' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_edit')),
		);
		return new GWF_Form($this, $data);
	}
}
?>