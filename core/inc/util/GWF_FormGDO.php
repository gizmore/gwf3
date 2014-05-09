<?php
final class GWF_FormGDO
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

		# GDO Object
		if (($gdo_d & GDO::OBJECT) === GDO::OBJECT)
		{
			return array(GWF_Form::SELECT, self::getObjectSelect($module, $gdo, $c, $d[2][0]), $module->lang('th_'.$c), $tt);
		}
		# Numbers
		if (($gdo_d & GDO::TINYINT) === GDO::TINYINT)
		{
			return array(GWF_Form::INT, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt, 4);
		}
		if (($gdo_d & GDO::MEDIUMINT) === GDO::MEDIUMINT)
		{
			return array(GWF_Form::INT, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt, 7);
		}
		if (($gdo_d & GDO::BIGINT) === GDO::BIGINT)
		{
			return array(GWF_Form::INT, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt, 16);
		}
		if (($gdo_d & GDO::INT) === GDO::INT)
		{
			return array(GWF_Form::INT, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt, 11);
		}
		if (($gdo_d & GDO::DECIMAL) === GDO::DECIMAL)
		{
			return array(GWF_Form::FLOAT, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt, 16);
		}
		# Text
		if (($gdo_d & GDO::CHAR) === GDO::CHAR)
		{
			return array(GWF_Form::STRING, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt, $d[2]);
		}
		if (($gdo_d & GDO::VARCHAR) === GDO::VARCHAR)
		{
			return array(GWF_Form::STRING, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt, $d[2]);
		}
		if (($gdo_d & GDO::MESSAGE) === GDO::MESSAGE)
		{
			return array(GWF_Form::MESSAGE, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt);
		}
		if (($gdo_d & GDO::TEXT) === GDO::TEXT)
		{
			return array(GWF_Form::STRING, $gdo->getVar($c, ''), $module->lang('th_'.$c), $tt, 40);
		}
		# Enum
		if (($gdo_d & GDO::ENUM) === GDO::ENUM)
		{
			return self::getEnumDataFromGDO($module, $gdo, $c, $d, $tt);
		}
		if ($gdo_d === GDO::JOIN)
		{
			return true;
		}
		die(sprintf('UNRECOGNIZED GDO TYPE in %s: %08x', __METHOD__, $gdo_d));
	}
	
	private static function getEnumDataFromGDO(GWF_Module $module, GDO $gdo, $c, $d, $tt)
	{
		return array(GWF_Form::SELECT, self::getEnumSelect($module, $gdo, $c), $module->lang('th_'.$c), $tt);
	}
	
	private static function getEnumSelect(GWF_Module $module, GDO $gdo, $c)
	{
		$data = array();
		$d = $gdo->getColumnDefines();
		foreach ($d[$c][2] as $enum)
		{
			$data[] = array($enum, $module->lang($c.'_'.$enum));
		}
		return GWF_Select::display($c, $data, $gdo->getVar($c));
	}

	private static function getObjectSelect(GWF_Module $module, GDO $gdo, $c, $classname)
	{
		if ($classname === 'GWF_Country')
		{
			return GWF_CountrySelect::single($c, $gdo->getVar($c));
		}
		
		die('Unsupported object in GWF_FormGDO::getObjectSelect: '.$classname);
	}
	
	##########################
	### Some default forms ###
	##########################
	/**
	 * Get a default advanced search form.
	 * @param GWF_Module $module
	 * @param object $caller
	 * @param GDO $gdo
	 * @param GWF_User $user
	 * @param boolean $captcha
	 * @return GWF_Form
	 */
	public static function getSearchForm(GWF_Module $module, $caller, GDO $gdo, $user, $use_captcha=true)
	{
		$data = array_merge(
			self::getDefaultFields($module, $gdo, $gdo->getSearchableFields($user)),
			$gdo->getSearchableFormData($user),
			self::getActions($module, $gdo->getSearchableActions($user)),
			self::getFormDataCaptcha($use_captcha)
		);
		return new GWF_Form($caller, $data);
	}

	public static function getQuickSearchForm(GWF_Module $module, $caller, GDO $gdo, $user, $use_captcha=true)
	{
		$data = array(
			'term' => array(GWF_Form::STRING, Common::getRequestString('term', ''), GWF_HTML::lang('term')),
			'qsearch' => array(GWF_Form::SUBMIT, GWF_HTML::lang('search')),
		);
		return new GWF_Form($caller, $data);
	}

	private static function getDefaultFields(GWF_Module $module, GDO $gdo, array $fields)
	{
		$filtered = array();
		foreach ($fields as $c)
		{
			# Option GRP
			if (strpos($c, '&&') !== false)
			{
				$pos = strpos($c, '&&');
				$pos = strpos($c, '&', $pos+1);
				$colname = substr($c, 0, $pos);
				$choice = substr($c, $pos+1);
				if (!isset($filtered[$c]))
				{
					$filtered[$colname] = array(GDO::ENUM, GDO::NULL, array());
				}
				$filtered[$colname][2][] = $choice;
			}
			elseif (strpos($c, '&') !== false)
			{
				$filtered[$c] = $gdo->getColumnDefine($gdo->getOptionsName());
			}
			else
			{
				$filtered[$c] = $gdo->getColumnDefine($c);
			}
		}
	
		$data = array();
		foreach ($filtered as $c => $define)
		{
			die('OOOOOOOOOPS 0815');
// 			$data[$c] = self::getFormData($module, $gdo, $c, $define);
		}
		return $data;
	}

	/**
	 * Return all values from the form except buttons.
	 * @param GWF_Form $form
	 * @return array
	 */
	public static function getFormVars(GWF_Form $form)
	{
		$back = array();
		foreach ($form->getFormData() as $key => $d)
		{
			switch ($d[0])
			{
				case GWF_Form::HIDDEN:
				case GWF_Form::SUBMIT:
				case GWF_Form::SUBMITS:
				case GWF_Form::SUBMIT_IMG:
				case GWF_Form::SUBMIT_IMGS:
					break;
				default:
					$back[$key] = $form->getVar($key, '');
			}
		}
		return $back;
	}
}
?>
