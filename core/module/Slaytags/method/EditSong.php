<?php
final class Slaytags_EditSong extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN, GWF_Group::STAFF); }
	
	public function execute(GWF_Module $module)
	{
		if (false === ($song = Slay_Song::getByID(Common::getGetString('stid'))))
		{
			return $this->_module->error('err_song');
		}
		
		if (isset($_POST['edit']))
		{
			return $this->onEdit($this->_module, $song).$this->templateEdit($this->_module, $song);
		}
		
		if (isset($_POST['flush_tags']))
		{
			return $this->onFlushTagsA($this->_module, $song).$this->templateEdit($this->_module, $song);
		}
		
		return $this->templateEdit($this->_module, $song);
	}

	private function templateEdit(Module_Slaytags $module, Slay_Song $song)
	{
		$form = $this->formEdit($this->_module, $song);
		$tVars = array(
			'song' => $song,
			'form' => $form->templateY($this->_module->lang('ft_edit_song')),
		);
		return $this->_module->template('edit_song.tpl', $tVars);
	}

	private function formEdit(Module_Slaytags $module, Slay_Song $song)
	{
		$data = array(
			'edit' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_edit')),
			'flush_tags' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_flush_tags')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onEdit(Module_Slaytags $module, Slay_Song $song)
	{
		$form = $this->formEdit($this->_module, $song);
		if (false !== ($error = $form->validate($this->_module)))
		{
			return $error;
		}
		
		return $this->_module->message('msg_song_edit');
	}
		
	private function onFlushTagsA(Module_Slaytags $module, Slay_Song $song)
	{
		$form = $this->formEdit($this->_module, $song);
		if (false !== ($error = $form->validate($this->_module)))
		{
			return $error;
		}
		
		if (false !== ($error = self::onFlushTags($this->_module, $song)))
		{
			return $error;
		}
		
		return $this->_module->message('msg_tags_flushed');
	}
	
	public static function onFlushTags(Module_Slaytags $module, Slay_Song $song)
	{
		$sid = $song->getID();
		
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