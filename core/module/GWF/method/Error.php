<?php
/**
 * Custom 404 error pages and email on 404.
 * @author spaceone, gizmore
 */
final class GWF_Error extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^error/(.*?)$ index.php?mo=GWF&me=Error&code=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		# Do not remember this "non 200" page
		GWF3::setConfig('store_last_url', false);
		
		return $this->templateError();
	}
	
	private function templateError()
	{
		# Get the error page
		$errors = array(
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
			# TODO: add 5XX; add htaccess
		);

		$realcode = Common::getGet('code', '0');
		if(true ===  isset($errors[$realcode]))
		{
			header($_SERVER['SERVER_PROTOCOL'].' '.$realcode.' '.$errors[$realcode]); 
		}
		
		# Real 404 page?
		if ($realcode === '404')
		{
			$message = self::getMessage('404');
			# Mail it?
			if ((GWF_DEBUG_EMAIL & 4) && $this->_module->cfgMail404())
			{
				self::errorMail(': 404 Error', $message);
			}
			
			# Log it?
			if ($this->_module->cfgLog404())
			{
				GWF_Log::log('404', $message, true);
			}
		}
		elseif ($realcode === '403' && (GWF_DEBUG_EMAIL & 8))
		{
			self::errorMail(': 403 Error', self::getMessage('403'));
		}
		
		# TODO: create base-lang: ERR_HTTP_404
		$err_msg =  GWF_HTML::lang('ERR_FILE_NOT_FOUND', array(htmlspecialchars($_SERVER['REQUEST_URI'])));
		
		$tVars = array(
			'code' => $realcode,
			'file' => GWF_HTML::error(GWF_SITENAME, $err_msg, false),
		);
		
		return $this->_module->template('error.tpl', $tVars);
	}
	
	public static function errorMail($subject, $body)
	{
		# TODO: blacklist for domains or paths by config?
		return GWF_Mail::sendDebugMail($subject, $body);
	}

	private static function getMessage($code)
	{
		return sprintf('The page %s threw a %s error.', htmlspecialchars($_SERVER['REQUEST_URI']), $code);
	}
}
?>
