<?php
final class Slay_SongTag extends GDO
{
	const SCALE = 10000;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'slay_songtag'; }
	public function getColumnDefines()
	{
		return array(
			'sst_sid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'sst_tid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'sst_count' => array(GDO::UINT|GDO::INDEX, 0),
			'sst_average' => array(GDO::UINT, 0), # between 0 and 10000
		
			'tags' => array(GDO::JOIN, GDO::NULL, array('Slay_Tag', 'sst_tid', 'st_id')),
			'songs' => array(GDO::JOIN, GDO::NULL, array('Slay_Song', 'sst_sid', 'ss_id')),
		);
	}
	
	public static function getVotes(Slay_Song $song)
	{
		$sid = $song->getID();
		return self::table(__CLASS__)->selectArrayMap('st_name, sst_count', "sst_sid={$sid}", 'st_name ASC', array('tags'), GDO::ARRAY_A);
	}
	
	public static function computeVotes(Slay_Song $song, $taggers=0)
	{
		$sid = $song->getID();
		$cache = array();
		$table = self::table(__CLASS__);
		foreach (Slay_Tag::getAllTags() as $tag_obj)
		{
			$tid = $tag_obj->getID();
			
			if (false === ($count = Slay_TagVote::countVotes($sid, $tid)))
			{
				return false;
			}

			$avg = $taggers > 0 ? (int)($count / $taggers * self::SCALE) : 0;
			
			if ($count > 0)
			{
				$cache[$tag_obj->getVar('st_name')] = $count;
			}
			
			if (false === $table->insertAssoc(array(
				'sst_sid' => $sid,
				'sst_tid' => $tid,
				'sst_count' => $count,
				'sst_average' => $avg,
			), true))
			{
				return false;
			}
		}
		
		# Cleanup empties
		if (false === $table->deleteWhere("sst_count=0"))
		{
			return false;
		}

		# Build cache
		$cc = NULL;
		if (count($cache) > 0)
		{
			arsort($cache);
			foreach ($cache as $tname => $count)
			{
				$cc .= sprintf(', %s(%.02f%%)', $tname, $count/$taggers*100);
			}
			$cc = substr($cc, 2);
		}
		if (false === $song->saveVar('ss_tag_cache', $cc))
		{
			return false;
		}
		
		return true;
	}
}
?>