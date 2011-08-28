<?php
final class Shoutbox_Moderate extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false === ($entry = GWF_Shoutbox::getByID(Common::getGetString('shoutid'))))
		{
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'shoutid'));
		}
		
		if ($entry->getHashcode() !== Common::getGetString('token'))
		{
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'token'));
		}
		
		if (false === $entry->delete())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $module->message('msg_deleted');
	}
}
?>