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
	public static function init() { self::$trans = new GWF_LangTrans(GWF_CORE_PATH.'lang/base/base'); }
	public static function &getLang() { return self::$trans; }
	public static function lang($key, $args=NULL) { return self::$trans->lang($key, $args); }
	public static function langAdmin($key, $args=NULL) { return self::$trans->langAdmin($key, $args); }
	public static function langISO($iso, $key, $args=NULL) { return self::$trans->langISO($iso, $key, $args); }
	public static function langUser(GWF_User $user, $key, $args=NULL) { return self::$trans->langUser($user, $key, $args); }
	
	##############
	### Errors ###
	##############
	private static $_ERRORS = array();
	public static function err($key, $args=NULL, $log=true, $to_smarty = false) { return self::error('GWF', GWF_Debug::shortpath(self::$trans->lang($key, $args)), $log, $to_smarty); }
	public static function error($title=NULL, $message, $log=true, $to_smarty = false) { return self::errorA($title, array($message), $log, $to_smarty); }
	public static function errorA($title=NULL, array $messages, $log=true, $to_smarty=false)
	{
		if (count($messages) === 0) return '';
		
		if ($log === true)
		{
			GWF_Log::logError(self::decode(implode(PHP_EOL, $messages)));
		}
		if ($to_smarty === false || false === Common::getConst('GWF_ERRORS_TO_SMARTY', false))
		{
			return self::displayErrors(array('title' => $title, 'messages' => $messages));
		}
		
		self::$_ERRORS[] = array('title' => $title, 'messages' => $messages); 
		return '';
	}
	public static function displayErrors($errors = NULL) 
	{
		$errors = $errors === NULL ? self::$_ERRORS : array($errors); 
		if(count($errors) === 0) return ''; 
		
		if (Common::getGet('ajax') !== false)
		{
			$err = '';
			foreach ($errors as $msg)
			{
				foreach ($msg['messages'] as $m)
				{
					$m2 = GWF_Debug::shortpath(self::decode($m));
					$err .= sprintf('0:%d:%s', strlen($m2), $m2).PHP_EOL;
				}
			}
			return GWF_Website::addDefaultOutput($err);
		}
		return GWF_Template::templateMain('error.tpl', array('title'=>$errors[0]['title'], 'errors' => $errors));
	}

	################
	### Messages ###
	################
	private static $_MESSAGES = array();
	public static function message($title=NULL, $message, $log=true, $to_smarty=false) { return self::messageA($title, array($message), $log, $to_smarty); }
	public static function messageA($title=NULL, array $messages, $log=true, $to_smarty=false)
	{
		if (count($messages) === 0) return '';
		
		if ($log === true)
		{
			GWF_Log::logMessage(self::decode(implode(PHP_EOL, $messages)));
		}
		if ($to_smarty === false || false === Common::getConst('GWF_MESSAGES_TO_SMARTY', false))
		{
			return self::displayMessages(array('title' => $title, 'messages' => $messages));
		}
		self::$_MESSAGES[] = array('title' => $title, 'messages' => $messages); 
		return '';
	}
	public static function displayMessages($messages = NULL) 
	{
		$messages = $messages === NULL ? self::$_MESSAGES : array($messages); 
		if(count($messages) === 0) return ''; 
		
		if (Common::getGet('ajax') !== false)
		{
			$output = '';
			foreach ($messages as $msg)
			{
				foreach ($msg['messages'] as $m)
				{
					$m2 = GWF_Debug::shortpath(self::decode($m));
					$output .= sprintf('1:%d:%s', strlen($m2), $m2).PHP_EOL;
				}
			}
			return GWF_Website::addDefaultOutput($output);
		}
		return GWF_Template::templateMain('message.tpl', array('title'=>$messages[0]['title'], 'messages' => $messages));
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
		if ($text === NULL) {
			$text = $url;
		}
		$url = htmlspecialchars($url);
		$title = $title === NULL ? '' : ' title="'.htmlspecialchars($title).'"';
		
		return sprintf('<a href="%s"%s>%s</a>', $url, $title, htmlspecialchars($text));
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