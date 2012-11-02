<?php
/**
 * Color stuff. Gradients, .
 * @author gizmore
 * @version 3.0
 * @since 3.0
 */
final class GWF_Color
{
	######################
	### GD Interpolate ###
	######################
	/**
	 * Colors as 8byte hex string (0 padded).
	 * perc has to be betweeen 0-1
	 * @param float $perc
	 * @param string $mincolor
	 * @param string $maxcolor
	 * @return unknown_type
	 */
	public static function interpolateBound($image, $min, $max, $value, $mincolor=0xffff0000, $maxcolor=0xff00ff00)
	{
		$range = $max - $min;
		$value -= $min;
		if ($range == 0) {
			return $maxcolor;
		}
		return self::interpolate($image, $value / $range, $mincolor, $maxcolor);
	}
	public static function interpolate($image, $perc, $mincolor=0xffff0000, $maxcolor=0xff00ff00)
	{
#		$A0 = ($mincolor & 0xff000000) >> 24;
		$R0 = ($mincolor & 0x00ff0000) >> 16;
		$G0 = ($mincolor & 0x0000ff00) >> 8;
		$B0 = ($mincolor & 0x000000ff);
#		$A1 = ($maxcolor & 0xff000000) >> 24;
		$R1 = ($maxcolor & 0x00ff0000) >> 16;
		$G1 = ($maxcolor & 0x0000ff00) >> 8;
		$B1 = ($maxcolor & 0x000000ff);
#		$A2 = round(($A1-$A0) * $perc + $A0);
		$R2 = round(($R1-$R0) * $perc + $R0);
		$G2 = round(($G1-$G0) * $perc + $G0);
		$B2 = round(($B1-$B0) * $perc + $B0);
		return imagecolorallocate($image, $R2, $G2, $B2);
	}

	########################
	### HTML Interpolate ###
	########################
	public static function interpolatBound($min, $max, $value, $mincolor=0xffff0000, $maxcolor=0xff00ff00)
	{
		$range = $max - $min;
		$value -= $min;
		return self::interpolat($value / $range, $mincolor, $maxcolor);
	}
	public static function interpolat($perc, $mincolor=0xffff0000, $maxcolor=0xff00ff00)
	{
#		$A0 = ($mincolor & 0xff000000) >> 24;
		$R0 = ($mincolor & 0x00ff0000) >> 16;
		$G0 = ($mincolor & 0x0000ff00) >> 8;
		$B0 = ($mincolor & 0x000000ff);
#		$A1 = ($maxcolor & 0xff000000) >> 24;
		$R1 = ($maxcolor & 0x00ff0000) >> 16;
		$G1 = ($maxcolor & 0x0000ff00) >> 8;
		$B1 = ($maxcolor & 0x000000ff);
#		$A2 = round(($A1-$A0) * $perc + $A0);
		$R2 = round(($R1-$R0) * $perc + $R0);
		$G2 = round(($G1-$G0) * $perc + $G0);
		$B2 = round(($B1-$B0) * $perc + $B0);
		return sprintf('%02X%02X%02X', $R2, $G2, $B2);
	}
}
