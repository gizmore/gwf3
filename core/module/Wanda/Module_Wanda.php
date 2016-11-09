<?php
/**
 * 
 * find images -type f -exec convert {} -resize "50%" images_medium/{}  \;
 * 
 * @author gizmore
 * @version 1.0
 */
final class Module_Wanda extends GWF_Module
{
	public function getDefaultAutoLoad() { return true; }
	
	private static $WANDA__PAGES = array(29, 20);
	private static $WANDA_IMAGES = array(
		'1.1.1' => array(23,17),
		'1.2.1' => array(21,17),
		'1.2.2' => array(18,12),
		'1.3.1' => array(19,15),
		'1.3.2' => array(12,14),
		'1.3.3' => array(19,11),
		'1.4.1' => array(18, 9),
		'1.5.1' => array(19,14),
		'1.5.2' => array(14, 6),
		'1.6.1' => array(32,12),
		'1.6.2' => array(15,15),
		'1.7.1' => array(18,18),
		'1.8.1' => array(18,18),
		'1.9.1' => array(30,16),
		'1.10.1' => array(24,15),
		'1.11.1' => array(13,16),
		'1.12.1' => array(17,13),
		'1.13.1' => array(15,19),
		'1.14.1' => array(33,11),
		'1.15.1' => array(19,11),
		'1.16.1' => array(16,13),
		'1.17.1' => array(13,11),
		'1.18.1' => array(14,13),
		'1.19.1' => array(14,12),
		'1.20.1' => array(13,13),
		'1.20.2' => array(32, 8),
		'1.21.1' => array(15,13),
		'1.21.2' => array(13,14),
		'1.22.1' => array(16,11),
		'1.23.1' => array(14,12),
		'1.24.1' => array(14,12),
		'1.25.1' => array(33,14), # Largest!
		'1.26.1' => array(12,13),
		'1.26.2' => array(18,17),
		'1.27.1' => array(17,13),
		'1.28.1' => array(14,13),
		'1.29.1' => array(14,15),
			
		'2.1.1' => array(18,15),
		'2.2.1' => array(17,15),
		'2.3.1' => array(),
		'2.4.1' => array(),
		'2.5.1' => array(),
		'2.6.1' => array(),
		'2.7.1' => array(),
		'2.8.1' => array(),
		'2.9.1' => array(),
		'2.10.1' => array(),
		'2.11.1' => array(),
		'2.12.1' => array(),
		'2.13.1' => array(),
		'2.14.1' => array(),
		'2.15.1' => array(),
		'2.16.1' => array(),
		'2.17.1' => array(),
		'2.18.1' => array(),
		'2.19.1' => array(),
		'2.20.1' => array(),
		'2.21.1' => array(),
	);
	
	
	##################
	### GWF_Module ###
	##################
	private static $instance;
	public static function instance()
	{
		return self::$instance;
	}
	
	public function getVersion() { return 1.00; }
	public function getDefaultPriority() { return 64; }
// 	public function getClasses() { return array('GWF_Guestbook', 'GWF_GuestbookMSG'); }
// 	public function onInstall($dropTable) { require_once 'GWF_GuestbookInstall.php'; return GWF_GuestbookInstall::onInstall($this, $dropTable); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/wanda'); }
	##############
	### Config ###
	##############
// 	public function cfgItemsPerPage() { return $this->getModuleVarInt('gb_ipp', 10); }
// 	public function cfgAllowURL() { return $this->getModuleVarBool('gb_allow_url', '1'); }
// 	public function cfgAllowEMail() { return $this->getModuleVarBool('gb_allow_email', '1'); }
// 	public function cfgAllowGuest() { return $this->getModuleVarBool('gb_allow_guest', '1'); }
// 	public function cfgGuestCaptcha() { return $this->getModuleVarBool('gb_captcha', '1'); }
// 	public function cfgMaxUsernameLen() { return $this->getModuleVarInt('gb_max_ulen', GWF_User::USERNAME_LENGTH); }
// 	public function cfgMaxMessageLen() { return $this->getModuleVarInt('gb_max_msglen', 1024); }
// 	public function cfgMaxTitleLen() { return $this->getModuleVarInt('gb_max_titlelen', 63); }
// 	public function cfgMaxDescrLen() { return $this->getModuleVarInt('gb_max_descrlen', 255); }
// 	public function cfgLevel() { return $this->getModuleVarInt('gb_level', 0); }
// 	public function cfgNesting() { return $this->getModuleVarBool('gb_nesting', '1'); }
	###############
	### Upgrade ###
	###############
	public function onStartup()
	{
		self::$instance = $this;
		$this->onLoadLanguage();
	}
	
	public function validateBookId($bookId)
	{
		$bookId = (int)$bookId;
		return (($bookId < 1) || ($bookId > 2)) ? false : $bookId;
	}
	
	
	public function wandaImage($book, $page, $image)
	{
		if (Common::getGetString('me') === 'GeneratePDF') {
			return $this->wandaImageSinglePage($book, $page, $image);
		}
		else {
			return $this->wandaImageSinglePage($book, $page, $image);
		}
	}

	public function wandaImageInline($book, $page, $image)
	{
		$imagePath = sprintf("%smodule/Wanda/content/images_medium/images/Book%dPage%02dImage%d.png", GWF_CORE_PATH, $book, $page, $image);
		$imageData = base64_encode(file_get_contents($imagePath));
		
		$key = sprintf('%d.%d.%d', $book, $page, $image);
		$w_h = self::$WANDA_IMAGES[$key];
		$scale = 30; $w = $w_h[0] * $scale; $h = $w_h[1] * $scale;
		
		$dataURL = 'data: '.mime_content_type($imagePath).';base64,'.$imageData;
		
		return sprintf('<img src="%s" width=%d height=%d />', $dataURL, $w, $h);
	}
	
	public function wandaImageSinglePage($book, $page, $image)
	{
		$key = sprintf('%d.%d.%d', $book, $page, $image);
		$w_h = self::$WANDA_IMAGES[$key];
		$scale = 30;
		$w = $w_h[0] * $scale;
		$h = $w_h[1] * $scale;
		$src = sprintf("%swanda/image/book/%d/page/%d/image/%d", GWF_WEB_ROOT_NO_LANG, $book, $page, $image);
		return sprintf('<img src="%s" width=%d height=%d />', $src, $w, $h);
	}
	
	public function getWandaPagecount($book)
	{
		return self::$WANDA__PAGES[$book-1];
	}

	public function getBookTitle($book)
	{
		return $this->lang("book$book");
	}
	
}
