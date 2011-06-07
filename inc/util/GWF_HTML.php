<?php
final class GWF_HTML
{
	/**
	 * Basic lang file instance
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
	public static function init() { self::$trans = new GWF_LangTrans('lang/base/base'); }
	public static function &getLang() { return self::$trans; }
	public static function lang($key, $args=NULL) { return self::$trans->lang($key, $args); }
	public static function langAdmin($key, $args=NULL) { return self::$trans->langAdmin($key, $args); }
	public static function langISO($iso, $key, $args=NULL) { return self::$trans->langISO($iso, $key, $args); }
	public static function langUser(GWF_User $user, $key, $args=NULL) { return self::$trans->langUser($user, $key, $args); }
	
	##############
	### Errors ###
	##############
	public static function err($key, $args=NULL, $log=true) { return self::error('GWF', self::$trans->lang($key, $args), $log); }
	public static function error($title=NULL, $message, $log=true) { return self::errorA($title, array($message), $log); }
	public static function errorA($title=NULL, array $messages, $log=true)
	{
		if (count($messages) === 0)
		{
			return '';
		}
		
		if ($log === true)
		{
			GWF_Log::logError(self::decode(implode(PHP_EOL, $messages)));
		}

		if (Common::getGet('ajax') !== false)
		{
			$errors = '';
			foreach ($messages as $msg)
			{
				$msg = self::decode($msg);
				$errors .= sprintf('0:%d:%s', strlen($msg), $msg).PHP_EOL;
			}
			return $errors;
		}
		
		return GWF_Template::templateMain('error.tpl', array('title'=>$title, 'errors'=>$messages));
	}

	################
	### Messages ###
	################
	public static function message($title=NULL, $message, $log=true) { return self::messageA($title, array($message), $log); }
	public static function messageA($title=NULL, array $messages, $log=true)
	{
		if (count($messages) === 0)
		{
			return '';
		}
		
		if ($log === true)
		{
			GWF_Log::logMessage(self::decode(implode(PHP_EOL, $messages)));
		}

		if (Common::getGet('ajax') !== false)
		{
			$output = '';
			foreach ($messages as $msg)
			{
				$msg = self::decode($msg);
				$output .= sprintf('1:%d:%s', strlen($msg), $msg).PHP_EOL;
			}
			return $output;
		}
		
		return GWF_Template::templateMain('message.tpl', array('title'=>$title, 'messages'=>$messages));
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
	
	public static function anchor($url, $text=NULL, $title=NULL)
	{
		$url = htmlspecialchars($url);
		if ($text === NULL) {
			$text = $url;
		}
		$title = $title === NULL ? '' : ' title="'.htmlspecialchars($title).'"';
		
		return sprintf('<a href="%s"%s>%s</a>', $url, $title, $text);
	}
	
	public static function selected($bool)
	{
		return $bool ? ' selected="selected"' : '';
	}

	public static function checked($bool)
	{
		return $bool ? ' checked="checked"' : '';
	}
	
	public static function br2nl($s, $nl="\x0a")
	{
		return preg_replace('/< *br *\/?>/', $nl, $s);
	}
	
}
?>