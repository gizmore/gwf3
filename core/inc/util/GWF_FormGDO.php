<?php
final class GWF_FormGDO extends GWF_Form
{
	#######################################
	### Convert From GDO Column Defines ###
	#######################################
	public static function dataFromGDO(GWF_Module $module, GDO $gdo)
	{
		$exclusive = array();
		$cd = $gdo->getColumnDefines();
		foreach ($cd as $c => $d)
		{
			if (($d & GDO::AUTO_INCREMENT) === GDO::AUTO_INCREMENT) {
				$exclusive[] = $c;
			}
		}
		return self::dataFromGDOExclusive($module, $gdo, $exclusive);
	}
	
	public static function dataFromGDOExclusive(GWF_Module $module, GDO $gdo, array $exclusive)
	{
		$data = array();
		$cd = $gdo->getColumnDefines();
		foreach ($cd as $c => $d)
		{
			if (in_array($c, $exclusive)) {
				continue;
			}
			if (true === ($fd = self::getDataFromGDO($module, $gdo, $c, $d))) {
				continue;
			}
			$data[$c] = $fd;
		}
		
		return $data;
	}
	
	public static function dataFromGDOInclusive(GWF_Module $module, GDO $gdo, array $inclusive)
	{
		$data = array();
		$cd = $gdo->getColumnDefines();
		foreach ($cd as $c => $d)
		{
			if (!in_array($c, $inclusive)) {
				continue;
			}
			if (true === ($fd = self::getDataFromGDO($module, $gdo, $c, $d))) {
				continue;
			}
			$data[$c] = $fd;
		}
		
		return $data;
	}
	
	private static function getDataFromGDO(GWF_Module $module, GDO $gdo, $c, $d)
	{
		$gdo_d = (int) $d[0];
		
		$ttk = 'tt_'.$c;
		if ($ttk === ($tt = $module->lang($ttk))) { $tt = ''; }
		
		# Numbers
		if (($gdo_d & GDO::TINYINT) === GDO::TINYINT) {
			return array(self::INT, $gdo->getVar($c, ''), $module->lang('th_'.$c), 4, '', $tt);
		}
		if (($gdo_d & GDO::MEDIUMINT) === GDO::MEDIUMINT) {
			return array(self::INT, $gdo->getVar($c, ''), $module->lang('th_'.$c), 7, '', $tt);
		}
		if (($gdo_d & GDO::BIGINT) === GDO::BIGINT) {
			return array(self::INT, $gdo->getVar($c, ''), $module->lang('th_'.$c), 16, '', $tt);
		}
		if (($gdo_d & GDO::INT) === GDO::INT) {
			return array(self::INT, $gdo->getVar($c, ''), $module->lang('th_'.$c), 11, '', $tt);
		}
		if (($gdo_d & GDO::DECIMAL) === GDO::DECIMAL) {
			return array(self::FLOAT, $gdo->getVar($c, ''), $module->lang('th_'.$c), 16, '', $tt);
		}
		# Text
//		if (($gdo_d & GDO::MESSAGE) === GDO::MESSAGE) {
//			return array(self::MESSAGE, $gdo->getVar($c, ''), $module->lang('th_'.$c), 40, '', $tt);
//		}
		if (($gdo_d & GDO::CHAR) === GDO::CHAR) {
			return array(self::STRING, $gdo->getVar($c, ''), $module->lang('th_'.$c), $d[2], '', $tt);
		}
		if (($gdo_d & GDO::VARCHAR) === GDO::VARCHAR) {
			return array(self::STRING, $gdo->getVar($c, ''), $module->lang('th_'.$c), $d[2], '', $tt);
		}
		if (($gdo_d & GDO::TEXT) === GDO::TEXT) {
			return array(self::MESSAGE, $gdo->getVar($c, ''), $module->lang('th_'.$c), 40, '', $tt);
		}
		# Enum
		if (($gdo_d & GDO::ENUM) === GDO::ENUM) {
			return self::getEnumDataFromGDO($module, $gdo, $c, $d, $tt);
		}
		if ($gdo_d === GDO::JOIN) {
			return true;
		}
		# GDO Object
//		if (($gdo_d & GDO::OBJECT) === GDO::OBJECT) {
////		$data['langid'] = array(GDO, $user->getVar('langid'), $module->lang('th_langid'), 0, 'GWF_Language');
//			return array(self::GDO, $gdo->getVar($c, ''), $module->lang('th_'.$c), 0, $d[2][0], $tt);
//		}
		die(sprintf('UNRECOGNIZED GDO TYPE in %s: %08x', __METHOD__, $gdo_d));
	}
}
?>