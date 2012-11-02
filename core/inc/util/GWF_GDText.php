<?php
final class GWF_GDText
{
	public static function write($image, $fontfile, $x, $y, $text, $color, $maxwidth, $size=11, $spacingx=2, $spacingy=2, $mx=1, $my=1, $angle=0)
	{
		if (!Common::isFile($fontfile))
		{
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array(htmlspecialchars($fontfile)));
			return false;
		}

		$dim = GWF_GDText::getFontSize($fontfile, $size, $angle);
		$fontwidth = $dim->w;
		$fontheight = $dim->h;

		if ($maxwidth != NULL)
		{
// 			die(''.$maxwidth);
			$maxcharsperline = floor($maxwidth / $fontwidth);
			$text = wordwrap($text, $maxcharsperline, "\n", 1);
// 			die($text);
		}
		
// 		die(var_dump($color));

		$lines = explode("\n", $text);
		$x += $mx;
		$y += $my;
		foreach ($lines as $line)
		{
			$y += $fontheight + $spacingy;
			imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $line);
		}
		return true;
	}

	public static function getFontSize($fontfile, $size, $angle=0)
	{
		$rect = GWF_GDRect::fromTTFBox(imagettfbbox($size, $angle, $fontfile, 'Q'));
		return new GWF_GDDimension($rect->w, $rect->h);		
	}
}
?>
