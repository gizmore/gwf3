<?php
/**
 * Display copyright information.
 * @author gizmore
 * @since 3.0
 */
final class GWF_Copyright
{
	public static function display()
	{
		$y1 = substr(GWF_Website::getBirthdate(), 0, 4);
		$y2 = date('Y');
		$years = $y1 === $y2 ? $y1 : "$y1-$y2";
		return GWF_HTML::lang('copy', array($years));
	}

	public static function displayGWF()
	{
		return GWF_HTML::lang('copygwf');
	}
}
