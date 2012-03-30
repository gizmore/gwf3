<?php
/**
 * Shared code in PB to upload files.
 * @author gizmore
 */
final class PB_Uploader
{
	public static function onUpload(Module_PageBuilder $module)
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS()))
		{
			return $error;
		}
		if (false === ($file = GWF_Upload::getFile('file')))
		{
			return GWF_HTML::err('ERR_MISSING_UPLOAD');
		}
		
		$back = '';
		
		# TODO: There are more unsafe languages!
		# But we want to keep the file extension.
		# Not really a big deal, unless you have malicious admin users.
		$name = $file['name'];
// 		$name = str_replace(array('/', '\\'), '', $name);
// 		$forbidden = array('.php',/* '.pl', '.py', '.asp'*/);
// 		foreach ($forbidden as $ext)
// 		{
// 			if (Common::endsWith($name, $ext))
// 			if (Common::endsWith($name, '.php'))
// 			{
// 				$name .= '.html';
// 				$back .= $module->error('err_file_ext');
// 				return $back;
// 			}
// 		}

		# This is evil, sometimes even with foo.php.html
		if (stripos($name, '.php') !== false)
		{
			return $module->error('err_file_ext');
		}

		# We do a sanity check here
		if (!preg_match('#^[a-z0-9_][a-z0-9_\\.]{0,62}$#iD', $name))
		{
			$back .= $module->error('err_file_name');
			return $back;
		}
		
		# Copy the file	
		$path = 'dbimg/content/'.$name;
		$epath = htmlspecialchars($path);
		if (Common::isFile($path))
		{
			return $back.$module->error('err_upload_exists');
		}
		
		if (false === GWF_Upload::moveTo($file, $path))
		{
			return $back.GWF_HTML::err('ERR_WRITE_FILE', array($epath));
		}
		
		# Is bbcode mode?
		$bbcode = (Common::getPostInt('type', 0) & (GWF_Page::HTML|GWF_Page::SMARTY)) === 0; 
		
		# Append to page content as image or anchor.
		$_POST['content'] .= self::fileToContent($name, $path, $bbcode);
		
		return $module->message('msg_file_upped', array($epath));
	}
	
	/**
	 * Append the new uploaded file to the content.
	 * @param string $name
	 * @param string $path
	 * @return string html content
	 */
	private static function fileToContent($name, $path, $bbcode)
	{
		$image_ext = array('.png', '.jpg', '.jpeg', '.bmp', '.tiff', '.gif');
		foreach ($image_ext as $ext)
		{
			if (Common::endsWith($name, $ext))
			{
				return self::fileToIMG($name, $path, $bbcode);
			}
		}
		return self::fileToAnchor($name, $path, $bbcode);
	}
	
	private static function fileToIMG($name, $path, $bbcode)
	{
		if ($bbcode)
		{
			return sprintf('[img title="%s"]%s%s[/img]', $name, GWF_WEB_ROOT, $path);
		}
		$epath = htmlspecialchars($path);
		$ename = htmlspecialchars($name);
		return sprintf('<img src="%s%s" title="%s" alt="Image %s" />', GWF_WEB_ROOT, $epath, $ename, $ename);
	}
	
	private static function fileToAnchor($name, $path, $bbcode)
	{
		if ($bbcode)
		{
			return sprintf('[url=%s%s]%s[/url]', GWF_WEB_ROOT, urlencode($path), $name);
		}
		$epath = htmlspecialchars($path);
		$ename = htmlspecialchars($name);
		return sprintf('<a href="%s%s" title="%s">%s</a>', GWF_WEB_ROOT, $epath, $ename, $ename);
	}
}
?>