<?php
final class GWF_LangMap extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'langmap'; }
	public function getColumnDefines()
	{
		return array(
			'langmap_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'langmap_lid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
		);
	}

	public static function getPrimaryLangID($countryid)
	{
		if (0 === ($countryid = (int) $countryid))
		{
			return 0;
		}
		if (false === ($result = self::table(__CLASS__)->selectVar('langmap_lid', 'langmap_cid='.$countryid, 'langmap_lid ASC')))
		{
			return 0;
		}
		return $result;
	}

	public static function getPrimaryCountryID($langid)
	{
		if (0 === ($langid = (int) $langid))
		{
			return 0;
		}
		if (false === ($result = self::table(__CLASS__)->selectVar('langmap_cid', 'langmap_lid='.$langid, 'langmap_cid ASC')))
		{
			return 0;
		}
		return $result;
	}
}

