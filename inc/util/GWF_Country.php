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
	public static function getByID($id) { return self::table(__CLASS__)->getBy('country_id', $id); }
	public static function getByTLD($tld) { return self::table(__CLASS__)->getBy('country_tld', $tld); }
	public static function getByName($name) { return self::table(__CLASS__)->getBy('country_name', $name); }
	
	public static function getByIDOrUnknown($id)
	{
		if ($id == 0) {
			return self::getUnknown();
		}
		if (false !== ($c = self::table(__CLASS__)->selectFirstObject('*', 'country_id='.intval($id)))) {
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
		if (false !== ($country = self::getByID($countryid))) {
			return $country->displayFlag();
		}
		$path = GWF_WEB_ROOT.'img/country/0';
		$t = '__Unknown Country';
		return sprintf('<img src="%s" width="30" height="18" title="%s" alt="%s"/>', $path, $t, $t).PHP_EOL;
	}

	public function displayFlag()
	{
		$id = $this->getID();
		$path = GWF_WEB_ROOT.'img/country/'.$id;
		$t = $this->display('country_name');
		return sprintf('<img src="%s" width="30" height="18" alt="%s" title="%s" />', $path, $t, $t).PHP_EOL;
	}
	
	#################
	### ISO Names ###
	#################
	private static $COUNTRY_NAMES = true;
	private static function initCountryNames() { if (self::$COUNTRY_NAMES === true) { self::$COUNTRY_NAMES = new GWF_LangTrans('lang/country/countries'); } }
	public function displayName() { return $this->displayNameISO(GWF_Language::getCurrentISO()); }
	public function displayNameISO($iso)
	{
		self::initCountryNames();
		return self::$COUNTRY_NAMES->lang($this->getVar('country_name'));
	}
}
?>