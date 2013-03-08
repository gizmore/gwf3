<?php
final class Slaytags_EditSong extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF, 'dj'); }
	
	public function execute()
	{
		if (false === ($song = Slay_Song::getByID(Common::getGetString('stid'))))
		{
			return $this->module->error('err_song');
		}
		
		$this->module->includeClass('Slay_KeySelect');
		
		if (isset($_POST['edit']))
		{
			return $this->onEdit($song).$this->templateEdit($song);
		}
		
		if (isset($_POST['flush_tags']))
		{
			return $this->onFlushTagsA($song).$this->templateEdit($song);
		}
		
		return $this->templateEdit($song);
	}
	
	public function validate_bpm(Module_Slaytags $m, $arg) { return GWF_Validator::validateInt($m, 'bpm', $arg, 0, 255); }
	public function validate_key(Module_Slaytags $m, $arg) { return Slay_Key::validate('key', $arg, true); }
	

	private function templateEdit(Slay_Song $song)
	{
		$form = $this->formEdit($song);
		$tVars = array(
			'song' => $song,
			'form' => $form->templateY($this->module->lang('ft_edit_song')),
		);
		return $this->module->template('edit_song.tpl', $tVars);
	}

	private function formEdit(Slay_Song $song)
	{
		$data = array(
			'bpm' => array(GWF_Form::INT, $song->getVar('ss_bpm'), $this->l('th_bpm')),
			'key' => array(GWF_Form::ENUM, $song->displayKey(), $this->l('th_key'), '', Slay_Key::data()),
			'edit' => array(GWF_Form::SUBMIT, $this->module->lang('btn_edit')),
			'flush_tags' => array(GWF_Form::SUBMIT, $this->module->lang('btn_flush_tags')),
		);
		return new GWF_Form($this, $data);
	}
	
// 	private function 
	
	private function onEdit(Slay_Song $song)
	{
		$form = $this->formEdit($song);
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		$song->saveVars(array(
			'ss_bpm' => $form->getVar('bpm'),
			'ss_key' => $form->getVar('key'),
		));
		
		return $this->module->message('msg_song_edit');
	}
		
	private function onFlushTagsA(Slay_Song $song)
	{
		$form = $this->formEdit($song);
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		if (false !== ($error = self::onFlushTags($song)))
		{
			return $error;
		}
		
		return $this->module->message('msg_tags_flushed');
	}
	
	public static function onFlushTags(Slay_Song $song)
	{
		$sid = $song->getID();
		
		if (!GWF_User::isInGroupS(GWF_Group::STAFF))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false === GDO::table('Slay_SongTag')->deleteWhere("sst_sid={$sid}"))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === GDO::table('Slay_TagVote')->deleteWhere("stv_sid={$sid}"))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if (false === $song->saveVars(array(
			'ss_taggers' => '0',
			'ss_tag_cache' => NULL,
		)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return false;
	}
}
?>