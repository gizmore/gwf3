<?php
final class GWF_Image
{
	/**
	 * Resize an image and keep aspect ratio.
	 * @param GDImage $image
	 * @param int $max_width
	 * @param int $max_height
	 * @param int $min_width
	 * @param int $min_height
	 * @return false||GDImage
	 */
	public static function resize($image, $max_width, $max_height, $min_width=1, $min_height=1)
	{
		if (0 >= ($width = imagesx($image)) || 0 >= ($height = imagesy($image)))
		{
			echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
			return false;
		}
		
// 		$width = min(array($min_width, $width));
// 		$height = min(array($min_height, $height));
		
// 		$vx = $width / $max_width;
// 		$vy = $height / $max_height;
		$scale_x = $max_width / $width;
		$scale_y = $max_height / $height;
		
// 		printf("Have to scale %.02f in X\n", $vx);
// 		printf("Have to scale %.02f in Y\n", $vy);
		
// 		die();
		
// 		$scale_x = 1.0;
// 		$scale_y = 1.0;
		
		if ($scale_x < $scale_y)
		{
			# X Scale
// 			if ($width < $min_width) {
// 				$scale_x = $width / $min_width;
// 			} elseif ($width > $max_width) {
// 				$scale_x = $max_width / $width;
// 			}
			
// 			echo $scale_x;
// 			die('A');
			
// 			# Y Scale
// 			$scale_y = $scale_x;
			$scale_y = $scale_x;
		}
		
		else
		{
			
			# Y Scale
// 			if ($height < $min_height) {
// 				$scale_y = $height / $min_height;
// 			} elseif ($height > $max_height) {
// 				$scale_y = $max_height / $height;
// 			}
			
// 			echo $scale_y;
// 			die('B');
			# X Scale
			$scale_x = $scale_y;
		}
		
// 		$scale_x = $scale_y;
// 		$scale_x = $vx;
// 		$scale_y = $vy;
		
// 		# All fine
// 		if ($scale_x === 1.0 && $scale_y === 1.0)
// 		{
// 			return $image;
// 		}
		
		
		return self::scaleImage($image, $scale_x, $scale_y, $width, $height);
	}
	
	private static function scaleImage($image, $scale_x, $scale_y, $width, $height, $destroy=true)
	{
		$new_width = round($scale_x * $width);
		$new_height = round($scale_y * $height);
		
		if ($new_height <= 0 || $new_width <= 0)
		{
			echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
			return false;
		}
	
		# Create new Image
		if (false === ($resized_img = imagecreatetruecolor($new_width, $new_height)))
		{
			echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
			return false;
		}
	
		# Resize into it
		if (false === imagecopyresized($resized_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height))
		{
			echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
			return false;
		}
		
		if ($destroy)
		{
			imagedestroy($image);
		}		

		return $resized_img;
	}
	
}
?>
