<?php
final class GWF_CountrySelect
{
	public static function single($name='country', $selected='0')
	{
		$db = gdo_db();
		$table = GDO::table('GWF_Country');
		if (false === ($result = $table->select('country_id,country_name', '', 'country_name ASC')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		$data = array(array('0', GWF_HTML::lang('sel_country')));
		while (false !== ($row = $db->fetchRow($result)))
		{
			$data[] = $row;
		}
		$db->free($result);
		return GWF_Select::display($name, $data, $selected);
	}

	#################
	### Validator ###
	#################
	public static function validate_countryid($arg, $allow_zero=false)
	{
		return self::isValidCountry($arg, $allow_zero) ? false : GWF_HTML::lang('ERR_UNKNOWN_COUNTRY');
	}

	public static function validate_countryidMulti($arg, $allow_zero=false)
	{
		if (!(is_array($arg))) {
			return $allow_zero === true ? false : GWF_HTML::lang('ERR_UNKNOWN_COUNTRY');
		}

		$success = true;
		foreach ($arg as $cid)
		{
			if ($cid === '0')
			{
				if ($allow_zero === false)
				{
					$success = false;
					break;
				}
			}
			elseif (false === self::getByID($cid))
			{
				$success = false;
				break;
			}
		}
		return $success === true ? false : GWF_HTML::lang('ERR_UNKNOWN_COUNTRY');
	}

	public static function isValidCountry($cid, $allow_zero=false)
	{
		$min = $allow_zero === true ? -1 : 0;
		if ($min >= ($cid = (int) $cid))
		{
			return false;
		}
		return $cid === 0 ? true : (GWF_Country::getByID($cid) !== false);
	}
}
