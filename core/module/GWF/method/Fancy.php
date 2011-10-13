<?php
/**
 * For Fancy Indexing.
 * @author spaceone,gizmore
 * @see http://httpd.apache.org/docs/2.0/mod/mod_autoindex.html
 */
final class GWF_Fancy extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		$module instanceof Module_GWF;
		
		# PHP workability; please add to your vhosts if AllowOverride All is deactivated!
		$ret = '';
		$ret .=
			'AddType text/html .php'.PHP_EOL;
//			'<Files "*.php">'.PHP_EOL.
//			'    AddHandler application/x-httpd-php .php'.PHP_EOL.
//			'</Files>'.PHP_EOL.PHP_EOL;
		
		# The Fancy Options
		if ($module->cfgFancyIndex())
		{
			$ret .= '# Fancy Index'.PHP_EOL;
			$ret .= 'IndexOptions FancyIndexing'.PHP_EOL.
				'IndexOptions'.
				' NameWidth='.$module->cfgNameWidth(). 
				' DescriptionWidth='.$module->cfgDescriptionWidth().
				' IconHeight='.$module->cfgIconHeight().
				' IconWidth='.$module->cfgIconWidth().PHP_EOL;
			$ret .= 'IndexOptions ';
			$ret .= $module->cfgHTMLTable() ? 'HTMLTable ' : '';
			$ret .= $module->cfgIgnoreClient() ? 'IgnoreClient ' : '';
			$ret .= $module->cfgFoldersFirst() ? 'FoldersFirst ': '';
			$ret .= $module->cfgIgnoreCase() ? 'IgnoreCase ' : '';
			$ret .= $module->cfgSuppressHTMLPreamble() ? 'SuppressHTMLPreamble ' : '';
			$ret .= $module->cfgScanHTMLTitles() ? 'ScanHTMLTitles ' : '';
			$ret .= $module->cfgSuppressDescription() ? 'SuppressDescription ' : '';
			$ret .= $module->cfgSuppressRules() ? 'SuppressRules ' : '';
			$ret .= PHP_EOL.PHP_EOL;
			# The Fancy URLs
			$ret .=
				'RewriteCond %{QUERY_STRING} (.*)'.PHP_EOL.
				'HeaderName /index.php?mo=GWF&me=Fancy&fancy=head&%1'.PHP_EOL.
				'ReadmeName /index.php?mo=GWF&me=Fancy&fancy=foot'.PHP_EOL;
		}
		return $ret.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
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
