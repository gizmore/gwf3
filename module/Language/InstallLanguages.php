<?php
final class InstallLanguages
{
	public static function onInstall(Module_Language $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'edit_time' => array('5m', 'time', 0, GWF_Time::ONE_HOUR),
//			'lang_by_domain' => array('YES', 'bool'),
		)).self::installSupported($module, $dropTables).
		self::installGoogleHasIt($module, $dropTables);
	}
	
	private static function installSupported(Module_Language $module, $dropTables)
	{
		$back = '';
		$s = GWF_Language::SUPPORTED;
		
		if (false === GDO::table('GWF_Language')->update("lang_options=lang_options-$s", "lang_options&$s")) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		$supported = explode(';', GWF_SUPPORTED_LANGS);
		foreach ($supported as $iso)
		{
			if (false === ($lang = GWF_Language::getByISO($iso))) {
				$back .= GWF_HTML::err('ERR_UNKNOWN_LANGUAGE', array( $iso));
				continue;
			}
			if (false === $lang->saveOption($s, true)) {
				$back .= GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		return $back;
	}

	private static function installGoogleHasIt(Module_Language $module, $dropTables)
	{
		$data = array(
			'af','sq','ar','hy','az','eu','be','bg','ca','zh-CN',
			'hr','cs','da','nl','en','et','tl','fi','fr','gl',
			'ka','de','el','ht','iw','hi','hu','is','id','ga',
			'it','ja','ko','lv','lt','mk','ms','mt','no','fa',
			'pl','pt','ro','ru','sr','sk','sl','es','sw','sv',
			'th','tr','uk','ur','vi','cy','yi',
		);
		$s = GWF_Language::GOOGLE_HAS_IT;
		if (false === GDO::table('GWF_Language')->update("lang_options=lang_options-$s", "lang_options&$s")) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)); // TODO: return value ?
		}
		foreach ($data as $iso)
		{
			if (false === ($lang = GWF_Language::getByISO($iso))) {
//				var_dump($iso);
				GWF_HTML::err('ERR_UNKNOWN_LANGUAGE', array( $iso));
				continue;
			}
			if (false === $lang->saveOption($s, true)) {
				GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}	
		return '';
	}
}
