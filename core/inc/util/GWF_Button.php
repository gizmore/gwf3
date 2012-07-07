<?php
/**
 * Non-Form Buttons and Tooltips.
 * Basically a wrapper for the correct css and markup, for often used buttons.
 * @author gizmore
 * @version 1.0
 */
final class GWF_Button
{
	private static $templateButtons = true;
	private static $templateTooltip = true;

	/**
	 * Preload button template.
	 */
	public static function init()
	{
		if (self::$templateButtons === true)
		{
			self::$templateButtons = GWF_Template::templateMain('buttons.tpl');
			self::$templateTooltip = GWF_Template::templateMain('tooltip.tpl');
		}
	}

	/**
	 * Get a GWF HTML button. Type is 'generic'. Command is ''. 
	 * @param string $text
	 * @param string $href
	 * @param string $type
	 * @param string $command
	 * @param boolean $selected
	 * @param string $onclick
	 * @return string
	 */
	public static function generic($text, $href='#', $type='generic', $command='', $selected=false, $onclick='')
	{
		$class = $selected ? ' gwf_btn_sel' : '';
		$onclick = $onclick === '' ? '' : " onclick=\"$onclick\"";
		return str_replace(
			array('%TEXT%', '%HREF%', '%TYPE%', '%CMD%', '%CLASS%', '%ONCLICK%'),
			array(GWF_HTML::display($text), GWF_HTML::display($href), $type, $command, $class, $onclick),
			self::$templateButtons
		);
	}


	public static function icon($class)
	{
		return sprintf('<span class="gwf_button"><span class="gwf_btn_%s"></span></span>', $class);
	}

	public static function imgbtn($class, $href, $text='', $command='', $onclick='')
	{
		$onclick = $onclick === '' ? '' : " onclick=\"$onclick\"";
		return sprintf('<a class="gwf_button" href="%s"%s title="%s"><span class="gwf_btn_%s"><b>%s</b></span></a>', GWF_HTML::display($href), $onclick, GWF_HTML::display($text), $class, $text);
	}

	public static function add($text, $href='#', $command='', $onclick='') { return self::imgbtn('add', $href, $text, $command, $onclick); }
	public static function sub($text, $href='#', $command='', $onclick='') { return self::imgbtn('sub', $href, $text, $command, $onclick); }
	public static function favorite($href, $text=true, $command='', $onclick='') { return self::imgbtn('favorite', $href, $text, $command, $onclick); }
	public static function mail($href, $text=true, $command='', $onclick='') { return self::imgbtn('mail', $href, $text, $command, $onclick); }
	public static function user($href, $text=true, $command='', $onclick='') { return self::imgbtn('user', $href, $text, $command, $onclick); }
	public static function edit($href, $text=true, $command='', $onclick='') { return self::imgbtn('edit', $href, $text, $command, $onclick); }
	public static function delete($href, $text=true, $command='', $onclick='') { return self::imgbtn('delete', $href, $text, $command, $onclick); }
	public static function ignore($href, $text=true, $command='', $onclick='') { return self::imgbtn('ignore', $href, $text, $command, $onclick); }
	public static function restore($href, $text=true, $command='', $onclick='') { return self::imgbtn('restore', $href, $text, $command, $onclick); }
	public static function options($href, $text=true, $command='', $onclick='') { return self::imgbtn('options', $href, $text, $command, $onclick); }
	public static function reply($href, $text=true, $command='', $onclick='') { return self::imgbtn('reply', $href, $text, $command, $onclick); }
	public static function quote($href, $text=true, $command='', $onclick='') { return self::imgbtn('quote', $href, $text, $command, $onclick); }
	public static function forward($href, $text=true, $command='', $onclick='') { return self::imgbtn('forward', $href, $text, $command, $onclick); }
	public static function search($href, $text=true, $command='', $onclick='') { return self::imgbtn('search', $href, $text, $command, $onclick); }
	public static function trashcan($href, $text=true, $command='', $onclick='') { return self::imgbtn('trashcan', $href, $text, $command, $onclick); }
	public static function bell($href='#', $text=true, $command='', $onclick='') { return self::imgbtn('bell', $href, $text, $command, $onclick); }
	public static function translate($href='#', $text=true, $command='', $onclick='') { return self::imgbtn('translate', $href, $text, $command, $onclick); }
	public static function thumbsUp($href='#', $text=true, $command='', $onclick='') { return self::imgbtn('thumbsup', $href, $text, $command, $onclick); }
	public static function thumbsDown($href='#', $text=true, $command='', $onclick='') { return self::imgbtn('thumbsdown', $href, $text, $command, $onclick); }
	public static function thankYou($href='#', $text=true, $command='', $onclick='') { return self::imgbtn('thanks', $href, $text, $command, $onclick); }
	public static function link($href='#', $text=true, $command='', $onclick='') { return self::imgbtn('link', $href, $text, $command, $onclick); }
	public static function checkmark($enabled=true, $text='', $href='#', $command='')
	{
		return $enabled ? self::generic($text, $href, 'on', $command) : self::generic($text, $href, 'off', $command);
	}

	public static function next($href='#', $text=true, $command='', $onclick='') { return self::imgbtn('next', $href, $text, $command, $onclick); }
	public static function prev($href='#', $text=true, $command='', $onclick='') { return self::imgbtn('prev', $href, $text, $command, $onclick); }


	public static function tooltip($text, $id='gwf_tt')
	{
		return str_replace(
			array('%TEXT_HTML%', '%TEXT_JS%', '%ID%'),
			array(htmlspecialchars($text), GWF_HTML::displayJS($text), $id),
			self::$templateTooltip);
	}

	public static function up($href)
	{
		return self::generic('^', $href, 'up');
	}

	public static function down($href)
	{
		return self::generic('v', $href, 'down');
	}

	public static function wrapStart($class='')
	{
		return '<div class="gwf_buttons_outer"><div class="gwf_buttons '.$class.'">'.PHP_EOL;
	}

	public static function wrapEnd()
	{
		return '</div></div>'.PHP_EOL;
	}

	public static function wrap($html, $class='')
	{
		return self::wrapStart($class).$html.self::wrapEnd();
	}
}

GWF_Button::init();

