<?php
/**
 * Page Tags
 * @see GWF_PageTagMap
 * @author gizmore
 */
final class GWF_PageTags extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'page_tags'; }
	public function getColumnDefines()
	{
		return array(
			'ptag_tid' => array(GDO::UINT|GDO::AUTO_INCREMENT),
			'ptag_lang' => array(GDO::UINT, GDO::NOT_NULL),
			'ptag_tag' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::INDEX, GDO::NOT_NULL, 63),
			'ptag_count' => array(GDO::UINT|GDO::INDEX, 0),
		);
	}
	
	#################
	### Insertion ###
	#################
	/**
	 * Fill the tag tables for a page.
	 * @param GWF_Page $page
	 * @param array $tags
	 * @return boolean
	 */
	public static function updateTags(GWF_Page $page, $tags, $langid)
	{
		if (false === GWF_PageTagMap::onDelete($page))
		{
			return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$pid = $page->getID();
		
		foreach (explode(',', $tags) as $tag)
		{
			$tag = trim($tag);
			if ($tag !== '')
			{
				if (!self::insertTag($tag, $pid, $langid))
				{
					return false;
				}
			}
		}
		
		if (false === self::cleanupTags())
		{
			return false;
		}
		
		return true;
	}
	
	private static function insertTag($tag, $pid, $langid)
	{
		# Insert tagname
		$etag = GDO::escape($tag);
		$langid = (int)$langid;
		if (false === ($tid = GDO::table(__CLASS__)->selectVar('ptag_tid', "ptag_tag='{$etag}' AND ptag_lang={$langid}")))
		{
			$newtag = new self(array(
				'ptag_tid' => '0',
				'ptag_lang' => $langid,
				'ptag_tag' => $tag,
				'ptag_count' => '1',
			));
			if (false === $newtag->insert())
			{
				return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			if (0 == ($tid = $newtag->getID()))
			{
				return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		# Insert into map
		$data = array('ptm_pid' => $pid, 'ptm_tid' => $tid);
		if (false === GDO::table('GWF_PageTagMap')->insertAssoc($data, true))
		{
			return GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return true;
	}
	
	###############
	### Cleanup ###
	###############
	/**
	 * Remove unused tags and fix counters.
	 * @return boolean
	 */
	public static function cleanupTags()
	{
		$t = GDO::table('GWF_PageTagMap')->getTableName();
		$tags = GDO::table(__CLASS__);
		if (!$tags->update("ptag_count=(SELECT COUNT(*) FROM `$t` WHERE ptm_tid=ptag_tid)"))
		{
			return false;
		}
		if (!$tags->deleteWhere('ptag_count=0'))
		{
			return false;
		}
		return true;
	}
	
	#############
	### Cloud ###
	#############
	public static function getTagMapData($langid)
	{
		$langid = (int)$langid;
		return self::table(__CLASS__)->selectArrayMap('ptag_tag, ptag_count', 'ptag_lang='.$langid, 'ptag_tag ASC');
	}
}
?>