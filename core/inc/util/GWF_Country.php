<?php
final class GWF_Country extends GDO
{
	###########
	### GDO ###
	###########
	public function getTableName() { return GWF_TABLE_PREFIX.'country'; }
	public function getClassName() { return __CLASS__; }
	public function getColumnDefines()
	{
		return array(
			'country_id' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'country_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, false, 63), 
			'country_tld' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, false, 2),
			'country_pop' => array(GDO::UINT, 0),
		);
	}

	public function getID() { return $this->getVar('country_id'); }

	/**
	 * Get a country by ID.
	 * @param int $id
	 * @return GWF_Country
	 */
	public static function getByID($id) { return self::table(__CLASS__)->getBy('country_id', $id); }

	/**
	 * Get a country by TLD, like cc for columbia.
	 * @param string $tld 2 letter tld
	 * @return GWF_Country
	 */
	public static function getByTLD($tld) { return self::table(__CLASS__)->getBy('country_tld', $tld); }

	/**
	 * Get a country by database (english?) name.
	 * @param string $name
	 * @return 
	 */
	public static function getByName($name) { return self::table(__CLASS__)->getBy('country_name', $name); }

	/**
	 * Get a country by ID or return a stub object with name "Unknown".
	 * @param int $id
	 * @return GWF_Country
	 */
	public static function getByIDOrUnknown($id)
	{
		$id = (int)$id;
		if ($id === 0) {
			return self::getUnknown();
		}
		if (false !== ($c = self::table(__CLASS__)->selectFirstObject('*', 'country_id='.$id))) {
			return $c;
		}
		return self::getUnknown();
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
				'country_id' => 0,
				'country_name' => 'Unknown', 
				'country_tld' => 'xx',
				'country_pop' => '1',
			));
		}
		return $UNKNOWN;
	}

	############
	### Flag ###
	############
	public static function displayFlagS($countryid)
	{
		if (false !== ($country = self::getByID($countryid)))
		{
			return $country->displayFlag();
		}
		return self::displayFlagS2(0, '__Unknown Country');
	}

	public function displayFlag()
	{
		return self::displayFlagS2($this->getID(), $this->getVar('country_name'));
	}

	public static function displayFlagS2($countryid, $countryname, $pattern='<img src="%s" class="flag" title="%s" alt="%s" />')
	{
		$path = sprintf('%simg/%s/country/%d',GWF_WEB_ROOT, GWF_ICON_SET, $countryid);
		$t = htmlspecialchars($countryname);
		return sprintf($pattern, $path, $t, $t);
	}

	#################
	### ISO Names ###
	#################
	private static $COUNTRY_NAMES = true;
	private static function initCountryNames() { if (self::$COUNTRY_NAMES === true) { self::$COUNTRY_NAMES = new GWF_LangTrans(GWF_CORE_PATH.'lang/country/countries'); } }
	public function displayName() { return $this->displayNameISO(GWF_Language::getCurrentISO()); }
	public function displayNameISO($iso)
	{
		self::initCountryNames();
		return self::$COUNTRY_NAMES->lang($this->getVar('country_name'));
	}
}

