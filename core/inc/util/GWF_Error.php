<?php
/**
 * Error messages
 * @author spaceone
 */
final class GWF_Error
{
	private static $_errors = array();
	private static $_messages = array();
	private static $_criticals = array();
	private static $_warnings = array();

	public static function decode($s) { return htmlspecialchars_decode($s, ENT_QUOTES); }

	/**
	 * shortpath and language
	 **/
	public static function err($key, $args=NULL) { self::error('GWF', GWF_Debug::shortpath(GWF_HTML::lang($key, $args))); }
	public static function error($title, $messages) { self::add(self::$_errors, $title, $messages); self::log_error($messages); }
	public static function message($title, $messages) { self::add(self::$_messages, $title, $messages); self::log_message($messages); }
	public static function warn($title, $messages) { self::add(self::$_criticals, $title, $messages); self::log_warning($messages); }
	public static function critical($title, $messages) { self::add(self::$_warnings, $title, $messages); self::log_critical($messages); }

	public static function log($s) { return self::decode(implode("\n", (array)$s)); }
	public static function log_error($content) { GWF_Log::logError(self::log($content)); }
	public static function log_message($content) { GWF_Log::logMessage(self::log($content)); }
	public static function log_warn($content) { GWF_Log::logWarning(self::log($content)); }
	public static function log_critical($content) { GWF_Log::logCritical(self::log($content)); }

	/** @deprecated */
	public static function displayErrors()
	{
		$back = '';
		$back .= self::display(self::$_criticals, 'error.tpl');
		$back .= self::display(self::$_errors, 'error.tpl');
		$back .= self::display(self::$_warnings, 'error.tpl');
		return $back;
	}

	/** @deprecated */
	public static function displayMessages()
	{
		return self::display(self::$_messages, 'message.tpl');
	}

	/**
	 * @param string $title
	 * @param string|array $messages
	 * @todo Log via string?
	 */
	private static function add(&$subject, $title, $messages)
	{
		$messages = (array) $messages;

		if (0 === count($messages))
			return;

		if (true === isset($subject[$title]))
			$subject[$title] = array_merge($subject[$title], $messages);
		else
			$subject[$title] = $messages;
	}

	/** @deprecated */
	private static function display(&$subject, $tpl)
	{
		if (true === empty($subject))
		{
			return '';
		}
		if (true === isset($_GET['ajax']))
		{
			return self::displayAjax($subject);
		}

		return GWF_Template::templateMain($tpl, array('messages' => $subject));
	}

	public static function displayAll()
	{
		$all = array(
			'messages' => self::$_messages,
			'criticals' => self::$_criticals,
			'errors' => self::$_errors,
			'warnings' => self::$_warnings,
		);

		foreach ($all as $k => $subject)
		{
			if (true === empty($subject))
			{
				unset($all[$k]);
			}
		}

		if (true === isset($_GET['ajax']))
		{
			$back = '';
			foreach ($all as $subject)
			{
				$back .= self::displayAjax($subject);
			}
			return $back;
		}

		return GWF_Template::templateMain('errors.tpl', array('messages' => $all));
	}

	private static function displayAjax(&$subject)
	{
		$back = '';
		foreach ($subject as $messages)
		{
			foreach ($messages as $msg)
			{
				$m = GWF_Debug::shortpath(self::decode($msg));
				$back .= sprintf('0:%d:%s', strlen($m), $m).PHP_EOL;
			}
		}
		GWF_Website::addDefaultOutput($back);
		//return $back;
	}

}
