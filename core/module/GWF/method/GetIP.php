<?php
/**
 * Get IP-Address in a various formats
 * @author spaceone
 * @see GWF_IP6
 */
final class GWF_GetIP extends GWF_Method
{
	public function showEmbededHTML() { return true; }
	public function getWrappingContent($content) { return $content; }

	public function execute()
	{
		return $_SERVER['REMOTE_ADDR'];
		$ip = Common::getGetString('ip', false);
		$type = Common::getGetString('type', GWF_IP6::INT_32);

		return GWF_IP6::getIP($type, $ip);
	}
}
