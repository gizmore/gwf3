<?php
/**
 * Score Buttons
 * @author gizmore
 */
final class Votes_Button extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^votes/button/([0-9]+)/([0-9]+)/of/([0-9]+)\.(gif|jpg|png)$ index.php?mo=Votes&me=Button&size=$1&num=$2&of=$3&ext=$4&no_session=true'.PHP_EOL;
	}
	
	public function execute()
	{
		GWF3::setConfig('store_last_url', false);
		
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		
		return $this->imageButton();
	}

	private function sanitize()
	{
		static $valid = array('gif', 'jpg', 'png');
		$this->size = Common::clamp(Common::getGet('size', 1), 16, 64);
		$this->of = Common::clamp(Common::getGet('of', 1), 1, 16);
		$this->num = Common::clamp(Common::getGet('num', 1), 1, $this->of);
		$this->ext = Common::getGet('ext');
		if (!in_array($this->ext, $valid, true)) {
			$this->ext = 'gif';
		}
		return false;
	}
	
	private function imageButton()
	{
		$cs = $this->size;
		$cx = $cy = round($this->size/2);
		if (false === ($image = imagecreatetruecolor($cs, $cs))) {
			return GWF_HTML::err('ERR_GENERAL');
		}
		imagealphablending($image, true);
		$background = imagecolorallocatealpha($image, 0x00, 0x00, 0x00, 0x00);
		imagecolortransparent($image, $background);
		$color = $this->getColor($this->_module, $image);
		$white = imagecolorallocate($image, 0xff, 0xff, 0xff);
		imagefilledellipse($image, $cx, $cy, $cs, $cs, $white);
		imagefilledellipse($image, $cx, $cy, $cs-1, $cs-1, $color);
		
		header('Content-Type: image/'.$this->ext);
		switch ($this->ext)
		{
			case 'png': imagepng($image); break;
			case 'gif': imagegif($image); break;
			case 'jpg': imagejpeg($image); break;
			default: return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		imagedestroy($image);
		die(0);
	}
	
	private function getColor(Module_Votes $module, $image, $mincolor=0xffff0000, $maxcolor=0xff00ff00)
	{
		return GWF_Color::interpolateBound($image, 1, $this->of, $this->num, $mincolor, $maxcolor); #, $max, $value)
	}
}
?>
