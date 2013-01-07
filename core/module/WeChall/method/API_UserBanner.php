<?php
final class WeChall_API_UserBanner extends GWF_Method
{
	const WIDTH = 468;
	const HEIGHT = 80;

	const LOGOPATH = 'logo_wc4_80px.png';
	
	const SIZE = 14;
	const FGCOLOR = '#FFFFFF';
	const BGCOLOR = '#122639';
	const FORMAT = 'L1A2RTGCS';
	const FONT = 'teen';
	/**
	 * @var GWF_GDRect
	 */
	private $box_logo, $box_stats, $box_avatar;
	
	# L with logo
	# A with avatar
	# S best sites
	
	# U username
	# R regdate      
	# T totalscore
	# G global rank
	# C country rank
	# X signature
	
	# ?Where am i in top ten
	# ?Where am i master masters
	
	
	public function getHTAccess()
	{
		return
			'RewriteCond %{QUERY_STRING} (.*)'.PHP_EOL.
			'RewriteRule ^wechallbanner/([^.]+)\.jpg index.php?mo=WeChall&me=API_UserBanner&username=$1&%1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false === ($user = GWF_User::getByName(Common::getGetString('username'))))
		{
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		if (false !== ($error = $this->module->isExcludedFromAPI($user, false)))
		{
			return $error;
		}
		
		$this->module->includeClass('WC_RegAt');
		
		$format = Common::getGetString('format', self::FORMAT);
		$bg = Common::getGetString('bg', self::BGCOLOR);
		$fg = Common::getGetString('fg', self::FGCOLOR);
		$size = Common::clamp(Common::getGetInt('s', self::SIZE), 6, 30);
		$spacingx = Common::clamp(Common::getGetInt('sx', 1), 0, 30);
		$spacingy = Common::clamp(Common::getGetInt('sy', 1), 0, 30);
		$marginx = Common::clamp(Common::getGetInt('mx', 1), 0, 30);
		$marginy = Common::clamp(Common::getGetInt('my', 1), 0, 30);
		$divider = Common::getGetString('div', '  ');
		$font = Common::getGetString('font', self::FONT);
		$_GET['font'] = $font;
				
		if ( (!preg_match('/^[a-z_0-9]+$/iD', $font)) || (!Common::isFile(GWF_EXTRA_PATH.'font/'.$font.'.ttf')) )
		{
			return "Font not found. Available fonts: ".$this->listFonts();
		}
		
		die($this->displayBanner($user, $format, $bg, $fg, $size, $spacingx, $spacingy, $marginx, $marginy, $divider));
	}
	
	private function getFontPath()
	{
		return GWF_EXTRA_PATH.'font/'.$_GET['font'].'.ttf';
	}
	
	private function listFonts()
	{
		$files = scandir(GWF_EXTRA_PATH.'font/');
		foreach ($files as $i => $file)
		{
			if ($file[0] === '.')
			{
				unset($files[$i]);
			}
			else
			{
				$files[$i] = substr($file, 0, -4);
			}
		}
		return GWF_Array::implodeHuman($files);
	}
	
	private function getLogoPath()
	{
		return GWF_WWW_PATH.'tpl/wc4/img/'.self::LOGOPATH;
	}
	
	private function copyLogo($image, $pos=1)
	{
		# Logo
		$filename = $this->getLogoPath();
		if (false === ($logo = imagecreatefrompng($filename)))
		{
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array($filename));
			return false;
		}
		
		# Resize
		if (false === ($logo2 = GWF_Image::resize($logo, self::WIDTH, self::HEIGHT)))
		{
			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		
		$w = imagesx($logo2);
		$h = imagesy($logo2);
// 		die(sprintf("SiZE: %d x %d\n", $w, $h));
		
		
		$this->box_logo->w = $w;
		$this->box_logo->h = $h;
		
		
		if ($pos === 2)
		{
			$this->box_logo->x = $this->box_stats->getX2() + 1 - $w;
		}
		else
		{
			$this->box_stats->x += $w;
		}
		
		$this->box_stats->w -= $w;
		
		if (!imagecopy($image, $logo2, $this->box_logo->x, $this->box_logo->y, 0, 0, $w, $h))
		{
			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		imagedestroy($logo2);
		
		return true;
	}

	private function copyAvatar($image, GWF_User $user, $pos=1)
	{
		# Logo
		$filename = $user->getAvatarFilename();
		if (false === ($avatar = imagecreatefromstring(file_get_contents($filename))))
		{
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array($filename));
			return false;
		}
		
		# Resize
		if (false === ($avatar2 = GWF_Image::resize($avatar, self::WIDTH, self::HEIGHT)))
		{
			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		
		$w = imagesx($avatar2);
		$h = imagesy($avatar2);
		
		$this->box_avatar->w = $w;
		$this->box_avatar->h = $h;
		
		
		if ($pos === 2)
		{
			$this->box_avatar->x = $this->box_stats->getX2() + 1 - $w;
		}
		else
		{
			$this->box_avatar->x = $this->box_stats->x;
			$this->box_stats->x += $w;
		}
		
		if (!imagecopy($image, $avatar2, $this->box_avatar->x, $this->box_avatar->y, 0, 0, $w, $h))
		{
			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		imagedestroy($avatar2);
		
		$this->box_stats->w -= $w;
		return true;
		
	}
	
	private function copySites($image)
	{
	
	}
	
	private function parsePos(&$format, &$i)
	{
		$j = $i+1;

		if (!isset($format[$j]))
		{
			return 1;
		}
		
		$c = $format[$j];
		
		switch ($c)
		{
			case '1': $i++; return 1;
			case '2': $i++; return 2;
			default: return 1;
		}
	}
	
	private function getSignature(GWF_User $user)
	{
		return GWF_ForumOptions::getUserOptions($user, true)->getVar('fopt_signature');
	}
	
	private function displayBanner(GWF_User $user, $format=self::FORMAT, $bg=self::BGCOLOR, $fg=self::FGCOLOR, $size, $spacingx=1, $spacingy=1, $mx, $my, $divider)
	{
		$this->box_logo = new GWF_GDRect();
		$this->box_stats = new GWF_GDRect(0, 0, self::WIDTH, self::HEIGHT);
		$this->box_avatar = new GWF_GDRect();
		
// 		echo $this->box_stats->toString().PHP_EOL;
		
		# Image
		if (false === ($image = imagecreatetruecolor(self::WIDTH, self::HEIGHT)))
		{
			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		
		
		# Colors
		$bg = GWF_GDColor::fromHTML($image, $bg);
		$fg = GWF_GDColor::fromHTML($image, $fg);
		
		# BG
		imagefilledrectangle($image, 0, 0, self::WIDTH, self::HEIGHT, $bg);
		
		$format2 = '';
		
		for ($i = 0; $i < strlen($format); $i++)
		{
			$c = $format[$i];
			$pos = $this->parsePos($format, $i);
			
			switch($c)
			{
				case 'L': $this->copyLogo($image, $pos); break;
				case 'A': $this->copyAvatar($image, $user, $pos); break;
				case 'S': $this->copySites($image); break;
				default: $format2 .= $c; break;
			}
		}
		
// 		echo $this->box_stats->toString().PHP_EOL;
		
		$text = '';
		
		for ($i = 0; $i < strlen($format2); $i++)
		{
			$c = $format2[$i];
			switch($c)
			{
				case 'U': $text .= $divider.$user->getVar('user_name'); break;
				case 'R': $text .= $divider.'Registered: '.GWF_Time::displayAge($user->getVar('user_regdate')); break;
				case 'T': $text .= $divider.$this->module->langUser($user, 'th_totalscore').': '.$user->getVar('user_level'); break;
				case 'G': $text .= $divider.$this->module->langUser($user, 'th_rank2').': '.WC_RegAt::calcExactRank($user); break;
				case 'C': $text .= $divider.$this->module->langUser($user, 'th_crank').': '.WC_RegAt::calcExactCountryRank($user); break;
				case 'X': $text .= $divider.$this->getSignature($user); break;
			}
		}
		
// 		die($this->getFontPath());
		
		$text = substr($text, strlen($divider));
		if (!GWF_GDText::write($image, $this->getFontPath(), $this->box_stats->x, $this->box_stats->y, $text, $fg, $this->box_stats->w, $size, $spacingx, $spacingy, $mx, $my))
		{
			return false;
		}
		
// 		die();
		
		# Output
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	}
}
?>
