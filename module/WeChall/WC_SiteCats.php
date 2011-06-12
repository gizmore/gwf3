<?php
final class WC_SiteCats extends GDO
{
	const MAX_LEN = 32;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_sitecat'; }
	public function getColumnDefines()
	{
		return array(
			'sitecat_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, self::MAX_LEN),
			'sitecat_sid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sitecat_bit' => array(GDO::UINT|GDO::INDEX, 0),
		);
	}
	
	public static function flush()
	{
		return self::table(__CLASS__)->truncate();
	}
	
	public static function addToCat($siteid, $cat)
	{
		$entry = new self(array(
			'sitecat_name' => $cat,
			'sitecat_sid' => $siteid,
		));
		return $entry->replace();
	}
	
	###############
	### Catbits ###
	###############
	public static function fixCatBits()
	{
		self::table(__CLASS__)->truncate();
		
		require_once 'module/WeChall/WC_RegAt.php';
		$sites = WC_Site::getSites();
		$tag_c = array();
		foreach ($sites as $site)
		{
			$site instanceof WC_Site;
			
			$tags = $site->getTagArray();
			$curr = array();
			foreach ($tags as $tag)
			{
				$tag = trim($tag);
				if ($tag === '') {
					continue;
				}
				
				$curr[] = $tag;
				
				if (!isset($tag_c[$tag])) {
					$tag_c[$tag] = 1;
				}
				else {
					$tag_c[$tag]++;
				}

				self::addToCat($site->getID(), $tag);
			}
			
			$site->saveVars(array(
				'site_tagbits' => self::calcTagBits($tags, $tag_c),
				'site_tags' => implode(',', $curr),
			));
			
			WC_RegAt::fixTagBits($site, $site->getTagBits());
		}
		
		self::adjustBits($tag_c);
	}
	
	private static function adjustBits(array $tag_c)
	{
		$t = self::table(__CLASS__);
		$bit = 1;
		foreach ($tag_c as $tagname => $count)
		{
			$tagname = $t->escape($tagname);
			$t->update("sitecat_bit=$bit", "sitecat_name='$tagname'");
			$bit <<= 1;
		}
	}
	
	private static function calcTagBits(array $tags, array $tag_c)
	{
		$back = 0;
		foreach ($tags as $tag)
		{
			$t = 0x01;
			foreach ($tag_c as $tagname => $count)
			{
				if ($tag === $tagname) {
					break;
				}
				$t <<= 1;
			}
			$back |= $t;
		}
		return $back;
	}
	
	###################
	### Convinience ###
	###################
	public static function getCatForBit($bit)
	{
		$db = gdo_db();
		$bit = (int) $bit;
		$cats = GWF_TABLE_PREFIX.'wc_sitecat';
		$query = "SELECT sitecat_name n FROM $cats WHERE sitecat_bit='$bit'";
		if (false === ($result = $db->queryFirst($query))) {
			return false;
		}
		return $result['n'];
	}
	
	public static function getBitForCat($tag)
	{
		if ($tag === '' || !is_string($tag)) {
			return 0;
		}
		$db = gdo_db();
		$tag = $db->escape($tag);
		$cats = GWF_TABLE_PREFIX.'wc_sitecat';
		$query = "SELECT sitecat_bit b FROM $cats WHERE sitecat_name='$tag'";
		if (false === ($result = $db->queryFirst($query))) {
			return 0;
		}
		return (int) $result['b'];
	}
	
	public static function getAllCats($orderby='sitecat_name ASC')
	{
		return self::table(__CLASS__)->selectColumn('sitecat_name', '', $orderby);
	}
	
	public static function isValidCatName($cat)
	{
		$cat = self::escape($cat);
		return self::table(__CLASS__)->selectVar('1', "sitecat_name='$cat'") !== false;
	}
}

?>
