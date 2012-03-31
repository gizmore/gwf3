<?php
/**
 * Language select and validation.
 * @author gizmore
 * @version 3.0
 * @since 3.0
 * @todo Multi select html function.
 */
final class GWF_LangSelect
{
	# Bitmasks
	const TYPE_ALL = 0;
	const TYPE_SUPPORTED = 1;
	const TYPE_GOOGLE = 2;

	/**
	 * Return a single html select for languages. 
	 * @param int $bitmask
	 * @param string $name param name
	 * @param mixed $selected 
	 * @param string $text
	 */
	public static function single($bitmask=0, $name='language', $selected=true, $text=true)
	{
		$db = gdo_db();
		$table = GDO::table('GWF_Language');
		$bitmask = (int)$bitmask;
		if (false === ($result = $table->select('lang_id, lang_name', "lang_options&$bitmask=$bitmask")))
		{
			GWF_Error::err('ERR_DATABASE', array(__FILE__, __LINE__));
			return '';
		}

		if ($selected === true)
		{
			$selected = Common::getPostString($name, '0');
		}

		if ($text === true)
		{
			$text = GWF_HTML::lang('sel_language');
		}

		$data = array(array('0', $text));

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
	public static function validate_langid($langid, $allow_zero=false, $bitmask=self::TYPE_ALL)
	{
		return self::isValidLanguage($langid, $allow_zero, $bitmask) ? false : GWF_HTML::lang('ERR_UNKNOWN_LANGUAGE');
	}	

	public static function isValidLanguage($langid, $allow_zero=false, $bitmask=self::TYPE_ALL)
	{
		$min = $allow_zero === true ? -1 : 0;
		if ($min >= ($langid = (int) $langid))
		{
			return false;
		}

		if ($langid === 0)
		{
			return true; # Zero allowed
		}

		if (false === ($lang = GWF_Language::getByID($langid)))
		{
			return false;
		}

		return $lang->isOptionEnabled($bitmask);
	}

	public static function validate_langidMulti($langids, $allow_zero=false, $bitmask=self::TYPE_ALL)
	{
		# Zero and nothing
		if (!(is_array($langids)))
		{
			return $allow_zero ? false : GWF_HTML::lang('ERR_UNKNOWN_LANGUAGE');
		}

		# Validate them all
		foreach ($langids as $langid)
		{
			if (!self::isValidLanguage($langid, false, $bitmask))
			{
				return GWF_HTML::lang('ERR_UNKNOWN_LANGUAGE');
			}
		}
		return false;
	}
}

