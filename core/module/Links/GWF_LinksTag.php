<?php
/**
 * Tagged Link Cloud
 * @author gizmore
 */
final class GWF_LinksTag extends GDO
{
	##########
	## GDO ###
	##########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'links_tag'; }
	public function getColumnDefines()
	{
		return array(
			'lt_id' => array(GDO::AUTO_INCREMENT),
			'lt_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::UNIQUE, true, 63),
			'lt_count' => array(GDO::UINT, 1),
//			'ltmap' => array(GDO::JOIN, NULL, array('GWF_LinksTagMap', 'lt_id', 'ltm_ltid')),
		);
	}
	
	##################
	### Convinient ###
	##################
	public function getID() { return $this->getVar('lt_id'); }
	public function getCount() { return $this->getVar('lt_count'); }
	public function displayName() { return $this->display('lt_name'); }
	
	#############
	### HREFs ###
	#############
	public function hrefOverview() { return GWF_WEB_ROOT.'links/'.$this->urlencode('lt_name'); }
	
	##############
	### Static ###
	##############
	/**
	 * Get a tag by name.
	 * @param string $tagname
	 * @return GWF_LinksTag
	 */
	public static function getByName($tagname)
	{
		return self::table(__CLASS__)->selectFirstObject('*', "lt_name='".self::escape($tagname)."'");
	}
	
	/**
	 * Check if a tag exists. Return a default value if not.
	 * @param string $tagname
	 * @param string $default
	 */
	public static function getWhitelistedTag($tagname, $default='')
	{
		return self::getByName($tagname) === false ? $default : $tagname;
	}
	
	/**
	 * Get the cached cloud.
	 * @param string $orderby
	 * @return array the cloud
	 */
	public static function getCloud($orderby='lt_name ASC')
	{
		static $tags = true;
		static $last_orderby = true;
		
		if ($last_orderby === $orderby) {
			if ($tags === true) { die('WRONG_ARGS_ERR in '.__FILE__.' line '.__LINE__); }
			return $tags;
		}
		else {
			$tags = true;
		}
		$last_orderby = $orderby;
		$tags = $table = self::table(__CLASS__)->selectObjects('*', '', $orderby);
		return $tags;
	}
	
	####################
	### Add / Remove ###
	####################
	public static function addTag(GWF_Links $link, $tagname)
	{
		if (false === ($tag = self::getByName($tagname))) {
			$tag = new self(array(
				'lt_name' => $tagname,
				'lt_count' => 1,
			));
			return $tag->insert();
		}
		return $tag->increase('lt_count', 1);
	}
	
	public static function removeTag(GWF_Links $link, $tagname)
	{
		if (false === ($tag = self::getByName($tagname))) {
			return false;
		}
		if ($tag->getVar('lt_count') > 1) {
			return $tag->increase('lt_count', -1);
		}
		else {
			return $tag->delete();
		}
	}
}
?>
