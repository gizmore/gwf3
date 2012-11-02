<?php
final class GWF_GDColor
{
	/**
	 * Allocate a color from html notation. Like #000 or #ffffff
	 * @param gd_image $image
	 * @param string $col
	 * @return gd_color
	 */
	public static function fromHTML($image, $col='#000')
	{
		$col = ltrim($col, '#');
		
		$len = strlen($col);
		
		if ($len === 3)
		{
			$col2 = '';
			for ($i=0;$i<3;$i++) { $c = $col[$i]; $col2 .= $c; $col2 .= $c; }
			$len = 6;
			$col = $col2;
		}
		
		if ($len === 6)
		{
			sscanf($col, "%02x%02x%02x", $r, $g, $b);
			return imagecolorallocate($image, $r, $g, $b);
		}
		
		return imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));
	}
}
?>
