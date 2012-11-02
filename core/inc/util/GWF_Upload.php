<?php
/**
 * Check if uploaded files are there.
 * Shrink images.
 * @author gizmore
 * @version 1.0
 */
final class GWF_Upload
{
	/**
	 * Get a file from a post request, if successfully submitted. Return the file array from $_FILES on success. The returned array contains: error, size, type, name, tmp_name.
	 * @param $var is the name of the $_FILES[key]
	 * @return array - the file from $_FILES or false.
	 */
	public static function getFile($key)
	{
		if (!isset($_FILES[$key])) {
			return false;
		}
		$file = $_FILES[$key];
		if (intval($file['error']) !== 0) {
			return false;
		}
		if (intval($file['size']) === 0) {
			return false;
		}
		return $file;
	}

	public static function getMaxUploadSize()
	{
		$mu = ini_get('upload_max_size');
		$mp = ini_get('post_max_size');

		if ($mu == false) {
			$mu = 1000000000; # 1GB
		}
		if ($mp == false) {
			$mp = 1000000000;
		}

		$mu = self::iniToBytes($mu);
		$mp = self::iniToBytes($mp);

		return min(array($mu, $mp));
	}

	/**
	 * Convert human filesize to bytes. Example 1KB = 1024. Optionally supports 1000 or 1024. 
	 * @param string $human
	 * @param int $factor
	 * @return int
	 */
	private static function iniToBytes($human, $factor=1024)
	{
		$bytes = 0;
		$f = $factor;
		$units = array(
			'B' => 1,
			'KB' => $f,
			'K'  => $f,
			'MB' => $f*$f,
			'M'  => $f*$f,
			'GB' => $f*$f*$f,
			'G'  => $f*$f*$f,
			'TB' => $f*$f*$f*$f,
			'T'  => $f*$f*$f*$f,
			'PB' => $f*$f*$f*$f*$f,
			'P'  => $f*$f*$f*$f*$f,
		);
		$bytes = floatval($human);
		if (preg_match('#([KMGTP]?B?)$#siD', $human, $matches) && !empty($units[$matches[1]]))
		{
			$bytes *= $units[$matches[1]];
		}
		$bytes = intval(round($bytes, 2));
		return $bytes;
	}

	/**
	 * Get the mime type of the file, by reading it`s content, not by extension.
	 * @param string $filename
	 * @return string
	 */
	public static function getMimeType($filename)
	{
		if (function_exists('finfo_open')) {
			return self::getMimeTypeB($filename);
		}
		elseif (function_exists('mime_content_type')) {
			return mime_content_type($filename);
		}
		else {
			return self::getMimeTypeFallback($filename);
		}
	}

	/**
	 * No built-in available for mime detection.
	 * @param string $filename
	 * @return string
	 */
	private static function getMimeTypeFallback($filename)
	{
		return 'application/octet-stream';
	}

	/**
	 * Use fileinfo extension to detect mime type of a file.
	 * @param string $filename
	 * @return string
	 */
	private static function getMimeTypeB($filename)
	{
		$finfo = finfo_open(FILEINFO_MIME);
		$mime = finfo_file($finfo, $filename);
		finfo_close($finfo);
		return Common::substrUntil($mime, ';');
	}

	/**
	 * Move file to a public accesible dir.
	 * On error return false. On success return the same file structure with an altered tmp_name
	 * @param $file array - structure from $_FILES.
	 * @param $pubtemp - path to public readable dir on server, defaults to "temp"
	 * @return mixed - false or array.
	 * */
	public static function moveToPublicTemp($file, $pubtemp='extra/temp/upload')
	{
		$newtmp = self::getFileName($file['tmp_name']);
		$newtmp = $pubtemp.'/'.$newtmp;
		return self::moveTo($file, $newtmp);
	}

	/**
	 * Actually this is "copy to"!
	 * @param array $file
	 * @param unknown_type $target
	 * @return unknown_type
	 */
	public static function moveTo(array $file, $target)
	{
		if (false === copy($file['tmp_name'], $target)) {
//			die('CANT COPY FILE IN '.__CLASS__.' '.__FUNCTION__);
			return false;
		}
		$file['tmp_name'] = $target;
		return $file;
	}

