<?php
final class Slaytags_AddLyrics extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($song = Slay_Song::getByID(Common::getGetString('stid'))))
		{
			return $module->error('err_song');
		}
		
		if (isset($_POST['add']))
		{
			return $this->onAddLyrics($module, $song).$this->templateAddLyrics($module, $song);
		}
		
		return $this->templateAddLyrics($module, $song);
	}
	
	private function templateAddLyrics(Module_Slaytags $module, Slay_Song $song)
	{
		$form = $this->formAddLyrics($module, $song);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_add_lyrics')),
		);
		return $module->template('add_lyrics.tpl', $tVars);
	}

	private function formAddLyrics(Module_Slaytags $module, Slay_Song $song)
	{
		$user = GWF_Session::getUser();
		$data = array(
			'lyrics' => array(GWF_Form::MESSAGE_NOBB, Slay_Lyrics::getLyrics($song, $user), $module->lang('th_lyrics')),
			'enabled' => array(GWF_Form::CHECKBOX, Slay_Lyrics::isEnabledLyrics($song, $user), $module->lang('th_enabled')),
			'add' => array(GWF_Form::SUBMIT, $module->lang('btn_add_lyrics')),
		);
		return new GWF_Form($this, $data);
	}

	public function validate_lyrics($m, $arg) { return GWF_Validator::validateString($m, 'lyrics', $arg, 32, Slay_Lyrics::MAX_LENGTH); }
	
	private function onAddLyrics(Module_Slaytags $module, Slay_Song $song)
	{
		$form = $this->formAddLyrics($module, $song);
		if (false !== ($error = $form->validate($module)))
		{
			return $error;
		}
		
		$options = isset($_POST['enabled']) ? Slay_Lyrics::ENABLED : 0;
		
		if (false === GDO::table('Slay_Lyrics')->insertAssoc(array(
			'ssl_sid' => $song->getID(),
			'ssl_uid' => GWF_Session::getUserID(),
			'ssl_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'ssl_edit_date' => NULL,
			'ssl_lyrics' => $form->getVar('lyrics'),
			'ssl_options' => $options,
		), true))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $song->updateLyricsCount())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $module->message('msg_added_lyrics');
	}
}
?>