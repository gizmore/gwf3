<?php
final class Slaytags_EditLyrics extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute()
	{
		if (false === ($lyrics = Slay_Lyrics::getByIDs(Common::getGetString(''), Common::getGetString(''))))
		{
			return $this->module->error('err_lyrics_unk');
		}
		
		return $this->templateEditLyrics($lyrics);
	}
	
	private function templateEditLyrics(Slay_Lyrics $lyrics)
	{
		$form = $this->formEditLyrics($lyrics);
		
		$tVars = array(
		);
		
		return $this->module->template('edit_lyrics', $tVars);
	}
	
	private function formEditLyrics(Slay_Lyrics $lyrics)
	{
		$data = array(
			'lyrics' => array(GWF_Form::MESSAGE_NOBB, $lyrics->getVar('ssl_lyrics'), $this->module->lang('th_lyrics')),
			'enabled' => array(GWF_Form::CHECKBOX, $lyrics->isEnabled(), $this->module->lang('th_enabled')),
			'add' => array(GWF_Form::SUBMIT, $this->module->lang('btn_edit')),
		);
		return new GWF_Form($this, $data);
	}
}
?>