<?php
final class Slay_Install
{
	public static function install(Module_Slaytags $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'slay_time_off' => array('0', 'int', '-172800', '172800'),
		)).
		self::defaultTags($module, $dropTables);
	}
	
	private static function defaultTags(Module_Slaytags $module, $dropTables)
	{
		$tags = array(
			'Rock', 'Pop', 'Classic', 'Siddy', 'Metal', 'Punk', 'Dance', 'Raggae', 'HipHop', 'Rap',
			'Trance', 'Techno', 'Instrumental', 'Funk', 'Caribian', 'Acapella', 'Country', 'Orchestral',
			'DrumAndBass', 'BreakBeat', 'Goa', 'Gabba', 'Ambient', 'Piano', 'Intro', 'Lyrics', 'Progressive',
			'Melodic', 'Piano', 'Guitar', 'Bassy', 'Happy', 'Melancholic', 'Minimal', 'Relax', 'Funky', 'Oriental',
			'Electro', 'House', 'Game', 'Tribal', 'Slow', 'Fast', 'Medieval', 'Theme', '80s', 'Spheric', 'Blues', 'Jazz',
			'Acid',
		);

		$table = GDO::table('Slay_Tag');
		foreach ($tags as $tag)
		{
			if (false === Slay_Tag::getByName($tag))
			{
				if (false === $table->insertAssoc(array(
					'st_id' => 0,
					'st_uid' => 0,
					'st_name' => $tag,
				), true))
				{
					return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
				}
			}
		}
		return '';
	}
}
?>