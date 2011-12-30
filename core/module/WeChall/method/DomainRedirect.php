<?php
final class WeChall_DomainRedirect extends GWF_Method
{
	public function getHTAccess(GWF_Module $modoule)
	{
		return
			'# Domain Redirection'.PHP_EOL.PHP_EOL.
			'RewriteCond %{HTTP_HOST} ^.*wechall.com'.PHP_EOL.
			'RewriteRule (.*) http://www.wechall.net/$1 [R=301,L]'.PHP_EOL.
			PHP_EOL.
			'RewriteCond %{HTTPS} ^on$'.PHP_EOL.
			'RewriteCond %{HTTP_HOST} ^wechall.'.PHP_EOL.
			'RewriteRule (.*) https://www.wechall.net/$1 [R=301,L]'.PHP_EOL.
			PHP_EOL.
			'RewriteCond %{HTTP_HOST} ^wechall.'.PHP_EOL.
			'RewriteRule (.*) http://www.wechall.net/$1 [R=301,L]'.PHP_EOL;
	}
	
	public function execute(GWF_Module $modoule)
	{
	}
	
}
?>
