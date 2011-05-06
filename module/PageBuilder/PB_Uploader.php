<?php
/**
 * Shared code in PB to upload files.
 * @author gizmore
 */
final class PB_Uploader
{
	public static function onUpload(Module_PageBuilder $module)
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS())) {
			return $error;
		}
		if (false === ($file = GWF_Upload::getFile('file'))) {
			return GWF_HTML::err('ERR_MISSING_UPLOAD');
		}
		
		$back = '';
		
		# TODO: There are more unsafe languages!
		# But we want to keep the file extension.
		# Not really a big deal, unless you have malicious admin users.
		$name = $file['name'];
		$name = str_replace(array('/', '\\'), '', $name);
		$forbidden = array('.php', '.pl', '.py', '.asp');
		foreach ($forbidden as $ext)
		{
			if (Common::endsWith($name, $ext))
			{
				$name .= '.html';
				$back .= $module->error('err_file_ext');
				break;
			}
		}
		
		# Copy the file	
		$path = 'dbimg/content/'.$name;
		$epath = htmlspecialchars($path);
		if (Common::isFile($path)) {
			return $back.$module->error('err_upload_exists');
		}
		
		if (false === GWF_Upload::moveTo($file, $path)) {
			return $back.GWF_HTML::err('ERR_WRITE_FILE', array($epath));
		}
		
		# Append to page content as image or anchor.
		$_POST['content'] .= self::fileToContent($name, $path);
		
		return $module->message('msg_file_upped', array($epath));
	}
	
	/**
	 * Append the new uploaded file to the content.
	 * @param string $name
	 * @param string $path
	 * @return string html content
	 */
	private static function fileToContent($name, $path)
	{
		$image_ext = array('.png', '.jpg', '.jpeg', '.bmp', '.tiff', '.gif');
		foreach ($image_ext as $ext)
		{
			if (Common::endsWith($name, $ext))
			{
				return self::fileToIMG($name, $path);
			}
		}
		return self::fileToAnchor($name, $path);
	}
	
	private static function fileToIMG($name, $path)
	{
		$epath = htmlspecialchars($path);
		$ename = htmlspecialchars($name);
		return sprintf('<img src="%s%s" title="Title of %s" alt="Image %s" />', GWF_WEB_ROOT, $epath, $ename, $ename);
	}
	
	private static function fileToAnchor($name, $path)
	{
		$epath = htmlspecialchars($path);
		$ename = htmlspecialchars($name);
		return sprintf('<a href="%s%s" title="Title of %s">%s</a>', GWF_WEB_ROOT, $epath, $ename, $ename);
	}
}
?>