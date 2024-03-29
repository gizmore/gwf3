<?php
/**
 * HTML markup helper class
 * @author gizmore
 * @author spaceone
 */
final class GWF_HTML
{
	/**
	 * Base lang file instance from core/lang/base.
	 * @var GWF_LangTrans
	 */
	private static $trans;

	#####################
	### SPECIAL CHARS ###
	#####################
	public static function decode($s) { return htmlspecialchars_decode($s, ENT_QUOTES); }
	public static function display($s) { return htmlspecialchars($s, ENT_QUOTES); }
	public static function displayJS($s) { return str_replace(array('\'', "\n"), array('\\\'', '\\n'), $s); }

	#################
	### Lang File ###
	#################
	public static function init()
	{
		if (!self::$trans)
		{
			GWF_Language::init();
			self::$trans = new GWF_LangTrans(GWF_CORE_PATH.'lang/base/base');
		}
	}

	public static function &getLang() { return self::$trans; }
	public static function lang($key, $args=NULL) { self::init(); return self::$trans->lang($key, $args); }
	public static function langAdmin($key, $args=NULL) { self::init(); return self::$trans->langAdmin($key, $args); }
	public static function langISO($iso, $key, $args=NULL) { self::init(); return self::$trans->langISO($iso, $key, $args); }
	public static function langUser(GWF_User $user, $key, $args=NULL) { self::init(); return self::$trans->langUser($user, $key, $args); }

	##############
	### Errors ###
	##############
	/** strip full paths */
	public static function err($key, $args=NULL, $log=true) { return self::error('GWF', GWF_Debug::shortpath(self::lang($key, $args)), $log); }

	/**
	 * Display a errormessage
	 * @author spaceone
	 * @author gizmore
	 * @param string $title
	 * @param string|array $messages
	 * @param boolean $log log the Error?
	 * @param boolean $to_smarty group errors to a fixed smarty area
	 * @return string
	 */
	public static function error($title, $messages, $log=true)
	{
		$messages = (array) $messages;

		if (count($messages) === 0) return '';

		if ($log === true)
		{
			GWF_Log::logError(self::decode(implode(PHP_EOL, $messages)));
		}
		return self::displayErrors(array('title' => $title, 'messages' => $messages));
	}
	public static function displayErrors($errors) 
	{
		if(count($errors) === 0) return ''; 

		if (isset($_GET['ajax']))
		{
			$err = '';
			foreach ($errors['messages'] as $m)
			{
				$m2 = GWF_Debug::shortpath(self::decode($m));
				$err .= sprintf('0:%d:%s', strlen($m2), $m2).PHP_EOL;
			}
			return $err;
//			return GWF_Website::addDefaultOutput($err);
		}
		return GWF_Template::templateMain('error.tpl', array('title' => $errors['title'], 'errors' => $errors['messages']));
	}

	################
	### Messages ###
	################
	public static function message($title, $message, $log=true) { return self::messageA($title, array($message), $log); }
	public static function messageA($title, array $messages, $log=true)
	{
		if (count($messages) === 0) return '';

		if ($log === true)
		{
			GWF_Log::logMessage(self::decode(implode(PHP_EOL, $messages)));
		}
		return self::displayMessages(array('title' => $title, 'messages' => $messages));
	}
	public static function displayMessages($messages) 
	{
		if(count($messages) === 0) return ''; 

		if (Common::getGet('ajax') !== false)
		{
			$output = '';
			foreach ($messages['messages'] as $m)
			{
				$m2 = GWF_Debug::shortpath(self::decode($m));
				$output .= sprintf('1:%d:%s', strlen($m2), $m2).PHP_EOL;
			}
			return $output;
// 			return GWF_Website::addDefaultOutput($output);
		}
		return GWF_Template::templateMain('message.tpl', array('title' => $messages['title'], 'messages' => $messages['messages']));
	}

	##############
	### Markup ###
	##############
	public static function div($html, $class='', $id='', $style='')
	{
		return self::element('div', $html, $class, $id, $style='');
	}

	public static function span($html, $class='', $id='', $style='')
	{
		return self::element('span', $html, $class, $id, $style='');
	}

	private static function element($name, $inner_html, $class='', $id='', $style='')
	{
		$id = $id === '' ? '' : ' id="'.$id.'"';
		$class = $class === '' ? '' : ' class="'.$class.'"';
		$style = $style === '' ? '' : ' style="'.$style.'"';
		return sprintf('<%s%s%s%s>%s</%s>', $name, $id, $class, $style, $inner_html, $name).PHP_EOL;
	}

	public static function anchor($url, $text=NULL, $title=NULL, $class=NULL)
	{
		if ($text === NULL)
		{
			$text = $url;
		}
		$class = $class === NULL ? '' : " class=\"$class\"";
		$url = htmlspecialchars($url);
		$title = $title === NULL ? '' : ' title="'.htmlspecialchars($title).'"';
		return sprintf('<a%s href="%s"%s>%s</a>', $class, $url, $title, htmlspecialchars($text));
	}

	public static function selected($bool)
	{
		return $bool ? ' selected="selected"' : '';
	}

	public static function checked($bool)
	{
		return $bool ? ' checked="checked"' : '';
	}

	public static function br2nl($s, $nl=PHP_EOL)
	{
		return preg_replace('/< *br *\/? *>/i', $nl, $s);
	}
}

