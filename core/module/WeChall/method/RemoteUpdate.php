<?php
/**
 * Trigger an update remotely.
 * @author Kender
 */
final class WeChall_RemoteUpdate extends GWF_Method
{
	public function getHTAccess()
	{
		return 
			'RewriteCond %{QUERY_STRING} (.*)'.PHP_EOL.
			'RewriteRule ^remoteupdate.php$ index.php?mo=WeChall&me=RemoteUpdate&%1'.PHP_EOL;
	}

	public function execute()
	{
		$syntax = 'syntax: ' . Common::getAbsoluteURL('remoteupdate.php'). '?sitename=FOO&username=BAR';
		$server = htmlspecialchars($_SERVER['SERVER_NAME'], ENT_QUOTES);
		$unknownsite = 'Join us: '.Common::getAbsoluteURL('join_us');# "Join us: http://$server/join.php";
		$unknownuser = 'Register at '.Common::getAbsoluteURL('register').' for global ranking. Please note that the username is case sensitive for remoteupdates.';
		
		// flag for images. 0=normal text, 1=default image, we can assign different image styles to higher numbers
		$img = (int) Common::getGet('img', 0);
		
		if (false === ($sitename = Common::getRequest('sitename')))
		{
			$this->outDie($syntax);
		}
		if (false === ($onsitename = Common::getRequest('username')))
		{
			$this->outDie($syntax);
		}
		if ($sitename === 'FOO' && $onsitename === 'BAR')
		{
			$this->outDie('Doh! Not literally!');
		}
		
		if ( (false === ($site = WC_Site::getByName($sitename))) && (false === ($site = WC_Site::getByClassName($sitename))) )
		{
			$this->outExit($unknownsite);
		}
		
		$this->_module->includeClass('WC_RegAt');
		if (false === ($user = WC_RegAt::getUserByOnsiteName($onsitename, $site->getID())))
		{
			$this->outExit($unknownuser);
		}
		
		# Update him
		$result = $site->onUpdateUser($user);
		
		# Output result
		switch ($img)
		{
			case 0: $this->outResult($result); break;
			case 1: $this->imgDisplayText($result->getMessage()); break;
		}
	}

	private function outResult(GWF_Result $result)
	{
		die($result->display('WeChall'));
	}
	
	private function outDie($text)
	{
		global $img;
		switch ($img) {
			case 0: die($text); break;
			case 1: $this->imgDisplayText($text, 3, false, 0xff, 0x00, 0x00); die;
		}
	}
	
	private function outExit($text)
	{
		global $img;
		switch ($img) {
			case 0: die($text); break;
			case 1: $this->imgDisplayText($text); exit;
		}
	}
	
	
	# Output a string as an image (type 1)
	private function imgDisplayText($text, $font_size=2, $border=true, $r=0x00, $g=0x00, $b=0x55, $padding=3)
	{
		// get the lines
		$ts=explode(PHP_EOL, $text);
		$width=0;
		//compute width
		foreach ($ts as $string)
		{
			$width=max($width,strlen($string));
		}
		# Create image width dependant on width of the string
		$width = imagefontwidth($font_size)*$width + 2*$padding;
		// Set height to that of the font
		$height = imagefontheight($font_size)*count($ts) + 2*$padding;
		$el = imagefontheight($font_size);
		// Create the image pallette
		$img = imagecreatetruecolor($width, $height);
		// font color
		$color = imagecolorallocate($img, $r, $g, $b);
		// background
		$bg = imagecolorallocate($img, 0xEE, 0xEE, 0xEE);
		imagefill($img, 0, 0, $bg);
		//border
		if ($border) {
			imagerectangle($img, 0, 0, $width-1, $height-1, $color);
		}
		// draw lines of text
		$yPos = $padding;
		foreach ($ts as $string)
		{
			imagestring($img, $font_size, $padding, $yPos, $string, $color);
			$yPos += $el;
		}
		// Return the image
		header("Content-Type: image/png");
		imagepng($img);
		imagedestroy($img);
	}
}
?>