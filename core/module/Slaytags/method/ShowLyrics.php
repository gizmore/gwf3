<?php
final class Slaytags_ShowLyrics extends GWF_Method
{
	public function execute()
	{
		if (false === ($song = Slay_Song::getByID(Common::getGetString('stid'))))
		{
			return $this->_module->error('err_song');
		}
		return $this->templateShowLyrics($song);
	}

	private function templateShowLyrics(Slay_Song $song)
	{
		$sid = $song->getID();
		$user = GWF_Session::getUser();
		$staff = $user->isStaff();
		$table = GDO::table('Slay_Lyrics');
		$perm = $staff ? '' : ' AND ssl_options&'.Slay_Lyrics::ENABLED;
		$where = "ssl_sid={$sid}{$perm}";
		$tVars = array(
			'song' => $song,
			'lyrics' => $table->selectAll('*', $where, 'ssl_date ASC', array('user'), -1, -1, GDO::ARRAY_O),
			'is_admin' => $staff,
		);
		return $this->_module->template('lyrics.tpl', $tVars);
	}
}
?>