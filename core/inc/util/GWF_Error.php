<?php
/**
 * Error messages
 * @todo cleanup
 * @author spaceone
 */
final class GWF_Error
{
	private static $static;
	private $all;
	
	public function __construct()
	{
		$this->all = array(
			'message' => array(),
			'critical' => array(),
			'error' => array(),
			'warning' => array(),
		);
	}

	public static function getInstance()
	{
		if (NULL === self::$static)
		{
			self::$static = new self();
		}
		return self::$static;
	}

	public static function decode($s) { return htmlspecialchars_decode($s, ENT_QUOTES); }

	/**
	 * shortpath and language
	 **/
	public static function err($key, $args=NULL) { return self::error('GWF', GWF_Debug::shortpath(GWF_HTML::lang($key, $args))); }
	public static function err404($filename) { @header(Common::getProtocol().' 404 File not found'); return self::err('ERR_FILE_NOT_FOUND', htmlspecialchars($filename)); } # DEPRECATED
	public static function error($title, $messages) { self::$static->addError($title, $messages); }
	public static function message($title, $messages) { self::$static->addMessage($title, $messages); }
	public static function warn($title, $messages) { self::$static->addCritical($title, $messages); }
	public static function critical($title, $messages) { self::$static->addWarning($title, $messages); }

	public function addError($title, $messages) { $this->add('error', $title, $messages); }
	public function addMessage($title, $messages) { $this->add('message', $title, $messages); }
	public function addWarning($title, $messages) { $this->add('critical', $title, $messages); }
	public function addCritical($title, $messages) { $this->add('warning', $title, $messages); }


	public static function log($type, $s)
	{
		$s = self::decode(implode("\n", (array)$s));
		switch ($type)
		{
			case 'error':
				GWF_Log::logError($s);
				break;
			case 'info':
			case 'message':
				GWF_Log::logMessage($s);
				break;
			case 'critical':
			case 'fatal':
				GWF_Log::logCritical($s);
				break;
			case 'warning':
			case 'warn':
				GWF_Log::logWarning($s);
				break;
		}
	}

	/**
	 * @param string $type critical|error|warning|message
	 * @param string $title
	 * @param string|array $messages
	 */
	private function add($type, $title, $messages)
	{
		$messages = (array) $messages;

		if (0 === count($messages))
			return;

		self::log($type, $messages);

		if (isset($this->all[$type][$title]))
		{
			$this->all[$type][$title] = array_merge($this->all[$type][$title], $messages);
		}
		else
		{
			$this->all[$type][$title] = $messages;
		}
	}

	public static function displayAll()
	{
		$errors = self::$static->getAll();
		if (GWF_ERRORS_TO_SMARTY)
		{
			GWF_Template::addMainTvars(array('errors' => $errors));
		}
		elseif (!isset($_GET['ajax']))
		{
			GWF_Website::addDefaultOutput($errors);
			GWF_Template::addMainTvars(array('errors' => ''));
		}
	}

	public function getAll()
	{
		foreach ($this->all as $k => $subject)
		{
			if (true === empty($subject))
			{
				unset($this->all[$k]);
			}
		}

		if (true === isset($_GET['ajax']))
		{
			$back = '';
			foreach ($this->all as $subject)
			{
				$back .= self::displayAjax($subject);
			}
			return $back;
		}

		return GWF_Template::templateMain('errors.tpl', array('messages' => $this->all));
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
		return $back;
	}

}

GWF_Error::getInstance();
