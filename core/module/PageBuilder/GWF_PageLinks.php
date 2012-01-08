<?php
/**
 * Simple url => href RewriteRule
 * @example foo => http://google.com
 * @example bar => foobar
 * @author spaceone
 */
final class GWF_PageLinks extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'page_links'; }
	public function getColumnDefines()
	{
		return array(
			'link_url' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, 255),
			'link_href' => self::getURLDefine(GDO::NOT_NULL),
		);
	}

	public function getURL() { return $this->getVar('link_url'); }
	public function getHREF() { return $this->getVar('link_href'); }

	public static function insertLink($url, $href)
	{
		$link = new self(array('link_url' => $url, 'link_href' => $href));
		return $link->insert();
	}

	public static function deleteLink($url)
	{
		if (false === ($link = self::table(__CLASS__)->getBy('link_url', $url)))
		{
			return false;
		}
		return $link->delete();
	}
}
