<?php
/**
 * User Profiles.
 * @author gizmore
 * @version 1.0
 */
final class Module_Profile extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.02; }
	public function getDefaultPriority() { return 40; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/profile'); }
	public function getClasses() { return array('GWF_Profile', 'GWF_ProfileLink', 'GWF_ProfilePOI', 'GWF_ProfilePOIWhitelist'); }
	public function onInstall($dropTable) { require_once 'GWF_ProfileInstall.php'; return GWF_ProfileInstall::onInstall($this, $dropTable); }
	
	##############
	### Config ###
	##############
	public function cfgAllowHide() { return $this->getModuleVarBool('prof_hide', '1'); }
	public function cfgMaxAboutLen() { return $this->getModuleVarInt('prof_max_about', 512); }
	public function cfgLevelGB() { return $this->getModuleVarInt('prof_level_gb', 0); }
	public function cfgMinPOIs() { return $this->getModuleVarInt('min_pois', 0); }
	public function cfgMaxPOIs() { return $this->getModuleVarInt('max_pois', 10); }
	public function cfgPntPOIs() { return $this->getModuleVarInt('pnt_pois', 0); }
	public function cfgMinPntPOIsAdd() { return $this->getModuleVarInt('pnt_add_pois', 250); }
	public function cfgMinPntPOIsRead() { return $this->getModuleVarInt('pnt_show_pois', 250); }
	public function cfgMapsApiKey() { return $this->getModuleVar('maps_api_key', ''); }
	
	public function cfgAllowedPOIs()
	{
		$level = GWF_User::getStaticOrGuest()->getLevel();
		$minpnts = $this->cfgMinPntPOIsAdd();
		$allowed = 0;
		if ( ($level >= $minpnts) && (0 < ($ppp = $this->cfgPntPOIs())) )
		{
			$level -= $minpnts;
			$allowed = intval($level/$ppp);
		}
		return Common::clamp($allowed, $this->cfgMinPOIs(), $this->cfgMaxPOIs());
	}
	
	public function canReadPOIs()
	{
		$user = GWF_User::getStaticOrGuest();
		return $user->getLevel() >= $this->cfgMinPntPOIsRead();
	}

	####################
	### Param Helper ###
	####################
	public function lat($varname='lat')
	{
		if (false === ($lat = Common::getGetString($varname, false)))
		{
			$this->ajaxError('Missing parameter "'.$varname.'".');
		}
		$lat = (float)$lat;
		if ($lat < -90 || $lat > 90)
		{
			$this->ajaxError('Invalid parameter "'.$varname.'".');
		}
		return $lat;
	}
	
	public function lon($varname='lon')
	{
		if (false === ($lon = Common::getGetString($varname, false)))
		{
			$this->ajaxError('Missing parameter "'.$varname.'".');
		}
		$lon = (float)$lon;
		if ($lon < -180 || $lon > 180)
		{
			$this->ajaxError('Invalid parameter "'.$varname.'".');
		}
		return $lon;
	}
}
