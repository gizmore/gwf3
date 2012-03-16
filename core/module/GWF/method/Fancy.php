<?php
/**
 * For Fancy Indexing.
 * @author spaceone
 * @author gizmore
 * @see http://httpd.apache.org/docs/2.0/mod/mod_autoindex.html
 */
final class GWF_Fancy extends GWF_Method
{
	public function getHTAccess()
	{
		$ret = '';

		# The Fancy Options
		if (true === $this->module->cfgFancyIndex())
		{
			# TODO: This check does not seem to work on WC5 server.
// 			if (false === GWF_ServerInfo::isApache())
// 			{
// 				return '';
// 			}

			# PHP workability; please add to your vhosts if AllowOverride All is deactivated!
			# TODO: can we check if AllowOverride is on?

			# TODO: This rule breaks any server setup i have dealt with, so far.
			#     : Please make this optional and default disabled.
			$ret .= 'AddType text/html .php'.PHP_EOL;

			$ret .= '<Files "*.php">'.PHP_EOL;

			# TODO: This rule is completely bullocks, as x-httpd-php is not a fixed value but configureable in apache. Please remove. 
			$ret .= '    AddHandler application/x-httpd-php .php'.PHP_EOL.

			$ret .= '</Files>'.PHP_EOL.PHP_EOL;

			$ret .= '# Fancy Index'.PHP_EOL;
			$ret .= 'IndexOptions FancyIndexing'.PHP_EOL.
				'IndexOptions'.
				' NameWidth='.$this->module->cfgNameWidth(). 
				' DescriptionWidth='.$this->module->cfgDescriptionWidth().
				' IconHeight='.$this->module->cfgIconHeight().
				' IconWidth='.$this->module->cfgIconWidth().PHP_EOL;
			$ret .= 'IndexOptions ';
			$ret .= $this->module->cfgHTMLTable() ? 'HTMLTable ' : '';
			$ret .= $this->module->cfgIgnoreClient() ? 'IgnoreClient ' : '';
			$ret .= $this->module->cfgFoldersFirst() ? 'FoldersFirst ': '';
			$ret .= $this->module->cfgIgnoreCase() ? 'IgnoreCase ' : '';
			$ret .= $this->module->cfgSuppressHTMLPreamble() ? 'SuppressHTMLPreamble ' : '';
			$ret .= $this->module->cfgScanHTMLTitles() ? 'ScanHTMLTitles ' : '';
			$ret .= $this->module->cfgSuppressDescription() ? 'SuppressDescription ' : '';
			$ret .= $this->module->cfgSuppressRules() ? 'SuppressRules ' : '';
			$ret .= PHP_EOL.PHP_EOL;
			# The Fancy URLs
			$ret .=
				'RewriteCond %{QUERY_STRING} (.*)'.PHP_EOL.
				'HeaderName /index.php?mo=GWF&me=Fancy&fancy=head&%1'.PHP_EOL.
				'ReadmeName /index.php?mo=GWF&me=Fancy&fancy=foot'.PHP_EOL;
		}
		return $ret.PHP_EOL;
	}
	
	public function execute()
	{
		switch(substr(Common::getGetString('fancy'), 0, 4))
		{
			case 'head': 
				GWF_Website::addCSS(sprintf('/tpl/%s/css/fancy.css', GWF3::getDesign()));
				die(GWF3::onDisplayHead());
				
			case 'foot': 
				die(GWF3::onDisplayFoot());
				
			default:
				die(GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'fancy')));
		}
	}	
}
?>
