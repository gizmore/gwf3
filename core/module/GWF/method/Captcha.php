<?php
/**
 * Create and display a captcha.
 * @author gizmore, spaceone
 */
class GWF_Captcha extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^Captcha/?$ index.php?mo=GWF&me=Captcha'.PHP_EOL.
			'RewriteRule ^Captcha/([^/]+)$ index.php?mo=GWF&me=Captcha&chars=$1'.PHP_EOL;
	}
	
	public function execute() 
	{
		# Don't store this url.
		GWF3::setConfig('store_last_url', false);
		
		# Load the Captcha class
		require(GWF_CORE_PATH.'inc/3p/Class_Captcha.php');
		
		# disable Logging
		GWF3::setConfig('log_request', false);
		
		# disable HTTP Caching
		GWF_HTTP::noCache();
		
		# Setup Font, Color, Size
		$aFonts = $this->_module->cfgCaptchaFont();
		$rgbcolor = $this->_module->cfgCaptchaBG();
		$width = $this->_module->cfgCaptchaWidth();
		$height = $this->_module->cfgCaptchaHeight();
		$oVisualCaptcha = new PhpCaptcha($aFonts, $width, $height, $rgbcolor);
		
		# Output the captcha
		die($oVisualCaptcha->Create('', Common::getGetString('chars', true)));
	}
}
?>