<?php
final class Slaytags_AddLyrics extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		if (false === ($song = Slay_Song::getByID(Common::getGetString('stid'))))
		{
			return $this->_module->error('err_song');
		}
		
		if (isset($_POST['add']))
		{
			return $this->onAddLyrics($this->_module, $song).$this->templateAddLyrics($this->_module, $song);
		}
		
		return $this->templateAddLyrics($this->_module, $song);
	}
	
	private function templateAddLyrics(Module_Slaytags $module, Slay_Song $song)
	{
		$form = $this->formAddLyrics($this->_module, $song);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_add_lyrics')),
		);
		return $this->_module->template('add_lyrics.tpl', $tVars);
	}

	private function formAddLyrics(Module_Slaytags $module, Slay_Song $song)
	{
		$user = GWF_Session::getUser();
		$data = array(
			'lyrics' => array(GWF_Form::MESSAGE_NOBB, Slay_Lyrics::getLyrics($song, $user), $this->_module->lang('th_lyrics')),
			'enabled' => array(GWF_Form::CHECKBOX, Slay_Lyrics::isEnabledLyrics($song, $user), $this->_module->lang('th_enabled')),
			'add' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_add_lyrics')),
		);
		return new GWF_Form($this, $data);
	}

	public function validate_lyrics($m, $arg) { return GWF_Validator::validateString($m, 'lyrics', $arg, 32, Slay_Lyrics::MAX_LENGTH); }
	
	private function onAddLyrics(Module_Slaytags $module, Slay_Song $song)
	{
		$form = $this->formAddLyrics($this->_module, $song);
		if (false !== ($error = $form->validate($this->_module)))
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
		
		return $this->_module->message('msg_added_lyrics');
	}
}
?>