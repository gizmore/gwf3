<?php
/**
 * Custom 404 error pages and email on 404.
 * @author spaceone, gizmore
 */
final class GWF_ShowError extends GWF_Method
{
	protected $_tpl = 'error.tpl';

	public function getHTAccess()
	{
		return 'RewriteRule ^error/(.*?)$ index.php?mo=GWF&me=ShowError&code=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		# Do not remember this "non 200" page
		GWF3::setConfig('store_last_url', false);
		
		return $this->templateError();
	}
	
	private function templateError()
	{
		$errors = array(
			# client errors 4xx
			'400' => 'Bad Request',
			'401' => 'Unauthorized',
			'403' => 'Forbidden',
			'404' => 'Not Found',
			'405' => 'Method Not Allowed',
			'406' => 'Not Acceptable',
			'407' => 'Proxy Authentication Required',
			'408' => 'Request Time-out',
			'409' => 'Conflict',
			'410' => 'Gone',
			'411' => 'Length Required',
			'412' => 'Precondition Failed',
			'413' => 'Request Entity Too Large',
			'414' => 'Request-URI Too Long',
			'415' => 'Unsupported Media Type',
			'417' => 'Expectation Failed',
			'418' => 'I\'m a Teapot',
			'421' => 'There are too many connections from your internet address',
			'422' => 'Unprocessable Entity',
			'423' => 'Locked',
			'424' => 'Failed Dependency',
			'426' => 'Upgrade Required',
			# TODO: server errors 5XX; add htaccess
		);

		# Get the error page
		$code = Common::getGetString('code', '0');
		if (false === isset($errors[$code]))
		{
			return GWF_HTML::error('ERR_NO_PERMISSION');
		}

		@header(Common::getProtocol().' '.$code.' '.$errors[$code]);

		# Generate template
		$tVars = array(
			'code' => $code,
			'file' => GWF_HTML::error(GWF_SITENAME, $this->module->getLang()->langA('ERR_HTTP', $code, array(htmlspecialchars($_SERVER['REQUEST_URI']))), false), # FIXME: this is frontend work!
		);
		$template = $this->module->template($this->_tpl, $tVars);

		# Is the request blacklisted?
		foreach (preg_split('/[,;]/', $this->module->cfgBlacklist()) as $pattern)
		{
			if (false !== strpos($_SERVER['REQUEST_URI'], $pattern))
			{
				# Do not log and email the request
				return $template;
			}
		}

		$message = self::getMessage($code);

		# Mail it?
		if (1 === preg_match("/(?:^|[,;]){$code}(?:$|[,;])/", $this->module->cfgMail()))
		{
			self::errorMail($code, $message);
		}

		# Log it?
		if (1 === preg_match("/(?:^|[,;]){$code}(?:$|[,;])/", $this->module->cfgLog()))
		{
			GWF_Log::logHTTP($message);
		}

		return $template;
	}
	
	public static function errorMail($subject, $body)
	{
		return GWF_Mail::sendDebugMail(': HTTP Error '.$subject, $body);
	}

	private static function getMessage($code)
	{
		$ip = isset($_SERVER['REMOTE_ADDR']) ? "[{$_SERVER['REMOTE_ADDR']}] " : '';
		return sprintf('%sThe page %s threw a %s error.', $ip, htmlspecialchars($_SERVER['REQUEST_URI']), $code);
	}
}
?>
