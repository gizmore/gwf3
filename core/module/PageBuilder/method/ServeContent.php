<?php
/**
 * A wrapper for the dbimg/content folder.
 * This way you can upload .php without harm :D
 * @author gizmore
 */
final class PageBuilder_ServeContent extends GWF_Method
{
	public function execute()
	{
		if ('' === ($filename = Common::getGetString('filename')))
		{
			return GWF_Error::err('ERR_NO_PERMISSION');
		}
		
		$path = $this->module->getContentPath();
		$filename = $path.'/'.$filename; 
		
		if (!Common::isFile($filename))
		{
			return GWF_Error::err404($filename);
		}
		
		GWF_Upload::outputFile($filename);
	}
}
?>