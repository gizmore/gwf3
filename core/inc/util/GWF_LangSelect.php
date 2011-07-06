<?php
final class GWF_LangSelect
{
	const TYPE_ALL = 0;
	const TYPE_SUPPORTED = 1;
	const TYPE_GOOGLE = 2;
	
	public static function single($bitmask=0, $name='language', $selected=true)
	{
		$db = gdo_db();
		$table = GDO::table('GWF_Language');
		$bitmask = (int)$bitmask;
		if (false === ($result = $table->select('lang_id, lang_name', "lang_options&$bitmask=$bitmask"))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if ($selected === true) {
			$selected = Common::getPostString($name);
		}
		
		$data = array(array('0',GWF_HTML::lang('sel_language')));
		while (false !== ($row = $db->fetchRow($result)))
		{
			$data[] = $row;
		}
		$db->free($result);
		return GWF_Select::display($name, $data, Common::getPostString($name, $selected));
	}
	
	#################
	### Validator ###
	#################
	public static function validate_langid($langid, $allow_zero=false)
	{
		return self::isValidLanguage($langid, $allow_zero) ? false : GWF_HTML::lang('ERR_UNKNOWN_LANGUAGE');
	}	
	
	public static function isValidLanguage($langid, $allow_zero=false)
	{
		$min = $allow_zero === true ? -1 : 0;
		if ($min >= ($langid = (int) $langid)) {
			return false;
		}
		return $langid == 0 ? true : (GWF_Language::getByID($langid) !== false);
	}
	
	public static function validate_langidMulti($langids, $allow_zero=false)
	{
		if (!(is_array($langids))) {
			return $allow_zero ? false : GWF_HTML::lang('ERR_UNKNOWN_LANGUAGE');
		}
		$success = true;
		foreach ($langids as $langid)
		{
			if ($langid === '0')
			{
				if (!$allow_zero)
				{
					$success = false;
					break;
				}
			}
			elseif (false === self::getByID($langid))
			{
				$success = false;
				break;
			}
		}
		return $success ? false : GWF_HTML::lang('ERR_UNKNOWN_LANGUAGE');
	}
}
?>