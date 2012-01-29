<?php
final class GWF_Language extends GDO
{
	const SUPPORTED = 0x01;
	const GOOGLE_HAS_IT = 0x02;
	
	###########
	### GDO ###
	###########
	public function getTableName() { return GWF_TABLE_PREFIX.'language'; }
	public function getClassName() { return __CLASS__; }
	public function getOptionsName() { return 'lang_options'; }
	public function getColumnDefines()
	{
		return array(
			'lang_id' => array(GDO::AUTO_INCREMENT),
			'lang_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, true, 64),
			'lang_nativename' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, false, 64),
			'lang_short' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, true, 3),
			'lang_iso' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, true, 2),
			'lang_options' => array(GDO::UINT, 0),
		);
	}
	public function getID() { return $this->getVar('lang_id'); }
	public function getISO() { return $this->getVar('lang_iso'); }
	
	public static function getByID($id) { return self::table(__CLASS__)->selectFirstObject('*', 'lang_id='.((int)$id)); }
	
	/**
	 * Get a language by ISO.
	 * @param string $iso
	 * @return GWF_Language
	 */
	public static function getByISO($iso)
	{
		# NoCache
// 		$iso = self::escape($iso);
// 		return self::table(__CLASS__)->selectFirstObject('*', "lang_iso='{$iso}'");
		
		# Cached
		static $CACHE = array();
		if (false === isset($CACHE[$iso]))
		{
			$eiso = self::escape($iso);
			$CACHE[$iso] = self::table(__CLASS__)->selectFirstObject('*', "lang_iso='{$eiso}'");
		}
		return $CACHE[$iso];
	}
	
	public static function isSupported($id) { return self::table(__CLASS__)->selectVar('1', 'lang_id='.((int)$id).' AND lang_options&1"') === '1'; }
	public static function getByIDOrUnknown($id)
	{
		$id = (int)$id;
		if ($id === 0)
		{
			return self::getUnknown();
		}
		if (false !== ($c = self::table(__CLASS__)->selectFirstObject('*', 'lang_id='.$id)))
		{
			return $c;
		}
		return self::getUnknown();
	}
	
	public static function getISOByID($id)
	{
		return self::table(__CLASS__)->selectVar('lang_iso', 'lang_id='.((int)$id));
	}
	
	###############
	### Unknown ###
	###############
	public static function getUnknown()
	{
		static $UNKNOWN = true;
		if ($UNKNOWN === true)
		{
			$UNKNOWN = new self(array(
				'lang_id' => '0',
				'lang_name' => 'Unknown',
				'lang_nativename' => 'Unknown',
				'lang_short' => '000',
				'lang_iso' => '00',
				'lang_options' => 0,
			));
		}
		return $UNKNOWN;
	}
	
	############
	### Init ###
	############
	private static $LANG = NULL;
	private static $ISO = GWF_DEFAULT_LANG;
	public static function getEnglish() { return new self(array('lang_id'=>'1','lang_name'=>'English','lang_nativename'=>'English','lang_short'=>'eng','lang_iso'=>'en','lang_options'=>'3')); }
	public static function getCurrentID() { return self::$LANG->getID(); }
	public static function getCurrentISO() { return self::$ISO; }
	public static function getCurrentLanguage() { return self::$LANG; }
	
	public static function setCurrentLanguage(GWF_Language $lang, $refresh_lang_cache=false)
	{
		self::$LANG = $lang;
		self::$ISO = $lang->getVar('lang_iso');
		return true;
	}
	
	public static function init()
	{
		# IN URL
		if (isset($_SERVER['REQUEST_URI']))
		{
			$pattern = '#^'.GWF_WEB_ROOT_NO_LANG.'([a-z]{2})(/.*)?$#D';
			if (preg_match($pattern, $_SERVER['REQUEST_URI'], $matches))
			{
				$iso = $matches[1];
				if (false !== (self::$LANG = GWF_Language::getByISO($iso)))
				{
					self::$ISO = $iso;
					return true;
				}
			}
		}
		
		# By account setting.
		if (false !== ($user = GWF_Session::getUser()))
		{
			if (false !== (self::$LANG = $user->getLanguage()))
			{
				self::$ISO = self::$LANG->getISO();
				return true;
			}
		}
		
		# Browser
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			$iso = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			if (false !== (self::$LANG = self::getByISO($iso)))
			{
				self::$ISO = $iso;
				return true;
			}
		}

		# Default
		if (false !== (self::$LANG = GWF_Language::getByISO(self::$ISO)))
		{
			return true;
		}
		
		# English
		return self::initEnglish();
	}
	
	public static function initEnglish()
	{
		if (false !== (self::$LANG = self::getEnglish()))
		{
			self::$ISO = 'en';
			return true;
		}
		return false;
	}
	
	###################
	### DisplayName ###
	###################
	private static $LANG_NAMES = true;
	private static function initLangNames() { if (self::$LANG_NAMES === true) { self::$LANG_NAMES = new GWF_LangTrans(GWF_CORE_PATH.'lang/language/languages'); } }
	public function displayName() { return $this->displayNameISO(GWF_Language::getCurrentISO()); }
	public function displayNameISO($iso)
	{
		self::initLangNames();
		return self::$LANG_NAMES->lang($this->getVar('lang_name'));
	}
	
	/**
	 * Get an array of all supported language.
	 * @return array|false
	 */
	public static function getSupported()
	{
		return GDO::table(__CLASS__)->selectObjects('*', 'lang_options&1');
	}
	public static function getAvailable()
	{
		return preg_split('/[;,]+/', GWF_SUPPORTED_LANGS);
	}
}
?>