<?php
/**
 * Display HTML Boxes.
 * @author gizmore
 * @version 3.0
 */
final class GWF_Box
{
	/**
	 * Display a box
	 * @param string $content
	 * @param string $title
	 * @return string the html box
	 */
	public static function box($content='', $title='')
	{
		if ($content === '' && $title === '') {
			return '';
		}
		return $title === '' ? self::boxNT($content) : self::boxT($content, $title);
	}

	/**
	 * Display a box with a title
	 * @param string $content
	 * @param string $title
	 * @return string the html box
	 */
	private static function boxT($content, $title)
	{
		return GWF_Template::templateMain('box_t.tpl', array('title'=>$title,'content'=>$content));
	}

	/**
	 * Box with no title.
	 * @param string $content
	 * @return string the html box
	 */
	private static function boxNT($content)
	{
		return GWF_Template::templateMain('box_nt.tpl', array('content'=>$content));
	}
}

