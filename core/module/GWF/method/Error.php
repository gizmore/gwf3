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
		
		return $this->templateError($this->_module);
	}
	
	private function templateError()
	{
		# Get the error page
		$errors = array(403, 404);
		$realcode = Common::getGetInt('code', 0);
		$code =  in_array($realcode, $errors, true) ? $realcode : 0;

		if ($realcode === 403)
		{
			header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden"); 
		}
		else
		{
			header($_SERVER['SERVER_PROTOCOL']." 404 Not Found"); 
		}
		
		
		// Real 404 page?
		if ($realcode === 404)
		{
			// Mail it?
			if ($this->_module->cfgMail404())
			{
				self::gwf_error_404_mail();
			}
			
			// Log it?
			if ($this->_module->cfgLog404())
			{
				GWF_Log::log('404', self::get404Message(), true);
			}
		}
		
		$err_msg =  GWF_HTML::lang('ERR_FILE_NOT_FOUND', array(htmlspecialchars($_SERVER['REQUEST_URI'])));
		
		$tVars = array(
			'code' => $realcode,
			'file' => GWF_HTML::error(GWF_SITENAME, $err_msg, false),
		);
		
		return $this->_module->template('error.tpl', $tVars);
	}
	
	public static function gwf_error_404_mail()
	{
		$blacklist = array(
		);
		
		if (in_array($_SERVER['REQUEST_URI'], $blacklist, true))
		{
			return;
		}
		
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_ADMIN_EMAIL);
		$mail->setSubject(GWF_SITENAME.': 404 Error');
		$mail->setBody(self::get404MailMessage());
		$mail->sendAsText();
	}
	
	private static function get404MailMessage()
	{
		$referrer = isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '';
		return $referrer.PHP_EOL.PHP_EOL.self::get404Message();
	}
	
	private static function get404Message()
	{
		return sprintf('The page %s threw a 404 error.', htmlspecialchars($_SERVER['REQUEST_URI']));
	}
}
?>