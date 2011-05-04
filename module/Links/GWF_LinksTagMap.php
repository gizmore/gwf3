<?php
final class GWF_LinksTagMap extends GDO
{
	##########
	## GDO ###
	##########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'links_tagmap'; }
	public function getColumnDefines()
	{
		return array(
			'ltm_lid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_Links', 'ltm_lid', 'link_id')),
			'ltm_ltid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_LinksTag', 'ltm_ltid', 'lt_id')),
		);
	}
	
	public static function remTags($linkid)
	{
		$linkid = (int) $linkid;
		return self::table(__CLASS__)->deleteWhere("ltm_lid=$linkid");
	}
	
	public static function addTag($linkid, $tagid)
	{
		$maprow = new self(array(
			'ltm_lid' => $linkid,
			'ltm_ltid' => $tagid,
		));
		if (false === ($maprow->replace())) {
			return false;
		}
		return $maprow;
	}
	
	public static function getCloud(Module_Links $module)
	{
//		$db = gdo_db();
		$back = array();
		
		if ($module->cfgShowPermitted()) {
			$conditions = '';
		} else {
			$conditions = $module->getPermQuery(GWF_Session::getUser());
		}

		$table = self::table('GWF_LinksTagMap');
		if (false === ($result = $table->select('lt_name, COUNT(*) lt_count, link_score', $conditions, 'lt_name ASC', array('ltm_lid', 'ltm_ltid')))) {
			return $back;
		}
		
		while (false !== ($row = $table->fetch($result, self::ARRAY_A)))
		{
			if ($row['lt_name'] !== NULL)
			{
				$back[] = new GWF_LinksTag($row);
			}
		}
		
		$table->free($result);
		
//		$map = self::table(__CLASS__);#->getTableName();
//		$tags = self::table('GWF_LinksTag')->getTableName();
//		$links = self::table('GWF_Links')->getTableName();
		
//		return $map
//		
//		if (false !== ($result = $db->queryAll("SELECT lt_name, COUNT(*) lt_count, link_score FROM $map LEFT JOIN $tags ON lt_id=ltm_ltid LEFT JOIN $links ON link_id=ltm_lid WHERE $conditions GROUP BY ltm_ltid ORDER BY lt_name ASC ")))
//		{
//			foreach ($result as $row)
//			{
//				$back[] = new GWF_LinksTag($row);
//			}
//		}

//		var_dump($back);
		
		return $back;
	}
}

?>
