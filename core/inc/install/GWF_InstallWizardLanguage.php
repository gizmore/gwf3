<?php
/**
 * Setup the correct language from /data/GWF_LanguageData.php
 * Of course it's inefficient to load language from this file.
 * @author gizmore
 */
final class GWF_InstallWizardLanguage
{
	public static function init()
	{
		return self::initB() ? true : GWF_Language::initEnglish();
	}
	
	private static function initB()
	{
		if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			return false;
		}
		$iso = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if (false === ($lang = self::getByISO($iso)))
		{
			return false;
		}
		return GWF_Language::setCurrentLanguage($lang);
	}
	
	private static function getByISO($iso)
	{
		require_once GWF_CORE_PATH.'inc/install/data/GWF_LanguageData.php';
		
		$i = 0;
		foreach (GWF_LanguageData::getLanguages() as $lang)
		{
			$i++;
			if ( (isset($lang[3])) && ($lang[3] === $iso) )
			{
				return new GWF_Language(array(
					'lang_id' => $i,
					'lang_name' => $lang[0],
					'lang_nativename' => $lang[1],
					'lang_short' => $lang[2],
					'lang_iso' => $iso,
					'lang_options' => '0',
				));
			}
		}
	}
}
?>