	/**
	 * Get the filename from a path / full name.
	 * eg: /foo/bar will become bar.
	 * @param $filename string full path
	 * @return string filename.
	 * */
	public static function getFileName($filename)
	{
		$filename = Common::getUnixPath($filename);
		if (false === ($pos = strrpos($filename, '/'))) {
			return $filename;
		}
		return substr($filename, $pos+1);
	}

	/**
	 * Check MIME Type of $_FILES[file]['type]. Return true or false.
	 * @param array $file from $_FILES[$file]
	 * @return boolean
	 * */
	public static function isImageFile(array $file)
	{
		return self::isImageMime($file['type']);
	}

	/**
	 * Check if mimetype is image
	 * @param unknown_type $mime
	 * @return unknown_type
	 */
	public static function isImageMime($mime)
	{
		return Common::startsWith($mime, 'image/');
	}

	/**
	 * Resize an image and replace it with a scaled jpg image.
	 * If the image is within the bounds, it will not get touched.
	 * Else the file will get replaced with a scaled jpeg.
	 * @param $file array
	 * @param $max_width int
	 * @param $max_height int
	 * @param $min_width int
	 * @param $min_height int
	 * @return boolean
	 */
	public static function resizeImage(array $file, $max_width, $max_height, $min_width=1, $min_height=1)
	{
		// HACK
		if (false === ($image = @imagecreatefromstring(file_get_contents($file['tmp_name'])))) {
			return false;
		}

		// Resize and output
		$back = self::resizeImageB($image, $file, $max_width, $max_height, $min_width, $min_height);
		imagedestroy($image);
		return $back;
	}

	private static function resizeImageB($image, array $file, $max_width, $max_height, $min_width=1, $min_height=1)
	{
		if (0 === ($width = imagesx($image)) || 0 === ($height = imagesy($image))) {
			echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
			return false;
		}

		if ($width < $min_width) {
			$scale_x = $width / $min_width;
		} elseif ($width > $max_width) {
			$scale_x = $max_width / $width;
		} else {
			$scale_x = 1.0;
		}

		if ($height < $min_height) {
			$scale_y = $height / $min_height;
		} elseif ($height > $max_height) {
			$scale_y = $max_height / $height;
		} else {
			$scale_y = 1.0;
		}

		# All fine
		if ($scale_x === 1.0 && $scale_y === 1.0) {
			return true;
		}

		return self::resizeImageC($image, $scale_x, $scale_y, $width, $height, $file);
	}

	private static function resizeImageC($image, $scale_x, $scale_y, $width, $height, array $file)
	{
		$new_width = round($scale_x * $width);
		$new_height = round($scale_y * $height);
		if ($new_height <= 0 || $new_width <= 0) {
			echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
			return false;
		}
	
		# Create new Image
		if (false === ($resized_img = imagecreatetruecolor($new_width, $new_height))) {
			echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
			return false;
		}

		$back = false;
		# Resize into it
		if (false !== imagecopyresized($resized_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height)) {
			# Save to file
			if (false !== imagejpeg($resized_img, $file['tmp_name'])) {
				$back = true;
			}
			else {
				echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
			}
		}
		else {
			echo GWF_HTML::err('ERR_GENERAL', __FILE__, __LINE__);
		}
		# Destroy the img.
		imagedestroy($resized_img);
		return $back;
	}

	/**
	 * Output a file.
	 * @param string $fullpath
	 * @param boolean $as_attach
	 * @param string $mime
	 * @param mixed $filename
	 * @return unknown_type
	 */
	public static function outputFile($fullpath, $as_attach=true, $mime='application/octet-stream', $filename=true)
	{
		header("Content-type: $mime");

		if ($as_attach)
		{
			if (!is_string($filename))
			{
				$filename = basename($fullpath);
			}
			header("Content-disposition: attachment; filename=$filename");
		}

		readfile($fullpath);
// 		echo file_get_contents($fullpath);
	}

	public static function humanFilesize($bytes, $factor='1024', $digits='2')
	{
//		var_dump($bytes, $factor, $digits);
		$txt = GWF_HTML::lang('filesize');
		$i = 0;
		$rem = '0';
		while (bccomp($bytes, $factor) >= 0)
		{
			$rem = bcmod($bytes, $factor);
			$bytes = bcdiv($bytes, $factor);
			$i++;
		}
		return $i === 0
			? sprintf("%s%s", $bytes, $txt[$i])
			: sprintf("%.0{$digits}f%s", ($bytes+$rem/$factor), $txt[$i]);
	}

}

