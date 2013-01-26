<?php
/**
 * For Fancy Indexing.
 * @author spaceone
 * @author gizmore
 * @version 3.0
 * @see http://httpd.apache.org/docs/2.0/mod/mod_autoindex.html
 */
final class GWF_Fancy extends GWF_Method
{
	public function showEmbededHTML() { return true; }
	public function getWrappingContent($content) { return $content; }

	public function getHTAccess()
	{
		$ret = '';

		# The Fancy Options
		if (true === $this->module->cfgFancyIndex())
		{
			# TODO: can we check if AllowOverride is on? <-- THIS!
			# TODO: This check does not seem to work on WC5 server. 
			##### ?! (ONLY APACHE ANYWAY) ?! #####
// 			if (!GWF_ServerInfo::isApache()) return '';

			# The Fancy htaccess
			$ret .= '# Fancy Index'.PHP_EOL;
			$ret .= 'AddType text/html .php'.PHP_EOL; # Needed for fancy. No idea why.
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

			# The Fancy htaccess URLs
			$ret .= PHP_EOL.PHP_EOL;
			$ret .=
				'HeaderName /index.php?mo=GWF&me=Fancy&fancy=head&%{QUERY_STRING}'.PHP_EOL.
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
				return GWF3::onDisplayHead();
				
			case 'foot': 
				return GWF3::onDisplayFoot();
				
			default:
				return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'fancy'));
		}
	}
}
