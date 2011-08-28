<?php

/**
 * Description of Error
 *
 * @author spaceone
 */
final class GWF_Error extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^error/(.*?)$ index.php?mo=GWF&me=Error&code=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		# Do not remember this "non 200" page
		GWF3::setConfig('store_last_url', false);
		
		return $this->templateError($module);
	}
	
	private function templateError(Module_GWF $module)
	{
		# Get the error page
		$errors = array(403, 404);
		$realcode = Common::getGetInt('code', 0);
		$code =  in_array($realcode, $errors, true) ? $realcode : 0;

		if ($realcode === 403) {
			header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden"); 
		} else {
			header($_SERVER['SERVER_PROTOCOL']." 404 Not Found"); 
			self::gwf_error_404_mail();
		}
		
		$tVars = array(
			'code' => $realcode,
			'file' => GWF_HTML::err(GWF_HTML::lang('ERR_FILE_NOT_FOUND', array(htmlspecialchars($_SERVER['REQUEST_URI'])))),
		);
		return $module->template('error.tpl', $tVars);
	}
	
	public static function gwf_error_404_mail()
	{
		$blacklist = array(
		);
		$pagename = $_SERVER['REQUEST_URI'];
		if (in_array($pagename, $blacklist, true)) {
			return;
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_ADMIN_EMAIL);
		$mail->setSubject(GWF_SITENAME.': 404 Error');
		$mail->setBody(sprintf('The page %s threw a 404 error.', $pagename));
		$mail->sendAsText();
	}
	
}
?>