<?php
/**
 * print HTTP-Headers
 * @author spaceone
 */
final class GWF_ShowHeaders extends GWF_Method
{
//	public function showEmbededHTML() { return false; }
//	public function getWrappingContent($content) { return $content; }

	public function getHTAccess()
	{
		return 'RewriteRule ^GWF/headers/?$ index.php?mo=GWF&me=ShowHeaders'.PHP_EOL;
	}

	public function execute()
	{
		$back = 'Request headers:<ul>'.PHP_EOL;
		
		foreach (apache_request_headers() as $key => $v)
		{
			$back .= sprintf('<li>%s: %s</li>'.PHP_EOL, htmlspecialchars($key), htmlspecialchars($v));
		}
		
		$back .= '</ul><br/><br/><ul>Response Headers:<ul>'.PHP_EOL;

		foreach (apache_response_headers() as $key => $v)
		{
			$back .= sprintf('<li>%s: %s</li>'.PHP_EOL, htmlspecialchars($key), htmlspecialchars($v));
		}

		$back .= '</ul>'.PHP_EOL;

		if (GWF_User::getStaticOrGuest()->isAdmin())
		{
			$back .= '<br/><br/>$_SERVER variables:<ul>';
			foreach ($_SERVER as $key => $v)
			{
				$back .= sprintf('<li>%s: %s</li>'.PHP_EOL, htmlspecialchars($key), htmlspecialchars($v));
			}
			$back .= '</ul>';
		}

		return $back;
	}
}
