<?php
/**
 * For Fancy Indexing.
 * @author spaceone,gizmore
 * @see http://httpd.apache.org/docs/2.0/mod/mod_autoindex.html
 */
final class GWF_Fancy extends GWF_Method
{
	public function getHTAccess()
	{
		$ret = '';

		# The Fancy Options
		if (true === $this->_module->cfgFancyIndex())
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
				' NameWidth='.$this->_module->cfgNameWidth(). 
				' DescriptionWidth='.$this->_module->cfgDescriptionWidth().
				' IconHeight='.$this->_module->cfgIconHeight().
				' IconWidth='.$this->_module->cfgIconWidth().PHP_EOL;
			$ret .= 'IndexOptions ';
			$ret .= $this->_module->cfgHTMLTable() ? 'HTMLTable ' : '';
			$ret .= $this->_module->cfgIgnoreClient() ? 'IgnoreClient ' : '';
			$ret .= $this->_module->cfgFoldersFirst() ? 'FoldersFirst ': '';
			$ret .= $this->_module->cfgIgnoreCase() ? 'IgnoreCase ' : '';
			$ret .= $this->_module->cfgSuppressHTMLPreamble() ? 'SuppressHTMLPreamble ' : '';
			$ret .= $this->_module->cfgScanHTMLTitles() ? 'ScanHTMLTitles ' : '';
			$ret .= $this->_module->cfgSuppressDescription() ? 'SuppressDescription ' : '';
			$ret .= $this->_module->cfgSuppressRules() ? 'SuppressRules ' : '';
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
