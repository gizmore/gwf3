<?php
final class GWF_Gender
{
	public static function isValidGender($gender)
	{
		return $gender === 'no_gender' || $gender === 'male' || $gender === 'female';
	}

	public static function select($key='gender', $selected='no_gender')
	{
		$data = array(
			array('no_gender', GWF_HTML::lang('gender_no_gender')),
			array('female', GWF_HTML::lang('gender_female')),
			array('male', GWF_HTML::lang('gender_male')),
		);
		return GWF_Select::display('gender', $data, $selected);
	}
}
