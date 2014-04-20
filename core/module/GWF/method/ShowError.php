<?php
/**
 * Custom 404 error pages and email on 404.
 * @author spaceone
 * @author gizmore
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
		$module = $this->module;
		$module instanceof Module_GWF;

		$codes = $module->lang('ERR_HTTP');

		# Get the error page
		$code = Common::getGetString('code', '0');
		if (false === isset($codes[$code]))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}

		@header($_SERVER['SERVER_PROTOCOL'].' '.$code.' '.$codes[$code]);
		
		# Generate template
		$tVars = array(
			'code' => $code,
			'file' => GWF_HTML::error(GWF_SITENAME, $module->getLang()->langA('ERR_HTTP', $code, array(htmlspecialchars($_SERVER['REQUEST_URI']))), false), # FIXME: this is frontend work!
		);
		$template = $module->template($this->_tpl, $tVars);

		# Is the request blacklisted?
		foreach (preg_split('/[,;]/', $module->cfgBlacklist()) as $pattern)
		{
			if (false !== strpos($_SERVER['REQUEST_URI'], $pattern))
			{
				# Do not log and email the request
				return $template;
			}
		}

		$message = self::getMessage($code);

		# Mail it?
		if (1 === preg_match("/(?:^|[,;]){$code}(?:$|[,;])/", $module->cfgMail()))
		{
			self::errorMail($code, $message);
		}

		# Log it?
		if (1 === preg_match("/(?:^|[,;]){$code}(?:$|[,;])/", $module->cfgLog()))
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
