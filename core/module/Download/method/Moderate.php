<?php
/**
 * Download moderation by email.
 * @author gizmore
 */
final class Download_Moderate extends GWF_Method
{
	public function execute()
	{
		if (false === ($dl = GWF_Download::getByID(Common::getGetString('dlid'))))
		{
			return $this->_module->error('err_dlid');
		}
		
		if ($dl->getHashcode() !== Common::getGetString('token'))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		switch (Common::getGetString('action'))
		{
			case 'allow': return $this->onAllow($this->_module, $dl);
			case 'delete': return $this->onDelete($this->_module, $dl);
			case 'download': return $this->onDownload($this->_module, $dl);
		}
		
		return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'action'));
	}
	
	private function onAllow(Module_Download $module, GWF_Download $dl)
	{
		if (false === $dl->saveOption(GWF_Download::ENABLED, true))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return $this->_module->message('msg_enabled');
	}

	private function onDelete(Module_Download $module, GWF_Download $dl)
	{
		if (false === $dl->getVotes()->onDelete())
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		if (false === $dl->delete())
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return $this->_module->message('msg_deleted');
	}

	private function onDownload(Module_Download $module, GWF_Download $dl)
	{
		if (false === ($method = $this->_module->getMethod('Download')))
		{
			return GWF_HTML::err('ERR_METHOD_MISSING', array('Download', 'Download'));
		}
		$method instanceof Download_Download;
		$method->sendTheFile($this->_module, $dl);
	}
}
?>