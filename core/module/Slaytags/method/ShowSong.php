<?php
final class Slaytags_ShowSong extends GWF_Method
{
	public function execute()
	{
		if (false === ($this->song = Slay_Song::getByID(Common::getGetString('song'))))
		{
			return $this->module->error('err_song');
		}
		
		return $this->templateSong();
	}
	
	private function templateSong()
	{
		$tVars = array(
			'song' => $this->song,
			'playing' => false,
			'left' => 0,
		);
		return $this->module->template('song.tpl', $tVars);
	}
}
