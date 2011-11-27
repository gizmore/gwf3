<?php

/**
 * Create and display an Captcha
 * @author gizmore, spaceone
 */
class GWF_Captcha extends GWF_Method
{
	public function getHTAccess(GWF_Module $module) {
		return 'RewriteRule ^Captcha/?$ index.php?mo=GWF&me=Captcha'.PHP_EOL.
			'RewriteRule ^img/captcha(?:\.php)?$ index.php?mo=GWF&me=Captcha'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module) 
	{
		# Load the Captcha class
		require(GWF_CORE_PATH.'inc/3p/Class_Captcha.php');
		
		# disable Logging
		GWF3::setConfig('log_request', false);
		
		# disable HTTP Caching
		GWF_HTTP::noCache();
		
		# Setup Font, Color, Size
		$aFonts = $module->cfgCaptchaFont();
		$rgbcolor = $module->cfgCaptchaBG();
		$width = $module->cfgCaptchaWidth();
		$height = $module->cfgCaptchaHeight();
		$oVisualCaptcha = new PhpCaptcha($aFonts, $width, $height, $rgbcolor);
		
		# Output the captcha
		die($oVisualCaptcha->Create('', Common::getGetString('chars', true)));
	}
}

?>